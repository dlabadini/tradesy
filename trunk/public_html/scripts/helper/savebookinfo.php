<?php
require_once('init_utils.php');

$class=$_GET["class"];
$number=$_GET["number"];

$sql = "SELECT class_id FROM classes" . $_SESSION['schoolID'] . " WHERE abrev = '{$class}' AND class_number = '{$number}'";
$classid = mysql_result(mysql_query($sql), 0, 0);
$title = $_GET['title'];
$authors = $_GET['authors'];
$bknew = $_GET['bknew'];
$bkused = $bknew * 0.75;
$picurl = $_GET['picurl'];
$todo = $_GET['act'];

// see if book exists
//$sql = "SELECT book_id FROM schools_classes WHERE class_id = " . $classid;
//$bkid = mysql_result(mysql_query($sql), 0, 0);

if ($todo > 0){
 //book exists so update information, in this case the value of todo is the bookid
 $bkid = $todo;
 $sql = "UPDATE books" . $_SESSION['schoolID'] . " SET title='" . $title . "', author='" . $authors . "', picture_url='" . $picurl . "' WHERE book_id=" . $bkid;
 mysql_query($sql);
 echo "<span id='notification'>Book ";

// use marketer's school info to add book to that school
if (isset($_SESSION['schoolID'])){
	$sql = "UPDATE schools_classes SET bkstoreprice_new='{$bknew}', bkstoreprice_used='{$bkused}' WHERE school_id=" . $_SESSION['schoolID'] . " AND book_id={$bkid}";
	mysql_query($sql);
	echo " and class ";
} else {
	echo " (NOT class)";
}
echo " information has been updated. Please refresh the list of books by clicking on the 'Show Books' button</span>";


} else if ($todo == -1){ //adding new book

$sql = "INSERT INTO books" . $_SESSION['schoolID'] . "(title, author, picture_url) VALUES ('" . $title . "', '" . $authors . "', '" . $picurl . "')";
mysql_query($sql);
echo "<span id='notification'>Book ";
if (strpos(mysql_error(), "Duplicate") != false){
	 echo "Unable to add book. Perhaps it has already been assigned to the class</span>";
} else {
      // assign the book to the current class
      if (isset($_SESSION['schoolID'])){
      	 // get the book id again - there has to be an easier way to do this
      	 $sql = "SELECT book_id FROM books" . $_SESSION['schoolID'] . " WHERE title='{$title}' AND author='{$authors}' AND picture_url='{$picurl}'";
      	 $bkid = mysql_result(mysql_query($sql), 0, 0);
      		$sql = "INSERT INTO schools_classes VALUES (" . $_SESSION['schoolID'] . ", {$classid}, {$bkid}, '{$bknew}', '{$bkused}')";
            mysql_query($sql);
      	echo " and class";
      } else {
      	echo " (NOT class)";
      }
      echo " information has been added. Please refresh the list of books by clicking on the 'Show Books' button</span>";
	}
}
?>