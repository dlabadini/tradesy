<?php
    require_once('init_utils.php');

    $page_title = "CBE Chat";
    include 'layout/startlayout.php';
    nav_menu($_SESSION['username'], 'chat');
?>

<div class="page_info" >

<iframe src="http://webchat.quakenet.org/?nick=<? echo $_SESSION['username'] ?>&channels=collegebookevolution" style='width: 100%; height: 400px; margin: 0px;'></iframe>

<br/><br/>

<a href="javascript:;" onclick="togglediv('quickhelp');">Quick Tips</a>
<div id="quickhelp" style="display: none;" >
<ul>
<li><b>Private message:</b> /msg nickname message (eg. /msg Bob hello!)</li>
<li><b>Message several people:</b> /msg nickname1, nickname2 message (eg. /msg Bob,Steve hello!)</li>
<li><b>Security:</b> This chat room exposes your IP address for authenticity. If you are uncomfortable with this, you may <i>hide</i> your IP address.</li>
</ul>

</div>
</div>
<?php
    include 'layout/endlayout.php';
?>
