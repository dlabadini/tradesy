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

if( !isset( $_GET['groupid'] ) || !is_numeric( $_GET['groupid'] ) )
{
	// show store front
	include($absPath . 'ccdata/data/index.inc.php');
	exit(0);
}

include $myPage->getLangIncludePath( 'group.inc.php' );

ob_end_flush();

?>