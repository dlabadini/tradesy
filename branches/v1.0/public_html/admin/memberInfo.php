<?php require_once("../includes/connection.php");?>

<?php
$q=$_GET["q"];

$sql="SELECT * FROM members WHERE username = '$q'";

$result = mysql_query($sql);

echo "<table border='1'>
<tr>
<th>Member ID</th>
<th>Name</th>
<th>Email</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['member_id'] . "</td>";
  echo "<td>" . $row['name'] . "</td>"; 
  echo "<td>" . $row['email'] . "</td>";
  echo "</tr>";
  }
echo "</table>";
?>