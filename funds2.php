<?php
require('db.inc.php');
session_start(); 
$fund='';
$amount='';

///
$flag=0;
$fundcode=strtoupper($_POST['txtfundcode']);
//$fundcode=strtoupper($_POST['lstfundcode']);
$grant=$_POST['lstgrant'];
$sgrant=$_SESSION['grant'];
$fund=$_POST['txtfund'];
//$amount=intval($_POST['txtamount']);
$amount=intval(str_replace(',', '', $_POST['txtamount'])) ;
if ($sgrant!=$grant )
{
$fundcode='';
$fund='';
$amount='';
}


$_SESSION['grant']=$grant;
$cdate=date("Y/m/d");
$cyear=date('Y',strtotime($cdate));
$cyear1=$cyear-1;

$year=$_POST['lstyear'];
$emsg='';
$flag=$_POST['hdflag'];
$fc='';
$sql="select * from item_type_mf where item_type_name='$grant'";
$result=mysql_query($sql) or die("Mysql error2");
while ($row=mysql_fetch_array($result))
	   $grantcode=$row['item_type_code'];

////
 /*$sql="select * from fund where year='$year' and grant_code='$grantcode' order by fund_code";
		  $result=mysql_query($sql) or die("Error in SQL");
		  while($row=mysql_fetch_array($result))
		 
			$txtfc=$txtfc."\n".$row['fund_code'];*/
		 

//////

if ($flag==0)
{
$_SESSION['seditflag']=0;
$flag=1;
$_SESSION['grant']='';
}

//////


////////


if (isset($_POST['btnsave']) or $_POST['btnsave']=="Save")
{

$error==0 ;
$recno=0;

////

if (!is_numeric($amount)and $amount<>'' )
{$emsg="Please Enter a Numeric Value for Amount";
 $error=1;
 }


if ($amount=='')
{$emsg="Please Enter Amount";
 $error=1;
 }


if ($grant=='')
{$emsg="Please Enter Grant ";
 $error=1;
 }


if ($grant=='')
{$emsg="Please Select Grant";
 $error=1;
 }


if ($year=='')
{$emsg="Please Select Year";
 $error=1;
 }


////


if ($error==0)
{
/*$grantcode=strtoupper($grantcode);
$sql="select * from fund where fund_code='$fundcode' and  grant_code='$grantcode' and  year='$year' ";
$result=mysql_query($sql) or die("Mysql error6a");  
	$recno= mysql_num_rows($result);
	
if ($recno==0)
{
$sql1="insert into fund(year,fund_code,grant_code,amount,fund_detail) values('$year','$fundcode','$grantcode','$amount','$fund')";
	$result1=mysql_query($sql1) or die("Mysql error");
$fund='';
$amount='';
$fundcode='';
$grant='';
$_SESSION['grant']='';
}
*/
/////




   $sql="select sum(amount) as t from fund where grant_code='$grant' and year=$year";
   $result=mysql_query($sql) or die("Mysql error1q");
   while ($row=mysql_fetch_array($result))
	   $totamt=$row['t'];

///
    if ($totamt>$amount)
    {
    $tmsg1=" Rs. Funds already allocated";
    $emsg=$totamt.$tmsg1 ;
	}
////////////
     else
     {
	 echo "<script> alert ('$grant  added successfully!!'); </script>";
	 $sql1="update fund set amount='$amount' where grant_code='$grant' and year=$year" ;
      $result1=mysql_query($sql1) or die("Mysql error7"); 
      $grant='';
      $amount='';
      $fundcode='';
     $fund='';
	 $_SESSION['grant']='';
	 }
///////////////
     }      



// if ($_SESSION['seditflag']==0)
// echo "<script> alert ('Record Found in the File.  Use <Find> to get the Record')</script>";





$_SESSION['seditflag']=0;
}

////////////////

if (isset($_POST['btnedit']) or $_POST['btnedit']=="Find")
{
$fund='';
$amount='';
 $_SESSION['seditflag']=1;
 //$editbtn="disabled";
 $recno=0;
 $grantcode=strtoupper($grantcode);
/* $sql="select * from fund where fund_code='$fundcode' and year='$year' and grant_code= '$grantcode'";
 $result=mysql_query($sql) or die("Mysql error6");  
 $recno= mysql_num_rows($result);
 if($recno==0)
 echo "<script> alert ('Record Not Found')</script>";*/


 if($recno>0)
 {
 while ($row=mysql_fetch_array($result))
 {
  $fund=$row['fund_detail'];
  $amount=$row['amount'];
  }
  }
 
 }

////////////

if (isset($_POST['btnclear']) or $_POST['btnclear']=="Clear")
{
$year='';
$fundcode='';
$grant='';
$fund='';
$amount='';
$_SESSION['grant']='';

}

////////

if (isset($_POST['btnexit']) or $_POST['btnexit']=="Exit")
header("location:homeindex.php");





?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fund Register</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
<div id="header">
		<div class="wrapper clearfix">
			<div id="logo">
				<a href="index.php"><img src="images/ucsclogo.png" alt="LOGO"></a>
			</div>
			<!--ul id="navigation">
				<li class="selected">
					<a href="inventory.php">Inventory</a>
				</li>
				<li>
					<a href="purchase.php">Purchase</a>
				</li>
				<li>
					<a href="index.php">Administration</a>
				</li>
				<li>
					<a href="supplier.php">Supplier</a>
				</li>
				<li>
					<a href="index.php">Reports</a>
				</li>
			</ul-->
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
                <a href="#" style="float:left">Funds</a>
              </div>
            </div>
			<div class="dropdown">
              <button class="dropbtn">Administration</button>
              <div class="dropdown-content">
                <a href="#" style="float:left">Users</a>
                <a href="logout.php" style="float:left">Logout</a>
              </div>
            </div>
			<div class="dropdown">
              <button class="dropbtn">Reports</button>
              
            </div>
		</div>
	</div>
<!--************************************************************************************************************-->


<form id="form1" name="form1" method="post" action="" >

<table width="100%" border="0" id="cmd" style="background-color:lightblue;">
  <tr>
    <td height="28" bgcolor="#999999"><span class="style1"><span class="style6">Funds </span>
          <label for="textfield"></label>
          <input name="hdflag" type="hidden" id="hdflag" value="<?php echo $flag ;?>" />
    </span></td>
    <td colspan="2" bgcolor="#999999"><div align="right"><strong>
      <input type="submit" name="btnsave" value="Save" id="btnsave"  <?php echo $savebtn; ?> />
      </strong><strong>
        <input name="btnexit" type="submit" id="btnexit" value="Exit" />
        <input name="btnclear" type="submit" id="btnclear" value="Clear" />
    </strong></div></td>
  </tr>
  
  <tr>
    <td width="188" height="26"><strong>Year</strong></td>
    <td colspan="2"><label for="label"></label>
    <label for="label">
    <select name="lstyear" id="lstyear" onchange="submit()">
	<option selected="selected"><?php echo $year;?></option>
	<?php
	 
	echo '<option>'.$cyear.'</option>';
	echo '<option>'.$cyear1.'</option>';	  
		  
	?>
	</select>
    </label></td>
  </tr>
  
  <tr>
    <td height="26"><strong>Grant</strong></td>
    <td colspan="2"><select name="lstgrant" id="lstgrant" onchange="submit()" >
      <option selected="selected"><?php echo $grant; ?></option>
      <?php
		$sql="select * from grants order by grant_code "	;   
	     
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	    				
		echo '<option>'.$row['grant_code'].'</option>'  ;			
		
		?>
    </select></td>
  </tr>
  
  <tr>
    <td height="26"><strong>Amount</strong></td>
    <td colspan="2"><input name="txtamount" type="text" id="txtamount" value="<?php echo number_format($amount,2);?>" />
      <span style="color:#990000"><?php echo $emsg ; ?></span></td>
  </tr>
</table>
<p>
  <label for="textarea"></label>
</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p align="right">&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

 
</form>
</body>
</html>

