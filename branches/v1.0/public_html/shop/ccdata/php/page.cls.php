<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Everything a normal page needs to know or do.....
*
* Some functions to manipulate the cart contents must be loaded
* statically in controller.php because PHP4 does not have dynamic methods
*
* @version $Revision: 2734 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

require $absPath . 'ccdata/php/shoppingCart.cls.php';

define('PAYMENT', 'PayResponse');

header('Content-Type: text/html; charset=utf-8');

class Page {

	function loadData ( ) {

		global $absPath;
		require $absPath . "ccdata/data/data.php";

		$this->products = $products;
		$this->groups = $groups;
		$this->starredproducts = $starredproducts;
		$this->categoryproducts = $categoryproducts;
		$this->extrashipping = $extrashippings;
		$this->creditcards = $creditcards;
		$this->pages = $pages;
		$this->config = $config;

		// TaxRate must exist to avoid errors in cart calculations
		if( ! isset( $this->config['TaxRates'] ) )
			$this->config['TaxRates'] = array();

		// see: http://en.wikipedia.org/wiki/Currency_sign
		switch( $this->getConfig('shopcurrency') ) {
			case 'USD':
			$this->curSign = '$';
			break;
			case 'EUR':
			$this->curSign = '&euro;';
			break;
			case 'GBP':
			$this->curSign = '&pound;';
			break;
			case 'CAD':
			$this->curSign = 'C$';
			break;
			case 'JPY':
			$this->curSign = '&yen;';
			break;
			case 'MXN':
			$this->curSign = '&#8369;';
			break;
			case 'HUF':
			$this->curSign = 'Ft';
			break;
			case 'ILS':
			$this->curSign = '&#8362;';
			break;
			case 'PLN':
			$this->curSign = 'zł';
			break;
			case 'CHF':
			$this->curSign = 'SFr.';
			break;
			case 'AUD':
			$this->curSign = 'AU$';
			break;
			case 'NZD':
			$this->curSign = 'NZ$';
			break;
			case 'HKD':
			$this->curSign = 'HK$';
			break;
			case 'SGD':
			$this->curSign = 'S$';
			break;
			case 'SEK':
			$this->curSign = 'kr';
			break;
			case 'DKK':
			$this->curSign = 'Dkr';
			break;
			case 'NOK':
			$this->curSign = 'NKr';
			break;
			case 'CZK':
			$this->curSign = 'Kc';
			break;
			default:
			$this->curSign = $this->getConfig('shopcurrency');
			break;
		}
	}

	// properties
	var $cart;
	var $config;
	var $curSign;
	var $products;
	var $groups;
	var $starredproducts;
	var $categoryproducts;
	var $message = '';					// markup for message in cart screen
	var $extrashipping;
	var $creditcards;
	var $pages;

	// constructor
	function Page ( ) {

		// we don't like it when E_NOTICE is set
		error_reporting(E_ALL ^ E_NOTICE);

		$this->loadData();

		// session cookie name so multiple shops on a domain do not share a session
		// name may only contain alpanumeric characters and must have at least 1 character
		session_name( 'cc' . preg_replace('/\W/', '', $this->config['shopname']) );
		session_start();

		$this->createCart();

		// test if session and data.php are in sync
		// else start with empty cart
		// and set message and if it had any articles.
		if( ! $this->isInSync() ) {
			if( $this->cart->getNumberOfArticles() ) {
				$this->message = _T( "The shop has just been updated. Please select the products that you want to buy again. Sorry for the inconvenience." );
			}
			$this->createCart( true );					// new cart
		}

		// always unlock the cart, lock it later again if needed
		$this->lockCart( false );

	}


	// save only data in session because some php4 servers have problems
	// with loading serialized classes (reason unknown)
	function createCart ( $emptyCart = false ) {

		$this->cart = new ShoppingCart( $this, $emptyCart );
		$_SESSION['ShopTimestamp'] = $this->getConfig( 'timestamp' );
	}


	function emptyCart ( ) {
		$this->cart->emptyCart( true );
	}


	function saveCart ( ) {
		$this->cart->saveCart( );
	}


	// return true if data.php has not changed since creating the session
	function isInSync ( ) {
		return $this->getConfig('timestamp') == $_SESSION['ShopTimestamp'];
	}


	function lockCart ( $lock = true ) {
		$this->cart->lock = $lock;
	}


	function getLockCart ( ) {
		#echo ($this->cart->lock ? 'locked' : 'free' );
		return $this->cart->lock;
	}


	// template should call this to determine which checkout buttons to show
	// $method must match *exactly* what is in the data.php file!
	function hasCheckoutMethod ( $method ) {
		if( isset($this->config[$method]) )
			return isset($this->config[$method]['enabled']) && $this->config[$method]['enabled'];
		else
			return false;
	}


	function getPaymentState ( ) {

		if( $this->cart->getNumberOfArticles() == 0 )
			return -1;						// empty cart, no payment possible
		else if( !isset($this->resArray) ||
				 !isset($this->resArray['TOKEN']) ||
				 $this->resArray['TOKEN'] == '' )
			return 0;						// no payment in progress
		else if( isset($this->resArray['PAYMENTSTATUS']) &&
			$this->resArray['PAYMENTSTATUS'] == 'Completed')
			return 2;						// payment completed
		else
			return 1;						// connection with PayPal established
	}


	function getConfig( $param1, $param2 = false, $dieOnFailure = true ) {

		$notfound = false;

		switch ($param1) {
			// these are params determined by php
		case 'cc_paypalcheckout':
			if( $param2 ) 					// asked url only
				$result = "checkoutpp.php";
			else
				$result = "checkoutpp.php?updateinfo";
			break;

		case 'cc_paypalwpscheckout':
			$result = "checkoutpps.php";
			break;

			// these are params determined by php
		case 'cc_googlecheckout':
			if( $param2 ) 					// asked url only
				$result = "checkoutgc.php";
			else
				$result = "checkoutgc.php?updateinfo";
			break;

		case 'cc_anscheckout':
				$result = "checkoutans.php";
			break;

		case 'cc_2checkout':
				$result = "checkout2co.php";
			break;

		case 'paypalimage':
			$result = 'https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif';
			break;

		case 'paypalwpsimage':
			$result = 'https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif';
			break;

		case 'googleimage':
			$result = 'https://checkout.google.com/buttons/checkout.gif?merchant_id='
					. $this->config['Google']['merchant_id']
					. '&w=160&h=43&style=trans&variant=text&loc=en_US';
			break;

		case 'authorizeimage':
			$result = 'ccdata/images/CardCheckout.png';
			break;

		case 'transaction':
				$result = 'Sale';
			break;

		case 'cc_confirmpayment':
			if( $param2 ) 					// asked url only
				$result = "checkoutpp.php";
			else
				$result = "checkoutpp.php?payment');";
			break;

		// next are the params determined by the application
		default:
			if( $param2 && isset($this->config[$param1][$param2]) ) {
				$result = $this->config[$param1][$param2];
			} else if( isset($this->config[$param1]) && !$param2 ) {
				$result = $this->config[$param1];
			} else
				$notfound = true;
		}
		if( $notfound == true ) {

			// be careful with this switch, some config parameters return false as a valid value
			if( $dieOnFailure )
				die( "No config parameter '$param1'" . ($param2 ? " + $param2 " : ' ') . "defined." );
			else
				return false;
		}

		return $result;
	}

	// return path to file in correct language or safe fallback if file does not (yet) exist
	function getLangIncludePath ( $filename ) {

		global $absPath;

		if( ! empty( $filename ) ) {
			$filename = ltrim( $filename, '/ ');
		}

		$path = false;
		if( isset( $this->config['lang'] ) && $this->config['lang'] != 'en' ) {

			$path = $absPath . 'ccdata/data/' . $this->config['lang'] . '/' . $filename;

		}
		if( $path !== false && file_exists( $path ) ) {
			return $path;
		}

		return $absPath . 'ccdata/data/' . $filename ;
	}


	// $query substitutes the current query (if any) with this value
	// calling this method with an empty string will always return an url with query part
	function getUrl ( $query = false ) {

		// get self without query string
		$url = $_SERVER['PHP_SELF'];
		$p = strpos( $url, '?' );
		if( $p !== false )
			$url = substr( $url, 0, $p - 1 );

		// do we need to replace the query string or use the original?
		if(  $query !== false ) {

			if( !empty( $query ) ) $url .= '?' . $query;

		} else if( $_SERVER['QUERY_STRING'] )
			$url = $_SERVER['PHP_SELF'] . '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_NOQUOTES, 'UTF-8');

		return $url;
	}


	// include server info
	function getFullUrl ( $altPage = false, $includeQuery = true, $urlEncode = false ) {

		// some servers use redirection which causes SERVER_NAME != 'url_we_need'
		// test on _SERVER["REDIRECT_SCRIPT_URI"] if this may be the case
		if( isset( $_SERVER['HTTP_HOST'] ) )
			$servername = $_SERVER['HTTP_HOST'];
		else
			$servername = $_SERVER['SERVER_NAME'];

		if( $urlEncode ) {
			// encode the folders, not the '/'!
			$tmp = explode( '/',  trim( $_SERVER['PHP_SELF'], '/') );
			for( $i = 0; $i < count( $tmp ); ++$i ) {
				$tmp[$i] = rawurlencode( $tmp[$i] );
			}
			$script = '/' . implode( '/', $tmp );
		} else {
			$script =  $_SERVER['PHP_SELF'];
		}

		if( $_SERVER['QUERY_STRING'] && $includeQuery )
			$script .= '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_NOQUOTES, 'UTF-8');

		$protocol = strtolower( substr( $_SERVER['SERVER_PROTOCOL'], 0, strpos( $_SERVER['SERVER_PROTOCOL'], '/') ) );
		
		// In case https is used in the server, we set the protocol string to https 
		if( $_SERVER['HTTPS'] == 'on' )
		{
			$protocol = 'https';
		}
		
		$url = $protocol . '://' . $servername;

		// only add the serverport when it differs from the default
		if( strpos( $servername, ':') === false &&
			( $_SERVER['SERVER_PORT'] != '80' || $protocol != 'http') ) {
			$url .= ':' . $_SERVER['SERVER_PORT'];
		}

		$url .= $script;

		if( $altPage )
			$url = substr($url, 0, strrpos($url, '/') + 1 ) . $altPage;

		return $url;
	}


	// format returned  array ( array('productid' => '7', 'groupid' => '0'), ...
	function getStarredProducts ( $groupid = false ) {

		// use === because grouid can have value 0
		if( $groupid === false ) return $this->starredproducts;

		$prods = array();
		foreach( $this->starredproducts as $prod ) {
			if( $prod['groupid'] == $groupid ) $prods[] = $prod;
		}
		return $prods;
	}


	// format returned  array ( 1, 3, 4 )
	function getStarredGroups ( ) {
		$grps = array();
		// In case that there are no starred products, maybe the user wants only categories to be shown
		if( count( $this->starredproducts ) != 0 )
		{
			foreach( $this->starredproducts as $prod ) {
				// add to a map to catch duplicates
				$grps[ $prod['groupid'] ] = 1;
			}
		}
		else
		{
			foreach( $this->groups as $group ){
				$grps[ $group['groupid'] ] = 1;
			}
		}
		return array_keys($grps);
	}

	// format returned  array ( array('productid' => '7', 'groupid' => '0'), ...
	function getCategoryProducts ( $groupid = false ) {

		// use === because grouid can have value 0
		if( $groupid === false ) return $this->categoryproducts;

		$prods = array();
		foreach( $this->categoryproducts as $prod ) {
			if( $prod['groupid'] == $groupid ) $prods[] = $prod;
		}
		return $prods;
	}

	// format returned  array ( 1, 3, 4 )
	function getCategoryGroups ( ) {
		$grps = array();
		// In case that there are no starred products, maybe the user wants only categories to be shown
		if( count( $this->categoryproducts ) != 0 )
		{
			foreach( $this->categoryproducts as $prod ) {
				// add to a map to catch duplicates
				$grps[ $prod['groupid'] ] = 1;
			}
		}
		else
		{
			foreach( $this->groups as $group ){
				$grps[ $group['groupid'] ] = 1;
			}
		}
		return array_keys($grps);
	}

	function getCartProducts ( ) {
		return $this->cart->getPairProductIdGroupId();
	}


	function getProductNameByCartId ( $cartid ) {
		return $this->cart->Prods[$cartid]['name'];
	}


	function getGroups ( ) {
		// groups can be empty
		if( ! isset( $this->groups ) || ! is_array( $this->groups ) )
			return array();

		return $this->groups;
	}

	function getCreditCards ( ) {
		// credit cards can be empty
		if( ! isset( $this->creditcards ) || ! is_array( $this->creditcards ) )
			return array();

		return $this->creditcards;
	}


	function getTaxLocations ( ) {
		$loc = $this->getConfig('TaxLocations', false);
		if( ! is_array( $loc ) ) {
			$loc = array();
		}
		return $loc;
	}
	
	
	function getPages ( $pagetype = '' ) {
		if( ! isset( $this->pages ) || ! is_array( $this->pages ) )
			return array();

		// If the string is empty we return the full array
		if( empty( $pagetype ) ) {
			return $this->pages;
		}
			
		// In case we want a determined page type, we need a auxiliar vector to fill (prevent issue foreach nested loops on PHP4)
		$param_pages = array();
		foreach( $this->pages as $key=>$curr_page ) {
			if( $curr_page['type'] == $pagetype ) {
				$param_pages[$key] = $curr_page;
			}		
		}
			
		return $param_pages;
	}

	function getPage ( $pageid ) {
		if( ! isset( $this->pages[$pageid] ) || ! is_array( $this->pages ) )
			return array();

		return $this->pages[$pageid];
	}


	function getGroup ( $groupid ) {
		// groups can be empty
		if( ! isset( $this->groups ) ||  ! isset( $this->groups[$groupid] ) )
			return array();

		return $this->groups[$groupid];
	}


	// array with all products, no formating done on price fields
	function getProducts ( ) {
		return $this->products;
	}


	// array with products in a group, no formating done on price fields
	function getProductsByGroup ( $groupid = '' ) {
		if( !$this->findId('groupid', $groupid) )
			return false;
		return $this->products[$groupid];
	}


	// product with correctly formatted fields.
	// use data from cart if $_GET['cartid'] is set and quantity from $_POST.
	function getProduct ( $groupid = '', $productid = '' ) {

		if( !$this->findId('groupid', $groupid) ||
			!$this->findId('productid', $productid) )
			return false;

		// copy product data
		$product = $this->products[$groupid][$productid];

		// add formating to the copy
		$product['yourprice'] = formatMoney($product['yourprice'], 100);
		$product['retailprice'] = formatMoney($product['retailprice'], 100);
		$product['tax'] = formatMoney($product['tax'], 100);
		$product['shipping'] = formatMoney($product['shipping'], 100);
		$product['handling'] = formatMoney($product['handling'], 100);
		$product['weight'] = formatAmount($product['weight'] / 100, 2);
		$product['quantity'] = $product['defaultquantity'];

		if( $product['ispercentage'] == 0)
			$product['discount'] = formatMoney($product['discount'], 100);
		else
			$product['discount'] = formatAmount($product['discount'] / 100, 2);

		if( isset( $_GET['cartid'] ) ) {

			$product['cartid'] = $_GET['cartid'];
			$product['cart_optionIds'] = $this->cart->getOptions($_GET['cartid']);
			$product['cart_qty'] = $this->cart->getUnitsOfProduct($_GET['cartid']);

			if( ( $optionIds = $this->cart->getOptions( $_GET['cartid']) ) != '' ) {

				// update 'selected' info of options array with cart data
				$ids = explode(',', $optionIds);

				for( $i = 0; $i < count($ids); ++$i ) {

					if( $ids[$i] > 0 ) {

						// there is an option defined, let's find it
						for( $oi = 0; $oi < count($product['options'][$i]['items']); ++$oi) {

							$item =& $product['options'][$i]['items'][$oi];

							if( $item['value'] == $ids[$i] ) {
								$item['selected'] = 1;
								break;		// because there can only be 1 selected per option
							}
						}
					}
				}
			}
		} else if( isset($_POST['quantity']) && $_POST['quantity'] > 0 ) {
			// for when the user is in the details screen, clicks submit and the page is reloaded
			$product['quantity'] = $_POST['quantity'];
		}
		return $product;
	}


	function getProductById ( $productid = '' )
	{

		if( !$this->findId('productid', $productid) )
			return false;

		foreach( $this->groups as $group )
		{
			if( isset($this->products[$group['groupid']][$productid]) )
				return $this->getProduct( $group['groupid'] , $productid );
		}

		return false;
	}


	// sets the contents of the message
	function setCartMessage ( $text = '' ) {
		$this->message = $text;
	}


	// return the contents of the message or false if no message exists
	function getCartMessage ( ) {
		if( trim( $this->message ) == '' ) return false;
		return $this->message;
	}


	function getDateProductBase ( ) {
		return $this->getConfig('timestamp');
	}


	// return array of visible items unless the index is set
	function getExtraShipping ( $index = false ) {

		if( $index === false ) {

			if( isset( $this->extrashipping ) && is_array( $this->extrashipping )) {

				// copy the visible items
				$toshow = array();

				foreach( $this->extrashipping as $es ) {

					if( $es['show'] ) {
						$toshow[] = $es;
					}
				}

				return $toshow;

			} else {

				// no data defined
				return false;

			}

		} else {
			return $this->extrashipping[$index]['description'];
		}

	}


	function getExtraShippingIndex ( ) {
		return $this->cart->getExtraShippingId();
	}


	function getCartSubtotalPriceProduct ( $cartid ) {
		return formatMoney($this->cart->getSubtotalPriceProduct($cartid), 100 );
	}


	function getCartUnitsOfProduct ( $cartid ) {
		return $this->cart->getUnitsOfProduct( $cartid );
	}


	function getCartGrandTotal ( ) {
		return formatMoney($this->cart->getGrandTotalCart(), 100);
	}


	function getCartTaxTotal ( ) {
		return formatMoney($this->cart->getTotalTax(), 100);
	}


	function getCartSubTotal ( ) {
		return formatMoney($this->cart->getSubtotalPriceCart(), 100);
	}


	function getCartShippingTotal ( ) {
		return formatMoney($this->cart->getTotalShipping(), 100);
	}


	function getCartHandlingTotal ( ) {
		return formatMoney($this->cart->getTotalHandling(), 100);
	}


	function getCartShippingHandlingTotal ( ) {
		return formatMoney( ($this->cart->getShippingHandlingTotal() ), 100);
	}


	function getCartCount ( ) {
		return $this->cart->getNumberOfLineItems();
	}


	// return true for 'enabled' and echo the text (if any) for eache state
	function setConnectButtonState ( $echofalse = '', $echotrue = '' ) {

		switch( $this->getPaymentState() ) {
		case -1:		// empty cart
		case 2:			// paid and done
		case 1:			// token from PP recieved
			$result = false;
			break;
		case 0:			// payment not started
			$result = true;
			break;
		}
		if( $result ) echo $echotrue;
		else echo $echofalse;
		return $result;
	}


	// return true for 'enabled' and echo the text (if any) for eache state
	function setPayButtonState ( $echofalse = '', $echotrue = '' ) {

		switch( $this->getPaymentState() ) {
		case -1:		// empty cart
		case 2:			// paid and done
		case 0:			// token from PP recieved
			$result = false;
			break;
		case 1:			// payment not started
			$result = true;
			break;
		}
		if( $result ) echo $echotrue;
		else echo $echofalse;
		return $result;
	}


	function findId ( $name, &$id ) {

		if( $id != '' ) return true;

		// get identifiers from GET
		if( isset($_GET[$name]) ) {
			$id = $_GET[$name];
			return true;
		}

		if( isset($_POST[$name]) ) {
			$id = $_POST[$name];
			return true;
		}

		// return boolean false (unsuccessful, no usable product identifier)
		return false;
	}

}

?>
