<?php require_once('init_utils.php');?>


<?php
$class=$_GET["class"];
$number=$_GET["number"];

	$classid = get_classid($class, $number);

	if (isset($classid)){

         $maxclasses = MAXIMUM_CLASSES;
         $clslock = WEEKS_TILL_CLASS_LOCK; //# of weeks till classes are locked

         // make sure user hasn't added more than max classes
		 $sql = "SELECT count(*) FROM members_classes WHERE member_id = " . $_SESSION['userid'];
		 if  (mysql_result(mysql_query($sql), 0, 0) < $maxclasses){
    		//add the class
    		$sql = "INSERT INTO members_classes VALUES (" . $_SESSION['userid'] . ", " . $classid . ")";
    		mysql_query($sql);
    		if (mysql_error() == ""){  // insertion was successful
    			echo $class . " " . $number . " has been added to your list of classes " . $result;
    		}else{
    			if (strpos(mysql_error(), "Duplicate") >= 0){
    				echo "Class has already been added";
    			}else{
    				echo "Unable to add '" . $class . " " . $number . "' to your list of classes";
    			}
    		}
		}
		else {
			 echo "<span id='error'>Sorry, you can't add more than <b>$maxclasses</b> classes per semester. ";
             if ($maxclasses == 10){
                echo "To <i>add</i> a class, <i>drop</i> one or more classes first</span>";
             }else{
               echo "To add more classes, you'll have to <a href='upgrade.php'>upgrade</a> your account.";
             }
		  }
	}
	showClasses($_SESSION['userid']);
?>