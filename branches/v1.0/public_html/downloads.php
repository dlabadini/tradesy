<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php
session_save_path("/home/users/web/b2287/sl.devinlab77/public_html/cgi-bin/tmp");
session_start();
if (!is_authed() or strtolower($_SESSION['acctype']) != 'marketer'){
	header("location:index.php");
	exit;
}
?>

<?php
$page_title = "CBE Downloads | " . ucwords($_SESSION['fullname']);
include 'layout/startlayout.php';
nav_menu($_SESSION['username'], 'downloads');
?>

<div class="page_info" >
<h2>Downloads</h2>
<div class='hrline'></div>
<p>
No downloads are available at the moment. Please check back later.
</p>

</div>

<?php
include 'layout/endlayout.php';
?>
