<!--
<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
-->
<?php
include '../includes/connection.php';
$page_title = "Account Info"; 
session_start();
if(!session_is_registered(theusername)){
header("location:index.php");
}
include 'layout/startlayout.php';
nav_menu($_SESSION['theusername'], 'home');
?>

<div class="page_info" >
<h2>Marketer Account</h2>
<div class='hrline'></div>
<p>
No account info present currently. Please check back later.
</p>

</div>

<?php
include 'layout/endlayout.php';
?>
