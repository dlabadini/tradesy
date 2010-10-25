// JavaScript Documentvar xmlhttp;

function get_xmlHttp(){
    xmlhttp = GetXmlHttpObject();
    if (xmlhttp == null){
        alert("Browser does not support HTTP Request");
        return;
    }
    return xmlhttp;
    }

function xmlhttp_request(xmlhttp, url, id){
    xmlhttp.onreadystatechange = function(){ stateChanged(id); }
    xmlhttp.open("GET", url, true);
    xmlhttp.send(null);
    }

function stateChanged(id) {
	if (xmlhttp.readyState == 4) {
		document.getElementById(id).innerHTML = xmlhttp.responseText;
	}
}

function GetXmlHttpObject() {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject) {
		// code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}

function addclass(cname, cnumber, id) {
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/addclass.php?";

    //class name
	var index = cname.selectedIndex;
	var classname = cname.options[index].text;

    // class number
	var index = cnumber.selectedIndex;
	var classnumber = cnumber.options[index].text;

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	url = url + "class=" + fixurl(classname) + "&number=" + classnumber
              + "&sid=" + Math.random();

    xmlhttp_request(xmlhttp, url, id);
}

function dropclass(classids, id) {
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/dropclass.php?";

	// prompt
	var answer = confirm("Are you sure you want to drop this class?");
	if (!answer) {
		return;
	} else {
		for (i = 0; i < classids.length; i++) {
			if (classids[i].checked == true) {
				url = url + "&cid[]=" + classids[i].id;
			}
		}
		url = url + "&sid=" + Math.random();
	}

	currdiv = undefined; //clear currdiv (defined in editclasses.php) so the div can be showed again
	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';

    xmlhttp_request(xmlhttp, url, id);
}

function showBook(cname, cnumber, id) {
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/showbook.php?";

	var index = cname.selectedIndex;
	var classname = cname.options[index].text;

	var index = cnumber.selectedIndex;
	var classnumber = cnumber.options[index].text;

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	url = url   + "class=" + fixurl(classname) + "&number="
		    	+ classnumber
                + "&sid=" + Math.random();

	xmlhttp_request(xmlhttp, url, id);
}


function showBookSaveAs(cname, cnumber, id) {
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/savebookas.php?";

	var index = cname.selectedIndex;
	var classname = cname.options[index].text;

	var index = cnumber.selectedIndex;
	var classnumber = cnumber.options[index].text;

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	url = url   + "class=" + fixurl(classname)
                + "&number="  + classnumber
                + "&sid=" + Math.random();

    xmlhttp_request(xmlhttp, url, id);
}

function saveBookAsExisting(cname, cnumber, bookids, id){
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/assign_existing_book_to_class.php?";

	var index = cname.selectedIndex;
	var classname = cname.options[index].text;

	var index = cnumber.selectedIndex;
	var classnumber = cnumber.options[index].text;

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	url = url + "class=" + fixurl(classname) +"&number="+ classnumber;
		for (i = 0; i < bookids.length; i++) {
			if (bookids[i].checked == true) {
				url = url + "&bkid=" + bookids[i].id;
			}
		}
	url = url + "&sid=" + Math.random();

	xmlhttp_request(xmlhttp, url, id);
}

function unassignClassBook(classid, bookids, id){
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/unassign_class_book.php?";
			
	var index = bookids.selectedIndex;
	var bkid = bookids.options[index].value;
	
	if (bkid < 0){
		 alert("No book selected");
		 return;
	}
	
	var answer = confirm("Are you sure you want to unassign this book?");
	if (!answer)
			return;

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	document.getElementById('result').style.display = 'block';

	url = url   + "cid=" + classid
                + "&bkid=" + bkid
                + "&sid=" + Math.random();

    xmlhttp_request(xmlhttp, url, id);

    //remove the selected item from the combobox
	if (bkid >= 0){
		 var x=document.getElementById("reqbooks");
         x.remove(x.selectedIndex);
	 }
}


function addBook(bookid, newused, covertype, bknew, bkused, askprice, desc, id, action) {
    xmlhttp = get_xmlHttp();
    var url;
    if (action == undefined){
        url = "scripts/helper/addbook.php?";
    } else if (action == 'update') {
       url = "scripts/helper/updatebook.php?";
    }

    // check if asked price is a number
    if ((askprice.replace(/(^\s*)/g, "")).length > 0 && askprice != parseFloat(askprice)){
        alert("Please enter a valid ask price or leave the field blank");
        return;
    }

	var bknew = parseFloat(bknew);
	var bkused = parseFloat(bkused);
	var buyback = bknew * 0.40;
	var optimalprice = ((buyback + bkused) / 2) * 1.1;
	
	var condition;
    (newused.checked)? condition = "New" : condition = "Used";

	var ctype;
    (covertype.checked)? ctype = "Hardcover" : ctype = "Paperback";

	if (askprice == "") {
		var answer = confirm("No price has been set. This book will be listed as 'In Use'");
		if (!answer)
			return;
        askprice = -1.00;
	} else if (newused.checked  && (parseFloat(askprice) > (bknew * 1.025).toFixed(2))) {
		alert("You can't sell this book for more than $"
				+ (bknew * 1.025).toFixed(2)
				+ "\n(2.5% more than the new price)");
		return;
	} else if (!newused.checked  && (parseFloat(askprice) > (optimalprice * 1.05).toFixed(2))) {
		alert("You can't sell this book for more than $"
				+ (optimalprice * 1.05).toFixed(2)
				+ "\n(5% more than the optimal price)");
		return;
	}

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	url = url   + "bid=" + bookid
                + "&newused=" + newused
                + "&askprice=" + askprice
		    	+ "&newused=" + condition
                + "&covertype=" + ctype
                + "&desc=" + fixurl(desc)
                + "&sid=" + Math.random();
	xmlhttp_request(xmlhttp, url, id);
	document.getElementById('foundbook').innerHTML = "";
}

function editUserBook(bookid, condition, covertype, askprice, comment, id) {
	xmlhttp = get_xmlHttp();
    var url = "scripts/helper/edituserbook.php?";

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	url = url   + "bid=" + bookid
                + "&cond=" + condition
			    + "&ctype=" + covertype
                + "&aprice=" + askprice
                + "&desc=" + fixurl(comment)
                + "&sid=" + Math.random();

	xmlhttp_request(xmlhttp, url, id);
}

function removeBook(bookids, id) {
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/removebook.php?";

	var answer = confirm("Remove the selected book(s)?");
	if (!answer)
		return;

	document.getElementById(id).innerHTML='<img src="images/loading.gif" />';
	if (bookids == parseInt(bookids)) { // a single book id was received, not an array
		url = url + "bid[]=" + bookids;
	} else {
		for (i = 0; i < bookids.length; i++) {
			if (bookids[i].checked == true) {
				url = url + "&bid[]=" + bookids[i].id;
			}
		}
	}

	url = url + "&sid=" + Math.random(); 
	xmlhttp_request(xmlhttp, url, id);
}

function findBooks(classids, bookids) {
	var url = "search.php?";
	
	//get class id from radio buttons
	for (i = 0; i < classids.length; i++) {
		if (classids[i].checked == true) {
			url = url + "&cid[]=" + classids[i].id;
		}
	}
	
	//get bookid from radio buttons
	for (i = 0; i < bookids.length; i++) {
		if (bookids[i].checked == true) {
			url = url + "&bkid=" + bookids[i].id;
		}
	}
	window.location.href = url;
}

function loadCourseNumbers(cname, id, elt) {
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/getclassnums.php?";

	var index = cname.selectedIndex;
	var classname = cname.options[index].value;

    if (elt == undefined) elt = "";

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	url = url   + "class=" + fixurl(classname)
                + "&elt="+elt
                + "&sid=" + Math.random();

	xmlhttp_request(xmlhttp, url, id);
}


function LoadSchools(state, id) {
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/loadSchools.php?";

	var index = state.selectedIndex;
	var st = state.options[index].value;

	document.getElementById(id).innerHTML = 'Loading...'; //'<img src="images/loading.gif" />';
	url = url   + "state=" + st
                + "&sid=" + Math.random();

	xmlhttp_request(xmlhttp, url, id);
}


function rankSeller(rank, seller, id) {
	xmlhttp = get_xmlHttp();
    var url = "scripts/helper/rankseller.php?";

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	for ( var i = 0; i < seller.length; i++) {
		if (seller[i].checked) {
			var sellerid = seller[i].value;
		}
	}

	url = url   + "&rank=" + rank
                + "&sellerid=" + sellerid
                + "&sid=" + Math.random();

	xmlhttp_request(xmlhttp, url, id);
}

function getClassBooks(cname, cnumber, id) {
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/getclassbooks.php?";

	var index = cname.selectedIndex;
	var classname = cname.options[index].text;

	var index = cnumber.selectedIndex;
	var classnumber = cnumber.options[index].text;

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	document.getElementById('result').style.display = 'none';
	url = url + "class=" + fixurl(classname) + "&number=" + classnumber
              + "&sid=" + Math.random();
	xmlhttp_request(xmlhttp, url, id);
}

function loadBookInfo(books, id){
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/bookinfo.php?";

	var index = books.selectedIndex;
	var bookid = books.options[index].value;
	
	if (bookid == -3){
		 alert("Please select an action");
		 return;
		}

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	document.getElementById('result').style.display = 'block';
	url = url + "bkid=" + bookid
              + "&sid=" + Math.random();

	xmlhttp_request(xmlhttp, url, id);
}

function saveBookInfo(cname, cnumber, title, authors, bknew, bkused_obj, picurl, id, a) {
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/savebookinfo.php?";

    if (title.length == 0 || authors.length == 0 || bknew.length == 0){
        alert("The form is incomplete. Please fill all required fields before saving");
        return;
    }

    //validate price
    if ((bknew.replace(/(^\s*)/g, "")).length > 0 && bknew != parseFloat(bknew)){
        alert("Please enter a valid price for the book");
        return;
    }

	var index = cname.selectedIndex;
	var classname = cname.options[index].text;

	var index = cnumber.selectedIndex;
	var classnumber = cnumber.options[index].text;

	var index = a.selectedIndex;
	var action = a.options[index].value;

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	url = url   + "class=" + fixurl(classname)
                + "&number=" + classnumber
                + "&title=" + title
                + "&authors=" + authors
		        + "&bknew=" + bknew
                + "&picurl=" + picurl
                + "&act=" + action
                + "&sid=" + Math.random(); 
    xmlhttp_request(xmlhttp, url, id);
    bkused_obj.value = (bknew * 0.75).toFixed(2);
}

function togglediv(divid) {
	if (document.getElementById(divid).style.display == 'none') {
		document.getElementById(divid).style.display = 'block';
	} else {
		document.getElementById(divid).style.display = 'none';
	}
}

function fixurl(val) {
	val = val.replace(/&/g, "%26");
	return val;
}

function imposeMaxLength(Object, MaxLen) {
	return (Object.value.length <= MaxLen);
}

var currdiv;

function Check(chk)
/**
DESCRIPTION: Checks/Unchecks all check boxes in the array chk

@param {Array} chk Array of checkboxes to be checked/unchecked
@returns none
@see editbooks.php
*/
{
  if(document.classform.checker.checked==true){
    for (i = 0; i < chk.length; i++)
        chk[i].checked = true ;
  }else{
    for (i = 0; i < chk.length; i++)
        chk[i].checked = false ;
  }
}

function toggleReqBooks(divid, books){
/**
DESCRIPTION: Toggles display of books required for a class displayed on the 'Classes' page.

@param {String} divid ID of the div whose display is to be toggled
@returns none
@see editclasses.php
*/

    // if the same radio button (class) is clicked and its div is opened, close it
    if ((currdiv != undefined) && (divid == currdiv) && (document.getElementById(divid).style.display == 'block')){
        document.getElementById(divid).style.display = 'none' ;
        return;
    }
	//  hide current div
	if (currdiv != undefined){
		document.getElementById(currdiv).style.display = 'none';
	}

	if(document.getElementById(divid).style.display == 'none'){
		document.getElementById(divid).style.display = 'block';
		currdiv = divid;

        //select the book whose value = the classid
        if (books.length > 1){   //doesn't just have the hidden value
            for (i = 0; i < books.length; i++){
                if (books[i].value == divid){
                    books[i].checked = true;
                }
            }
        }
	}else{
		document.getElementById(divid).style.display = 'none';
		currdiv = 'x';
	}
	currdiv = divid;
}

function clearReqBooks(allbooks) {
/**
DESCRIPTION: Clears the radio button array of all books listed on the 'Classes' page

@param {Array} allbooks Array containing book ids of all books listed on 'Classes' page
@returns none
@see editclasses.php
*/
        if (allbooks != undefined){
    	   for (i=0; i < allbooks.length; i++) {
            if (allbooks[i].checked){
                allbooks[i].checked = false;
                return;
    	     }
           }
        }
	}

function sendInvitation(email, from, id){
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/invitefriends.php?";

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	url = url + "email=" + email
              + "&from=" + from
              + "&sid=" + Math.random();

	xmlhttp_request(xmlhttp, url, id);
    }

function sendTestimonial(message, name, email, id){
    xmlhttp = get_xmlHttp();
    var url = "scripts/helper/sendtestimonial.php?";

	document.getElementById(id).innerHTML = '<img src="images/loading.gif" />';
	url = url + "msg=" + fixurl(message)
              + "&name=" + name
              + "&email=" + email
              + "&sid=" + Math.random();

	xmlhttp_request(xmlhttp, url, id);
    }
// JavaScript Document
