<?php require_once('init_utils.php');?>


<?php
$class=$_GET["class"];
$number=$_GET["number"];

$askprice = (float)$_GET['askprice'];
$cond = $_GET['newused'];
$ctype = $_GET['covertype'];
$desc = $_GET['desc'];
$classid = get_classid($class, $number);
$bookid = $_GET['bid'];

$sql = "UPDATE members_books SET ask_price=" . $askprice . ", newused='" . $cond .
 "', cover='" . $ctype . "', comment=\"" . stripcslashes($desc) . "\" WHERE member_id = " . $_SESSION['userid'] . " AND book_id = " . $bookid;
mysql_query($sql);

showBooks($_SESSION['userid']);
?>