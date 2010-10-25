<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Connection with Google Checkout.
*
* @version $Revision: 2265 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

require './ccdata/php/utilities.inc.php';
require $absPath . 'ccdata/php/checkoutgc.cls.php';

$myPage = new CheckoutPage();


if( isset($_GET['cancel']) ) {

	// go back to the cart
	header("Location: cart.php");
	exit();

} else {

	// go to Google Checkout
	if( ! $myPage->checkOut() ) {
		showError();
	}
}

ob_end_flush();
exit();


// variable $myPage MUST be defined/available for the includes to work!!!

/******** Displays error parameters. ********/
function showError ( ) {
	global $myPage;
?>

<html>
<head>
<title><?php _T('Google Checkout Response'); ?></title>
<style>
td{vertical-align:top;}
td.header{font-size:1.1em;font-weight:bolder;}
</style>
</head>

<body alink=#0000FF vlink=#0000FF>

<center>

<table width="700" cellspacing="10">
<tr>
		<td colspan="2" class="header"><?php _T('Google Checkout has returned an error!'); ?></td>
	</tr>
<?php  //it will print if any URL errors
	if(isset($_SESSION['curl_error_no'])) {
			$errorCode = $_SESSION['curl_error_no'] ;
			$errorMessage = $_SESSION['curl_error_msg'] ;
			session_unset();
?>

<tr>
		<td><?php _T('Error Number:'); ?></td>
		<td><?php echo $errorCode ?></td>
	</tr>
	<tr>
		<td><?php _T('Error Message:'); ?></td>
		<td><?php echo $errorMessage; ?></td>
	</tr>

<?php } else {

/* If there is no URL Errors, Construct the HTML page with
   Response Error parameters.
   */
?>
<tr>
		<td><?php _T('Ack:'); ?></td>
		<td><?php echo $myPage->resArray['ACK']; ?></td>
	</tr>
	<tr>
		<td><?php _T('Message:'); ?></td>
		<td><?php echo $myPage->resArray['MESSAGE']; ?></td>
	</tr>
	<tr>
		<td><?php _T('Post:'); ?></td>
		<td><pre><?php echo str_replace(array('<','>'), array('&lt;','&gt;'), $myPage->resArray['POST']); ?></pre></td>
	</tr>
<?php }// end else ?>
 </table>
</center>
<br>
<a class="home" id="CallsLink" href="<?php echo $myPage->getConfig('home'); ?>"><font color="blue">&lt;&lt; <?php _T('home'); ?></font></a>
</body>
</html>
<?php } ?>