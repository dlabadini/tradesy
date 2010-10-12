<?php
require_once("../includes/connection.php");

// Get variables from URL
$name=$_GET["name"];
$state=$_GET["state"];
$email=$_GET["email"];

if (!isset($name) or !isset($state) or !isset($email)){
	echo "Missing information";
}else{

// add school info
$sql = "INSERT INTO schools(school_name, state) VALUES ('" . $name . "', '" . $state . "')";
mysql_query($sql);

// add mail server info
$sql = "SELECT school_id FROM schools WHERE school_name = '" . $name . "' AND state = '" . $state . "'";
$schid = mysql_result(mysql_query($sql), 0, 0);

$sql = "INSERT INTO mail_servers(school_id, mail_server) VALUES (" . $schid . ", '" . $email . "')";
mysql_query($sql);

// create class and books tables
mysql_query("CREATE TABLE  `cbe_db`.`classes" . $schid . "` (
`class_id` INT( 10 ) NOT NULL ,
 `class_name` VARCHAR( 50 ) NOT NULL ,
 `abrev` VARCHAR( 8 ) NOT NULL ,
 `class_number` VARCHAR( 8 ) NOT NULL ,
 `title` VARCHAR( 150 ) NOT NULL ,
PRIMARY KEY (  `class_id` ) ,
KEY  `class_name` (  `class_name` ) ,
KEY  `class_number` (  `class_number` )
) ENGINE = MYISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = latin1;"); 

mysql_query("
CREATE TABLE  `cbe_db`.`books" . $schid . "` (
`Book_ID` INT( 10 ) NOT NULL AUTO_INCREMENT ,
 `Title` VARCHAR( 233 ) NOT NULL ,
 `ISBN` VARCHAR( 50 ) DEFAULT NULL ,
 `Author` VARCHAR( 233 ) DEFAULT NULL ,
 `Picture_URL` VARCHAR( 233 ) NOT NULL ,
PRIMARY KEY (  `Book_ID` ) ,
KEY  `Title` (  `Title` ,  `Author` )
) ENGINE = MYISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = latin1");

echo "School has been added!";
}
?>