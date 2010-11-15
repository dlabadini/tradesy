<?php
    $page_title = "Jin's Business Tools";
    include '../layout/external_info_layout.html';
?>


<div  class='container' style='width:800px'><br />
<table width='100%'><tr bgcolor="#FFFFFF" height="400px" valign="top"><td >

<div class='sidemenu'>
<a class='side_link' href="javascript:void" onClick='loadInfo("summary", "display")'>Summary</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("input", "display")'>Revenue</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("expense", "display")'>Expenses</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("print", "display")'>Financial Statements</a><br/><br />
<br/><br />



<?php
    include '../layout/sidebar_sublinks.html';
?>

</div>
<div class='sidemenu_content' id='display'>
<?
$ref = $_GET['ref'];
// if no reference was passed, load about.html as default, else load the reference page
if (empty($ref)){
    include 'summary.html';
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