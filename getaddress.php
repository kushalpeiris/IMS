<?php
require('getconnection.php');
$q=$_GET["q"];


//$ts=substr($q,0,5);

	//	$sql="select * from supplier where supplier_code='$ts'"	;   
	  
	  $sql="select * from supplier where supplier_name='$q'"	; 
	  
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	   {
	  echo $row['supplier_address1']."\n".$row['supplier_address2']."\n".$row['supplier_address3'] ."\n". $row['sup_address4'];
}

   
		   ?>
		   
		   
