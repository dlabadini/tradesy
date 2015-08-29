<?php require_once('init_utils.php');?>

<html>
<head>
<title>CBE Upgrade</title>
<style type="text/css">
table.sample {
	border-width: 1px;
	border-spacing: ;
	border-color: #A9F5F2;
	border-collapse: separate;
	background-color: white;
	font-family:Arial, Helvetica, sans-serif;
	font-size:0.8em;
}
table.sample th {
	border-width: 0px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: rgb(250, 240, 230);
	-moz-border-radius: ;
}
table.sample td {
	border-width: 0px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: #FFFF99;
	-moz-border-radius: 10px;
    -webkit-border-radius: 10px;
}
span#error{
  background-color: #FFCCCC;
}

.bottom_links a{
    text-decoration: none;
    color: black;
    padding: 3px;
}

.bottom_links a:hover{
    text-decoration: underline;
}


</style>
</head>
<body>
<div align='center'>
<a href='http://www.collegebookevolution.com'><img src='images/cbe_logo.gif' border='0' alt='College Book Evolution' /></a>

<table class='sample'width=500px><tr><td>
<div align='center' style='margin-left:10px;'>
<h2>Upgrade Your Account</h2>
<p>

<?

function print_form(){
?>
<form method="post" action="<?php echo $PHP_SELF;?>">

		<?php
        $sql = "SELECT 1 FROM pending_upgrades WHERE username = '" . $_SESSION['username'] . "'";
        if (mysql_result(mysql_query($sql), 0, 0)){
          echo "<div style='background-color: #FFCCCC; margin-right: 10px;'>Our records indicate that you previously attempted to upgrade your account.<br />If you completed payment, please wait for your account to be upgraded.</div><br />";
        }
		$sql = "SELECT duration, price, comment FROM subscriptions";
		$subs = mysql_query($sql);
		while ($row = mysql_fetch_array($subs)){
                    if ($row['duration'] > 0){
					    echo '<input class="nodec" name="subscription" type="radio" value="' . $row['duration'] . '" />' . $row['duration'] . ' Year - <b>$' . $row['price'] . '</b> <i>' . $row['comment'] . '</i><br />';
                    }
		}
		?>

<br />
Coupon: <input class="textbox" name="coupon" type="text" /> <a href='http://www.collegebookevolution.com/help/?ref=faqs#coupons' target='_blank'>what's this?</a>
<br /><br />
<input type='submit' name='submit' value='Continue' />
</form>
<?
}

function info_valid(){

    if (!isset($_POST['subscription'])){
      echo "<span id='error'>Please choose a subscription</span>";
    }else if (!empty($_POST['coupon'])){
      	 $query = "SELECT member_id FROM mk_coupons WHERE coupon = '" . $_POST['coupon'] . "' LIMIT 1";
         $res = mysql_fetch_array(mysql_query($query));
         if (count($res)){
            $mkid = $res['member_id'];
         }
      	 if (empty($mkid)){
      	 		echo "<span id='error'>Invalid coupon code</span>";
    	 } else {
            	 $sql = "SELECT state, school_name FROM schools WHERE school_id = (SELECT school_id FROM members WHERE member_id = " . $_SESSION['userid'] . ")";
                    $res = mysql_query($sql);
                    if (mysql_num_rows($res) > 0){
                        $schinfo = mysql_fetch_array($res);
                    }

            	 //coupon code is valid but make sure it's for the right school
            	 if (!couponValidSchool($schinfo['state'], $schinfo['school_name'], $mkid)){
            		 echo "<span id='error'>Coupon is not valid for your school '<b>" . $schinfo['school_name'] . ", " . $schinfo['state'] . "</b>'</span>";
            	 }else{
            	   return true;
            	 }
      	}
    }else{
      return true;
    }
}

if (subscription_type($_SESSION['userid']) > 0){
  echo "<span id='error'>You can't upgrade from a paid account</span><br /><br />Return to <a href='index.php'>Home</a>";
}else if (isset($_POST['submit'])){
  if (info_valid()){

    $regdate = date("Y-m-d H:i:s");
    $sql = "SELECT 1 FROM pending_upgrades WHERE username = '" . $_SESSION['username'] . "'";
    if (mysql_result(mysql_query($sql), 0, 0)){
        echo "<div style='background-color: #FFCCCC; margin-right: 10px;'>Our records indicate that you previously attempted to upgrade your account.<br />If you completed payment, please wait for your account to be upgraded.</div><br />";
    }

    // add upgrade information to database
    $sql = "INSERT INTO pending_upgrades(username, reg_date, coupon) VALUES ('" . $_SESSION['username'] . "', '" . $regdate . "', '" . $_POST['coupon'] . "')";
    mysql_query($sql);
    if (mysql_error() != ""){ // upgrade has already been requested so update info - user must have refreshed the page or something...ugh
        $sql = "UPDATE pending_upgrades SET reg_date = '" . $regdate . "', coupon = '" . $_POST['coupon'] . "' WHERE username = '" . $_SESSION['username'] . "'";
        mysql_query($sql) or die("Unable to process your information. Please try upgrading later.");
    }

    if (mysql_error() == ""){

                //paypal form for payment
				$query = "select price, discount from subscriptions where duration = " . $_POST['subscription'] . " LIMIT 1";
				$res = mysql_fetch_array(mysql_query($query));
				$subsc_price = (float)$res['price'];


				//display account information
				?>
				<div><table style='font-size:1em;' cellpadding='3px'>
				<tr><td align='left'><b>Name:</b></td><td><?echo ucwords($_SESSION['fullname']);?></td></tr>
				<tr><td align='left'><b>Login ID:</b></td><td><?echo $_SESSION['username']?></td></tr>
    			<tr><td align='left'><b>Subscription:</b></td><td><? echo $_POST['subscription'] . " Year(s)" ?></td></tr>
				<tr><td align='left'><b>Price:</b></td><td><?echo '$'.$subsc_price;?></td></tr>
				<?

				// if a valid coupon was entered, recalculate the subscription price
                $discount = -1;

				if (!empty($_POST['coupon'])){
					 $discount = (float)$res['discount'];
					 ?>
					 <tr><td align='left'><b>Discount:</b></td><td><?echo $discount;?>%</td></tr>
                     <?
				}
				?>
				</table></div><br>
				<?
  				print "<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
  				<input type='hidden' name='cmd' value='_xclick'>
  				<input type='hidden' name='business' value='payment@collegebookevolution.com'>
  				<input type='hidden' name='item_number' value='" . $_POST['subscription'] . "-Year Subscription'>
  				<input type='hidden' name='item_name' value='College Book Evolution Account Upgrade: "  . $_SESSION['username'] . "'>
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

  				echo "<br/><br/><b><div style='text-align: left;'>Note:</b> Tax and discount, if any, will be applied once you have been directed to Paypal. <br/><br/>
                       Please allow up to <b>2 business days</b> for your account
                       to be activated after payment has been recieved.</div></div></div>";
    }else{
      echo "<span id='error'>Unable to process your information at this time. Please try upgrading again later.</span>";
    }
  }else{
    print_form();
  }

}else{
  print_form();
}
?>
</p>
</div>
</td></tr></table><br />
<table class='sample'width=500px><tr><td>
<div align='center' style='margin-left:10px;'>
<span style='float: left; font-size: 11px;'>&copy; CollegeBookEvolution, LLC</span>
<span class='bottom_links' style='float:right; font-size: 11px;'><a href="welcome.php">Home</a> <a href="about">About Us</a> <a href="about/?ref=contact">Contact Us</a> <a href="help">Help</a> <a href="legal">Terms</a> <a href="legal/?ref=privacy">Policy</a></span>
</div>
</td></tr>
</table>
</div>
</body>
</html>