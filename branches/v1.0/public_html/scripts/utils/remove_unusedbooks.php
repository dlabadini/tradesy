<?php require_once("../../includes/session.php"); ?>
<?php require_once("../../includes/connection.php");?>
<?php require_once("../../includes/functions.php");?>
<?php

/* Removes books from the books table that are neither referenced
    in members_books nor schools_classes table
*/

$user = "";
$psswd = "";

// get credentials
$myFile = "../../../../.credentials";
$fh = fopen($myFile, 'r');
$data = fread($fh, filesize($myFile));
list($user, $psswd) = split(":", $data);
fclose($fh);

//check authentication
if (($_GET['adminID'] != $user) and ($_GET['adminpswd'] != $psswd)){
	 ?>
	  <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
    <html><head>
    <title>401 Authorization Required</title>
    </head><body>
    <h1>Authorization Required</h1>
    <p>This server could not verify that you
    are authorized to access the document
    requested.  Either you supplied the wrong
    credentials (e.g., bad password), or your
    browser doesn't understand how to supply
    the credentials required.</p>
    </body></html>
		<?
	 exit;
	 }

$sql = "DELETE FROM books WHERE book_id NOT IN " .
       "( SELECT book_id FROM members_books )AND book_id NOT IN ( SELECT book_id FROM schools_classes )";
mysql_query($sql) or die("Failed to remove unreferenced books - " . mysql_error());
echo "<br/>Records deleted: " . mysql_affected_rows();

?>




