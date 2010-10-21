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
<title>Employee Central  |  Timesheet</title>
</head>

<?php include ("../layout/startlayout.php")?>


<div align="right">
<?php
    $today1 = date("D, F j, Y, g:i a"); echo $today1;
?>
</div>



<br/>
<center>
<font color="">
<br /><br/>
</font>
</center>

<form action="employee_form_action.php" method="post">
<center>
		<!--<select name="range[rangename]">
				<?php include('daterange.php')?></select>-->
           <select name="range">
				<?php include('daterange.php')?></select>
           <br>
</center>
<br />
	   <center>
		   <!--<select name="employee[employeename]">
				<?php include('employee.php')?></select>-->

				<select name="employee">
				<?php include('employee.php')?></select>
       </center>
<br /><br />
<body>

 <table border="1" cellspacing="0" cellpadding="4" align="center" width="350">
   <tr>
     <td><b></b></td>
     <td><b><center>Sunday</center></b></td>
     <td><b><center>Monday</center></b></td>
     <td><b><center>Tuesday</center></b></td>
     <td><b><center>Wednesday</center></b></td>
     <td><b><center>Thursday</center></b></td>
     <td><b><center>Friday</center></b></td>
     <td><b><center>Saturday</center></b></td>
   </tr>
   <tr>
	 <td>

		<select name="project1[projectname]">
			<?php include('project.php')?>
		</select>
	  </td>
	  <td>
		<select name="project1[sunday]">
		<?php include('hourvalues.php')?>
		</select>
	 </td>
	 <td>
		<select name="project1[monday]">
		<?php include('hourvalues.php')?>
		</select>
	 </td>
	 <td>
	  <select name="project1[tuesday]">
		<?php include('hourvalues.php')?>
		</select>
	 </td>
	 <td>
		<select name="project1[wednesday]">
		<?php include('hourvalues.php')?>
		</select>
	 </td>
	 <td>
		<select name="project1[thursday]">
		<?php include('hourvalues.php')?>
		</select>
	 </td>
	 <td>
		<select name="project1[friday]">
		<?php include('hourvalues.php')?>
		</select>
	 </td>
	 <td>
		<select name="project1[saturday]">
		<?php include('hourvalues.php')?>
		</select>
	 </td>
   </tr>
	 <tr>
		 <td>
			   <select name="project2[projectname]">
				<?php include('project.php')?>
			   </select>
		  </td>
		  <td>
			   <select name="project2[sunday]">
				 <?php include('hourvalues.php')?>
			   </select>
		  </td>
		  <td>
			   <select name="project2[monday]">
				<?php include('hourvalues.php')?>
			   </select>
		  </td>
		  <td>
			   <select name="project2[tuesday]">
				<?php include('hourvalues.php')?>
			   </select>
		  </td>
		  <td>
			   <select name="project2[wednesday]">
				<?php include('hourvalues.php')?>
			   </select>
		  </td>
		  <td>
			   <select name="project2[thursday]">
				<?php include('hourvalues.php')?>
			   </select>
		  </td>
		  <td>
			   <select name="project2[friday]">
				<?php include('hourvalues.php')?>
			   </select>
		   </td>
		   <td>
			   <select name="project2[saturday]">
				<?php include('hourvalues.php')?>
			   </select>
		   </td>
	   </tr>
 </table>
<br/>
	<table align="center">
		<tr>
		  <td width="120" align="right" valign="middle">Comments<br/>& Updates:</td>
		  <td><textarea input type="text" name="comments" rows="5" cols="40">
		  </textarea></td>
		</tr>
	 </table>

</body>
<br />

<div align="right">
    <input value="Submit" type="submit" />
</div>
</form>

<?php include ("../layout/endlayout.php")?>





