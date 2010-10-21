<?php
$root = $_SERVER["DOCUMENT_ROOT"];
if (strpos($root, "xampp") == false){
  require_once($root . "/includes/connection.php");
  require_once($root . "/includes/session.php");
  require_once($root . "/includes/functions.php");
}else{
  require_once("\includes/session.php");
  require_once("\includes/connection.php");
  require_once("\includes/functions.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Forgot Password</title>
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
<a href='http://www.collegebookevolution.com'><img src='images/cbe_logo.gif' border='0' alt='College Book Evolution' /></a>

<table class='sample' width='500px' ><tr><td>
<div align='center' style='margin-left:10px;'>
<form action=<?php echo $_SESSION['PHP_SELF'] ?> >
<h2>Forgot Your Password</h2>
<p>
<?
//check email address
$em = $_GET['email'];
if (isset($em)){
  $sql = "SELECT 1 FROM members WHERE email='" . $em . "'";
  if (mysql_result(mysql_query($sql), 0, 0) == 1){
  	 // generate new password
  	 $resetcode = substr(base64_encode(rand(1000000000,9999999999)),0,10);
  	 
  	 	$to = $em;
  	  $subject = "CollegeBookEvolution Password Reset";
  	  $headers = 'From: noreply@collegebookevolution.com' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();
    	$body = "visit this link to reset your password \n http://www.collegebookevolution.com/psswdreset.php?em=". $em . "&rc=". $resetcode;
    	if (mail($to, $subject, $body, $headers)) {
  			 echo "A link to reset your password has been sent to '<b>" . $em . "</b>'<br><br>";
  			 
  			 //add info to password_resets table
  			 $sql = "INSERT INTO password_resets VALUES ('" . $em . "', '" . $resetcode . "')";
  			 mysql_query($sql);
				 if (strpos("Duplicate", mysql_error()) >= 0){
				 		$sql = "UPDATE password_resets SET reset_code = '" . $resetcode . "' WHERE email='" . $em . "'";
						mysql_query($sql) or die ("Some weird error occured. Ignore any emails you might receive");
				 }
  			 
      } else {
         echo "An error occured.<br>";
      }
  	 
  } else {
  	echo "No account exists under the email address '<b>" . $em . "</b>'<br><br>";
  	}
}
?>
		
	 
Enter your email address<br />
<input type='text' name='email' /><br />
<input type='submit' value='Submit'/>
</form>
<br/>
<br/>
<p>
<div align='center'>
<h3>What happens next?</h3>
A link to reset your password will be sent to your email address, follow the link to reset your password. 
</div>
</p>
</div>
</td></tr></table>
</div>
</body>
</html>