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
$sql = "SELECT member_id, coupon FROM mk_coupons";
$marketers = mysql_query($sql);

//append to the coupons log file
$myFile = $_SERVER["DOCUMENT_ROOT"] . "/admin/logs/marketerCoupons.txt";

$fh = fopen($myFile, 'a') or die("can't open file");

while($row = mysql_fetch_array($marketers)){
				$mkter = $row['member_id'];
				
				// if there's an account pending activation with this marketer's coupon, skip
				$sql = "SELECT 1 FROM pending_subscriptions WHERE coupon = '" . $row['coupon'] . "' LIMIT 1";
				if (mysql_result(mysql_query($sql), 0, 0) == 1){
					 continue;
				}
				
				$coupon = generate_coupon();
				$sql = "UPDATE mk_coupons SET coupon = '" . $coupon . "', date_given = '" . date("Y-m-d") . "', users = 0 WHERE member_id = " . $mkter;
				mysql_query($sql) or die(mysql_error());
				$log = $mkter . ", " . $coupon . ", " . date("Y-m-d") . "\n";
				//echo $log;
				fwrite($fh, $log);
				}

fclose($fh);

?>
				
				