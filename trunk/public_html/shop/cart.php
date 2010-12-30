<?php
/**
 * CoffeeCup Software's Shopping Cart Creator.
 *
 * Page with the cart.
 *
 * POST handles the following keys:
 * 	  Key                   Corresponding Data
 * 	- recalculate			key 'qty' contains array (cartid, #)
 * 	- delete				contains array with (cartid, 'delete')
 * 	- checkout				no data
 *
 * Updated cart is returned.
 *
 * This page has no GET requests, only the plain cart page.
 *
 * @version $Revision: 2265 $
 * @author Cees de Gruijter
 * @category SCC
 * @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
 */

require './ccdata/php/utilities.inc.php';

// hack so we can return from Auth.Net relay without security warning ( <a..> instead of form post )
if( isset($_GET['emptycart']) ) $_POST['emptycart'] = 1;


// global
$myPage = new Page();

// hack so we can return from PP WPS and empty cart (session only available after page object is created)
if( isset( $_SESSION['emptycart'] ) ) {
	$_POST['emptycart'] = 1;
	unset( $_SESSION['emptycart'] );
}


if( ! empty($_POST) ) {

	// handle form submit
	include $absPath . 'controller.php';		// this will create the cart-page object

}

// see if another url left us a message
if( isset( $_SESSION['cart_warning'] ) ) {
	$myPage->setCartMessage( $_SESSION['cart_warning'] );
	unset( $_SESSION['cart_warning'] );
}


// show cart
include $myPage->getLangIncludePath( 'cart.inc.php' );

ob_end_flush();

?>