<?php
    $page_title = "Employee Central";
    include '../layout/external_info_layout.html';
?>


<div  class='container' style='width:800px'><br />
<table width='100%'><tr bgcolor="#FFFFFF" height="400px" valign="top"><td >

<div class='sidemenu'>
<a class='side_link' href="javascript:void" onClick='loadInfo("welcome", "display")'>Welcome</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("timetable", "display")'>Timetable</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("project", "display")'>Project Files</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("contacts", "display")'> Contact List</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("chat", "display")'>Chat</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("suggestions", "display")'>Submit Suggestion</a><br/><br />


</div>
<div class='sidemenu_content' id='display'>
<?
$ref = $_GET['ref'];
// if no reference was passed, load about.html as default, else load the reference page
if (empty($ref)){
    include 'welcome.html';
}else{
    include $ref . ".html";
}
?>
</div>
</div>


</td></tr>
</table>
</body>
</html>