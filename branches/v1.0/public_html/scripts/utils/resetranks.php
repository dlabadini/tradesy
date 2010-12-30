<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/connection.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/session.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php");

$user = "";
$psswd = "";

// get credentials
$myFile = $_SERVER["DOCUMENT_ROOT"] . "/../.credentials";
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

// This script runs monthly and assigns new coupon codes to the marketers
// listed in the mk_coupons table.

// get all marketer member ids
$sql = "DELETE FROM recent_ranks";
mysql_query($sql) or die("delete ranks failed - " . mysql_error());
?>
				
				