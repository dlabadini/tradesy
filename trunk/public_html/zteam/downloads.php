<!--
<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
-->
<?php
$page_title = "Downloads";
session_start();
if(!session_is_registered(theusername)){
header("location:index.php");
}
include 'layout/startlayout.php';
nav_menu($_SESSION['theusername'], 'downloads');
?>

<div class="page_info" >
<h2>Downloads</h2>
<div class='hrline'></div>
<p>
<a href="downloads/salemflyer.pdf" target="_blank">Salem State FullSize Flyer</a>
</p>

</div>

<?php
include 'layout/endlayout.php';
?>
