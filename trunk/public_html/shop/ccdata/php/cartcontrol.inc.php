<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Use as include file
* Adds static functions for adding and removing products to the cart.
*
* @version $Revision: 2582 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

// A cartid other then '' means an item already in the cart should be updated.
// return the cartid of the modified item.
function cart_add ( &$cartid ) {

	global $myPage;

	$msg = false;
	// some input validation
	$cartid = ''; $productid = ''; $groupid = ''; $quantity = '';
	$num = extract($_POST, EXTR_IF_EXISTS);

	if( !is_numeric($productid) ||
		!is_numeric($groupid) ||
		$num < 2)
	{
		$msg = _T("Missing Product or Group information in request to the Shopping Cart.");
		return $msg;
	}

	
	// get the option values, $optionstring must be a comma seperated list of values
	$optionstring = '';
		$prod =& $myPage->products[$groupid][$productid];
		
	for ( $i = 0; $i < count($prod['options']); ++$i ) {				// loop as many times as there are option fields
		$key = 'opt_' . $i;
		if( isset($_POST[$key]) ) {
			$optionstring .= $_POST[$key] . ',';
		} else {
			$optionstring .= '-1,';				// default
		}
	}
	$optionstring = rtrim($optionstring, ',');

	// after this test, we may assume $quantity is a valid number
	if( ($msg = cart_testQuantity($quantity, $groupid, $productid, true, $optionstring)) != '' )
	{
		return $msg;
	}

	if( $cartid != '' ) {

		// update existing cart entry
		$myPage->cart->setUnitsOfProduct($cartid, $quantity);
		$myPage->cart->setOptionsOfProduct($cartid, $optionstring);

	} else {

		// get unformatted product data (money in int format)
		$prod =& $myPage->products[$groupid][$productid];
		
		$cartid = $myPage->cart->addProduct( $productid, $prod['name'], $prod['shortdescription'], $prod['yourprice'],
							 			   $quantity, $groupid, $optionstring,
							 			   $prod['tax'], $prod['shipping'], $prod['handling']);
	}

	// after updating the cart, we must reset any pending authorisation with PayPal or
	// checkout won't work

	return $msg;
}


// Update quantities and return array of updated cartid's
function cart_update ( &$cartids ) {

	global $myPage;

	$msg = false;

	// input validation
	if( ! isset( $_POST['extrashipping'] ) && ! isset( $_POST['taxlocation'] ) &&
		( ! isset( $_POST['qty'] ) || ! is_array( $_POST['qty'] ) || empty( $_POST['qty'] ) ) ) {
		// nothing to do
		$msg = _T("Cart is up to date.");
		return $msg;
	}

	if( isset( $_POST['qty'] ) && is_array( $_POST['qty'] ) && ! empty( $_POST['qty'] ) ) {
		foreach ( $_POST['qty'] as $cid => $qty ) {

			// after this test, we may assume $quantity is a valid number
			$productid = $myPage->cart->getId($cid);
			$groupid = $myPage->cart->getGroupId($cid);
			if( ($msg = cart_testQuantity($qty, $groupid, $productid, false)) != '' )
			{
				$msg = $myPage->cart->getName($cid) . ':<br/>' . $msg;
				break;
			}

			if ( is_numeric($qty) && $myPage->cart->setUnitsOfProduct($cid, $qty) ) {
				$cartids[] = $cid;
			} else {
				$msg = _T("Can not update a product that is not found in the cart or a quantity that is not a number.");
				break;
			}
		}

		if( count($cartids) == 0 && $msg == '')
			$msg = _T("No products in the cart were updated.");
	}

	if( isset( $_POST['extrashipping'] ) ) {
		$myPage->cart->setExtraShippingType( $_POST['extrashipping'] );
	}

	if( isset($_POST['taxlocation']) ) {
		$myPage->cart->setTaxLocationId( $_POST['taxlocation'] );
	}

	return $msg;
}


// return array of cartids removed
function cart_remove (  &$cartids ) {

	global $myPage;

	$msg = false;
	$cartid = '';

	// input validation
	if( !is_array($_POST['delete']) || empty($_POST['delete']) ) {
		// nothing to do
		$msg = _T("No products in cart could be deleted.");
		return $msg;
	}

	// data structure is like this: [delete] => Array( [ 0 ] => Delete )
	// in which the array-key is the cartid we need (watch out for spaces!)
	$cids = array_keys($_POST['delete']);

	foreach( $cids as $cid ) {

		if( $myPage->cart->removeProduct($cid) ) {
			$cartids[] = $cid;
		}
	}

	if( count($cids) != count($cartids) ) {
		$msg = _T("Could not remove all items from cart.");
	}

	return $msg;
}


/* Test if $quantity contains a valid value or return default if input $quantity =''
 * Return value is '' on success or a descriptive error message on failure
 *
 *  There are 3 'typequantity' conditions:
 *		'choose_quantity' 	- any number will do
 * 		'default_quantity' 	- only the default is allowed
 * 		'range_quantity'	- number must be in range
 *
 *  Behavior in case $quantity = '' or -1:
 * 		'choose_quantity' 	- +1
 * 		'default_quantity' 	- +dft if not yet in cart
 * 		'range_quantity'	- +1   if still possible
 *
 *  Quantities must be tested against what is already in the cart!
 */
function cart_testQuantity ( &$quantity, $groupid, $productid, $includeCart = true, $optionstring = '' ) {

global $myPage;

	if( !isset($myPage->products[$groupid]) || !isset($myPage->products[$groupid][$productid]) ) {
		return _T('Could not find product data.');
	}

	if( $includeCart )
		$inCart = $myPage->cart->getNumberOfOptionProducts($groupid, $productid, $optionstring);
	else
		$inCart = 0;

	// first deal with the situation when no quantity is defined
	if( $quantity == '' || $quantity == '-1' ) {

		switch ( $myPage->products[$groupid][$productid]['typequantity'] ) {

		case 'default_quantity':
		
			if( $inCart < $myPage->products[$groupid][$productid]['defaultquantity'] )
			{
				$quantity = (int)$myPage->products[$groupid][$productid]['defaultquantity'];	
			}
			else
			{
				$quantity = -1;
			}
				
			break;

		case 'choose_quantity':
			$quantity = 1;
			break;

		case 'range_quantity':
			if( $inCart < $myPage->products[$groupid][$productid]['maxrangequantity'] ) {
				if( $inCart > 0 )
				{
					$quantity = 1;
				}
				else
				{
					$quantity = (int)$myPage->products[$groupid][$productid]['minrangequantity'];
				}
					
			} else {
				$quantity = -1;
			}
		}
			
		return ( $quantity > 0  ? '' : _T('This product is already in your shopping cart.') );
	}

	// now handle the situation with a qty from the user
	$quantity = (int) $quantity;
	$isNum = ( $quantity > 0 );

		if( $myPage->products[$groupid][$productid]['typequantity'] == 'range_quantity' &&
		( ! $isNum ||
		  $quantity < ($myPage->products[$groupid][$productid]['minrangequantity'] - $inCart) ||
		  $quantity > ($myPage->products[$groupid][$productid]['maxrangequantity'] - $inCart) ) )
	{
		
		
		$msg = sprintf( _T("Quantity must be a number between %d and %d."),
			 		$myPage->products[$groupid][$productid]['minrangequantity'],
			 		$myPage->products[$groupid][$productid]['maxrangequantity'] );
		if( $inCart )
			$msg .= sprintf( _T(" <br/>You have this product %d times in your cart."), $inCart );

		return $msg;
	}

	if( $myPage->products[$groupid][$productid]['typequantity'] == 'choose_quantity' && !$isNum )
	{
		$msg = _T("Quantity must be a whole number and may not be 0.");
		return $msg;
	}

	if( $myPage->products[$groupid][$productid]['typequantity'] == 'default_quantity' &&
		$quantity != $myPage->products[$groupid][$productid]['defaultquantity'] )
	{
		// only default quantity allowed
		$quantity = $myPage->products[$groupid][$productid]['defaultquantity'];
		$msg = sprintf( _T("Quantity can only be: %d."), $quantity );
		return $msg;
	}

	return '';
}

?>
