<?php
require_once("../includes/connection.php");

function addtomsg($table){
    $str = "";
    if (mysql_error() == ""){
        $str = "delete from $table table - ok<br />";
    }else{
        $str = "<span style='color: red;'>delete from $table table - failed</span><br />";
    }
    return $str;
}

// Get variables from URL
$name=$_GET["q"];

// Get member_id
$sql = "SELECT member_id FROM members WHERE username = '" . $name . "'";
$userid = mysql_result(mysql_query($sql), 0, 0);

if (empty($userid)){
  echo "Member does not exist";
  exit;
}

$msgs = "";

$tables = array("members", "members_books", "members_classes", "class_locks", "members_contacts", "members_prefs", "member_subscriptions", "mk_coupons", "password_resets", "pending_subscriptions", "pending_upgrades", "recent_ranks");
for($i = 0; $i < count($tables); $i++){
    // remove from members table
    $sql = "DELETE FROM " . $tables[$i] . " WHERE member_id = " . $userid;
    mysql_query($sql);

    $msgs .= addtomsg($tables[$i]);
}

// delete contacts made to user
$sql = "DELETE FROM members_contacts WHERE seller_id = " . $userid;
mysql_query($sql);
if (mysql_error() == ""){
  $msgs .= "delete contacts made to seller - ok<br />";
}else{
  $msgs .= "delete contacts made to seller - failed<br />";
}

echo $msgs;

?>