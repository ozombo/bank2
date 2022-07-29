<?php
define('INCLUDE_CHECK',1);
include 'coreengine.php';
session_start(); 
mysql_query("UPDATE userz SET
			`last_login` = '".date("U")."'
			 WHERE id='$_SESSION[user_id]'
			") or die(mysql_error());
unset($_SESSION['user_id']);
setcookie("cookname", '', time()-60*60*24*60, "/");
header("Location: index.php");

?>
