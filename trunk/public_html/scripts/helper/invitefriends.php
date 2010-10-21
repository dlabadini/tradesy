<?

function isValidEmail($email){
    if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
      return true;
    }
    return false;
}


$to = $_GET['email'];

if (!isValidEmail($to)){
  echo "<span id='subscript'>Invalid E-mail address. Invitation not sent.</span>";
}else{
  $invitee = $_GET['from'];
  $subject = 'College Book Evolution Invitation';
  $headers = "From: noreply@collegebookevolution.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


  	$message = "<html><body><font size='2' face='Verdana'><p>You have been invited by '" . $invitee .
                  "' to join <a href='http://www.collegebookevolution.com'>College Book Evolution</a>." .
                  "<br/>Click <a href='http://www.collegebookevolution.com/register.php'>here</a> " .
                  "to sign up and start saving money buying and selling your textbooks" .
                  "</p><br/>Thanks,<br/>College Book Evolution</font></body></html>";
  	$mail_sent = @mail( $to, $subject, $message, $headers );
  	if ($mail_sent){
          echo "<span id='subscript'>Invitation has been sent to <b>" . $to . "</b></span>";
      } else {
          echo "<span id='subscript'>Unable to send invitaion.</span>";
      }
}
?>