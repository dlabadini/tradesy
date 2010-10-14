<?php
session_start();
$root = $_SERVER["DOCUMENT_ROOT"];
if (strpos($root, "xampp") == false){
  require_once($root . "/includes/connection.php");
  require_once($root . "/includes/functions.php");
}else{
  require_once("\includes/connection.php");
  require_once("\includes/functions.php");
}
?>