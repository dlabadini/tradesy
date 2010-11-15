<?
$msg = $_GET['msg'];
$from = $_GET['name'];
$email = $_GET['email']; 

$to = 'testimonials@collegebookevolution.com';

$subject = 'College Book Evolution Testimonial';

$headers = "From: noreply@collegebookevolution.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


$message = "<html><body><font size='2' face='Verdana'><p>" .
      "New Testimonial from " . $from . "(" . $email . ")<p>" . $msg . "</p></p><br/>Thanks,<br/>College Book Evolution</font></body></html>";
$mail_sent = @mail( $to, $subject, $message, $headers );
if ($mail_sent){
      echo "<span id='subscript'>Testimonial has been submitted.</span>";
  } else {
      echo "<span id='subscript'>Unable to submit testimonial. Please try again later.</span>";
  }
?>