<?php
require_once("../includes/connection.php");

$q=$_GET["q"];

$sql = "UPDATE member_subscriptions SET account_type = (SELECT tid FROM account_types WHERE name = 'marketer')";
mysql_query($sql);
if (mysql_error() == ""){
    echo "<b>" . $q . "</b> is now a markter";
} else {
    echo "Unable to make " . $q . " a marketer";
}
$sql = "INSERT INTO mk_coupons(member_id) VALUES ((SELECT member_id FROM members WHERE username = '" . $q . "'))";
mysql_query($sql);
if (mysql_error() == ""){
    echo " and will be given a coupon during the next cycle";
} else {
    echo " failed to make " . $q . " eligible for coupons. Please try again later or do it manually";
}
?>