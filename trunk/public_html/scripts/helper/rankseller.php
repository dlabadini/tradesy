<?php require_once('init_utils.php');?>


<?php
$class=$_GET["class"];
$number=$_GET["number"];

list($sellerid, $bks) = split(":", $_GET['sellerid']);
unset($bks);
$rank = $_GET['rank'];
$sql = "SELECT 1 FROM recent_ranks WHERE member_id = " . $_SESSION['userid'] . " AND seller_id = " . $sellerid . " LIMIT 1";
if (mysql_num_rows(mysql_query($sql)) > 0){
	echo "<span id='notification'>You have already rated this seller</span>";
}else{
    if ($rank == 1){
    	 $sql = "UPDATE members SET rank = rank + 1 WHERE member_id = " . $sellerid;
    }else{
    	 $sql = "UPDATE members SET rank = rank - 1 WHERE member_id = " . $sellerid;
    }
    mysql_query($sql) or die("<span id='notification'>Ranking failed. Please try again later</span>");
    $sql = "INSERT INTO recent_ranks VALUES (" . $_SESSION['userid'] . ", " . $sellerid . ")";
    mysql_query($sql);
    echo "<span id='notification'>Thanks for rating this seller!</span>";
}
?>