<?php 
session_start();
include("db.inc.php");

extract($_POST);
$tcurrentdate= $_SESSION["currentdate"];
$tdatetime=strftime("%Y-%m-%d %H:%M:%S");
$code='';

if (isset($_POST['btnSave']) || $_POST['btnSave']=="Save")
{
	$pId=$_POST['lstProduct'];
	$pCatagoty=$_POST['lstCategory'];
	$Code=$_POST['txtCode'];
	$Des=addslashes(trim($_POST['txtDes']));
	$Local=$_POST['lstLocal'];
	$Type=$_POST['lstType'];
	$Location=$_POST['lstLocation'];
	$Umo=$_POST['lstUMO'];
	$Costing=$_POST['lstCosting'];
	$OrderL=trim($_POST['txtOrderL']);
	$OrderQ=trim($_POST['txtOrderQ']);
	
	
	$sqlItemAdd="insert into item_masterfile (product_category_code,product_sub_category_code,item_code,item_description,import_local,item_type_code,item_uom,item_costing_method,item_rol,item_rol_qty,user_add,user_add_date)
values	('$pId','$pCatagoty','$Code','$Des','$Local','$Type','$Umo','$Costing',$OrderL,$OrderQ,'$tusername','$tdatetime')";
	

 $result= mysql_query($sqlItemAdd) or die(mysql_error());
echo "<script> alert ('Item Code $txtCode - $txtDes  added successfully!!'); </script>";
	unset($_REQUEST);
}
if (isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
{
	unset($_REQUEST);
}
if (isset($_POST['btnExit']) || $_POST['btnExit']=="Exit")
{
	header("location:homeindex.php");
}
?>
<!--*********************************************************************************************************-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reports Dashboard</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<script>
function validateForm()
{		
	if (document.getElementById('lstProduct').value=="0")
	{
		alert('Please select the Main Category !');
		return false;
	}	
	if (document.getElementById('lstCategory').value=="0")
	{
		alert('Please select the Sub Category !');
		return false;
		form1.lstCategory.focus();
	}
	if (document.getElementById('lstType').value=="0")
	{
		alert('Please select the Item Type ! ');
		return false;
	}
	if (document.getElementById('lstLocation').value=="0")
	{
		alert('Please select Item Location ! ');
		return false;
	}
	if (document.getElementById('txtDes').value=="")
	{
		alert('Please Enter Item Description ');
		return false;
	}
	if (document.getElementById('lstUMO').value=="0")
	{
		alert('Please Select Unit of Measurement (U.O.M) ! ');
		return false;
	}
	var OrderL=document.getElementById('txtOrderL').value;
	if (OrderL=="")
	{
		alert('Please Enter Re-Order Level ! ');
		return false;
	}
	if (isNaN(OrderL))
	{
		alert('Re-Ordr Level must have numbers only !');
		return false;
		OrderQ.focus();
	}
	var OrderQ=document.getElementById('txtOrderQ').value;
	if (OrderQ=="")
	{
		alert('Please Enter Re-Order Quantity ');
		return false;
	}
	if (isNaN(OrderQ))
	{
		alert('Re-Ordr Quantity omust have numbers only !');
		return false;
		form1.OrderQ.focus();
	}
	return true;
}
function ClearSubCategory()
{
	document.getElementById('lstCategory').value=0;
}
</script>
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
		<td colspan="4" align="center"><span class="title"><strong>Purchase Reports</strong></span></td>											
	</tr>
	<tr><td colspan="4" align="center">
    <a href="pobook.php">PO Book</a>
    </td></tr>
    <tr><td colspan="4" align="center">
    <a href="polist.php">Purchase Listing</a>
    </td></tr>
    <!--tr>
        <td colspan="4" align="center"><span class="title"><strong>GRN Reports</strong></span></td></tr>
        <tr><td colspan="4" align="center">
    <a href="grnlist.php">GRN Listing</a>
    </td></tr>
    <tr-->
        <td colspan="4" align="center"><span class="title"><strong>Supplier Reports</strong></span></td></tr>
        <tr><td colspan="4" align="center">
    <a href="suplist.php">Supplier listing</a>
    </td></tr>
</table>
</form>
</body>
</html>
