<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    include '../layout/external_info_layout.html';
?>
<div id="header">
    <div class='main_logo'>
    <div align='center'>
    	<a href="/"><img src="../images/page/full_logo.png" style="border-style:none;" /></a>
    </div>
    </div>
</div>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="selectuser.js"></script>
<style type='text/css'>
body{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
}

div.action{
  padding: 10px;
  background-color: #FFFF99;
  	-moz-border-radius: 10px;
    -webkit-border-radius: 10px;
}


</style>

<title>CBE Administration</title>
</head>


<body>
<table align="center" cellpadding='15px'>
<tr valign='top'><td  width='500px'>

<h2>What do you want to do?</h2>
<ul>
<!-- NEWSLETTER -->
<li>
<a href='http://www.collegebookevolution.com/admin/phpmassmail.php'>Send Newsletter</a>
</li>
<!-- ACTIVATE PENDING ACCOUNT -->
<li><a href='javascript:void;' onClick='togglediv("activate_pending");'>Activate Pending Account</a></li>
<div class='action' id='activate_pending' style='display:none; position:relative;'>
<form>
<h2>Activate Pending Account</h2>
Enter registration code:
<input type="text" id="regcode" name="regcode" onkeyup="showUser(this.value, 'txtHint')" />
</form>
<br />
<div id="txtHint">User information will be listed here.</div>
<br />
<input type="button" id="reguser" name="reguser" value="Activate Account" onclick="activateAccount(document.getElementById('regcode').value, 'actHint')" />
<br /><br/>
<div id="actHint">Result:</div>
</div>

<!-- UPGRADE FREE ACCOUNT -->
<li><a href='javascript:void;' onClick='togglediv("upgrade_account");'>Upgrade Account</a></li>
<div class='action' id='upgrade_account' style='display:none; position:relative;'>
<form>
<h2>Upgrade Account</h2>
Enter username
<input type='text' id='freeuser' name='freeuser' onKeyup='showFreeUser(this.value, "userInfo")' />
&nbsp;Years: <input type='text' id='years' name='years' size='2' /> (check Paypal invoice)
</form>
<br />
<div id='userInfo'>Free Account user information</div><br />
<input type='button' id='upgradeAccount' name='upgradeAccount' value='Upgrade Account' onClick="upgradeAccount(document.getElementById('freeuser').value, document.getElementById('years').value, 'userInfo')" />
<br /><br />
<div id="upgradeResult">Result:</div>
</div>

<!-- MAKE MEMBER A MARKETER -->
<li><a href='javascript:void;' onClick='togglediv("make_marketer");'>Make Marketer</a></li>
<div class='action' id='make_marketer' style='display:none; position:relative;'>
<form>
<h2>Make Marketer</h2>
Enter username
<input type='text' id='user2mkter' name='user2mkter' onKeyup='memberInfo(this.value, "memberInfo")' />
</form>
<br/>
<div id='memberInfo'>Member information will be listed here.</div>
<br/>
<input type='button' id='makemarketer' name='makemarketer' value='Make Marketer' onClick="makeMarketer(document.getElementById('user2mkter').value, 'memberInfo')" />
</div>

<!-- REMOVE MEMBER -->
<li><a href='javascript:void;' onClick='togglediv("delete_account");'>Delete Account</a></li>
<div class='action' id='delete_account' style='display:none; position:relative;'>
<h2>Delete Account</h2>
Enter username
<input type='text' id='user2remove' name='user2remove' onKeyup='memberInfo(this.value, "member2remove")' />
<br/>
<div id='member2remove'>Member information will be listed here.</div>
<br/>
<input type='button' id='removemember' name='removemember' value='Remove Member' onClick="deleteAccount(document.getElementById('user2remove').value, 'member2remove')" />
</div>

<!-- ADD SCHOOL -->
<li><a href='javascript:void;' onClick='togglediv("add_new_school");'>Add New School</a></li>
<div class='action' id='add_new_school' style='display:none; position:relative;'>
<h2>Add New School</h2>
Name (eg. ABC University):<br/>
<input type='text' id='name' name='name' /><br/>
State (eg. AB):<br/>
<input type='text' id='state' name='state' /><br/>
Email (eg. abc.uni.edu): <br/>
<input type='text' id='email' name='email' /><br/> 

<br/>
<div id='newschoolinfo'>Result:</div>
<br/>
<input type='button' id='addschool' name='addschool' value='Add School' onClick="addSchool(document.getElementById('name').value, document.getElementById('state').value, document.getElementById('email').value, 'newschoolinfo')" />
</div>
</ul>

</td>
</tr>
</table>


</body>
</html>
