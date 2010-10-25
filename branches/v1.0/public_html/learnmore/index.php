<?php
    $page_title = "CollegeBookEvolution Learn More";
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
<a class='side_link' href="javascript:void" onClick='loadInfo("intro", "display")'>Intro</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("tothestudents", "display")'>To the Students</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("toparents", "display")'>To the Parents</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("5ws", "display")'>5 W's</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("numbers", "display")'>By The Numbers</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("conclusion", "display")'>A Few Conclusions</a><br/><br />
<a class='side_link' href="javascript:void" onClick='loadInfo("subjects", "display")'>Subjects in Database</a><br/><br />


<?php
    include '../layout/sidebar_sublinks.html';
?>

</div>
<div class='sidemenu_content' id='display'>
<?
$ref = $_GET['ref'];
// if no reference was passed, load about.html as default, else load the reference page
if (empty($ref)){
    include 'intro.html';
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