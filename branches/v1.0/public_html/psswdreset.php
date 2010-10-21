<?php
$root = $_SERVER["DOCUMENT_ROOT"];
if (strpos($root, "xampp") == false){
  require_once($root . "/includes/connection.php");
  require_once($root . "/includes/functions.php");
}else{
  require_once("\includes/connection.php");
  require_once("\includes/functions.php");
}
?>

<html>
<head>
<title>Password Reset</title>
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

<table class='sample'width=500px><tr><td> 
<div align='center' style='margin-left:10px;'>
<h2>Forgot Your Password</h2>
<p>

<?php
	$email = $_GET['em'];
	$resetcode = $_GET['rc'];
	
	$newpsswd = substr(base64_encode(rand(1000000000,9999999999)),0,10);
	
	$sql = "SELECT 1 FROM password_resets WHERE email='" . $email . "' AND reset_code='" . $resetcode . "'";
  if (mysql_result(mysql_query($sql), 0, 0) == 1){
     	 //get salt
      $salt = generate_salt();
      $psswd = md5(md5($newpsswd) . $salt);	
      	 
      // overwrite old password
      $sql = "UPDATE members SET password='" . $psswd . "', salt='" . $salt . "' WHERE email='" . $email . "'";
			
    	if (mysql_query($sql)){
    		 $sql = "DELETE FROM password_resets WHERE email='" . $email . "'";
    		 mysql_query($sql);
    		 
    		  $to = $email;
      	  $subject = "CollegeBookEvolution Password Reset";
      	  $headers = 'From: noreply@collegebookevolution.com' . "\r\n" .
          'X-Mailer: PHP/' . phpversion();
        	$body = "Your password has been reset to '" . $newpsswd . "' (without the quotes). \n\n" .
								"Please login to your account at www.collegebookevolution.com and change this password as soon as possible. \n\nThanks,\nCollege Book Evolution";
        	if (mail($to, $subject, $body, $headers)) {
      			 echo "Your password has been reset. <br/>A new password has been sent to your email address '<b>" . $email . "</b>'. <br/><br/><a href='http://www.collegebookevolution.com'>Login</a> with this new password and change it under MyAccount.";
          } else {
             echo "An error occured. Try resetting your password again.";
          }
    		 }
	} else {
		echo "Sorry, no information found. Return to <a href='http://www.collegebookevolution.com'>College Book Evolution</a><br>";
} 
?>
</p>
</div>
</table>

</html>
</body>