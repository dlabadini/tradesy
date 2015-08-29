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
    <td>Jin</td>
    <td>Kim</td>
    <td><a href='mailto:jin@rhyan.com'>eMail</a></td>
    <td>703-885-6857</td>
    <td>President</td>
  </tr>
    <tr>
    <td>Jennifer</td>
    <td>Weaver</td>
    <td><a href='mailto:jennifer@rhyan.com'>eMail</a></td>
    <td>703-885-6989</td>
    <td>TechWriter</td>
  </tr>
  <tr>
    <td>Paul</td>
    <td>Megivern</td>
    <td><a href='mailto:paul@rhyan.com'>eMail</a></td>
    <td>703-885-6841</td>
    <td>Architect</td>
  </tr>
  <tr>
    <td>Ashish</td>
    <td>Upadhyaya</td>
    <td><a href='mailto:ashish@rhyan.com'>eMail</a></td>
    <td>703-885-6842</td>
    <td>Senior EAI Consultant</td>
  </tr>
   <tr>
    <td>Tony</td>
    <td>John</td>
    <td><a href='mailto:tjohn@rhyan.com'>eMail</a></td>
    <td>703-885-6813</td>
    <td>Senior EAI Consultant</td>
  </tr>
</table>

</body>

<?php include ("../layout/endlayout.php")?>

</html>