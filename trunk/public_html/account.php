<?php
/**
Filename: account.php
URL: www.collegebookevolution.com/account.php
Author: William Mensah (www.wilmens.net)
Date Created: 12/2009
Last Modified: 07/2010

Purpose:
	- Displays current user's account information
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

To implement new message notifications, execute the following SQL:
ALTER TABLE  `members_prefs` ADD  `new_message_notification` BOOL NULL DEFAULT  '1' AFTER  `auto_search_notification`;
UPDATE members_prefs SET new_message_notification = 1;

*/


include 'init_utils.php';

$error = 0; // used to detect if any errors have been encountered so we know when to proceed
$errmsg = ""; // error message to be displayed if any errors are encountered.

if (isset($_POST['prefs'])){
  // save user preferences
  $as_action = 1; // auto search
  $nm_action = 1; // new message
  if (empty($_POST['auto_search'])){
    //user has unsubscribed from auto_search notifications
    $as_action = "NULL";
  }
  if (empty($_POST['new_message'])){
    // user has unsubscribed from new_message notifications
    $nm_action = "NULL";
  }
  $sql = "UPDATE members_prefs SET auto_search_notification = $as_action, new_message_notification = $nm_action WHERE member_id = " . $_SESSION['userid'];
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
        $pic = $_POST['pic'];

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

            if (!empty($pic)) {
                 if ($update != "") {
                        $update = $update . ", ";
                        }
                 $update = $update . "profile_picture_url = '$pic'";
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
echo "<a onclick='togglediv(\"changepsswd\");' href='javascript:;'>Password</a>" .
	"</td><td><div id='changepsswd' class='editinfo' style='display:none;'>Current Password:<br><input type='password' name='oldpsswd' />" .
	"<br/>New Password:<br><input type='password' name='newpsswd' />" .
	"<br/>Confirm New Password:<br><input type='password' name='confnewpsswd' /></div><br/>";
echo "</td></tr>";

echo "<tr><td valign='top'><a onclick='togglediv(\"pic\");' href='javascript:;'>Profile Picture:</a></td><td>" . showProfilePicture($_SESSION['userid']) .
        "<br/><div class='editinfo' id='pic' style='display:none;'>Change To: <input type='text' maxlength=233 name='pic' /></div></td></tr>";

echo "</table>";
echo "<p><input type='submit' name='personal' value='Save Changes' /></p>";
echo "</form></div>";

//book credit information
echo "<h2>Book Credits</h2>";
echo "<div style='margin-left:40px'>";
echo "<table border='0' cellpadding='3px' style='font-size:1em;'>";
$sql = "SELECT * FROM members_credits WHERE member_id = " . $_SESSION['userid'] . " LIMIT 1";
$info = mysql_fetch_array(mysql_query($sql));
echo "<tr><td>Credits purchased:</td><td>" . $info['bought'] . "</td></tr>";
echo "<tr><td>Credits spent:</td><td>" . $info['used'] . "</td></tr>";
echo "<tr><td>Credits available:</td><td>" . ((int)$info['bought'] - (int)$info['used']) . "</td></tr>";
echo "<tr><td><a href='add_credits.php'>Add credits</a></td></tr>";
echo "</table></div>";

//Preferences
$auto_search_checked = "";
$new_message_checked = "";
echo "<h2>Preferences</h2>";
echo "<div style='margin-left:40px;'>";
echo "<form method=\"post\" action=\"{$_SERVER['php_self']}\">";
$sql = "SELECT * FROM members_prefs WHERE member_id = " . $_SESSION['userid'];
$prefs = mysql_fetch_array(mysql_query($sql));
if ($prefs['auto_search_notification'] == 1) $auto_search_checked = "checked";
if ($prefs['new_message_notification'] == 1) $new_message_checked = "checked";
echo "<input type='checkbox' name='auto_search' $auto_search_checked />Subscribe to Auto-Search Notifications (<a href='help/?ref=faqs#autosearch'>What's this?</a>)<br/>";
echo "<input type='checkbox' name='new_message' $new_message_checked />Subscribe to New Message Notifications (<a href='help/?ref=faqs#newmessage'>What's this?</a>)";
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
