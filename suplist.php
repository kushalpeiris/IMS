<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Supplier Reporting</title>
<link rel="stylesheet" href="css/style.css" type="text/css">

<?php 

session_start();
if (!$_SESSION["login"])
{
	header("Location:../login.php");
}

$tusername = $_SESSION["username"];
$tcurrentdate= $_SESSION["currentdate"];


require('db.inc.php');
include('styles.inc.php'); 
extract($_POST);
$tyear=strftime("%Y");
	
//***********************************************************************************

?>
</head>
<body>

<script>

function validateform()
{
	tsupcatyear = document.getElementById('lstSupYear');
	tsupcat=document.getElementById('lstSupCat');
	
	if (tsupcatcode.value=="")
	{
		alert ('Please select a Year!!!');
		return false;
	}
	if (tsupcatname.value=="")
	{
		alert ('Please select a Supplier Category!!!')
		return false;
	}
	return true;
}

//********************AJAX - Report Listing*******************************

function getXMLHttp()
{
  var xmlHttp

  try
  {
    //Firefox, Opera 8.0+, Safari
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    //Internet Explorer
    try
    {
      xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e)
    {
      try
      {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e)
      {
        alert("Your browser does not support AJAX!")
        return false;
      }
    }
  }
  return xmlHttp;
}

//*********************
function MakeRequest(url)
{
  var xmlHttp = getXMLHttp();
 
  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4)
    {
      HandleResponse(xmlHttp.responseText);
    }
  }

  xmlHttp.open("GET", url, false);
  xmlHttp.send(null);
}


//*****************************
function HandleResponse(response)
{
  document.getElementById('ResponseDiv').innerHTML = response;
}


//*********************************
function fprint(url,printr)
{
		if(printr==1)
		{
		var printa= confirm("Do you want to print the record?");
		if(printa)
		{
			MakeRequest(url + "&printr=1");
			return true;
		}
		else
		{
			return false;			
		}
		}
		<?php /*echo "unset($_REQUEST)" ;*/?>
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


<form id="form1" name="form1" method="post" action="" >

<table width="100%" border="0" id="cmd" style="background-color:lightblue;">
<tr>
		<td colspan="4" align="center"><span class="title"><strong>Supplier Listing </strong></span></td>											
	</tr>
<tr>
<td width="5%"></td>
    <td align="right" style="padding-right:50px" width="25%">Supplier Year </td>
    <td><label>
    <select name="lstSupYear" id="lstSupYear" onChange="submit()" class="styleselect1">
          <option value=0 selected="selected"> Select...</option>
          <option value="<?php echo $tyear-1; ?>"  <?php if ($_POST['lstSupYear']==$tyear-1) {echo "selected=\"selected\"";}?>> <?php echo $tyear-1; ?> </option>
          <option  value="<?php echo $tyear; ?>" <?php if ($_POST['lstSupYear']==$tyear) {echo "selected=\"selected\"";}?>> <?php echo $tyear; ?> </option>
          <option value="<?php echo $tyear+1; ?>" <?php if ($_POST['lstSupYear']==$tyear+1) {echo "selected=\"selected\"";}?>
> <?php echo $tyear+1; ?> </option>
    </select>
    </label>      <label></label></td>
    <td class="style3">&nbsp;</td>
  </tr>
  <tr>
  <td></td>
    <td align="right" style="padding-right:50px">Supplier Category </td>
    <td><label>
    <select name="lstSupCat" id="lstSupCat" onChange="submit()" class="styleselect1">
	<option value="0">Select... </option>
     <?php
	//include("db.inc.php");
	$sql="SELECT `sup_cat_code`,`sup_cat_name` FROM `supplier_category` order by 1 ";
	$result = mysql_query($sql) or die("Mysql error2");
	while($row=mysql_fetch_assoc($result))
	{
?>
<option value="<?php echo $row['sup_cat_code']?>" 
<?php 
	if (!isset($_REQUEST['lstSupCat'])) 
	$_REQUEST['lstSupCat'] = "undefine"; 
	//if (isset($row['supplier_code']) && $_REQUEST['lstSupplier']!=0)
	if($row['sup_cat_code']===$_REQUEST['lstSupCat'])
	echo " selected=\"selected\" " ;
?>>
<?php	 
	echo $row['sup_cat_code'].' - '.$row['sup_cat_name'];
?>
</option>
<?php
	}
?>
    </select>
    </label></td>
    <td class="style3">&nbsp;</td>
  </tr>
  <tr height="50px"></tr>
  <tr>
    <td colspan="3" style="padding-left:415px">
<input name="btnPrint" type="submit" class="btn2" width="40px" id="btnPrint" value="Print" <?php if(!isset($_REQUEST['lstSupCat']) || $_REQUEST['lstSupCat']==0 || !isset($_REQUEST['lstSupYear']) || $_REQUEST['lstSupYear']==0){?> disabled="disabled" <?php } ?> onclick="javascript: form.action='rptsupcatwise.php'; "/>
<span>
	<input name="btnAllSup" type="submit" id="btnAllSup" value="Print all" <?php if(!isset($_REQUEST['lstSupYear']) || $_REQUEST['lstSupYear']==0){?> disabled="disabled" <?php } ?> onclick="javascript: form.action='rptallsuplist.php'; " class="btn2" />
	</span>
	<label>
      
	</label></td>
    </tr></table>

</form>
</body>
</html>









