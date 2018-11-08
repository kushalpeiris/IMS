<?php
define("USER","imsuser");
define("PWD","Ucsc@123#");
define("HOST","localhost");
define("DB","imsdb");

//connect to DataBase
$conn=mysql_connect(HOST,USER,PWD) or die (header('location:error.php?err='.mysql_error()));

//select DB
mysql_select_db(DB) or (header('location:error.php?err='.mysql_error()));
?>
