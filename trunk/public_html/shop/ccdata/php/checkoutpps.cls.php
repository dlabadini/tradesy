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
* @version $Revision: 1866 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/


class CheckoutPage extends Page {

	var $lineNum = 1;	// must start with 1

	function CheckoutPage ( ) {
		parent::Page();
	}

	function getCheckoutFields ( ) {

		// make sure the cart stays locked
		$this->lockCart( true );

		$fields = '';
		$this->addHeaderToMessage( $fields );
		$this->addProductsToMessage( $fields );
		$this->addShippingHandlingToMessage( $fields );
		$this->addTaxToMessage( $fields );

		#print_r($fields);
		return $fields;

	}



	/*********************** PRIVATE METHODS *********************************/

	function addHeaderToMessage ( &$fields )
	{
		// info that is independent from cart contents

		$fields .= '<input type="hidden" name="business"   value="'  . $this->getConfig('PayPalWPS', 'BUSINESS') . '" />'
				 . '<input type="hidden" name="cmd" value="_cart" />'
				 . '<input type="hidden" name="upload" value="1" />'
				 . '<input type="hidden" name="return" value="' . $this->getFullUrl( false , false ) . '" />'
				 . '<input type="hidden" name="cancel_return" value="' . $this->getFullUrl( false, false ) . '?cancel" />'
				 . '<input type="hidden" name="amount" value="' . number_format($this->cart->getGrandTotalCart() / 100, 2, '.', '') . '" />'
				 //. '<input type="hidden" name="handling_cart" value="' . number_format( $this->cart->getShippingHandlingTotal() / 100, 2, '.', '') . '" />'
				 //. '<input type="hidden" name=" " value="' . . '" />'
				 //. '<input type="hidden" name=" " value="' . . '" />'
				 //. '<input type="hidden" name=" " value="' . . '" />'
				 //. '<input type="hidden" name=" " value="' . . '" />'
				 //. '<input type="hidden" name=" " value="' . . '" />'
				 . '<input type="hidden" name="currency_code" value="' . $this->getConfig('shopcurrency') . '" />';

	    if( $this->getConfig('shoplogo') ) {

			$fields .= '<input type="hidden" name="cpp_header image" value="'
					 . $this->getFullUrl( $this->getConfig('shoplogo'), false ) . '" />';
	    }
    }


	function addProductsToMessage ( &$nvp ) {

		foreach( $this->cart->getPairProductIdGroupId() as $article ) {

			$cid =& $article['cartid'];

			// ensure the description + option text is not longer than 127
			$optionstxt = $this->cart->getOptionsAsText( $cid, ' / ' );
			$descr = substr( $this->cart->getName( $cid ), 0, 127 - strlen( $optionstxt ) ) . $optionstxt;

			// create some sort of product id
			$id = $this->cart->getProductProperty( $cid, 'refcode' );
			if( empty( $id) )
				$id = $this->lineNum;

			$nvp .= '<input type="hidden" name="item_name_' . $this->lineNum . '" value="'
				  . $descr . '" />';

			$nvp .= '<input type="hidden" name="item_number_' . $this->lineNum . '" value="'
				  . $id . '" />';

			$nvp .= '<input type="hidden" name="amount_' . $this->lineNum . '" value="'
				  . number_format( $this->cart->getPrice( $cid ) / 100, 2, '.', '' ) . '" />';

			$nvp .= '<input type="hidden" name="quantity_' . $this->lineNum . '" value="'
				  . $this->cart->getUnitsOfProduct( $cid ) . '" />'; 	// must be > 0

			$nvp .= '<input type="hidden" name="tax_' . $this->lineNum . '" value="'
				  . number_format( $this->cart->getTotalTaxAmountProduct($cid) /
				  				   $this->cart->getUnitsOfProduct($cid) /
				  				   100, 2, '.', '' )
				  . '" />';

			++$this->lineNum;
		}
	}


	function addShippingHandlingToMessage ( &$nvp ) {

		$amount = $this->cart->getShippingHandlingTotal();

		// shouldn't add line items with cost 0
		if( $amount == 0 ) return;

		// ensure the description + option text is not longer than 127
		$descr = substr( $this->getExtraShipping( $this->getExtraShippingIndex() ), 0, 127);

		$nvp .= '<input type="hidden" name="item_name_' . $this->lineNum . '" value="'
			  . $descr . '" />';

		$nvp .= '<input type="hidden" name="item_number_' . $this->lineNum . '" value="'
			  . 'ship' . '" />';

		$nvp .= '<input type="hidden" name="amount_' . $this->lineNum . '" value="'
			  . number_format( $amount / 100, 2, '.', '' ) . '" />';

		$nvp .= '<input type="hidden" name="quantity_' . $this->lineNum . '" value="1" />';

		$nvp .= '<input type="hidden" name="tax_' . $this->lineNum . '" value="'
			 . $this->cart->getTaxAmountExtraShipping() . '" />';

		++$this->lineNum;
	}


	function addTaxToMessage ( &$nvp ) {

		$nvp .= '<input type="hidden" name="tax_cart" value="'
			  . number_format( $this->cart->getTotalTax() / 100, 2, '.', '' )
		 	  . '" />';
	}


}

?>