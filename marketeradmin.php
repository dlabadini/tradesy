<?php
include 'init_utils.php';

if (strtolower($_SESSION['acctype']) != 'marketer'){
	header("location:index.php");
	exit;
}

$page_title = "CBE Marketing Team | " . ucwords($_SESSION['fullname']);
include 'layout/startlayout.php';
nav_menu($_SESSION['username'], 'marketer');
?>

<div class="page_info" >

<script type="text/javascript" src="scripts/classfunctions.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!-- 

<!-- Begin
function Check(chk)
{
if(document.classform.checker.checked==true){
for (i = 0; i < chk.length; i++)
chk[i].checked = true ;
}else{

for (i = 0; i < chk.length; i++)
chk[i].checked = false ;
}
}

function togglediv(divid){ 
if(document.getElementById(divid).style.display == 'none'){ 
document.getElementById(divid).style.display = 'block'; 
}else{ 
document.getElementById(divid).style.display = 'none'; 
} 
}

// End -->
</script>
<div >

<div id="add_class"  >

<table><tr><td>
<FORM NAME="myform" ACTION="" METHOD="GET">
 Department:
<select id="classname" height='10px' onChange="loadCourseNumbers(this, 'nums');">
<option>-- Select --</option>
<?
$sql = "SELECT distinct abrev, class_id FROM classes" . $_SESSION['schoolID'] . " group by class_name";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)){
			echo "<option value='" . $row['class_id'] . "'>" . $row['abrev'] . "</option>";
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


<input name="button" type="button" onclick="getClassBooks(document.getElementById('classname'), document.getElementById('classnum'), 'classbooks')" value="Show Books"/>
</td></tr></table>
</form>
</div>
</div><br>

<div class='hrline'></div>
<div id='classbooks' style="postition: absolute; margin-left:100px; width:700px;">
</div>
<div id='result' style="margin-right:50px; margin-left:10px; padding:5px; width:845px; background-color:#F5EFFB;">
<strong><font style='font-size:20px;'>College Book Evolution Marketing Team.</font></strong><p>This page allows you to add books to College Book Evolution that don't already exist
or edit those that do. Doing so will assign the book to the class selected above.
</p></div>
<table><tr><td>
<div id="bookInfo" style="position: absolute; margin-left:100px;">
</div>
</td></tr></table>

</div>

<?php
include 'layout/endlayout.php';
?>