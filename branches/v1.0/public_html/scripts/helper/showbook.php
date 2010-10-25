<?php require_once('init_utils.php');?>


<?php
$class=$_GET["class"];
$number=$_GET["number"];

$cid = get_classid($class, $number);
if (isset($cid)){
$bookids = get_class_books($_SESSION['userid'], $cid);
//$sql = "SELECT class_name, class_number FROM classes WHERE class_id = " . $cid;
//$book = get_book($bookid);
echo "<ul>";
if (mysql_num_rows($bookids) == 0){
echo "<span style='margin:40px;'>Sorry, no books found</span><br/>";
}
else {
 echo "<h3>Select a book:</h3>";
		while ($book = mysql_fetch_array($bookids)){
					echo '<li><a href="javascript:;" onclick="togglediv(\'bk'. $book['book_id'] . '\');">' . $book['title'] . '</a></li>';
					echo '<div id="bk' . $book['book_id'] . '" style="display: none;" >';

    		//some math
    		$buyback = ((float)$book['bkstoreprice_new']) * 0.40;
    		$optimalprice = (($buyback + (float)$book['bkstoreprice_used'])/2) * 1.1;

            /*
    		if (!isset($book)){
    			echo "<span id='notification'>Sorry, no book found</span>";
					break;
    		} */
    		//else {
                echo "<h3>" . $book['title'] . "</h3>";
                echo "<table class='classbook'>";

                echo "<tr valign='top'>";
                $bkpic = $book['picture_url'];
                if (empty($bkpic)){
                $bkpic = "images/noimage.png";
                }
                echo  "<td width='10%'><img src='" . $bkpic . "' width='80px' height='90px'/></td>" .
                      "<td width='30%'><b>Author(s):</b><br>" . $book['author'] .
                      "<br><br><table cellpadding=0 border=0>" .
                      "<tr><td><b>New:</b></td><td> $" . $book['bkstoreprice_new'] . "</td></tr>" .
                      "<tr><td><b>Used:</b><td> $" . $book['bkstoreprice_used'] . "</td></tr>" .
                      "<tr><td><b>Buy Back:</b><td> $" . number_format($buyback, 2, '.', ',') .  "</td></tr>" .
                      "<tr><td><b>Optimal:</b><td> $" . number_format($optimalprice, 2, '.', ',') .  "</td></tr>" .
                      "</table><a href='help/?ref=faqs#optimalprice' target='_blank'>more information</a>..." .
                      "</td>";
                echo '<td width="30%"><b>Condition:</b><br><input type="radio" id="newused_' . $book['book_id'] . '" name="newused_' . $book['book_id'] . '" value="new"> New &nbsp;<input type="radio" id="newused_' . $book['book_id'] . '" name="newused_' . $book['book_id'] . '" value="used" checked> Used<br>';
                echo '<br><b>Cover Type:</b><br><input type="radio" id="covertype_' . $book['book_id'] . '" name="covertype_' . $book['book_id'] . '" value="hardcover" checked /> Hardcover &nbsp;<input type="radio" id="covertype_' . $book['book_id'] . '" name="covertype_' . $book['book_id'] . '" value="paperback"> Paperback<br>';
                echo "<br><br><input name='button' type='button'onclick=\"addBook(" . $book['book_id'] . ", document.getElementById('newused_" . $book['book_id'] . "'), document.getElementById('covertype_" . $book['book_id'] . "'), '" . $book['bkstoreprice_new'] . "', '" . $book['bkstoreprice_used'] . "', document.getElementById('askprice_" . $book['book_id'] . "').value, document.getElementById('bookcomments_" . $book['book_id'] . "').value, 'listbooks')\" value='Add Book'/>";
                echo " <input name='button' type='button'onclick=\"document.getElementById('foundbook').innerHTML='';\" value='Hide'/>";
                echo "</td>";
                echo "<td width='30%'><b>Ask Price:</b><br>$ <input id='askprice_" . $book['book_id'] . "' type='text' size='10'/><br>";
                echo "<b>Book Description:</b><br><textarea name='bookcomments' id='bookcomments_" . $book['book_id'] . "' onkeypress='return imposeMaxLength(this, 100);'>". $desc .
                      '</textarea><br>'.
                      '<font size="1">(Maximum characters: 100)</font></td></tr></table>';
    		//}
				echo "</div>";
			} // while
			echo "</ul>";
	}
echo "<br/><span id='subscript' style='margin-left:40px;'>Don't see the book you're looking for? <a href='http://www.collegebookevolution.com/help/?ref=suggest' target='_blank'>Suggest it</a> so we can add it.</span>";
}
?>