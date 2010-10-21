<?php require_once('init_utils.php');?>


<?php
$class=$_GET["class"];
$number=$_GET["number"];

    $bookid = $_GET['bid'];
		$condition = $_GET['cond'];
		$cover_type = $_GET['ctype'];
		$ask_price = $_GET['aprice'];
		$desc = $_GET['desc'];
		
  	$book = get_book($bookid);
		
		//some math
		$buyback = ((float)$book['bkstoreprice_new'])/2;
		$optimalprice = ($buyback + (float)$book['bkstoreprice_used'])/2;
			
		if ($book['title'] == ""){
			echo "<span id='notification'>Sorry, no book found</span>";
		}
		else {
				echo "<h3>" . $book['title'] . " (Editing...)</h3>";
				echo "<table class='editbook' cellpadding=5>";
		
		  	echo "<tr valign='top'>";
				$bkpic = $book['picture_url'];
				if (empty($bkpic)){
					 $bkpic = "images/noimage.png";
				}
		  	echo "<td width='10%'><img src='" . $bkpic . "' width='80px' height='90px'/></td>" .
           "<td width='30%'><b>Author(s):</b><br>" . $book['author'] .
					 "<br><br><table cellpadding=0 border=0>" . 
           "<tr><td><b>New:</b></td><td> $" . $book['bkstoreprice_new'] . "</td></tr>" . 
           "<tr><td><b>Used:</b><td> $" . $book['bkstoreprice_used'] . "</td></tr>" . 
					 "<tr><td><b>Buy Back:</b><td> $" . number_format($buyback, 2, '.', ',') .  "</td></tr>" . 
					 "<tr><td><b>Optimal:</b><td> $" . number_format($optimalprice, 2, '.', ',') .  "</td></tr>" . 
					 "</table><a href='help/?ref=faqs#optimalprice' target='_blank'>more information</a>..." .
			 		 "</td>";
  		  echo '<td width="30%"><b>Condition:</b><br><input type="radio" id="newused" name="newused" value="new"';
  			if ($condition == "New"){
  				 echo " checked";
  			}
  			echo '> New &nbsp;<input type="radio" id="newused" name="newused" value="used"';
  			if ($condition == "Used"){
  				 echo " checked";
  			} 
  			echo '> Used<br>';
  			echo '<br><b>Cover Type:</b><br><input type="radio" id="covertype" name="covertype" value="hardcover"';
  			if ($cover_type == 'Hardcover'){
  				 echo " checked";
  				}
  		  echo '/> Hardcover &nbsp;<input type="radio" id="covertype" name="covertype" value="paperback"';
  			if ($cover_type == 'Paperback'){
  				 echo " checked";
  				}
  			echo '/> Paperback<br>';
  		  echo "<br><br><br /><input name='button' type='button'onclick=\"addBook(" . $bookid . ", document.getElementById('newused'), document.getElementById('covertype'), '" . $book['bkstoreprice_new'] . "', '" . $book['bkstoreprice_used'] . "', document.getElementById('askprice').value, document.getElementById('bookcomments').value, 'listbooks', 'update')\" value='Save'/>";
  		  echo " <input name='button' type='button'onclick=\"document.getElementById('foundbook').innerHTML='';\" value='Cancel'/>";
  			echo "</td>";
  			echo "<td width='30%'><b>Ask Price:</b><br>$ <input id='askprice' type='text'";
				if ($ask_price != "(In Use)"){
					 echo "value='" . substr($ask_price, 1); //substr omits the $ sign
				}
				echo "' size='10'/><br>";
			echo "<b>Book Description:</b><br><textarea name='bookcomments' id='bookcomments' rows='4' onkeypress='return imposeMaxLength(this, 100);'>". str_replace("\'", "'", $desc) .
					 '</textarea><br>'.
					 '<font size="1">(Maximum characters: 100)</font>';
  		}	
?>