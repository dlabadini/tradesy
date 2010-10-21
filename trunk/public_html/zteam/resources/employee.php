<html>
<option disabled>---Select Employee---</option>

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

//execute the SQL query and return records
$result = mysql_query("SELECT employee_id, firstname, lastname, username, password, salt FROM employee");

while ($row = mysql_fetch_array($result)) {
   $fullname= $row['firstname']. " " . $row['lastname'];
     echo "<option value='" . $row['employee_id'] . "'>". $fullname . "</option>";

}


//close the connection
mysql_close($dbhandle);



?>
</html>