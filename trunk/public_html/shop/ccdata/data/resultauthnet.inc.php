<div class="paypal_feedback">
  <a href="http://www.authorize.net" target="_blank"><img src="ccdata/images/authnet_checkout.gif" align="right" border="0"></a>

<?php if( $testMode ) echo '<p>' . $testMode . '</p>'; ?>

<h3><?php echo $ResponseText; ?></h3>
<table align="center">
<tr>
	<td align="right" width="175" valign=top><b><?php echo _T("Amount:"); ?></b></td>
	<td align="left"><?php echo $myPage->curSign . $Amount; ?></td>
</tr>

<tr>
	<td align="right" width="175" valign=top><b><?php echo _T("Transaction ID:"); ?></b></td>
	<td align="left"><?php echo $TransID == "0" ? _T("Not Applicable.") : $TransID; ?></td></tr>
<tr>
	<td align="right" width="175" valign=top><b><?php echo _T("Authorization Code:"); ?></b></td>
	<td align="left"><?php echo $AuthCode == "000000" ? _T("Not Applicable.") : $AuthCode ?></td>
</tr>
<tr>
	<td align="right" width="175" valign="top"><b><?php echo _T("Response Reason:"); ?></b></td>
	<td align="left"><?php echo $ResponseReasonCode . '&nbsp;-&nbsp;' . $ResponseReasonText; ?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td valign="top"><b><em><?php echo _T("Thank you for your business!") ?></em></b>
	<p class="return_button"><a href="<?php echo $myPage->getFullUrl('cart.php'); ?>?emptycart=1">Done - Return to the Shop</a></p>
	</td>
</tr>
</table>
</div>