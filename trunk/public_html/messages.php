<?php
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
    require_once('init_utils.php');

    // first handle any POST situations
    if(isset($_POST['action'])) {
        /*if($_POST['action'] == "create") {
            // check the list of memberids

            // convert the memberids into an array
            $threadid = create_thread($to, $subj, $message);
            if(!$threadid) {
                echo "Error creating message";
            } else {
                echo "<meta http-equiv='refresh' content='0;messages.php?nav=thread&t=$threadid'>";
                echo "Message posted!";
            }
            exit;
        }*/
        if($_POST['action'] == "reply") {
            $postid = reply_to_thread($_POST['thread'], $_POST['data']);
            if(!$postid) {
                echo "You do not have access to this thread";
            } else {
                echo "<meta http-equiv='refresh' content='0;messages.php?nav=thread&t=".$_POST['thread']."'>";
                echo "Message posted!";
            }
            exit;
        }
        if($_POST['action'] == "hide") {
            $hidden = hide_thread($_POST['thread']);
            if(!$hidden) {
                echo "You do not have access to this thread";
            } else {
                echo "<meta http-equiv='refresh' content='0;messages.php?nav=inbox&msg=Thread%20moved%20to%20trash'>";
                echo "Thread moved to trash!";
            }
            exit;
        }
        if($_POST['action'] == "unhide") {
            $unhidden = unhide_thread($_POST['thread']);
            if(!$unhidden) {
                echo "You do not have access to this thread";
            } else {
                echo "<meta http-equiv='refresh' content='0;messages.php?nav=trash&msg=Thread%20moved%20to%20inbox'>";
                echo "Thread moved to trash!";
            }
            exit;
        }
        if($_POST['action'] == "delete") {
            $deleted = delete_thread($_POST['thread']);
            if(!$deleted) {
                echo "You do not have access to this thread";
            } else {
                echo "<meta http-equiv='refresh' content='0;messages.php?nav=trash&msg=Thread%20deleted'>";
                echo "Thread deleted!";
            }
            exit;
        }
    }

    $page_title = "CBE Classes | " . ucwords($_SESSION['fullname']);
    include 'layout/startlayout.php';
    nav_menu($_SESSION['username'], 'messages');
?>

<style>
div.mail_main {
  position: relative;
  margin-left: 120px;
  margin-top: -63px;
  margin-bottom: 50px;
}

#navlist li {
  list-style-type:none;
  list-style-image:none;
}

li.selected {
  font-weight: bold;
}

p#box-name {
  font-weight: bold;
  font-size: larger;
}

ul#boxlist {
  margin-top: -10px;
}

#boxlist li {
  list-style-type:none;
  list-style-image:none;
  border-style: solid;
  border-width: thin;
  padding: 1px;
  position: relative;
  margin-top: -1px;
  margin-left: -40px;
}

p#thread-subject {
  font-size: larger;
  font-weight: bold;
}

p#thread-members {
  text-align: center;
  margin-top: -10px;
  margin-bottom: 0px;
}

span.thread-member {
  color: darkblue;
}

span.post-poster {
  font-weight: bold;
}

span.post-time {
  font-style: italic;
}

span.item-poster {
  font-weight: bold;
}

span.item-subject {
  position: absolute;
  padding-left: 80px;
}
</style>

<div class="page_info" >

<div class="mail_nav">
<?
echo "<ul id='navlist'><li";
if($_GET['nav'] == "inbox" or !isset($_GET['nav'])) echo " class='selected'";
echo "><a href='messages.php?nav=inbox'>Inbox</a></li><li";
if($_GET['nav'] == "drafts") echo " class='selected'";
echo "><a href='messages.php?nav=drafts'>Drafts</a></li><li";
if($_GET['nav'] == "trash") echo " class='selected'";
echo "><a href='messages.php?nav=trash'>Trash</a></li></ul>";
?>
</div>

<div class="mail_main">
<?
if($_GET['nav'] == "inbox" or !isset($_GET['nav']))
    show_inbox();
if($_GET['nav'] == "thread") {
    if(display_thread($_GET['t'])) {
        ?>
<form name="threadform" action="messages.php" method="POST">
<textarea name="data" rows=5 cols=80></textarea>
<input type="hidden" name="action" value="reply"/>
<input type="hidden" name="thread" value="<? echo $_GET['t'] ?>"/>
<br/>
<input type="submit" value="Reply" onclick="document.threadform.action.value='reply'"/>
        <?
        if(thread_visible($_GET['t'])) {
            ?>
<input type="submit" value="Trash" onclick="document.threadform.action.value='hide'"/>
            <?
        } else {
            ?>
<input type="submit" value="Unhide" onclick="document.threadform.action.value='unhide'"/>
<input type="submit" value="Delete" onclick="document.threadform.action.value='delete'"/>
            <?
        }
        ?>

</form>
        <?
    }
}
if($_GET['nav'] == "trash")
    show_trash();
?>
</div>

</div>

<?php
    include 'layout/endlayout.php';
?>