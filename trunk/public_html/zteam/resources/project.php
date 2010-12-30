<html>
<option value=-5 disabled>----Select Project----</option>

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
$result2 = mysql_query("SELECT project_id, projectname FROM projects");

while ($row = mysql_fetch_array($result2)) {
    echo "<option value='" . $row['project_id'] . "-" . $row['projectname'] . "'>". $row['projectname'] . "</option>";

}

//close the connection
mysql_close($dbhandle);



?>

</html>