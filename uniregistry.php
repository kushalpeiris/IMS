<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Supplier Category Information</title>


<?php 

session_start();
if (!$_SESSION["login"])
{
	header("Location:../login.php");
}
if (isset($_POST['btnExit']) || $_POST['btnExit']=="Exit")
{
	header("location:homeindex.php");
}

$tusername = $_SESSION["username"];
$tcurrentdate= $_SESSION["currentdate"];
//$tusergroup = $_SESSION["usergroup"];
$ct=0;
$cot=0;

require('db.inc.php');
include('styles.inc.php'); 
extract($_POST);
//************************************************************************************************

//************************************************************************************************
if (isset($_POST['btnAdd']) || $_POST['btnAdd']=="Add")
{
	if ($lstFacCode == '000000215' && $tusername == 'admin_sup')
	{
		echo "<script> alert ('Sorry, You Do Not Have Permission!'); </script>";
	}
	else
	{
	//$txtFacCode=trim($txtDepCode,'0');
	//$txtFacCode=str_pad($txtDepCode,9,0,STR_PAD_LEFT);
	$txtDepName=addslashes(trim($txtDepName));
	$sql= "SELECT count(*) as rowcount FROM `unit_masterfile` WHERE `unit_code`='$txtDepFacCode$txtDepCode'";
	$result= mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_assoc($result);
	if ($row['rowcount']!=0)
	{
		echo "<script> checksupcat();
		function checksupcat()
		{
			alert('Record Exsist!');
			return false;
		}  </script>";
	}
	else
	{
		//$tDepCode=($txtDepFacCode + $txtDepCode);
		$sql1="INSERT INTO `unit_masterfile`(`unit_code`,`div_code`, `unit_name`, `user_add`,`user_add_date`) VALUES ('$txtDepFacCode$txtDepCode','$lstFacCode','$txtDepName','$tusername','$tcurrentdate')";
		$result1= mysql_query($sql1) or die(mysql_error());
		echo "<script> alert ('Department $txtDepFacCode$txtDepCode - $txtDepName added successfully!!'); </script>";		
	}
	}
	$txtDepFacCode="";
	$txtDepCode="";
	$txtDepName="";
	unset($_REQUEST);
}
	
//***********************************************************************************
if (isset($_POST['btnFind']) || $_POST['btnFind']=="Find")
{
	$sql="SELECT count(*) as rowcount,`unit_code`,`unit_name`,`div_code` FROM `unit_masterfile` WHERE `unit_code`='$txtDepFacCode$txtDepCode'"; 
	$result=mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_array($result);
	if ($row[rowcount]==0)
	{
		echo "<script> checksupcat();
		function checksupcat()
		{
			alert('No Record Found!');
			return false;
		}  </script>";
	//unset($_REQUEST);
	//$txtDepCode="";
	$txtDepName="";
	$ct=1;
	}
	else
	{
	$txtDepName= $row['unit_name'];
	$ct=2;
	if($txtDepCode == '001')
	{
	$cot=3;
	}
	}
	//$hdFCat=$row['div_code'];
}

//**********************************************************************************
if (isset($_POST['btnEdit']) || $_POST['btnEdit']=="Edit")
{	
	if ($lstFacCode == '000000215' && $tusername == 'admin_sup')
	{
		echo "<script> alert ('Sorry, You Do Not Have Permission!'); </script>";
	}
	elseif($lstFacCode == '000000215' && $tusername == 'admin_med' && $hdCot == 3)
	{
		echo "<script> alert ('Sorry, You Do Not Have Permission!'); </script>";
	}
	else
	{
	$txtDepName=addslashes(trim($txtDepName));
	/*if ($_REQUEST['lstFacCode'] != $hdFCat)
	{
		echo "<script> alert (' You cannot change Faculty Category Code!!!'); </script>";
	}
	else
	{*/
	$sql="UPDATE `unit_masterfile` SET `unit_name`='$txtDepName',`os_user`='$tusername',`user_add_date`='$tcurrentdate' WHERE `unit_code`='$txtDepFacCode$txtDepCode'";
	//echo $sql;
	mysql_query($sql) or die(mysql_error());
	echo "<script> alert('Record $txtDepFacCode$txtDepCode - $txtDepName updated successfully!'); </script>" ;
	}
	$txtDepFacCode="";
	unset($_REQUEST);
	$txtDepCode="";
	$txtDepName="";
}

//************************************************************************************
if (isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
{
	$txtDepFacCode="";
	unset($_REQUEST);
	$txtDepCode="";
	$txtDepName="";
}
?>

<title>Unit Register</title>
<link rel="stylesheet" href="css/style.css" type="text/css"></head>
<body>

<script>

function validateform()
{
	tfaccode= document.getElementById('lstFacCode');
	tdepcode = document.getElementById('txtDepCode');
	tdepname=document.getElementById('txtDepName');
	
	if (tfaccode.value==0)
	{
		alert ('Please Select a Faculty!!!');
		return false;
	}
	if (tdepcode.value=="")
	{
		alert ('Please enter the Department Code!!!');
		return false;
	}
	if (tdepname.value=="")
	{
		alert ('Please enter the Department Name!!!')
		return false;
	}
	if (isNaN(tdepcode.value))
	{
		alert('Department Code should a number');
		return false;
	}
	return true;
}


function validatefind()
{
	tfaccode= document.getElementById('lstFacCode');
	tdepcode = document.getElementById('txtDepCode');
	
	if (tfaccode.value==0)
	{
		alert ('Please Select a Faculty!!!');
		return false;
	}
	if (tdepcode.value=="")
	{
		alert ('Please enter the Department Code!!!');
		return false;
	}
	if (isNaN(tfaccode.value))
	{
		alert('Department Code should a number');
		return false;
	}
	return true;
}

</script>

<!-- ************************************************************Form**********************************************-->
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
<form id="form1" name="form1" method="post" action="" >

<table width="100%" border="0" id="cmd" style="background-color:lightblue;">
  <tr>
    <td width="15%" class="style3">Division Code </td>
    <td width="85%" class="style3"><label>
      <select name="lstFacCode" id="lstFacCode" onchange="submit()" >
	  <option value="0">Select... </option>
	  <?php
	  
	  $sql = "SELECT `div_code`,`div_name` FROM `division_masterfile` "; //list of Faculty.....
	  $result= mysql_query($sql) or die(mysql_error());
	  while($row = mysql_fetch_array($result))
	  {
	  ?>
	  <option value="<?php echo $row['div_code']?>" 
			<?php 
			if (!isset($_REQUEST['lstFacCode'])) 
			$_REQUEST['lstFacCode'] = "undefine"; 
			if($row['div_code']===$_REQUEST['lstFacCode'])
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
    </label></td>
  </tr>
  <tr>
    
    <td class="style3" valign="top">Unit Code </td>
    <td class="style3">
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
		$tFacCode = ltrim($lstFacCode,0);
		//echo $tFacCode;
		$txtDepFacCode = str_pad("$tFacCode",6,0,STR_PAD_LEFT);
	}
	?>
      <input name="txtDepFacCode" type="text" id="txtDepFacCode" size="20" readonly="readonly" value="<?php if ($_POST['lstFacCode'] ==0){echo " ";} else{ echo stripslashes($txtDepFacCode);}?>"  />
      <input name="txtDepCode" type="text" id="txtDepCode" size="10" maxlength="3" value="<?php echo $txtDepCode; ?>" <?php if (isset($_POST['btnFind'])){ ?> readonly="readonly" <?php }?> />
    Ex:0XX</td>
  </tr>
  <tr valign="top">
    <td class="style3">Unit Name </td>
    <td class="style3"><label>
    <textarea name="txtDepName" cols="30" rows="2" id="txtDepName" ><?php echo stripslashes($txtDepName);?></textarea>
    </label></td>
  </tr>
  
  <tr>
    <td colspan="3">
    <input name="btnAdd" type="submit" class="btn2" id="btnAdd" value="Add" onclick="return validateform()" <?php if(isset($_REQUEST['btnFind']) && $ct==2){ ?> disabled="disabled" <?php } ?>/>

    <!--input name="btnFind" type="submit" class="style3" id="btnFind" value="Find" onclick="return validatefind()" />

    <input name="btnEdit" type="submit" class="style3" id="btnEdit" value="Edit" onclick="return validateform()" <?php if(!isset($_REQUEST['btnFind']) || $ct==1){ ?> disabled="disabled" <?php } ?> />
	
	<input name="btnClear" type="submit" class="style3" id="btnClear" value="Clear" />
	<<input name="btnExit" type="submit" class="style3" id="btnExit" value="Exit" onclick="javascript: form.action='../login.php'; " /> -->
	<input name="btnExit" type="submit" class="btn2" id="btnExit" value="Exit" />
	<input name="hdCot" class="style3" id="hdCot" value="<?php echo $cot; ?>" type="hidden" />
	<!--input name="hdFCat" class="style3" id="hdFCat" value="< ?php echo $hdFCat; ?>" type="hidden" /-->
	</td>
    </tr>
  <!--<tr>
   <td colspan="3">
   <?php //include 'footer.php'?></td>
  </tr>--> 
</table>

</form>
</body>
</html>
