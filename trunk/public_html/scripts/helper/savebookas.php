<?php require_once('init_utils.php');?>

<?php
$class=$_GET["class"];
$number=$_GET["number"];

$cid = get_classid($class, $number);  
if (isset($cid)){
 $bookids = get_class_books($_SESSION['userid'], $cid);
if (mysql_num_rows($bookids) == 0){
  echo "no books found";
}
else {
   echo "<h3>Select a book:</h3>";
   echo "<form name='saveasbooks'>";
   echo "<input type='radio' name='bookslist' id='-1' style='visibility:hidden;' />";
  		while ($book = mysql_fetch_array($bookids)){
  					echo '<input type="radio" name="bookslist" id=' . $book['book_id'] . ' />' . $book['title'] . '<br/>';
  			} // while
  	echo '<br/><input type="button" onClick="saveBookAsExisting(document.getElementById(\'classname\'), document.getElementById(\'classnum\'), document.saveasbooks.bookslist, \'result\');" value="Assign Book"/>';
  			echo "</form>";
  	}
}
?>