<?php
require('db.inc.php');

session_start(); 
$flag=0;
$cdate=date("Y/m/d");
$cyear=date('Y',strtotime($cdate));
$cyear1=$cyear-1;
$year=$_POST['lstyear'];
$proj=$_POST['lstproj'];
$dept=$_POST['lstdept'];
$grant=$_POST['lstgrant2'];
$tfundcode=$_POST['lstfundcode'];
$itype=$_POST['lstgrant'];
$sgrant=$_SESSION['itype'];
$loguser = $_SESSION["username"];
$amount=intval(str_replace(',', '', $_POST['txtamount'])) ;

if ($sgrant!=$itype ){
$tfundcode='';
$dept='';
$proj='';
$amount='';
}
$_SESSION['itype']=$itype;

$flag=$_POST['hdflag'];
$emsg='';

if (isset($_POST['btnclear']) or $_POST['btnclear']=="Clear"){
$year='';
$tfundcode='';
$grant='';
$itype='';
$proj='';
$dept='';
$prog='';
$amount='';
$_SESSION['itype']='';
}
$proj1=addslashes(trim($proj));

$sql="select * from division_masterfile where div_name='$proj1'";
$result=mysql_query($sql) or die("Mysql error1q");
while ($row=mysql_fetch_array($result))
	   $faccode=$row['div_code'];
		$dept1=addslashes(trim($dept));
$sql="select * from unit_masterfile where unit_name='$dept1' and div_code= '$faccode'";
$result=mysql_query($sql) or die("Mysql error23");
while ($row=mysql_fetch_array($result))
	   $deptcode=$row['unit_code'];
$sql="select * from item_type where item_type_name='$itype'";
$result=mysql_query($sql) or die("Mysql error24");
while ($row=mysql_fetch_array($result))
	   $itypecode=$row['item_type_code'];
$sql="select * from grants where grant_name='$grant'";
$result=mysql_query($sql) or die("Mysql error2");
while ($row=mysql_fetch_array($result))
	   $grantcode=$row['grant_code'];

if ($flag==0){
$_SESSION['seditflag']=0;
$flag=1;
$_SESSION['itype']='';
}

if (isset($_POST['btnedit']) or $_POST['btnedit']=="Find"){
$_SESSION['seditflag']=1;
$sql="select * from fund_detail where grant_code='$grant' and  year='$year' and div_code='$faccode' and unit_code='$deptcode' ";
$result=mysql_query($sql) or die("Mysql error1q");
$recno= mysql_num_rows($result);
if($recno==0){
	echo "<script> alert ('No funds allocated for the entered criteria!')</script>";
	/* $year='';
	$tfundcode='';
	$grant='';
	$itype='';
	$proj='';
	$dept='';
	$prog='';
	$amount=''; */
}
if($recno>0){
while ($row=mysql_fetch_array($result))
$amount=$row['amount'];
}
}

if (isset($_POST['btnsave']) or $_POST['btnsave']=="Save"){
$error==0 ;
$recno=0;
if (!is_numeric($amount)and $amount!='' ){
$emsg="Please Enter a Numeric Value for Amount";
$error=1;
}

if ($amount==''){
$emsg="Please Enter Amount";
$error=1;
}

if ($grant==''){
$emsg="Please Select Grant";
$error=1;
}

if ($proj==''){
$emsg="Please select division";
$error=1;
}

if ($itype==''){
$emsg="Please select item type";
$error=1;
}

if ($year==''){
$emsg="Please Select Year";
$error=1;
}

if ($error==0){
$fundamt=0;
$totamt=0;

$sql="select * from fund where grant_code='$itypecode' and year='$year'";
$result=mysql_query($sql) or die("Mysql error1q");
while ($row=mysql_fetch_array($result))
	   $fundamt=$row['amount'];
}

if ($error==0){
$fgiven=0;
}
if ($error==0){
$proj1=addslashes(trim($proj));

$sql="select * from division_masterfile where div_name='$proj1'";
$result=mysql_query($sql) or die("Mysql error4q");
while ($row=mysql_fetch_array($result))
	   $faccode=$row['div_code'];
	   $dept1=addslashes(trim($dept));

$sql="select * from unit_masterfile where unit_name='$dept1' and div_code= '$projcode'";
$result=mysql_query($sql) or die("Mysql error2");
while ($row=mysql_fetch_array($result))
	   $deptcode=$row['unit_code'];
	   $itypecode=strtoupper($itypecode);
$recno=0;


$sqlfund="select sum(amount) as t from fund_detail where grant_code='$grant' and year='$year'";
$resultfund=mysql_query($sqlfund) or die("Mysql error2");
while ($rowfund=mysql_fetch_array($resultfund))
	   $curfund=$rowfund['t'];
echo "<script> alert ('Current allocation from $grant to $year is Rs.$curfund'); </script>";
if($curfund!=0){
$sqlfund2="SELECT `amount` FROM `fund` WHERE `grant_code`='$grant' and `year`='$year'";
$resultfund2=mysql_query($sqlfund2) or die("Mysql error2");
while ($rowfund2=mysql_fetch_array($resultfund2))
	   $curfund2=$rowfund2['amount'];
	//$totfund=$curfund2+$amount;
	$tottoalloc=$curfund+$amount;
	   //echo "<script> alert ('Current allocation from $grant to $year is Rs.$totfund'); </script>";
if($curfund2<$tottoalloc){
echo "<script> alert ('$tottoalloc Exeeds allocated amount $curfund2'); </script>";
$year='';
$tfundcode='';
$grant='';
$itype='';
$proj='';
$dept='';
$prog='';
$amount='';
}
else{

$sqlt="select * from fund_detail where year=$year and grant_code='$grant' and div_code='$faccode' and unit_code='$deptcode'";
$resultt=mysql_query($sqlt) or die("Mysql error6a");  
	$recno= mysql_num_rows($resultt);

$d=strftime("%Y-%m-%d %H:%M:%S"); 
if ($recno==0){
$sql1="insert into fund_detail(year,grant_code,itype_code,div_code,unit_code,amount,user_add,user_add_date) values('$year','$grant','$itypecode','$faccode','$deptcode','$amount','$loguser','$d')";
$result1=mysql_query($sql1) or die("Mysql error");

$proj='';
$dept='';
$prog='';
$itype='';
$tfundcode='';
$amount='';
$grant='';
echo "<script> alert ('Funds added successfully! ')</script>";
$_SESSION['itype']='';
}

if ($recno>0){
if ($_SESSION['seditflag']==1){
$sql1="update fund_detail set amount='$amount',user_mod='$loguser',user_mod_date='$d' where year='$year' and grant_code='$grant' and div_code='$faccode' and unit_code='$deptcode'" ;
$result1=mysql_query($sql1) or die("Mysql error7"); 

$proj='';
$dept='';
$prog='';
$itype='';
$tfundcode='';
$amount='';
$grant='';
echo "<script> alert ('Funds added successfully! ')</script>";
$_SESSION['itype']='';
}}
}

if ($_SESSION['seditflag']==0)
//echo "<script> alert ('Similar record found.  Click current amt. to update record.')</script>";
echo "<script> alert ('Could not add funds.')</script>";
}}
$_SESSION['seditflag']=0;
}

if (isset($_POST['btnexit']) or $_POST['btnexit']=="Exit")
header("location:homeindex.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">

var xmlhttp;

function stateChanged()
{
  if (xmlhttp.readyState==4)
  {
  document.getElementById("txtaddress").innerHTML=xmlhttp.responseText;
  }
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 

</script>
<title>Fund Allocation</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
<div id="header">
		<div class="wrapper clearfix">
			<div id="logo">
				<a href="index.php"><img src="images/ucsclogo.png" alt="LOGO"></a>
			</div>
			
			<div class="dropdown">
              <button class="dropbtn">Inventory</button>
              <div class="dropdown-content">
                <a href="inventory.php" style="float:left; border-right:thin; border-right-color:#00F">Items</a>
                <a href="maincategory.php">Category</a>
                <a href="subcatregistry.php" style="float:left">Sub category</a>
              </div>
            </div>
			<div class="dropdown">
              <button class="dropbtn">Supplier</button>
              <div class="dropdown-content">
                <a href="supplier.php" style="float:left">Supplier registry</a>
                <a href="supcategory.php" style="float:left">Category</a>
              </div>
            </div>
            <div class="dropdown">
              <button class="dropbtn">Funds</button>
              <div class="dropdown-content">
                <a href="funds.php" style="float:left">Funds registry</a>
                <a href="fundallocate.php" style="float:left">Allocation</a>
              </div>
            </div>
			<div class="dropdown">
              <button class="dropbtn">Purchase</button>
              <div class="dropdown-content">
                <a href="purchase.php" style="float:left">PO</a>
              </div>
            </div>
            <div class="dropdown">
              <button class="dropbtn">Good Receival</button>
              <div class="dropdown-content">
                <a href="GRN.php" style="float:left">GRN</a>
                <a href="GIN.php" style="float:left">GIN</a>
              </div>
            </div>
			<div class="dropdown">
              <button class="dropbtn">Administration</button>
              <div class="dropdown-content">
              	<a href="division.php" style="float:left">Divisions</a>
                <a href="units.php" style="float:left">Units</a>
                <a href="reports.php" style="float:left">Reports</a>
                <a href="adduser.php" style="float:left">Users</a>
                <a href="logout.php" style="float:left">Logout</a>
              </div>
            </div>
			</div>
	</div>
<!--************************************************************************************************************-->


<form id="form1" name="form1" method="post" action="" >
<table width="100%" border="0" id="cmd" style="background-color:lightblue;">
    <tr>
    <td colspan="4" align="center"><span class="title"><strong>Fund Allocation</strong></span>
          <label for="textfield"></label>
          <input name="hdflag" type="hidden" id="hdflag" value="<?php echo $flag ;?>" />
    </td>
  </tr>
  
  <tr><td width="15%"></td>
    <td width="226" height="26">Year</td>
    <td><label for="label"></label>
    <label for="label">
    <select name="lstyear" id="lstyear" onchange="submit()" class="styleselect1">
      <option selected="selected"><?php echo $year;?></option>
      <?php
	 
	echo '<option>'.$cyear.'</option>';
	?>
    </select>
    </label></td>
  </tr>
  <tr><td width="15%"></td>
    <td height="29">Item type</td>
    <td><select name="lstgrant" id="lstgrant" onchange="submit()" class="styleselect1">
      <option selected="selected"><?php echo $itype; ?> </option>
      <?php
		$sql="select * from item_type order by item_type_name "	;   
	     
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	    				
		echo '<option>'.$row['item_type_name'].'</option>'  ;			
		
		?>
    </select></td>
  </tr>
  <tr><td width="15%"></td>
    <td height="29">Grant</td>
    <td><select name="lstgrant2" id="lstgrant2" onchange="submit()" class="styleselect1" >
      <option selected="selected"><?php echo $grant; ?></option>
      <?php
		$sql="select * from grants order by grant_code "	;   
	     
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	    				
		echo '<option>'.$row['grant_code'].'</option>'  ;			
		
		?>
    </select></td>
  </tr>
  <tr><td width="15%"></td>
    <td height="29">Division</td>
    <td><select name="lstproj" size="1" id="lstproj"  onchange="submit()" class="styleselect1">
      <option selected="selected"><?php echo $proj; ?></option>
      <?php
	  	 
	  		$sql="select * from division_masterfile order by div_name ";
	  					
		  $result=mysql_query($sql) or die("Error in SQL");
		  while($row=mysql_fetch_array($result))
		  {
		  	echo '<option>'.$row['div_name'].'</option>' ;  
		  }
		 ?>
    </select>      <div align="center"></div></td>
    </tr>
  <tr><td width="15%"></td>
    <td height="29">Unit</td>
    <td><select name="lstdept" size="1" id="lstdept" onchange="submit()" class="styleselect1">
      <option selected="selected"><?php echo $dept;?></option>
      <?php 
		
		 $q1=addslashes(trim($proj)); 
			
		$sql="select * from division_masterfile where div_name='$q1'"	; 

	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	   
	   $pcode=$row['div_code'];
		$sql="select * from unit_masterfile where div_code='$pcode' order by unit_name ";
		
		  $result=mysql_query($sql) or die("Error in SQL");
		  while($row=mysql_fetch_array($result))
		  echo '<option>'.$row['unit_name'].'</option>' ;  
?>
    </select></td>
    </tr>
  
  <tr><td width="15%"></td>
    <td height="28">Amount to be added</td>
    <td><input name="txtamount" type="text" id="txtamount" value="<?php echo number_format($amount,2);?>" />
      <span style="color:#990000"><?php echo $emsg ; ?></span> </td>
  </tr><tr height="50px"></tr>
  <tr><td height="26" colspan="4" align="right" style="padding-right:595px">
  <input name="btnedit" type="submit" onclick="" id="btnedit" value="Current amt." class="btn2" />
  <input class="btn2" type="submit" name="btnsave" value="Save" id="btnsave"  <?php echo $savebtn; ?> />
			<input name="btnclear" class="btn2" type="submit" id="btnclear" value="Clear" /></td>
	</tr>
</table>
<p>
  <label for="textarea"></label>
</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

 
</form>
</body>
</html>

