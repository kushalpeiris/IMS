<?php 
session_start();
include("db.inc.php");

$tcurrentdate= $_SESSION["currentdate"];
$addeduser="";
$ct=0;
extract($_POST);

if (isset($_POST['btnAdd']) || $_POST['btnAdd']=="Add")
{
	$txtDivName=addslashes(trim($txtDivName));
	$txtDivCode=str_pad($txtDivCode,9,0,STR_PAD_LEFT);
	$sql= "SELECT count(*) as rowcount FROM `division_masterfile` WHERE `div_code`='$txtDivCode' or `div_name`='$txtDivName'";
	$result= mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_assoc($result);
	if ($row['rowcount']!=0)
	{
		echo "<script> alert('Record Exsist!$txtDivCode'');</script>";
		$txtDivCode="";
		$txtDivName="";	
	}
	else
	{
		$txtDivCode=str_pad($txtDivCode,9,0,STR_PAD_LEFT);
		$sql1="INSERT INTO `division_masterfile`(`div_code`,`div_name`,`user_add`,`user_add_date`)VALUES('$txtDivCode','$txtDivName','$tusername','$tcurrentdate')";
		$result1= mysql_query($sql1) or die(mysql_error());
		echo "<script> alert ('Division $txtDivCode - $txtDivName added successfully!!'); </script>";			
	}
	$txtDivCode="";
	$txtDivName="";
}
	

//***********************************************************************************

if (isset($_POST['btnFind']) || $_POST['btnFind']=="Find")
{
	$divCode=trim($txtDivCode);
	$sql="SELECT count(*) as rowcount,`div_code`,`div_name`,`user_add` FROM `division_masterfile` WHERE `div_code`='$divCode'"; 
	$result=mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_array($result);
	if ($row[rowcount]==0)
	{
		echo "<script> alert('No Record Found!');</script>";
		$txtDivName="";
		$ct=1;
	}
	else
	{
	$txtDivCode=$row['div_code'];
	$txtDivName= $row['div_name'];
	$addeduser = $row['user_add'];
	$ct=2;
	}
}

//**********************************************************************************
if (isset($_POST['btnEdit']) || $_POST['btnEdit']=="Edit")
{
	if($tusername == 'admin' || $tusername == $addedUser)
	{	
	$sql="UPDATE `division_masterfile` SET `div_code`='$txtDivCode',`div_name`='$txtDivName' WHERE `div_code`= '$txtDivCode';";
	mysql_query($sql) or die(mysql_error());
	echo "<script> alert('Record $txtDivCode - $txtDivName updated successfully!'); </script>" ;
	}
	else
	{
		echo "<script> alert('Sorry, You Do Not Have Permission!'); return false; </script>" ;
	}
	$txtDivCode="";
	$txtDivName="";
}
//************************************************************************************
if (isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
{
	$txtDivCode="";
	$txtDivName="";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Division Information</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<script>
function validateform()
{
	tmaincatcode = document.getElementById('txtDivCode');
	tmaincatname=document.getElementById('txtDivName');
	
	if (tmaincatcode.value=="")
	{
		alert ('Please enter the Division Code!!!');
		return false;
	}
	if (isNaN(tmaincatcode.value))
	{
		alert('Division Code should a number');
		return false;
	}
	if (tmaincatname.value=="")
	{
		alert ('Please enter the Division Name!!!');
		return false;
	}
	return true;
}

function validatefind()
{
	tmaincatcode = document.getElementById('txtDivCode');
	
	if (tmaincatcode.value=="")
	{
		alert ('Please enter the Division Code!!!');
		return false;
	}
	if (isNaN(tmaincatcode.value))
	{
		alert('Division Code should a number');
		return false;
	}
	return true;
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
<form id="form1" name="form1" method="post" action="">

<table width="100%" border="0" id="cmd" bgcolor="lightblue">
  <tr>
    <td colspan="2" bgcolor="lightblue"></td>
  </tr>
  <tr>
		<td colspan="4" align="center"><span class="title"><strong>Division</strong></span></td>											
	</tr>
    <tr>
    <td width="25%" height="35" align="right"> Division Code </td><td width="26%" style="padding-left:15px"><label>
      <input name="txtDivCode" type="text" id="txtDivCode" value="<?php echo $txtDivCode; ?>" maxlength="9" <?php if(isset($_REQUEST['btnFind'])){ ?> readonly="readonly" <?php } ?> />
    </label></td>
    <td></td>
  </tr>
  <tr>
    <td height="32" align="right"> Division Name </td>
    <td style="padding-left:15px"><label>
    <input name="txtDivName" type="text" id="txtDivName" size="50" value="<?php echo stripslashes($txtDivName); ?>"  />
    </label></td>
  </tr>
  <tr height="50px"></tr>
   <tr>
    <td height="27" colspan="3" align="left" style="padding-left:250px">
    <input name="btnAdd" type="submit" class="btn2" id="btnAdd" value="Add" onclick="return validateform() " <?php if(isset($_REQUEST['btnFind']) && $ct==2){ ?> disabled="disabled" <?php } ?>/>
    <input name="btnFind" type="submit" class="btn2" id="btnFind" value="Find" onclick="return validatefind()" />
    <input name="btnEdit" type="submit" class="btn2" id="btnEdit" value="Edit" onclick="return validatefind()" <?php if(!isset($_REQUEST['btnFind']) || $ct==1){ ?> disabled="disabled" <?php } ?> />
    <label class="style3" ><font color="#003333"></font> 
   
	<input name="btnClear" type="submit" class="btn2" id="btnClear" value="Clear" />
	</label>
    <input name="addedUser" type="hidden" id="addedUser" value="<?php echo $addeduser; ?>" /></label></td>
    </tr>
</table>

</form>
</body>
</html>
