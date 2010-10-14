// JavaScript Documentvar xmlhttp;
item_images = null;
objImage = new Image();
var current_slide = 0;
var notification_timer;
var tm;
var currBrand;
var currCategory;
var allthumbs = null;

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

function togglediv(divid) {
    $('#'+divid).slideToggle();
}

function preloadImage(img, x){
  i = new Image()
  i.src = img;
  allthumbs[x-1] = i;
}

function loadThumbs(brand, category, id){
    allthumbs = new Array(); //reset the thumbnails array
    hideItemInfo();
    document.images["im"].src = null;
    document.getElementById(id).innerHTML = "<img src='images/loadbar.gif' />";
    document.getElementById('bigImage').style.display = "none";
    xmlhttp = get_xmlHttp();
    var url = "helper/loadthumbs.php?bid=" + brand + "&cid=" + category;
    url = url + "&sid=" + Math.random();
    xmlhttp_request(xmlhttp, url, id);
    currCategory = category;
}

function download(img_src){
    //preload image file
    objImage.src = item_images[img_src];
}

function zoomThumb(path, thumbid, count, clickable){   
    document.getElementById("bigImage").onclick = function ()
    {
      if (clickable){
        $('#bigImage').fadeOut();
        hideItemInfo();
        document.getElementById('item_desc').innerHTML = '';
      }else{
        //return false;
        url = (document.location.href).toString();
        nurl = url.substring(0, url.lastIndexOf("&"));
        nurl = nurl.substring(0, nurl.lastIndexOf("&"));
        window.location=nurl;
      }
    }
    urlvars = 'bid='+currBrand+'&cid='+currCategory+'&tid='+thumbid+'&cnt='+count;
    sharestuff = '<br /><br /><img src="images/expand.gif"/> <a href="javascript:void(0);" onClick="togglediv(\'share\');">Share</a>'+
    '<div id="share" style="position: relative; border-top: 1px solid #E9E9E9; padding-top: 5px; display: none;">';//+
    //'<a name="fb_share" type="button_count" target="_blank" href="http://www.facebook.com/sharer.php?u=www.finallymade.com/shop/?' + urlvars + '">'+
    //'<img style="vertical-align: middle;" src="images/facebook.jpg" title="Share link on Facebook"/></a>';
    //sharestuff += ' <a href="javascript:void(0);" onClick="mailpage(\'www.finallymade.com/shop/?'+urlvars.replace("amp;", "")+'\');"><img style="vertical-align: middle;" src="images/mail.png" title="Share link via email"/></a>'
     sharestuff += '  URL: www.finallymade.com/shop/?'+urlvars+"</div>";
     document.getElementById('item_desc').innerHTML += sharestuff;
    // if the zoomed thumb is clickable, set cursor to pointer, else set to default
    document.getElementById("bigImage").style.cursor = "pointer";

    item_images = new Array();
    current_slide = 0;
    document.images["im"].src = null;

    if (count == 1){
        document.getElementById("minithumbs").style.visibility = "hidden";
    }else{
       document.getElementById("minithumbs").style.visibility  = "visible";
    }


    for (var i = 0; i < count; i++){
        item_images[i] = path + "/" + thumbid + "/" + (i+1) + ".jpg";
    }

    if (allthumbs.length> 0){
       document.images["im"].src = allthumbs[thumbid-1].src;

    }else{
       document.images["im"].src = item_images[0];
    }
    $("#bigImage").fadeIn();
}


function loadItemDesc(name, desc){
     // set item description
    document.getElementById('item_desc').innerHTML = "<h2>" + name + "</h2>" + desc;
}

/*  Populates the right side bar with the selected items price and sizes
    information and provides a button for adding the item to the shopping cart

    @params itemid id of the selected item
    @params price price of the selected item
    @params origprice original price of the selected item
    @params instock quantity of the item in stock. 0 if none in stock
    @params store_only true if the item is not sold online
    @params id div id where results should be displayed
    @returns void
*/
function loadItemPrice(itemid, price, origprice, instock, sizes, store_only, id){
  xmlhttp = get_xmlHttp();
  var valqty = new Array();
  var allsizes = new Array();
  var i;
  price = price.toFixed(2);
  origprice = origprice.toFixed(2);

  var output = "<span class='item_price' >$" + price + "</span>";

  if (origprice != "0.00"){
  output += "<br/><img src='images/sale.jpg' />" +
         "<span class='old_price'>$" + origprice + "</span>";
  }

  if (store_only){
    output += "<br /><br /><span class='badnews'>Not Sold Online</span>";
  } else if (!instock){
      output += "<br /><br /><span class='badnews'>Sold Out</span>";
  }else {
    //split sizes
    allsizes = sizes.split(';');

    if (allsizes[0] == "--"){
       output += "<p><input type='hidden' id='size' value='--' /></p>";
    }else{
        output += "<p><select id='size'><option value='-1'>Select Size</option>";
        for (i = 0; i < allsizes.length; i++){
            valqty = allsizes[i].split(':');
            output += "<option value='" + valqty[0] + "'>" + valqty[0] + "</option>";
        }
        output += "</select></p>";
    }

    output += "<input class='btn' type='button' onmouseover='this.className=\"btn btnhov\"' " +
       "onmouseout='this.className=\"btn\"' value='Add To Cart' " +
       "onClick='addToCart(" + itemid +  ", " + price + ", \"itmcnt\");' />";
  }
  document.getElementById(id).innerHTML = output;
  document.getElementById('minithumbs').innerHTML = "";
  var url = "helper/minithumbs.php?id=" + itemid;
  url += "&sid=" + Math.random();
  xmlhttp_request(xmlhttp, url, "minithumbs");
}


function hideItemInfo(){
    document.getElementById('rsidebar_content').style.display = 'none';
}

function showItemInfo(){
    document.getElementById('rsidebar_content').style.display = 'block';
}

/* ======= OPACITY ===========*/
function imageFadeOut(img)
{
    img.opacity = 100;
    setOpacity(img.name, -10, 100);
}

function imageFadeIn(img)
{
    img.opacity = 0;
    setOpacity(img.name, 10, 10);
}

function browserIE(){
    var browser=navigator.appName;
    var b_version=navigator.appVersion;
    var version=parseFloat(b_version);
    return browser=="Microsoft Internet Explorer";
}

function setOpacity (imgName, step, delay)
{
  var img = document.images[imgName];
  img.opacity += step;
  if (browserIE()){
    // internet explorer opacity
    img.style.filter = 'alpha(opacity = ' + img.opacity + ')';
    if (step > 0 && img.opacity < 100 || step < 0 && img.opacity > 0)
    setTimeout('setOpacity("' + img.name + '",' + step + ', ' + delay + ')', delay);
  } else {
    // all other browsers
    img.style.opacity = img.opacity/100;
    if (step > 0 && img.opacity < 100 || step < 0 && img.opacity > 0)
    setTimeout('setOpacity("' + img.name + '",' + step + ', ' + delay + ')', delay);
  }
}
/* ===== end ============ */


function loadBrandInfo(id, brand, url, comment){
    if (currBrand == id){
      //return;
    }
    document.images["im"].src = "images/loadbar.gif";
    document.images["im"].src = "images/brands/logos/" + brand + ".jpg";
    if (url != ""){
        document.getElementById("bigImage").onclick = function()
        {
            window.open("http://" + url);
        }
    } else {
        document.getElementById("bigImage").onclick = null;
    }
    var fg=document.getElementById("im");
    var bg = document.getElementById("ads");
    bg.style.backgroundImage = "none";
    fg.style.backgroundImage = "none";
    window.clearTimeout(fg.timer);
    window.clearTimeout(tm);
    tm = null;
    hideItemInfo();
    document.getElementById('bigImage').style.display = "block";
    imageFadeIn(fg);
    document.getElementById('item_desc').innerHTML = comment + "<br/>" +
            "<a href='http://" + url + "' target='_blank'>" + url + "</a>";
}

function addToCart(item_id, price, divid){
    cbox = document.getElementById('size');
    var size;
    if (cbox.value == "--"){
        size = "--";
    }else{
        var index = cbox.selectedIndex;
    	size = cbox.options[index].value;
    }

    if (size == -1){
        notify("<span style='color:red;'>No size selected</span>");
        return;
    }
    document.getElementById(divid).innerHTML = "<img src='images/loadbar.gif' />";

    xmlhttp = get_xmlHttp();
    var url = "helper/addtocart.php?id=" + item_id + "&size=" + size +
              "&price=" + price + "&sid=" + Math.random();

    xmlhttp.onreadystatechange = function(){ stateChanged_eval(divid); }
    xmlhttp.open("GET", url, true);
    xmlhttp.send(null);
}

function stateChanged_eval(id) {
    /* res[0] is a javascript function to be evaluated
       res[1] is text to be displayed   */
	if (xmlhttp.readyState == 4) {
        var res = xmlhttp.responseText.split("|");
		document.getElementById(id).innerHTML = res[1];
        eval(res[0]);
	}
}

function showUpdating(msg){
  if (msg == null){  // use default
    msg = "Updating cart. Please wait...";
  }
  document.getElementById("notification").innerHTML = msg;
  $("#notification").fadeIn();
  clearTimeout(notification_timer);
}

function promptSaveChanges(){
  updatePayPal(undefined);
  notify("Cart updated");
}

function notify(msg){
    document.getElementById("notification").innerHTML = msg;
    $("#notification").fadeIn();
    clearTimeout(notification_timer);
    notification_timer = setTimeout('clearNotification()', 1000);
}

function clearNotification(){
    //document.getElementById('notification').innerHTML = " ";
    $("#notification").fadeOut();
    clearTimeout(notification_timer);
    document.getElementById('notification').innerHTML = " ";
}

function incQty(itemid, price, size, qty, ttqty, ttprice, divid){
    document.getElementById("incqty"+divid).style.visibility = "hidden";
    document.getElementById("decqty"+divid).style.visibility = "hidden";
    document.getElementById("qty"+divid).innerHTML = qty+1;
    document.getElementById("ttl"+divid).innerHTML = ((qty+1) * price).toFixed(2);
    document.getElementById("itmcnt").innerHTML = "<h1 class='item_price'>$" +
    (ttprice + price).toFixed(2) + "</h1>(" + (ttqty + 1) + " items | <a style='cursor: pointer;' onClick='emptyCart();'>empty</a>)";

    xmlhttp = get_xmlHttp();
    var url = "helper/updatecart.php?action=inc&id=" + itemid + "&qty=" + (qty+1) + "&size=" + size + "&price=" + price;
    url = url + "&sid=" + Math.random();
    xmlhttp_request(xmlhttp, url, "thumbs_display");
}

function decQty(itemid, price, size, qty, ttqty, ttprice, divid){
    document.getElementById("decqty"+divid).style.visibility = "hidden";
    document.getElementById("incqty"+divid).style.visibility = "hidden";
    document.getElementById("qty"+divid).innerHTML = qty-1;
    document.getElementById("ttl"+divid).innerHTML = ((qty-1) * price).toFixed(2);
    document.getElementById("itmcnt").innerHTML = "<h1 class='item_price'>$" +
    (ttprice - price).toFixed(2) + "</h1>(" + (ttqty - 1) + " items | <a style='cursor: pointer;' onClick='emptyCart();'>empty</a>)";

    xmlhttp = get_xmlHttp();
    var url = "helper/updatecart.php?action=dec&id=" + itemid + "&qty=" + (qty-1) + "&size=" + size + "&price=" + price;
    url = url + "&sid=" + Math.random();
    xmlhttp_request(xmlhttp, url, "thumbs_display");
}

function delItem(itemid, price, size, qty, ttqty, ttprice){
    document.getElementById("thumbs_display").innerHTML = "<img src='images/loadbar.gif' />";
    var str = "<h1 class='item_price'>$" +
    (ttprice - (qty*price)).toFixed(2) + "</h1>(" + (ttqty - qty) + " items";
    // if there are more items, show empty button
    if ((ttqty - qty) > 0){
      str += " | <a style='cursor: pointer;' onClick='emptyCart();'>empty</a>";
    }
    str += ")";

    document.getElementById("itmcnt").innerHTML = str;
    xmlhttp = get_xmlHttp();
    var url = "helper/updatecart.php?action=del&id=" + itemid + "&qty=" + (qty-1) + "&size=" + size + "&price=" + price;
    url = url + "&sid=" + Math.random();
    xmlhttp_request(xmlhttp, url, "thumbs_display");
}

function emptyCart(){
    var answer = confirm("Remove all items from the shopping cart?");
    if (answer){
      document.getElementById("thumbs_display").innerHTML = "<img src='images/loadbar.gif' />";
      document.getElementById("itmcnt").innerHTML = "<h1 class='item_price'>$0.00</h1>(0 items)";

      xmlhttp = get_xmlHttp();
      var url = "helper/updatecart.php?action=empty";
      url = url + "&sid=" + Math.random();
      xmlhttp_request(xmlhttp, url, "thumbs_display");
    }
}

function updatePayPal(shipping){
    code = document.getElementById("promocode").value;
    shipcost = 8;

    xmlhttp = get_xmlHttp();

    // disable the checkout button until changes have been applied
    document.getElementById("paypal_info").innerHTML =
    "<input class='btn' type='button' style='color:#B9B9B9;' value='Checkout' disabled />";

    var url = "helper/paypal.php?promocode=" + code;
    if (shipping != undefined){
        if (shipping == "int"){
            shipcost = 20;
        }
        url = url + "&shipping="+shipcost;
    }

    url = url + "&sid=" + Math.random();
    xmlhttp_request(xmlhttp, url, "paypal_info");
}

/* IMAGE FADE
   Script: http://www.cryer.co.uk/resources/javascript/script12slideshow.htm
*/
var FadeDurationMS=1000;
function SetOpacity(object,opacityPct)
{
  // IE.
  object.style.filter = 'alpha(opacity=' + opacityPct + ')';
  // Old mozilla and firefox
  object.style.MozOpacity = opacityPct/100;
  // Everything else.
  object.style.opacity = opacityPct/100;
}
function ChangeOpacity(id,msDuration,msStart,fromO,toO)
{
  var element=document.getElementById(id);
  var msNow = (new Date()).getTime();
  var opacity = fromO + (toO - fromO) * (msNow - msStart) / msDuration;
  if (opacity>=100)
  {
    SetOpacity(element,100);
    element.timer = undefined;
  }
  else if (opacity<=0)
  {
    SetOpacity(element,0);
    element.timer = undefined;
  }
  else
  {
    SetOpacity(element,opacity);
    element.timer = window.setTimeout("ChangeOpacity('" + id + "'," + msDuration + "," + msStart + "," + fromO + "," + toO + ")",10);
  }
}
function FadeInImage(foregroundID,newImage,backgroundID)
{
  var foreground=document.getElementById(foregroundID);
  if (foreground.timer) window.clearTimeout(foreground.timer);
  if (backgroundID)
  {
    var background=document.getElementById(backgroundID);
    if (background)
    {
      if (background.src)
      {
        foreground.src = background.src;
        SetOpacity(foreground,100);
      }
      background.src = newImage;
      background.style.backgroundImage = 'url(' + newImage + ')';
      background.style.backgroundRepeat = 'no-repeat';
      var startMS = (new Date()).getTime();
      foreground.timer = window.setTimeout("ChangeOpacity('" + foregroundID + "'," + FadeDurationMS + "," + startMS + ",100,0)",10);
    }
  } else {
    foreground.src = newImage;
  }
}
var slideCache = new Array();
function RunSlideShow(pictureID,backgroundID,imageFiles,displaySecs)
{
    if (currBrand == undefined) { // no brand has been selected
    var imageSeparator = imageFiles.indexOf(";");
    var nextImage = imageFiles.substring(0,imageSeparator);
    FadeInImage(pictureID,nextImage,backgroundID);
    var futureImages = imageFiles.substring(imageSeparator+1,imageFiles.length)+ ';' + nextImage;
    tm = setTimeout("RunSlideShow('"+pictureID+"','"+backgroundID+"','"+futureImages+"',"+displaySecs+")",displaySecs*1000);
    // Cache the next image to improve performance.
    imageSeparator = futureImages.indexOf(";");
    nextImage = futureImages.substring(0,imageSeparator);
    if (slideCache[nextImage] == null)
    {
      slideCache[nextImage] = new Image;
      slideCache[nextImage].src = nextImage;
    }
  } else {
    tm = null;
  }
}

function selectBrand(id){
  //hide shadow
  document.getElementById("shadow").style.display = "none";
  currCategory = 0;
  if (id != currBrand){
    if (currBrand != undefined){
      document.getElementById("brand_" + currBrand).style.fontWeight = "normal";
      document.getElementById(currBrand).style.display = "none";
    }
    document.getElementById("brand_" + id).style.fontWeight = "bold";
    currBrand = id;


  }
}

function getReturnUrl(){
  res = "";
  if (currBrand > 0){
    res = "bid=" + currBrand + "&cid=" + currCategory;
  }
  return res;

}

function mailpage(urlvars)
{
  mail_str = "mailto:?subject=Check out this FinallyMade merchandise.";
  mail_str += "&body=What's good?%0aCheck out this item I found at FinallyMade (www.finallymade.com). Thought you might be interested.";
  mail_str += "%0a%0a ";
  mail_str += urlvars.replace(/&/g, "%26");
  location.href = mail_str;
}
