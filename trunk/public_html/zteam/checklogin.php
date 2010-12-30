<?php
$host="devinlab77.startlogicmysql.com"; // Host name
$username="devinlabadini2"; // mysql username
$password="newdlab"; // mysql password
$db_name="newproject"; // Database name

$tbl_name="employee"; // Table name

// Connect to server and select databse.
$dbhandle = mysql_connect($host, $username, $password)or die("cannot connect");
$tableselect = mysql_select_db($db_name, $dbhandle)or die("cannot select DB");

// username and password sent from form
$msusername=$_POST['theusername'];
$mspassword=$_POST['thepassword'];

$sql="SELECT * FROM $tbl_name WHERE username='$msusername' and password='$mspassword'";
$result=mysql_query($sql);

// mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $msusername and $mspassword, table row must be 1 row

if($count==1){
// Register $msusername, $mspassword and redirect to file "login_success.php"
session_register("theusername");
session_register("thepassword");
header("location:welcome.php");
}
else {
    header("location:redirect.php");
    	
    }
?>