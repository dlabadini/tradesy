<?php
session_start();
if(!session_is_registered(theusername)){
header("location:../index.php");
}
?>
<head><title>Project Resources</title></head>
<?php include ("../layout/startlayout.php")?>
<html>
<br/>
<br/>
<body>
<table table border="2" cellspacing="0" cellpadding="7" align="center" width="500">
  <tr>
    <td><b>First Name</b></td>
    <td><b>Last Name</b></td>
    <td><b>Email</b></td>
    <td><b>Phone</b></td>
    <td><b>Position</b></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td><a href='mailto:'>eMail</a></td>
    <td></td>
    <td></td>
  </tr>
    <tr>
    <td></td>
    <td></td>
    <td><a href='mailto:'>eMail</a></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td><a href='mailto:'>eMail</a></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
     <td></td>
    <td></td>
    <td><a href='mailto:'>eMail</a></td>
    <td></td>
    <td></td>
  </tr>
   <tr>
   <td></td>
    <td></td>
    <td><a href='mailto:'>eMail</a></td>
    <td></td>
    <td></td>
  </tr>
</table>

</body>
<?php include ("../layout/endlayout.php")?>	
</html>