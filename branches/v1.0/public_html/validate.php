<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>

<?php 
if ($_POST['email'] == "" and $_SESSION['code'] == ""){

    $page_title = "Registration";
    include 'layout/startlayout.php';
    ?>
    

    <div class="nav"><br>
    &nbsp; Account Registration
    </div>
    <div class="page_info">
		<?
	 echo "<div align='center'>Page has expired. Return to <a href='index.php'>College Book Evolution</a></div><br><br>".
	 			"<div style='margin-left:50px;'><p><h3>What happens now?</h3>" . 
				"<ul><li>If you didn't complete payment for your account via PayPal, please restart the <a href='register.php'>registration</a> process.</li>".
	 			"<li>If you did, please allow up to 2 days for your account to be activated. You will receive an email when this happens.</li>" .
	 			"</ul></p>If you have any questions, contact us at <a href='mailto:support@collegebookevolution.com'>support@collegebookevolution.com</a>.</div>";
	 echo "</div>";
	 include 'layout/endlayout.php';
	 $_SESSION['ignore'] = true;
	 }else{
	 unset($_SESSION['ignore']);
	 }
if (isset($_SESSION['code'])){
	$code = $_SESSION['code'];
	}
unset($_SESSION['code']);

if (isset($_POST['email'])){
// when page is refreshed, $_post values are empty so we don't want to overwrite the sesion values with empty $_posts
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] =  md5($_POST['password']);
	$_SESSION['schstate'] =  $_POST['schstate'];
	$_SESSION['schname'] =  $_POST['schname'];
	$_SESSION['email'] =  $_POST['email'];
	$_SESSION['location'] = $_POST['location'];
	$_SESSION['subscription'] =  $_POST['subscription'];
	$_SESSION['couponcode'] = $_POST['couponcode'];
}
?>


<div align="center">

<?php
if ((isset($code) and isset($_POST['valcode'])) and ($_POST['valcode'] == $code)) {
// if we have a session code and a user-entered code, and both are the same, then activate the user's account
  if (account_exists($_SESSION['email'])){
		 echo "Account has already been created or is pending activation<br>Click <a href='register.php'>here</a> to go back.";
		 exit;
	}
	$_SESSION['regcode'] = $code;
	if (isset($_SESSION['regcode'])){
		$salt = generate_salt();
		$psswd = md5($_SESSION['password'] . $salt);
		$res = setup_user_account($_SESSION['regcode'], $_SESSION['name'], $_SESSION['username'], $psswd, $_SESSION['schstate'], $_SESSION['schname'], $_SESSION['email'], $_SESSION['location'], $_SESSION['subscription'], $_SESSION['couponcode'], $salt);
		if ($res){
		    $page_title = "Registration";
            include 'layout/startlayout.php';
            ?>
            

            <div class="nav"><br>
            &nbsp; Payment
            </div>
            <div class="page_info">
        		<?
				echo "<div align='center'>";
                if ($_SESSION['subscription'] != -1){
				    echo "Below is your account information. Please pay now to complete the registration process. <br><br>";
                }else{
                    echo "Registration Complete! Below is your account information.<br/><br/>";
                }
				
				//paypal form for payment
				$query = "select price, discount from subscriptions where duration = " . $_SESSION['subscription'] . " LIMIT 1";
				$res = mysql_fetch_array(mysql_query($query));
				$subsc_price = (float)$res['price'];

				//display account information
				?>
				<div><table style='font-size:1em;' cellpadding='3px'>
				<tr><td align='right'><b>Name:</b></td><td><?echo $_SESSION['name'];?></td></tr>
				<tr><td align='right'><b>Login ID:</b></td><td><?echo $_SESSION['username']?></td></tr>
				<tr><td align='right'><b>School State:</b></td><td><?echo $_SESSION['schstate'];?></td></tr>
				<tr><td align='right'><b>School Name:</b></td><td><?echo $_SESSION['schname'];?></td></tr>
				<tr><td align='right'><b>E-mail:</b></td><td><?echo $_SESSION['email']?></td></tr>
				<tr><td align='right'><b>Location:</b></td><td><?echo $_SESSION['location'];?></td></tr>
				<tr><td align='right'><b>Subscription:</b></td><td><? if ($_SESSION['subscription'] == -1) { echo "Free Trial (expires 01/01/2010)"; } else { echo $_SESSION['subscription'] . " Year(s)"; }?></td></tr>
				<tr><td align='right'><b>Price:</b></td><td><?echo '$'.$subsc_price;?></td></td>
				<?

				// if a valid coupon was entered, recalculate the subscription price
                $discount = -1;

				if (!empty($_SESSION['couponcode'])){
					 $discount = (float)$res['discount'];
					 ?>
					 <tr><td align='right'><b>Discount:</b></td><td><?echo $discount;?>%</td></tr>
					 <?
				}
				?>
				</table></div><br>
				<?			

				if ($_SESSION['subscription'] != -1){
    				print "<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
    				<input type='hidden' name='cmd' value='_xclick'>
    				<input type='hidden' name='business' value='payment@collegebookevolution.com'>
    				<input type='hidden' name='item_number' value='" . $_SESSION['subscription'] . "-Year Subscription (" . $_SESSION['regcode'] . ")'>
    				<input type='hidden' name='item_name' value='College Book Evolution Account: "  . $_SESSION['username'] . "'>
    				<input type='hidden' name='currency_code' value='USD'>";

                    $tax = round(($subsc_price * 0.06), 2);
                    if ($discount > 0){
                        $discount_value =  round($subsc_price * ($discount/100), 2);
                        echo "<input type='hidden' name='discount_amount' value='" . $discount_value . "'>";
                        $tax = round((($subsc_price - $discount_value) * 0.06), 2);
                    }

                    print "<input type='hidden' name='amount' value='$subsc_price'>
                    <input type='hidden' name='tax' value='" . $tax . "'>
                    <input type='hidden' name='image_url' value='http://www.collegebookevolution.com/images/page/full_logo.png'>
    				<input type='image' src='http://www.paypal.com/en_US/i/btn/x-click-but01.gif'
    				name='submit' alt='Make payments with PayPal - it\'s fast, free and secure!'>
    				</form>";
    				echo "<br/><br/><b>Note:</b> Tax and discount, if any, will be applied once you have been directed to Paypal. <br/><br/>
                         Please allow up to <b>2 business days</b> for your account to be activated after payment has been recieved.<br/>You will receive an email when your account has been activated.</div></div>";
                }else{
                    echo "<br/><br/>Please allow up to <b>2 business days</b> for your account to be activated. You will receive an email once activation is complete. ".
                         "<br/>If you benefit from the free trial period, support the evolution by Signing Up for a Subscription, so that we can continue to improve and develop services for college students. " .
                         "<br/>Also note that the trial period ends on <b>12/27/2009</b>.<br/><br/>Return to <a href='http://www.collegebookevolution.com'>Home</a></div></div>";
                }
				include 'layout/endlayout.php';
			}
	}
	else{
		echo "Account cannot be confirmed. Please click <a href='http://www.collegebookevolution.com'>here</a> to return to the home page";
	}
}
else{
    if (!isset($_SESSION['ignore'])){

        // generate validation code
        $random = rand(10000, 99999);
        $_SESSION['code'] = $random;
        $mail = $_SESSION['email'];
        //echo "validation code = "  . $random . " ";
    	if (send_validation_code($mail, $random)){
        	  echo  "A validation code has been sent to the email address you provided:<br><br><b>" . $mail . "</b><br><br>Please enter the code in the box below to proceed.<br/>(Don't close this window)<br/><br/>";
        	  echo  "<form name='valform' action='validate.php' method='post' target='_self' onSubmit='if (document.valform.valcode.value != \"" . $_SESSION['code'] . "\") { alert(\"Invalid validation code.\"); return false;}'>" .
              		"Validation Code: <input type='text' id='valcode' name='valcode' /><br /><br /> " .
                    "<iframe width='100%' height='400px' style='border:0px;' src='legal/terms.html'><p>Click on the link below to view terms and agreement</p></iframe><br /><br />" .
              		"<input type='checkbox' name='termagree' value='Agree' onclick='this.form.s1.disabled=! this.checked;' />Agree to <a  href='legal' target='_blank'>terms</a><br /><br />".
              		"<input type='Submit' name='s1' id='s1' value='submit' disabled/>".
              		"</form>";
    	}
    	else{
    		echo "Unable to send validation code. Please check the email address '<b>" . $mail . "</b>' and try again";
    	}
	}
}
?>

