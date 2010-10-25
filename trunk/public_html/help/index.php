<?php
    $page_title = "CollegeBookEvolution Help";
    include '../layout/external_info_layout.html';
?>

<div id="header">
    <div class='main_logo'>
    <div align='center'>
    	<a href="/"><img src="../images/page/full_logo.png" style="border-style:none;" /></a>
    </div>
    </div>
</div>

<div  class='container' style='width:800px'><br />
<table width='100%'><tr bgcolor="#FFFFFF" height="400px" valign="top"><td >

<div class='sidemenu'>
<a class='side_link' href="javascript:void" onClick='loadInfo("start", "display")'>Getting Started</a><br/><br />
<a class='side_link' href="http://www.collegebookevolution.com/tutorials" onClick='loadInfo("tutorial", "display")'>Tutorials</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("safety", "display")'>Communication & Safety Tips</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("suggest", "display")'>Make a Suggestion</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("faqs", "display")'>Frequently Asked Questions</a><br/><br />

<?php
    include '../layout/sidebar_sublinks.html';
?>

</div>
<div class='sidemenu_content' id='display'>
<?
$ref = $_GET['ref'];
// if no reference was passed, load about.html as default, else load the reference page
if (empty($ref)){
    include 'start.html';
}else{
    include $ref . ".html";
}
?>
</div>
</div>


</td></tr>
<tr><td>
<p style='float:left;'><span id='subscript' style='color:black;'>
	 &nbsp; &copy; CollegeBookEvolution.com, LLC.
</span></p>
<p style='float:right;'>
<span id='subscript'>
    <?php
        include '../layout/footer_links.html';
    ?>
</span>
</p>
</td></tr>
</table>
</body>
</html>