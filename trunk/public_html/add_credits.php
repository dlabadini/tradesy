<?php
include 'init_utils.php';

$page_title = "Add Credits | " . ucwords($_SESSION['fullname']);
include 'layout/startlayout.php';
nav_menu($_SESSION['username'], '');
?>

<div class="page_info">
<?php
/* THIS IS THE TEST BUTTON
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="3JKKLLDW59YJQ">
<table>
<tr><td><input type="hidden" name="on0" value="Book Credits">Book Credits</td></tr><tr><td><select name="os0">
	<option value="1 Credit">1 Credit $1.50</option>
	<option value="5 Credits">5 Credits $6.00</option>
	<option value="10 Credits">10 Credits $10.00</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
*/
?>

<div class='action' id='add_credits' style='display:; position:relative;'>
<?php
include 'includes/buy_credits_button.html';
?>
</div>
</div>

<?php
include 'layout/endlayout.php';
?>