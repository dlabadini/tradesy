<?php require_once('init_utils.php');?>

<?php
$class=$_GET["class"];
$number=$_GET["number"];
$action=$_GET["action"];

//$cid = get_classid($class, $number);
$sql = "SELECT class_id FROM classes WHERE abrev = '{$class}' AND class_number = '{$number}'";
$cid = mysql_result(mysql_query($sql), 0, 0);
$bookid = $_GET['bkid'];

//get school id
$sql = "SELECT school_id FROM members WHERE member_id = " . $_SESSION['userid'];
$schid = mysql_result(mysql_query($sql), 0, 0);

//get bookstore price
$sql = "SELECT * FROM schools_classes WHERE book_id = " . $bookid . " AND school_id = " . $schid . " LIMIT 1";
$prices = mysql_fetch_array(mysql_query($sql));

$sql = "INSERT INTO schools_classes VALUES ({$schid}, {$cid}, {$bookid}, '" . $prices['bkstoreprice_new'] . "', '" . $prices['bkstoreprice_used'] . "')";
mysql_query($sql);

if (mysql_error() == ""){
	echo "Book has successfully been assigned to the class. Click 'Book Info' to refresh the list of books";
} else {
 echo "<br />An error occured";
if (strpos(mysql_error(), "Duplicate") >= 0){
	 echo ": Book has already been assigned to the class";
}
}		
?>