<?php
$page_title = "Confirm purchase | " . ucwords($_SESSION['fullname']);
include 'init_utils.php';
include 'layout/startlayout.php';
nav_menu($_SESSION['username'], '');
?>

<div class="page_info">

<?
// The below code was autogenerated by paypal's tool at
// https://www.paypaltech.com/PDTGen/generate_pdt.php
// and modified to suit cbe's purposes

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-synch';

$tx_token = $_GET['tx'];

//echo "tx token: " . $tx_token . "<br/><br/>";

$auth_token = "5nVjhF2kHnu0XZS9NkSIct01zBcdJpeR7ch-qjb9xYzc5h3qx1RmjAabdNy";

$req .= "&tx=$tx_token&at=$auth_token";


// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
// If possible, securely post back to paypal using HTTPS
// Your PHP server will need to be SSL enabled
// $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

if (!$fp) {
    // HTTP ERROR
       } else {
    fputs ($fp, $header . $req);
    // read the body data
    $res = '';
    $headerdone = false;
    while (!feof($fp)) {
        $line = fgets ($fp, 1024);
         if (strcmp($line, "\r\n") == 0) {
            // read the header
               $headerdone = true;
               }
         else if ($headerdone)
         {
            // header has been read. now read the contents
               $res .= $line;
               }
         }

    // parse the data
    $lines = explode("\n", $res);
    $keyarray = array();
    if (strcmp ($lines[0], "SUCCESS") == 0) {
        for ($i=1; $i<count($lines);$i++){
            list($key,$val) = explode("=", $lines[$i]);
            $keyarray[urldecode($key)] = urldecode($val);
            }
        // check the payment_status is Completed
        // check that txn_id has not been previously processed
        $trans = mysql_query("select transaction_id from members_transactions where transaction_id=$tx_token");
        $trow = mysql_fetch_array($trans);
        echo $trow['transaction_id'] . '<br/>';
        if($trow['transaction_id'] == $tx_token) {
          $tinsert = mysql_query("insert into members_transactions (member_id, transaction_id, gross, fee, date) values ('" . $_SESSION['userid'] . "', '$tx_token', '" . $keyarray['mc_gross'] . "', '" . $keyarray['mc_fee'] . "', '" . date("Y-m-d H:i:s") . "')");
          if(!$tinsert) {
            echo "error: " . mysql_error();
          }
        } else {
          echo "This transaction has already been processed.";
          exit();
        }
        // check that receiver_email is your Primary PayPal email
        // check that payment_amount/payment_currency are correct
        // process payment
        $firstname = $keyarray['first_name'];
        $lastname = $keyarray['last_name'];
        $itemname = $keyarray['item_name'];
        $amount = $keyarray['mc_gross'];
        $credits = strtok($keyarray['option_selection1'],' ');
//        echo $credits . "<--- credits keyy array ->>" . $keyarray['option_selection1'];

        // update the credits and total spent in the database
        mysql_query("update members_credits set bought=bought+$credits" .
                    ", total_spent=total_spent+$amount" .
                    "where member_id='" . $_SESSION['userid'] . "'");

        // get the new total credits
        $res = mysql_fetch_array(mysql_query("select bought, used from " .
                                             "members_credits where " .
                                             "member_id = '" .
                                             $_SESSION['userid'] . "'"));
        $newcred = (int)$res['bought'] - (int)$res['used'];

        echo ("<p><h3>Thank you for your purchase!</h3></p>");

        echo ("<b>Payment Details</b><br>\n");
        echo ("<li>Name: $firstname $lastname</li>\n");
        echo ("<li>Item: Book credits ($credits)</li>\n");
        echo ("<li>Amount: $amount</li>\n");
        echo ("<li>Credits: $newcred</li>\n");
        echo ("");
        }
    else {
        echo "<b>The purchase could not be completed.</b><br/>";
        echo "If you have reached this page in error, please <a href='mailto:support@collegebookevolution.com'>contact us.</a><br/>";
/*        echo "<pre>";
        foreach($lines as $line) {
            echo $line . '<br/>';
        }
        echo "</pre>"; */
    }


}

fclose ($fp);
?>

</div>

<?
include 'layout/endlayout.php';
?>