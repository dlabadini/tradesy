<?php
/**
 * CoffeeCup Software's Shopping Cart Creator.
 *
 * Auth.Net relay response page.
 *
 * Auth.Net works as a sort of relay-proxy and does not send header info back to the site.
 * So as long as we don't store transactions in the cart, it is difficult to relate this
 * page with the actual cart contents that was paid. For the time being, include a button
 * that brings the client back to the shop and empty the cart when that happens.
 *
 * @version $Revision: 2265 $
 * @author Cees de Gruijter
 * @category SCC
 * @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
 */

require './ccdata/php/utilities.inc.php';
require $absPath . 'ccdata/php/checkoutans.cls.php';

if( isset( $_POST['sessionid'] ) )
	session_id( $_POST['sessionid'] );


// Retrieving and defining Form Data from POST
$ResponseCode = Trim( $_POST["x_response_code"] );
$ResponseReasonText = Trim( $_POST["x_response_reason_text"] );
$ResponseReasonCode = Trim( $_POST["x_response_reason_code"] );
//$AVS = Trim( $_POST["x_avs_code"] );				// not use  here (yet)
$TransID = Trim( $_POST["x_trans_id"] );
$AuthCode = Trim( $_POST["x_auth_code"] );
$Amount = Trim( $_POST["x_amount"] );
$ReceiptLink = "http://www.authorizenet.com";

// any url that is returned by a page::method must have a full url
// and filter some other stuff
class FullUrlPage extends CheckoutPage {

	var $myUrl;

	function FullUrlPage () {

		Page::Page();

		$this->myUrl = $this->getFullUrl(false, false, true);
		$this->myUrl = substr( $this->myUrl, 0, strrpos( $this->myUrl, '/' ) + 1 );
	}

	function getConfig( $param1, $param2 = false ) {

		$result = Page::getConfig( $param1, $param2 );

		switch ( $param1 ) {
			case 'shoplogo':
			case 'viewcarthref':
			case 'home':
				if( ! empty( $result ) )
					$result = $this->myUrl . $result;
		}
		return $result;
	}

	function getUrl(  $query = false ) {
		return $this->myUrl . Page::getUrl( $query );
	}

	function getGroups() {
		$myGroups = Page::getGroups();
		for( $i = 0; $i < count($myGroups); ++$i ) {
			$myGroups[$i]['pagehref'] = $this->myUrl . $myGroups[$i]['pagehref'];
		}
		return $myGroups;
	}

}


$myPage = new FullUrlPage();

switch( $ResponseCode ) {
	case "1":
		$ResponseText = _T("This transaction has been approved.");
		// clean out the cart ---- won't work, the AUth.Net relay does not have session info.
		break;
	case "2":
		$ResponseText = _T("This transaction has been declined.");
		break;
	case "3":
		$ResponseText = _T("There has been an error processing this transaction.");
		break;
	case "4":
		$ResponseText = _T("This transaction is being held for review.");
		break;
	default:
		$ResponseText = _T("There was an error processing this transaction.");
}

if( $TransID == "0" && $ResponseCode == "1" )
	$testMode = _T("*TEST MODE* This transaction will -NOT- be processed because your account is in Test Mode.");
else
	$testMode = false;


// pass the contents of the message template to the page
$msgfile = $myPage->getLangIncludePath( 'resultauthnet.inc.php' );
if( is_file( $msgfile ) ) {
	ob_start();						// output buffering
	include $msgfile;
	$myPage->setCartMessage(ob_get_contents());
	ob_end_clean();
} else {
	$myPage->setCartMessage();		// reset message
}

// Problem: Auth.Net behaves as a sort of proxy and for html links to work, we need full url's
// which the templates don't have. Since it is only this 1 template, we can read it into
// a buffer and replace the things we need.

$templateFile = $myPage->getLangIncludePath( 'cart_authnet_1.inc.php' );
if( is_file( $templateFile ) ) {
	ob_start();						// output buffering
	include $templateFile;
	$template = ob_get_contents();
	ob_end_clean();
} else {
	$template = FallbackScreen();
}

FixUrls ( $template );

echo $template;

ob_end_flush();
exit();

/*******************************/

function FixUrls( &$source ) {

	global $myPage;
	$url = $myPage->getFullUrl(false, false, true);
	$url = substr( $url, 0, strrpos( $url, '/' ) + 1 );

	$source = str_replace( 'src="ccdata', 'src="'   . $url . 'ccdata' , $source );
	$source = str_replace( 'href="css'  , 'href="'  . $url . 'css' , $source );
	$source = str_replace( 'src="js'    , 'js="'    . $url . 'js' , $source );

}


// simple response screen that has no dependencies
function FallbackScreen ( ) {

	global $myPage, $Amount, $testMode, $ResponseText, $ResponseReasonCode, $ResponseReasonText;

?>	<html>
	<head>
	<title>Transaction Receipt Page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
	<body bgcolor="#FFFFFF">
<?php if( $testMode ) { ?>
<table align="center" width="60%">
	<tr>
		<th>
		  <font size="5" color="red" face="arial">TEST MODE</font>
		</th>
	</tr>
	<tr>
		<th valign="top">
		    <font size="1" color="black" face="arial">
			This transaction will <u>-NOT-</u> be processed because your account is in Test Mode.
			</font>
		</th>
    </tr>
</table>
<?php } ?>
	<br>
	<br>
	<table align="center" width="60%">
	<tr>
		<th><font size="3" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">
			<?php echo $myPage->getConfig('shopname'); ?></font>
		</th>
	</tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr>
		<th><font size="2" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">
			<?php echo $ResponseText; ?></font>
		</th>
	</tr>
	</table>
	<br>
	<br>
	<table align="center" width="60%">
	<tr>
		<td align="right" width=175 valign=top><font size="2" color="black" face="arial">
		  <b>Amount:</b>
		</font></td>
		<td align="left"><font size="2" color="black" face="arial">
		    <?php echo $myPage->curSign .  $Amount; ?>
		</font></td>
	</tr>

	<tr>
		<td align="right" width=175 valign=top><font size="2" color="black" face="arial">
		<b>Transaction ID:</b>
		</font></td>
		<td align="left"><font size="2" color="black" face="arial">
			<?php echo $TransID == "0" ? _T("Not Applicable.") : $TransID; ?>
		</font></td>
	</tr>

	<tr>
		<td align="right" width=175 valign=top><font size="2" color="black" face="arial">
		<b>Authorization Code:</b>
		</font></td>
		<td align="left"><font size="2" color="black" face="arial">
			<?php echo $AuthCode == "000000" ? _T("Not Applicable.") : $AuthCode ?>
			</font></td>
	</tr>
	<tr>
		<td align="right" width=175 valign=top><font size="2" color="black" face="arial">
		<b>Response Reason:</b></font></td>
		<td align="left">
		  <font size="2" color="black" face="arial">
		  <?php echo $ResponseReasonCode . '&nbsp;' . $ResponseReasonText; ?>
		  </font></td>
	</tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr>
		<td>&nbsp;</td>
		<td><a href="<?php echo $myPage->getConfig('home'); ?>">Take me back to the shop</a></td>
    </tr>
	</table>
	</body>
	</html>
<?php
}
 ?>