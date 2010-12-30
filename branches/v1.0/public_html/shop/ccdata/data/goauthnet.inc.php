<div class="paypal_feedback">
  <a href="http://www.authorize.net" target="_blank"><img src="ccdata/images/authnet_checkout.gif" align="right" border="0"></a>
  <h3>Proceed to secure checkout with Authorize.Net</h3>
  <p>Thank you for shopping with us!</p>
  <p>We will now transfer you to the secure payment gateway where you can enter your credit card data.</p>
  <br/><br/>
  <form style="display:inline;" action="<?php echo $myPage->getUrl('cancel'); ?>" method="POST">
    <input type="submit" name="return" value="Return to the Shop" />
  </form>&nbsp;&nbsp;&nbsp;
  <form style="display:inline;" action="<?php echo $myPage->getConfig('AuthorizeNetSIM', 'URL'); ?>" method="POST">
  	<?php echo $myPage->getCheckoutFields() ?>
    <input type="submit" name="checkout" value="Proceed to Checkout" />
  </form>
</div>