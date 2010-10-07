<?php
require_once('init_utils.php');

$class=$_GET["class"];
$number=$_GET["number"];

	//$cid = get_classid($class, $number);
    $sql = "SELECT class_id FROM classes" . $_SESSION['schoolID'] . " WHERE abrev = '{$class}' AND class_number = '{$number}'";
    $cid = mysql_result(mysql_query($sql), 0, 0);
	if (isset($cid)){  //one or more books found so display in drop down
  	$bookids = get_class_books($_SESSION['userid'], $cid);
	            ?>
				<p><h2>Edit book or add new book</h2><span id='subscript'>
                    Select a book to edit or assign a new book to the selected class
                </span><br>
				<select id='reqbooks' style='width:400px;'>

                <?php
				while ($book = mysql_fetch_array($bookids)){
									 echo "<option value=" . $book['book_id'] . ">" . $book['title'] . "</option>";
				}
                ?>
                
			   <option value=-3 disabled>--- Select Action ---</option>
			   <option value=-1>Assign new book</option>
			   <option value=-2>Assign book from another class</option></select>
			   <input type="button" onClick="loadBookInfo(document.getElementById('reqbooks'), 'result');" value="Continue" />
			   <input type="button" onClick="unassignClassBook('<? echo $cid ?>', document.getElementById('reqbooks'), 'result');" value="Unassign Book" />
			   <br/><br/></p>
               <?
				
		}
?>