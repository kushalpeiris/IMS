<?php
$fndcode='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
</style>
</head>

<body>
<strong><span>Grant</span></strong><strong>
<select name="lstfund" id="lstfund"  onchange="submit()" class="styleselect1">
  <option selected="selected"><?php echo $fund;?></option>
  <?php
	   
	   $sql1="SELECT distinct(`grant_code`) FROM `fund_detail` WHERE `itype_code`='$titypecode' and `year`='$cyear'";
		  $result1=mysql_query($sql1) or die("Error in SQL");
		  while($row=mysql_fetch_array($result1))
		 {
 $fndcode=$row['grant_code'];
             echo '<option>'.$fndcode.'</option>' ;   
}
?>
</select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong><span>Allocation</span></strong>
<select name="lstfdept" id="lstfdept" onchange="submit()" class="styleselect1">
  <option selected="selected"><?php echo $funddept; ?></option>
  <?php
	$sql="select * from fund_detail where grant_code='$fund' and year='$cyear' and div_code='$tfaccode'  and  `itype_code`='$titypecode' ";
	$result=mysql_query($sql) or die("Mysql error2");
	while ($row=mysql_fetch_array($result)){
	  $tffaccode=$row['div_code'];
	  $tfdeptcode=$row['unit_code'];
		$tfamt=$row['amount'] ;
	  $tffac='';
	  $tfdept='';
	  $tfprog='';
	
	$sql1="select * from division_masterfile where div_code='$tffaccode'";
	$result1=mysql_query($sql1) or die("Mysql errorq");
	while ($row=mysql_fetch_array($result1))
	$tffac=$row['div_name'] ;
	 
	$sql1="select * from unit_masterfile where unit_code='$tfdeptcode'";
	$result1=mysql_query($sql1) or die("Mysql errorq");
	while ($row=mysql_fetch_array($result1))
	$tfdept=$row['unit_name'] ;

///////////////////////////////////////////
$more=0;
$less=0;

$sql1="select sum(fund_amount) as t from purch_ord_mas where fund_code='$fund' and item_type_code='$titypecode' and pom_acct_yr='$cyear' and fund_fac='$tffaccode' and fund_dept='$tfdeptcode' and pom_cancel<>'Y' and (fund_avail='Y' or po_approved='Y')   and !(pom_po_no='$tn' and pom_acct_yr='$tyear')";		
$result1=mysql_query($sql1) or die("Mysql error1q");
while ($row=mysql_fetch_array($result1))
$ttotfnd=$row['t'];
$tavailable = $tfamt + $less  - ($ttotfnd + $more) ;
{
	if ($tffac<>'' and $tfprog<>'' and $tfdept<>'')
	if ($tavailable>0)
	echo '<option>'.$tffac.' | '.$tfdept.' | '.$tfprog.' | ('.number_format($tavailable,2).')'.'</option>' ;  
	else
	echo '<option>'.$tffac.' | '.$tfdept.' | '.$tfprog.'|      ***** ('.number_format($tavailable,2).')'.'</option>' ;  
	
	if ($tfprog=='' and $tfdept<>'' and $tffac<>'')
	if ($tavailable>0)
	echo '<option>'.$tffac.' | '.$tfdept.' | ('.number_format($tavailable,2).')'.'</option>' ;  
	else
	echo '<option>'.$tffac.' | '.$tfdept.' | '.'      *****  ('.number_format($tavailable,2).')'.'</option>' ;  
	  	
	if ($tfprog=='' and $tfdept=='' and $tffac<>'')
	if ($tavailable>0)
	echo '<option>'.$tffac.' | ('.number_format($tavailable,2).')'.'</option>' ;  
else
echo '<option>'.$tffac.' |    ***** ('.number_format($tavailable,2).')'.'</option>' ;  
	}
	}
	?>
</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="color:#000"><?php echo  ('Rs.  '. number_format($totval,2)) ; ?></span></strong>
</body>
</html>
