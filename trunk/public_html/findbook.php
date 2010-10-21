<?php
    include 'init_utils.php';

    $page_title = "CBE Find Book | " . ucwords($_SESSION['fullname']);
    $lightbox = true;
    include 'layout/startlayout.php';
    nav_menu($_SESSION['username'], 'search');
?>

<?

function HighlightKeys($string, $key, $color){
    $words = split(" " , $key);
    $finalstr;
    foreach ($words as $word){
        if (isset($finalstr)){
            $string = $finalstr;
        }
        while (stripos($string, $word) !== false){
          $index = stripos($string, $word);
          $finalstr .= substr($string, 0, $index);
          $string = substr($string, $index);
          $currfound = "<span style='background-color: " . $color . ";'>" . substr($string, 0, strlen($word)) . "</span>";
          $finalstr .= $currfound;
          $string = substr($string, strlen($word));
        }
        $finalstr .=  $string;
    }
    return $finalstr;
}


?>

<div class="page_info" >
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method='GET'>
  Search for: <input type='text' name='phrase'
  <? if (isset($_GET['phrase'])){ ?> value='<? echo $_GET['phrase']; ?>'<? } ?> /> in
  <select name='key'>
  <option value='title'
  <? if ($_GET['key'] == 'title'){ echo "selected"; } ?> >Title</option>
  <option value='author'
  <? if ($_GET['key'] == 'author'){ echo "selected"; } ?> >Author</option>
  </select>
  <input type='submit' name='submit' value='Search' />
</form>
<br />
<div class='hrline'></div>
<?
if (!isset($_GET['submit'])){?>
<div id='result' style="margin-right:50px; margin-left:10px; padding:5px; width:845px; background-color:#F5EFFB;">
<strong><font style='font-size:20px;'>Find a Book</font></strong><p>
Enter a portion of the book's title or author's name and find out what class that book belongs to, if it exists. <br/>This feature is helpful
especially when you have a book to add but don't know what class it is assigned to.
<br /><br /><b>Note:</b> Search is restricted to 30 results per query
</p>
<? } else { ?>
<div id='result' style="margin-right:50px; margin-left:10px; padding:5px; width:845px; background-color:#ffffff;">
<?
//show results
$sql = "SELECT book_id, title, author, picture_url FROM books" . $_SESSION['schoolID'] . " JOIN schools_classes using (book_id) WHERE " . $_GET['key'] . " LIKE '%" . str_replace(' ', '%', $_GET['phrase']) . "%' AND school_id = " . $_SESSION['schoolID'] . " LIMIT 30";
$time_start = microtime(true);
$result = mysql_query($sql);
$time_end = microtime(true);
$time = number_format($time_end - $time_start, 5);
echo "<strong><font style='font-size:20px;'><span style='float:left;'>Search Results</span></font></strong><span style='float:right;'>(" . mysql_num_rows($result) . " books found in " . $time . " secs)</span><br /><br/><p>";
if (mysql_num_rows($result) == 0){
    echo "<span style='color:red;'>Sorry, no books found</span>";
} else {
echo "<table width=100%' cellpadding='5px'>";
while ($row = mysql_fetch_array($result)){
        $bkimg = $row['picture_url'];
		if (empty($bkimg)){
			$bkimg = "images/noimage.png";
		}
    echo "<tr valign='top'>" .
        "<td width=65><a href='" . $bkimg . "' rel='lightbox[userbooks]' title='" . $row['title'] . "'><img src='" . $bkimg . "' width=65 height=70></a></td>" .
        "<td><table class='listbooks' width=100%><tr><td width=60px><b>Title:</b></td><td> <b>";
    echo ($_GET['key'] == 'title')?  HighlightKeys($row['title'], $_GET['phrase'], '#F3F781') :  $row['title'];
    echo "</b></td></tr>";
    echo "<tr><td><b>Author:</b></td><td> ";
    echo ($_GET['key'] == 'author')?  HighlightKeys($row['author'], $_GET['phrase'], '#D0F5A9') :  $row['author'];
    echo "</td></tr>" .
        "<tr><td><b>Classes:</b></td><td><i> ";

		 //get classes this book has been assigned to...the next line is an optimized version of the query below it
         $sql = "SELECT class_name, class_number FROM classes" . $_SESSION['schoolID'] . " JOIN schools_classes USING ( class_id ) WHERE book_id = " . $row[0] ;
		 $bkscs = mysql_query($sql);
		 $classcount = 0;

		 if (mysql_num_rows($bkscs)){
		 		while ($bkclass = mysql_fetch_array($bkscs)){
							$classcount++;
                            if ($classcount > 1){
                                echo ", ";
                            }
		 					echo $bkclass['class_name'] . " " . $bkclass['class_number'];

							 if ($classcount == 2){
							 		$diff = ($total-$classcount);
									if ($diff > 0){
											if ($diff == 1){
												 echo "and 1 other class";
											}else{
									 			 echo "and " . $diff . " other classes<br/>";
											}
									}
								  break;
							 }
				}
		 }
		 else {
		 		echo "Unassigned";
		 }
       echo "</i></td></tr></table>";
 }
echo "</table>";
}
} //end else
?>
</p></div></div>
<?php
    include 'layout/endlayout.php';
?>
