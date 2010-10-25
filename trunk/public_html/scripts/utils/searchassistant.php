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

/*
for each user
	- get list of books still needed
	- for each book
		- see if there are any sellers at all
		- if seller is found
            - add the book to list of books found
    - when done, email the current user
*/

$sql = "SELECT name, member_id, school_id, username, preferred_email FROM members";
$allmembers = mysql_query($sql);

function getBookTitle($bkid, $schid){
  $sql = "SELECT title FROM books" . $schid . " WHERE book_id = " . $bkid;
  $res = mysql_fetch_array(mysql_query($sql));
  return $res['title'];
}

function sendMail($to, $message, $count){
    //$to = "w.w.mensah@gmail.com"; // for testing
    $from = "CollegeBookEvolution <support@collegebookevolution.com>";
    $subject = "We've found sellers for " . $count . " of your books";

    // To send the HTML mail we need to set the Content-type header.
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers  .= "From: $from\r\n";

    mail($to, $subject, $message, $headers);

	echo "Sent message to " . $to . "...<br/>";
}

while ($member = mysql_fetch_array($allmembers)){
    // for each member, see if member has a paid account and has subscribed to automated notifications
    if (subscription_type($member['member_id']) < 0){ // free account
      break;
    }
    
    $sql = "SELECT auto_search_notification FROM members_prefs WHERE member_id = " . $member['member_id'];
    if (!mysql_num_rows(mysql_query($sql))){
        break;
    }
    // get list of books still needed
    $member_booksneeded = get_books_still_needed($member['member_id']);
    $booksfound;
    $totalfound = 0;

    // for each book
    while ($book = mysql_fetch_array($member_booksneeded)){
      // see if there are any sellers
      $sql = "SELECT 1 FROM members_books WHERE book_id = " . $book['book_id'] . " LIMIT 1";
      $result = mysql_query($sql);
      if (mysql_num_rows($result) > 0){  // if seller is found
            $totalfound++;
            $booksfound .= "- " . getBookTitle($book['book_id'], $member['school_id']) . "<br />";
      }
    }
    if ($totalfound){
		$msg = "<html><body style='font-family: Arial, Helvetica, sans-serif; font-size: 13px;'>";
        $msg .= "Hello " . $member['name'] . ",<br /><br />We've found sellers for " . $totalfound . " of your books:<br /><br />";
        $msg .= $booksfound . "<br />";
        $msg .= "Click <a href='http://www.collegebookevolution.com'>here</a> to login to CollegeBookEvolution and contact these sellers. <br />";
        $msg .= "<br />Thanks,<br />CollegeBookEvolution<br /><br /><span style='font-size: 11px;'>You can disable these notifications under My Account once you've logged in.</span><br /><br />";
        $msg .= "</body></html>";
        sendMail($member['preferred_email'], $msg, $totalfound);
        $sql = "UPDATE members_prefs SET last_sent = '" . date("Y-m-d") . "' WHERE member_id = " . $member['member_id'];
        mysql_query($sql);

    }
    $booksfound = "";
}
?>