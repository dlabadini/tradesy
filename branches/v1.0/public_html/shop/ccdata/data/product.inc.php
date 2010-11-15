<?php /** @version $Revision: 2751$ */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><?php?><html xmlns="http://www.w3.org/1999/xhtml"><?php
        $fooProduct = & $myPage->getProduct($_GET['groupid'], $_GET['productid']);
        $product_group = & $myPage->getGroup( $_GET['groupid'] );
        $product_cartid = $_GET['cartid'];
    

      
      $fooProductId = $fooProduct['productid'];
      $fooGroupId =  $fooProduct['groupid'];
      $fooOption1 = 'option1Sel_'.$fooProductId;
      $fooOption2 = 'option2Sel_'.$fooProductId;
      $fooQuantity = 'quantitySel_'.$fooProductId;
      $product_id = $fooProductId;
      $product_groupid =  $fooGroupId;
      $product_name =  $fooProduct['name'];
      $product_shortdescr =  $fooProduct['shortdescription'];
      $product_longdescr =  $fooProduct['longdescription'];

      $product_metakeywords =  $fooProduct['metakeywords'];
      $product_metadescription =  $fooProduct['metadescription'];

      $product_isstarred = $fooProduct['isstarred'];
      $product_refcode =$fooProduct['refcode'];
      $product_yourprice =$fooProduct['yourprice'];
      $product_ispercent = $fooProduct['ispercentage'];
      $product_price = $fooProduct['retailprice'];
      $product_discount = $fooProduct['discount'];
      $product_tax = $fooProduct['tax'];
      $product_shipping = $fooProduct['shipping'];
      $product_handling = $fooProduct['handling'];
      $product_quantitytype =$fooProduct['typequantity'];
      $product_quantitydefault = $fooProduct['quantity'];
      $product_quantitymin = $fooProduct['minrangequantity'];
      $product_quantitymax = $fooProduct['maxrangequantity'];
      $product_imagefull = $fooProduct['main_full'];
      $product_imagesmall = $fooProduct['main_small'];
      $product_imagethumbscount = count( $fooProduct['thumbs'] );
      $product_imagethumbs = $fooProduct['thumbs'];

      $product_options = $fooProduct['options'];

      $product_pagehref = $fooProduct['pagehref'];
      $product_weight = ($fooProduct['weight'] == '0.00' ? 0 : $fooProduct['weight']);
      $product_weightunit = $fooProduct['weightunits'];
    
      $product_iteration = 0;
      $product_quantityid = $fooQuantity;

      $product_stock = $fooProduct['stock'];

    
      ?><head><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><title><?php  echo $myPage->getConfig('shopname'); ?><?php
    
    if ( 
    $product_name ) 
    { ?> - <?php
        echo $product_name;
      ?><?php } ?></title><?php } else { ?><?php
    
    if ( 
    $product_name ) 
    { ?><title><?php
        echo $product_name;
      ?></title><?php } ?><?php } ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="description" content="<?php
        echo $product_metadescription;
      ?>" /><meta name="keywords" content="<?php
        echo $product_metakeywords;
      ?>" /><meta name="generator" content="CoffeeCup Shopping Cart Creator, <?php  echo $myPage->getConfig('sccversion'); ?>" /><meta http-equiv="generator" content="CoffeeCup Shopping Cart Creator (www.coffeecup.com)" /><meta name="revised" content="<?php  echo $myPage->getConfig('timestamp'); ?>" /><link rel="stylesheet" type="text/css" media="all" href="css/default.css" /><link rel="stylesheet" type="text/css" media="screen" href="css/colorbox.css" /><!-- styler.css must be the last one. --><link rel="stylesheet" type="text/css" media="screen" href="css/styler.css" /><!-- Remember that shop header must include css/default_ie.css in an IE 7 conditional comment --><?php include 'ccdata/php/common.inc.php'; echo $myPage->getConfig('shophtmlheader'); ?><script type="text/javascript" src="js/colorbox.js">/**/</script><script type="text/javascript" src="js/external_links.js">/**/</script></head><body id="scs_productdetails_page"><div id="scs_header_area_wrapper"><div id="scs_header_area_inner_wrapper"><div id="scs_header_area"><div id="scs_header_wrapper"><div id="scs_header_inner_wrapper"><div id="scs_header"><?php
    
    if ( 
    $myPage->getConfig('shoplogo') ) 
    { ?><?php
    
    if ( 
    $myPage->getConfig('websitehref') ) 
    { ?><a href="<?php  echo $myPage->getConfig('websitehref'); ?>"><img id="scs_shoplogo" src="<?php  echo $myPage->getConfig('shoplogo'); ?>" alt="<?php  echo $myPage->getConfig('shopname'); ?>" /></a><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><h1 id="scs_header_title"><?php  echo $myPage->getConfig('shopname'); ?></h1><?php } ?><?php } else { ?><img id="scs_shoplogo" src="<?php  echo $myPage->getConfig('shoplogo'); ?>" alt="<?php  echo $myPage->getConfig('shopname'); ?>" /><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><h1 id="scs_header_title"><?php  echo $myPage->getConfig('shopname'); ?></h1><?php } ?><?php } ?><?php } else { ?><?php
    
    if ( 
    $myPage->getConfig('websitehref') ) 
    { ?><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><h1 id="scs_header_title"><a href="<?php  echo $myPage->getConfig('websitehref'); ?>"><?php  echo $myPage->getConfig('shopname'); ?></a></h1><?php } ?><?php } else { ?><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><h1 id="scs_header_title"><?php  echo $myPage->getConfig('shopname'); ?></h1><?php } ?><?php } ?><?php } ?><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div></div></div></div></div><div id="scs_central_area_wrapper"><div id="scs_central_area_inner_wrapper"><div id="scs_central_area"><div id="scs_navbar_wrapper" class="scs_navbar_adjustable"><div id="scs_navbar_inner_wrapper"><div id="scs_navbar"><div id="scs_navmenu_wrapper"><div id="scs_navmenu_inner_wrapper"><span class="scs_layout_menu_vertical"><ul id="scs_navmenu"><?php

    foreach($myPage->getPages() as  
          $page )
    {
    ?><?php
    
    $page_id = $page['id'];
    $page_name = $page['name'];
    $page_pagehref = $page['pagehref'];
    $page_metadescription = $page['metadescription'];
    $page_metakeywords = $page['metakeywords'];
    $page_type = $page['type'];
    $page_content = $page['content'];
  ?><?php
    
    if ( 
    $page_type =='home' ) 
    { ?><li class="scs_home_item"><div class="scs_navmenu_item_inner_wrapper"><a href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a></div></li><?php } ?><?php
    
    if ( 
    $page_type =='shophome' ) 
    { ?><li class="scs_shophome_item"><div class="scs_navmenu_item_inner_wrapper"><a href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a></div></li><?php } ?><?php
    
    if ( 
    $page_type =='cart' ) 
    { ?><li class="scs_cart_item"><div class="scs_navmenu_item_inner_wrapper"><a href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a></div></li><?php } ?><?php
    
    if ( 
    $page_type =='category' ) 
    { ?><li class="scs_categories_item"><div class="scs_navmenu_item_inner_wrapper"><div class="scs_navmenu_item_with_submenu"><a href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a><div class="scs_navsubmenu_wrapper"><span class="scs_layout_menu_vertical"><ul class="scs_navsubmenu"><?php

    foreach($myPage->getGroups() as  
          $group )
    {
    ?><?php
        $group_id = $group['groupid'];
        $group_products =& $myPage->getProductsByGroup($group_id);
      
    $group_name = $group['name'];
    $group_metakeywords = $group['metakeywords'];
    $group_metadescription = $group['metadescription'];

    $group_pagehref =  $group['pagehref'];
    $group_productscount = count( $group_products );
    $group_iteration = 0;
  ?><?php
    
    if ( 
    $group_name ) 
    { ?><li><div class="scs_navsubmenu_item_inner_wrapper"><a href="<?php
        echo $group_pagehref;
      ?>"><?php
        echo $group_name;
      ?></a></div></li><?php } ?><?php } ?></ul></span></div></div></div></li><?php } ?><?php
    
    if ( 
    $page_type =='staticpage' ) 
    { ?><li class="scs_staticpage_item"><div class="scs_navmenu_item_inner_wrapper"><a href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a></div></li><?php } ?><?php } ?></ul></span></div></div><div id="scs_cartsummary_wrapper"><div id="scs_cartsummary"><h3 id="scs_cartsummary_title">Cart Summary</h3><?php
    
    if ( 
    strval($myPage->getCartCount()) =='0' ) 
    { ?><div id="scs_cartsummary_content"><p>There are no items in your cart</p></div><?php } else { ?><div id="scs_cartsummary_content"><ol id="scs_cartsummary_list"><?php

    foreach($myPage->getCartProducts() as  
          $cartproduct )
    {
    ?><?php
        $fooProduct = & $myPage->getProduct($cartproduct['groupid'], $cartproduct['productid']);
        $cartproduct_group = & $myPage->getGroup( $cartproduct['groupid'] );
        $fooCartId = $cartproduct['cartid'];
        $cartproduct_cartid = $fooCartId;
      

      
      $fooProductId = $fooProduct['productid'];
      $fooGroupId =  $fooProduct['groupid'];
      $fooOption1 = 'option1Sel_'.$fooProductId;
      $fooOption2 = 'option2Sel_'.$fooProductId;
      $fooQuantity = 'quantitySel_'.$fooProductId;
      $cartproduct_id = $fooProductId;
      $cartproduct_groupid =  $fooGroupId;
      $cartproduct_name =  $fooProduct['name'];
      $cartproduct_shortdescr =  $fooProduct['shortdescription'];
      $cartproduct_longdescr =  $fooProduct['longdescription'];

      $cartproduct_metakeywords =  $fooProduct['metakeywords'];
      $cartproduct_metadescription =  $fooProduct['metadescription'];

      $cartproduct_isstarred = $fooProduct['isstarred'];
      $cartproduct_refcode =$fooProduct['refcode'];
      $cartproduct_yourprice =$fooProduct['yourprice'];
      $cartproduct_ispercent = $fooProduct['ispercentage'];
      $cartproduct_price = $fooProduct['retailprice'];
      $cartproduct_discount = $fooProduct['discount'];
      $cartproduct_tax = $fooProduct['tax'];
      $cartproduct_shipping = $fooProduct['shipping'];
      $cartproduct_handling = $fooProduct['handling'];
      $cartproduct_quantitytype =$fooProduct['typequantity'];
      $cartproduct_quantitydefault = $fooProduct['quantity'];
      $cartproduct_quantitymin = $fooProduct['minrangequantity'];
      $cartproduct_quantitymax = $fooProduct['maxrangequantity'];
      $cartproduct_imagefull = $fooProduct['main_full'];
      $cartproduct_imagesmall = $fooProduct['main_small'];
      $cartproduct_imagethumbscount = count( $fooProduct['thumbs'] );
      $cartproduct_imagethumbs = $fooProduct['thumbs'];

      $cartproduct_options = $fooProduct['options'];

      $cartproduct_pagehref = $fooProduct['pagehref'];
      $cartproduct_weight = ($fooProduct['weight'] == '0.00' ? 0 : $fooProduct['weight']);
      $cartproduct_weightunit = $fooProduct['weightunits'];
    
      $cartproduct_iteration = 0;
      $cartproduct_quantityid = $fooQuantity;

      $cartproduct_stock = $fooProduct['stock'];

    
      

      $cartproduct_quantity = $myPage->cart->getUnitsOfProduct($fooCartId);
      $cartproduct_subtotal = $myPage->getCartSubtotalPriceProduct($fooCartId);
      $cartproduct_optionsselected =  $myPage->cart->getOptionsAsText($fooCartId);
      $cartproduct_optionshref = 'viewitem.php?groupid='.$fooGroupId.'&amp;productid='.$fooProductId.'&amp;cartid='.$fooCartId;
    ?><li><?php
        echo $cartproduct_name;
      ?><?php
    
    if ( 
    $cartproduct_optionsselected ) 
    { ?> - <?php
        echo $cartproduct_optionsselected;
      ?><?php } ?><br /><?php echo $myPage->curSign;?><?php
        echo $cartproduct_subtotal;
      ?></li><?php } ?></ol></div><div class="scs_viewyourcart_link_wrapper"><a class="scs_viewyourcart_link" href="<?php  echo $myPage->getConfig('viewcarthref'); ?>">View Your Cart</a></div><?php } ?></div></div></div></div></div><div id="scs_content_area_wrapper" class="scs_navbar_adjustable_opposite"><div id="scs_content_area_inner_wrapper"><div id="scs_content_area"><div id="scs_subheader_wrapper"><div id="scs_subheader_inner_wrapper"><div id="scs_subheader"><h2 id="scs_subheader_title"><?php
    
    if ( 
    $product_name ) 
    { ?><?php
        echo $product_name;
      ?><?php } else { ?><span class="scs_sdkworkaround">&#160;</span><?php } ?></h2></div></div></div><div id="scs_content_wrapper"><div id="scs_content_inner_wrapper"><div id="scs_content"><?php
    
    if ( 
    $myPage->getCartMessage() ) 
    { ?><div id="scs_cartmessages_wrapper"><div id="scs_cartmessages"><div id="scs_cartmessages_content"><?php echo $myPage->getCartMessage(); ?></div></div></div><?php } ?><div id="scs_productdetails"><div id="scs_productdetails_images"><a href="<?php
        echo $product_imagefull;
      ?>" id="scs_productdetails_imagefull_link" class="colorbox" rel="detail-images"><img id="scs_productdetails_imagefull" src="<?php
        echo $product_imagesmall;
      ?>" alt="<?php
        echo $product_name;
      ?> Image" /></a><?php
    
    if ( 
    $product_imagethumbscount ) 
    { ?><div id="scs_productdetails_thumbnails"><?php

    foreach($product_imagethumbs as  
          $thumb )
    {
    ?><?php
    $thumb_full = $thumb['full'];
    $thumb_small = $thumb['small'];
 ?><div class="scs_thumbnail_wrapper" ><a href="<?php
        echo $thumb_full;
      ?>" class="colorbox" rel="detail-images"><img class="scs_thumbnail" src="<?php
        echo $thumb_small;
      ?>" alt="Detail Image" /></a></div><?php } ?></div><?php } ?></div><div id="scs_productdetails_info_wrapper"><div id="scs_productdetails_info"><?php
    
    if ( 
    $product_longdescr ) 
    { ?><p><?php
        echo $product_longdescr;
      ?></p><?php } ?><form action="<?php echo $myPage->getUrl(); ?>" method="post"><table><?php
    
    if ( 
    $product_price!= $product_yourprice ) 
    { ?><tr><td class="scs_label">List Price:</td><td class="scs_price_list"><?php echo $myPage->curSign;?><?php
        echo $product_price;
      ?></td></tr><?php } ?><tr><td class="scs_label">Your Price:</td><td><span class="scs_yourprice"><?php echo $myPage->curSign;?><?php
        echo $product_yourprice;
      ?></span><?php
    
    if ( 
    $product_price!= $product_yourprice ) 
    { ?><span class="scs_discount">&#160;(You save <?php
    
    if ( 
     !  (  $product_ispercent )  ) 
    { ?><?php echo $myPage->curSign;?><?php } ?><?php
        echo $product_discount;
      ?><?php
    
    if ( 
    $product_ispercent ) 
    { ?>%<?php } ?>)</span><?php } ?></td></tr><?php

    foreach($product_options as  $option_key => $option )
    {
    ?><?php
    $option_name = 'opt_'.$option_key;
    $option_label = $option['name'];
    $option_count = count( $option );
    $option_id = 'option'.$option_key.'Sel_'.$fooProductId;
    $option_optionsitems = $option['items'];
    ?><tr><td class="scs_label"><label for="<?php
        echo $option_name;
      ?>"><?php
        echo $option_label;
      ?>:</label></td><td class="scs_option"><select id="<?php
        echo $option_name;
      ?>" name="<?php
        echo $option_name;
      ?>"><?php

    foreach($option_optionsitems as  $optionitem_key => $optionitem )
    {
    ?><?php
    $fooValue = $optionitem['value'];
    $fooSelect = $optionitem['selected'];
    $optionitem_label = $optionitem['label'];
    $optionitem_extraprice = formatMoney($optionitem['price'],100);
    $optionitem_value = $fooValue.( $fooSelect == 1 ? '" selected="selected' : '' );
    ?><option value="<?php
        echo $optionitem_value;
      ?>"><?php
        echo $optionitem_label;
      ?></option><?php } ?></select></td></tr><?php } ?><?php
    
    if ( 
    $product_weight ) 
    { ?><tr><td class="scs_label">Weight:</td><td class="scs_weight"><?php
        echo $product_weight;
      ?> <?php
        echo $product_weightunit;
      ?></td></tr><?php } ?><tr><td class="scs_label"><label>Quantity:</label></td><td class="scs_quantity"><?php
    
    if ( 
    $product_quantitytype =='default_quantity' ) 
    { ?><?php
        echo $product_quantitydefault;
      ?><?php } ?><?php
    
    if ( 
    $product_quantitytype =='range_quantity' ) 
    { ?>Choose from&#160;<?php
        echo $product_quantitymin;
      ?>&#160;to&#160;<?php
        echo $product_quantitymax;
      ?>:<input type="text" value="<?php
        echo $product_quantitymin;
      ?>" id="quantity" name="quantity" /><?php } ?><?php
    
    if ( 
    $product_quantitytype =='choose_quantity' ) 
    { ?><input type="text" value="<?php
        echo $product_quantitydefault;
      ?>" id="quantity" name="quantity" /><?php } ?></td></tr></table><p><input type="hidden" name="method" value="add" /><input type="hidden" name="productid" value="<?php
        echo $product_id;
      ?>" /><input type="hidden" name="groupid" value="<?php
        echo $product_groupid;
      ?>" /><input type="hidden" name="cartid" value="<?php
        echo $product_cartid;
      ?>" /><span class="scs_addtocart_wrapper"><input type="submit" value="Add to Cart" class="scs_addtocart" /></span></p></form></div></div><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div></div></div></div></div></div><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div></div><div id="scs_footer_area_wrapper"><div id="scs_footer_area_inner_wrapper"><div id="scs_footer_area"><div id="scs_footer_wrapper"><div id="scs_footer_inner_wrapper"><div id="scs_footer"><div class="scs_flat_navmenu"><?php
    
    if ( 
    $myPage->getConfig('websitehref') ) 
    { ?><?php

    foreach($myPage->getPages() as  
          $firstpage )
    {
    ?><?php
    
    $firstpage_id = $firstpage['id'];
    $firstpage_name = $firstpage['name'];
    $firstpage_pagehref = $firstpage['pagehref'];
    $firstpage_metadescription = $firstpage['metadescription'];
    $firstpage_metakeywords = $firstpage['metakeywords'];
    $firstpage_type = $firstpage['type'];
    $firstpage_content = $firstpage['content'];
  ?><?php
    
    if ( 
    $firstpage_type =='home' ) 
    { ?><a href="<?php  echo $myPage->getConfig('websitehref'); ?>"><?php
        echo $firstpage_name;
      ?></a><?php } ?><?php } ?><?php

    foreach($myPage->getPages() as  
          $page )
    {
    ?><?php
    
    $page_id = $page['id'];
    $page_name = $page['name'];
    $page_pagehref = $page['pagehref'];
    $page_metadescription = $page['metadescription'];
    $page_metakeywords = $page['metakeywords'];
    $page_type = $page['type'];
    $page_content = $page['content'];
  ?><?php
    
    if ( 
    $page_type!='home' ) 
    { ?>&#160;|&#160;<a href="<?php
        echo $page_pagehref;
      ?>"><?php
        echo $page_name;
      ?></a><?php } ?><?php } ?><?php } else { ?><?php

    foreach($myPage->getPages() as  
          $firstpage )
    {
    ?><?php
    
    $firstpage_id = $firstpage['id'];
    $firstpage_name = $firstpage['name'];
    $firstpage_pagehref = $firstpage['pagehref'];
    $firstpage_metadescription = $firstpage['metadescription'];
    $firstpage_metakeywords = $firstpage['metakeywords'];
    $firstpage_type = $firstpage['type'];
    $firstpage_content = $firstpage['content'];
  ?><?php
    
    if ( 
    $firstpage_type =='shophome' ) 
    { ?><a href="<?php
        echo $firstpage_pagehref;
      ?>"><?php
        echo $firstpage_name;
      ?></a><?php } ?><?php } ?><?php

    foreach($myPage->getPages() as  
          $page )
    {
    ?><?php
    
    $page_id = $page['id'];
    $page_name = $page['name'];
    $page_pagehref = $page['pagehref'];
    $page_metadescription = $page['metadescription'];
    $page_metakeywords = $page['metakeywords'];
    $page_type = $page['type'];
    $page_content = $page['content'];
  ?><?php
    
    if ( 
    $page_type!='shophome' ) 
    { ?><?php
    
    if ( 
    $page_type!='home' ) 
    { ?>&#160;|&#160;<a href="<?php
        echo $page_pagehref;
      ?>"><?php
        echo $page_name;
      ?></a><?php } ?><?php } ?><?php } ?><?php } ?></div><?php
    
    if ( 
    $myPage->getConfig('shopfooter') ) 
    { ?><div id="scs_footercontent_wrapper"><div id="scs_footercontent"><div id="scs_footercontent_content"><?php  echo $myPage->getConfig('shopfooter'); ?></div></div></div><?php } ?><?php
    
    if ( 
    $myPage->getConfig('copyright') ) 
    { ?><p class="scs_branding"><?php  echo $myPage->getConfig('copyright'); ?></p><?php } ?></div></div></div></div></div></div></body></html>