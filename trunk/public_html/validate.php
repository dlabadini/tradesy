<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>

<?php
    $page_title = "Account validation";
    include_once 'layout/startlayout.php';
?>

    <div class="nav"><br>
    &nbsp; Account Validation
    </div>

<div class="page_info">
<div align="center">

<?php
// get the validation code from the members table
$valcode = mysql_result(mysql_query("SELECT valcode FROM members WHERE username='" . $_SESSION['username'] . "'"), 0);

if (isset($_POST['valcode'])) {
// this is a post to the validation form so check their code and activate account if needed
    if($_POST['valcode'] == $valcode) { // the code matches
        // activate account
        mysql_query("UPDATE members SET valcode=0 WHERE username='" . $_SESSION['username'] . "'");

        // display success message
        echo "Registration Complete! Below is your account information.<br/><br/>";
        echo "<div><table style='font-size:1em;' cellpadding='3px'>" .
    		 "<tr><td align='right'><b>Name:</b></td><td>" . $_SESSION['name'] . "</td></tr>" .
    		 "<tr><td align='right'><b>Login ID:</b></td><td>" . $_SESSION['username'] . "</td></tr>" .
    		 "<tr><td align='right'><b>School State:</b></td><td>" . $_SESSION['schstate'] . "</td></tr>" .
    		 "<tr><td align='right'><b>School Name:</b></td><td>" . $_SESSION['schname'] . "</td></tr>" .
    		 "<tr><td align='right'><b>E-mail:</b></td><td>" . $_SESSION['email'] . "</td></tr>" .
    		 "<tr><td align='right'><b>Location:</b></td><td>" . $_SESSION['location'] . "</td></tr>" .
             "</table></div>";
        echo "<br/><br/>Click <a href='welcome.php'>here</a> to go to the main site.";

    } else {
        echo "Invalid registration code.";
    }
} else {
// the user is on the validation page, give them the form
    $mail = $_SESSION['email'];
//    echo "validation code = " . $valcode;
    echo "A validation code has been sent to the email address you provided:<br><br><b>" . $mail . "</b><br><br>Please enter the code in the box below to proceed.<br/><br/>";
    echo "<form name='valform' action='validate.php' method='post' target='_self'>" .
         "Validation Code: <input type='text' id='valcode' name='valcode' /><br /><br /> " .
         "<iframe width='100%' height='400px' style='border:0px;' src='legal/terms.html'><p>Click on the link below to view terms and agreement</p></iframe><br /><br />" .
         "<input type='checkbox' name='termagree' value='Agree' onclick='this.form.s1.disabled=! this.checked;' />Agree to <a  href='legal' target='_blank'>terms</a><br /><br />".
         "<input type='Submit' name='s1' id='s1' value='submit' disabled/>".
         "</form>";
    echo "<br/><br/>";
    echo "Didn't get the validation email? Click below to send again.<br/>";
    echo "<form name='resend_form' action='validate.php' method='post' target='_self'>" .
         "<input type='Submit' name='resend' value='resend'/>" .
         "</form>";
    if($_POST['resend'] == "resend") {
        echo "<p style='color: red;'>";
        if(send_validation_code($mail, $valcode)) {
            echo "Validation code resent.";
        } else {
            echo "Unable to send validation code. Please check the email address '<b>" . $mail . "</b>' and try again";
        }
        echo "</p>";
    }
}
?>

</div></div>

<?
include 'layout/endlayout.php'
?>