<?php require_once('init_utils.php');?>


<?php
$class=$_GET["class"];
$number=$_GET["number"];

$cid = $_GET['class'];
$elt = $_GET['elt'];
if ($elt == ""){
 $elt = "classnum";
}
$sql = "SELECT class_number FROM classes" . $_SESSION['schoolID'] . " WHERE class_name = (SELECT class_name FROM classes" . $_SESSION['schoolID'] . " WHERE class_id = " . $cid . ")";
$res = mysql_query($sql);
echo "<select id='" . $elt . "' name='classnumber'>";
while ($row = mysql_fetch_array($res)){
   echo "<option>" . $row['class_number'] . "</option>";
  }
echo "</select>";

?>