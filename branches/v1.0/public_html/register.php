<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$page_title = "Registration";
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