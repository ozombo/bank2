<?php
 //secure coreengine inclusion
 define('INCLUDE_CHECK',1);

 //call coreengine files for site controller
 include 'coreengine.php';


 //secure this page for loggedin users only
 page_protect();

 $getaccounts = mysql_query("select * from userz order by id DESC") or die(mysql_error());

 // Add new account
 if (isset($_POST['fund']))
{ 




if(empty($_POST['receiver']) OR 
   empty($_POST['sender']) OR 
   empty($_POST['amount']) ) {


$msg = urlencode("Fund! You have left important fields empty. Please start over.");
header("Location: fund.php?msg=$msg&type=error");
} else {


$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');



$sender = mysql_real_escape_string($_POST['sender']);
$receiver = mysql_real_escape_string($_POST['receiver']);
$date = mysql_real_escape_string($_POST['date']);
$amount = mysql_real_escape_string($_POST['amount']);
$status = mysql_real_escape_string($_POST['status']);




$sql_insert = "INSERT into `incoming`
  			(`sender`,`receiver`,`date`,`amount`,`status`)
		    VALUES
		    ('$sender','$receiver','$date','$amount','$status')
			";

mysql_query($sql_insert) or die("Insertion Failed:" . mysql_error()); 

header("Location: fund.php");

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
  <label for="sender">Sender:</label><br>
  <input type="text" id="sender" name="sender" value=""><br>
  <label for="receiver">Receiver:</label><br>
 <select name = "receiver" id = "receiver">
 <?php while ($accountrow = mysql_fetch_array($getaccounts)) {
      $receiver_name = $accountrow['name'];
      $receiver_id = $accountrow['id'];
    ?>
  <option value="<?php echo "$receiver_id"; ?>"><?php echo "$receiver_name"; ?></option>

<?php } ?>
 </select><br />
  <label for="date">Date:</label><br>
  <input type="text" id="date" name="date" value=""><br>
  <label for="amount">Amount(without comma):</label><br>
  <input type="text" id="amount" name="amount" value=""><br>
  <label for="status">Status(1 for cleared, 2 for pending):</label><br>
  <input type="text" id="status" name="status" value=""><br><br />
  <input type="submit" name = "fund" value="Submit">
</form> 
</body>
</html>