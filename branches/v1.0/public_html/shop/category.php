<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Category page. Only shows the categroy base page
*
* @version $Revision: 2265 $
* @author Cees de Gruijter
* @modified Alberto Fdez.
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

require './ccdata/php/utilities.inc.php';
$myPage = new Page();

if( isset($_POST['method']) ) {

	// handle form submit
	include $absPath . 'controller.php';		// this will create the page object

}

// show index
include $myPage->getLangIncludePath( 'catpage.inc.php' );

ob_end_flush();
?>