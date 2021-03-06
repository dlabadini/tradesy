<? session_start(); ?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php
	/* if the user has already been authenticated, direct him/her to the welcome page */
    if (is_authed()){
		echo '<META http-equiv="refresh" content="0;URL=welcome.php">';
		exit();
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>College Book Evolution</title>

<meta name="google-site-verification" content="J-VCE_Hejym4_YvJdOQ9hkSAhhTtd4tbnvOCIxTqB3Y" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="DESCRIPTION" content="Buy, sell, trade college textbooks with classmates." />
<meta name="KEYWORDS" content="CollegeBookEvolution, college book evolution, Textbooks, barter trade, book, evolution, college book evolution" />
<meta name="ROBOTS" content="ALL, INDEX, FOLLOW" />

<link rel="stylesheet" type="text/css" href="css/master.css" />
<link REL="SHORTCUT ICON" HREF="images/icons/favicon.ico">

<?php
if(isset($_POST['submit'])){
    $username =($_POST['username']);
    $password= ($_POST['password']);
    if(user_login($username, $password)){
    	echo '<META http-equiv="refresh" content="0;URL=welcome.php">';
    	exit;
    }else {
        //username and password coudn't found in the database
        $login_error = "Error: Invalid Email/Password combination";
    }
}else{ //Form has been submitted
   if(isset($_GET['logout']) && $_GET['logout'] == 1) {
   		$message = "You are now logged out.";
    }
  	$username="";
  	$password="";
}
?>

<!--[if lt IE 7.]>
<script defer type="text/javascript" src="scripts/pngfix.js"></script>
<![endif]-->

<script type="text/javascript">
 <!--
 function are_cookies_enabled(){
   var tmpcookie = new Date();
   chkcookie = (tmpcookie.getTime() + '');
   document.cookie = "chkcookie=" + chkcookie + "; path=/";
    if (document.cookie.indexOf(chkcookie,0) < 0) {
      return false;
      }
    else {
      return true;
    }
   }
 //-->
</SCRIPT>

</head>
<body class='main_font'onload='document.login.username.focus();'>
<div align="center">

<!-- main logo -->
<div ><img src="images/cbe_logo.gif" alt="collegebookevolution"/></div>

<div class='bgblackbanner'>

<table width="900" border="0" class="wob-font main-font">
<tr>

<!-- left frame -->
<td width="200" class="main-font" align='left'>
    <p>
        <h2>
        Buy, Sell, Trade<br/>
        with classmates</h2>
    </p>
</td>

<!-- middle frame -->
<td width="300">
    <img src="images/books.png" alt='books' />
</td>

<!-- right frame (login) -->
<td width="300">

<? if (isset($login_error)){ ?>
  <div id='errormsg' class="main-font" style="position: absolute; top:150px;">
    <? echo $login_error; unset($login_error);?>
  </div>
<? } ?>

<form id='login' action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="post" enctype="multipart/form-data" name="login" onSubmit='if (!are_cookies_enabled()) { alert("Please enable cookies for your browser first"); return false;}'>

<!-- login table -->
<table  height="350px" bordercolor="white" border="1">
    <tr><td width="300" valign='middle'>
    <div align="center">

      	<table style='border:none;'>

                <!-- username -->
                <tr>
                    <td align="right">Username:</td>
    				<td align='right'><input class='input' style="width:130px;" id="username" name="username"
    				    <?php if (isset($_POST['username'])) { ?> value="<?php echo $_POST['username']; ?>" <?php } ?> />
                    </td>
                </tr>

                <!-- password -->
                <tr>
                    <td align="right">Password:</td>
                    <td align='left'><input class='input' id="password" style="width:130px;" name="password" type="password" />
                    </td>
                </tr>

          </table>

          <br /><input name="submit" type="submit" value="Login" />

          <p><a class='linkonblack' href="forgotpassword.php">Forgot your password?</a> &nbsp; | &nbsp; <a class='linkonblack' href="help">Help</a></p>
          <a class='linkonblack' href="register.php" onclick='if (!are_cookies_enabled()) { alert("Please enable cookies for your browser first"); return false;}'><font size="+2">Sign Up</font></a>
          </div>
      </td></tr>
</table>

</form>

</td></tr></table> <!-- end of right frame -->

</div> <!-- end of bgblackbanner -->

<div align="center">
<p>
<br />
<table id="pior-footer" border="0" cellpadding="2" class="main-font">
  <tr valign='top'>

    <!-- Learning Center -->
  	<td width="60"><img src="images/icons/info.png" alt='learning center' /></td>
    <td width="230" align='left'>
    <h2 class='big'>Learning Center</h2>
    <a class='linkonwhite' href="/learnmore" target="_blank">Learn more</a> about the evolution.</td>

    <!-- Tutorials -->
    <td width="60"><img src="images/icons/tutorial.png" alt='tutorial' /></td>
    <td width="230" align='left'>
    <h2 class="big">Tutorials</h2>
    Watch <a class='linkonwhite' href="/tutorials" target="_blank">video tutorials</a> on how to use<br/> the site.</td>

    <!-- 5 Ws -->
    <td width="60" valign="top"><img src="images/icons/support.png" alt='support' /></td>
    <td width="230" valign='top' align='left'>
    <h2 class="big">5 W's</h2>
	<div align='left'><a class='linkonwhite' href='/learnmore/?ref=5ws' target='_blank'>Read</a> about the foundation on which<br/>College Book Evolution is built.<br/>
	</div>
	</td>
  </tr>
</table>  <br/>

<a href='http://twitter.com/cbevolution' target='_blank'>
<img src='images/twitter.png' border="0"/>
</a>
&nbsp;&nbsp;
<!-- site lock logo -->
<img border="0" src="//shield.sitelock.com/shield/collegebookevolution.com" alt='sitelock' id="sl_shield_image" style="cursor: pointer;"/>
<script id="sl_shield" src="//shield.sitelock.com/sitelock.js"  type="text/javascript" language="javascript"></script>
&nbsp;&nbsp;
<a target='_blank' href='http://www.facebook.com/pages/Morgantown-WV/The-College-Book-Evolution/221502719391?ref=ts'>
<img src='images/facebook.png' border="0"/>
</a>

</p>

</div>
</div>

<style type="text/css">
div.footer-wrapper{clear:both;background:#eee url("http://s.twimg.com/a/1286916367/images/fronts/bg-ftr-top.gif") repeat-x 0 0;width:100%;}#footer ul{margin:0;padding:10px 0;zoom:1;padding-left:40px;overflow:hidden;color:#666;font-size:11px;}#footer .footer-nav li.first{margin-right:130px;float:left;}#footer.wide{font-size:11px;width:940px;background:none;margin:0 auto;} #footer{font-size:.8em;white-space: nowrap;}.offscreen{position:absolute;left:-9999px;overflow:hidden;white-space: nowrap;} #footer{text-align:center;padding:8px 0;margin-top:.7em;line-height:1;background:#fff;white-space:nowrap;}#footer li{display:inline;padding:0 4px;}#footer li.first:before{content:'';padding-right:0;}
</style>

 <!--
<link href="http://a2.twimg.com/a/1287004160/stylesheets/fronts.css?1287006760" media="screen" rel="stylesheet" type="text/css" />
   -->
<br/><br/>

<div class="footer-wrapper main-font">
  <div id="footer" class="round wide">
      <h3 class="offscreen">Footer</h3>
       <div align="center">
      <ul class="footer-nav">
          <li class="first">&copy; CollegeBookEvolution.com, LLC. </li>

          <li><a href='/about'>About Us</a></li>
          <li><a href='/about/?ref=contact'>Contact</a></li>
          <li><a href='/blog'>Blog</a></li>
          <li><a href='/learnmore'>Learn More</a></li>
          <li><a href='/mailinglist/'>Mailing List</a></li>
          <li><a href='/help'>Help</a></li>
          <li><a href='/careers'>Careers</a></li>
          <li><a href='/legal'>Terms</a></li>
          <li><a href='/legal/?ref=privacy'>Privacy</a></li>
      </ul>
  </div>
  </div>
   </div>
</body>
</html>