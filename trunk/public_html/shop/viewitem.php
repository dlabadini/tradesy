<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* This page handles GET requests for an item and POST
* requests updates information of the cart. It returns the original page.
* If the GET parameters are missing the store front is shown.
*
* @version $Revision: 2265 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

require './ccdata/php/utilities.inc.php';

// globals
$myPage = new Page();

if( isset($_POST['method']) ) {

	// handle form submit
	include $absPath . 'controller.php';		// this will create the page object

}

// some input validation
$productid = ''; $groupid = ''; $cartid = '';
$num = extract($_GET, EXTR_IF_EXISTS);

if( !is_numeric($productid) || !is_numeric($groupid) )
{
	// may be there is some left from the form
	$num = extract($_POST, EXTR_IF_EXISTS);
	if( !is_numeric($productid) || !is_numeric($groupid) )
		die( _T( "Missing Group information in GET request to the Shopping Cart." ) );
}

include $myPage->getLangIncludePath( 'product.inc.php' );

ob_end_flush();

?>
