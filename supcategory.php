<?php 
session_start();
include("db.inc.php");

extract($_POST);
$tcurrentdate= $_SESSION["currentdate"];
$tusername = $_SESSION["username"];
$tdatetime=strftime("%Y-%m-%d %H:%M:%S");

$ct=0;
$sql="SELECT max(sup_cat_code)+1 as maxSupCode FROM `supplier_category`";
$result = mysql_query($sql) or die("max code error ");
if($row=mysql_fetch_assoc($result)){
	$scCodeNo="0000".$row['maxSupCode'];
	}

//************************************************************************************************
if (isset($_POST['btnAdd']) || $_POST['btnAdd']=="Add")
{
	$txtSCatCode=ltrim($scCodeNo,'0');
	$txtSCatCode=str_pad($txtSCatCode,6,0,STR_PAD_LEFT);
	$txtASCatName=addslashes(trim($txtASCatName));
	$sql= "SELECT count(*) as rowcount FROM `supplier_category` WHERE `sup_cat_code`='$txtSCatCode' or `sup_cat_name`='$txtASCatName'";
	$result= mysql_query($sql) or die("");
	$row=mysql_fetch_assoc($result);
	if ($row['rowcount']!=0)
	{
		echo "<script>alert('Record Exsist!');</script>";
	}
	else
	{
		$txtSCatCode=str_pad($txtSCatCode,6,0,STR_PAD_LEFT);
		$sql1="INSERT INTO `supplier_category`(`sup_cat_code`, `sup_cat_name`,`user_add`,`user_add_date`) VALUES ('$txtSCatCode','$txtASCatName','$tusername','$tcurrentdate')";
		mysql_query($sql1) or die(mysql_error());
		echo "<script> alert ('Supplier Category $txtSCatCode Added Successfully!!'); </script>";	
		$txtSCatCode="";
		$txtASCatName="";	
		$sql="SELECT max(sup_cat_code)+1 as maxSupCode FROM `supplier_category`";
		$result = mysql_query($sql) or die("max code error ");
		if($row=mysql_fetch_assoc($result)){
		$scCodeNo="0000".$row['maxSupCode'];
	}
	}
	
}
	
//***********************************************************************************
if (isset($_POST['btnFind']) || $_POST['btnFind']=="Find")
{
	$scatCode=trim($txtSCatCode);
	$sql="SELECT count(*) as rowcount,`sup_cat_code`,`sup_cat_name` FROM `supplier_category` WHERE `sup_cat_code`='$scatCode'"; 
	$result=mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_array($result);
	if ($row[rowcount]==0)
	{
		echo "<script> alert('No Record Found!');</script>";
		$ct=1;
		$txtASCatName="";
	}
	else
	{
	$scCodeNo=$row['sup_cat_code'];
	$txtASCatName= $row['sup_cat_name'];
	$ct=2;
	}
}

//**********************************************************************************
if (isset($_POST['btnEdit']) || $_POST['btnEdit']=="Edit")
{
	$sql="UPDATE `supplier_category` SET `sup_cat_code`='$txtSCatCode', `sup_cat_name`='$txtASCatName',`user_mod`='$tusername',`user_mod_date`='$tcurrentdate' WHERE `sup_cat_code`= '$txtSCatCode'";
	mysql_query($sql) or die(mysql_error());
	echo "<script> alert('Record Updated successfully!'); </script>" ;
	$txtSCatCode="";
	$txtASCatName="";
}

//************************************************************************************
if (isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
{
	$txtSCatCode="";
	$txtASCatName="";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Supplier Category Information</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

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

<script>

function validateform()
{
	tsupcatcode = document.getElementById('txtSCatCode');
	tsupcatname=document.getElementById('txtASCatName');
	
	if (tsupcatcode.value=="")
	{
		alert ('Please Enter the Supplier Code!!!');
		return false;
	}
	if (tsupcatname.value=="")
	{
		alert ('Please Enter the Supplier Name!!!')
		return false;
	}
	return true;
}


function validatefind()
{
	tscatcode = document.getElementById('txtSCatCode');
	
	if (tscatcode.value=="")
	{
		alert ('Please Enter the Supplier Category Code!!!');
		return false;
	}
	return true;
}

</script>

<!-- ************************************************************Form**********************************************-->

<form id="form1" name="form1" method="post" action="" >

<table width="100%" border="0" id="cmd" style="background-color:lightblue;">
<tr>
		<td colspan="4" align="center"><span class="title"><strong>Supplier category</strong></span></td>											
	</tr>
  <tr>
    <td colspan="2" bgcolor="lightblue"></td>
  </tr>
  <tr>
    <td width="25%" height="35" align="right">Supplier Category Code </td>
    <td style="padding-left:15px"><label>
      <input name="txtSCatCode" type="text" id="txtSCatCode" value="<?php echo $scCodeNo;?>" maxlength="6" <?php if(isset($_POST['btnFind']) || $_POST['btnFind']=="Find"){ ?> readonly=""<?php } ?> />
    </label></td>
  </tr>
  <tr>
    <td height="32" align="right">Supplier Category Name </td>
    <td style="padding-left:15px"><label>
    <textarea name="txtASCatName" cols="60" rows="2" id="txtASCatName"><?php echo $txtASCatName;?></textarea>
    </label></td>
  </tr>
  
  <tr>
    <td height="27" colspan="3" align="left" style="padding-left:250px">
    <input name="btnAdd" type="submit" class="btn2" id="btnAdd" value="Add" onclick="return validateform()" <?php if(isset($_REQUEST['btnFind']) && $ct==2 ){ ?> disabled="disabled" <?php } ?> />

    <input name="btnFind" type="submit" class="btn2" id="btnFind" value="Find" onclick="return validatefind()" />

    <input name="btnEdit" type="submit" class="btn2" id="btnEdit" value="Edit" onclick="return validatefind()" <?php if(!isset($_REQUEST['btnFind']) || $ct==1){ ?> disabled="disabled" <?php } ?> />
	<label>
	<input name="btnClear" type="submit" class="btn2" id="btnClear" value="Clear" />
	</label>
</table>

</form>
</body>
</html>
