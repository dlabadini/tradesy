<?php
require_once("/includes/connection.php");

$page_title = "Populating members_credits table";

echo "<html><head><title>" . $page_title . "</title><body>";

echo "<b>" . $page_title . "</b><br/><br/>";

$members = mysql_query("select member_id from members");
while($id = mysql_fetch_array($members)) {
  echo $id[0] . "<br/>";
  if(mysql_query("insert into
                  members_credits(member_id, bought, used, total_spent)
                  values ('" . $id[0] . "', '0', '0', '0')"))
    echo "true<br/>";
  else
    echo "false<br/>";
}
echo "</body></html>";

/*
Here is the SQL to create the members_credits table:

CREATE TABLE IF NOT EXISTS `members_credits` (
  `member_id` int(10) NOT NULL,
  `bought` int(5) NOT NULL COMMENT 'lifetime credits purchased',
  `used` int(5) NOT NULL COMMENT 'lifetime credits redeemed',
  `total_spent` decimal(10,2) NOT NULL COMMENT 'total cash spent on credits',
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
*/
?>