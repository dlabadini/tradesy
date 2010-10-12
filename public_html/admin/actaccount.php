<?php
require_once("../includes/connection.php");

function write_to_log($file, $msg){
    $myFile = $_SERVER['DOCUMENT_ROOT'] . "/admin/logs/" . $file . "_" . date("Y_m") . ".csv";
    $fh = fopen($myFile, 'a') or die("can't open file");
    fwrite($fh, $msg);
    fclose($fh);
}

function send_notification_email($to){
    $subject = "College Book Evolution Account Activated";
    $headers = "From: support@collegebookevolution.com\nReply-To: $replyto\nContent-Type: text/html";
    $message = "<html><body><font size='2' face='Verdana'>Hello,<br/>Your College Book Evolution account has been activated.<br/><br/>Please login at <a href='http://www.collegebookevolution.com'>www.collegebookevolution.com</a>" .
               "<br/><br/>Thank you,<br/>College Book Evolution</font></body></html>";
    if (mail($to, $subject, $message, $headers)){
        echo "<br/>Notification has been sent to <b>" . $to . "</b>";
    }else{
        echo "<br/>Failed to send notification to <b>" . $to . "</b>. Please send it manually";
    }
}


$q=(int)$_GET["q"];

$sql="SELECT * FROM pending_subscriptions WHERE reg_id = $q";

$result = mysql_query($sql);

while($row = mysql_fetch_array($result))
  {

	// add member
  $sql = "INSERT INTO members(member_id, name, username, password, school_id, email, location, salt) values (" . $row['member_id'] . ", '" . $row['name'] . "', '" . $row['username'] . "', '" . $row['password'] . "', " .  $row['school_id'] . ", '" . $row['email'] . "', '" . $row['location'] . "', '" . $row['salt'] . "')";
  $mquery = mysql_query($sql);
  if ($mquery){
	  echo "Account for <b>" . ucfirst($row['name']) . "</b> (User ID: " . $row['member_id'] . ") hass be successfully activated<br>";
	  mysql_query("DELETE FROM pending_subscriptions WHERE reg_id = $q");
          $msg = "\n" . $q . ", " . $row['name'] . ", " . $row['email'] . ", " . date("Y-m-d H:i:s");
          write_to_log("activated_accounts", $msg);


		//check coupon discount
		$query = "select price, discount from subscriptions where subscription_id = " . $row['subscription_id'] . " LIMIT 1";
		$res = mysql_fetch_array(mysql_query($query));
		$subsc_price = (float)$res['price'];

		if (!empty($row['coupon'])){
			 $discount = (float)$res['discount'];
			 $subsc_price = $subsc_price - ($subsc_price * ($discount/100));
			 $subsc_price = round($subsc_price, 2);

			 //increment coupon users for member id
			 mysql_query("UPDATE mk_coupons SET users = users + 1 WHERE coupon = '" . $row['coupon'] . "'");
			 }

	  // add to member_subscriptions table
	  $sql = "INSERT INTO member_subscriptions(subscription_id, member_id, start_date, account_status, amount_paid, coupon) values (" . $row['subscription_id'] . ", " . $row['member_id'] . ", '" . date("Y-m-d") . "', 1, " . $subsc_price . ", '" . $row['coupon'] . "' )";
	  $squery = mysql_query($sql) or die(mysql_error());
	  if ($squery){
		  echo "Subscription information has been successfully added<br>";

          //send email
          send_notification_email($row['email']);
	  }else{
		  echo "Unable to add subscription information<br>";
	  }

      // add member to members_prefs table
      $sql = "INSERT INTO members_prefs(member_id) VALUES (" . $row['member_id'] . ")";
      mysql_query($sql);
  }else{
	  echo "Unable to activate account for user with registration ID " . $q . " - " . mysql_error() . "<br>";
  }
 }
echo "</table>";
?>