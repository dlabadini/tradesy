<?php
    $page_title = "CollegeBookEvolution Tutorials";
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
<a class='side_link' href="#tutorials" onClick='loadInfo("tutorials", "display")'>Tutorials</a><br/><br />
<ul>
<li><a class='side_link' href="#addclass" onClick='loadInfo("addclass", "display")'>Adding a class</a><br/><br /></li>
<li><a class='side_link'href="#dropclass" onClick='loadInfo("dropclass", "display")'>Dropping a class</a><br/><br /></li>
<li><a class='side_link' href="#addbook" onClick='loadInfo("addbook", "display")'>Adding a book</a><br/><br /></li>
<li><a class='side_link' href="#changeinfo" onClick='loadInfo("changeinfo", "display")'>Edit Account Info</a><br/><br /></li>
<li><a class='side_link' href="#bartertrade" onClick='loadInfo("bartertrade", "display")'>Barter Trade</a><br/><br /></li>
<!--<li><a class='side_link' href="#searchbook" onClick='loadInfo("searchbook", "display")'>Searching for books</a><br/><br /></li>
--></ul>
<a class='side_link' href="http://www.collegebookevolution.com/help">Help</a>

<?php
    include '../layout/sidebar_sublinks.html';
?>


</div>
<div class='sidemenu_content' id='display'>
<?
$ref = $_GET['ref'];
// if no reference was passed, load about.html as default, else load the reference page
if (empty($ref)){
    include 'tutorials.html';
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