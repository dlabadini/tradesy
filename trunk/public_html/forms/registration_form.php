<?php
if (isset($_POST['submit'])){

if (isset($_POST['email'])){
// get the post data into the session
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] =  md5($_POST['password']);
	$_SESSION['schstate'] =  $_POST['schstate'];
	$_SESSION['schname'] =  $_POST['schname'];
	$_SESSION['email'] =  $_POST['email'];
	$_SESSION['location'] = $_POST['location'];
}

		$reg_error = validate_registration($_POST['name'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['confpassword'], $_POST['schstate'], $_POST['schname'], $_POST['location']);

    // Everything is ok, register
	  if ($reg_error == ""){
        // generate validation code
        $valcode = rand(10000, 99999);

        // create account
        $salt = generate_salt();
		$psswd = md5(md5($_POST['password']) . $salt);
		$res = setup_user_account($valcode, $_POST['name'], $_POST['username'], $psswd, $_POST['schstate'], $_POST['schname'], $_POST['email'], $_POST['location'], $salt);

        // send email
        $mail = $_POST['email'];
        send_validation_code($mail, $valcode);

        // display the validation page
        include 'validate.php';

  		exit;
	  }
}
?>
<!--
<link href="css/master.css" rel="stylesheet" type="text/css" />
<div align="center">
<a href="/workshop" style="text-decoration:none"><img src="images/logo.gif" width="594" height="42" alt="logo" border="0"/></a>
</div>
-->
<script type="text/javascript" src="scripts/classfunctions.js"></script>
<div align="center" class="main-font">

<?php $page_title = "Registration Information"; ?>
<?php if (isset($reg_error)) { ?>
<font style="background-color:#FF3;"><?php echo $reg_error; ?></font>
<?php } else { ?>
	Complete the form below and click the Register button to continue
<?php }?>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="addmember" target="_self">
<table border="0" cellpadding="3" class="main-font wob-font">
  <tr><br />
    <td align="right">Full Name:</td>
    <td align="left"><input class="textbox" name="name" maxlength="100" type="text"
    <?php if (isset($_POST['name'])) { ?> value="<?php echo $_POST['name']; ?>" <?php } ?> /></td>
  </tr>
   <tr>
    <td align="right">Username:</td>
    <td align="left"><input class="textbox" name="username" type="text" maxlength="15"
    <?php if (isset($_POST['username'])) { ?> value="<?php echo $_POST['username']; ?>" <?php } ?> />
    <br><span id="subscript">6-15 chars max</span></td>
  </tr>
  <tr>
    <td align="right">Password:</td>
    <td align="left"><input class="textbox" name="password" type="password" maxlengh="32"/><br/><span id="subscript">6+ chars, alpha-numeric, mixed-case</span></td>
  </tr>
  <tr>
    <td align="right">Confirm Password:</td>
    <td align="left"><input class="textbox" name="confpassword" type="password" /></td>
  </tr>
  <tr>
    <td align="right">School State:</td>
	<td align="left">

    <select id='schstates' class="textbox" name="schstate" onChange="LoadSchools(this, 'schoolname')">
		<option selected>-- Select --</option>
        <?
            $sql = "SELECT state FROM schools ORDER BY state ASC";
            $states = mysql_query($sql);
            while ($row = mysql_fetch_array($states)){
              echo "<option value='" . $row['state'] . "'>" . $row['state'] . "</option>";
            }
        ?>
	</select>
    </td>

  </tr>
  <tr>
    <td align="right">School Name:</td>
	<td align="left">
    <div id='schoolname'>
	    <select class='textbox' name="schname">
            <option>-- Select --</option>
        </select>
    </div>

    </td>
  </tr>
  <tr>
    <td align="right">Email:</td>
    <td align="left"><input class="textbox" id="email" name="email" maxlength="256" type="text"
    <?php if (isset($_POST['email'])) { ?> value="<?php echo $_POST['email']; ?>" <?php } ?> /><br><span id="subscript">School Email address</span></td>
  </tr>
  <tr>
    <td align="right">Current Location:</td>
    <td align="left"><input class="textbox" id="location" name="location" maxlength="30" type="text"
    <?php if (isset($_POST['location'])) { ?> value="<?php echo $_POST['location']; ?>" <?php } ?> /><br><span id="subscript">Where you live (eg. College Park)</span></td>
  </tr>
</table><br/>
 <input type="hidden" name="subscription" value="defunct" />
 <input type="submit" name="submit" value="Register" />
</form>
</div>
