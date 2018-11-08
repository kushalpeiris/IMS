<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Faculty Registry</title>


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
$ct=0;

require('db.inc.php');
include('styles.inc.php'); 
extract($_POST);

//************************************************************************************************
if (isset($_POST['btnAdd']) || $_POST['btnAdd']=="Add")
{
	$txtAFacName=addslashes(trim($txtAFacName));
	$txtFacCode1=ltrim($txtFacCode,'0');
	$txtFacCode=str_pad($txtFacCode1,9,0,STR_PAD_LEFT);
	$sql= "SELECT count(*) as rowcount FROM `division_masterfile` WHERE `div_code`='$txtFacCode' or `div_name`='$txtAFacName'";
	$result= mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_assoc($result);
	if ($row['rowcount']!=0)
	{
		echo "<script> checkfacreg();
		function checkfacreg()
		{
			alert('Record Exsist!');
			return false;
		}  </script>";
		$txtFacCode="";
		$txtAFacName="";	
	}
	else
	{
		$txtFacCode=str_pad($txtFacCode1,9,0,STR_PAD_LEFT);
		$sql1="INSERT INTO `division_masterfile`(`div_code`,`div_name`,`user_add_date`)VALUES('$txtFacCode','$txtAFacName','$tcurrentdate')";
		$result1= mysql_query($sql1) or die(mysql_error());
		echo "<script> alert ('Faculty Code $txtFacCode - $txtAFacName added successfully!!'); </script>";			
	}
	$txtFacCode="";
	$txtAFacName="";
	
}
	
//***********************************************************************************

if (isset($_POST['btnFind']) || $_POST['btnFind']=="Find")
{

	$FacCode=trim($txtFacCode);
	$sql="SELECT count(*) as rowcount,`div_code`,`div_name` FROM `division_masterfile` WHERE `div_code`='$FacCode'"; 
	$result=mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_array($result);
	if ($row[rowcount]==0)
	{
		echo "<script> checkfacreg();
		function checkfacreg()
		{
			alert('No Record Found!');
			return false;
		}  </script>";
		$ct=1;
		//$txtFacCode="";
		$txtAFacName="";
	}
	else
	{
	$txtFacCode=$row['div_code'];
	$txtAFacName= $row['div_name'];
	$ct=2;
	}
}
//**********************************************************************************
if (isset($_POST['btnEdit']) || $_POST['btnEdit']=="Edit")
{
	$txtAFacName=addslashes(trim($txtAFacName));
	$sql="DELETE from `division_masterfile` WHERE `div_code`='$txtFacCode'";
	//echo $sql;
	mysql_query($sql) or die("Record not found!");
	//$txtSCatCode=$row['sup_cat_code'];
	//$txtASCatName= $row['sup_cat_name'];
	$sql="INSERT INTO `division_masterfile`(`div_code`,`div_name`,`os_user`,`user_add_date`)VALUES('$txtFacCode','$txtAFacName','$tusername','$tcurrentdate')";
	//echo $sql;	
	mysql_query($sql) or die(mysql_error());
	echo "<script> alert('Record $txtFacCode - $txtAFacName updated successfully!'); </script>" ;
	$txtFacCode="";
	$txtAFacName="";
}
//*********************************************************************************
if (isset($_POST['btnDelete']) || $_POST['btnDelete']=="Delete")
{
	$sql="DELETE from `division_masterfile` WHERE `div_code`='$txtFacCode'";
	//echo $sql;
	mysql_query($sql) or die("Record not found!");
	//$txtSCatCode=$row['sup_cat_code'];
	//$txtASCatName= $row['sup_cat_name'];
	echo "<script> alert('Record $txtFacCode - $txtAFacName deleted successfully!'); </script>" ;
	$txtFacCode="";
	$txtAFacName="";
}


//************************************************************************************
if (isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
{
	$txtFacCode="";
	$txtAFacName="";
}

?>
<title>Division Register</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<script>

function validateform()
{
	tfaccode = document.getElementById('txtFacCode');
	tfacname=document.getElementById('txtAFacName');
	
	if (tfaccode.value=="")
	{
		alert ('Please enter the Faculty  Code!!!');
		return false;
	}
	if (tfacname.value=="")
	{
		alert ('Please enter the Faculty Name!!!');
		return false;
	}
	if (isNaN(tfaccode.value))
	{
		alert('Faculty Code should a number');
		return false;
	}
	return true;
}

function validatefind()
{
	tfaccode = document.getElementById('txtFacCode');   
	
	if (tfaccode.value=="")
	{
		alert ('Please enter the Faculty Code!!!');
		return false;
	}
	if (isNaN(tfaccode.value))
	{
		alert('Faculty Code should a number');
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
    <td width="172" class="style3">Division  Code : </td>
    <td width="834" class="style3"><input name="txtCode" type="text" id="txtCode" readonly="false" value="<?php				
								
										$sql="SELECT max(div_code)+1 as maxCode FROM `division_masterfile`";
										$result = mysql_query($sql) or die("max code error ");
										if($row=mysql_fetch_assoc($result))
										    {
												$codeNo=$row['maxCode'];
												//echo "code No - $codeNo-";
												if ($codeNo==NULL) 
												{ 
													$codeNo="001";
													echo "$code$codeNo"; 
												
												}
												else
												{ 											 
												$codeNo= str_pad($codeNo,9,0,STR_PAD_LEFT);
												echo "$codeNo";
												}
											}
								?> "/></td>
  </tr>
  <tr>
    <td class="style3">Division Name : </td>
    <td class="style3"><label>
    <input name="txtAFacName" type="text" id="txtAFacName" value="<?php echo stripslashes($txtAFacName); ?>" size="50" />
    </label></td>
  </tr>
  
  <tr>
    <td colspan="2">
    <input name="btnAdd" type="submit" id="btnAdd" value="Add" class="btn2"  onclick="return validateform()" <?php if(isset($_REQUEST['btnFind']) && $ct==2){ ?> disabled="disabled" <?php } ?> />
    <!--input name="btnFind" type="submit" class="style3" id="btnFind" value="Find" onclick="return validatefind()" />
    <input name="btnEdit" type="submit" class="style3" id="btnEdit" value="Edit" onclick="return validateform()" <?php if(!isset($_REQUEST['btnFind']) || $ct==1){ ?> disabled="disabled" <?php } ?> /-->
      
	<input name="btnExit" type="submit" class="btn2" id="btnExit" value="Exit" />
	<font color="#003333"> <?php 
	  if ($result1)
	  {
	 // echo "$txtFacCode - $txtAFacName added successfully.";
//	  $txtFacCode="";
//	  $txtAFacName=""; 
	  }
	  ?></font></td>
    </tr>
    <!--<tr>
    <td colspan="3">< ?php include 'footer.php'?></td>
  </tr>-->
</table>

</form>
</body>
</html>
