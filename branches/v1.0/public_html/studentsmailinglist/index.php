<?
/*
Email list script
by phptutorial.info
*/

// to avoid showning errors (change to 1 to show them). For security
error_reporting(0);

// if info is posted, show the form and die
// the form is in the bottom of the page
if (!$_POST){print_form();die();}

// when info is posted you will be here
?>

        <!-- PAGE LAYOUT -->

<html>
<head>
<title>Students Mailing List</title>
<style type="text/css">
table.sample {
	border-width: 1px;
	border-spacing: ;
	border-color: #A9F5F2;
	border-collapse: separate;
	background-color: white;
	font-family:Arial, Helvetica, sans-serif;
	font-size:0.8em;
}
table.sample th {
	border-width: 0px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: rgb(250, 240, 230);
	-moz-border-radius: ;
}
table.sample td {
	border-width: 0px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: #FFFF99;
	-moz-border-radius: 10px;
    -webkit-border-radius: 10px;
}
span#error{
  background-color: #FFCCCC;
}

.bottom_links a{
    text-decoration: none;
    color: black;
    padding: 3px;
}

.bottom_links a:hover{
    text-decoration: underline;
}


</style>
</head>
<body>
<div align='center'>
<a href='http://www.collegebookevolution.com'><img src='../images/cbe_logo.gif' border='0' alt='College Book Evolution' /></a>

<table class='sample'width=500px><tr><td>
<div align='center' style='margin-left:10px;'>
<h2>Mailing List</h2>
<p>

<?

// GET EMAIL
        $email=$_POST["email"];
        // To avoid problems, only lower case is used
        $email=strtolower($email);
        // Check whether email is correct by using a function
        //  function requires the email address and the error message
        check_email ($email, "Error: email is not valid.");


// GET VALUE FOR action : subc (subscribe) or unsubc (unsubscribe)
$action=$_POST["action"];

// this is the file with the info (emails)
//    When using the link in the top to download the complete script, a new name for this file
//    will be generated (p.e.: emaillist-2ax1fd34rfs.txt), so users will be unable to find it
$file = "../admin/mailinglist_students.txt";

// lets try to get the content of the file
if (file_exists($file)){
        // If the file is already in the server, its content is pasted to variable $file_content
        $file_content=file_get_contents($file);
}else{
        // If the file does not exists, lets try to create it
        //   In case file can not be created (probably due to problems with directory permissions),
        //   the users is informed (the first user will be the webmaster, who must solve the problem).
        $cf = fopen($file, "w") or die("Error: file does not exits, and it can not be create.<BR>Please check permissions in the directory or create a file with coresponding name.");
        fputs($cf, "devin.labadini@collegebookevolution.com");
        fclose($cf);
}

// IF REQUEST HAS BEEN TO SUBSCRIBE FROM MAILING LIST, ADD EMAIL TO THE FILE
if ($action=="subc"){
        // check whether the email is already registered
        if(strpos($file_content,"$email")){die("<span id='error'>Your email is already included in this mailing list</span><br/><br/>");}
        // write the email to the list (append it to the file)
        $cf = fopen($file, "a");
        fputs($cf, "\n$email");       // new email is written to the file in a new line
        fclose($cf);
        // notify subscription
        print "Your email has been added to our <b>students</b> mailing list.<br>Thanks for joining us. <br/><br/>";
}
// IF REQUEST HAS BEEN TO UNSUBSCRIBE FROM MAILING LIST, REMOVE EMAIL FROM THE FILE
if ($action=="unsubc"){
        // if email is not in the list, display error
        if(strpos($file_content,"$email")=== false){die("<span id='error'>Your email is not included in this mailing list</span><br/><br/>");}
        // remove email from the content of the file
        $file_content=preg_replace ("/\n$email/","",$file_content);
        // print the new content to the file
        $cf = fopen($file, "w");
        fputs($cf, $file_content);
        fclose($cf);
        // notify unsubscription
        print "Your email has been removed from our <b>students</b> mailing list.<br>Thanks for joining us. <br/><br/>";
}

?>
</p>



<?
// THIS FUNCTION WILL CHECK WHETHER AN EMAIL IS CORRECT OR NOT
//      FIRST, BASIC ARCHITECTURE IS CHECKED
//      THEM, EXISTANCE OF THE EMAIL SERVER IS CHECKED
// If email is not correct, the error message is shown and page dies
function check_email ($email, $message){
        // check if email exists
           if ($email==""){die($message);}
        // check whether email is correct (basic checking)
           $test1=strpos($email, "@");                                     //value must be >1
           $test2=strpos(substr($email,strpos($email,"@")), ".");          //value must be >1
           $test3=strlen($email);                                          //value must be >6
           $test4=substr_count ($email,"@");                               //value must be 1
           if ($test1<2 or $test2<2 or $test3<7 or $test4!=1){die($message);}
        // check whether email is correct (advance checking)
           // extracts whatever is after "@" to variable $email_server
           $email_server=substr($email,strpos($email, "@")+1);
           // Check DNS records (0 => the server exists; 1=> the server does not exist)
           if (checkdnsrr($email_server)!=1){die ($message);}
}

// THIS FUNCTION WILL SHOW THE FORM
// MODIFY IT AS REQUIRED
function print_form(){
?>

        <!-- PAGE LAYOUT -->

<html>
<head>
<title>Parents Mailing List</title>
<style type="text/css">
table.sample {
	border-width: 1px;
	border-spacing: ;
	border-color: #A9F5F2;
	border-collapse: separate;
	background-color: white;
	font-family:Arial, Helvetica, sans-serif;
	font-size:0.8em;
}
table.sample th {
	border-width: 0px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: rgb(250, 240, 230);
	-moz-border-radius: ;
}
table.sample td {
	border-width: 0px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: #FFFF99;
	-moz-border-radius: 10px;
    -webkit-border-radius: 10px;
}
span#error{
  background-color: #FFCCCC;
}

.bottom_links a{
    text-decoration: none;
    color: black;
    padding: 3px;
}

.bottom_links a:hover{
    text-decoration: underline;
}


</style>
</head>
<body>
<div align='center'>
<a href='http://www.collegebookevolution.com'><img src='../images/cbe_logo.gif' border='0' alt='College Book Evolution' /></a>

<table class='sample'width=500px><tr><td>
<div align='center' style='margin-left:10px;'>
<h2>Join our students mailing list</h2>
<p>
<!-- END OF PAGE LAYOUT -->

        <form action="<? $PHP_SELF; ?>" method="post">
          <table>
             <tr>
             <td>
                        <div align='center'><font size='2'>Enter your email address</font></div>
                        &nbsp;<input name="email" size="30" type="text"> <br>
                        <div style="text-align: center;">
                        <input name="action" value="subc" checked="checked" type="radio">Subscribe
                        <input name="action" value="unsubc" selected="" type="radio">Unsubscribe
                        <br>
                </div><br/>
                <div style="text-align: center;">
                        <input value="Submit" type="submit">
                </div>
              </td>
              </tr>
          </table>
        </form>
<!-- PAGE LAYOUT -->
</p>
</div>
</table>

<br />
<table class='sample'width=500px><tr><td>
<div align='center' style='margin-left:10px;'>
<span style='float: left; font-size: 11px;'>&copy; CollegeBookEvolution, LLC</span>
<span class='bottom_links' style='float:right; font-size: 11px;'><a href="http://www.collegebookevolution.com">Home</a> <a href="http://www.collegebookevolution.com/about">About Us</a> <a href="http://www.collegebookevolution.com/about/?ref=contact">Contact Us</a> <a href="http://www.collegebookevolution.com/help">Help</a> <a href="http://www.collegebookevolution.com/legal">Terms</a> <a href="http://www.collegebookevolution.com/legal/?ref=privacy">Policy</a></span>
</div>
</td></tr>
</table>
</div>
</body>
</html>
<!-- END OF PAGE LAYOUT -->

<?
} // the function finishes here
?>

<!-- PAGE LAYOUT -->
</p>
</div>
</table>

<br />
<table class='sample'width=500px><tr><td>
<div align='center' style='margin-left:10px;'>
<span style='float: left; font-size: 11px;'>&copy; CollegeBookEvolution, LLC</span>
<span class='bottom_links' style='float:right; font-size: 11px;'><a href="http://www.collegebookevolution.com">Home</a> <a href="http://www.collegebookevolution.com/about">About Us</a> <a href="http://www.collegebookevolution.com/about/?ref=contact">Contact Us</a> <a href="http://www.collegebookevolution.com/help">Help</a> <a href="http://www.collegebookevolution.com/legal">Terms</a> <a href="http://www.collegebookevolution.com/legal/?ref=privacy">Policy</a></span>
</div>
</td></tr>
</table>
</div>
</body>
</html>
<!-- END OF PAGE LAYOUT -->