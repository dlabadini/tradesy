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
$sql = "SELECT member_id, coupon, date_given, users, name, email FROM mk_coupons a INNER JOIN members b USING(member_id)";
$marketers = mysql_query($sql);

//append to the coupons log file
$myFile = "../../admin/logs/marketer_earnings/" . date("m-d-Y") . ".csv";
$fh = fopen($myFile, 'a') or die("can't open file");
//$earned = 0.00;
$msg = "";
$body = "Marketer earnings for " . date("m/d/Y") . "\n\n";

fwrite($fh, "member id,name,email,coupon,users\n");

while($row = mysql_fetch_array($marketers)){
				$mkter = $row['member_id'];
				//$earned = (int)$row['users'] * 3.00;
				$msg = $msg . $row['member_id'] . "," . $row['name'] . ",<" . $row['email'] . ">,"  . $row['coupon'] . "," . $row['users'] . "\n";

				//reset users
				$sql = "UPDATE mk_coupons SET users = 0";
				mysql_query($sql);
	
				$body = $body . $msg . "\n";

				// write to log
				fwrite($fh, $msg);
                $msg = "";
				}

//email msg
$to = "devin.labadini@collegebookevolution.com";
$subject = "College Book Evolution Payroll";
if (mail($to, $subject, $body)) {
echo("<p>Message successfully sent!</p>");
} else {
echo("<p>Message delivery failed...</p>");
}

fclose($fh);

?>
				
