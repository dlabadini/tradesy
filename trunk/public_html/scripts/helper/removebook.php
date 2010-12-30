<?php require_once('init_utils.php');?>


<?php
$class=$_GET["class"];
$number=$_GET["number"];
$books = $_GET['bid'];

	for ($i = 0; $i < sizeof($books); $i++){    //start from 1 because $books[0] = -1
		$sql = "DELETE FROM members_books WHERE book_id = " . $books[$i] . " AND member_id = " . $_SESSION['userid'];
		mysql_query($sql); 
	}
	showBooks($_SESSION['userid']);
?>