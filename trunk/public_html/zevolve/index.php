<?php
require_once 'library/config.php';
require_once 'library/category-functions.php';
require_once 'library/product-functions.php';
require_once 'library/cart-functions.php';
$pageTitle = 'eVOLVE Shop';

$_SESSION['shop_return_url'] = $_SERVER['REQUEST_URI'];

$catId  = (isset($_GET['c']) && $_GET['c'] != '1') ? $_GET['c'] : 0;
$pdId   = (isset($_GET['p']) && $_GET['p'] != '') ? $_GET['p'] : 0;
?>

<!--not display --->
<?php
if ($pdId) {
	require_once 'include/productDetail.php';
} else if ($catId) {
	require_once 'include/productList.php';
}
?>
<!--end-->
<br/>
<?php include 'include/startlayout.php'; ?>
<br/>
<body onload="RunSlideShow('im', 'ads', 'images/slide/lance.jpg;images/slide/lance1.jpg;images/slide/lance2.png', 6)">

<div id="page">
<!--======== LEFT SIDEBAR ========-->

<div class='hrline'></div>
<!--
<? include("include/leftNav.php"); ?>
-->
<? include("include/leftmenu.php"); ?>
    </div>
 <!--======== PAGE CONTENT ========-->
    <div id="page_content">
 <? include("include/topmenubar.php"); ?>

      <div style="text-align: center" id="bigImage" class="big_img" onclick="window.open('http://collegebookevolution.com/');">
        <table style='border: 0px; height: 500px; width: 100%; text-align: center;'>
          <tr valign='middle' align='center'>
            <td>
              <div id='ads' class='ads_and_logos'>
                <img name="im" id="im" src="images/slide/1.png" /><img id='shadow' src='images/forlooks/shade.jpg' style='position:relative; top:-5px;' name="shadow" />
              </div>
            </td>
          </tr>
        </table>
      </div>

      <div id="thumbs_display" class="thumbnails_frame content">
      </div>

      <div id="item_desc" class="desc_div main_font">
        <span style='float:left;'><b>UPDATES</b><br />
        Welcome to our new eVOLVE sHOP.</span> <span style='float: right; padding:10px;'><a href='http://www.facebook.com/pages/Morgantown-WV/The-College-Book-Evolution/221502719391?ref=nf' target='_blank'><img src='images/forlooks/facebook.png' alt='facebook' title='Be a fan on Facebook' /></a> <a href='http://twitter.com/cbevolution' target='_blank'><img src='images/forlooks/twitter.png' alt='twitter' title='Follow us on Twitter' /></a></span>
  </div>
<!--<div class="content main_font footer" align='center'
    style="opacity:.2;filter:alpha(opacity=20)"
    onmouseover="this.style.opacity=1;this.filters.alpha.opacity=100"
    onmouseout="this.style.opacity=.2;this.filters.alpha.opacity=20"> -->
      <!--<div class="content main_font footer" align='center' >
        All images &copy; CollegeBookEvolution.com, LLC. or their respective brands
        <img src="images/logos/cbe_slogo1.png" style="vertical-align:middle;"/>
</div>-->
    </div>
    <!--======== RIGHT SIDEBAR ========-->
    <div id="right_sidebar" class="main_font">
      <div class="content">
        <span class="nav_menu" style='padding:2px;'><a href="cart.php?action=view">VIEW CART</a></span><br />
        <span style='position:relative; top:5px;'>Items: <span id='itmcnt'><php echo ("hello"); ?></span></span>
      </div>

      <div id="rsidebar_content" style='display:none;'>
        <div id="iteminfo" class="item_info content"></div>

        <div id="additem" class="content"></div>

        <div id="minithumbs" class="content"></div>
      </div>

      <div id="notification" class="content" style='position:relative; float: left; top: 15px;'></div>
    </div>
  </div>
<br/>
<?php
include 'include/footer.php';
?>


