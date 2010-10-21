<?php
/**
 * CoffeeCup Software's Shopping Cart Creator.
 *
 * Connection with Authorize.Net SIM.
 *
 * Pass 1. The cart is shown read-only and the visitor has the option to
 *         - return to the cart
 *         - continue to Auth.Net
 * Pass 2. Auth.Net does all payment processing. The user may define a relay-response url
 *         that brings the visitor back to his web site after the transaction has been completed.
 * Pass 3. The relay response (if used) should contain a button to empty the cart.
 *
* @version $Revision: 2265 $
 * @author Cees de Gruijter
 * @category SCC
 * @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
 */


require './ccdata/php/utilities.inc.php';
require $absPath . 'ccdata/php/checkoutans.cls.php';

$myPage = new CheckoutPage();

if( isset($_GET['cancel']) ) {

	// go back to the cart
	header("Location: cart.php");
	exit();

} else {

	showGoAuthNetForm();
}

ob_end_flush();
exit();


// variable $myPage MUST be defined/available for the includes to work!!!
function showGoAuthNetForm ( ) {

	global $myPage;

	// pass the contents of the message template to the page
	$msgfile = $myPage->getLangIncludePath( 'goauthnet.inc.php' );
	if( is_file( $msgfile ) ) {
		ob_start();						// output buffering
		include $msgfile;
		$myPage->setCartMessage(ob_get_contents());
		ob_end_clean();
	} else {
		$myPage->setCartMessage();		// reset message
	}
	include $myPage->getLangIncludePath( 'cart_authnet_1.inc.php' );
}
 ?>