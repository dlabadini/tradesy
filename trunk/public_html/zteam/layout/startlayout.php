<?php require_once('./includes/functions.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="SHORTCUT ICON" HREF="http://www.collegebookevolution.com/images/icons/favicon.ico">
<link rel="stylesheet" type="text/css" href="./layout/master.css" />
<link href="../css/centertemplate.css" rel="stylesheet" type="text/css" />
<title>
<?php echo $page_title ?></title>
<script type="text/javascript" src="./includes/functions.js"></script>
<script type="text/javascript" src="./includes/explorer.js"></script>
<script type="text/javascript" src="./includes/scripts.js"></script>

<!--[if lt IE 7.]>
<script defer type="text/javascript" src="../scripts/pngfix.js"></script>
<![endif]-->

<?
if ($lightbox){
  echo '<script type="text/javascript" src="../scripts/lightbox/js/prototype.js"></script>
        <script type="text/javascript" src="../scripts/lightbox/js/scriptaculous.js?load=effects,builder"></script>
        <script type="text/javascript" src="../scripts/lightbox/js/lightbox.js"></script>
        <link rel="stylesheet" href="../scripts/lightbox/css/lightbox.css" type="text/css" media="screen" />';
}
?>
</head>

<body class="main_font" >
<img class='cornerImg' src="../images/swirls.gif" />

<div id="header">
    <div class='main_logo'>
				 <div align='center'>
      	 			<a href="http://www.collegebookevolution.com/"><img src="../images/page/full_logo.png" style="border-style:none;" /></a>
					</div>
    </div>
</div>

<div class="container">
<div id="ajaxim"></div>