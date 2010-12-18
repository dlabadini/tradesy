<?php require_once("../includes/connection.php");?>

<?php
$q=$_GET["q"];

$sql="SELECT * FROM pending_subscriptions WHERE reg_id = $q";

$row = mysql_fetch_array(mysql_query($sql));

echo "<table border='1'>
<tr>
<th>Member ID</th>
<th>Name</th>
<th>School</th>
<th>Email</th>
<th>Subscription</th>
<th>Registration Date</th>
</tr>";

echo "<tr>";
echo "<td>" . $row['member_id'] . "</td>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['school_id'] . "</td>";
echo "<td>" . $row['email'] . "</td>";
echo "<td>" . $row['subscription_id'] . "</td>";
echo "<td>" . $row['reg_date'] . "</td>";
echo "</tr>";

echo "</table>";
?> 