<?php
/**
 * CoffeeCup Software's Shopping Cart Creator.
 *
 * Required POST parameters:
 *  	method, value can be: add, update, remove
 * or one of the following:
 * 		recalculate
 * 		delete
 * 		emptycart
 * 		checkout
 * 		confirmpp
 * 		paypalcheckout
 * 		googlecheckout
 *
 *  Optional parameters:
 * - item_id
 * - group_id
 * - any other form field that is appropriate in a certain context
 *
 * Upon successful cart update, the user is redirected to the cart
 * (see NAVIGATION comment)
 *
 * @version $Revision: 2265 $
 * @author Cees de Gruijter
 * @category SCC
 * @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
 */

// load static functions to manipulate cart
require $absPath . 'ccdata/php/cartcontrol.inc.php';

// $myPage should exist already, but just in case it doesn't
if( empty( $myPage ) ) $myPage = new Page( true );

if( $myPage->message != '' ) {
	$myPage->setCartMessage( $myPage->message );
	return;
}

// remove any pending authorisation with PayPal, it is invalidated by changes to the cart
if( isset($_SESSION[PAYMENT]) ) {
	unset( $_SESSION[PAYMENT] );
	$myPage->resArray = array();
}

// cleanup any cart message that shouldn't be there'
if( isset( $_SESSION['cart_warning'] ) ) {
	unset( $_SESSION['cart_warning'] );
}

// what do we need to do?
if( isset($_POST['method']) ) {
	$method = $_POST['method'];
} else if( isset($_POST['recalculate']) ) {
	$method = 'update';
} else if( isset($_POST['delete']) ) {
	$method = 'remove';
} else if( isset($_POST['emptycart']) ) {
	$method = 'emptycart';
} else if( isset($_POST['paypalcheckout']) || isset($_POST['paypalcheckout_x']) ) {
	$method = 'cc_paypalcheckout';
} else if( isset($_POST['paypalwpscheckout']) || isset($_POST['paypalwpscheckout_x']) ) {
	$method = 'cc_paypalwpscheckout';
} else if( isset($_POST['googlecheckout']) || isset($_POST['googlecheckout_x']) ) {
	$method = 'cc_googlecheckout';
} else if( isset($_POST['anscheckout']) || isset($_POST['anscheckout_x']) ) {
	$method = 'cc_anscheckout';
} else if( isset($_POST['twocheckout']) || isset($_POST['twocheckout_x']) ) {
	$method = 'cc_2checkout';
} else if( isset($_POST['confirmpp']) ) {
	$method = 'confirmpp';
} else {
	$method = false;
}

if( $method ) {
	switch( $method ) {
		case 'emptycart':
			$errorMsg = $myPage->emptyCart();
			break;

		case 'add':
		case 'update':
		case 'remove':
			$mytask = 'cart_' . $method;
			$errorMsg = $mytask( $cids );
			break;

		case 'cc_googlecheckout':
		case 'cc_paypalcheckout':
		case 'cc_paypalwpscheckout':
		case 'cc_anscheckout':
		case 'cc_2checkout':

			if( count( $myPage->cart->Prods ) > 0 ) {

				header('Location: ' . $myPage->getConfig($method, true) .'?connect');
				exit(0);

			} else
				cart_update();	// does nothing that can cause problem

			break;

		case 'confirmpp':		// usually handled by the page that does 'connectpp'

			header('Location: ' . $myPage->getConfig('cc_confirmpayment', true));
			break;

		default:
			die("Could not recognize task in Post request ($method).");
	}

	/* removed, this function should only be done once after upload
	// this is a good point to verify the server (once per session)
	if( ! isset($_SESSION['serverOK']) ) {
		$test = testVersion() + testExtensions() + testPayPal();
		if( $test == 0 ) {
			$_SESSION['serverOK'] = true;
		} else {
			// output a normal page, because die() may go to the log file
			echo "<html><head></head><body><h2>This server is missing functionality that is needed by the Shopping Cart software.</h2>";
			echo "<h3>Please run the server test script that is supplied with the software to obtain more information about this server (error $test).</h3></body></html>";
			exit();
		}
	}
	*/

	if( $errorMsg ) {
		$myPage->setCartMessage( $errorMsg );
	} else {
		$myPage->saveCart();

		// NAVIGATION: stop output buffering and redirect to cart if needed
		if( stristr( strtolower($_SERVER['PHP_SELF']), 'cart.php' ) === false &&
			$myPage->getConfig('navigate_stayonpage') == false )
		{
			if( ob_get_level() != 0 ) ob_end_clean();
			header("Location: cart.php");
			exit();
		}
	}
}



// return 1 if minimal PHP version is not installed
function testVersion ( ) {
	$version = phpversion();
	$v = explode('.', $version);

	$ok = false;
	$ok = $ok || $v[0] > 4;
	$ok = $ok || $v[0] = 4 && $v[1] >= 3;
	return $ok ? 0 : 1;
}


// return 2 if not all needed extensions are present
function testExtensions ( ) {
	$result = true;
	$exts = get_loaded_extensions();

	if( array_search('curl', $exts) === false )	{
		$result = false;
	}

	if( array_search('pcre', $exts) === false ) {
		$result = false;
	}

	if( array_search('session', $exts) === false ) {
		$result = false;
	}

	// some 'free' servers disable curl_init
	$funcs = get_extension_funcs("curl");
	if( $funcs !== false && array_search('curl_init', $funcs) === false ) {
		$result = false;
	}

	return $result ? 0 : 2;
}


// return 4 if connect is not possible
function testPayPal ( ) {

	global $myPage;

	$connectOK = false;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.paypal.com");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

	// Proxy will only be enabled if USE_PROXY is set to TRUE
	if( $myPage->getConfig('PayPal', 'USE_PROXY') ) {
		curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
		curl_setopt ($ch, CURLOPT_PROXY,
						  $myPage->getConfig('PayPal', 'PROXY_HOST')
		 				. ":" . $myPage->getConfig('PayPal', 'PROXY_PORT') );
	}

	$dummy = curl_exec($ch);
	curl_close($ch);
	return $dummy !== false ? 0 : 4;
}


?>
