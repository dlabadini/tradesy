<?php
$username = "converge";
$password = "converge1";
$hostname = "192.168.1.19:1433";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("TIMESHEETDB",$dbhandle)
  or die("Could not select TIMESHEETDB");

//execute the SQL query and return records
$result = mysql_query("SELECT date, firstname, lastname FROM cars");

//fetch tha data from the database
while ($row = mysql_fetch_array($result)) {
   echo "Date".$row{'date'}." First Name:".$row{'firstname'}."LastName: ". //display the results
   $row{'lastname'}."<br>";
}
//close the connection
mysql_close($dbhandle);
?>