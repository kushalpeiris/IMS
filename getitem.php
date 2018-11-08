<?php
require('getconnection.php');
$q=$_GET["q"];

///
$q1=addslashes(trim($q)); 
$sql="select * from item_type_mf  where item_type_name='$q1'"	;   
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	   $icode=$row['item_type_code'];

echo '<option>'.''.'</option>'  ;

 	$sql="select * from item_masterfile  where item_type_code='$icode' order by item_description"	;   
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	   
	     	   
echo '<option>'.$row['item_description'].'</option>'  ;

		   ?>