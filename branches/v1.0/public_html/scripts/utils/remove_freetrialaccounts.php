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

// This script will run on 01/01/2010 and delete all free tiral accounts
$sql = "SELECT member_id FROM member_subscriptions WHERE subscription_id = -1";
$mids = mysql_query($sql);
echo "Removing all Free Trial accounts...<br/>";
while ($id = mysql_fetch_array($mids)){
    $sql = "delete from members where member_id = " . $id['member_id'];
    mysql_query($sql);
    echo "removed from members<br/>";
    $sql = "delete from members_contacts where member_id = " . $id['member_id'];
    mysql_query($sql);
    echo "removed from members_contacts<br/>";
    $sql = "delete from members_classes where member_id = " . $id['member_id'];
    mysql_query($sql);
    echo "removed from members_classes<br/>";
    $sql = "delete from members_books where member_id = " . $id['member_id'];
    mysql_query($sql);
    echo "removed from members_books<br/>";
    $sql = "delete from class_locks where member_id = " . $id['member_id'];
    mysql_query($sql);
    echo "removed from class_locks<br/>";
    $sql = "delete from password_resets where member_id = " . $id['member_id'];
    mysql_query($sql);
    echo "removed from password_resets<br/>";
    $sql = "delete from recent_ranks where member_id = " . $id['member_id'];
    mysql_query($sql);
    echo "removed from recent_ranks<br/>";
    }
$sql = "delete from pending_subscriptions where subscription_id = -1";
mysql_query($sql);
echo "removed from pending_subscriptions<br/>";
echo "<br/>removing subscription information...<br/>";
$sql = "delete from member_subscriptions where subscription_id = -1";
mysql_query($sql);
echo "Done!";
