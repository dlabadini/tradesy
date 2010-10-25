<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* All manipulations of Shopping Cart data.
*
* As of build 1896, all shipping and handling is treated as a total and presented as
* a seperate line item on the invoice. No shipping and/or handling costs are to be
* used on a per line-item bases.
*
* @version $Revision: 2731 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

define('SEP', 'v');

class ShoppingCart {
	/* data structure:
	 * $Prods[cartid] = array('name'=>..., 'price'=>..., 'options'=>...   etc)
	 *    options are stored as a string with option values that can be exploded for searching
	 * Products that differ in options are added as different products, to this end
	 *    a sequence number is added to the id, e.g.   12  12-1    12-2 ...
	 * Products must exist before any of the modify functions do something.
	 * Products that already exist can not be added, only modified and deleted.
	 *
	 * Notes:
	 * 	  $cartid is a string and the template sometimes adds spaces - use TRIM!
	 */
	var $Prods = array();		// persistent buffer with product data and extraShippingCosts index
	var $owner;					// owner of this object
	var $lock = false;			// prevents changes to the cart
	var $taxrates = false;		// hash with rate_name => %
	var $xtrShippingId = -1;	// is the id in the extrashipping array (not the index)
	var $taxLocationId = '-1';	// where is the buyer located

	function ShoppingCart ( $owner, $emptyCart = false ) {

		$this->owner =& $owner;

		// restore from session if present
		if( ! $emptyCart && isset( $_SESSION['CartData'] ) ) {

			$this->Prods = unserialize( $_SESSION['CartData'] );

			if( isset( $_SESSION['Shipping'] ) )
				$this->setExtraShippingType( $_SESSION['Shipping'] );

			if( isset( $_SESSION['TaxLocation'] ) )
				$this->taxLocationId = $_SESSION['TaxLocation'];
		}
		else
		{
			$this->setTaxLocationId();
			$this->setExtraShippingType();
		}
	}

 /*****************************  CART METHODS  *****************************/

	// return the cartid on success or '' on failure
	function addProduct ( $id, $name, $descr, $price, $units, $group, $options,
						  $tax = '', $shipping = 0, $handling = 0 ) {

		if( $this->lock ) return '';

		// from a group screen, options may be set to '-1' as undefined,
		// these must be translated to the first default option (if it exists)
		if ($options != '') {
			$sel = explode(',', $options);
			$opts =& $this->owner->products[$group][$id]['options'];

			for( $i = 0; $i < count($sel); $i++ ) {
		 		if ($sel[$i] == -1 && count($opts[$i]['items']) > 0 ) {
					$sel[$i] = $opts[$i]['items'][0]['value'];
				}
			}
			$options = implode(',', $sel);
		}

		if( $this->getProdKey( $id, $group, $options, $key ) ) {
			// update quantity if product+options is already in basket
			$this->Prods[$key]['qty'] += $units;
		} else {
			$this->Prods[$key] = array(
				'id' => $id,
				'name' => $name,
				'descr' => $descr,
				'price' => $price,
				'qty' => $units,
				'groupid' => $group,
				'taxname' => $tax,					// this is the key for the taxrates array
				'handling' => $handling,
				'shipping' => $shipping,
				'options' => $options );
		}

		return $key;
	}


	// find products with the same id AND same options string
	// return true if found and always return a usable key (existing or new )
	function getProdKey ( $id, $group, $options, &$cartid ) {

		$unique = $id . '_' . $group;

		if( !isset($this->Prods[$unique]) ) {
			// this product_group is not yet in the cart
			$cartid = $unique;
			return false;
		}


		// product_group is in the cart, check the options
		foreach ($this->Prods as $k => $v) {

			if( $v['id'] == $id && $v['groupid'] == $group && $v['options'] == $options ) {
				// this product_group + options is already in the cart
				$cartid = $k;
				return true;
			} else {
				// extract last used sequence number
				$pos = strpos($k, SEP);
				$seq = ($pos === false ? 0 : substr($k, $pos + 1) );
			}
		}

		// not found, make new key, use letter for javascript compatability
		$cartid = $unique . SEP . ($seq + 1);
		return false;
	}


  	function removeProduct ( &$cartid ) {

		if( $this->lock ) return false;

		$cartid = trim($cartid);

		if( isset($this->Prods[$cartid]) ) {
			unset($this->Prods[$cartid]);
			return true;
		}
		return false;
   	}


  	function emptyCart ( $ignoreLock = false ) {

  		if( $this->lock && !$ignoreLock) return false;

		$this->Prods = array();
		unset($_SESSION['CartData']);
  	}


	function saveCart ( ) {
		$_SESSION['CartData'] = serialize( $this->Prods );
		$_SESSION['Shipping'] = $this->getExtraShippingId();
		$_SESSION['TaxLocation'] = $this->taxLocationId;
	}


	// export all cart data as a structure that has no dependencies on data.php
	// include the original values so the cart lines can be restore (future function?)
	function exportCart ( ) {
		$export =  array(
			'timestamp' => time(),
			'currency' => $this->owner->getConfig('shopcurrency'),
			'grandtotal' => $this->getGrandTotalCart(),
			'handling' => $this->getTotalHandling(),
			'shipping' => $this->getTotalShipping(),
			'tax' => $this->getTotalTax(),
			'extrashippingdescr' => $this->owner->extrashipping[ $this->getExtraShippingIndex() ]['description'],
			'lines' => array()
			);

		// remove dependencies on data.php
		foreach( $this->Prods as $cid => $line ) {
			$export['lines'] [ $cid ] = array(
				'id' => $line['id'],
				'name' => $line['name'],
				'descr' => $line['descr'],
				'price' => $line['price'],
				'qty' => $line['qty'],
				'subtotal' => $this->getSubtotalPriceProduct( $cid ),
				'groupid' => $line['groupid'],
				'taxname' => $line['taxname'],								// dependent
				'taxperc' => $this->lookupTaxPerc( $line['taxname'] ),		// independent
				'handling' => $line['handling'],
				'shipping' => $line['shipping'],
				'options' => $line['options'],								// dependent
				'optionstext' => $this->getOptionsAsText ( $cid )			// independent
			 );
		}

		$export['linecount'] = $this->getNumberOfArticles();
		return $export;
	}

 /*****************************  NAME & DESCR  *****************************/

 	function existsProduct ( $cid ) {
		return isset( $this->Prods[$cid] );
	}


	function getName ( $cartid ) {
		if( !isset($this->Prods[$cartid]) )	return '';
		return $this->Prods[$cartid]['name'];
	}


	function getDescr ( $cartid ) {
		if( !isset($this->Prods[$cartid]) )	return '';
		return $this->Prods[$cartid]['descr'];
	}


	// return product id as in data.php ( != cart id)
	function getId ( $cid ) {
		if( !isset($this->Prods[$cid]) )	return -1;
		return $this->Prods[$cid]['id'];
	}


	function getGroupId ( $cid ) {
		if( !isset($this->Prods[$cid]) )	return -1;
		return $this->Prods[$cid]['groupid'];
 	}


 	function setGroupId ( $cid, $groupId ) {
		if( isset($this->Prods[$cid]) ) {
       		$this->Prods[$cid]['groupid'] = $groupId;
  		}
  	}

  	function getProductProperty( $cid, $property ) {
  		if( isset($this->owner->products[$this->getGroupId($cid)]) &&
  			isset($this->owner->products[$this->getGroupId($cid)][$this->getId($cid)][$property]) )
  			return $this->owner->products[$this->getGroupId($cid)][$this->getId($cid)][$property];
  		else
  			return '';
  	}

 /*****************************  OPTIONS  *****************************/


  	// see comment at top of file for $options expected format
 	function setOptionsOfProduct ( &$cartid, $options ) {

		if( $this->lock ) false;

		$cartid = trim($cartid);			// important: template adds spaces!

		if( isset( $this->Prods[$cartid] ) ) {
			$this->Prods[$cartid]['options'] = $options;
			return true;
		} else
			return false;
  	}


	function hasOptions ( $cartid ) {

		$cartid = trim($cartid);			// important: template adds spaces!

		if( !isset($this->Prods[$cartid]) ||
			$this->Prods[$cartid]['options'] == '' ) {
			return false;
		} else {
			return true;
		}
	}


	function getOptions ( $cartid ) {

		$cartid = trim($cartid);			// important: template adds spaces!

		if( !isset($this->Prods[$cartid]) )	return '';

		return $this->Prods[$cartid]['options'];
	}


	function getOptionsAsText ( $cartid, $prefix = '' ) {

		// find the product and it's options
		$prdid = $this->getId( $cartid );
		$grpid = $this->getGroupId( $cartid );
		$options =& $this->owner->products[$grpid][$prdid]['options'];
		#echo "Cart ID: $cartid, Group ID: $grpid, Product ID: $prdid"; print_r($options);

		if( !$this->hasOptions( $cartid ) || empty( $options ) ) return '';
		$sel = explode(',', $this->getOptions( $cartid ) );
		$text = '';

		for( $i = 0; $i < count($sel); $i++ ) {
			// if nothing selected AND options defined, then show first option as default
			if( $sel[$i] == -1 && count( $options[$i]['items'] ) > 0 ) {
				$sel[$i] = $options[$i]['items'][0]['value'];
			}
			foreach( $options[$i]['items'] as $item ) {
				if( $item['value'] == $sel[$i] ) {
					$text .= ($text != '' ? ', ' : '') . $item['label'];
					break;
				}
			}
		}
		return strlen( $text ) == 0 ? '' : $prefix . $text;
	}


 /*****************************  PRICE & QUANTITY  *****************************/

  	function setUnitsOfProduct ( &$cartid, $units ) {

 		$cartid = trim($cartid);			// important: template adds spaces!

 		if( $this->lock ) false;

		if( isset($this->Prods[$cartid]) ) {
			$this->Prods[$cartid]['qty'] = $units;
			return true;
		} else
			return false;
  	}


	function getUnitsOfProduct ( &$cartid ) {

		$cartid = trim($cartid);			// important: template adds spaces!

		if( !isset($this->Prods[$cartid]) ||
		 	!isset($this->Prods[$cartid]['qty']) ) return 0;

 		return $this->Prods[$cartid]['qty'];
	}


	function getPrice ( $cid ) {
		if( !isset($this->Prods[$cid]) ) return 0;

		return $this->Prods[$cid]['price'];
 	}


	// returns price * qty per cart-id
 	function getSubtotalPriceProduct ( $cid ) {

		if( !isset($this->Prods[$cid]) ) return 0;
		#echo "ID: $id, QTY: {$this->Prods[$cid]['qty']}, Price: {$this->Prods[$cid]['price']}";

		return $this->Prods[$cid]['qty'] * $this->Prods[$cid]['price'];
	}


	// amount with (normal) shipping, handling and tax
	function getTotalPriceProduct ( $cid ) {

		if( !isset($this->Prods[$cid]) )	return 0;

		$price = 0;
		$price += $this->Prods[$cid]['price'];
		$price += $this->Prods[$cid]['shipping'];
		$price += $this->Prods[$cid]['handling'];
		$price *= $this->Prods[$cid]['qty'];

		return $price + $this->getTaxAmountProduct($cid);
	}


 /*****************************  TAXES  *****************************/

	function setTaxLocationId ( $id = -1 ) {

		if( $id != -1 )	{
			$this->taxLocationId = $id;
			return;
		}

		// set this to the first tax location id if it exists
		$loc = $this->owner->getTaxLocations();
		if( count( $loc ) > 0 )
			$this->taxLocationId = key( $loc );
	}


	function getTaxLocationId ( ) {
		return $this->taxLocationId;
	}


	function setTaxProduct ( $cid, $tax ) {
		if( $this->lock ) return;

		if( isset($this->Prods[$cid]) ) {
			$this->Prods[$cid]['taxname'] = $tax;
		}
 	}


 	// return product tax rate names as an array for the selected location or only true
 	function lookupProductTaxRates ( $returnKeys = false ) {

 		if( ! $this->taxrates )
			// do not use =& because it breaks some php4 servers
 			$this->taxrates = $this->owner->getConfig('TaxRates');

 		if( isset( $this->taxrates['Product'] ) &&
 			isset( $this->taxrates['Product'][$this->taxLocationId] ) )
 		{

 			return $returnKeys ? array_keys( $this->taxrates['Product'][$this->taxLocationId] ) : true;
 		}
		return false;
 	}


 	// return % in decimal form, i.e. 1% -> 0.01
 	function lookupTaxPerc ( $rate_name ) {

 		if( $this->lookupProductTaxRates() &&
 		    isset( $this->taxrates['Product'][$this->taxLocationId][$rate_name] ) )
 		{
 			$div = pow( 10, $this->taxrates['Product'][$this->taxLocationId][$rate_name]['decimalsnumber'] + 2 );
 			return $this->taxrates['Product'][$this->taxLocationId][$rate_name]['amount'] / $div ;
 		}
		return 0;
 	}


// QUESTION: Is this still used?
 	// return % in decimal form, i.e. 1% -> 0.01
 	function lookupTaxPercSpecial ( $subject ) {

 		if( ! $this->taxrates )
			// do not use =& because it breaks some php4 servers
 			$this->taxrates = $this->owner->getConfig('TaxRates');

 		if( isset( $this->taxrates[$subject] ) &&
 			isset( $this->taxrates[$subject][$this->taxLocationId] ) )
 		{
 			$div = pow( 10, $this->taxrates[$subject][$this->taxLocationId]['decimalsnumber'] + 2 );
 			return $this->taxrates[$subject][$this->taxLocationId]['amount'] / $div ;
 		}
		return 0;
 	}

	// return 0.0 if no shipping tax value found
 	function lookupTaxPercShipping ( ) {

 		if( $this->lookupProductTaxRates() &&
 		    isset( $this->taxrates['Shipping'] ) &&
 		    isset( $this->taxrates['Shipping'][$this->taxLocationId] ) )
 		{
 			$div = pow( 10, $this->taxrates['Shipping'][$this->taxLocationId]['decimalsnumber'] + 2 );
 			return $this->taxrates['Shipping'][$this->taxLocationId]['amount'] / $div;
 		}

		return 0.0;
 	}


	// return the name of the tax rate for a product
 	function getTaxRateName ( $cid ) {

		if( !isset($this->Prods[$cid]) ) return '';

		return $this->Prods[$cid]['taxname'];
	}


	// tax amount for 1 product rounded to cents
 	function getTaxAmountProduct ( $cid ) {

		if( !isset($this->Prods[$cid]) ) {
			return 0;
		}

		$tax = 0;
		$prod_prc = $this->lookupTaxPerc( $this->Prods[$cid]['taxname'] );

		$shippingtax = $this->lookupTaxPercShipping();

		if( $shippingtax ) {

			$tax += round( $shippingtax * $this->Prods[$cid]['handling'] );
			$tax += round( $shippingtax * $this->Prods[$cid]['shipping'] );
		}
		// tax on product only is also used when type is not defined (-1)
		$tax += round( $prod_prc * $this->Prods[$cid]['price'] );

		return $tax;
	}


	// tax amount on extra shipping, only has a value != 0 if $config['TaxRates']['Shipping']
	// exists for the location that the buyer is in.
 	function getTaxAmountExtraShipping ( ) {

		return $this->lookupTaxPercShipping() * $this->getShippingHandlingTotal();
	}


 	function hasTaxAmountProduct ( $cid ) {

		if( !isset( $this->Prods[$cid] ) )	return false;

		return $this->lookupTaxPerc( $this->Prods[$cid]['taxname'] ) * $this->Prods[$cid]['price'] != 0.0;
	}


	// tax amount for a product * qty rounded to cents
	function getTotalTaxAmountProduct ( $cid ) {

		if( !isset( $this->Prods[$cid] ) )	return 0;

		return $this->getTaxAmountProduct ( $cid ) * $this->getUnitsOfProduct($cid);
	}


	// tax of all products together
 	function getTotalTax ( ) {

 		if( empty( $this->Prods ) ) return 0;

 		$amount = 0;

	 	foreach( $this->Prods as $cid => $value) {
   			$amount += $this->getTotalTaxAmountProduct( $cid );
 		}
		
		$amount += $this->getTaxAmountExtraShipping();
		
		return $amount;
  	}


 /*****************************  SHIPPING  *****************************/

	function setExtraShippingType ( $id = -1 ) {

		if( $id != -1 )	{
			// set as the user chooses
			$this->xtrShippingId = $id;
			return;
		} else if( $this->xtrShippingId != -1 ) {
			// default is already set
			return;
		}

		// set the default extra shipping like this:
		// 		find item with type '-1'
		//		if property show=true then that item is selected
		//		else the next property is selected by default
		if( isset( $this->owner->extrashipping) &&
			is_array( $this->owner->extrashipping ) )
		{
			foreach( $this->owner->extrashipping as $es ) {

				if( $es['type'] == '-1' ) {
					if( $es['show'] ) {
						$this->xtrShippingId = (int)$es['id'];
						return;
					} else {
						break;
					}
				}
			}

			// we are here because type -1 is not visible, find the first item with type != -1
			foreach( $this->owner->extrashipping as $es ) {

				if( $es['type'] != '-1' && $es['show'] ) {
					$this->xtrShippingId = (int)$es['id'];
					return;
				}
			}

		}

		// this means no array found or no suitable item found in array
		$this->xtrShippingId = false;
	}


	// return false if not set
	function getExtraShippingId ( ) {
		return $this->xtrShippingId;
	}


	// doesn't include extra shipping costs
	function setShippingProduct ( $cid, $shipping ) {

		if( $this->lock ) return;

		if( isset($this->Prods[$cid]) ) {
			$this->Prods[$cid]['shipping'] = $shipping;
		}
 	}


	// doesn't include extra shipping costs
 	function getShippingProduct ( $cid ) {

		if( !isset($this->Prods[$cid]) ||
			!isset($this->Prods[$cid]['shipping']) )
			return 0;

		return $this->Prods[$cid]['shipping'];
 	}


	// doesn't include extra shipping costs
 	function getShippingProducts ( ) {

		$amount = 0;
		$cids = array_keys( $this->Prods );
  		foreach( $cids as $cid ) {
  			$amount += $this->getShippingProduct( $cid ) * $this->getUnitsOfProduct( $cid );
 		}
		return $amount;
 	}


 	// data is found in the $extrashipping array as the item with type = -1
	function getDefaultShippingAmount ( ) {

		if( isset( $this->owner->extrashipping) &&
			is_array( $this->owner->extrashipping ) )
		{
			foreach( $this->owner->extrashipping as $es ) {
				if( $es['type'] == '-1' ) return $es['amount'];
			}
		}

		return 0;
	}


	// return false if not found, parameters are not touched in that case
	function getShippingData ( $id, &$amount, &$isShown, &$type ) {

		if( isset( $this->owner->extrashipping) &&
			is_array( $this->owner->extrashipping ) )
		{
			foreach( $this->owner->extrashipping as $es ) {

				if( $id == (int)$es['id'] ) {
					$type = $es['type'];
					$isShown = $es['show'];
					$amount = $es['amount'];
					return true;
				}
			}
		}

		return false;
	}


 	/* Shipping & Handling costs for all products together:
 	 *  - Total is always: shipping_prod + handling_prod + minimim_charge + extra_charge
 	 *
  	 *  How to treat the number in $extrashipping array when type is:
	 *		-1 -> 0,
	 * 	 0 -> As a fixed amount,
	 *		 1 -> As a % over shipping&handling,
	 *		 2 -> As a fixed amount * number of individual products (not line items)
	 *		 3 -> As a % over shipping&handling * number of individual products (not line items)
	 *		 4 -> Fixed_Amount + ( Shipping_Product1 + Shipping_Product2 ) * Percentage_Rate
	 *
  	 * If no $method is specifies, the actual extra-costs are return
  	 * else other costs can be calculated, e.g. to pass on to Google Checkout.
  	 */
 	function getShippingHandlingTotal ( $method = false ) {

 		if( empty($this->Prods) )
 			return 0;

 		if( $method === false ) {
			$method = $this->getExtraShippingId ( );
 		}

		$amount = $this->getShippingProducts() +
				  $this->getHandlingProducts() +
				  $this->getDefaultShippingAmount();

 		if ( $method === false ) {
			return $amount;
 		} else {
 			$extra_amount = 0;
			$extra_type = -1;
			$dummy = 0;
			$this->getShippingData( $method, $extra_amount, $dummy, $extra_type );
		}

		switch( (int) $extra_type ) {
		case -1:
			// already added
			break;

	  	case 0:
	  		$amount += $extra_amount;
	  		break;

 		case 1:
	  		$amount += $amount * $extra_amount / 10000;
			break;

		case 2:
			$amount += $this->getNumberOfProducts() * $extra_amount;
	  		break;

		case 3:
	  		$amount +=  $amount * $this->getNumberOfProducts() * $extra_amount / 10000;
	  		break;

		case 4:
	  		$amount += ( $this->getShippingProducts() + $this->getHandlingProducts() ) * $extra_amount / 10000;
	  		break;
 		}

		return $amount;
 	}


 /*****************************  HANDLING  *****************************/

	function setHandlingProduct ($cid, $handling ) {

		if( $this->lock ) return;

		if( isset($this->Prods[$cid]) ) {
			$this->Prods[$cid]['handling'] = $handling;
		}
 	}

	// amount for 1 product
 	function getHandlingProduct ( $cid ) {
		if( !isset($this->Prods[$cid]) ||
			!isset($this->Prods[$cid]['handling']) ) return 0;
		return $this->Prods[$cid]['handling'];
 	}


	// amount for product * qty * all articles in cart
	function getHandlingProducts ( ) {
  		if( empty($this->Prods) )
  			return 0;

  		$amount = 0;
		foreach( $this->Prods as $cid => $value ) {
			$amount += $this->getHandlingProduct( $cid ) * $this->getUnitsOfProduct( $cid );
 		}
		return $amount;
 	}


 /*****************************  COUNTERS & TOTALS  *****************************/

	// # of products = # of articles * quantity of each article
	// if group and product id's are defines:
	// 		# of articles * quantity of each article with groupid and productid
	//		articles with different options are considered the same product!
	function getNumberOfProducts (  $groupid = -1, $productid = -1) {
		$n = 0;
	 	foreach( $this->Prods as $p ) {
    		if( ( $groupid < 0 && $productid < 0 ) ||
    			( $p['groupid'] == $groupid && $p['id'] == $productid ) )
    		{
	 			$n += $p['qty'];
    		}
  		}
		return $n;
	}

	// products with different options are considered different products
	function getNumberOfOptionProducts ( $groupid, $productid, $options ) {
	 	foreach( $this->Prods as $p ) {
    		if( $p['groupid'] == $groupid &&
    			$p['id'] == $productid &&+
				// Check in case it is the default option maybe also exists
    			($p['options'] == $options || -1 == $options) ) {
	 			return $p['qty'];
    		}
  		}
		return 0;
	}


	// articles corresponds to number of different products (= cart lines)
	function getNumberOfLineItems ( ) {
  		return count($this->Prods);
 	}


 	// amount without shipping, handling and tax
	function getSubtotalPriceCart ( ) {

  		if( empty($this->Prods) ) return 0;
  		$amount = 0;

	 	foreach( $this->Prods as $p ) {
   			$amount += $p['price'] * $p['qty'];
 		}

		return $amount;
   	}


 	// amount with shipping, handling and tax in cents
   	function getGrandTotalCart ( ) {

  		if( empty($this->Prods) ) return 0;

		$amount = 0;
	 	foreach( $this->Prods as $cid => $value ) {
   			$amount += $this->getSubtotalPriceProduct( $cid );
 		}

 		$amount += $this->getShippingHandlingTotal() + $this->getTotalTax();

		return $amount;
   	}


 /*****************************  USED BY TEMPLATES  *****************************/


	function getPairProductIdGroupId ( ) {
		if( empty($this->Prods) ) return array();

		$temp= array();
		foreach( $this->Prods as $k => $v ) {
			$temp[] = array( 'cartid' => $k, 'productid' => $v['id'], 'groupid' => $v['groupid']);
    	}
		return $temp;
 	}

}
?>
