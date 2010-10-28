<?php
include 'init_utils.php';

$page_title = "CBE Home | " . ucwords($_SESSION['fullname']);
include 'layout/startlayout.php';
nav_menu($_SESSION['username'], 'home');
?>

Coming soon...

<?php
include 'layout/endlayout.php';
?>