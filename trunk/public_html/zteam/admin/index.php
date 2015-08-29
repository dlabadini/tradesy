
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
<link rel="stylesheet" type="text/css" href="/layout/master.css" />
<link rel="stylesheet" type="text/css" href="/layout/sub.css" />
<link rel="SHORTCUT ICON" href="images/" />

<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />

<title>Employee Central Login</title>
<script type="text/javascript" src="/includes/explorer.js"></script>
<script type="text/javascript" src="/includes/scripts.js"></script>
</head>

<body>
<center>
<table>
<tr>
	<td>
		<div ><img src="/images/logo.png" alt="converge"/></div>
	</td>
</tr>
<tr>
</center>
<center>


<!-- login table -->

<?php include ("main_login.php")?>

<!-- end frame -->
</center>
</body>
</html>