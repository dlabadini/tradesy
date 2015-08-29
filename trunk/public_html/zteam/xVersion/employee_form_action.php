<html>
<br />
<center>

Employee: <?php echo $_POST["employee"]; ?>

<!--Below converts first project-->

    <?php $intSunday = (int)$_POST["sunday"]; ?>
    <?php $intMonday = (int)$_POST["monday"]; ?>
    <?php $intTuesday = (int)$_POST["tuesday"]; ?>
    <?php $intWednesday = (int)$_POST["wednesday"]; ?>
    <?php $intThursday = (int)$_POST["thursday"]; ?>
    <?php $intFriday = (int)$_POST["friday"]; ?>
    <?php $intSaturday = (int)$_POST["saturday"]; ?>

<!--Below converts second project-->

   <?php $intSunday2 = (int)$_POST["sunday2"]; ?>
    <?php $intMonday2 = (int)$_POST["monday2"]; ?>
    <?php $intTuesday2 = (int)$_POST["tuesday2"]; ?>
    <?php $intWednesday2 = (int)$_POST["wednesday2"]; ?>
    <?php $intThursday2 = (int)$_POST["thursday2"]; ?>
    <?php $intFriday2 = (int)$_POST["friday2"]; ?>
    <?php $intSaturday2 = (int)$_POST["saturday2"]; ?>
<br /><br />

<body>
 <table width="400" border="1" cellpadding="3" bordercolor=#rrggbb>
   <tr>
     <td><b><center></center></b></td>
     <td><b><center>Sunday</center></b></td>
     <td><b><center>Monday</center></b></td>
     <td><b><center>Tuesday</center></b></td>
     <td><b><center>Wednesday</center></b></td>
     <td><b><center>Thursday</center></b></td>
     <td><b><center>Friday</center></b></td>
     <td><b><center>Saturday</center></b></td>

   </tr>
   <tr>
     <td><b><center><?php echo $_POST["project"]; ?></center></b></td>
     <td><center><?php echo $_POST["sunday"]; ?></center></td>
     <td><center><?php echo $_POST["monday"]; ?></center></td>
     <td><center><?php echo $_POST["tuesday"]; ?></center></td>
     <td><center><?php echo $_POST["wednesday"]; ?></center></td>
     <td><center><?php echo $_POST["thursday"]; ?></center></td>
     <td><center><?php echo $_POST["friday"]; ?></center></td>
     <td><center><?php echo $_POST["saturday"]; ?></center></td>
        <td><center><b>
      <?php
$a = array($intSunday, $intMonday, $intTuesday, $intWednesday, $intThursday, $intFriday, $intSaturday);
echo "" . array_sum($a) . "\n";
?>
        </b></center></td>

   </tr>
   <tr>
     <td><b><center><?php echo $_POST["project2"]; ?></center></b></td>
     <td><center><?php echo $_POST["sunday2"]; ?></center></td>
     <td><center><?php echo $_POST["monday2"]; ?></center></td>
     <td><center><?php echo $_POST["tuesday2"]; ?></center></td>
     <td><center><?php echo $_POST["wednesday2"]; ?></center></td>
     <td><center><?php echo $_POST["thursday2"]; ?></center></td>
     <td><center><?php echo $_POST["friday2"]; ?></center></td>
     <td><center><?php echo $_POST["saturday2"]; ?></center></td>
     <td><center><b>
      <?php
$b = array($intSunday2, $intMonday2, $intTuesday2, $intWednesday2, $intThursday2, $intFriday2, $intSaturday2);
echo "" . array_sum($b) . "\n";
?>
    </b></center></td>
   </tr>

   <tr>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td><center><b>   <?php
$c = array(array_sum($a), array_sum($b));
echo "" . array_sum($c) . "\n";
?>
        </b></center></td>
 </table>

<?php
$myString0 = "Time Sheet for: " . $_POST["employee"];
$myString1 = "Project Name: " . $_POST["project"] .  "...\nTotal Hours:" . array_sum($a) . "\n";
$myString2 = "\nProject Name: " . $_POST["project2"] .  "...\nTotal Hours:" . array_sum($b) . "\n";
$myString3 = "\n\nTotal Week Hours: " . array_sum($c) . "\n";
$myString4 = "\n\nComments & Updates: " . $_POST["comments"];
$myString5 = $myString1.$myString2.$myString3.$myString4;


?>
<br/>
<table align="center">
<tr>
  <td width="120" align="right" valign="middle">Comments<br/>& Updates:</td>
  <td><textarea input type="text" name="comments" rows="5" cols="40">
  <?php echo $_POST["comments"]; ?>
  </textarea></td>
</tr>
 </table>

<br/><br/>
<?php
 $to = "chsnmyrhoades88x@gmail.com";
 $subject = $myString0;
 $body = $myString5;
 if (mail($to, $subject, $body)) {
   echo("<p>Message successfully sent! <br/><br/> You will most likely recieve a paycheck this week.</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }
 ?>


</body>
</center>
</html>
