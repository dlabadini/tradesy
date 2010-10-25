<?php
require_once("../includes/connection.php");

function write_to_log($file, $msg){
    $myFile = $_SERVER['DOCUMENT_ROOT'] . "/admin/logs/" . $file . "_" . date("Y_m") . ".csv";
    $fh = fopen($myFile, 'a') or die("can't open file");
    fwrite($fh, $msg);
    fclose($fh);
}

function send_notification_email($to, $yrs){
    $subject = "College Book Evolution Account Activated";
    $headers = "From: support@collegebookevolution.com\nReply-To: $replyto\nContent-Type: text/html";
    $message = "<html><body><font size='2' face='Verdana'>Hello,<br/>Your College Book Evolution account has been upgraded to a " . $yrs . "-year subscription.<br/><br/>Please login at <a href='http://www.collegebookevolution.com'>www.collegebookevolution.com</a>" .
               "<br/><br/>Thank you,<br/>College Book Evolution</font></body></html>";
    if (mail($to, $subject, $message, $headers)){
        echo "<br/>Notification has been sent to <b>" . $to . "</b>";
    }else{
        echo "<br/>Failed to send notification to <b>" . $to . "</b>. Please send it manually";
    }
}


// Get variables from URL
$name=$_GET["q"];
$yrs = (int)$_GET["years"];

// get user info from pending_upgrades table
$sql="SELECT * FROM pending_upgrades WHERE username = '" . $name . "'";
$upgrade_info = mysql_fetch_array(mysql_query($sql)) or die("Member not found<br />" . mysql_error());

$sql = "SELECT name, member_id, email FROM members WHERE username = '" . $name . "'";
$userinfo = mysql_fetch_array(mysql_query($sql));

$query = "SELECT price, discount FROM subscriptions WHERE duration = " . $yrs . " LIMIT 1";
$res = mysql_fetch_array(mysql_query($query));

$subsc_price = (float)$res['price'];

if (!empty($upgrade_info['coupon'])){
  $discount = (float)$res['discount'];
  $subsc_price =  $subsc_price - round($subsc_price * ($discount/100), 2);

  // increment marketer with that coupon's # of users
  $sql = "UPDATE mk_coupons SET users = users + 1 WHERE coupon = '" . $upgrade_info['coupon'] . "'";
  mysql_query($sql);
}

// upgrade member
$sql = "UPDATE member_subscriptions SET subscription_id = " . $yrs .
       ", coupon = '" . $upgrade_info['coupon'] .
       "', account_type = 1, amount_paid = " . $subsc_price .
       ", start_date = '" . date("Y-m-d") .
       "' WHERE member_id = " . $userinfo['member_id'];
mysql_query($sql) or die("Unable to upgrade account<br />" . mysql_error());

echo "Account for <b>" . ucfirst($userinfo['name']) .
    "</b> (User ID: " . $name . ") has been upgraded to a " . $yrs .
    "-Year subscription<br>";

// extend class lock date if it has already been set
$clslock = FA_WEEKS_TILL_CLASS_LOCK;
$newdate = strtotime('+' . $clslock . ' week' , strtotime(date("Y-m-d")));
$newdate = date('Y-m-d' , $newdate);

$sql = "UPDATE class_lock SET lock_date = '" . $newdate . "' WHERE member_id = " . $userinfo['member_id'];
mysql_query($sql);

$sql ="DELETE FROM pending_upgrades WHERE username = '" . $name . "'";
mysql_query($sql);

$msg = "\n" . $userinfo['member_id'] . ", " . $name . ", " . $userinfo['email'] . ", " . date("Y-m-d H:i:s");
write_to_log("upgraded_accounts", $msg);

if (mysql_error() == ""){
  //send email
  send_notification_email($userinfo['email'], $yrs);
}
echo "</table>";
?>