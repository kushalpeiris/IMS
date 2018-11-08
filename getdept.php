<?php
require('getconnection.php');
$q=$_GET["q"];
//Commerce and  Management

$q1=addslashes(trim($q)); 
$sql="select * from division_masterfile where div_name='$q1'"	;   
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	   
	   $pcode=$row['div_code'];



echo '<option>'.''.'</option>'  ;
		$sql="select * from unit_masterfile where dvi_code='$pcode' order by unit_name"	;   
	   $result=mysql_query($sql) or die("Error in SQL");
	   //
	   
	   //
	   while ($row=mysql_fetch_array($result))
	     echo '<option>'.$row['unit_name'].'</option>'  ;

	   
		   ?>