
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--************************************************************************-->
<!--* Revenge of the Menu Bar Demo                                         *-->
<!--*                                                                      *-->
<!--* Copyright 2000-2004 by Mike Hall                                     *-->
<!--* Please see http://www.brainjar.com for terms of use.                 *-->
<!--************************************************************************-->

<?php
session_start();
if(session_is_registered(theusername)){
header("location:welcome.php");
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="layout/master.css" />
<link rel="stylesheet" type="text/css" href="layout/sub.css" />
<link rel="SHORTCUT ICON" href="images/" />

<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />

<title>Marketer Central Login</title>
<script type="text/javascript" src="includes/explorer.js"></script>
<script type="text/javascript" src="includes/scripts.js"></script>
<style type="text/css">
table.sample {
	border-width: 1px;
	border-spacing: ;
	border-color: #A9F5F2;
	border-collapse: separate;
	background-color: white;
	font-family:Arial, Helvetica, sans-serif;
	font-size:0.8em;
}
table.sample th {
	border-width: 0px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: rgb(250, 240, 230);
	-moz-border-radius: ;
}
table.sample td {
	border-width: 0px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: #FFFF99;
	-moz-border-radius: 10px;
    -webkit-border-radius: 10px;
}
span#error{
  background-color: #FFCCCC;
}

.bottom_links a{
    text-decoration: none;
    color: black;
    padding: 3px;
}

.bottom_links a:hover{
    text-decoration: underline;
}


</style>

</head>

<body>
<div align='center'>
<a href='http://www.collegebookevolution.com'><img src='../images/cbe_logo.gif' border='0' alt='College Book Evolution' /></a>
<table class='sample'width=500px><tr><td>
<div align='center' style='margin-left:10px;'>
<h2>Marketing Team Central Login</h2>
</div>
</td></tr></table>
<!-- login table -->
<center>
<?php include ("main_login.php")?>
</center>
<!--end login table -->
<table class='sample'width=500px><tr><td>
<div align='center' style='margin-left:10px;'>
<span style='float: left; font-size: 11px;'>&copy; CollegeBookEvolution, LLC</span>
<span class='bottom_links' style='float:right; font-size: 11px;'><a href="http://www.collegebookevolution.com">Home</a> <a href="http://www.collegebookevolution.com/about">About Us</a> <a href="http://www.collegebookevolution.com/about/?ref=contact">Contact Us</a> <a href="http://www.collegebookevolution.com/help">Help</a> <a href="http://www.collegebookevolution.com/legal">Terms</a> <a href="http://www.collegebookevolution.com/legal/?ref=privacy">Policy</a></span>
</div>
</td></tr>
</table>
</body>
</html>