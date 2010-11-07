<?php
/**
Filename: books.php
URL: www.collegebookevolution.com/account.php
Author: William Mensah (www.wilmens.net)
Date Created: 12/2009
Last Modified: 07/2010

Purpose:
	- Responsible for displaying all books the user currently owns.
	- Provides funtionality for users to add/remove/edit books to/in their possession
	
Requires:
	- init_utils.php
	- scripts/classfunctions.js
	- layout/startlayout.php
	- layout/endlayout.php
	
Optional POST parameters:
	- n/a

Functionalilty:
	This script simply loads the layout of the page, and creates buttons and other objects that enable users to add books.
	It then calls showBooks($userid) which prints out the books owned by the user, and also provides buttons/links for removing/editing the user's books
	
Function Calls:
	- showBooks($userid) (see: includes/functions.php)
	- loadCourseNumbers(object, id); (see: scripts/classfunctions.js)
	
*************************************************************************************************
*/

    require_once('init_utils.php');

    $page_title = "CBE Books | " . ucwords($_SESSION['fullname']);
    $lightbox = true;
    include 'layout/startlayout.php';
    nav_menu($_SESSION['username'], 'books');
?>


<div class="page_info" >

<script type="text/javascript" src="scripts/classfunctions.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!-- 

<!-- Begin
function Check(chk){
// Checks/Unchecks all check boxes on the page (for selecting/unselecting all books)
  if(document.booksform.checker.checked==true){
    for (i = 0; i < chk.length; i++)
    chk[i].checked = true ;
  }else{
    for (i = 0; i < chk.length; i++)
      chk[i].checked = false ;
    }
}


function limitText(limitField, limitCount, limitNum) {
// restrains the number of characters used in describing the book
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
// End -->
</script>


<font size="5px"><strong>Books</strong></font><br>
<table width='100%'><tr><td>
<div style="margin-left:10px;">
<li><a onclick="togglediv('add_book');" href="javascript:;">Add Book</a> .
<a href="findbook.php">Find Book</a> .
<a href='javascript:;' onClick='togglediv("add_credits");'>Add Credits</a></li>



<div class='action' id='add_credits' style='display:none; position:relative;'>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="CRWXL494AZHFS">
<table>
<tr><td><input type="hidden" name="on0" value="Credits"></td></tr><tr><td><select name="os0">
	<option value="1 Credit">1 Credit $1.50</option>
	<option value="2 Credits">2 Credits $3.00</option>
	<option value="3 Credits">3 Credits $4.50</option>
	<option value="4 Credits">4 Credits $6.00</option>
	<option value="5 Credits">5 Credits $6.25</option>
	<option value="10 Credits">10 Credits $10.00</option>
</select> </td></tr>
</table><br/>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form><table><tr><td>
</td><td>
</td><td width='60px'>
</td><td>
</td></tr></table>
</div>


<div id="add_book" style="display:none; ">
<table><tr><td>
<FORM NAME="myform" ACTION="" METHOD="GET">
 Department:
<select id="classname" onChange="loadCourseNumbers(this, 'nums');">
<option>Select One</option>

<?
// Get list of classes for user's school and populate the combo box with it

$sql = "SELECT distinct class_name, class_id FROM classes" . $_SESSION['schoolID'] . " group by class_name";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)){
			echo "<option value='" . $row['class_id'] . "'>" . $row['class_name'] . "</option>";
}
?>
</select>
</td><td>
Class:
</td><td width='60px'>
<div id='nums'>
<select><option>--</option></select>
</div>
</td><td>


<input name="button" type="button" 
onclick="showBook(document.getElementById('classname'), document.getElementById('classnum'), 'foundbook')" value="Show Books"/>
</td></tr></table>
</form>
</div>
</div>

</td></tr></table>

<p>
<table><tr><td>
<div name='top' id="foundbook">
</div>
</td></tr></table>
</p>

<div class='hrline'></div>

<table><tr><td>
<div id="listbooks">

<?php
//list user's books
showBooks($_SESSION['userid']);
?>
</div>
</td></tr>
</table>

</div>

<?php
    include 'layout/endlayout.php';
?>