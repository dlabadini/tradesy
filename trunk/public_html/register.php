<?php
$page_title = "Registration";
require_once("includes/session.php");
require_once("includes/connection.php");
require_once("includes/functions.php");
include 'layout/startlayout.php';
?>


<div class="nav"><br>
  <span class='linkonwhite' style="float:left; margin-left:10px;">Registration Information</span>
  <span style="float:right; margin-right:10px;"><a class='linkonwhite' href='help'>Help</a></span>
</div>
<div class="page_info">
<? 
include 'forms/registration_form.php';
?>
</div>

<?php
include 'layout/endlayout.php';
?>