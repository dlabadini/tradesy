<?php

/* Navigation Menu
Input:  $loginid - Id used to log into account. Displayed next to My Account
        $page - Current page the nav menu is being displayed on.
                Name of page will be formatted differently.
Description:
        When displaying the menu items, 2 main things are checked
            - if menu item = $page, give menu item a blue color
            - if user with $loginid's account type is a markter,
                show additional menu items
*/
function nav_menu($blahblah, $page){
    // Display general menu everyone sees
    echo '<div class="nav"><br>' .
  		 '<div style="float:left; height:30px; margin-left:10px; background-color:white; border-style:solid;  border-color:#0099CC; border-width:thin; border-bottom-style:none;"><span style="float:left; margin-left:10px; margin-right:10px; padding:3px; ">' .
  		 '<a href="welcome.php"';
           if ($page == 'home'){ echo 'style="color:blue;"'; }else{ echo 'class="linkonwhite"';}
           echo '>Home</a> | <a href="resources.php"';
           if ($page == 'resources'){ echo 'style="color:blue;"';} else { echo 'class="linkonwhite"';}
           echo '>Resources</a> | <a href="contacts.php"';
           if ($page == 'contacts'){ echo 'style="color:blue;"';} else { echo 'class="linkonwhite"'; }
           echo '>Contacts</a> | <a href="downloads.php"';
           if ($page == 'downloads'){ echo 'style="color:blue;"';} else { echo 'class="linkonwhite"'; }
           echo '>Downloads</a> | <a href="agreement.php"';
           ;

    // Show links to My Account, Help and Logout at top right corner
    echo '</span></div>'.
          '<span style="float:right; margin-right:10px;">'.
          '<a class="linkonwhite" href="account.php">My Account (' . $blahblah . ')</a> &nbsp; <a class="linkonwhite" href="logout.php">Logout</a>' .
          '</span>'.
          '</div>';
}


function redirect_to($location = NULL){
	if($location !=NULL){
	header("Location:{$location}");
	exit;
	}
}

function user_logout()
{
     // End the session and unset all vars
     session_unset ();
     session_destroy ();
}

			
?>