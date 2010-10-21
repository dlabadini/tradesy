<?php
$root = $_SERVER["DOCUMENT_ROOT"];
if (strpos($root, "xampp") == false){
  require_once($root . "/includes/connection.php");
  //require_once($root . "/includes/session.php");
  require_once($root . "/includes/functions.php");
}else{
  //require_once("C:\\xampp\htdocs\cbe\public_html\includes/session.php");
  require_once("C:\\xampp\htdocs\cbe\public_html\includes/connection.php");
  require_once("C:\\xampp\htdocs\cbe\public_html\includes/functions.php");
}
?>


<?php
$state=$_GET["state"];
$elt = $_GET['elt'];
if ($elt == ""){
 $elt = "schname";
}
$sql = "SELECT school_name FROM schools WHERE state = '" . $state . "' ORDER BY school_name ASC";
$res = mysql_query($sql);

echo '<select class="textbox" name="schname">';
echo "<option selected>-- Select --</option>";
while ($row = mysql_fetch_array($res)){
   echo "<option>" . $row['school_name'] . "</option>";
  }
echo '</select>';

?>