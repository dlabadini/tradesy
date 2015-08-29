<?php require_once('init_utils.php');?>

<?php
$class=$_GET["class"];
$number=$_GET["number"];

$bookid = $_GET['bkid'];			 
$book = get_book($bookid);

if ($bookid == -2){
	//select book from an existing class
?>
          <table><tr><td>
          <div style="margin-left:10px;">
		  <h3>Select a class:</h3>
		  <span id='subscript'>Pick a class the book is currently assigned to</span>

          <FORM NAME="myform" ACTION="" METHOD="GET">
			<table><tr><td >
           Department:
          <select id="classname2" onChange="loadCourseNumbers(this, 'nums2', 'classnum2');">
          <option>-- Select --</option>
          <?
          $sql = "SELECT distinct class_name, class_id FROM classes" . $_SESSION['schoolID'] . " group by class_name";
          $result = mysql_query($sql);
          while ($row = mysql_fetch_array($result)){
          			echo "<option value='" . $row['class_id'] . "'>" . $row['class_name'] . "</option>";
          }
          ?>
          </select>
          </td><td>
          Class:
          </td><td>
          <div id='nums2'>
          <select><option>--</option></select>
          </div>
          </td><td>
          
          
          <input name="button" type="button" 
          onclick="showBookSaveAs(document.getElementById('classname2'), document.getElementById('classnum2'), 'foundbook')" value="Show Book"/>
          </td></tr></table>
          </form>
          </div>
          </div>
          
          </td></tr></table>
          
          <p>
          <table><tr><td>
          <div name='top' id="foundbook" style="float:left; margin-left:40px;">
          </div>
          </td></tr></table>

<?php

} else {
	    echo "Please enter book information for this class and click on the <b><i>Save</i></b> button below when done...";
		$bkpic = $book['picture_url'];
		if (empty($bkpic)){
						$bkpic = "images/noimage.png";
		}
         ?>
		    <div style='float:left;'><br><img src='<? echo $bkpic ?>' width='80px' height='90px'/></div>
			<div>
			<table class='blueform' cellpadding='5px'>
		  	<tr valign='top'><td>
      		 <b>Title<sup style='color:red;'>*</sup></b><br><input type='text' size=80 id='title' value='<? echo $book['title'] ?>' /></td></tr><tr><td>
      		 <b>Authors<sup style='color:red;'>*</sup></b><br><input type='text' size=80 id='authors' value='<? echo $book['author'] ?>' /></td></tr><tr><td>
             <b>ISBN-13)</b><br><input type='text' size=80 id='isbn' value='<? echo $book['isbn'] ?>' /></td></tr><tr><td>
      		 Price (New)<sup style='color:red;'>*</sup><br>$ <input type='text' size=20 id='bknew' value='<? echo $book['bkstoreprice_new'] ?>' /></td></tr><tr><td>
      		 Price (Used)<br>$ <input type='text' readonly size=20 id='bkused' value='<? echo $book['bkstoreprice_used'] ?>' /><br><span id='subscript'><i>(automatically updated)</i></span></td></tr><tr><td>
      		 Picture URL<br><input type='text' size=80 id='pic_url' value='<? echo $book['picture_url'] ?>' /></td></tr>
      	<tr><td>
		    <input type='submit' name='savebook' value='Save'
    		 onClick='saveBookInfo(document.getElementById("classname"),
             document.getElementById("classnum"),
             document.getElementById("title").value,
             document.getElementById("authors").value,
             document.getElementById("isbn").value,
             document.getElementById("bknew").value,
             document.getElementById("bkused"),
             document.getElementById("pic_url").value, "result",
             document.getElementById("reqbooks"));' />
              </table></div>
          <?
	}

?>