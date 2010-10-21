<?php
session_start();
if(!session_is_registered(theusername)){
header("location:../index.php");
}
?>
<head><title>Project Resources</title></head>
<?php include ("../layout/startlayout.php")?>
<h2 class='content_heading'></h2>
<br/>
<br/>
<html>

Software Guides:
    <ul>
        <li><a href='mg.pdf' target="_blank">BusinessWare Modeling Guide</a></li>
    </ul>

eIV:
    <ul>
        <LI><a href='270_271.pdf' target="_blank">Health Care Eligibility Benefit
Inquiry and Response
(270/271)</a></li>
    </UL>
	
<?php include ("../layout/endlayout.php")?>	
</html>

