<?php
/**
Filename: init_utils.php
URL: www.collegebookevolution.com/init_utils.php
Author: William Mensah (www.wilmens.net)
Date Created: 12/2009
Last Modified: 07/2010

Purpose:
	- Initialization file for all php scripts used to run the site
	
Requires:
	- session_start()
	
Optional POST parameters:
	- n/a

Functionalilty:
	- 	Makes a connection with the backend database by calling connection.php
	- 	Loads all functions needed to run the site by calling functions.php
	- 	session_start() is called to check for user authentication
	- 	Whether localhost is being used or not determines what the path to 
		connection.php and functions.php should be
	
Function Calls:
	- session_start()
	
	
*************************************************************************************************
*/
session_start();

$root = $_SERVER["DOCUMENT_ROOT"];
if (strpos($root, "xampp") == false){
  require_once($root . "/includes/connection.php");
  require_once($root . "/includes/functions.php");
}else{
  require_once("\includes/connection.php");
  require_once("\includes/functions.php");
}

if (!is_authed()){
    echo "<div align='center' style='font-family:Arial, Helvetica, sans-serif; font-size:0.8em;'>
            <img src='images/cbe_logo.gif' />
            <p>
            Sorry, you need to <a href='index.php'>login</a> to see this page...
            </p>
        </div>";
    exit;
}
?>