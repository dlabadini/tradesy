<?require_once('init_utils.php');?>

<?php
$sql = "SELECT count(*) FROM members_books WHERE member_id = " . $_SESSION['userid'];
if (mysql_result(mysql_query($sql), 0, 0) >= 15){
    echo "<span id='notification'>You have added the maximum number of books permitted.</span>";
} else {
    $class=$_GET["class"];
    $number=$_GET["number"];

    $askprice = (float)$_GET['askprice'];
    $cond = $_GET['newused'];
    $ctype = $_GET['covertype'];
    $desc = $_GET['desc'];
    $bookid = $_GET['bid'];

    if (isset($bookid)){
    		$sql = "INSERT INTO `members_books`(`member_id`, `book_id`, `ask_price`, `newused`, `cover`, `comment`, `date_added`) VALUES ('" . $_SESSION['userid'] . "', '" . $bookid . "', '" . $askprice . "', '" . $cond . "', '" . $ctype . "', '" . $desc . "', '" . date("Y-m-d") . "')";
    		mysql_query($sql);
    		if (mysql_error() == ""){
    			echo "Book has been added<br />";
    		}else{
    			if (strpos(mysql_error(), "Duplicate") >= 0){
    				echo "Book has already been added<br />";
    			}else{
    				echo "Unable to add book<br>";
    			}
    		}
    	}
}
showBooks($_SESSION['userid']);
?>