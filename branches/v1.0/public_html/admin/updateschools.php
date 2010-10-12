<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Schools</title>
</head>
<?php
include '../init.php';
$lines = file("schools.htm");
foreach ($lines as $currline){
	if (strpos(strtolower($currline), "<li>") and strpos($currline, "(") and strpos($currline, ")")){
		$urlndx = strpos($currline, '"') + 1;
		$url = substr($currline, $urlndx, (strpos($currline, '"', $urlndx + 1) - $urlndx));
		echo $url . "<br>";
		$namendx =  strpos(strtolower($currline), 'target="_blank">') + 16;
		$name = substr($currline, $namendx, strpos(strtolower($currline), "</a>", $namendx+1) - $namendx);
		echo $name . "<br>";
		$statendx = strpos($currline, '(') + 1;
		$state = substr($currline, $statendx, 2);
		echo $state . "<br>";
		}
	echo " ";
	}
include '../closedb.phps';
?>										
																			
<body>
</body>
</html>