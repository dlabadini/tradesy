<?php
    require_once('init_utils.php');

    $page_title = "CBE Classes | " . ucwords($_SESSION['fullname']);
    include 'layout/startlayout.php';
    nav_menu($_SESSION['username'], 'classes');
?>

<div class="page_info" >
<script type="text/javascript" src="scripts/classfunctions.js"></script>

<font size="5px"><strong>Classes</strong></font><br>
<div style=" margin-left:10px;">

	<li>
	<a href="javascript:;" onclick="togglediv('add_class');">Add Class</a>
	</li>

	<div id="add_class" style="display: none;" >

	<table><tr><td>
	<FORM NAME="myform" ACTION="" METHOD="GET">
	 Department:
	<select id="classname" onChange="loadCourseNumbers(this, 'nums');">
	<option>Select One</option>
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
	</td><td width='60px'>
	<div id='nums'>
	<select><option>--</option></select>
	</div>
	</td><td>

	<input name="button" type="button" onclick="addclass(document.getElementById('classname'), document.getElementById('classnum'), 'listclasses')" value="Add Class"/>
	</td></tr></table>
	</form>
	</div>

</div>
<br />
<div class='hrline'></div>
<table><tr><td>
<div id="listclasses">
<?php
//list user's classes
$classes = get_classes($_SESSION['userid']);
showClasses();
?>
</div>
</td></tr></table>

</div>

<?php
    include 'layout/endlayout.php';
?>