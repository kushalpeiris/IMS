<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sub Category Registry</title>


<?php 

session_start();
if (!$_SESSION["login"])
{
	header("Location:../login.php");
}

if (isset($_POST['btnExit']) || $_POST['btnExit']=="Exit")
{
	header("location:inventory.php");
}

$tusername = $_SESSION["username"];
$tcurrentdate= $_SESSION["currentdate"];
//$tMCat="";
$addeduser="";
$ct=0;

require('db.inc.php');
include('styles.inc.php'); 
extract($_POST);

//************************************************************************************************
if (isset($_POST['btnsave']) || $_POST['btnsave']=="Save")
{
	$gp=$_POST['lstMCatCode'];
	$uname=addslashes(trim($_POST['txtuname']));
	$rtpw=$_POST['txtpw2'];
	$em=$_POST['txtemail'];
		$sql1="INSERT INTO `imsdb`.`users` (`username`, `password`, `group`, `email`) VALUES ('$uname', '$rtpw', '$gp', '$em');";
		$result1= mysql_query($sql1) or die(mysql_error());
		echo "<script> alert ('New user $uname  added successfully!!'); </script>";		
	
	$gp='';
	$uname='';
	$rtpw='';
	$em='';
	unset($_REQUEST);
}

if (isset($_POST['btndelete']) || $_POST['btndelete']=="Remove")
{
	$gp=$_POST['lstMCatCode'];
	$uname=addslashes(trim($_POST['txtuname']));
		$sql1="Delete from `imsdb`.`users` where `username`='$uname' and `group`= '$gp'";
		$result1= mysql_query($sql1) or die(mysql_error());
		echo "<script> alert ('User $uname  removed successfully!!'); </script>";		
	
	$gp='';
	$uname='';
	$rtpw='';
	$em='';
	unset($_REQUEST);
}
?>

<script>

function validateform()
{
	tMCatCode= document.getElementById('lstMCatCode');
	tSCatCode = document.getElementById('txtSCatCode');
	tSCatName=document.getElementById('txtSCatName');
	
	if (tMCatCode.value==0)
	{
		alert ('Please Select a Main Category Code!!!');
		return false;
	}
	if (tSCatCode.value=="")
	{
		alert ('Please enter the Sub Category Code!!!');
		return false;
	}
	if (tSCatName.value=="")
	{
		alert ('Please enter the Sub Category Name!!!')
		return false;
	}
	if (isNaN(tSCatCode.value))
	{
		alert('Sub Category Code should a number');
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
		alert ('Please Select a Main Category Code!!!');
		return false;
	}
	if (tSCatCode.value=="")
	{
		alert ('Please enter the Sub Category Code!!!');
		return false;
	}
	if (isNaN(tSCatCode.value))
	{
		alert('Sub Category Code should a number');
		return false;
	}
	return true;
}

</script>
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
    <td colspan="5" align="center"><span class="title"><strong>Users</strong></span></td>
  </tr>
  <tr>
  	<td width="15%"></td>
    <td width="15%" class="style3" valign="top">Group</td>
    <td width="1102" class="style3"><label>
      <select name="lstMCatCode" id="lstMCatCode" onchange="submit()">
	  <option value="0">Select... </option>
	  <?php 
	  $sql = "SELECT * FROM `user_groups`"; //list of Category.....
	  $result= mysql_query($sql) or die(mysql_error());
	  while($row = mysql_fetch_array($result))
	  {
	  ?>
	  <option value="<?php echo $row['id']?>" 
			<?php 
			if (!isset($_REQUEST['lstMCatCode'])) 
			$_REQUEST['lstMCatCode'] = "undefine"; 
			if($row['id']===$_REQUEST['lstMCatCode'])
			echo " selected=\"selected\" " ;
		?>>
	  <?php	 
		echo $row['name'];
	  ?>
	  </option>
	  <?php
		}
		?> 	
      </select>
    </label></td>
    <td width="199" class="style3">Current users </td><td width="15%"></td>
  </tr>
  <tr>
   	 <td width="15%"></td>
     <td width="188" height="26">Username</td>
    <td><label for="label"></label>
      <input name="txtuname" type="text" id="txtuname" value="<?php echo $uname;?>" /></td>
    <td rowspan="2" class="style3" valign="top">
  <!-- Show the Sub Category List-->
	<table border="0" cellspacing="0" cellpadding="0" width="260px">
							  
<?php if ($_REQUEST['lstMCatCode']<>0) 
{  
		$sql="SELECT * FROM `users` WHERE `group`='$lstMCatCode'";
		$result = mysql_query($sql) or die(mysql_error());
		$a=1;
		while($row=mysql_fetch_assoc($result))
			{
?>								
	<tr valign="top"align=""><td <?php if ($a%2==0) echo "bgcolor=\"#C4C4C4\""; else echo "bgcolor=\"#E3E3E3\"";  ?> >
	<?php echo "<font class=\"style3\" style=\"font-weight:normal\">".$row['username']. " - ".$row['email']."</font>"."<br>"; ?></td></tr>
 	 <?php $a++;}//end while 
		}//end if ?></table>
		<!-- End  -->
  </td>
  </tr>
  <tr>
    <td width="15%"></td><td height="26">Password</td>
    <td colspan="2"><input type="password" name="txtpw"  id="txtpw" value="<?php echo $pw;?>" />
      <span style="color:#990000"><?php echo $emsg ; ?></span></td>
  </tr>
  <tr>
    <td width="15%"></td><td height="26">Re-type password</td>
    <td colspan="2"><input type="password" name="txtpw2"  id="txtpw2" value="<?php echo $rtpw;?>" />
      <span style="color:#990000"><?php echo $emsg ; ?></span></td>
  </tr>
  <tr>
    <td width="15%"></td><td height="26">email</td>
    <td colspan="2"><input name="txtemail" type="text" id="txtemail" value="<?php echo $em;?>" />
      <span style="color:#990000"><?php echo $emsg ; ?></span></td>
  </tr>
  <tr height="50px"></tr>
	<tr><td height="26" colspan="4" style="padding-right:525px" align="right"><input class="btn2" type="submit" name="btnsave" value="Save" id="btnsave"  <?php echo $savebtn; ?> />
	<input class="btn2" type="submit" name="btndelete" value="Remove" id="btndelete"  <?php echo $delbtn; ?> />
			<!--input name="btnClear" type="submit" id="btnClear" value="Clear" class="btn2"/>
			<input name="btnExit" type="submit" class="btn2" id="btnExit" value=" Exit " /--></td>
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
