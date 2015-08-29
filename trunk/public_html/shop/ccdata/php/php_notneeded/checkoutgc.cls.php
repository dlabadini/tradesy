<?php
/*
 * example checkout message
 * <?xml version="1.0" encoding="UTF-8"?>
 * <checkout-shopping-cart xmlns="http://checkout.google.com/schema/2">
 *   <shopping-cart>
 *     <items>
 *       <item>
 *         <item-name>HelloWorld 2GB MP3 Player</item-name>
 *        <item-description>HelloWorld, the simple MP3 player</item-description>
 *         <unit-price currency="USD">159.99</unit-price>
 *         <quantity>1</quantity>
 *      </item>
 *     </items>
 *   </shopping-cart>
 *   <checkout-flow-support>
 *    <merchant-checkout-flow-support/>
 *   </checkout-flow-support>
 * </checkout-shopping-cart>
 */

class CheckoutPage extends Page {

	var $resArray;						// responses from Google Checkout

	var $glmsg = '<?xml version="1.0" encoding="UTF-8"?>';

	function CheckoutPage ( ) {
		Page::Page();
	}


	// return false on errors
	function checkOut ( ) {

		// make sure the cart stays locked
		$this->lockCart(true);

		$this->glmsg .=  '<checkout-shopping-cart xmlns="http://checkout.google.com/schema/2">';
		$this->addProductsToMessage();

		$this->glmsg .= '<checkout-flow-support>';
		$this->glmsg .= '<merchant-checkout-flow-support>';
		$this->glmsg .= '<edit-cart-url>' . htmlspecialchars( $this->getFullUrl( 'cart.php', false, true ), ENT_NOQUOTES) . '</edit-cart-url>';
		$this->addShippingToMessage();
		$this->addTaxRates();
		$this->glmsg .= '</merchant-checkout-flow-support>';
		$this->glmsg .= '</checkout-flow-support>';

		$this->glmsg .= '</checkout-shopping-cart>';

		// contact Google
		$this->htmlapi_call();
		#print_r($this->resArray);

		if( $this->resArray['ACK'] != 'redirect' ) {
			return false;
		}

		header("Location: " . $this->resArray['URL']);

		return true;
	}



	/*********************** PRIVATE METHODS *********************************/

	function addProductsToMessage ( ) {

		$this->glmsg .= '<shopping-cart><items>';

		foreach( $this->cart->getPairProductIdGroupId() as $article ) {

			$cid =& $article['cartid'];
			$descr = htmlspecialchars( $this->cart->getDescr($cid)
				   . $this->cart->getOptionsAsText($cid, ' / '), ENT_NOQUOTES);
			$item = '<item>';
			$item .= '<item-name>' . htmlspecialchars( $this->cart->getName($cid), ENT_NOQUOTES) . '</item-name>';
			$item .= '<item-description>' . $descr . '</item-description>';
			$item .= '<quantity>' . $this->cart->getUnitsOfProduct($cid) . '</quantity>';
			$item .= '<unit-price currency="' . $this->getConfig('shopcurrency') . '">'
				  .  number_format($this->cart->getPrice($cid) / 100, 2, '.', '') . '</unit-price>';
			$item .= '<tax-table-selector>' . htmlspecialchars( $this->cart->getTaxRateName($cid), ENT_NOQUOTES) . '</tax-table-selector>';

			$this->glmsg .= $item . '</item>';
		}

		// no need to add shipping option as a line item, because GC does that after authentication

		$this->glmsg .= '</items></shopping-cart>';
	}


	function addShippingToMessage ( ) {

		// get reference to extra-shipping array
		$methods =& $this->getExtraShipping();

		if( $methods === false || count($methods) == 0 ) return;

		$this->glmsg .= '<shipping-methods>';

		// add the selected method first, because we can't pass a selection index to google.
		if( ($index = $this->getExtraShippingIndex()) >= 0) {
			$this->glmsg .= '<flat-rate-shipping name="' . htmlspecialchars( $this->getExtraShipping($index), ENT_NOQUOTES) . '">'
						  . '<price currency="' . $this->getConfig('shopcurrency') . '">'
						  . number_format(  $this->cart->getShippingHandlingTotal() / 100, 2, '.', '')
						  . '</price>'
						  . '</flat-rate-shipping>';
		}

	for( $i = 0; $i < count($methods) ; ++$i ) {
			if(  $methods[$i]['id'] == $index ) continue;			
			$this->glmsg .= '<flat-rate-shipping name="' . htmlspecialchars(  $methods[$i]['description'], ENT_NOQUOTES) . '">'
						  . '<price currency="' . $this->getConfig('shopcurrency') . '">'
						  . number_format( $this->cart->getShippingHandlingTotal( $methods[$i]['id'] ) / 100, 2, '.', '')
						  . '</price>'
						  . '</flat-rate-shipping>';
		}
		$this->glmsg .= '</shipping-methods>';
    }


	/*
	 * setup to charge the same tax world-wide using the alternate tables
	 * use <tax-table-selector> in products lines to select the appropriate tax table
	 * Google expects 'multiplier' values, not %!
	 */
    function addTaxRates ( ) {

		$taxratekeys = $this->cart->lookupProductTaxRates( true );

		$this->glmsg .= '<tax-tables>'
		         	  . '<default-tax-table>'
            		  . '<tax-rules>'
            		  . '<default-tax-rule>'
            		  . '<rate>0</rate>'
            		  . '<tax-area><world-area/></tax-area>'
            		  . '</default-tax-rule>'
            		  . '</tax-rules>'
            		  . '</default-tax-table>'
					  . '<alternate-tax-tables>';

		if( is_array( $taxratekeys ) ) {
			foreach( $taxratekeys as $key ) {
				$this->glmsg .= '<alternate-tax-table standalone="true" name="' . htmlspecialchars( $key, ENT_NOQUOTES) . '">'
							  . '<alternate-tax-rules>'
							  . 	'<alternate-tax-rule>'
							  . 		'<rate>' .  strval( $this->cart->lookupTaxPerc( $key ) ) . '</rate>'
							  . 		'<tax-area><world-area/></tax-area>'
							  . 	'</alternate-tax-rule>'
							  . '</alternate-tax-rules>'
							  . '</alternate-tax-table>';
			}
		}

		if( $this->cart->getShippingHandlingTotal() != 0 ) {
			$this->glmsg .= '<alternate-tax-table standalone="true" name="shipping">'
						  . '<alternate-tax-rules>'
						  . 	'<alternate-tax-rule>'
						  . 		'<rate>' . $this->cart->lookupTaxPercSpecial( 'Shipping' ) . '</rate>'
						  . 		'<tax-area><world-area/></tax-area>'
						  . 	'</alternate-tax-rule>'
						  . '</alternate-tax-rules>'
						  . '</alternate-tax-table>';
		}


		$this->glmsg .= '</alternate-tax-tables>'
					  . '</tax-tables>';
	}


	function htmlapi_call ( ) {
		$ch = curl_init();
		$url = $this->getConfig('Google', 'url') . $this->getConfig('Google', 'merchant_id') /* . '/diagnose' */ ;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TRANSFERTEXT, 1);
		curl_setopt($ch, CURLOPT_POST, 1);

		// set authorization header
		$headers = array( 'Authorization: Basic '
							. base64_encode( $this->getConfig('Google', 'merchant_id') . ':'
							. $this->getConfig('Google', 'merchant_key') ),
						  'Content-Type: application/xml;charset=UTF-8',
						  'Accept: application/xml;charset=UTF-8;' );

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		// Turn off server and peer verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

	    // Proxy will only be enabled if USE_PROXY is set to TRUE
		if( $this->getConfig('Google', 'USE_PROXY') ) {
			curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			curl_setopt ($ch, CURLOPT_PROXY,
							  $this->getConfig('Google', 'PROXY_HOST')
			 				. ":" . $this->getConfig('Google', 'PROXY_PORT') );
		}

		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->glmsg);
		#echo $this->glmsg; die();

		$response = curl_exec($ch);

		$this->updateResultArray($response);

		if( curl_errno($ch) ) {
			die(curl_errno($ch)  . ': ' . curl_error($ch));
		} else {
			curl_close($ch);
		}
	}


	function updateResultArray ( $response ) {
		$parser = xml_parser_create("UTF-8");

		$values = array(); $index = array();
		if( xml_parse_into_struct( $parser, $response, $values, $index) == 0 ) {
			// failure
			xml_parser_free($parser);
			$this->resArray['ACK'] = 'error';
			return;
		}

		#echo $response; print_r($index); print_r($values);

		if( isset($index['ERROR-MESSAGE']) ) {
			$this->resArray['ACK'] = 'error';
			$this->resArray['MESSAGE'] = $values[ $index['ERROR-MESSAGE'][0] ]['value'];
			$this->resArray['POST'] = $this->glmsg;
			xml_parser_free($parser);
			return;
		}

		if( isset($index['REDIRECT-URL']) ) {
			$this->resArray['ACK'] = 'redirect';
			$this->resArray['URL'] = $values[ $index['REDIRECT-URL'][0] ]['value'];
		}

		xml_parser_free( $parser );
	}
}
?>