<?php require_once('init_utils.php');?>


<?php
$class=$_GET["class"];
$number=$_GET["number"];

$classid = $_GET['cid'];
$bookid = $_GET['bkid'];

//get school id
$sql = "SELECT school_id FROM members WHERE member_id = " . $_SESSION['userid'];
$schid = mysql_result(mysql_query($sql), 0, 0);

$sql = "DELETE FROM schools_classes WHERE book_id = " . $bookid . " AND class_id = " . $classid . " AND school_id = " . $schid;
mysql_query($sql);
if (mysql_error() == ""){
	echo "Book has successfully been unassigned to the class.";
} else{
echo "<br/>Unable to unassign book at this time. Try again later.";
}
?>