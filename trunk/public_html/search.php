<?php
include 'init_utils.php';
    
$page_title = "Search Results";
$lightbox = true;
include 'layout/startlayout.php';
?>
<script type="text/javascript" src="scripts/classfunctions.js"></script>

<script LANGUAGE="JavaScript">
<!--
function confirmSubmit()
{
var agree=confirm("Contact the selected seller?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>

<?
//print the menu
nav_menu($_SESSION['username'], null);
?>

<div class="page_info">

<?php
$cid = $_GET['cid'][0];
$bookid = $_GET['bkid'];
echo "<h2><font color='#0000A0'>&nbsp;&nbsp;Search Results</font></h2>";

$sql = "SELECT class_name, class_number FROM classes" . $_SESSION['schoolID'] . " WHERE class_id = " . $cid;
$class = mysql_fetch_array(mysql_query($sql));
$book = get_book($bookid);
$count = 0;

$orderby = "";

//set sort order
    $sort = $_GET['sort'];
    $orderby = "ORDER BY";
    if ($sort == 'plh'){
    $orderby .= " ask_price ASC";
    }else if ($sort == 'phl'){
    $orderby .= " ask_price DESC";
    }else if ($sort == 'rlh'){
    $orderby .= " rank ASC";
    }else if ($sort == 'rhl'){
    $orderby .= " rank DESC";
    }else if ($sort == 'la'){
    $orderby .= " location ASC";
    }else if ($sort == 'ld'){
    $orderby .= " location DESC";
    }else if ($sort == 'nua'){
    $orderby .= " newused ASC";
    }else if ($sort == 'nud'){
    $orderby .= " newused DESC";
    }else if ($sort == 'cta'){
    $orderby .= " cover ASC";
    }else if ($sort == 'ctd'){
    $orderby .= " cover DESC";
    }else if ($sort == 'daa'){
    $orderby .= " date_added DESC";
    }else if ($sort == 'dad'){
    $orderby .= " date_added ASC";
    }else if ($sort == 'sca'){
    $orderby .= " school_name ASC";
    }else if ($sort == 'scd'){
    $orderby .= " school_name DESC";
    }else{
    $orderby .= " ask_price ASC";
    }


//set index for results page display
$max = 20;
$min = 0;

$ndx = $_GET['index'];
if (!empty($ndx)){
$max = $ndx * 20;
$min = $max - 20;
}

$vv = $_GET['viceversa'];
if($_GET['outersearch'] == "on") $outer = 1;
else $outer = 0;

// PRICE BOUNDS
$pricequery = "";
    $rng_min = $_GET['rng_min'];
    $rng_max = $_GET['rng_max'];

    if (!empty($rng_min) and !empty($rng_max)){
    $pricequery = " AND ask_price BETWEEN " . $rng_min . " AND " . $rng_max;
    }
    else if (!empty($rng_min) and empty($rng_max)){
    $pricequery = " AND ask_price >= " . $rng_min;
    }
    else if (empty($rng_min) and !empty($rng_max)){
    $pricequery = " AND ask_price <= " . $rng_max;
    }

if(!$outer or is_null($book['isbn'])) { // dont outer search if the isbn is null either
$outer=0; // if we arent outer searching, make sure the rest of the page dont think we are
/* this query dynamically creates a rownum inside the query, and looks for records between 2 rownums */
$sql = "select * FROM (SELECT @rownum := @rownum + 1 as rownum, t.member_id, username, location, ask_price, rank, newused, cover, date_added, comment, school_id " .
	"FROM members t INNER JOIN members_books a ON a.member_id = t.member_id, (SELECT @rownum := 0) r " .
	"WHERE school_id =" . $_SESSION['schoolID'] . " AND book_id =" . $bookid . " AND ask_price != -1.00 AND t.member_id != " . $_SESSION['userid'] . $pricequery . ") x " .
	"WHERE rownum BETWEEN " . $min . " AND " . $max . " " .  $orderby;
} else {
/* this is the outer search version of the same query, searching on isbn instead of book_id */
$sql = "SELECT * FROM (SELECT @rownum := @rownum + 1 as rownum, t.member_id, username, location, ask_price, rank, newused, cover, date_added, comment, school_id " .
    ", school_id sid, (select school_name from schools where school_id = sid) as school_name " .
	"FROM members t INNER JOIN members_books a ON a.member_id = t.member_id, (SELECT @rownum := 0) r WHERE ";

// the book_id is different in every school, so look up the isbns and do the query that way
$schoolnum = 1;
$first_school = 1;
$schools = mysql_query("select school_id from schools"); // get all the schools
// for each school
while($school = mysql_fetch_row($schools)) {
  // find the book in that school by isbn
  $sbidq = mysql_query("select book_id from books" . $schoolnum . " where ISBN like '" . $book['isbn'] . "'");
  // skip this school if the book doesn't exist here
  if(is_null($sbidq) or mysql_num_rows($sbidq) == 0) {
    $schoolnum++;
    continue;
  }
  // throw in an OR if needed
  if($first_school) $first_school = 0;
  else $sql .= " OR ";
  // include the school/book combo in the query
  $sbid = mysql_result($sbidq, 0, 0);
  $sql .= "(school_id = $schoolnum AND book_id = $sbid)";
  // incriment counter
  $schoolnum++;
}

$sql .= " AND ask_price != -1.00 AND t.member_id != " . $_SESSION['userid'] . $pricequery . ") x " .
        "WHERE rownum BETWEEN " . $min . " AND " . $max . " " .  $orderby;
}

$bookowners = mysql_query($sql);

if (mysql_num_rows($bookowners) == 0){
echo "<center><font color='red'>Sorry, no sellers have been found.</font> <br/><br/><font color='green'>CollegeBookEvolution.com is still gaining popularity, to increase the chance of <br/> finding a match, encourage you friends and classmates to join the eVOLUTION.</font><br/><br/>Reminder, keep your textbooks, list them on CollegeBookEvolution.com :<br/><br/><img src=http://www.collegebookevolution.com/about/compare888.jpg alt='2010 Textbook Price Comparsion'/></center>
";
} else {

echo "<table border='0' cellpadding='3px'>";

//math
$buyback = ((float)$book['bkstoreprice_new']) * 0.40;
$optimal = (($buyback + (float)($book['bkstoreprice_used']))/2) * 1.1;

$bkimg = $book['picture_url'];
if ($bkimg == ""){
	 $bkimg = "images/noimage.png";
	 }
//class & book information
echo "<tr valign='top'><td width='600px'>" .
	"<table cellpadding='10px'>" .
	"<tr><td><a href='" . $bkimg . "' rel='lightbox' title='" . $book['title'] . "'><img src='" . $bkimg . "' width='80' height='90' alt='required book'></a></td><td valign='top'>" .
	"<table cellpadding=0 border=0>" . 
	"<tr valign='top'><td width='80px'><b>Book:</b></td><td width=''> " . $book['title'] . "</td></tr>" .
	"<tr valign='top'><td><b>Author:</b></td><td> " . $book['author'] . "</td></tr>" .
	"<tr valign='top'><td><b>New:</b></td><td> $" . $book['bkstoreprice_new'] . "</td></tr>" .
	"<tr valign='top'><td><b>Used:</b></td><td> $" . $book['bkstoreprice_used'] . "</td></tr>" .
	"<tr valign='top'><td><b>Buy Back:  &nbsp; </b></td><td> $" . number_format($buyback, 2, '.', ',') .
    "<tr valign='top'><td><b>Optimal:  &nbsp; </b></td><td> $" . number_format($optimal, 2, '.', ',') .
	" <a href='help/?ref=faqs#optimalprice' target='_blank'>[?]</a></td></tr></table>" .
	"</td></tr></table>";

$tt = "SELECT count(*) FROM members_books WHERE book_id =" . $bookid . " AND member_id != " . $_SESSION['userid'];
$total = (int)mysql_result(mysql_query($tt), 0, 0);

// CONTACT SELLER
if (isset($_POST['member_sel'])) {
$selected_seller = $_POST['selected_member'];
$emailres = sendBookRequestEmail($selected_seller, $class['class_name'] . " " . $class['class_number'], $bookid, $book['author'], $book['title']);
}

echo "<td style='vertical-align: bottom;' >";

//SORTING
echo "<table><tr><td width='600px' align='right'>";
echo "<form name='sortform' method='get' action='search.php'>";
echo "<input type='hidden' name='cid[]' value='" . $cid . "' />";
echo "<input type='hidden' name='bkid' value='" . $bookid . "' />";

    echo "<input type='hidden' name='sort' value='" . !$sort . "' />";
    echo "<input type='hidden' name='rng_min' value='" . $rng_min . "' />";
    echo "<input type='hidden' name='rng_max' value='" . $rng_max . "' />";
    echo "<input type='hidden' name='viceversa' value='" . $vv . "' />";
    echo "<input type='hidden' name='outersearch' value='" . $_GET['outersearch'] . "' />";

    echo "Sort: <select name='sort' size=1 onChange='sortform.submit();'>";
    echo "<option value='plh' ";
    if ($sort == 'plh')echo "SELECTED";
    echo ">Price: Lowest To Highest</option>";
    echo "<option value='phl' ";
    if ($sort == 'phl')echo "SELECTED";
    echo ">Price: Highest To Lowest</option>";
    echo "<option value='rlh'";
    if ($sort == 'rlh')echo "SELECTED";
    echo ">Likes: Lowest To Highest</option>";
    echo "<option value='rhl'";
    if ($sort == 'rhl')echo "SELECTED";
    echo ">Likes: Highest To Lowest</option>";
    echo "<option value='la'";
    if ($sort == 'la')echo "SELECTED";
    echo ">Location: Ascending</option>";
    echo "<option value='ld'";
    if ($sort == 'ld')echo "SELECTED";
    echo ">Location: Descending</option>";
    echo "<option value='nua'";
    if ($sort == 'nua')echo "SELECTED";
    echo ">Condition: Ascending</option>";
    echo "<option value='nud'";
    if ($sort == 'nud')echo "SELECTED";
    echo ">Condition: Decending</option>";
    echo "<option value='cta'";
    if ($sort == 'cta')echo "SELECTED";
    echo ">Cover Type: Ascending</option>";
    echo "<option value='ctd'";
    if ($sort == 'ctd')echo "SELECTED";
    echo ">Cover Type: Decending</option>";
    echo "<option value='daa'";
    if ($sort == 'daa')echo "SELECTED";
    echo ">Posted: Recent Date</option>";
    echo "<option value='dad'";
    if ($sort == 'dad')echo "SELECTED";
    echo ">Posted: Distant Date</option>";
    if($outer) {
      echo "<option value='sca'";
      if ($sort == 'sca')echo "SELECTED";
      echo ">School: Ascending</option>";
      echo "<option value='scd'";
      if ($sort == 'scd')echo "SELECTED";
      echo ">School: Descending</option>";
    }
    echo "</select></form>";


    echo "<form id='prsearch' method='get' action='search.php'>";
    //echo "<br>Price range:";
    echo "<input type='hidden' name='cid[]' value='" . $cid . "' />";
    echo "<input type='hidden' name='bkid' value='" . $bookid . "' />";
    echo "<input type='hidden' name='sort' value='" . $sort . "' />";
    //echo "$ <input type='text' name='rng_min' size='3' value='" . $rng_min . "'/> to $ <input type='text' name='rng_max' size='3' value='" . $rng_max . "'/> ";
    //echo "<input type='submit' value='Go' />";

//vice versa (or barter trade) check box, onclick, submit the form
echo "<br><input id='viceversa' name='viceversa'onClick='submit();' type='checkbox'";
if ($_GET['viceversa'] == 'on') echo "checked";
echo "/>Barter Trade <a href='help/?ref=faqs#bartertrade' target='_blank'>[?]</a>";

//outer search (other schools) check box, onclick, reveal other school div
echo "<br><input type='checkbox' id='outersearch' name='outersearch' onClick='submit();'";
if ($_GET['outersearch'] == 'on') echo "checked";
echo "/>Outer Search <a href='help/?ref=faqs#outersearch' target='_blank'>[?]</a>";

echo "</td></tr></table>";


echo "</form></table><p>";
echo "<div class='hrline'></div>";
print "<form name='contact' method='post' action='{$_SERVER['php_SELF']}' onsubmit='return confirmSubmit()' >";
echo "<table class='resultsTable' cellpadding='5px' width='100%'><th></th>
     <th align='left'>Seller</th>";
if($outer) echo "<th align='left'>School</th>";
echo "<th align='left'>Location</th>
     <th align='left'>Condition</th>
     <th align='left'>Cover Type</th>
     <th align='left'>Date Added</th>
     <th align='left'># of Likes</th>
     <th align='left'>Ask Price</th>";


// NOTIFICATIONS
echo "<div id='rankresult' align='center'>";
if (isset($emailres)){
  echo (substr($emailres, 0, 5) == "Sorry")? "<span id='error'>" : "<span id='notification'>";
  echo $emailres . "<br /><br />";
}
echo "</span></div>";

echo "<input type='hidden' name='selected_member' value='-1'>";
while ($row = mysql_fetch_array($bookowners)){
      $count++;
      if ($_GET['viceversa'] == "on"){
        $trade = viceVersaSearch($_SESSION['userid'], $row['member_id'], $outer);
      }
      echo "<tr ";
      if (($count % 2) == 0){
        echo "class='altrow'";
      }
      echo "><td><input type='radio' name='selected_member' value='" . $row['member_id'];

      if (sizeof($trade) > 0){
      	echo ":" . get_title_strings($trade); //can trade
      }else{
      	echo ":-1"; //can't trade
      }
      	echo "' onclick='this.form.contactbtn.disabled=!this.checked; this.form.like.disabled=!this.checked; this.form.dislike.disabled=!this.checked;' /></td>" .
      		"<td>";

      if (sizeof($trade) > 0){ // if user has a book the seller wants, a 'trade' icon shows up displaying the books both parties could trade
        echo "<span style='color:#339966;'><b>" . ucfirst($row['username']) . "</b></span> <img align=absmiddle src='images/needed.png' title='needs: " . get_title_strings($trade) . "'/>";
      } else if ($_SESSION['schoolID'] != $row['school_id']) { // display outer search results in orange
        echo "<span style='color:#cc6600;'><b>" . ucfirst($row['username']) . "</b></span>";
      } else {
        echo ucfirst($row['username']);
      }
      if (!empty($row['comment']))
        echo " <img align=absmiddle src='images/descr.png' alt='description' title='" . $row['comment'] . "' />";
        echo "</td>";
        if($outer) echo "<td>" . $row['school_name'] . "</td>";
        echo	"<td>" . $row['location'] . "</td>" .
        		"<td>" . $row['newused'] . "</td>" .
        		"<td>" . $row['cover'] . "</td>" .
        		"<td>" . format_date($row['date_added']) . "</td>" .
        		"<td>" . $row['rank'] . " <img src='images/likes.png' alt='likes' /> </td>" .
        		"<td><b>$" . $row['ask_price'] . "</b></td></tr>";
}
echo "</table>";

// PAGINATION
$indices = ceil($total/20);
if ($indices > 1){
    if ($indices > 10){
    $indices = 10;
    }
    echo "<br><br>Go to page: ";
    for ($i = 1; $i <= $indices; $i++){
        echo "<a href='search.php?cid[]=" . $cid . "&sort=" . $sort . "&index=" . $i . "&rng_min=" . $rng_min . "&rng_max=" . $rng_max . "'>";
        if ($i == $ndx) {
        echo "<b>" . $i . "</b>";
        } else {
        echo $i;
        }
        echo "</a>";
    }
}
echo "<br><br>";
echo "&nbsp;&nbsp;<input type='submit' name='member_sel' id='contactbtn' value='Contact Seller' disabled /> ";

    echo "<input type='button' name='like' value='Like' disabled onClick='rankSeller(1, document.contact.selected_member, \"rankresult\")'/> <input type='button' name='dislike' value='Dislike' disabled onClick='rankSeller(0, document.contact.selected_member, \"rankresult\")'/>";

echo "</form></td></tr>";
echo "</table></p>";

}
?></div>

<?php
include 'layout/endlayout.php';
?>
