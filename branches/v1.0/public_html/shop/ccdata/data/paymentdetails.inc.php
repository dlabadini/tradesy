<?php /** @version $Revision: 2751$ */ ?>
<?php?><div class="paypal_feedback"><h3>Information received from PayPal:</h3><table><tr><td><strong>Order Total:</strong></td><td><?php echo $myPage->curSign;?><?php echo $myPage->resArray['AMT']; ?></td></tr><tr><td>&#160;</td><td>&#160;</td></tr><tr><td ><strong>Shipping Address:</strong></td></tr><tr><td>Street 1:</td><td><?php echo $myPage->resArray['SHIPTOSTREET']; ?></td></tr><tr><td>Street 2:</td><td><?php echo $myPage->resArray['SHIPTOSTREET2']; ?></td></tr><tr><td>City:</td><td><?php echo $myPage->resArray['SHIPTOCITY']; ?></td></tr><tr><td>State:</td><td><?php echo $myPage->resArray['SHIPTOSTATE']; ?></td></tr><tr><td>Postal code:</td><td><?php echo $myPage->resArray['SHIPTOZIP']; ?></td></tr><tr><td>Country:</td><td><?php echo $myPage->resArray['SHIPTOCOUNTRYNAME']; ?></td></tr><tr><td>&#160;</td><td>&#160;</td></tr><tr><td>&#160;</td><td><a href="<?php echo $myPage->getConfig('cc_paypalcheckout'); ?>">&#187; Return to PayPal to change the address</a></td></tr></table></div>