<?php 
session_start();
include("db.inc.php");

$tcurrentdate= $_SESSION["currentdate"];
$tusername = $_SESSION["username"];
$addeduser="";
$ct=0;
extract($_POST);

$sql="SELECT max(category_code)+1 as maxCode FROM `item_category`";
$result = mysql_query($sql) or die("max code error ");
if($row=mysql_fetch_assoc($result)){
	$codeNo="00".$row['maxCode'];
	}

if (isset($_POST['btnAdd']) || $_POST['btnAdd']=="Add"){
	$txtMCatCode=trim($codeNo);
	$txtAMCatName=trim($txtAMCatName);
	$txtAMCatName=addslashes($txtAMCatName);
	$sql= "SELECT count(*) as rowcount FROM `item_category` WHERE `category_code`='$txtMCatCode' or `category_name`='$txtAMCatName'";
	$result= mysql_query($sql) or die("");
	$row=mysql_fetch_assoc($result);
	if ($row['rowcount']!=0)
	{
		echo "<script>alert('Record already exsists!');</script>";
	}
	else
	{
		$txtMCatCode=str_pad($txtMCatCode,3,0,STR_PAD_LEFT);
		$sql1="INSERT INTO `item_category`(`category_code`, `category_name`,`os_user`,`user_add_date`) VALUES ('$txtMCatCode','$txtAMCatName','$tusername','$tcurrentdate')";
		$result1= mysql_query($sql1) or die(mysql_error());
		echo "<script> alert('Record $txtMCatCode-$txtAMCatName added successfully!'); </script>" ;
		$txtMCatCode="";
		$txtAMCatName="";	
		$sql="SELECT max(category_code)+1 as maxCode FROM `item_category`";
		$result = mysql_query($sql) or die("max code error ");
		if($row=mysql_fetch_assoc($result)){
	$codeNo="00".$row['maxCode'];
	}		
	}
}
	
//***********************************************************************************
if (isset($_POST['btnFind']) || $_POST['btnFind']=="Find")
{
	$MCatCode=trim($txtMCatCode);
	$sql="SELECT count(*) as rowcount,`category_code`,`category_name`,`os_user` FROM `item_category` WHERE `category_code`='$MCatCode'"; 
	$result=mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_array($result);
	if ($row[rowcount]==0)
	{
		echo "<script>alert('No Record Found!');</script>";
		$txtMCatCode="";
		$txtAMCatName="";
		unset($_REQUEST);
		$ct=1;
	}
	else
	{
	$codeNo=$row['category_code'];
	$txtAMCatName= $row['category_name'];
	$addeduser = $row['os_user'];
	$ct=2;
	}
}

//**********************************************************************************
if (isset($_POST['btnEdit']) || $_POST['btnEdit']=="Edit")
{
	if($tusername == 'admin' || $tusername == $addedUser)
	{	
	$sql="UPDATE `item_category` SET `category_code`='$txtMCatCode',`category_name`='$txtAMCatName' WHERE `category_code`= '$txtMCatCode';";
	mysql_query($sql) or die(mysql_error());
	echo "<script> alert('Record $txtMCatCode - $txtAMCatName updated successfully!'); </script>" ;
	}
	else
	{
		echo "<script> alert('Sorry, You Do Not Have Permission!'); return false; </script>" ;
	}
	$txtMCatCode="";
	$txtAMCatName="";
}
//************************************************************************************
if (isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
{
	$txtMCatCode="";
	$txtAMCatName="";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Category Information</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<script>
function validateform()
{
	tmaincatcode = document.getElementById('txtMCatCode');
	tmaincatname=document.getElementById('txtAMCatName');
	
	if (tmaincatcode.value=="")
	{
		alert ('Please enter category code!!!');
		return false;
	}
	if (isNaN(tmaincatcode.value))
	{
		alert('Category code should a number!');
		return false;
	}
	if (tmaincatname.value=="")
	{
		alert ('Please enter catergory name!!!');
		return false;
	}
	return true;
}

function validatefind()
{
	tmaincatcode = document.getElementById('txtMCatCode');
	
	if (tmaincatcode.value=="")
	{
		alert ('Please enter category code!!!');
		return false;
	}
	if (isNaN(tmaincatcode.value))
	{
		alert('Category code should a number!');
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
		<td colspan="4" align="center"><span class="title"><strong>Item category</strong></span></td>											
	</tr>
    <tr>
    <td width="25%" height="35" align="right"> Category Code </td><td width="26%" style="padding-left:15px"><label>
      <input name="txtMCatCode" type="text" id="txtMCatCode" value="<?php echo $codeNo; ?>" maxlength="3" <?php if(isset($_REQUEST['btnFind'])){ ?> readonly="readonly" <?php } ?> />
    </label></td>
    <td></td>
  </tr>
  <tr>
    <td height="32" align="right"> Category Name </td>
    <td style="padding-left:15px"><label>
    <input name="txtAMCatName" type="text" id="txtAMCatName" size="50" value="<?php echo stripslashes($txtAMCatName); ?>"  />
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
    <!--input name="btnExit" type="submit" class="btn2" id="btnExit" value="Exit"/-->
	<input name="addedUser" type="hidden" id="addedUser" value="<?php echo $addeduser; ?>" />
	<?php 
	  if ($result1)
	  {
	  //echo "$txtMCatCode -". stripslashes($txtAMCatName)." added successfully.";
//	  $txtMCatCode=" ";
//	  $txtAMCatName=" "; 
	  }
	  ?>
    </label></td>
    </tr>
 
 <!-- <tr>
    <td colspan="3"><?php //include 'footer.php'?></td>
  </tr>-->
</table>

</form>
</body>
</html>
