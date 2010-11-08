<?php
define('COUPON_LENGTH', 12);

class UserClass{
	/*
	Represents a class identified in the Classes# table of the database
	*/
  public $id;
  public $name;
  public $abrev;
  public $number;
  public $title;

  public function __construct($cid){
	// Constructor
	
	$res = mysql_query("SELECT * FROM classes" . $_SESSION['schoolID'] . " WHERE class_id = " . $cid );
	if (mysql_num_rows($res)){
	  $cinfo = mysql_fetch_array($res);
	  $this->id = (int)$cid;
	  $this->name = (string)$cinfo['class_name'];
	  $this->abrev = $cinfo['abrev'];
	  $this->number = $cinfo['class_number'];
	  $this->title = $cinfo['title'];
	}else{
	  return null;
	}
  }

  public function RequiredBooks($user){
    /* Returns an array of book instances representing books required for
    this class */

    $books = array();
    $query = "SELECT book_id FROM schools_classes WHERE school_id = " .
            $user->getSchoolID() . " AND class_id = " . $this->id;

	$res = mysql_query($query);
    if (mysql_num_rows($res)){
      while($bk = mysql_fetch_array($res)){
        $books[] = new Book($bk['book_id']);
      }
    }
    return $books;
  }
}

class Book{
  /* A book in the database */

  public $id;
  public $title;
  public $author;
  public $picture_url;

  public function __construct($bkid){
  /*
	Constructor
		- Creates a Book instance
	Parameters:
		- $bkid: ID for the book as specified in the database
	Returns:
		- n/a
	*/
    $sql = "SELECT title, author, picture_url FROM books" . $_SESSION['schoolID'] . " WHERE book_id = " . $bkid;
    $res = mysql_query($sql);
    if (mysql_num_rows($res)){
      $binfo = mysql_fetch_array($res);
      $this->id = $bkid;
      $this->title = $binfo['title'];
      $this->author = $binfo['author'];
      $this->picture_url = $binfo['picture_url'];
    }else{
      return null;
    }
  }

  public function ClassesAssignedTo($user){
    /* 
	Purpose:
		- Gets a list of all class this book has been assigned to
	Parameters:
		- $user: Instance of UserClass
	Returns:
		- An array of class ids representing classes this book has been assigned to
	*/

    $query = "SELECT class_id FROM schools_classes WHERE school_id = " .
            $user->school_id . " AND class_id = " . $this->id;
    $res = mysql_query($query);
    if (mysql_num_rows($res)){
      return mysql_fetch_array($res);
    }else{
      return null;
    }
  }

  public function getBookInfo(){
    /* Returns an array containing information about this book */

    $bkinfo = array("book_id" => $this->id, "title" => $this->title,
           "author" => $this->author, "picture_url" => $this->picture_url);
    return $bkinfo;
  }
}


class UserBook extends Book{
  /* 
  Book owned by a user - inherits methods and variables from class Book
	and in addition, has information such the ask_price, condition etc as specified by the user / owner
	*/

  public $book;
  private $ask_price;
  private $comment;
  private $condition;
  private $cover_type;

  public function __construct($user, $bkid){
    $this->book = new Book($bkid);
    $sql = "SELECT ask_price, newused, cover, comment FROM members_books WHERE member_id = " . $user->id;
    $res = mysql_query($sql);
    if (mysql_num_rows($res)){
      $bkinfo = mysql_fetch_array($res);
      $this->ask_price = $bkinfo['ask_price'];
      $this->comment = $bkinfo['newused'];
      $this->condition = $bkinfo['cover'];
      $this->cover_type = $bkinfo['comment'];
    }else{
      return null;
    }
  }

  // Getter and Setter functions
  
  public function setAskPrice($price){
    $this->ask_price = $price;
  }
  public function setComment($cc){
    $this->comment = $cc;
  }
  public function setCondition($cd){
    $this->condition = $cd;
  }
  public function setCoverType($ct){
    $this->cover_type = $ct;
  }
  public function getAskPrice(){
    return $this->ask_price;
  }
  public function getComment(){
    return $this->comment;
  }
  public function getCondition(){
    return $this->condition;
  }
  public function getCoverType(){
    return $this->cover_type;
  }
}

class User{
/*
	Class that identifies a user of the system.
	All information about the user is extracted from the members table fo the database
*/

  private $id;
  private $name;
  private $school_id;
  private $email;

  public function __construct($id){
	/* 
		Constructor
		Parameters:
			- $id: ID specified in the members table used to identify the user
	*/
    $sql = "SELECT * FROM members WHERE member_id = $id";
    $res = mysql_query($sql);
    if (mysql_num_rows($res)){
      $minfo = mysql_fetch_array($res);
      $this->id = $minfo['member_id'];
      $this->name = $minfo['name'];
      $this->school_id = $minfo['school_id'];
      $this->email = $minfo['email'];
    }
  }

  public function GetBooks(){
    /* 
		Returns an array of UserBook instances representing books currently
		owned by this user 
	*/

    $userbooks = array();
    $sql = "SELECT book_id FROM members_books WHERE member_id = " . $this->id;
    $res = mysql_query($sql);
    if (mysql_num_rows($res)){
      while ($currbook = mysql_fetch_array($res)){
        $userbooks[] = new UserBook($this, $currbook['book_id']);
      }
    }
    return $userbooks;
  }

  public function GetClasses(){
    /* 
		Returns an array of UserClass instances representing classes this user
		is currently enrolled in 
	*/

    $userclasses = array();
    $sql = "SELECT class_id FROM members_classes WHERE member_id = " . $this->id;
    $res = mysql_query($sql);
    if ($res){
      while ($currclass = mysql_fetch_array($res)){
        $userclasses[] = new UserClass($currclass['class_id']);
      }
    }
    return $userclasses;
  }

  public function getID(){
    return $this->id;
  }
  public function getName(){
    return $this->name;
  }
  public function getSchoolID(){
    return $this->school_id;
  }
  public function getEmail(){
    return $this->email;
  }

  public function SubscriptionType(){
    $sql = "SELECT subscription_id FROM member_subscriptions WHERE member_id = " . $this->id;
    return mysql_result(mysql_query($sql), 0, 0);
  }

  public function LockDateDue(){
	$sql = "SELECT 1 FROM class_locks WHERE lock_date < '" . date("Y-m-j") . "' AND member_id = " . $this->id;
	$res = mysql_query($sql);
	if (mysql_num_rows($res)){
		return true;
	}
   return false;
  }

  public function HasBook($bookid){
    /* Returns true if user has the specified book and false otherwise
       Parameters: $bookid - ID of the book
       Returns: boolean - true if user has book and false otherwise
    */

    $sql = "SELECT 1 FROM members_books WHERE member_id = " . $this->id . " AND book_id = " . $bookid;
    $res = mysql_query($sql);
    if (mysql_num_rows($res)){
      return true;
    }
    return false;
  }
}

function redirect_to($location = NULL){
	if($location !=NULL){
	header("Location:{$location}");
	exit;
	}
}
function confirm_query($result_set){
	if(!$result_set){
	die("Database query failed; ". mysql_error());
	}
}
// Salt Generator
function generate_salt()
{
     // Declare $salt
     $salt = '';

     // And create it with random chars
     for ($i = 0; $i < 3; $i++)
     {
          $salt .= chr(rand(35, 126));
     }
		 			$salt = str_replace("\\", ".", $salt);
					$salt = str_replace("'", "*", $salt);
          return $salt;
}

function send_validation_code($who, $code)
{
	/* 
	During the registration process, the function emails a validation code the user
	Parameters:
		- $who: email address where the validation code will be sent to
		- $code: the validation code
	Returns:
		- 1 (int): mail sent successfully
	*/

	$to = $who;

    $headers = "From: noreply@collegebookevolution.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$message = "<html><body><font size='2' face='Verdana'><p>" .
                "<img src='http://www.collegebookevolution.com/images/page/full_logo.png' /><br />" .
                "Welcome to College Book Evolution! <br/><br />Your validation code is: " . $code . 
                "</p><br/>Thanks,<br/>College Book Evolution</font>" .
                "<br/><br /><br /><font size='1' face='Verdana'>Return to the registration page and enter this validation code to proceed with the " .
                "registration process.</font></body></html>";
	
	$subject = 'College Book Evolution registration';
	$mail_sent = @mail( $to, $subject, $message, $headers );
	return 1;//$mail_sent;
}

function isValidEmail($email){
	/*
		Checks if an email address is in the database
		Parameters:
			- $email: email address to be validated
		Returns:
			- true (boolean): email address is valid / exists
			- false (boolean): email address is not valid / does not exist
	*/
	$index = strpos($email, '@');
	$mailserver = "";
	if ($index){
		  $mailserver = substr($email, $index+1);
    	// check if mail server exists
    	$sql = "SELECT 1 FROM mail_servers WHERE mail_server='" . $mailserver . "'";
    	if (mysql_result(mysql_query($sql), 0, 0) == 1){
    		 return true;
    	}
	}
	return false;
}

function couponValidSchool($schstate, $schname, $mkid){
	/* 
		Validates a coupon (during the registration process) by checking if the coupon exists in the database
		and belongs to the school being registered under
		
		Parameters:
			- $schstate: State in which the school is located
			- $schname: Name of the school
			- $mkid: Marketer who issued the coupon's ID
			
		Returns:
			- true (boolean): if the coupon is valid
			- false (boolean): if the coupon is invalid
	*/
	
		$sql = "SELECT school_id FROM schools WHERE school_name='{$schname}' AND state='{$schstate}'";
		$schid = mysql_result(mysql_query($sql), 0, 0);
		
		if (isset($schid)){
			 // get marketer school id
			 $sql = "SELECT school_id FROM members WHERE member_id = " . $mkid;
    		 $mkschid = mysql_result(mysql_query($sql), 0, 0);

			 return ($mkschid == $schid);
		}
		return false;
}


function generate_memberid(){
	/*
		Attempts to generate a unique member ID. A problem might occur if 2 or more people register simultaneously,
		or an assigned ID is pending activation, so this function checks the uniqueness of a generated ID in the 
		database up to 5 times before it gives up
	
		Parameters:
			- n/a
		
		Returns:
			- $id (String): A unique ID to be assigned to a registered user
	*/
	  $tables = array("members, pending_subscriptions, pending_upgrades");

	  for ($i = 0; $i < 5; $i++){
		$id = date('ydh') . rand(0, 9999);

		// check the 3 tables to see if the id has already been used
		for ($j = 0; $j < count($tables); $j++){
		  $sql = "SELECT 1 FROM " . $tables[$i] . " WHERE member_id = " . $id;
		  $res = mysql_query($sql);

		  if ($res and mysql_num_rows($res)){
			break;      // id was found in 1 of 3 tables so break from this loop
		  }else{
			if ($j == count($tables)-1){
			  return $id; // all tables have been checked and id is unique so return it
			}
		  }
		}
	  }
	  return false;
}

function setup_user_account($valcode, $name, $username, $psswd, $schstate, $schname, $email, $location, $salt){
	/* 
		Sets up a user account by
		- Placing the account information in the pending registration table if it's a paid account
		- Placing the account information in the members table and other relevant tables directly if it's a free trial account
		
		Parameters:
			- $valcode: The validation code
			- $name: User's full name
			- $username: User's username
			- $psswd: User's password
			- $schstate: State in which the User's school is located
			- $schname: Name of school User is attending
			- $email: User's email address
			- $location: Where User resides
			- $salt: hash for the User's password
	*/
	
	// get school id
	$query = "select school_id from schools where state = '" . $schstate . 
	"' and school_name = '" . $schname . "'";
	$school_id = (int)(mysql_result(mysql_query($query), 0, 0));

    $time_of_subscr = date("Y-m-d H:i:s");

    // get member id
    $member_id = generate_memberid();
    if (!$member_id){
      echo "<div class='nav'><br>Registration Error</div><div class='page_info'><div align='center'>" .
         "Sorry, your account could not be created at this time. Please try again later.</div></div>";
    include 'layout/endlayout.php';
    return false;
    }

    // add member information to members table
    $sql = "INSERT INTO members(member_id, name, username, password, school_id, email, location, salt, valcode) values (" . $member_id . ", '" . $name . "', '" . $username . "', '" . $psswd . "', " .  $school_id . ", '" . $email . "', '" . $location . "', '" . $salt . "', '" . $valcode . "')";
    mysql_query($sql) or die("ERROR 120: Unable to activate account. Please contact us with the code: (120" . $member_id . ")");

    // add credits information
    $sql = "INSERT INTO members_credits (member_id, bought, used, total_spent) values ($member_id, 0, 0, 0)";
    mysql_query($sql) or die("ERROR 123: Unable to activate account. Please contact us with the code: (123" . $member_id . ")");

    // add subscription information
	$sql = "INSERT INTO member_subscriptions(subscription_id, member_id, start_date, account_status, amount_paid) values (" . 5 . ", " . $member_id . ", '" . date("Y-m-d") . "', 1, 0.00)";
    mysql_query($sql) or die("ERROR 121: Unable to activate account. Please contact us with the code: (121" . $member_id . ")");

    // add member to members_prefs table
    $sql = "INSERT INTO members_prefs(member_id) VALUES (" . $member_id . ")";
    mysql_query($sql) or die("ERROR 122: Unable to activate account. Please contact us with the code: (122" . $member_id . ")");

/*    $page_title = "Registration";
    include 'layout/startlayout.php';
    echo "<div class='nav'><br>Registration Complete</div><div class='page_info'><div align='center'>" .
         "<img src='images/tick.png'><br /><br />Thank you <b>" . ucwords($name) . "</b>, your account has been activated!<br /><br />Click <a href='http://www.collegebookevolution.com'>here</a> to login</div></div>";
    include 'layout/endlayout.php';
  */

    return true;
}

function user_login($username, $password)
{
     $loginID = "username";

		 if (isValidEmail($username)){
		 		$loginID = "email";
			}

	// Try and get the salt from the database using the username
     $query = "select salt from members where " . $loginID . "='$username' limit 1";
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);

     // Using the salt, encrypt the given password to see if it
     // matches the one in the database
     $encrypted_pass = md5(md5($password).$user['salt']);

     // Try and get the user using the username & encrypted pass
     $query = "select member_id, name, school_id, email, location from members where " . $loginID . "='$username' and password='$encrypted_pass'";
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);

    if (mysql_num_rows($result))
    {
		// Now encrypt the data to be stored in the session
		$userid = $user['member_id'];
		$encrypted_id = md5($userid);
		
		//get account type
		//$sql = "SELECT name FROM account_types WHERE tid = (SELECT account_type FROM member_subscriptions WHERE member_id = " . $userid . " LIMIT 1)";
        // no more subscriptions; everyone is a 5
		$acctype = 5;

        // get the school name and state
        $school_info = get_school($user['school_id']);
        $schstate = $school_info['State'];
        $schname = $school_info['School_Name'];

		// Store the data in the session
		$_SESSION['username'] = $username;
		$_SESSION['userid'] = $userid;
		$_SESSION['acctype'] = $acctype;
		$_SESSION['encrypted_id'] = $encrypted_id;
        $_SESSION['fullname'] = $user['name'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['schoolID'] = $user['school_id'];
        $_SESSION['schstate'] = $schstate;
        $_SESSION['schname'] = $schname;
        $_SESSION['email'] = $user['email'];
        $_SESSION['location'] = $user['location'];
        return true;
    }
    else
    {
        return false;
    }
}

function user_logout()
{
     // End the session and unset all vars
     session_unset ();
     session_destroy ();
}

function is_authed()
{
     // Check if the encrypted username is the same
     // as the unencrypted one, if it is, it hasn't been changed
     if (isset($_SESSION['username']) && (md5($_SESSION['userid']) == $_SESSION['encrypted_id']))
     {
          return true;
     }
     else
     {
          return false;
     }
}

function is_validated() {
    // Check if current user is validated
    $valcode = mysql_result(mysql_query("SELECT valcode FROM members WHERE username='" . $_SESSION['username'] . "'"), 0);
    if($valcode == 0) return true;
    return false;
}

function format_date($date){
				$m = "";
				$d = "";
				$yr = ""; 
				list($yr, $m, $d) = split("-", $date);
				return $m . "/" . $d . "/" . $yr;
				}

function addDate($date, $num){
				 $newdate = strtotime ( $num . ' year' , strtotime ( $date ) ) ;
				 $newdate = date ( 'Y-m-j' , $newdate );
				 return $newdate;
				 }

				 
function account_exists($email){
	 // check for unique username
	 $query = "select count(*) from members where email='" . $email . "'";
	 $unames = (int)(mysql_result(mysql_query($query), 0, 0));
	 
	 if ($unames == 0){
  	 $query = "select count(*) from pending_subscriptions where email='" . $email . "'";
  	 $unames = (int)(mysql_result(mysql_query($query), 0, 0));
		 }
	 if ($unames > 0){
	    return true;
		}
	 return false;
}

/* USER INTERACTION FUNCTIONS */
function add_class($userid, $classid){
	$query = "INSERT INTO member_classes(member_id, class_id) VALUES ({$userid}, {$classid})";
	return mysql_query($query);
	}

function get_classid($class, $number){
	$sql="SELECT class_id FROM classes" . $_SESSION['schoolID'] . " WHERE class_name = '" . chkstr($class) . "' AND class_number = '" . $number . "'";
	return (int)(mysql_result(mysql_query($sql), 0, 0));
	}
	
function get_school($schoolid){
	$sql = "SELECT * FROM schools WHERE school_id = " . $schoolid . " LIMIT 1";
	return mysql_fetch_array(mysql_query($sql));
	}
	
function get_subscription_info($sub_id){
	$sql = "SELECT * FROM subscriptions WHERE subscription_id = " . $sub_id . " LIMIT 1";
	return mysql_fetch_array(mysql_query($sql));
	}
	
	
function get_bookid($userid, $classid){
	$sql = "SELECT book_id FROM schools_classes WHERE class_id = {$classid} AND school_id = (SELECT school_id FROM members WHERE member_id = {$userid} LIMIT 1)";
	return (int)(mysql_result(mysql_query($sql), 0, 0));
	}	
	
function get_book($bookid){
	$sql = "SELECT title, isbn, author, picture_url, bkstoreprice_new, bkstoreprice_used FROM books" . $_SESSION['schoolID'] . " a INNER JOIN schools_classes b ON a.book_id = b.book_id WHERE a.book_id = " . $bookid . " AND b.school_id = (SELECT school_id FROM members WHERE member_id = " . $_SESSION['userid'] . " LIMIT 1)";
	return mysql_fetch_array(mysql_query($sql));
	}	
	
function drop_class($userid, $classid){
	$query = "REMOVE FROM member_classes WHERE member_id = {$userid} AND class_id = {$classid}";
	return mysql_query($query);
	}

function get_classes($userid){
/* returns information about all the classes a user is taking */
    $sql = "SELECT * FROM classes" . $_SESSION['schoolID'] . " JOIN members_classes using(class_id) WHERE member_id = " . $_SESSION['userid'];   //optimized version
	//$sql = "SELECT * FROM classes WHERE class_id IN (SELECT class_id FROM members_classes WHERE member_id = " . $_SESSION['userid'] . ")";
	return mysql_query($sql);
	}
	
function get_books_owned($userid){
	$query = "SELECT m.*, b.book_id, title, ISBN, author, picture_url FROM books" . $_SESSION['schoolID'] . " b INNER JOIN members_books m USING(book_id) WHERE member_id = {$userid}";
	return mysql_query($query);
	}
	
function get_books_still_needed($userid){
	// get his classes -> get books for his classes that are not in the books he has
    $query = "SELECT book_id FROM schools_classes JOIN (SELECT class_id FROM members_classes WHERE member_id = $userid) x USING(class_id) WHERE book_id NOT IN (SELECT book_id FROM members_books WHERE member_id = $userid)"; //optimized - runs in .0009 secs
	//$query = "SELECT book_id FROM schools_classes WHERE class_id in (SELECT class_id FROM members_classes WHERE member_id = " . $userid . ") AND book_id NOT IN (SELECT book_id FROM members_books WHERE member_id = " . $userid . ")";
    return mysql_query($query);
	}

	
function get_class_book($userid, $classid){
/* returns the book(s) required for a class */
	$query = "SELECT book_id, title, ISBN, author, picture_url FROM books" . $_SESSION['schoolID'] . " WHERE book_id IN (SELECT book_id FROM schools_classes WHERE class_id = {$classid} AND school_id = (SELECT school_id FROM members WHERE member_id = {$userid}))";
	return mysql_query($query);
	}
	
function get_class_books($userid, $classid){
/* returns the book(s) required for a class */
	$query = "SELECT a.book_id, title, isbn, author, picture_url, bkstoreprice_new, bkstoreprice_used FROM books" . $_SESSION['schoolID'] . " a INNER JOIN schools_classes b ON a.book_id = b.book_id WHERE a.book_id IN (SELECT book_id FROM schools_classes WHERE class_id = {$classid} AND school_id = (SELECT school_id FROM members WHERE member_id = {$userid})) AND class_id = {$classid}";
	return mysql_query($query);
	}
	
	
function class_book_belongs_to($bookid){
    $query = "SELECT class_id FROM schools_classes LEFT JOIN (SELECT school_id FROM members WHERE member_id = " . $_SESSION['userid'] . ") x using (school_id) where book_id = $bookid";  // runs in .0009 secs
	//$query = "SELECT class_id FROM schools_classes WHERE book_id = " . $bookid . " AND school_id = (SELECT school_id FROM members WHERE member_id = " . $_SESSION['userid'] . ")";    // runs in .0030 secs
	echo $query;
	return mysql_result(mysql_query($query), 0, 0);
}
	
function rate_user($userid, $goodrate){
/* rates a user. If goodrate = 1, increment positive rate, else increment negative rate  > you either like the seller or you dont */
	if ($goodrate){
		$query = "UPDATE members SET positive_rating = positive_rating + 1 WHERE member_id = {$userid}";
		}else{
		$query = "UPDATE members SET negative_rating = negative_rating + 1 WHERE member_id = {$userid}";
		}
	return mysql_query($query);
	}
	
	
function class_lock_due(){
	$sql = "SELECT 1 FROM class_locks WHERE lock_date < '" . date("Y-m-j") . "' AND member_id = " . $_SESSION['userid'];
	$res = mysql_query($sql);
	if (mysql_num_rows($res) == 1){
		return true;
	}
 return false;
}
	
/* ----------------------------- SHOW CLASSES ----------------------------------*/

function showClasses(){

$USER = new User($_SESSION['userid']);
$classes = $USER->GetClasses();
$classlock = $USER->LockDateDue();
$cap = MAXIMUM_CLASSES;
$class_count = 0;

echo "<form name='classform' method='post' action='' />
     <h2>Your Classes <span id='subscript'>(" . count($classes) . "/$cap)</span></h2>
     <input type='checkbox' name='check_list' id='-1' style='visibility:hidden;' />
     <input type='radio' name='reqbooks' id='-1' style='visibility:hidden;' /><br>";

foreach($classes as $class){

  $cls = "<strong>" . $class->name . " " . $class->number . "</strong>: <span style='color:#777777;'><i>" . $class->title . "</i></span>";
  $chk_count = 1;
  echo "<input class='nodec' type='radio' name='check_list' id='" . $class->id . "' value='" . $class_count++ . "' onclick='";
	 if (!$classlock){
	    echo "clearReqBooks(this.form.reqbooks); ";
	 }
	echo "toggleReqBooks(\"bkcid" . $class->id . "\", document.classform.reqbooks); '/>" . $cls . "<br/>";

    $class_books = $class->RequiredBooks($USER);
	$bkcount = count($class_books);

	echo "&nbsp; &nbsp; &nbsp;<span id='subscript'>";
    echo "<b> Book: </b>" ;

    if ($bkcount > 0){
        // print the first book's title
        echo $class_books[0]->title;

        // indicate the # of remaining books
        if ($bkcount == 1){
    		echo "<br>";
    	} else if ($bkcount == 2){
    		echo " and 1 other book<br> ";
    	} else if ($bkcount > 2){
    		echo " and " . ($bkcount - 1) . " other books<br>";
    	}
    }

	echo "</span>";

  	if ($bkcount == 0){
		echo "<span id='subscript' >book not found.</span><br>";
	}
		//show div
		echo "<div class='class_books' style='display: none;' id='bkcid" . $class->id . "'>" .
            "<h3>Books:</h3>";
		foreach ($class_books as $book){
            echo "<input type='radio' name='reqbooks' id='" . $book->id . "'";

            //if it's the first book, make it checkable when the class is clicked on.
            if ($chk_count == 1){
                echo " value='bkcid" . $class->id . "'";
            }
            echo "/>";

            $chk_count++;

            //see if user has books for this class
            if (!$USER->HasBook($book->id)){
            	echo $book->title . "<br/>";
            } else {
                echo $book->title . "<span style='color:#000000;'> &#x2713;</span><br/>";
            }
		}
		if ($bkcount > 0){
			 echo "<br />";
		}
		if ($classlock == false){
            echo "<a href='#' onClick='dropclass(document.classform.check_list, \"listclasses\"); return false'>Drop Class</a>&nbsp; &nbsp;";
		}
        echo "<a href='#' onClick='findBooks(document.classform.check_list, document.classform.reqbooks); return false'>Find Book</a>";
		echo "</div>"; 
	
	echo "<br>";  
  }
if ($class_count == 0){
	echo "No classes found.<br>";
}
echo "<br><br><br/><span id='subscript'>
      Can't find your class, or don't see a particular book for your class listed?
      <a href='http://www.collegebookevolution.com/help/?ref=suggest'
      target='_blank'>Suggest it</a> so we can add it.
      </span>
      </form>";
}

/* ----------------------------- SHOW BOOKS ----------------------------------*/
function showBooks($user){
/* list all the books a user has */

	$books = get_books_owned($_SESSION['userid']);
	echo "<form name='booksform' method='post' action='' />";
	echo "<h2>Your Books <span id='subscript'>(" . mysql_num_rows($books) . ")</span></h2>";
	echo "<table border='0' cellpadding='3px'>";
	$count = 0;
	echo "<input type='checkbox' name='check_list' id='-1' style='visibility:hidden;' />";
	while($row = mysql_fetch_array($books))
	{
		$count++;
		$askprice;
		$bkimg = $row['picture_url'];
		if (empty($bkimg)){
			$bkimg = "images/noimage.png";
		}
		echo "<tr>";
		echo "<td valign='top'><input class='nodec' type='checkbox' name='check_list' id='" . $row['book_id'] .
		"' value='" . $count . "' /></td><td valign='top'><a href='" . $bkimg . "' rel='lightbox[userbooks]' title='" . $row['title'] . "'><img src='" . $bkimg . "' width='75px' height='90px'/></a></td>";
		if ($row['ask_price'] == '-1.00'){
			 $askprice = "(In Use)";
			 }else{
			 $askprice = '$'.$row['ask_price'];
		}		
		echo "<td></td><td>" . 
				 "<table class='listbooks'>" .
				 "<tr valign='top'><td width='100px' valign='top'><b>Book Title:</b></td><td><b>" . $row['title'] . "</b></td>" .
				 '<td align="right" width="150px;"><a href="#top" onClick="editUserBook(\'' . $row['book_id'] . '\', \'' .
				 $row['newused'] . '\', \'' . $row['cover'] . '\', \'' . $askprice . '\', \'' . str_replace('"', "\'", (str_replace("'", "\'", $row['comment']))) . '\', \'foundbook\')">Edit</a>' .
				 "&nbsp; | &nbsp;<a href='javascript:void(0)' onClick='removeBook(" . $row['book_id'] . ", \"listbooks\")'>Remove</a></td></tr>" .
				 "<tr><td width='100px' valign='top'><b>Author:</b></td><td>" . $row['author'] . "</td></tr>"  .
				 "<tr><td width='100px' valign='top'><b>Class:</b></td><td><i>";

				 //get classes this book has been assigned to...the next line is an optimized version of the query below it
                 $sql = "SELECT class_name, class_number FROM classes" . $_SESSION['schoolID'] . " JOIN schools_classes USING ( class_id ) WHERE book_id = " . $row['book_id'] . " AND school_id = " . $_SESSION['schoolID'] ;
				 //$sql = "SELECT class_name, class_number FROM classes WHERE class_id IN (select class_id FROM schools_classes WHERE book_id = " . $row['book_id'] . ")";

				 $bkscs = mysql_query($sql);
				 $classcount = 0;

				 if (mysql_num_rows($bkscs)){
				 		while ($bkclass = mysql_fetch_array($bkscs)){
									$classcount++;
				 					 echo $bkclass['class_name'] . " " . $bkclass['class_number'] . "<br/>";
									 if ($classcount == 2){
									 		$diff = ($total-$classcount);
											if ($diff > 0){
  											echo "<span id='subscript'>";
  											if ($diff == 1){
  												 echo "and 1 other class";
  											}else{
  									 			 echo "and " . $diff . " other classes<br/>";
  											}
  											echo "</span>";
											}
										  break;
									 }
						}
				 }
				 else {
				 		echo "Unassigned";
				 }
		echo "</i><tr><td width='100px' valign='top'><b>Ask Price:</b></td><td>" . $askprice . "</td></tr>" .
				 "<tr><td width='100px' valign='top'><b>Condition:</b></td><td>" . $row['newused'] . "</td></tr>" .
				 "<tr><td width='100px' valign='top'><b>Cover Type:</b></td><td>" . $row['cover'] . "</td></tr>" .
				 "<tr><td width='100px' valign='top'><b>Comment:</b></td><td>" . str_replace("\'", "'", $row['comment']) . "</td></tr>" .
				 "<tr><td width='100px' valign='top'><b>Date Added:</b></b></td><td>" . format_date($row['date_added']) . "</td></tr>".
				 "</table>";
		echo "</td></tr>";
	}
	
	echo "</table>";
	if ($count == 0){
		echo "No books found<br/>";
	}
	echo '<br><input type="checkbox" name="checker" value="yes" onClick="Check(document.booksform.check_list)"><b>Check/Uncheck All</b>';
	echo "<br><br><input name='delete' type='button' value='Remove Book' onclick='removeBook(document.booksform.check_list, \"listbooks\")' />";
	echo "</form>";
}	




/* ----------------------------- SEND BOOK REQUEST EMAIL ----------------------------------*/

function sendBookRequestEmail($seller, $class, $bkid, $bk_author, $bk_title){
/* emails a seller regarding a request for a book. Email is sent to account email address, 
if no preferred email address is set */

list ($seller, $trade) = split(":", $seller);

// check if this seller has already been contacted this month
    $sql = "SELECT 1 FROM members_contacts WHERE member_id = " . $_SESSION['userid'] . " AND seller_id = " . $seller .
           " AND book_id = " . $bkid . " AND (contact_date is NULL or DATEDIFF(CURDATE(), contact_date) <= 28)";
    if (mysql_num_rows(mysql_query($sql))){
    	 return "Sorry, this seller has already been contacted in the last 4 weeks regarding this book.";
    }

	$sql = "SELECT preferred_email, email FROM members WHERE member_id = " . $seller;
	$result = mysql_fetch_array(mysql_query($sql));
	
	if (!empty($result[0])){
		 $seller_email = $result[0]; //preferred email
	} else {
		 $seller_email = $result[1]; //default email
	}
	
	$sql = "SELECT username, preferred_email, email, location FROM members WHERE member_id = " . $_SESSION['userid'];
	$result = mysql_fetch_array(mysql_query($sql));
	if (empty($result[1])){
		 $useremail = $result[2];
	}else{
		 $useremail = $result[1];
	}
	$username = $result[0];
    $location = $result[3];
    if (!empty($location)){
        $location = "(" . $location . ") ";
    }
	
	$to = $seller_email;
	$subject = "CollegeBookEvolution Book Request";

    $headers = "From: noreply@collegebookevolution.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "Reply-To: " . $useremail . "\r\n";

  	$body = "<html><body><font size='2' face='Verdana'><b>" . $username . "</b> " . $location. "is interested in your " . $class . " book: <b>" . $bk_title . "</b> by " . $bk_author;
	if ($trade != -1){
		$body .= "<br/>This user also has books you are currently in need of: " . $trade;
	}
  	$body .= "<br/><br/>Respond to this user by sending an E-mail to <a href='mailto:" . $useremail . "'>" . $useremail . "</a>.<br/><br/>Thanks, <br/>College Book Evolution." .
  	"<p><font size='1'>Uncertain about how to respond? Check out our <a href='http://www.collegebookevolution.com/help/?ref=safety'>Communication & Safety Tips</a>." .
    "<br/>If you do not wish to receive email at this address: <i>" . $seller_email . "</i>, you may set or change your preferred email under 'My Account' " .
    "once you login to your account at <a href='http://www.collegebookevolution.com'>collegebookevolution.com</a></font></p></font></body></html>";

  	if (@mail($to, $subject, $body, $headers)) {
			 // add record to member_contacts
			 $sql = "INSERT INTO members_contacts(member_id, seller_id, book_id, contact_date) VALUES " .
			 			"(" . $_SESSION['userid'] . ", " . $seller . ", " . $bkid . ", '" . date("Y-m-d") . "')";
			 mysql_query($sql);
			 return "Request has been sent to seller.";
    } else {
       return "Unable to send request to seller. Please try again later.";
    }
}


/* ----------------------------- GENERATE COUPON ----------------------------------*/

function generate_coupon(){
/*try at least 5 times to generate a unique random id. the first unique one generated is returned. */
		
		for ($i = 1; $i < 5; $i++){
        //set the random id length 
        $random_id_length = COUPON_LENGTH; 
        
        //generate a random id encrypt it and store it in $rnd_id 
        $rnd_id = crypt(uniqid(rand(),1)); 
        
        //to remove any slashes that might have come 
        $rnd_id = strip_tags(stripslashes($rnd_id)); 
        
        //Removing any . or / and reversing the string 
        $rnd_id = str_replace(".","",$rnd_id); 
        $rnd_id = strrev(str_replace("/","",$rnd_id)); 
        
        //finally I take the first 10 characters from the $rnd_id 
        $rnd_id = substr($rnd_id,0,$random_id_length); 
				
				$d = date("mdY");
				$coupon = substr($d, 0, 2); // month
				$coupon = $coupon . substr($rnd_id, 0, 4);
				$coupon = $coupon . substr($d, 2,2); // day
				$coupon = $coupon . substr($rnd_id, 4, 4);
				$coupon = $coupon . substr($d, 4,2); // year1
				$coupon = $coupon . substr($rnd_id, 8, 4);
				$coupon = $coupon . substr($d, 6,2); // year2
				$rnd_id = $coupon;
				
				$sql = "SELECT 1 FROM mk_coupons WHERE coupon = '" . $rnd_id . "' LIMIT 1";
				if (mysql_num_rows(mysql_query($sql)) != 1){
					 break;
					 }
		}
    
		return $rnd_id;
}
		


/* ----------------------------- VICE VERSA SEARCH (BARTER TRADE) ----------------------------------*/

function viceVersaSearch($userid, $sellerid){
	 //get users books
	 $urbooks = get_books_owned($userid);

	 //get books seller needs
	 $sellerneeds =  get_books_still_needed($sellerid);

	 $trade = array(); //tradable books
     $sb = array();

     // store the seller's books needed in an array so we don't
     // mysql_fetch_array every time we loop through the buyers books
     // to find a match.
     while ($row = mysql_fetch_array($sellerneeds)){
        $sb[] = $row['book_id'];
       }

     // loop through buyers books, and for each book_id, see if it's needed
     // by the seller.
	 while ($buyerbooks = mysql_fetch_array($urbooks)){
		 foreach($sb as $sellerbkid){
  			 if ($sellerbkid == $buyerbooks['book_id']){
			 		$trade[] = $sellerbkid;
				}
		 }
	 }
	 return $trade;
}




/* ----------------------------- GET TITLE STRINGS ----------------------------------*/

function get_title_strings($list){
/* Gets a list of book_ids and returns a string listing the book titles */

				 $res = "";
				 $max = sizeof($list);
				 for ($i = 0; $i < $max; $i++){
				 
				 		 $bk = get_book($list[$i]);
						 $title = $bk['title'];
						 
						 if ($max == 1){
						 		$res = $res . $title;
						    break;
						 }
						 if ($i == (sizeof($list)-1)){
						 		$res = $res . " and " . $title;
								} else {
								$res = $res . $title . ", ";
						 }
					}
					return $res;
}

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
function nav_menu($loginid, $page){
    // Display general menu everyone sees
    echo '<div class="nav"><br>' .
  		 '<div style="float:left; height:30px; margin-left:10px; background-color:white; border-style:solid;  border-color:#0099CC; border-width:thin; border-bottom-style:none;"><span style="float:left; margin-left:10px; margin-right:10px; padding:3px; ">' .
  		 '<a href="welcome.php"';
           if ($page == 'home'){ echo 'style="color:blue;"'; }else{ echo 'class="linkonwhite"';}
           echo '>Home</a> | <a href="classes.php"';
           if ($page == 'classes'){ echo 'style="color:blue;"';} else { echo 'class="linkonwhite"';}
           echo '>Classes</a> | <a href="books.php"';
           if ($page == 'books'){ echo 'style="color:blue;"';} else { echo 'class="linkonwhite"'; }
           echo '>Books</a> | <a href="chat.php"';
           if ($page == 'chat'){ echo 'style="color:blue;"';} else { echo 'class="linkonwhite"'; }
           echo '>Chat</a> | <a href="findbook.php"';
           if ($page == 'search'){ echo 'style="color:blue;"';} else { echo 'class="linkonwhite"'; }
           echo '>Search</a>';

    //check account type and show additional menu items if marketer
    if (strtolower($_SESSION['acctype']) == 'marketer'){
          echo ' | <a href="marketeradmin.php"';
          if ($page == 'marketer'){ echo 'style="color:blue;"'; } else { echo 'class="linkonwhite"'; }
          echo 'class="linkonwhite">Marketing Team</a> | <a href="downloads.php"';
          if ($page == 'downloads'){ echo 'style="color:blue;"'; } else { echo 'class="linkonwhite"'; };
          echo 'class="linkonwhite">Downloads</a>';
    }

    // Show links to My Account, Help and Logout at top right corner
    echo '</span></div>'.
          '<span style="float:right; margin-right:10px;">'.
          '<a class="linkonwhite" href="account.php">My Account (' . $loginid . ')</a> &nbsp; <a class="linkonwhite" href="help">Help</a> &nbsp; <a class="linkonwhite" href="logout.php">Logout</a>' .
          '</span>'.
          '</div>';
}


function welcome_info(){
    // announcement
    $sql = "SELECT value FROM misc WHERE attribute = 'announcement'";
    $ann = mysql_result(mysql_query($sql), 0, 0);
    if (!empty($ann)){
        echo "<li><img src='http://www.collegebookevolution.com/images/icons/announcement.png' alt='announcement' /> " . $ann . "</li>";
        }

    // coupons
   if ($_SESSION['acctype'] == 'marketer'){
  		 // get coupon code
  		 $sql = "SELECT coupon, date_given, users FROM mk_coupons WHERE member_id = " . $_SESSION['userid'];
  		 $res = mysql_fetch_array(mysql_query($sql));
  		 echo "<li><b>Coupon Code:</b> " . $res['coupon'] .
   			"<br><span id='subscript'>date issued: ";
         if (!empty($res['coupon'])){
            echo "<b>" . date("m/d/Y", strtotime($res['date_given'])) . "</b>";
         }

         echo "</span></li>";

  		 // compute earnings
        if ($res['users'] == 0){
       		echo "<li>No one has signed up with your coupon code this month.<br>";
        } else if ($res['users'] == 1){
       	  echo "<li><i><b>1</b></i> person has signed up so far with your coupon code this month.<br>";
        } else {
      				 	echo "<li><i><b>" . $res['users'] . "</b></i> people have signed up so far with your coupon code this month.<br>";
       	}
  	}

   // point out total classes and last day to add/drop classes if any
   $sql = "SELECT count(*) FROM members_classes WHERE member_id = " . $_SESSION['userid'];
   $numclasses = mysql_result(mysql_query($sql), 0, 0);
   if ($numclasses == 0){
   		echo "<li>You don't have any classes listed. Click <a href='classes.php'>here</a> to add a class.".
  				 "<br><span id='subscript'>Watch a <a href='http://www.collegebookevolution.com/tutorials/?ref=addclass'>video tutorial</a> on how to add classes</span></li>";
  		}
   else {
   			if ($numclasses == 1){
  				 echo "<li>You have <b><a href='classes.php'>1 class</a></b> listed.<br>";
  				}else{
   				 echo "<li>You have <b><a href='classes.php'>" . $numclasses . " classes</a></b> listed.<br>";
  			}
  		$sql = "SELECT lock_date FROM class_locks WHERE member_id = " . $_SESSION['userid'];
  		$dropdate = mysql_result(mysql_query($sql), 0, 0);
  		echo "<span id='subscript'>Last day to add/drop classes";
  		if (class_lock_due()){
  			echo " was";
  		}
  		echo ": <b>" . date("m/d/Y", strtotime($dropdate)) . "</b></span></li>";
   }

   // point out total books listed
   $sql = "SELECT count(*) FROM members_books WHERE member_id = " . $_SESSION['userid'];
   $numbooks = mysql_result(mysql_query($sql), 0, 0);
   if ($numbooks == 0){
   		echo "<li>You don't have any books listed. Click <a href='books.php'>here</a> to add a book.".
  				 "<br><span id='subscript'>Watch a <a href='http://www.collegebookevolution.com/tutorials/?ref=addbook'>video tutorial</a> on how to add books</span></li>";
  		}
   else {
   			if ($numbooks == 1){
  				 echo "<li>You have <b><a href='books.php'>1 book</a></b> listed.<br></li>";
  			} else {
   				 echo "<li>You have <b><a href='books.php'>" . $numbooks . " books</a></b> listed.<br></li>";
  			}
   }

    // available credits
    $sql = "select bought, used from members_credits where member_id = " . $_SESSION['userid'];
    $res = mysql_fetch_array(mysql_query($sql));
    if($res['bought'] == $res['used'])
        echo "<li>You don't have any book credits available. Click <a href='add_credits.php'>here</a> to add some.</li>";

    // recent contacts
         // filter out null contact dates left over from subscription pricing model
         $sql = "SELECT * FROM members_contacts WHERE member_id = " . $_SESSION['userid']. " AND contact_date IS NOT NULL ORDER BY contact_date DESC LIMIT 4";
         $res = mysql_query($sql);
         if (mysql_num_rows($res) > 0){
              ?>
              <li><b><a href='javascript:void(0);' onClick='togglediv("sellers");'>Sellers</a></b> you have contacted recently</li>
              <div id='sellers' name='sellers' style='display:none;'>
              <?

              echo "<ul>";
              while ($row = mysql_fetch_array($res)){
                  $newsql = "SELECT username, location FROM members WHERE member_id = " . $row['seller_id'] . " LIMIT 1";
                  $sellerinfo = mysql_fetch_array(mysql_query($newsql));

                  $bookinfo = "SELECT title FROM books" . $_SESSION['schoolID'] . " WHERE book_id = " . $row['book_id'] . " LIMIT 1";
                  $bookname = mysql_fetch_array(mysql_query($bookinfo));
                  echo "<li>" . $sellerinfo['username'] . " (<i>" . $sellerinfo['location'] . "</i>)<br/><span id='subscript'><b>Date:</b> ";
                  echo (empty($row['contact_date']))? "n/a" : date("m/d/Y", strtotime($row['contact_date']));
                  echo " <b>Book:</b> " . $bookname['title'] . "</span></li>";
             }
             echo "</ul></div>";
         }


         $sql = "SELECT * FROM members_contacts WHERE seller_id = " . $_SESSION['userid']. " ORDER BY contact_date DESC LIMIT 4";
         $res = mysql_query($sql);
         if (mysql_num_rows($res) > 0){
              ?>
              <li><b><a href='javascript:void(0);' onClick='togglediv("buyers");'>Buyers</a></b> who have contacted you recently</li>
              <div id='buyers' name='buyers' style='display:none;'>
              <?

              echo "<ul>";
              while ($row = mysql_fetch_array($res)){
                  $newsql = "SELECT username, location FROM members WHERE member_id = " . $row['member_id'] . " LIMIT 1";
                  $buyerinfo = mysql_fetch_array(mysql_query($newsql));

                  $bookinfo = "SELECT title FROM books" . $_SESSION['schoolID'] . " WHERE book_id = " . $row['book_id'] . " LIMIT 1";
                  $bookname = mysql_fetch_array(mysql_query($bookinfo));
                  echo "<li>" . $buyerinfo['username'] . " (<i>" . $buyerinfo['location'] . "</i>)<br/><span id='subscript'><b>Date:</b> " . date("m/d/Y", strtotime($row['contact_date'])) . " <b>Book:</b> " . $bookname['title'] . "</span></li>";
             }
             echo "</ul></div>";
         }

   // invitation
   $sql = "SELECT name FROM members WHERE member_id = " . $_SESSION['userid'];
   $res = mysql_fetch_array(mysql_query($sql));
   $name = $res['name'];
   ?>
   <li><a href='javascript:void;' onClick='togglediv("invite"); document.getElementById("invite_email").value="Enter email address"; document.getElementById("invite_email").select();'>Invite</a> your friends to join College Book Evolution</li>
   <div id='invite' name='invite' style='display:none;'><p><input type='text' id='invite_email' />&nbsp;<a href='javascript:void;' onClick='sendInvitation(document.getElementById("invite_email").value, "<? echo $name ?>", "invite");'>Send</a></p></div>
   <?
}

function chkstr($str){
				// check for '
				//$str = str_replace("'", "\'", $str);
				$str = str_replace('"', "\'", $str);
				return $str;
}



function validate_registration($name, $email, $username, $password, $confpassword, $schstate, $schname, $location){

		$reg_error = "";
     // Check if any of the fields are missing
    if (empty($name) || empty($email) || empty($username) || empty($password) || empty($confpassword) || $schstate == "-- Select --" || $schname == "-- Select --" || empty($location)){
		 	 return 'One or more fields missing';
			 }

			 if (!isValidEmail($email)){
		 return 'Invalid email address, must be your school email.';
		 }


	 // Check if email has already been registered
	 $query = "select 1 from members where email='" . $email . "' LIMIT 1";
	 $res = mysql_num_rows(mysql_query($query));
	 if ($res > 0){
			return "An account already exists under the email address '<b>" . $email . "</b>'";
			}

	 if (ctype_punct($name)){
	 		return "Your name '<b>" . $name . "</b>' cannot contain any punctuations or special characters";
			}

	 if (!ctype_alnum($username)){
	 		return "Invalid username '<b>" . $username . "</b>'. Make sure it doesn't contain any spaces or special characters";
			}


    // check for unique username
    $query = "select count(*) from members where username='" . $username . "'";
    $unames = mysql_result(mysql_query($query), 0, 0);
    if ($unames > 0){
        return "The username '<b>" . $username . "</b>' is not available";
    }

    if (strlen($username) < 6){
        return "The username '<b>" . $username . "</b>' is less than 6 characters long";
    }


    // check if password conforms to rules
    if (!preg_match("/^.*(?=.{6,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $password)){
        return 'Password must be at least 6 characters long, alpha numeric and a mix of upper and lower case letters';
    }

    // Check if the passwords match
    if ($password != $confpassword){
        return 'Your passwords do not match';
	}

	return $reg_error;
}

function write_to_log($file, $msg){ 
    if (strpos($_SERVER["DOCUMENT_ROOT"], "xampp") == false){
        $myFile = $_SERVER['DOCUMENT_ROOT'] . "/admin/logs/" . $file . "_" . date("Y_m") . ".csv";
        $fh = fopen($myFile, 'a') or die("can't open file");
        fwrite($fh, $msg);
        fclose($fh);
    }
}

function subscription_type($userid){
  $sql = "SELECT subscription_id FROM member_subscriptions WHERE member_id = $userid";
  return mysql_result(mysql_query($sql), 0, 0);
}
?>


