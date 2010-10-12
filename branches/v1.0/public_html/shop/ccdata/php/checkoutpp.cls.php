<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Extension of Page for checking out with PayPal.
*
* @version $Revision: 2329 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/
class CheckoutPage extends Page {

	var $resArray;						// responses from PayPayl

	function CheckoutPage ( ) {

		Page::Page();

		if( isset($_SESSION[PAYMENT]) )
			$this->resArray = unserialize( $_SESSION[PAYMENT] );
		else
			$this->resArray = array();
	}


	function authorizePayment ( ) {

		// some data validation
		if( $this->cart->getGrandTotalCart() == 0 ||
			$this->getConfig('shopcurrency') == "" )
			return "FAILURE";

		// csrt lines may not have 0 quantities
		foreach( $this->cart->getPairProductIdGroupId() as $article ) {

			if( (int) $this->cart->getSubtotalPriceProduct( $article['cartid'] ) == 0 ) {

				$this->setCartMessage( _T("You can't checkout with items that have a price of '0.00'. Please delete them from the cart.") );
				return "WARNING";

			}
		}

		// new transaction start - clear any old data
		$this->clearSessionData();

		// from this point onwards, the cart can NOT be changed anymore
		$this->lockCart(true);

		// my url, must be without any query part
		$url = $this->getFullUrl( false, false );

		// save the amount we send out, only used for display purposes
		$this->resArray['AMT'] = formatMoney($this->cart->getGrandTotalCart(), 100, 'en');

		$returnURL = urlencode($url);
		$cancelURL = urlencode($url . '?cancel=1');

		$nvpstr = '&PAYMENTACTION=' . $this->getConfig('transaction')
		 		. '&RETURNURL=' . $returnURL
				. '&CANCELURL=' . $cancelURL
				. '&CURRENCYCODE=' . $this->getConfig('shopcurrency')
				. '&LANDINGPAGE=Billing';			// can be Billing or Login

		// add line item info with the SetExpressCheckout call because of a possible
		// redirect to GiroPay before the DoExpressCheckoutPayment call
		$this->addLineItems( $nvpstr );
		$this->addTotals ( $nvpstr ) ;

		if( $this->getConfig( 'PayPal', 'USE_GIROPAY') ) {
			$nvpstr .= '&GIROPAYSUCCESSURL=' . urlencode( $url . '?gpok=1' )		// redirect URL after a successful giropay payment.
					 . '&GIROPAYCANCELURL=' . urlencode( $url . '?gpok=0' )			// redirect URL after a payment is cancelled or fails.
					 . '&BANKTXNPENDINGURL=' . urlencode( $url . '?gpok=2' );		// redirect URL after a bank transfer payment.
		}
		#echo $nvpstr;


		/* Make the call to PayPal to set the Express Checkout token
		 * If the API call succeded, then redirect the buyer to PayPal
		 * to begin to authorize payment.  If an error occured, show the resulting errors
		 */
		$this->hash_call("SetExpressCheckout", $nvpstr);
		#print_r($this->resArray);
		$ack = strtoupper($this->resArray["ACK"]);

		return $ack;
	}


	function redirectPayPal ( $withAjax = false ) {

		if( !isset($this->resArray["TOKEN"]) ) return;

		// make sure the cart stays locked
		$this->lockCart(true);

		// Redirect to paypal.com
		$payPalURL = $this->getConfig('PayPal', 'PAYPAL_URL') . urldecode($this->resArray["TOKEN"]);

		header("Location: " . $payPalURL);
	}


	function getPaymentDetails ( ) {

		// make sure the cart stays locked
		$this->lockCart(true);

		$nvpstr = '&TOKEN=' . urlencode($this->resArray['TOKEN']);
		$this->hash_call("GetExpressCheckoutDetails", $nvpstr);

		// check for the 'REDIRECTREQUIRED' field to learn if GIROPAY was selected by the buyer

		return strtoupper($this->resArray["ACK"]);
	}


	function finalizePayment ( ) {

		// make sure the cart stays locked
		$this->lockCart(true);

		// start building the name-value pair string
		$nvpstr = '&TOKEN=' . urlencode($this->resArray['TOKEN'])
				. '&PAYERID=' . urlencode($this->resArray['PAYERID'])
				. '&PAYMENTACTION=' . urlencode($this->getConfig('transaction'))
				. '&CURRENCYCODE=' . urlencode($this->getConfig('shopcurrency'))
				. '&IPADDRESS=' . urlencode($_SERVER['SERVER_NAME']);

		$this->addLineItems( $nvpstr );
		$this->addTotals ( $nvpstr ) ;

		// Call PayPal
		$this->hash_call("DoExpressCheckoutPayment", $nvpstr);
		#print_r($this->resArray);

		$ack = strtoupper($this->resArray["ACK"]);

		if( $ack == 'SUCCESS' ) {
			$this->emptyCart();									// reset & unlock the cart for next transaction
			unset( $this->resArray['TOKEN'] );					// or else PP may complain about duplicate transactions
			$_SESSION[PAYMENT] = serialize( $this->resArray );	// and make sure the session is also updated
		}
		return $ack;
	}


/*********************** PRIVATE METHODS *********************************/

	function addTotals ( &$nvp ) {

		$itemTax = '&TAXAMT=' . urlencode( number_format( $this->cart->getTotalTax() / 100, 2, '.', '') );
		$itemAmt = '&ITEMAMT=' . urlencode( number_format( ( $this->cart->getSubtotalPriceCart() + $this->cart->getShippingHandlingTotal() ) / 100, 2, '.', '') );

		// note: shipping is now a seperate line-item and included in the grand-total
		//$shipping = '&SHIPPINGAMT=' . urlencode(formatMoney($this->cart->getShippingProducts(), 100, 'en'));
		//$handling = '&HANDLINGAMT=' . urlencode(formatMoney($this->cart->getTotalHandling(), 100, 'en'));
		$grandtotal = '&AMT=' . urlencode( number_format( $this->cart->getGrandTotalCart() / 100, 2, '.', '') );

		$nvp .= $grandtotal . $itemAmt . $itemTax /*. $shipping . $handling */;
	}

	 /*	NOTE: If the line item details do not add up to ITEMAMT or TAXAMT, the line item details are
		discarded, and the transaction is processed using the values of ITEMAMT or TAXAMT.
		The ACK value in the response is set to SuccessWithWarning.
	 */
	function addLineItems ( &$nvp ) {

		/* Line items in cart */
		$nams = ''; 	// name
		$nums = '';		// sequence number
		$qtys = '';		// quantity
		$taxs = '';		// tax
		$amts = '';		// price

		$i = 0;
		foreach( $this->cart->getPairProductIdGroupId() as $article ) {

			$cid =& $article['cartid'];

			$nams .= '&L_NAME'   . $i . '=' . urlencode( substr($this->cart->getName($cid)
				   . $this->cart->getOptionsAsText($cid, ' / '), 0, 127) );	// PayPal accepts 127 chars max
			$nums .= '&L_NUMBER' . $i . '=' . ($i + 1);
			$qtys .= '&L_QTY'    . $i . '=' . urlencode( $this->cart->getUnitsOfProduct($cid) );
			$taxs .= '&L_TAXAMT' . $i . '=' . urlencode( number_format( $this->cart->getTotalTaxAmountProduct($cid) / 100, 2, '.', '') /
														$this->cart->getUnitsOfProduct($cid) );
			$amts .= '&L_AMT'    . $i . '=' . urlencode( number_format( $this->cart->getPrice($cid) / 100, 2, '.', '') );
			$i++;
		}

		// add extra shipping as a line item
		$es_amount = $this->cart->getShippingHandlingTotal();
		if( $es_amount != 0 ) {

			$nams .= '&L_NAME'   . $i . '=' . maxLenEncode( $this->getExtraShipping( $this->getExtraShippingIndex() ), 127 );
			$nums .= '&L_NUMBER' . $i . '=' . ($i + 1);
			$qtys .= '&L_QTY'    . $i . '=1';
			$taxs .= '&L_TAXAMT' . $i . '=' . urlencode( number_format( $this->cart->getTaxAmountExtraShipping() / 100, 2, '.', '' ) );
			$amts .= '&L_AMT'    . $i . '=' . urlencode( number_format( $es_amount / 100, 2, '.', '' ) );
			$i++;
		}

		$nvp .= $nams . $nums . $qtys . $taxs . $amts;							// add list items

	}


	/* hash_call: Function to perform the API call to PayPal using API signature
	 * @methodName is name of API  method.
	 * @nvpStr is nvp string.
	 * returns an associative array containing the response from the server.
	 */
	function hash_call ( $methodName, $nvpStr )
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getConfig('PayPal', 'API_ENDPOINT'));
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);

		// Turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	    // Proxy will only be enabled if USE_PROXY is set to TRUE
		if( $this->getConfig('PayPal', 'USE_PROXY') ) {
			curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			curl_setopt ($ch, CURLOPT_PROXY,
							  $this->getConfig('PayPal', 'PROXY_HOST')
			 				. ":" . $this->getConfig('PayPal', 'PROXY_PORT') );
		}

		$nvpreq = "METHOD="	. urlencode($methodName)
				. "&VERSION=" . urlencode($this->getConfig('PayPal', 'VERSION'))
				. "&PWD=" . urlencode($this->getConfig('PayPal', 'API_PASSWORD'))
				. "&USER=" . urlencode($this->getConfig('PayPal', 'API_USERNAME'))
				. "&SIGNATURE=" . urlencode($this->getConfig('PayPal', 'API_SIGNATURE'))
				. $nvpStr;

		#echo $nvpreq;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
		$response = curl_exec($ch);

		$this->updateResultArray( $response );

		if( curl_errno($ch) ) {
			die(curl_errno($ch)  . ': ' . curl_error($ch));
		} else {
			curl_close($ch);
		}
	}


	function updateResultArray ( $nvpstr )
	{
		#echo "Name-Value pair string: " . $nvpstr;
		while( strlen($nvpstr) ) {
			$keypos = strpos($nvpstr, '=');
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&') : strlen($nvpstr);

			$keyval = substr($nvpstr, 0, $keypos);
			$valval = substr($nvpstr, $keypos + 1, $valuepos - $keypos - 1);

			$this->resArray[urldecode($keyval)] = urldecode($valval);
			$nvpstr = substr($nvpstr, $valuepos + 1);
	     }

		$_SESSION[PAYMENT] = serialize($this->resArray);
	}


	function clearSessionData ( ) {

		if( isset($_SESSION[PAYMENT]) )
			unset($_SESSION[PAYMENT]);
		$this->resArray = array();
	}

}

?>
