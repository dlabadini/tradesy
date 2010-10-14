<!--
<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
-->
<?php
$page_title = "Contacts"; 
session_start();
if(!session_is_registered(theusername)){
header("location:index.php");
}
include 'layout/startlayout.php';
nav_menu($_SESSION['theusername'], 'downloads');
?>

<div class="page_info" >
<h2>Contacts</h2>
<div class='hrline'></div>
<p>
No contacts are available at the moment. Please check back later.
</p>

</div>

<?php
include 'layout/endlayout.php';
?>
