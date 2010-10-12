<?php

  $config['sccversion'] = '';
  $config['timestamp'] = '';
  $config['home'] = 'index.php';
  $config['viewcarthref'] = 'cart.php';
  $config['categorypagehref'] = 'category.php';
  $config['shopname'] = 'New Shop';
  $config['shoplogo'] = 'ccdata/images/logo.png';
  $config['websitehref'] = '';
  $config['shopfooter'] = '';
  $config['shopcurrency'] = 'USD';
  $config['groupscount'] = '13';
  $config['pagescount'] = '0';
  $config['creditcardscount'] = '0';
  $config['shopkeywords'] = '';
  $config['shopdescription'] = '';
  $config['shophtmlheader'] = '<!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/default_ie.css" / ><![endif]-->';
  $config['homeheader'] = '';
  $config['hometext'] = '';
  $config['showstarredgroups'] = '1';
  $config['showhomeproducts'] = '1';
  $config['showcategoryproducts'] = '1';
  $config['staticpageshome'] = false;
  $config['copyright'] = '';
  $config['navigate_stayonpage'] = true;

  
  $config['ispro'] = false;
    
  // Possible languages defined: 
  // en' -> English; 'de' -> German; 'es' -> Spanish
  
    $config['lang'] = 'en';

    $config['PayPal'] = array(
    'enabled' => false,
    'API_USERNAME' => '',
    'API_PASSWORD' => '',
    'API_SIGNATURE' => '',
    'API_ENDPOINT' => 'https://api-3t.paypal.com/nvp',
    'USE_PROXY' => false,
    'PROXY_HOST' => '',
    'PROXY_PORT' => '',
    'PAYPAL_URL' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=',
    'VERSION' => '3.2',
    'USE_GIROPAY' => false
    );
    
  $config['Google'] = array(
	  'enabled' => false,
    'merchant_id' => '',
    'merchant_key' => '',
    'url' => "https://checkout.google.com/api/checkout/v2/merchantCheckout/Merchant/",
    'USE_PROXY' => false,
    'PROXY_HOST' => '',
    'PROXY_PORT' => ''
    );
        
 $config['AuthorizeNetSIM'] = array(
    'enabled' => false,
    'URL' => 'https://secure.authorize.net/gateway/transact.dll',
    'API_LOGIN' => '',
	  'API_KEY' => '',
 	  'TEST_MODE' => 0			// allows for testing in live environment
    );


    $config['PayPalWPS'] = array (
    'enabled' => true,
    'URL' => 'https://www.paypal.com/cgi-bin/webscr',
    'BUSINESS' => 'payment@collegebookevolution.com',
    'USE_PROXY' => false,
    'PROXY_HOST' => '',
    'PROXY_PORT' => ''
    );

    $config['2CO'] = array(
    'enabled' => false,
    'VENDOR_NUMBER' => '',
    'SECRET' => '',
    
    // single page checkout (only intangible products)
    //'URL' => 'https://www.2checkout.com/checkout/spurchase',
    // multipage checkout
    
    'URL' => 'https://www.2checkout.com/checkout/purchase',
    'TEST_MODE' => 0			// allows for testing in live environment
    );

    $config['WorldPay'] = array(
    'enabled' => false,
    'ID' => '',
    'URL' => 'https://select-test.wp3.rbsworldpay.com/wcc/purchase',
    'URL_TEST' => 'https://select-test.wp3.rbsworldpay.com/wcc/purchase',		// use this if test mode is selected
    'TEST_MODE' => 0			// allows for testing in live environment
  );


  $config['TaxLocations'] = array(
       '1' => 'International' ,
       '2' => 'Alabama' ,
       '3' => 'Alaska' ,
       '4' => 'Arizona' ,
       '5' => 'Arkansas' ,
       '6' => 'California' ,
       '7' => 'Colorado' ,
       '8' => 'Connecticut' ,
       '9' => 'Delaware' ,
       '10' => 'Florida' ,
       '11' => 'Georgia' ,
       '12' => 'Hawaii' ,
       '13' => 'Idaho' ,
       '14' => 'Illinois' ,
       '15' => 'Indiana' ,
       '16' => 'Iowa' ,
       '17' => 'Kansas' ,
       '18' => 'Kentucky' ,
       '19' => 'Louisiana' ,
       '20' => 'Maine' ,
       '21' => 'Maryland' ,
       '22' => 'Massachusetts' ,
       '23' => 'Michigan' ,
       '24' => 'Minnesota' ,
       '25' => 'Mississippi' ,
       '26' => 'Missouri' ,
       '27' => 'Montana' ,
       '28' => 'Nebraska' ,
       '29' => 'Nevada' ,
       '30' => 'New Hampshire' ,
       '31' => 'New Jersey' ,
       '32' => 'New Mexico' ,
       '33' => 'New York' ,
       '34' => 'North Carolina' ,
       '35' => 'North Dakota' ,
       '36' => 'Ohio' ,
       '37' => 'Oklahoma' ,
       '38' => 'Oregon' ,
       '39' => 'Pennsylvania' ,
       '40' => 'Rhode Island' ,
       '41' => 'South Carolina' ,
       '42' => 'South Dakota' ,
       '43' => 'Tennessee' ,
       '44' => 'Texas' ,
       '45' => 'Utah' ,
       '46' => 'Vermont' ,
       '47' => 'Virginia' ,
       '48' => 'Washington' ,
       '49' => 'West Virginia' ,
       '50' => 'Wisconsin' ,
       '51' => 'Wyoming' 
    );

    /* Type of taxes: 0 -> Apply to product amount, 1 -> Apply to product amount + shipping, 2 -> Apply to product amount + shipping + handling (NOT IN USE, USE SHIPPING ARRAY)*/
          $config['TaxRates']['Product']['1']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['2']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['3']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['4']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['5']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['6']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['7']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['8']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['9']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['10']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['11']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['12']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['13']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['14']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['15']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['16']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['17']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['18']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['19']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['20']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['21']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['22']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['23']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['24']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['25']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['26']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['27']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['28']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['29']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['30']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['31']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['32']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['33']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['34']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['35']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['36']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['37']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['38']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['39']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['40']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['41']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['42']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['43']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['44']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['45']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['46']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['47']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['48']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['49']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
          $config['TaxRates']['Product']['50']['Merchandise'] = array( 'amount'=> 60000, 'decimalsnumber' => 4 );
       
  $pages['1'] = array(
      'type' => 'shophome',
      'name' => '<h2>eVOLVE Shop Home</h2>',
      'id' => '1',
      'pagehref' => 'index.php',
      'metadescription' => 'blah',
      'metakeywords' => 'college essentials, clothing, shirts, sweatshirts, t-shirts, mugs, tailgate, freshmen needs, dorm, dorm needs',
      'content' => 'Welcome to the CollegeBookEvolution.com online shop, eVOLVE, where college essentials are all in one place.'
      );
    
  $pages['2'] = array(
      'type' => 'category',
      'name' => 'Categories',
      'id' => '2',
      'pagehref' => 'category.php',
      'metadescription' => '',
      'metakeywords' => '',
      'content' => ''
      );
    
  $pages['3'] = array(
      'type' => 'cart',
      'name' => 'View Cart',
      'id' => '3',
      'pagehref' => 'cart.php',
      'metadescription' => '',
      'metakeywords' => '',
      'content' => ''
      );
    
        /* Description -> Text to show in the dropdown. Amount -> quantity to add. Show -> If we need to show it in the dropdown 
       
       Type of extrashipping: 
        -1 -> Default Shipping, use for Fixed amount (even if not visible) 
         0 -> Apply to total shipping
         1 -> Apply as percentage to total 
         2 -> Apply to each item in the cart
         3 -> Apply percentage to each item in the cart 
         4 -> Increase shipping costs with this % times the number of products
         */
    
  $extrashippings[] = array(
          'description' => 'Normal Shipping',
          'amount' => '200',
          'type' => '-1',
          'show' => true,
          'id' =>  '0'
      );
    
  $groups['0'] = array(
      'name' => 'Polos',
      'metakeywords' => 'Polos',
      'metadescription' => 'Polos',
      'groupid' => '0',
      'pagehref' => 'viewcategory.php?groupid=0',
      'productsIds' => array(0,8)
      );
    
  $groups['2'] = array(
      'name' => 'Collectibles',
      'metakeywords' => 'Collectibles',
      'metadescription' => 'Collectibles',
      'groupid' => '2',
      'pagehref' => 'viewcategory.php?groupid=2',
      'productsIds' => array(7)
      );
    
  $groups['3'] = array(
      'name' => 'Cups, Mugs, &Shots',
      'metakeywords' => 'Cups, Mugs, &Shots',
      'metadescription' => 'Cups, Mugs, &Shots',
      'groupid' => '3',
      'pagehref' => 'viewcategory.php?groupid=3',
      'productsIds' => array(2,16)
      );
    
  $groups['4'] = array(
      'name' => 'Footwear & Socks',
      'metakeywords' => 'Footwear & Socks',
      'metadescription' => 'Footwear & Socks',
      'groupid' => '4',
      'pagehref' => 'viewcategory.php?groupid=4',
      'productsIds' => array(3,5)
      );
    
  $groups['5'] = array(
      'name' => 'Gifts & Accessories',
      'metakeywords' => 'Gifts & Accessories',
      'metadescription' => 'Gifts & Accessories',
      'groupid' => '5',
      'pagehref' => 'viewcategory.php?groupid=5',
      'productsIds' => array(6)
      );
    
  $groups['6'] = array(
      'name' => 'Hats',
      'metakeywords' => 'Hats',
      'metadescription' => 'Hats',
      'groupid' => '6',
      'pagehref' => 'viewcategory.php?groupid=6',
      'productsIds' => array(4)
      );
    
  $groups['7'] = array(
      'name' => 'Clothing',
      'metakeywords' => 'Clothing',
      'metadescription' => 'Clothing',
      'groupid' => '7',
      'pagehref' => 'viewcategory.php?groupid=7',
      'productsIds' => array(9)
      );
    
  $groups['8'] = array(
      'name' => 'Jerseys',
      'metakeywords' => 'Jerseys',
      'metadescription' => 'Jerseys',
      'groupid' => '8',
      'pagehref' => 'viewcategory.php?groupid=8',
      'productsIds' => array(10)
      );
    
  $groups['9'] = array(
      'name' => 'Kitchen & Bar',
      'metakeywords' => 'Kitchen & Bar',
      'metadescription' => 'Kitchen & Bar',
      'groupid' => '9',
      'pagehref' => 'viewcategory.php?groupid=9',
      'productsIds' => array(11)
      );
    
  $groups['10'] = array(
      'name' => 'Shorts & Pants',
      'metakeywords' => 'Shorts & Pants',
      'metadescription' => 'Shorts & Pants',
      'groupid' => '10',
      'pagehref' => 'viewcategory.php?groupid=10',
      'productsIds' => array(12)
      );
    
  $groups['11'] = array(
      'name' => 'Sweatshirts & Fleece',
      'metakeywords' => 'Sweatshirts & Fleece',
      'metadescription' => 'Sweatshirts & Fleece',
      'groupid' => '11',
      'pagehref' => 'viewcategory.php?groupid=11',
      'productsIds' => array(14)
      );
    
  $groups['12'] = array(
      'name' => 'Tailgate',
      'metakeywords' => 'Tailgate',
      'metadescription' => 'Tailgate',
      'groupid' => '12',
      'pagehref' => 'viewcategory.php?groupid=12',
      'productsIds' => array(13)
      );
    
  $groups['13'] = array(
      'name' => 'T-Shirts',
      'metakeywords' => 'T-Shirts',
      'metadescription' => 'T-Shirts',
      'groupid' => '13',
      'pagehref' => 'viewcategory.php?groupid=13',
      'productsIds' => array(15)
      );
    
  $products['0']['0'] =
      
      array(
      'productid' => '0',
      'groupid' => '0',
      'pagehref' => 'viewitem.php?groupid=0&amp;productid=0',
      'name' => 'Titlehh',
      'shortdescription' => 'mjj',
      'longdescription' => '
        <span><span style="font-size:12px;">mhjkhkjhjk</span></span>
      ',
      'metakeywords' => 'Titlehh',
      'metadescription' => 'mjj',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000000',
      'yourprice' => '8900',
      'retailprice' => '8900',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
        
          array ( 'name' => 'sHIPPING',
              'items' => array (
              
                array('label' => 'FGFHFGH', 'price' => '000' , 'value' => '1', 'selected' => 0 )  )
           ) 
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_0_0.jpg',
      'main_small' => 'ccdata/images/smallMain_0_0.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_0_0.jpg', 'small' => 'ccdata/images/small1_0_0.jpg')  )
      );
    
  $products['0']['8'] =
      
      array(
      'productid' => '8',
      'groupid' => '0',
      'pagehref' => 'viewitem.php?groupid=0&amp;productid=8',
      'name' => 'Tgfdgsdf',
      'shortdescription' => 'fdsgds',
      'longdescription' => '',
      'metakeywords' => 'Tgfdgsdf',
      'metadescription' => 'fdsgds',
      'weight' => '200',
      'weightunits' => 'lbs',
      'isstarred' => '1',
      'sku' => 'SKU_00000008',
      'yourprice' => '3230',
      'retailprice' => '3400',
      'discount' => '500',
      'ispercentage' => '1',
      'tax' => 'Merchandise',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
        
          array ( 'name' => 'sHIPPING',
              'items' => array (
              
                array('label' => 'FGFHFGH', 'price' => '000' , 'value' => '1', 'selected' => 0 )  )
           ) 
      ),
      'typequantity' => 'choose_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_0_8.jpg',
      'main_small' => 'ccdata/images/smallMain_0_8.jpg',
      'thumbs' => array(
       )
      );
    
  $products['2']['7'] =
      
      array(
      'productid' => '7',
      'groupid' => '2',
      'pagehref' => 'viewitem.php?groupid=2&amp;productid=7',
      'name' => 'Titledfs',
      'shortdescription' => 'fds',
      'longdescription' => '
        <span><span style="font-size:12px;">gfhdggf</span></span>
      ',
      'metakeywords' => 'Titledfs',
      'metadescription' => 'fds',
      'weight' => '100',
      'weightunits' => 'lbs',
      'isstarred' => '1',
      'sku' => 'SKU_00000007',
      'yourprice' => '594',
      'retailprice' => '600',
      'discount' => '100',
      'ispercentage' => '1',
      'tax' => 'Merchandise',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_2_7.jpg',
      'main_small' => 'ccdata/images/smallMain_2_7.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_2_7.jpg', 'small' => 'ccdata/images/small1_2_7.jpg')  , 
        array (	'full' => 'ccdata/images/full2_2_7.jpg', 'small' => 'ccdata/images/small2_2_7.jpg')  , 
        array (	'full' => 'ccdata/images/full3_2_7.jpg', 'small' => 'ccdata/images/small3_2_7.jpg')  , 
        array (	'full' => 'ccdata/images/full4_2_7.jpg', 'small' => 'ccdata/images/small4_2_7.jpg')  )
      );
    
  $products['3']['2'] =
      
      array(
      'productid' => '2',
      'groupid' => '3',
      'pagehref' => 'viewitem.php?groupid=3&amp;productid=2',
      'name' => 'WVU Mug',
      'shortdescription' => 'Nice mug with WV Logo',
      'longdescription' => '
        <span><span style="font-size:12px;">Blah Blah Blah</span></span>
      ',
      'metakeywords' => 'WVU Mug',
      'metadescription' => 'Nice mug with WV Logo',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000002',
      'yourprice' => '1200',
      'retailprice' => '1200',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_3_2.jpg',
      'main_small' => 'ccdata/images/smallMain_3_2.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_3_2.jpg', 'small' => 'ccdata/images/small1_3_2.jpg')  , 
        array (	'full' => 'ccdata/images/full2_3_2.jpg', 'small' => 'ccdata/images/small2_3_2.jpg')  , 
        array (	'full' => 'ccdata/images/full3_3_2.jpg', 'small' => 'ccdata/images/small3_3_2.jpg')  , 
        array (	'full' => 'ccdata/images/full4_3_2.jpg', 'small' => 'ccdata/images/small4_3_2.jpg')  )
      );
    
  $products['3']['16'] =
      
      array(
      'productid' => '16',
      'groupid' => '3',
      'pagehref' => 'viewitem.php?groupid=3&amp;productid=16',
      'name' => 'Titlegdf',
      'shortdescription' => 'Shogdfsgrt Description',
      'longdescription' => '
        <span><span style="font-size:12px;">ghgdh</span></span>
      ',
      'metakeywords' => 'Titlegdf',
      'metadescription' => 'Shogdfsgrt Description',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000016',
      'yourprice' => '200',
      'retailprice' => '800',
      'discount' => '600',
      'ispercentage' => '0',
      'tax' => 'Merchandise',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_3_16.jpg',
      'main_small' => 'ccdata/images/smallMain_3_16.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_3_16.jpg', 'small' => 'ccdata/images/small1_3_16.jpg')  , 
        array (	'full' => 'ccdata/images/full2_3_16.jpg', 'small' => 'ccdata/images/small2_3_16.jpg')  , 
        array (	'full' => 'ccdata/images/full3_3_16.jpg', 'small' => 'ccdata/images/small3_3_16.jpg')  , 
        array (	'full' => 'ccdata/images/full4_3_16.jpg', 'small' => 'ccdata/images/small4_3_16.jpg')  )
      );
    
  $products['4']['3'] =
      
      array(
      'productid' => '3',
      'groupid' => '4',
      'pagehref' => 'viewitem.php?groupid=4&amp;productid=3',
      'name' => 'TSexy WVU sOX',
      'shortdescription' => '100% cotton baby',
      'longdescription' => '
        <span><span style="font-size:12px;">KK;LJKLJK;LFDAS</span></span>
      ',
      'metakeywords' => 'TSexy WVU sOX',
      'metadescription' => '100% cotton baby',
      'weight' => '100',
      'weightunits' => 'lbs',
      'isstarred' => '1',
      'sku' => 'SKU_00000003',
      'yourprice' => '600',
      'retailprice' => '600',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'Merchandise',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_4_3.jpg',
      'main_small' => 'ccdata/images/smallMain_4_3.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_4_3.jpg', 'small' => 'ccdata/images/small1_4_3.jpg')  , 
        array (	'full' => 'ccdata/images/full2_4_3.jpg', 'small' => 'ccdata/images/small2_4_3.jpg')  , 
        array (	'full' => 'ccdata/images/full3_4_3.jpg', 'small' => 'ccdata/images/small3_4_3.jpg')  , 
        array (	'full' => 'ccdata/images/full4_4_3.jpg', 'small' => 'ccdata/images/small4_4_3.jpg')  )
      );
    
  $products['4']['5'] =
      
      array(
      'productid' => '5',
      'groupid' => '4',
      'pagehref' => 'viewitem.php?groupid=4&amp;productid=5',
      'name' => 'BDSAFA',
      'shortdescription' => 'DSFADS',
      'longdescription' => '',
      'metakeywords' => 'BDSAFA',
      'metadescription' => 'DSFADS',
      'weight' => '100',
      'weightunits' => 'lbs',
      'isstarred' => '1',
      'sku' => 'SKU_00000005',
      'yourprice' => '400',
      'retailprice' => '400',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'Merchandise',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_4_5.jpg',
      'main_small' => 'ccdata/images/smallMain_4_5.jpg',
      'thumbs' => array(
       )
      );
    
  $products['5']['6'] =
      
      array(
      'productid' => '6',
      'groupid' => '5',
      'pagehref' => 'viewitem.php?groupid=5&amp;productid=6',
      'name' => 'Titlegfffffffhgfh',
      'shortdescription' => 'Shortgfhdgdfghdgfh Description',
      'longdescription' => '
        <span><span style="font-size:12px;">hgdjghg</span></span>
      ',
      'metakeywords' => 'Titlegfffffffhgfh',
      'metadescription' => 'Shortgfhdgdfghdgfh Description',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000006',
      'yourprice' => '800',
      'retailprice' => '800',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_5_6.jpg',
      'main_small' => 'ccdata/images/smallMain_5_6.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_5_6.jpg', 'small' => 'ccdata/images/small1_5_6.jpg')  , 
        array (	'full' => 'ccdata/images/full2_5_6.jpg', 'small' => 'ccdata/images/small2_5_6.jpg')  , 
        array (	'full' => 'ccdata/images/full3_5_6.jpg', 'small' => 'ccdata/images/small3_5_6.jpg')  , 
        array (	'full' => 'ccdata/images/full4_5_6.jpg', 'small' => 'ccdata/images/small4_5_6.jpg')  )
      );
    
  $products['6']['4'] =
      
      array(
      'productid' => '4',
      'groupid' => '6',
      'pagehref' => 'viewitem.php?groupid=6&amp;productid=4',
      'name' => 'Titlehgfh',
      'shortdescription' => 'hgfdhd',
      'longdescription' => '
        <span><span style="font-size:12px;">hgjgh</span></span>
      ',
      'metakeywords' => 'Titlehgfh',
      'metadescription' => 'hgfdhd',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000004',
      'yourprice' => '700',
      'retailprice' => '700',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_6_4.jpg',
      'main_small' => 'ccdata/images/smallMain_6_4.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_6_4.jpg', 'small' => 'ccdata/images/small1_6_4.jpg')  , 
        array (	'full' => 'ccdata/images/full2_6_4.jpg', 'small' => 'ccdata/images/small2_6_4.jpg')  , 
        array (	'full' => 'ccdata/images/full3_6_4.jpg', 'small' => 'ccdata/images/small3_6_4.jpg')  , 
        array (	'full' => 'ccdata/images/full4_6_4.jpg', 'small' => 'ccdata/images/small4_6_4.jpg')  )
      );
    
  $products['7']['9'] =
      
      array(
      'productid' => '9',
      'groupid' => '7',
      'pagehref' => 'viewitem.php?groupid=7&amp;productid=9',
      'name' => 'Titlehjghgfhdjgh',
      'shortdescription' => '546hfhgfhdgh',
      'longdescription' => '
        <span><span style="font-size:12px;">sdad</span></span>
      ',
      'metakeywords' => 'Titlehjghgfhdjgh',
      'metadescription' => '546hfhgfhdgh',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000009',
      'yourprice' => '600',
      'retailprice' => '600',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_7_9.jpg',
      'main_small' => 'ccdata/images/smallMain_7_9.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_7_9.jpg', 'small' => 'ccdata/images/small1_7_9.jpg')  , 
        array (	'full' => 'ccdata/images/full2_7_9.jpg', 'small' => 'ccdata/images/small2_7_9.jpg')  , 
        array (	'full' => 'ccdata/images/full3_7_9.jpg', 'small' => 'ccdata/images/small3_7_9.jpg')  , 
        array (	'full' => 'ccdata/images/full4_7_9.jpg', 'small' => 'ccdata/images/small4_7_9.jpg')  )
      );
    
  $products['8']['10'] =
      
      array(
      'productid' => '10',
      'groupid' => '8',
      'pagehref' => 'viewitem.php?groupid=8&amp;productid=10',
      'name' => 'Titlefdgds',
      'shortdescription' => 'fdgfvfdvd bhh',
      'longdescription' => '
        <span><span style="font-size:12px;">asdasd</span></span>
      ',
      'metakeywords' => 'Titlefdgds',
      'metadescription' => 'fdgfvfdvd bhh',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000010',
      'yourprice' => '400',
      'retailprice' => '400',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_8_10.jpg',
      'main_small' => 'ccdata/images/smallMain_8_10.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_8_10.jpg', 'small' => 'ccdata/images/small1_8_10.jpg')  , 
        array (	'full' => 'ccdata/images/full2_8_10.jpg', 'small' => 'ccdata/images/small2_8_10.jpg')  , 
        array (	'full' => 'ccdata/images/full3_8_10.jpg', 'small' => 'ccdata/images/small3_8_10.jpg')  , 
        array (	'full' => 'ccdata/images/full4_8_10.jpg', 'small' => 'ccdata/images/small4_8_10.jpg')  )
      );
    
  $products['9']['11'] =
      
      array(
      'productid' => '11',
      'groupid' => '9',
      'pagehref' => 'viewitem.php?groupid=9&amp;productid=11',
      'name' => 'Titlefdsfa',
      'shortdescription' => 'rrvv',
      'longdescription' => '
        <span><span style="font-size:12px;">ddsfds</span></span>
      ',
      'metakeywords' => 'Titlefdsfa',
      'metadescription' => 'rrvv',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000011',
      'yourprice' => '400',
      'retailprice' => '400',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_9_11.jpg',
      'main_small' => 'ccdata/images/smallMain_9_11.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_9_11.jpg', 'small' => 'ccdata/images/small1_9_11.jpg')  , 
        array (	'full' => 'ccdata/images/full2_9_11.jpg', 'small' => 'ccdata/images/small2_9_11.jpg')  , 
        array (	'full' => 'ccdata/images/full3_9_11.jpg', 'small' => 'ccdata/images/small3_9_11.jpg')  , 
        array (	'full' => 'ccdata/images/full4_9_11.jpg', 'small' => 'ccdata/images/small4_9_11.jpg')  )
      );
    
  $products['10']['12'] =
      
      array(
      'productid' => '12',
      'groupid' => '10',
      'pagehref' => 'viewitem.php?groupid=10&amp;productid=12',
      'name' => 'Titleeee',
      'shortdescription' => 'dsfadsf',
      'longdescription' => '
        <span><span style="font-size:12px;">ghdhgf</span></span>
      ',
      'metakeywords' => 'Titleeee',
      'metadescription' => 'dsfadsf',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000012',
      'yourprice' => '3400',
      'retailprice' => '3400',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_10_12.jpg',
      'main_small' => 'ccdata/images/smallMain_10_12.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_10_12.jpg', 'small' => 'ccdata/images/small1_10_12.jpg')  , 
        array (	'full' => 'ccdata/images/full2_10_12.jpg', 'small' => 'ccdata/images/small2_10_12.jpg')  , 
        array (	'full' => 'ccdata/images/full3_10_12.jpg', 'small' => 'ccdata/images/small3_10_12.jpg')  , 
        array (	'full' => 'ccdata/images/full4_10_12.jpg', 'small' => 'ccdata/images/small4_10_12.jpg')  )
      );
    
  $products['11']['14'] =
      
      array(
      'productid' => '14',
      'groupid' => '11',
      'pagehref' => 'viewitem.php?groupid=11&amp;productid=14',
      'name' => 'Titledsfdsaf',
      'shortdescription' => 'dsfsadf',
      'longdescription' => '
        <span><span style="font-size:12px;">dsafdsfad</span></span>
      ',
      'metakeywords' => 'Titledsfdsaf',
      'metadescription' => 'dsfsadf',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000014',
      'yourprice' => '4000',
      'retailprice' => '4000',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_11_14.jpg',
      'main_small' => 'ccdata/images/smallMain_11_14.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_11_14.jpg', 'small' => 'ccdata/images/small1_11_14.jpg')  , 
        array (	'full' => 'ccdata/images/full2_11_14.jpg', 'small' => 'ccdata/images/small2_11_14.jpg')  , 
        array (	'full' => 'ccdata/images/full3_11_14.jpg', 'small' => 'ccdata/images/small3_11_14.jpg')  , 
        array (	'full' => 'ccdata/images/full4_11_14.jpg', 'small' => 'ccdata/images/small4_11_14.jpg')  )
      );
    
  $products['12']['13'] =
      
      array(
      'productid' => '13',
      'groupid' => '12',
      'pagehref' => 'viewitem.php?groupid=12&amp;productid=13',
      'name' => 'Title333',
      'shortdescription' => 'dsfasd',
      'longdescription' => '',
      'metakeywords' => 'Title333',
      'metadescription' => 'dsfasd',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000013',
      'yourprice' => '400',
      'retailprice' => '400',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_12_13.jpg',
      'main_small' => 'ccdata/images/smallMain_12_13.jpg',
      'thumbs' => array(
       )
      );
    
  $products['13']['15'] =
      
      array(
      'productid' => '15',
      'groupid' => '13',
      'pagehref' => 'viewitem.php?groupid=13&amp;productid=15',
      'name' => 'Titledfdsf',
      'shortdescription' => 'fff',
      'longdescription' => '
        <span><span style="font-size:12px;">hjhdgjghjdg</span></span>
      ',
      'metakeywords' => 'Titledfdsf',
      'metadescription' => 'fff',
      'weight' => '',
      'weightunits' => '',
      'isstarred' => '1',
      'sku' => 'SKU_00000015',
      'yourprice' => '400',
      'retailprice' => '400',
      'discount' => '000',
      'ispercentage' => '0',
      'tax' => 'None',
      'shipping' => '100',
      'handling' => '100',
      'options' => array (
         
      ),
      'typequantity' => 'default_quantity',
      'defaultquantity' => '1',
      'minrangequantity' => '1',
      'maxrangequantity' => '5',
      'main_full' => 'ccdata/images/imageMain_13_15.jpg',
      'main_small' => 'ccdata/images/smallMain_13_15.jpg',
      'thumbs' => array(
      
        array (	'full' => 'ccdata/images/full1_13_15.jpg', 'small' => 'ccdata/images/small1_13_15.jpg')  , 
        array (	'full' => 'ccdata/images/full2_13_15.jpg', 'small' => 'ccdata/images/small2_13_15.jpg')  , 
        array (	'full' => 'ccdata/images/full3_13_15.jpg', 'small' => 'ccdata/images/small3_13_15.jpg')  , 
        array (	'full' => 'ccdata/images/full4_13_15.jpg', 'small' => 'ccdata/images/small4_13_15.jpg')  )
      );
    
 

    
  $starredproducts = array (    
            
                array(	
                  'productid' => '0',
                  'groupid' => '0',
                 )  , 
                array(	
                  'productid' => '8',
                  'groupid' => '0',
                 )  , 
                array(	
                  'productid' => '7',
                  'groupid' => '2',
                 )  , 
                array(	
                  'productid' => '2',
                  'groupid' => '3',
                 )  , 
                array(	
                  'productid' => '16',
                  'groupid' => '3',
                 )  , 
                array(	
                  'productid' => '3',
                  'groupid' => '4',
                 )  , 
                array(	
                  'productid' => '5',
                  'groupid' => '4',
                 )  , 
                array(	
                  'productid' => '6',
                  'groupid' => '5',
                 )  , 
                array(	
                  'productid' => '4',
                  'groupid' => '6',
                 )  , 
                array(	
                  'productid' => '9',
                  'groupid' => '7',
                 )  , 
                array(	
                  'productid' => '10',
                  'groupid' => '8',
                 )  , 
                array(	
                  'productid' => '11',
                  'groupid' => '9',
                 )  , 
                array(	
                  'productid' => '12',
                  'groupid' => '10',
                 )  , 
                array(	
                  'productid' => '14',
                  'groupid' => '11',
                 )  , 
                array(	
                  'productid' => '13',
                  'groupid' => '12',
                 )  , 
                array(	
                  'productid' => '15',
                  'groupid' => '13',
                 ) 
    );

    
  $categoryproducts = array (
    
      array(
      'productid' => '0',
      'groupid' => '0',
      )  , 
      array(
      'productid' => '8',
      'groupid' => '0',
      )  , 
      array(
      'productid' => '7',
      'groupid' => '2',
      )  , 
      array(
      'productid' => '2',
      'groupid' => '3',
      )  , 
      array(
      'productid' => '16',
      'groupid' => '3',
      )  , 
      array(
      'productid' => '3',
      'groupid' => '4',
      )  , 
      array(
      'productid' => '5',
      'groupid' => '4',
      )  , 
      array(
      'productid' => '6',
      'groupid' => '5',
      )  , 
      array(
      'productid' => '4',
      'groupid' => '6',
      )  , 
      array(
      'productid' => '9',
      'groupid' => '7',
      )  , 
      array(
      'productid' => '10',
      'groupid' => '8',
      )  , 
      array(
      'productid' => '11',
      'groupid' => '9',
      )  , 
      array(
      'productid' => '12',
      'groupid' => '10',
      )  , 
      array(
      'productid' => '14',
      'groupid' => '11',
      )  , 
      array(
      'productid' => '13',
      'groupid' => '12',
      )  , 
      array(
      'productid' => '15',
      'groupid' => '13',
      ) 
    );


    
  $creditcards = array (
      
      );
    
    ?>