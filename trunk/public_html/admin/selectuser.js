// JavaScript Documentvar xmlhttp;


function stateChanged(id) {
	if (xmlhttp.readyState == 4) {
		document.getElementById(id).innerHTML = xmlhttp.responseText;
	}
}

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

//****************************************************************************/

function showUser(str, id)
{
    xmlhttp=get_xmlHttp();
    var url="getuser.php?q="+str+"&sid="+Math.random();
    xmlhttp_request(xmlhttp, url, id);
}

function memberInfo(str, id)
{
    xmlhttp=get_xmlHttp();
    var url="memberInfo.php?q="+str+"&sid="+Math.random();
    xmlhttp_request(xmlhttp, url, id);
}

function showFreeUser(str, id)
{
    xmlhttp=get_xmlHttp();
    var url="freeUserInfo.php?q="+str+"&sid="+Math.random();
    xmlhttp_request(xmlhttp, url, id);
}



function activateAccount(str, id)
{
    if(isempty(str)){ 
      alert("No name/id specified");
      return;
    }
    xmlhttp=get_xmlHttp();
    var url="actaccount.php?q="+str+"&sid="+Math.random();
    xmlhttp_request(xmlhttp, url, id);
}

function upgradeAccount(str, yrs, id)
{
    if(isempty(str)){
      alert("No name/id specified");
      return;
    }
    if (yrs.replace(/\s/g,"") == "" || parseInt(yrs) < 1){
      alert("Invalid years");
      return;
    }
    xmlhttp=get_xmlHttp();
    var url="upgradeaccount.php?q="+str+"&years="+yrs+"sid="+Math.random();
    xmlhttp_request(xmlhttp, url, id);
}

function makeMarketer(str, id)
{
    if(isempty(str)){
      alert("No name/id specified");
      return;
    }
    xmlhttp=get_xmlHttp();
    var url='makeMarketer.php?q='+str+"&sid="+Math.random();
    xmlhttp_request(xmlhttp, url, id);
}

function deleteAccount(str, id)
{
    if(isempty(str)){
      alert("No name/id specified");
      return;
    }
    xmlhttp=get_xmlHttp();
    var url='deleteaccount.php?q='+str+"&sid="+Math.random();
    xmlhttp_request(xmlhttp, url, id);
}

function togglediv(divid) {
	if (document.getElementById(divid).style.display == 'none') {
		document.getElementById(divid).style.display = 'block';
	} else {
		document.getElementById(divid).style.display = 'none';
	}
}

function isempty(str){
    if(str.replace(/\s/g,"") == ""){
      return true;
    }
    return false;
}