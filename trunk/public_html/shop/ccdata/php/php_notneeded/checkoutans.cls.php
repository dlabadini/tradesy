<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Extension of Page for checking out with Auth.Net.
*
*
* The auth.net form does not show any shipping/handling info on the credit card form (and there
* is no way to add it).
* Solution: abuse the description field for this pupose.
*
* @version $Revision: 2265 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/


class CheckoutPage extends Page {

	function CheckoutPage ( ) {
		parent::Page();
	}

	function getCheckoutFields ( ) {

		// make sure the cart stays locked
		$this->lockCart( true );

		$fields = '';
		$this->addMessageToMessage( $fields );
		$this->addHeader( $fields );
		$this->addProductsToMessage( $fields );
		$this->addShippingToMessage( $fields );
		$this->addTaxToMessage( $fields );

		#print_r($fields);
		return $fields;

	}



	/*********************** PRIVATE METHODS *********************************/

	function addMessageToMessage ( &$fields ) {

		$message = sprintf( _T("The total amount includes %s %s for shipping, handling and taxes."),
		         	$this->curSign,
					formatMoney( $this->cart->getShippingHandlingTotal() +
								 $this->cart->getTotalTax(), 100) );

		if( $this->getExtraShipping( $this->getExtraShippingIndex() ) )
			$message .= sprintf( _T(" You selected shipping option: &quot;%s&quot;."),
						$this->getExtraShipping( $this->getExtraShippingIndex() ) );

		$fields = '<input type="hidden" name="x_description" value="' . maxLenEncode( $message, 255 ) . '" />';
	}


	function addHeader ( &$fields )
	{
		// prepare info that is independent from cart contents
		$amount = number_format($this->cart->getGrandTotalCart() / 100, 2, '.', '');
		$tstamp = time ();
		srand( $tstamp );				// seed random number for security and better randomness.
		$sequence = rand( 1, 1000 );
		$fingerprint = hmac ($this->getConfig('AuthorizeNetSIM', 'API_KEY'),
							 $this->getConfig('AuthorizeNetSIM', 'API_LOGIN')
						   . "^" . $sequence
						   . "^" . $tstamp
						   . "^" . $amount . "^" );

		$fields .= '<input type="hidden" name="x_fp_sequence"   value="'  . $sequence . '" />'
				 . '<input type="hidden" name="x_fp_timestamp"   value="' . $tstamp . '" />'
				 . '<input type="hidden" name="x_fp_hash"        value="' . $fingerprint . '" />'
				 . '<input type="hidden" name="x_login"          value="' . $this->getConfig('AuthorizeNetSIM', 'API_LOGIN') . '" />'
				 . '<input type="hidden" name="x_version"        value="3.1" />'
				 . '<input type="hidden" name="x_relay_response" value="1" />'				// correct url must be defined in Auth.Net
				 . '<input type="hidden" name="x_show_form"      value="PAYMENT_FORM" />'
				 . '<input type="hidden" name="x_test_request"   value="' . $this->getConfig('AuthorizeNetSIM', 'TEST_MODE') . '" />'
				 . '<input type="hidden" name="x_duplicate_window" value="3600" />'			// check for duplicate transactions during 1 hrs
				 . '<input type="hidden" name="x_method"         value="CC"/>'				// Credit Card method (not eCheck)
				 . '<input type="hidden" name="x_type"           value="AUTH_CAPTURE"/>'	// approve & submit
				 . '<input type="hidden" name="x_amount"         value="' . $amount. '" />'
    			 . '<input type="hidden" name="x_receipt_link_method" value="LINK" />'
    			 . '<input type="hidden" name="x_receipt_link_text" value="Return to ' . $this->getConfig('shopname') . '" />'
    			 . '<input type="hidden" name="x_receipt_link_url" value="' . $this->getFullUrl('index.php', false, true) . '" />';
	}
	// From Authorize.Net sample code
	// compute HMAC-MD5
	function xhmac ( $key, $data )
	{
		return (bin2hex (mhash(MHASH_MD5, $data, $key)));
	}

	// Calculate and return fingerprint
	function CalculateFP ( $loginid, $x_tran_key, $amount, $sequence, $tstamp, $currency = "" )
	{
		return (hmac ($x_tran_key, $loginid . "^" . $sequence . "^" . $tstamp . "^" . $amount . "^" . $currency));
	}


	/* format: x_line_item = ID <|> name | description <|> quantity <|> unit price <|> taxable */
	function addProductsToMessage ( &$nvp ) {

		foreach( $this->cart->getPairProductIdGroupId() as $article ) {

			$cid =& $article['cartid'];

			// ensure the description + option text is not too long
			$optionstxt = maxLenEncode( $this->cart->getOptionsAsText( $cid, ' / ' ) );
			$descr = maxLenEncode( $this->cart->getDescr( $cid ), 255 - strlen( $optionstxt ) )
				   . $optionstxt;

			// create some sort of product id
			$id = $this->cart->getProductProperty( $cid, 'refcode' );
			if( empty( $id) )
				$id = $this->cart->getGroupId( $cid ) . '/' . $this->cart->getId( $cid );

			$nvp .= '<input type="hidden" name="x_line_item" value="'
				  . maxLenEncode( $id, 31 )
				  . '<|>' . maxLenEncode( $this->cart->getName( $cid ), 31 )
				  . '<|>' . $descr
				  . '<|>' . $this->cart->getUnitsOfProduct( $cid )
				  . '<|>' . number_format( $this->cart->getPrice( $cid ) / 100, 2, '.', '' )
				  . '<|>' . ( $this->cart->hasTaxAmountProduct( $cid ) ? 1 : 0 )
				  . '" />';
		}

		// add extra shipping as line-item too
		$es_amount = $this->cart->getShippingHandlingTotal();
		if( $es_amount != 0 ) {
			$nvp .= '<input type="hidden" name="x_line_item" value="ship'
				  . '<|>' . 'Shipping option'
				  . '<|>' . $this->getExtraShipping( $this->getExtraShippingIndex() )
				  . '<|>' . '1'
				  . '<|>' . number_format( $es_amount / 100, 2, '.', '' )
				  . '<|>' . ( $this->cart->getTaxAmountExtraShipping ( ) > 0 ? 1 : 0 )
				  . '" />';
		}

	}


	/* format: x_freigt= Freight1<|>ground overnight<|>12.95 */
	function addShippingToMessage ( &$nvp ) {

		$nvp .= '<input type="hidden" name="x_freight" value="'
			  . 'Shipping-Handling'
			  . '<|>' . maxLenEncode( $this->getExtraShipping( $this->getExtraShippingIndex() ) )
			  . '<|>' . number_format( $this->cart->getShippingHandlingTotal() / 100, 2, '.', '' )
		 	  . '" />';
	}


	function addTaxToMessage ( &$nvp ) {

		$nvp .= '<input type="hidden" name="x_tax" value="'
			  . number_format( $this->cart->getTotalTax() / 100, 2, '.', '' )
		 	  . '" />';
	}


}


function hmac ( $key, $data ) {
   // RFC 2104 HMAC implementation for php.
   // Creates an md5 HMAC, eliminates the need to install mhash to compute a HMAC
   // Hacked by Lance Rushing
   $b = 64; // byte length for md5
   if( strlen( $key ) > $b ) {
       $key = pack( "H*", md5($key) );
   }
   $key  = str_pad( $key, $b, chr(0x00) );
   $ipad = str_pad( '', $b, chr(0x36) );
   $opad = str_pad( '', $b, chr(0x5c) );
   $k_ipad = $key ^ $ipad ;
   $k_opad = $key ^ $opad;
   return md5( $k_opad  . pack( "H*", md5( $k_ipad . $data ) ) );
}

?>