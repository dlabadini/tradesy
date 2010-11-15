<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
session_start();
if(!session_is_registered(adminusername)){
header("location:index.php");
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../layout/master.css" />
<link rel="SHORTCUT ICON" href="images/" />

<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />

<title>Employee Central</title>
<script type="text/javascript" src="../includes/explorer.js"></script>
<script type="text/javascript" src="../includes/scripts.js"></script>
</head>
<?php include ("../layout/startlayout.php")?>

<body>



Welcome Admin.






</body>
</html>

<?php include ("../layout/endlayout.php")?>