<?php 
session_start();
include("db.inc.php");

extract($_POST);
$tcurrentdate= $_SESSION["currentdate"];
$tdatetime=strftime("%Y-%m-%d %H:%M:%S");
$addeduser="";
$ct=0;

require('db.inc.php'); 
extract($_POST);

//************************************************************************************************
if (isset($_POST['btnAdd']) || $_POST['btnAdd']=="Add")
{
	$txtSCatName=addslashes(trim($txtSCatName));
	$sql= "SELECT count(*) as rowcount FROM `unit_masterfile` WHERE  `unit_code`='$txtDivCode$txtSCatCode'";
	$result= mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_assoc($result);
	if ($row['rowcount']!=0)
	{
		echo "<script>alert('Record Exist!');</script>";
	}
	else
	{
		$sql1="INSERT INTO `unit_masterfile`(`unit_code`,`div_code`,`unit_name`, `user_add`,`user_add_date`) VALUES ('$txtDivCode$txtSCatCode','$lstMCatCode','$txtSCatName','$tusername','$tcurrentdate')";
		$result1= mysql_query($sql1) or die(mysql_error());
		echo "<script> alert ('Unit $txtSCatCode - $txtSCatName added successfully!!'); </script>";		
	}
	$txtDivCode=0;
	$txtSCatCode="";
	$txtSCatName="";
	unset($_REQUEST);
}
	
//***********************************************************************************
if (isset($_POST['btnFind']) || $_POST['btnFind']=="Find")
{
	$sqluser="SELECT `user_add` FROM `unit_masterfile` WHERE `div_code`='$lstMCatCode'";
	$resultuser=mysql_query($sqluser) or die(mysql_error());
	$rowuser=mysql_fetch_array($resultuser);
	
	$sql="SELECT count(*) as rowcount,`div_code`,`unit_code`,`unit_name` FROM `unit_masterfile` WHERE `unit_code`='$txtDivCode$txtSCatCode' AND `div_code`='$lstMCatCode'"; 
	$result=mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_array($result);
	if ($row[rowcount]==0)
	
	{
		echo "<script>alert('No Record Found!');</script>";
		$ct=1;
		$txtSCatName="";
	}
	else
	{
	$txtSCatName= $row['unit_name'];
	$ct=2;
	$addeduser = $rowuser ['user_add'];
	}
}

//**********************************************************************************
if (isset($_POST['btnEdit']) || $_POST['btnEdit']=="Edit")
{
	if($tusername == 'admin' || $tusername == $addedUser)
	{	
	$txtSCatName=addslashes(trim($txtSCatName));
	$sql="UPDATE `unit_masterfile` SET `div_code`='$lstMCatCode', `unit_name`='$txtSCatName',`user_add`='$tusername',`user_add_date`='$tcurrentdate' WHERE `unit_code`='$txtDivCode$txtSCatCode' AND `div_code`='$lstMCatCode'";
	mysql_query($sql) or die(mysql_error());
	echo "<script> alert('Record $txtSCatCode - $txtSCatName updated successfully!'); </script>" ;
	}
	else
	{
		echo "<script> alert('Sorry, You Do Not Have Permission!'); return false; </script>" ;
	}
	$txtSCatCode="";
	$txtSCatName="";
	unset($_REQUEST);
	
}

//************************************************************************************
if (isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
{
	$lstMCatCode=0;
	unset($_REQUEST);
	$txtSCatCode="";
	$txtSCatName="";
	$txtDivCode="";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Unit Registry</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<script>

function validateform()
{
	tMCatCode= document.getElementById('lstMCatCode');
	tSCatCode = document.getElementById('txtSCatCode');
	tSCatName=document.getElementById('txtSCatName');
	
	if (tMCatCode.value==0)
	{
		alert ('Please Select a Div Category Code!!!');
		return false;
	}
	if (tSCatCode.value=="")
	{
		alert ('Please enter the Unit Code!!!');
		return false;
	}
	if (tSCatName.value=="")
	{
		alert ('Please enter the Unit Name!!!')
		return false;
	}
	if (isNaN(tSCatCode.value))
	{
		alert('Unit should a number');
		return false;
	}
	return true;
}


function validatefind()
{
	tMCatCode= document.getElementById('lstMCatCode');
	tSCatCode = document.getElementById('txtSCatCode');
	
	if (tMCatCode.value==0)
	{
		alert ('Please Select a Division Code!!!');
		return false;
	}
	if (tSCatCode.value=="")
	{
		alert ('Please enter the Unit Code!!!');
		return false;
	}
	if (isNaN(tSCatCode.value))
	{
		alert('Unit Code should a number');
		return false;
	}
	return true;
}

</script>
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

<table width="100%" height="201" border="0" align="center" style="background-color:lightblue;">
  <tr>
  	<td width="15%" valign="top"></td>
    <td width="5%" align="right"> Division &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td width="15%"><label>
      <select name="lstMCatCode" id="lstMCatCode" onchange="submit()" class="styleselect1">
	  <option value="0">Select... </option>
	  <?php 
	  $sql = "SELECT `div_code`,`div_name` FROM `division_masterfile`";
	  $result= mysql_query($sql) or die(mysql_error());
	  while($row = mysql_fetch_array($result))
	  {
	  ?>
	  <option value="<?php echo $row['div_code']?>" 
			<?php 
			if (!isset($_REQUEST['lstMCatCode'])) 
			$_REQUEST['lstMCatCode'] = "undefine"; 
			if($row['div_code']===$_REQUEST['lstMCatCode'])
			echo " selected=\"selected\" " ;
		?>>
	  <?php	 
		echo $row['div_code'].' - '.$row['div_name'];
	  ?>
	  </option>
	  <?php
		}
		?> 	
      </select>
    </label></td><td width="10%"></td>
  </tr>
  <tr height="26">
        <td colspan="4" align="center"><span class="title"><strong>Existing Units</strong></span></td></tr>
  <tr>
        <td colspan="4" valign="top">
  <!-- Show the Unit List-->
	<div style="overflow:scroll">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
							  
<?php if ($_REQUEST['lstMCatCode']<>0) 
{  
		$sql="SELECT `unit_code`,`unit_name` FROM `unit_masterfile` WHERE `div_code`='$lstMCatCode'";
		$result = mysql_query($sql) or die(mysql_error());
		$a=1;
		while($row=mysql_fetch_assoc($result))
			{
?>								
	<tr valign="top"align="left"><td style="padding-left:200px" <?php if ($a%2==0) echo "bgcolor=\"#66ccff\""; else echo "bgcolor=\"#ccffff\"";  ?> >
	<?php echo "<font class=\"style3\" style=\"font-weight:normal\">".$row['unit_code']. " - ".$row['unit_name']."</font>"."<br>"; ?></td></tr>
 	 <?php $a++;}//end while 
		}//end if ?></table></div>
	</td></tr>
  <tr>
  <td height="35" align="right"> Unit Code </td>
  <td style="padding-left:15px" colspan="3">
	<?php 
	if (
	(isset($_POST['btnAdd']) || $_POST['btnAdd']=="Add") || 
	(isset($_POST['btnClear']) || $_POST['btnClear']=="Clear") ||
	(isset($_POST['btnEdit']) || $_POST['btnEdit']=="Edit")
	)
	{
	}
	else
	{
		$tMCatCode = ltrim($lstMCatCode,0);
		$txtDivCode = str_pad("$tMCatCode",6,0,STR_PAD_LEFT);
	}
	?>
	<input name="txtDivCode" type="text" id="txtDivCode" size="20" readonly="readonly" value="<?php if ($_POST['lstMCatCode'] ==0){echo " ";} else{ echo stripslashes($txtDivCode);}?>"  /><input name="txtSCatCode" type="text" id="txtSCatCode" size="10" maxlength="3" value="<?php echo $txtSCatCode; ?>" <?php if (isset($_POST['btnFind']) || $_POST['btnFind']=="Find"){ ?> readonly="" <?php }?> /></td>
  </tr>
  <tr valign="top">
  <td height="32" align="right">Unit Name </td>
    <td style="padding-left:15px"><label>
    <input name="txtSCatName" type="text" id="txtSCatName" value="<?php echo $txtSCatName; ?>" size="50" class="styleselect1" />
    </label></td>
  </tr>
  
  <tr>
    <td height="27" colspan="3" align="left" style="padding-left:250px">
    <input name="btnAdd" type="submit" class="btn2" id="btnAdd" value="Add" onclick="return validateform()" <?php if(isset($_REQUEST['btnFind']) && $ct==2 ){ ?> disabled="disabled" <?php } ?>/>

    <input name="btnFind" type="submit" class="btn2" id="btnFind" value="Find" onclick="return validatefind()" />

    <input name="btnEdit" type="submit" class="btn2" id="btnEdit" value="Edit" onclick="return validateform()" <?php if(!isset($_REQUEST['btnFind']) || $ct==1){ ?> disabled="disabled" <?php } ?> />
	<label>
	<input name="btnClear" type="submit" class="btn2" id="btnClear" value="Clear" />
	<input name="addedUser" type="hidden" id="addedUser" value="<?php echo $addeduser; ?>" />
	</label></td>
	</tr>
 </table>

</form>
</body>
</html>
