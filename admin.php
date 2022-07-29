<?php
 //secure coreengine inclusion
 define('INCLUDE_CHECK',1);

 //call coreengine files for site controller
 include 'coreengine.php';


 //secure this page for loggedin users only
 page_protect();

?>
<html>
<head>
    <title>Admin panel</title>
</head>
<body>
<ul>
<li><a href = "admin.php">Admin Home</a></li>
<li><a href = "add.php">Add User</a></li>
    <li><a href = "fund.php">Fund User</a></li>
    <li><a href = "logout.php">Logout</a></li>
</ul>
</body>
</html>