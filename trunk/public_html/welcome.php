<?php
include 'init_utils.php';  

$page_title = "CBE Home | " . ucwords($_SESSION['fullname']);
include 'layout/startlayout.php';
nav_menu($_SESSION['username'], 'home');
?>

<script type="text/javascript" src="scripts/classfunctions.js"></script>

<div class="page_info">
<p>

<table width=100%>
<tr valign='top'><td width=500px>
<h2><font color="#0000A0">Welcome, <b><?php echo ucwords($_SESSION['fullname']); ?></b> !</font></h2>
<br>
<div class='list'>
<ul class='fancylists'>
<?
welcome_info();
?>
</ul>
</div>
</td>
<td rowspan="2">
<div class='twitter' style='float:right; position:relative;'>
<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US"></script><script type="text/javascript">FB.init("a02c20a7d3dea568298484f329327b73");</script><fb:fan profile_id="221502719391" stream="1" connections="10" logobar="1" width="300"></fb:fan><div style="font-size:8px; padding-left:10px"><center><a href="http://www.facebook.com/pages/Morgantown-WV/The-College-Book-Evolution/221502719391">The College Book Evolution</a> on Facebook</center></div>
</table>
</div>

<?php
include 'layout/endlayout.php';
?>