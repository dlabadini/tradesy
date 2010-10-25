<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Entry point for the web shop.
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

// show index
include $myPage->getLangIncludePath( 'index.inc.php' );

ob_end_flush();
?>