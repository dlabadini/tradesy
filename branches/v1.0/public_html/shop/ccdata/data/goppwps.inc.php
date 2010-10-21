<div class="paypal_feedback">
  <a href="http://www.paypal.com" target="_blank"><img src="ccdata/images/PPLogo.png" align="right" border="0"></a>
  <h3>Proceed to secure credit card checkout with PayPal</h3>
  <p>Thank you for shopping with us!</p>
  <p>We will now transfer you to the secure payment gateway where you can enter your credit card data.</p>
  <br/><br/>
  <form style="display:inline;" action="<?php echo $myPage->getUrl('cancel'); ?>" method="POST">
    <input type="submit" name="return" value="Return to the Shop" />
  </form>&nbsp;&nbsp;&nbsp;
  <form style="display:inline;" action="<?php echo $myPage->getConfig('PayPalWPS', 'URL'); ?>" method="POST">
  	<?php echo $myPage->getCheckoutFields() ?>
    <input type="submit" name="_xclick" value="Proceed to Checkout" />
  </form>
</div>