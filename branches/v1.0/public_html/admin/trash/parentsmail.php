<?
error_reporting(0);
set_time_limit(0);
//#############################################################
//#################   CONFIGURATION  ##########################

// choose a password
//$my_password="M7U0mDL89N";
// the email from which emails are send
//  mydomain.com must be your real domain, otherways,
//  the server will not send any emails
$from_email="CollegeBookEvolution.com <newsletter@collegebookevolution.com>";
// Your reply to email (whatever you want).
$replyto="newsletter@collegebookevolution.com";
// A message to be attached to the bottom of the message
//   We recommend to add a link to subscription page
$message_at_bottom="<br/><br/><p><div style='border-top: 1px solid #E8E8E8;'></div>
To unsubscribe from this mailing list, visit <a href='http://www.collegebookevolution.com/mailinglist'>www.collegebookevolution.com/mailinglist</a>
</p>";
// The file where emails are stored
$emails_file="emaillist-parents-M7U0mDL89N.txt";

//###############   END CONFIGURATION  ########################
//#############################################################

// IF INFO IS NOT POSTED, PRINT THE FORM AND DIE
if (!$_POST["mensaje"]){
        print_form();
        die();
}

// IF INFO IS POSTED YOU WILL BE HERE
// Check whether the password is correct
//  (only webmaster is supposed to know the password, which has been specified above)
//if ($_POST["p"]!=$my_password){die("Incorrect password");}

// Get the subject of message
$subject =$_POST["subject"];
// Get the body of message
$message=str_replace("**", "'", $_POST["mensaje"]);
// Add to body of message the bottom
$message.=$message_at_bottom;
// Read the file with emails to variable $emails_file
$emails_file=file_get_contents($emails_file);
// Extract list of emails to array $emails_array
preg_match_all("/<.{0,100}?>/",$emails_file,$emails_array);

// Start output
print "<b>Sending messages...</b>";

// Send email to each email
foreach ($emails_array[0] as $email){
        // remove "<" and ">" from each email
        $email=substr($email,1,strlen($email)-2);
        // Next line is the one sending the email: the key command of this script
        mail($email, $subject, $message,"From: $from_email\nReply-To: $replyto\nContent-Type: text/html");
        // Each time an email is send, output it
        print "<br>$email\n";
        // After sending each email, send previous line (the email) to the browser
        flush();
}

print "<p>Done! Return to <a href='http://www.collegebookevolution.com/workshop2/admin'>Admin</a> page or " .
    "<a href='http://www.collegebookevolution.com/workshop2'>Home</a> page</p>";
?>


</body>
</html>



<?php
// THIS FUNCTION WILL SHOW THE FORM
// MODIFY IT AS REQUIRED
function print_form(){
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"  http-equiv="content-type">
  <title>My email list</title>
</head>
<body style="background-color: rgb(255, 255, 255);">
<center>
<h2>Form to send email to the mailing list</h2>
<table style="font-family: times new roman;" border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="vertical-align: top;">
                <form method=POST action="<? $PHP_SELF; ?>".php>
                Subject
                <br><input type=text name=subject size=40>
                <br>Message
                <br><textarea name=mensaje cols=50 rows=8></textarea>
                <br><input type=submit value=Send>
                </form>

                <p>
                <ul>
                    <li>Note: html urls should be enclosed in ** and not " <br/>
                        eg. href=**http://www.collegebookevolution.com** and not <br/>
                        href="http://www.collegebookevolution.com"   </li><br/>
                    <li>Don't forget the 'http://'
                </ul>
      </td>
    </tr>
  </tbody>
</table>
</center>
</body>
</html>

<? } ?>
