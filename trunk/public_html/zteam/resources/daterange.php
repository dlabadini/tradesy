<html>
<option value=-5 disabled>-----------------Select Week-----------------</option>

<?php
$username = "devinlabadini2";
$password = "newdlab";
$hostname = "devinlab77.startlogicmysql.com";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//seeeelect a database to work with
$tableselect = mysql_select_db("newproject",$dbhandle)
  or die("Could not select newproject");

//get the date range
$result1 = mysql_query("SELECT date_id, startdate, enddate FROM dates");

while ($row = mysql_fetch_array($result1)) {
   $thedates= $row['startdate']. " - " . $row['enddate'];
     echo "<option value='" . $row['date_id'] . "'>". $thedates . "</option>";

}

//close the connection
mysql_close($dbhandle);



?>

</html>