<?php
/**
Filename: account.php
URL: www.collegebookevolution.com/account.php
Author: William Mensah (www.wilmens.net)
Date Created: 12/2009
Last Modified: 07/2010

Purpose:
	- Displays current user's account information such personal and subscription information
	- Allows current user to make changes to account information such as change password, alternate email address etc
	
Requires:
	- init_utils.php
	- layout/startlayout.php
	- layout/endlayout.php
	
Optional POST parameters:
	- prefs
		- ie. Save changes button was clicked, so determine what needs to be updated.
	- auto_search
		- auto search feature has been enabled/disabled.
	- personal
		- name, pemail, location, oldpsswd, newpsswd, confnewpsswd

Functionalilty:
	When php script is run, a check is made to see if $_POST['prefs'] is set. 
	If it is, then the user has made changes to preferences which needs to be saved (ie. updated in the database).
	So we check if POST:auto_search has been set, update the auto_search value in the database (1 or 0)
	If POST:personal has been set, then the user has updated personal information which needs to be saved in the database.
	$update is a string variable that holds the sql update command that will be executed to update the database
	The string is generated based on what information needs to be updated in the database.
	
Function Calls:
	- sendTestimonial($message, $name, $email, $title) (see functions.php)
	- nav_menu($username, $page) (see functions.php)
	
	
*************************************************************************************************
*/


include 'init_utils.php';

$error = 0; // used to detect if any errors have been encountered so we know when to proceed
$errmsg = ""; // error message to be displayed if any errors are encountered.

if (isset($_POST['prefs'])){
  // save user preferences
  $action = 1;
  if (empty($_POST['auto_search'])){
    //user has unsubscribed from auto_search notifications
    $action = "NULL";
  }
  $sql = "UPDATE members_prefs SET auto_search_notification = $action WHERE member_id = " . $_SESSION['userid'];
  mysql_query($sql);

$errmsg = "<span id='notification'>Changes to your <b>Preferences</b> have been applied.</span>";

}else if (isset($_POST['personal'])){
        $update = "";

        $name = $_POST['name'];
        $prefemail = $_POST['pemail'];
        $location = $_POST['location'];
        $oldpsswd = $_POST['oldpsswd'];
        $newpsswd = $_POST['newpsswd'];
        $confnewpsswd = $_POST['confnewpsswd'];

        if (!empty($oldpsswd)){
        	 //check if new password matches confirmed password
        	 $sql = "SELECT password, salt FROM members WHERE member_id = " . $_SESSION['userid'];
        	 $userpsswd = mysql_fetch_array(mysql_query($sql));

        	 if (md5(md5($oldpsswd).$userpsswd['salt']) != $userpsswd['password']){
        	 		$errmsg = "<span id='error'>Incorrect password</span>";
        			$error = 1;
        			}
        	 if ($error == 0){
            	 if (empty($newpsswd) or empty($confnewpsswd)){
            	 		$errmsg = "<span id='error'>New password fields cannot be left blank. Your password has not been changed.</span>";
            			$error = 1;
            			}
            	 else if ($newpsswd != $confnewpsswd){
            	 			$errmsg = "<span id='error'>Passwords don't match</span>";
            				$error = 1;
            				}
        	 }
             if ($error == 0 and !preg_match("/^.*(?=.{6,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $newpsswd)){
                $errmsg = '<span id="error">Password must be at least 6 characters long, alpha numeric and a mix of upper and lower case letters</span>';
                $error = 1;
             }

        }

        if (!empty($name) and !ctype_alnum(str_replace(' ', '', $name))){
                    $errmsg = "<span id='notification'>Your name '<b>" . str_replace("\\", '', $name) . "</b>' contains invalid characters. ".
                              "Make sure that it is alpha-numeric</span>";
                    $error = 1;
        }

        if ($error == 0){

            if (!empty($name)){
            	    $update = $update . "name = '" . $name . "'";
            }

            if (!empty($prefemail)){
            	 if ($update != ""){
            	 		$update = $update . ", ";
            			}
            	 $update = $update . "preferred_email = '" . $prefemail . "'";
            	 }

            if (!empty($location)){
            	 if ($update != ""){
            	 		$update = $update . ", ";
            			}
            	 $update = $update . "location = '" . $location . "'";
            	 }

            if (!empty($newpsswd)){
            	 if ($update != ""){
            	 		$update = $update . ", ";
            			}
            	 $update = $update . "password = '" . md5(md5($newpsswd).$userpsswd['salt']) . "'";
            	 }

        		//update information in the database.
        		if (!empty($update)){
        			 $query = "UPDATE members SET " . $update . " WHERE member_id = " . $_SESSION['userid'];
        			 mysql_query($query);
                     if (!empty($name)){
                        $_SESSION['fullname'] = $name;
                      }
        			 $errmsg = "<span id='notification'>Changes to your <b>Personal Information</b> have been applied.</span>";
        		}
        }
}

/*

	DISPLAY THE PAGE
	
*/

$page_title = "CBE My Account (" . $_SESSION['username'] . ")";
include 'layout/startlayout.php';
nav_menu($_SESSION['username'], null);


echo '<div class="page_info">';

$sql = "SELECT * FROM members WHERE member_id = " . $_SESSION['userid'] . " LIMIT 1";
$result = mysql_query($sql);
if (!empty($errmsg)){
	 echo $errmsg;
}
echo "<h2>Personal Information</h2>";
echo "<div style='margin-left:40px;'>";
echo "<form method=\"post\" action=\"{$_SERVER['php_self']}\">";
echo "<table border='0' cellpadding='3px' style='font-size:1em;'>";
$row = mysql_fetch_array($result);
echo "<tr><td valign='top'><a onclick='togglediv(\"name\");' href='javascript:;'>Name:</a></td><td>" . ucwords($row['name']) .
		 "<br><div class='editinfo' id='name' style='display:none;'>Change To: <input type='text' name='name' maxlength=100 /></div></td></tr>";

echo "<tr><td valign='top'>Username:</a></td><td>" . $row['username'] . "</td></tr>";

$school = get_school($row['school_id']);
echo "<tr><td valign='top'>School State:</td><td>" . $school[2] . "</td></tr>";

echo "<tr><td valign='top'>School Name:</td><td>" . $school[1] . "</td></tr>";

echo "<tr><td valign='top'>Email:</a></td><td>" . $row['email'] .  "</td></tr>";

echo "<tr><td valign='top'><a onclick='togglediv(\"prefered_email\");' href='javascript:;'>Preferred Email:</a></td><td>" . $row['preferred_email'] .
		 "<br><div class='editinfo' id='prefered_email' style='display:none;'>Change To: <input type='text' maxlength=320 name='pemail' /></div></td></tr>";

echo "<tr><td valign='top'><a onclick='togglediv(\"currLoc\");' href='javascript:;'>Current Location:</a></td><td>" . $row['location'] .
		 "<br><div class='editinfo' id='currLoc' style='display:none;'>Change To: <input type='text' maxlength=30 name='location' /></div></td></tr>";

echo "<tr valign='top'><td>";
echo "<a onclick='togglediv(\"changepsswd\");' href='javascript:;'>Change Password</a>" .
	"</td><td><div id='changepsswd' class='editinfo' style='display:none;'>Current Password:<br><input type='password' name='oldpsswd' />" .
	"<br/>New Password:<br><input type='password' name='newpsswd' />" .
	"<br/>Confirm New Password:<br><input type='password' name='confnewpsswd' /></div><br/>";

echo "</td></tr></table>";
echo "<p><input type='submit' name='personal' value='Save Changes' /></p>";
echo "</form></div>";

//subscription information
echo "<h2>Subscription Information</h2>";
echo "<div style='margin-left:40px'>";
echo "<table border='0' cellpadding='3px' style='font-size:1em;'>";
$sql = "SELECT * FROM member_subscriptions WHERE member_id = " . $_SESSION['userid'] . " LIMIT 1";
$info = mysql_fetch_array(mysql_query($sql));

if ($info['subscription_id'] == -1){
	echo "<tr><td>Start Date:</td><td align='left'>" .  date('m/d/Y', strtotime($info['start_date'])) . "</td></tr>";
	echo "<tr><td>Subscription:</td><td>Free Trial (<a href='upgrade.php'>Upgrade</a>)</td></tr></table>";
}else{
	echo "<tr><td>Start Date:</td><td>" . date('m/d/Y', strtotime($info['start_date'])) . "</td></tr>";

	$subscr = get_subscription_info($info['subscription_id']);
	echo "<tr><td>End Date:</td><td>" . date('m/d/Y', strtotime(addDate($info['start_date'], $subscr[3]))) . "</td></tr>";

	echo "<tr><td>Plan:</td><td>" . $subscr[1] . "</td></tr>";
	echo "<tr><td>Price:</td><td>$" . $subscr[2] . "</td></tr>";
	echo "<tr><td>Amount Paid:</td><td>$" . $info['amount_paid'] . "</td></tr>"; //subtract coupon value from this

	$acctype = mysql_result(mysql_query("SELECT name FROM account_types WHERE tid = " . $info['account_type']), 0, 0);
	echo "<tr><td>Type:</td><td>" . $acctype . "</td></tr>";

	echo "</table>";
}
echo "</div>";

//Preferences
$checked = "";
echo "<h2>Preferences</h2>";
echo "<div style='margin-left:40px;'>";
echo "<form method=\"post\" action=\"{$_SERVER['php_self']}\">";
if ($info['subscription_id']> 0){
  $sql = "SELECT auto_search_notification FROM members_prefs WHERE member_id = " . $_SESSION['userid'];
  if (mysql_result(mysql_query($sql), 0, 0) == 1){
	$checked = "checked";
  }
}
echo "<input type='checkbox' name='auto_search' $checked";
if ($info['subscription_id'] < 0) echo " disabled ";
echo "  />Subscribe to Auto-Search Notifications (<a href='help/?ref=faqs#autosearch'>What's this?</a>)";
echo "<p><input type='submit' name='prefs' value='Save Changes' /></p>";
echo "</form></div>";
?>
<br/><br/><div class='hrline'></div>
<a href='javascript:void;' onClick='togglediv("testimonial"); document.getElementById("testimony").value="Enter testimonial"; document.getElementById("testimony").select();'>Send</a> a testimonial
<div id='testimonial' name='testimonial' style='display:none; position:relative;'><p><textarea id='testimony' cols='105'></textarea><br/><a href='javascript:void;' onClick='sendTestimonial(document.getElementById("testimony").value, "<? echo $row['name']?> ", "<? echo $row['email'] ?>", "testimonial");'>Submit Testimonial</a></p></div>

</div>

<?php
include 'layout/endlayout.php';
?>
