<?php
include '../includes/connection.php';
$page_title = "Home";
session_start();
if(!session_is_registered(theusername)){
header("location:index.php");
}
include 'layout/startlayout.php';
nav_menu($_SESSION['theusername'], 'home');
?>

<div class="page_info" >
<h2>Home</h2>
<div class='hrline'></div>
<!--
<?php include ("menubar.php")?>
-->
<br/>
<?php
 // point out total members
   $sql = "SELECT count(*) FROM members WHERE school_id = '2' ";
   $nmembers = mysql_result(mysql_query($sql), 0, 0);
   if ($nmembers == 0){
   		echo "No members. Click <a href='invite.php'>here</a> to invite friends.".
  				 "<br>";
  		}
   else {
   			if ($nmembers == 1){
  				 echo "There is <b><a href='blank.php'>1 member</a></b> at Salem State University.<br>";
  			} else {
   				 echo "There are <b><a href='blank.php'>" . $nmembers . " members</a></b> at Salem State University.<br>";
  			}
   }
?>

<!--
<?php
 // point out paid members
   $sql = "SELECT count(*) FROM member_subscriptions WHERE member_id = (member_id FROM members) AND (school_id = '2' FROM members) AND (subscription_id = '-1' FROM member_subscriptions) ";
   $npaid = mysql_result(mysql_query($sql), 0, 0);
   if ($npaid == 0){
   		echo "No paid members. Click <a href='invite.php'>here</a> to invite friends.".
  				 "<br>";
  		}
   else {
   			if ($npaid == 1){
  				 echo "There is one paid<b><a href='blank.php'>1 member</a></b> at Salem State University.<br>";
  			} else {
   				 echo "There are <b><a href='blank.php'>" . $npaid . " members</a></b> who have paid at Salem State University.<br>";
  			}
   }
?>

-->
<br/>
<br/>
</div>

<?php
include
("layout/endlayout.php");
?>