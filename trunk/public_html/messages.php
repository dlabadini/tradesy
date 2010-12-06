<?php
    require_once('init_utils.php');

    $page_title = "CBE Classes | " . ucwords($_SESSION['fullname']);
    include 'layout/startlayout.php';
    nav_menu($_SESSION['username'], 'messages');

    /*
    The messages system uses 3 database tables:
        * messages_threads has a row for every thread
        * messages_access tracks who has visibility of a given thread
        * messages_posts has all the posts made in a given thread

    Because a thread is common to multiple users, one user deleting the thread
    should not remove it from everyone's inbox. Thus, messages_access has a
    hidden column that is set to true if a user has deleted a thread. When
    checking for thread access this field should not be used, but when
    populating a user's inbox it should.

    Here is the sql used to generate the reqired tables:

CREATE TABLE  `cbe_db`.`messages_threads` (
`thread_id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`op` INT( 10 ) NOT NULL COMMENT  'member id of original poster',
`subject` TINYTEXT NOT NULL ,
`create_date` TIMESTAMP NOT NULL
) ENGINE = MYISAM ;

CREATE TABLE  `cbe_db`.`messages_access` (
`thread_id` INT( 10 ) NOT NULL ,
`member_id` INT( 10 ) NOT NULL ,
`hidden` BOOL NOT NULL DEFAULT  '0' COMMENT  'whether this user has hidden the thread'
) ENGINE = MYISAM COMMENT =  'for each member that has access to a thread, a row exists';

CREATE TABLE  `cbe_db`.`messages_posts` (
`post_id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`thread_id` INT( 10 ) NOT NULL COMMENT  'thread this post is in',
`member_id` INT( 10 ) NOT NULL COMMENT  'member id that made this post',
`post_date` TIMESTAMP NOT NULL ,
`data` TEXT NOT NULL COMMENT  'contents of the post'
) ENGINE = MYISAM ;
    */

?>

<script type="text/javascript">
function nav_select(page) {
  // navigate to the appropriate messages page
  document.navform.nav.value = page;
  document.navform.submit();
}
</script>

<style>
#navlist li {
  list-style-type:none;
  list-style-image:none;
}

li.selected {
  font-weight: bold;
}
</style>

<div class="page_info" >

<div class="mail_nav">
<form action="messages.php" name="navform" id="navform" method="GET">
<input type=hidden id="nav" name="nav" value="
<?
echo $_GET['nav'];
?>
"/>
<?
echo "<ul id='navlist'><li";
if($_GET['nav'] == "inbox" or !isset($_GET['nav'])) echo " class='selected'";
echo "><a href='javascript:nav_select(\"inbox\")'>Inbox</a></li><li";
if($_GET['nav'] == "drafts") echo " class='selected'";
echo "><a href='javascript:nav_select(\"drafts\")'>Drafts</a></li><li";
if($_GET['nav'] == "outbox") echo " class='selected'";
echo "><a href='javascript:nav_select(\"outbox\")'>Outbox</a></li></ul>";
?>
</form>
</div>

<div class="mail_main">

</div>

</div>

<?php
    include 'layout/endlayout.php';
?>