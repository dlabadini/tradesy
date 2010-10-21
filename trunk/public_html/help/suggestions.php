<!--<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/session.php"); ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/connection.php");?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php");?>-->
<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/connection.php");
session_save_path("/home/users/web/b2287/sl.devinlab77/public_html/cgi-bin/tmp");
session_start();
?>

<html>
<head>
<title>Suggestions</title>
<style type="text/css">
table.sample {
	border-width: 1px;
	border-spacing: ;
	border-color: #A9F5F2;
	border-collapse: separate;
	background-color: white;
	font-family:Arial, Helvetica, sans-serif;
	font-size:0.8em;
}
table.sample th {
	border-width: 0px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: rgb(250, 240, 230);
	-moz-border-radius: ;
}
table.sample td {
	border-width: 0px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: #EFFBF5;
	-moz-border-radius: ;
}
</style>
</head>
<body>
<div align='center'>
<a href='http://www.collegebookevolution.com'><img src='../../images/cbe_logo.gif' border='0' alt='College Book Evolution' /></a>

<table class='sample'width=500px><tr><td>
<div align='center' style='margin-left:10px;'>
<h2>Suggestions</h2>
<p>
<?php
    $sql = "SELECT name, email FROM members WHERE username = '" . $_SESSION['username'] . "'";
    $userinfo = mysql_fetch_array(mysql_query($sql));
    $from = $userinfo['name'] . " <" . $userinfo['email'] . ">";
	$suggestion = $_POST['suggestionbox'];

    if (empty($suggestion) or strpos("Enter suggestion", $suggestion)){
      echo "No suggestion was made.";
    }else if (empty($from)){
      echo "You have to be logged in to make suggestions";
    }else{

          $to = 'suggestions@collegebookevolution.com';
          $subject = "Suggestion from " . $userinfo['name'];
          $headers = 'From: noreply@collegebookevolution.com' . "\r\n" .
                      'X-Mailer: PHP/' . phpversion();
          $body = "Suggestion from " . $from . ":\n\n" . $suggestion;
          if (mail($to, $subject, $body, $headers)) {
          	 echo "Thank you for the suggestion!<br/><br/>";
             echo "<i>Please note that suggestions are reviewed before taken into consideration; hence, the process could take a while. Your patience is very much appreciated.</i>";
          } else {
               echo "Unable to send suggestion. Please try again later.";
          }
    }
    echo "<br/><br/>Return to <a href='http://collegebookevolution.com/about/?ref=contact'>College Book Evolution</a>";
?>


</p>
</div>
</table>

</html>
</body>