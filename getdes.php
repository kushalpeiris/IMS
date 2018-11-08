<?php
require('getconnection.php');
$q=trim($_GET["q"]);


///
$q1=addslashes(trim($q)); 
$sql="select *  from item_masterfile where item_description='$q1'";

$result=mysql_query($sql) or die("Mysql error");
while ($row=mysql_fetch_array($result))
$icd=$row['item_code'];


////


echo $icd; 

  ?>
		   
		   
