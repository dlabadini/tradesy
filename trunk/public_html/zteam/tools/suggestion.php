
<html>
<?php
$myString0 = "Suggestion from: " . $_POST["name"];
$myString1 = "From:" . $_POST["email"];
$myString2 = "Suggestion:" . $_POST["comments"];
?>


<?php
 $to = "chsnmyrhoades88x@gmail.com";
 $subject = $myString0;
 $headers = $myString1;
 $body = $myString2;
 if (mail($to, $subject, $body, $headers)) {
   echo("<p>Suggestion successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed, maybe your idea wasn't that great.</p>");
  }
 ?>
 </html>

