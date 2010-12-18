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

function loadInfo(data, id) {
    xmlhttp = get_xmlHttp();
    document.getElementById(id).innerHTML = '<img src="../images/loading.gif" />';
    var url = "coordinator.php?data="+data;  
    xmlhttp_request(xmlhttp, url, id);
}