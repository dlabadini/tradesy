var isConnecting = 0;
var url = 'controller.php';

function preparePage ( ) {
	// remove all elements that have the 'cc_nojs' class
	$(".cc_nojs").remove();
}

function prepareCartPage ( step ) {
	preparePage();
	switch (step) {
		case -1: 					// empty cart
			$(".cc_connect").unbind().css("backgroundColor","#AAA");
			$(".cc_payment").unbind().css("backgroundColor","#AAA"); 
			break;
		case 0: 					// payment not started
			$(".cc_connect").hover(
				function () { $(this).css("cursor", "pointer") },
				function () { $(this).css("cursor", "auto") }); 
			$(".cc_payment").unbind().css("backgroundColor","#AAA");
			break;
		case 1: 					// token from PayPal received
			$(".cc_connect").unbind().css("backgroundColor","#AAA");
			$(".cc_payment").hover(
				function () { $(this).css("cursor", "pointer") },
				function () { $(this).css("cursor", "auto") }); 
			break;
		case 2: 					// paid and done
			$(".cc_connect").unbind().css("backgroundColor","#AAA").text("Connection Closed");
			$(".cc_payment").unbind().css("backgroundColor","#AAA").text("Payment Confirmed");
			break;
		default:
		 alert("Unexpected value for 'step' (" + step + ") in prepareCartPage.");
	}
}


function updateCheckoutButton ( ) {
	prepareCartPage(0);
	$(".cc_connect").unbind();
	$(".cc_connect").bind('mouseup', function(e) {
			changeCart();
			}).text("Update Cart");
}


function prepareProductPage() {
	preparePage();
	// set the options that are selected in the cart
/*	if( selectedOptions ) {
		var opts = selectedOptions.split(',');
		for( var i = 0; i < opts.length; i++ ) {
			tmpid = 'option' + (i+1) + 'Sel_' + prodId;
			var e = document.getElementById(tmpid);
			if( e ) {
				for( var j = 0; j < e.length; j++ ) {
					if( e.options[j].value == opts[i] ) {
						e.options[j].selected = true;
						break;
					}
				}
			}
		}
	}
	
	// set quantity that is set
	if( cartQty ) {
		var e = document.getElementById('quantitySel_' + prodId);
		if( e ) { e.value = cartQty; }
	}
*/
}


function add ( prodid, grpid ) {

	// get all form fields, string->json conversion with eval()
	var fields = $("input");
	var post = "({"; 
	for( var i = 0; i < fields.length; i++ ) {
		post += fields[i].name + ":'" + fields[i].value + "',";
	}
	fields = $("select");
	for( i = 0; i < fields.length; i++ ) {
		post += fields[i].name + ":'" + fields[i].value + "',";
	}

	// get possible cartid from query string -- no necessary, cartid is hidden form field
	//result = window.location.search.match(/cartid=(\w+)(?:&|$)/);
	//if( result != null) {
	//	post += " cartid:'" + result[1] + "',"; 
	//}
	post += "task:'add', ajax:'1',productid:'" + prodid + "',groupid:'" + grpid + "'})";

	$.post(url, eval(post), function(data){ processData(data); }, 'text');    
}


function popUpMsg ( msg ) {
	popUp();
	$("#cc_popupdiv").html("<img src=\"ccdata/js/coffeecup2.gif\"/>	"
				+ "<p style=\"padding:20px;\">" + msg + "</p>");
}


function popUp ( ) {
	var myDiv = document.getElementById('cc_popupdiv');
	var width = 300;
	if( !myDiv ) {
		myDiv = document.createElement("div");
		myDiv.id = "cc_popupdiv";
		myDiv.style.position = "absolute";
		myDiv.style.textAlign = "center";
		myDiv.style.backgroundColor = "#FFCC80";
		myDiv.style.border = "thin solid #0000FF";
		document.body.appendChild(myDiv); 
	}
	// position (window may have scrolled or changed size since last use)
	myDiv.style.top = width/3 + (document.all ? document.body.scrollTop : window.pageYOffset);
	myDiv.style.left = document.body.clientWidth/2 - width/2;
}


function connectPP ( myUrl ) {
	if( isConnecting == 1 ) {
		return;
	} else {
		isConnecting = 1;
	}
	
	// disable all input elements
	$("input").attr("disabled","disabled");

	// show something, because this takes a while
	popUpMsg("Connecting to PayPal, please wait...");
	window.defaultStatus = "Connecting to PayPal, please wait...";
	$.post(myUrl, { ajax:'1' }, function(data){ processData(data); }, 'text');
}


function confirmPP ( myUrl ) {
	if( isConnecting == 1 ) {
		return;
	} else {
		isConnecting = 1;
	}
	
	// show something, because this takes a while
	popUpMsg("Connecting to PayPal again, please wait...");
	window.defaultStatus = "Connecting to PayPal, please wait...";
	$.ajaxSetup( { timeout: 30000 } );
	$.post(myUrl, { ajax:'1' }, function(data){ processData(data); }, 'text');
}


// ajax data returned from the server
function processData ( data ) {

	isConnecting = 0;
	if (data == '') {
		alert("Ajax call did not return any data.");
		return;
	}
	
	// sometimes providers add garbage, lets clean up 
	var start = data.search(/htmlblock\n|url\n|refresh\n/);
	if( start == -1 ) { start = 0; }

	switch (data.slice(start, data.indexOf('\n', start))) {
		case 'url':
			location.replace(data.slice(data.indexOf('\n', start) + 1));
			popUp("Connecting, please wait...");
			break;
		case 'htmlblock':
			popUp();
			$("#cc_popupdiv").fadeIn('fast');
			$("#cc_popupdiv").html( data.slice(data.indexOf('\n', start) + 1) );
			$("#cc_popupdiv").fadeOut(3000);
			break;
		case 'refresh':
			window.location.reload();
			break;
		default:
			alert("Ajax call returned data that can not be handled: " + data);
	}
}


function changeCart ( ) {
	// string->json conversion with eval()
	var fields = $(":input");
	var post = "({"; 
	for( var i = 0; i < fields.length; i++ ) {
		post += fields[i].name + ":'" + fields[i].value + "',";
	}
	post += " task : 'update', ajax : '1'})";

	$.post(url, eval(post), function(data){ processData(data); }, 'text');
}


function removeProd ( id ) {
	$.post(url, { task: 'remove', ajax : '1', cartid: id },
		   function(data){ processData(data); }, 'text');
}


///// only private functions below this line /////

function getOptionsValue ( e ) {
    if( e != null ) {
    	var idx = e.selectedIndex;
		// if no availble option selected -> return value of first option
		if (idx == -1 ) idx = 0;
    	return e.options[idx].value;
    }
	// if there are no options, return -1
   	return -1;
}


// if a third parametr is set to true, the query is appended, not replaced
function makeUrl ( url, task ) {
	
	var u = (url != '' ? url :  window.location.href);
	
	if( task.charAt(0) != '?' ) { 
		task = '?' + task; 
	}	
	
	if( u.lastIndexOf('?') == -1 ) {
		u += task;
	} else {
		if( arguments.length > 2 && arguments[2]) {
			// append with &
			u += task.replace(/\?/, '&');
		} else {
			// replace
			u = u.replace(/\?[^?]*$/, task);
		}
	}
	return u;
}
