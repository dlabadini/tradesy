<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Stuff that needs to be include at the start of all html pages.
*
* This file MUST be included in ALL pages!
*
* @version $Revision: 2265 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="ccdata/js/jquery.js"></script>
<script type="text/javascript">
<!-- <![CDATA[
	function showError ( message ) {
		var e = $("#js_error_msg");
		if( $("#js_error_msg").length == 0 ) {
			$("body").append('<div id="js_error_msg" style="position:absolute;z-index:10;width:40%;left:30%;border: solid 1px Firebrick;padding:20px;background-color:white;color:Firebrick;" />');
		}
		if( message == "" ) {
			// remove message
			$("#js_error_msg").hide();
		} else {
			$("#js_error_msg").html(message).css('top', (window.pageYOffset + 150)).show();
		}
	}

	$(document).ready(
		function(){
  			// do a submit(recalclate) on changed shipping or tax location options
 			$("form.cart select[name='extrashipping']").bind("change",
   				function(e) {
   					$("form.cart input[name='recalculate']").click();
   				}
   			);
 			$("form.cart select[name='taxlocation']").bind("change",
   				function(e) {
   					$("form.cart input[name='recalculate']").click();
   				}
   			);
   			// add some validation on input fields for cart page
   			$("form.cart input[type='text']").bind("keyup",
   				function(e) {
   					// validate all input fields
   					var elms = $("form.cart input[type='text']");
   					var valid = true;
   					for( i = 0; i < elms.length; i++ ) {
   						valid = (elms[i].value.search(/[^0-9 ]/) == -1);
   						if( ! valid ) {
	   						showError("<?php echo _T('Only numbers are allowed in the Quantity field(s).'); ?>");
	   						$("form.cart input[type='submit']").attr("disabled","disabled");
	   						break;
	   					}
   					}
   					if( valid ) {
   						showError("");
   						$("form.cart input[type='submit']").attr("disabled","");
   						$("form.cart input[name='checkout']").attr("disabled","disabled");
   					}
   				}
   			);
   			// quantity validation for product page
   			$("input[name='quantity']").bind("keyup",
   				function(e) {
   					if( this.value.search(/[^0-9 ]/) != -1) {
	   					showError("<?php echo _T('Only numbers are allowed in a Quantity field.'); ?>");
	   					$("input.buylink[type='submit']").attr("disabled","disabled");
	   				} else {
   						showError("");
   						$("input.buylink[type='submit']").attr("disabled","");
   					}
   				}
   			);
   			// hide empty warning box (temporary fix, until 'p' tag is removed)
   			$("p.cart_messages:contains('<div')").hide();
 		}
 	);
 // ]]> -->
</script>