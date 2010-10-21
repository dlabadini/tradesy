


<html>



Project Name:<?php echo $_POST['contract']; ?><br/>
Project Price:<?php echo $_POST['price'];?><br/><br/>
<font color="#00FF00">Information Successfully Transfered.</font>

<?php

$name = $_POST['contract'];
$email = $_POST['price'];

$fp = fopen("data.txt","a");

if(!$fp) {
    echo 'Error: Cannot open file.';
    exit;
}

fwrite($fp, $name."||".$email."\n");

fclose($fp);
?>

</html>