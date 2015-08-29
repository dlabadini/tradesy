<?php require_once("../../includes/session.php"); ?>
<?php require_once("../../includes/connection.php");?>
<?php require_once("../../includes/functions.php");?>
<?php
// clear all messages
//$sql = "DELETE FROM member_messages";

/*
for each user
	- get list of books still needed
	- for each book
		- see who is selling it at the cheapest price
		- if seller is found
			- get list of books seller needs
			- if user has any of these books
				- save the list of books that could be traded
			- inform user that seller has the book needed
				- and needs the following books owned by user.
*/

$tradeable = array();
$sql = "SELECT member_id, username FROM members";
$allmembers = mysql_query($sql);

function getBookTitle($bkid){
  $sql = "SELECT title FROM books WHERE book_id = " . $bkid;
  $res = mysql_fetch_array(mysql_query($sql));
  return $res['title'];
}

while ($member = mysql_fetch_array($allmembers)){
    // for each member, see if member has subscribed to automated notifications
    echo "<br /><br />books needed by <b>" . $member['username'] . "</b><br />";
    // get list of books still needed
    $tradeable = array();
    $member_booksneeded = get_books_still_needed($member['member_id']);

    // for each book
    while ($book = mysql_fetch_array($member_booksneeded)){
      // see who is selling it at the cheapest price
      $sql = "SELECT member_id, ask_price FROM members_books WHERE book_id = " . $book['book_id'] . " AND ask_price != -1 ORDER BY ask_price LIMIT 1";
      $result = mysql_query($sql);
      if (mysql_num_rows($result) > 0){  // if seller is found
            // get list of books seller needs
            $seller = mysql_fetch_array($result);
            $seller_booksneeded = get_books_still_needed($seller['member_id']);
            while ($sb = mysql_fetch_array($seller_booksneeded)){
              $sql = "SELECT 1 FROM members_books WHERE member_id = " . $member['member_id'] . " AND book_id = " . $sb['book_id'];
              $result = mysql_query($sql);
              if (mysql_num_rows($result)){  // user has book seller needs
                  $tradeable[] = $sb['book_id'];
              }
            }


        echo "> title = " . getBookTitle($book['book_id']) . "<br />";

        $sql = "SELECT username FROM members WHERE member_id = " . $seller['member_id'];
        $sellername = mysql_fetch_array(mysql_query($sql));
        echo "  > seller_id: " . $sellername['username'] . "<br />";
        echo "  > ask_price: $" . $seller['ask_price'] . "<br />";
        echo "  > tradeable books: " . count($tradeable) . "<br />";
        if (count($tradeable)){
            for ($x = 0; $x < count($tradeable); $x++){
              echo "&nbsp;&nbsp;>> book: " . getBookTitle($tradeable[$x]);
            }
        }
        echo "<br />";
      }
    }
}
?>