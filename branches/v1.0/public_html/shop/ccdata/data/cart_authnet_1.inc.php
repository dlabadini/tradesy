<?php /** @version $Revision: 2751$ */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><?php
        $checkout_step1 = '0';
        $checkout_step2 = '0';
        $checkout_step3 = '1';
      
        $pageID = 3;
      ?><html xmlns="http://www.w3.org/1999/xhtml"><?php
        $currentpage = $myPage->getPage($pageID);
      
    
    $currentpage_id = $currentpage['id'];
    $currentpage_name = $currentpage['name'];
    $currentpage_pagehref = $currentpage['pagehref'];
    $currentpage_metadescription = $currentpage['metadescription'];
    $currentpage_metakeywords = $currentpage['metakeywords'];
    $currentpage_type = $currentpage['type'];
    $currentpage_content = $currentpage['content'];
  ?><head><?php
    
    if ( 
    $myPage->getConfig('shopname') ) 
    { ?><title><?php  echo $myPage->getConfig('shopname'); ?><?php
    
    if ( 
    $currentpage_name ) 
    { ?> - <?php
        echo $currentpage_name;
      ?><?php } ?></title><?php } else { ?><?php
    
    if ( 
    $currentpage_name ) 
    { ?><title><?php
        echo $currentpage_name;
      ?></title><?php } ?><?php } ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="description" content="<?php
        echo $currentpage_metadescription;
      ?>" /><meta name="keywords" content="<?php
        echo $currentpage_metakeywords;
      ?>" /><meta name="generator" content="CoffeeCup Shopping Cart Creator, <?php  echo $myPage->getConfig('sccversion'); ?>" /><meta http-equiv="generator" content="CoffeeCup Shopping Cart Creator (www.coffeecup.com)" /><meta name="revised" content="<?php  echo $myPage->getConfig('timestamp'); ?>" /><link rel="stylesheet" type="text/css" media="all" href="css/default.css" /><link rel="stylesheet" type="text/css" media="screen" href="css/colorbox.css" /><!-- styler.css must be the last one. --><link rel="stylesheet" type="text/css" media="screen" href="css/styler.css" /><!-- Remember that shop header must include css/default_ie.css in an IE 7 conditional comment --><?php include 'ccdata/php/common.inc.php'; echo $myPage->getConfig('shophtmlheader'); ?><script type="text/javascript" src="js/colorbox.js">/**/</script><script type="text/javascript" src="js/external_links.js">/**/</script></head><body id="scs_cart_page"><div id="scs_header_area_wrapper"><div id="scs_header_area_inner_wrapper"><div id="scs_header_area"><div id="scs_header_wrapper"><div id="scs_header_inner_wrapper"><div id="scs_header"><?php
    
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
    { ?><li class="scs_home_item"><div class="scs_navmenu_item_inner_wrapper"><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a><?php } ?></div></li><?php } ?><?php
    
    if ( 
    $page_type =='shophome' ) 
    { ?><li class="scs_shophome_item"><div class="scs_navmenu_item_inner_wrapper"><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a><?php } ?></div></li><?php } ?><?php
    
    if ( 
    $page_type =='cart' ) 
    { ?><li class="scs_cart_item"><div class="scs_navmenu_item_inner_wrapper"><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a><?php } ?></div></li><?php } ?><?php
    
    if ( 
    $page_type =='category' ) 
    { ?><li class="scs_categories_item"><div class="scs_navmenu_item_inner_wrapper"><div class="scs_navmenu_item_with_submenu"><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a><?php } ?><div class="scs_navsubmenu_wrapper"><span class="scs_layout_menu_vertical"><ul class="scs_navsubmenu"><?php

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
    { ?><li class="scs_staticpage_item"><div class="scs_navmenu_item_inner_wrapper"><?php
    
    if ( 
    $currentpage_id == $page_id ) 
    { ?><a class="scs_navmenu_currentpage_item" href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a><?php } else { ?><a href="<?php
        echo $page_pagehref;
      ?>"><div class="scs_navmenu_item_icon_wrapper"><div class="scs_navmenu_item_content_wrapper"><?php
        echo $page_name;
      ?></div></div></a><?php } ?></div></li><?php } ?><?php } ?></ul></span></div></div><div id="scs_cartsummary_wrapper"><div id="scs_cartsummary"><h3 id="scs_cartsummary_title">Cart Summary</h3><?php
    
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
        echo $currentpage_name;
      ?></h2></div></div></div><div id="scs_content_wrapper"><div id="scs_content_inner_wrapper"><div id="scs_content"><div class="scs_printthispage_link_area"><div class="scs_printthispage_link_wrapper"><a class="scs_printthispage_link" href="#" onClick="window.print()">Print This Page</a></div><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div><?php
    
    if ( 
    $myPage->getCartMessage() ) 
    { ?><div id="scs_cartmessages_wrapper"><div id="scs_cartmessages"><div id="scs_cartmessages_content"><?php echo $myPage->getCartMessage(); ?></div></div></div><?php } ?><?php
    
    if ( 
    $currentpage_content ) 
    { ?><div id="scs_staticcontent_wrapper"><div id="scs_staticcontent"><div id="scs_staticcontent_content"><?php
        echo $currentpage_content;
      ?></div></div></div><?php } ?><?php
    
    if ( 
    strval($myPage->getCartCount()) =='0' ) 
    { ?><p>There are no items in your cart</p><?php } else { ?><div id="scs_cart_form_wrapper"><form action="<?php echo $myPage->getUrl(); ?>" method="post" class="cart"><div class="scs_cart_updatebutton_area"><div class="scs_cart_updatebutton_wrapper"><p id="scs_cart_update_text">Make any changes below? <input type="submit" name="recalculate" value="Update Cart" class="scs_cart_updatebutton" /></p></div><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div><table id="scs_cart"><tr class="scs_cart_headlines"><td class="scs_cart_headline_product" colspan="2">Product</td><td class="scs_cart_headline_options">Options</td><td class="scs_cart_headline_qty">Qty</td><td class="scs_cart_headline_price">Price</td><td class="scs_cart_headline_subtotal">Subtotal</td></tr><?php

    foreach($myPage->getCartProducts() as  
          $product )
    {
    ?><?php
        $fooProduct = & $myPage->getProduct($product['groupid'], $product['productid']);
        $product_group = & $myPage->getGroup( $product['groupid'] );
        $fooCartId = $product['cartid'];
        $product_cartid = $fooCartId;
      

      
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

    
      

      $product_quantity = $myPage->cart->getUnitsOfProduct($fooCartId);
      $product_subtotal = $myPage->getCartSubtotalPriceProduct($fooCartId);
      $product_optionsselected =  $myPage->cart->getOptionsAsText($fooCartId);
      $product_optionshref = 'viewitem.php?groupid='.$fooGroupId.'&amp;productid='.$fooProductId.'&amp;cartid='.$fooCartId;
    ?><tr class="scs_cart_contents"><td class="scs_cart_product_container" colspan="2"><div class="scs_cart_product_image_wrapper"><div class="scs_cart_product_image_container"><img class="scs_cart_product_image" src="<?php
        echo $product_imagesmall;
      ?>" alt="<?php
        echo $product_name;
      ?> Image" /></div></div><div class="scs_cart_product_info_container"><div class="scs_cart_product_text_wrapper"><?php
    
    if ( 
    $product_name ) 
    { ?><span class="scs_cart_product_title"><?php
        echo $product_name;
      ?></span><?php } ?><?php
    
    if ( 
    $product_shortdescr ) 
    { ?><br /><span class="scs_cart_product_shortdescription"><?php
        echo $product_shortdescr;
      ?></span><?php } ?><span class="scs_sdkworkaround">&#160;</span></div><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><div class="scs_cart_product_deletebutton_wrapper"><input type="submit" name="delete[<?php
        echo $product_cartid;
      ?>]" value="Delete" id="delete_button" /></div><?php } ?></div></td><?php
    
    if ( 
    $product_optionsselected ) 
    { ?><td class="scs_cart_options"><a href="<?php
        echo $product_optionshref;
      ?>"><?php
        echo $product_optionsselected;
      ?></a></td><?php } else { ?><td class="scs_cart_options"><span class="scs_sdkworkaround">&#160;</span></td><?php } ?><td class="scs_cart_quantity"><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><?php
    
    if ( 
    $product_quantitytype!='default_quantity' ) 
    { ?><div class="scs_cart_quantity_input_wrapper"><input name="qty[<?php
        echo $product_cartid;
      ?>]" type="text" value="<?php
        echo $product_quantity;
      ?>" /></div><?php } else { ?><div class="scs_cart_quantity_static_value"><?php
        echo $product_quantity;
      ?></div><?php } ?><?php } else { ?><div class="scs_cart_quantity_static_value"><?php
        echo $product_quantity;
      ?></div><?php } ?></td><td class="scs_cart_price"><?php echo $myPage->curSign;?><?php
        echo $product_yourprice;
      ?></td><td class="scs_cart_product_subtotal"><?php echo $myPage->curSign;?><?php
        echo $product_subtotal;
      ?></td></tr><?php } ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label" colspan="2">Subtotal:</td><td class="scs_cart_subtotals_value"><?php echo $myPage->curSign;?><?php echo $myPage->getCartSubTotal(); ?></td></tr><?php
    
    if ( 
    strval(count($myPage->getExtraShipping()))!='1' ) 
    { ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_option_label"><label for="extrashipping">Shipping Method:</label></td><td class="scs_cart_subtotals_option_value"><select id="extrashipid" name="extrashipping"><?php

    foreach($myPage->getExtraShipping() as  $shipping_key => $shipping )
    {
    ?><?php
    $shipping_description = $shipping['description'];
    $shipping_amount = $shipping['amount'];
    $shipping_type = $shipping['type'];
    
    $shipping_value =$shipping['id'] . ( $myPage->getExtraShippingIndex() == $shipping['id'] ? '" selected="selected' : '');

    ?><option value="<?php
        echo $shipping_value;
      ?>" ><?php
        echo $shipping_description;
      ?></option><?php } ?></select></td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label" colspan="2">Shipping Total:</td><td class="scs_cart_subtotals_value"><?php echo $myPage->curSign;?><?php echo ( $myPage->getCartShippingHandlingTotal() ); ?></td></tr><?php } else { ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_option_label">&#160;</td><td class="scs_cart_subtotals_option_value">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label" colspan="2">Shipping &amp; Handling:</td><td class="scs_cart_subtotals_value"><?php echo $myPage->curSign;?><?php echo ( $myPage->getCartShippingHandlingTotal() ); ?></td></tr><?php } ?><?php
    
    if ( 
    strval(count($myPage->getTaxLocations()))!='1' ) 
    { ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_option_label"><label for="taxlocation">Shipping Destination:</label></td><td class="scs_cart_subtotals_option_value"><select id="taxlocid" name="taxlocation"><?php

    foreach($myPage->getTaxLocations() as  $location_key => $location )
    {
    ?><?php
    $location_name = $location;
    $location_value = $location_key . ( $myPage->cart->getTaxLocationId() == $location_key ? '" selected="selected' : '');
    ?><option value="<?php
        echo $location_value;
      ?>"><?php
        echo $location_name;
      ?></option><?php } ?></select></td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label" colspan="2">Estimated Taxes:</td><td class="scs_cart_subtotals_value"><?php echo $myPage->curSign;?><?php echo $myPage->getCartTaxTotal(); ?></td></tr><?php } else { ?><tr class="scs_cart_subtotals"><td class="scs_cart_subtotals_option_label">&#160;</td><td class="scs_cart_subtotals_option_value">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_subtotals_label" colspan="2">Taxes:</td><td class="scs_cart_subtotals_value"><?php echo $myPage->curSign;?><?php echo $myPage->getCartTaxTotal(); ?></td></tr><?php } ?><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><tr class="scs_cart_total"><?php
    
    if ( 
    $myPage->getConfig('creditcardscount')!='0' ) 
    { ?><td class="scs_cart_subtotals_option_label">Acceptable Credit&#160;Cards:</td><td class="scs_cart_subtotals_option_value"><?php

    foreach($myPage->getCreditCards() as  
          $card )
    {
    ?><?php
    $card_path = $card['path'];
    ?><img class="scs_creditcard_image" src="<?php
        echo $card_path;
      ?>" alt="card" /><?php } ?></td><?php } else { ?><td class="scs_cart_subtotals_option_label">&#160;</td><td class="scs_cart_subtotals_option_value">&#160;</td><?php } ?><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_total_label" colspan="2">Total:</td><td class="scs_cart_total_value"><?php echo $myPage->curSign;?><?php echo $myPage->getCartGrandTotal(); ?></td></tr><?php } else { ?><tr class="scs_cart_total"><td class="scs_cart_subtotals_option_label">&#160;</td><td class="scs_cart_subtotals_option_value">&#160;</td><td class="scs_cart_subtotals_label">&#160;</td><td class="scs_cart_total_label" colspan="2">Total:</td><td class="scs_cart_total_value"><?php echo $myPage->curSign;?><?php echo $myPage->getCartGrandTotal(); ?></td></tr><?php } ?></table><?php
    
    if ( 
    $checkout_step1 ) 
    { ?><div class="scs_checkout_buttons_container_wrapper"><div class="scs_checkout_buttons_container"><span class="scs_sdkworkaround">&#160;</span><?php
    
    if ( 
    $myPage->hasCheckoutMethod('PayPal') ) 
    { ?><input class="scs_checkout_button" type="image" src="<?php  echo $myPage->getConfig('paypalimage'); ?>" alt="Proceed to Checkout with Paypal" name="paypalcheckout" /><?php } ?><?php
    
    if ( 
    $myPage->hasCheckoutMethod('PayPalWPS') ) 
    { ?><input class="scs_checkout_button" type="image" src="<?php  echo $myPage->getConfig('paypalwpsimage'); ?>" alt="Proceed to Checkout with Paypal" name="paypalwpscheckout" /><?php } ?><?php
    
    if ( 
    $myPage->hasCheckoutMethod('Google') ) 
    { ?><input class="scs_checkout_button" type="image" src="<?php  echo $myPage->getConfig('googleimage'); ?>" alt="Proceed to Checkout with Google" name="googlecheckout" /><?php } ?><?php
    
    if ( 
    $myPage->hasCheckoutMethod('AuthorizeNetSIM') ) 
    { ?><input class="scs_checkout_button" type="image" src="<?php  echo $myPage->getConfig('authorizeimage'); ?>" name="anscheckout" value="Credit Card" /><?php } ?><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div><?php } ?><?php
    
    if ( 
    $checkout_step2 ) 
    { ?><?php
    
    if ( 
    $myPage->hasCheckoutMethod('PayPal') ) 
    { ?><div class="scs_checkout_buttons_container_wrapper"><div class="scs_checkout_buttons_container"><input class="scs_checkout_button" type="submit" name="confirmpp" value="Confirm Payment with Paypal" /><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div><?php } ?><?php } ?><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></form></div><?php } ?></div></div></div></div></div></div><div class="scs_cleardiv"><span class="scs_sdkworkaround">&#160;</span></div></div></div></div><div id="scs_footer_area_wrapper"><div id="scs_footer_area_inner_wrapper"><div id="scs_footer_area"><div id="scs_footer_wrapper"><div id="scs_footer_inner_wrapper"><div id="scs_footer"><div class="scs_flat_navmenu"><?php
    
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