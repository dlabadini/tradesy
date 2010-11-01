<?php
include 'init_utils.php';

$page_title = "Add credits | " . ucwords($_SESSION['fullname']);
include 'layout/startlayout.php';
nav_menu($_SESSION['username'], '');
?>

<div class="page_info">

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="866FRXJTAL374">
<table>
<tr><td><input type="hidden" name="on0" value="Book credits">Book credits</td></tr><tr><td><select name="os0">
	<option value="1">1 $1.30</option>
	<option value="5">5 $5.00</option>
	<option value="10">10 $9.00</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

</div>

<?php
include 'layout/endlayout.php';
?>