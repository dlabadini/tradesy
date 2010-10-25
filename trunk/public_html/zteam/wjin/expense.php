<html>
	Employee Name: <?php echo $_POST['emp0'];?><br/>
	         Week: <?php echo $_POST['week']; ?><br/>
	    $$$$$$$$$: <?php echo $_POST['cost2'];?><br/>

	<br/>
	<font color="#00FF00">Information Successfully Transfered.</font>
<?php


$name = $_POST['jin0'];
$week = $_POST['jin1'];
$cost = $_POST['jin2'];



$fp = fopen("expense.txt","a");

if(!$fp) {
    echo 'Error: Cannot open file.';
    exit;
}

fwrite($fp, $name."||".$email."\n");

fclose($fp);
?>

</html>