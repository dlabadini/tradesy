<?require_once('init_utils.php');?>

<?php
$sql = "SELECT bought, used FROM members_credits WHERE member_id = " . $_SESSION['userid'];
$res = mysql_fetch_array(mysql_query($sql));
if ($res['bought'] == $res['used']){
    echo "<span id='notification'>You don't have any book credits available. Get some <a href='add_credits.php'>here</a>.</span>";
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
    		    mysql_query("UPDATE members_credits SET used=used+1 WHERE member_id=" . $_SESSION['userid']);
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