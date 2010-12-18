<html>
<option value=-3 disabled>----</option>

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

//get the date range
$valueresult = mysql_query("SELECT hour_id, hours FROM hourvalues");

while ($row = mysql_fetch_array($valueresult)) {
   $thevalues= $row['hours'];
     echo "<option value='" . $row['hour_id'] . "'>". $thevalues. "</option>";

}

//close the connection
mysql_close($dbhandle);



?>


</html>