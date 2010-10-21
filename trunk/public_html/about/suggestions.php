<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/session.php"); ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/connection.php");?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php");?>

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
    $from = $_GET['username'];
	$suggestion = $_GET['suggestionbox'];

    if (!empty($suggestion) and !empty($from) and !strpos("Enter suggestion", $suggestion)){

          $to = 'suggestions@collegebookevolution.com';
          $subject = "College Book Evolution Suggestion";
          $headers = 'From: noreply@collegebookevolution.com' . "\r\n" .
                      'X-Mailer: PHP/' . phpversion();
          $body = "Suggestion from " . $from . ":\n\n" . $suggestion;
          if (mail($to, $subject, $body, $headers)) {
          	 echo "Thank you for the suggestion!<br/><br/>";
             echo "<i>Please note that suggestions are reviewed before taken into consideration; hence, the process could take a while. Your patience is very much appreciated.</i>";
             echo "<br/><br/>Return to <a href='http://www.collegebookevolution.com/about/?ref=contact'>College Book Evolution</a>";
          } else {
               echo "An error occured. Try resetting your password again.";
            }
    } else {
    echo "Sorry, no information received. Please check to make sure you're logged in. <br/><br/>Return to <a href='http://www.collegebookevolution.com/about/?ref=contact'>College Book Evolution</a><br>";
    }
?>


</p>
</div>
</table>

</html>
</body>