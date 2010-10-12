<? ob_start(); ?>
<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
$_SESSION= array();
    redirect_to("index.php");
?>
<? ob_flush(); ?>