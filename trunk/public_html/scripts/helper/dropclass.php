<?php require_once('init_utils.php');?>  


<?php
$class=$_GET["class"];
$number=$_GET["number"];

	$classes = $_GET['cid'];
	for ($i = 0; $i < sizeof($classes); $i++){
		$sql = "DELETE FROM members_classes WHERE class_id = " . $classes[$i] . " AND member_id = " . $_SESSION['userid'];
		mysql_query($sql);
		}
	showClasses($_SESSION['userid']);
?>