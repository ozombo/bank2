<?php
 //secure coreengine inclusion
 define('INCLUDE_CHECK',1);

 //call coreengine files for site controller
 include 'coreengine.php';


 //secure this page for loggedin users only
 page_protect();

 // Add new account
 if (isset($_POST['add']))
{ 




if(empty($_POST['name']) OR 
   empty($_POST['password']) OR 
   empty($_POST['email']) ) {


$msg = urlencode("Create error! You have left important fields empty. Please start over.");
header("Location: add.php?msg=$msg&type=error");
} else {


$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');



$name = mysql_real_escape_string($_POST['name']);
$state = mysql_real_escape_string($_POST['state']);
$city = mysql_real_escape_string($_POST['city']);
$email = mysql_real_escape_string($_POST['email']);
$password = mysql_real_escape_string(md5($_POST['password']));
$country = mysql_real_escape_string($_POST['country']);
$zip = mysql_real_escape_string($_POST['zip']);
$year = mysql_real_escape_string($_POST['year']);
$type = mysql_real_escape_string($_POST['type']);
$accountnumber = mysql_real_escape_string($_POST['accountnumber']);
$accountbranch = mysql_real_escape_string($_POST['accountbranch']);

$rs_duplicate = mysql_query("select count(*) as total from userz where email = '$email' ") or die(mysql_error());
list($total) = mysql_fetch_row($rs_duplicate);

if ($total > 0)
{
$msg = urlencode("Create ERROR! That account already exists on $appname.");
header("Location: add.php?msg=$msg&type=error");
exit();
}



$sql_insert = "INSERT into `userz`
  			(`name`,`state`,`city`,`email`,`password`,`country`,`zip`,`year`,`account_type`,`account_number`,`account_branch`)
		    VALUES
		    ('$name','$state','$city','$email','$password','$country','$zip','$year','$type','$accountnumber','$accountbranch')
			";

mysql_query($sql_insert) or die("Insertion Failed:" . mysql_error()); 

header("Location: admin.php");

	} 
}
?>
<html>
<head>
    <title>Admin panel</title>
</head>
<body>
<ul>
    <li><a href = "admin.php">Admin Home</a></li>
    <li><a href = "fund.php">Fund User</a></li>
    <li><a href = "logout.php">Logout</a></li>
</ul>
<h2>Create a new user below</h2>
<br />
<form action="" method = "POST">
  <label for="name">Fullname:</label><br>
  <input type="text" id="name" name="name" value=""><br>
  <label for="state">Sate:</label><br>
  <input type="text" id="state" name="state" value=""><br>
  <label for="city">City:</label><br>
  <input type="text" id="city" name="city" value=""><br>
  <label for="email">Email:</label><br>
  <input type="text" id="email" name="email" value=""><br>
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" value=""><br>
  <label for="country">Country:</label><br>
  <input type="text" id="country" name="country" value=""><br>
  <label for="zip">Zip:</label><br>
  <input type="text" id="zip" name="zip" value=""><br>
  <label for="year">Year:</label><br>
  <input type="text" id="year" name="year" value=""><br>
  <label for="type">Account type:</label><br>
  <input type="text" id="type" name="type" value=""><br>
  <label for="accountnumber">Account Number:</label><br>
  <input type="text" id="accountnumber" name="accountnumber" value=""><br>
  <label for="accountbranch">Account Branch:</label><br>
  <input type="text" id="accountbranch" name="accountbranch" value=""><br><br>
  <input type="submit" name = "add" value="Submit">
</form> 
</body>
</html>