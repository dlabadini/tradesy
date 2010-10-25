<?php
session_start();
if(!session_is_registered(theusername)){
header("location:../index.php");
}
?>


<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Converge Technologies, Employee, Timesheet, Timetable">
<meta name="keywords" content="Converge Technologies, Employee, Timesheet, Timetable">
<title>Employee Central</title>
</head>
<?php include ("../layout/startlayout.php")?>
<html>
	<br/><center>
		<?php $today1 = date("D, F j, Y, g:i a"); echo $today1;?>
	<br/>
<!--
<?php echo $_POST["range"]; ?><br/><br/>
<?php echo $_POST["employee"]; ?><br/><br/>-->

<!--Below converts projects-->

<?php
$projectArray1 = $_POST['project1'];
$projectArray2 = $_POST['project2'];

$project1ID =   substr($projectArray1['projectname'], 0, strpos($projectArray1['projectname'],"-"));
$project1Name = substr($projectArray1['projectname'], strpos($projectArray1['projectname'],"-") +1);
$intP1Sunday = $projectArray1['sunday'];
$intP1Monday = $projectArray1['monday'];
$intP1Tuesday = $projectArray1['tuesday'];
$intP1Wednesday = $projectArray1['wednesday'];
$intP1Thursday = $projectArray1['thursday'];
$intP1Friday = $projectArray1['friday'];
$intP1Saturday = $projectArray1['saturday'];

$project2ID =   substr($projectArray2['projectname'], 0, strpos($projectArray2['projectname'],"-"));
$project2Name = substr($projectArray2['projectname'], strpos($projectArray2['projectname'],"-") +1 );
$intP2Sunday = $projectArray2['sunday'];
$intP2Monday = $projectArray2['monday'];
$intP2Tuesday = $projectArray2['tuesday'];
$intP2Wednesday = $projectArray2['wednesday'];
$intP2Thursday = $projectArray2['thursday'];
$intP2Friday = $projectArray2['friday'];
$intP2Saturday = $projectArray2['saturday'];
?>

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
     <td><b><center><?php echo $project1Name; ?></center></b></td>
     <td><center><?php echo $intP1Sunday; ?></center></td>
     <td><center><?php echo $intP1Monday; ?></center></td>
     <td><center><?php echo $intP1Tuesday; ?></center></td>
     <td><center><?php echo $intP1Wednesday; ?></center></td>
     <td><center><?php echo $intP1Thursday; ?></center></td>
     <td><center><?php echo $intP1Friday; ?></center></td>
     <td><center><?php echo $intP1Saturday; ?></center></td>
        <td><center><b>
      <?php
$a = array($intP1Sunday, $intP1Monday, $intP1Tuesday, $intP1Wednesday, $intP1Thursday, $intP1Friday, $intP1Saturday);
echo "" . array_sum($a) . "\n";
?>
        </b></center></td>
	   </tr>
	   <tr>
        <td><b><center><?php echo $project2Name; ?></center></b></td>
        <td><center><?php echo $intP2Sunday; ?></center></td>
        <td><center><?php echo $intP2Monday; ?></center></td>
        <td><center><?php echo $intP2Tuesday; ?></center></td>
        <td><center><?php echo $intP2Wednesday; ?></center></td>
        <td><center><?php echo $intP2Thursday; ?></center></td>
        <td><center><?php echo $intP2Friday; ?></center></td>
        <td><center><?php echo $intP2Saturday; ?></center></td>
           <td><center><b>
   <?php
   $b = array($intP2Sunday, $intP2Monday, $intP2Tuesday, $intP2Wednesday, $intP2Thursday, $intP2Friday, $intP2Saturday);
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
		 <td><center><b>
			<?php
	$c = array(array_sum($a), array_sum($b));
	echo "" . array_sum($c) . "\n";
			  ?>
			</b></center></td>
 </table>

<?php
$mySum1 = "". array_sum($a) ."";
$mySum2 = "". array_sum($b) ."";
$mySum3 = "". array_sum($c) ."";
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
$username = "devinlabadini2";
$password = "newdlab";
$hostname = "devinlab77.startlogicmysql.com";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL");
echo "";

//seeeelect a database to work with
$tableselect = mysql_select_db("newproject",$dbhandle)
  or die("Could not select newproject");
echo "";


//Below converts first project

 $intEmployee = $_POST["employee"];
 $intRange = $_POST["range"];

$uniqueId = time();

$mysql_TimeSheet ="INSERT INTO timesheets(timesheet_id, employee_id, date_id, date_submitted, weekly_total) values ('$uniqueId', '$intEmployee','$intRange', '$today1', '$mySum3')";
     $msquery = mysql_query($mysql_TimeSheet);

$mysql_TS_Line1 = "INSERT INTO timesheetlineitem(timesheet_id, project_id, monday, tuesday, wednesday, thursday, friday, saturday, sunday, total) values ('$uniqueId', '$project1ID', '$intP1Monday', '$intP1Tuesday', '$intP1Wednesday', '$intP1Thursday', '$intP1Friday', '$intP1Saturday', '$intP1Sunday', '$mySum1')";
	 $msquery = mysql_query($mysql_TS_Line1);

$mysql_TS_Line2 = "INSERT INTO timesheetlineitem(timesheet_id, project_id, monday, tuesday, wednesday, thursday, friday, saturday, sunday, total) values ('$uniqueId', '$project2ID', '$intP2Monday', '$intP2Tuesday', '$intP2Wednesday', '$intP2Thursday', '$intP2Friday', '$intP2Saturday', '$intP2Sunday', '$mySum2')";
	 $msquery = mysql_query($mysql_TS_Line2);

//close the connection
mysql_close($dbhandle);
?>


<!--
$myString0 = "Time Sheet for: " . $_POST["employee"];
$myString1 = "Project Name: " . $intP1ProjectName .  "...\nTotal Hours:" . array_sum($a) . "\n";
$myString2 = "\nProject Name: " . $intP2ProjectName .  "...\nTotal Hours:" . array_sum($b) . "\n";
$myString3 = "\n\nTotal Week Hours: " . array_sum($c) . "\n";
$myString4 = "\n\nComments & Updates: " . $_POST["comments"];
$myString5 = $myString1.$myString2.$myString3.$myString4;


<php
 $to = "chsnmyrhoades88x@gmail.com";
 $subject = $myString0;
 $body = $myString5;
 if (mail($to, $subject, $body)) {
   echo("<p>Message successfully sent! <br/><br/> You will most likely recieve a paycheck this week.</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }
 ?>
-->

</body>
</center>
</html>

<?php include ("../layout/endlayout.php")?>
