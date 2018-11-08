<?php
require('getconnection.php');
$flag=0;

$tfac=$_POST['lstfac'];
$tdept=$_POST['lstdept'];
$tprog=$_POST['lstprog'];
$titype=$_POST['lstitype'];

$tdate=date("Y/m/d");
$ty=date('Y',strtotime($tdate));

$fyear=$_POST['lstfyy'];
$fmonth=$_POST['lstfmm'];
$fdd=$_POST['lstfdd'];
$fdate=date("$fyear-$fmonth-$fdd");

$tyear=$_POST['lsttyy'];
$tmonth=$_POST['lsttmm'];
$tdd=$_POST['lsttdd'];
$tdate=date("$tyear-$tmonth-$tdd");
$flag=$_POST['hdflag'];
$sql="select * from item_type where item_type_name='$titype'";
$result=mysql_query($sql) or die("Mysql error2");
while ($row=mysql_fetch_array($result))
	   $titypecode=$row['item_type_code'];


$tfac1=addslashes(trim($tfac));

$sql="select * from division_masterfile where div_name='$tfac1'";
$result=mysql_query($sql) or die("Mysql error1q");
while ($row=mysql_fetch_array($result))
	   $tfaccode=$row['div_code'];

$tdept1=addslashes(trim($tdept));

$sql="select * from unit_masterfile where unit_name='$tdept1' and div_code= '$tfaccode'";
$result=mysql_query($sql) or die("Mysql error21");
while ($row=mysql_fetch_array($result))
	   $tdeptcode=$row['unit_code'];

///

if ($flag==0)
{
$cdate=date("Y/m/d");

$fdd='1';
$fmonth='1';
$fyear=date('Y',strtotime($cdate));
$flag=1;
}

////



if (isset($_POST['btnprint']) or $_POST['btnprint']=="Print")
{
if ($tfac=='')

echo "<script> alert ('Please Enter Faculty')</script>";


else
header("location:rptgrnlist.php?id1=". $tfaccode."&id2=".$tdeptcode."&id3=".$tprogramcode."&id4=".$titypecode."&id5=".$fdate."&id6=".$tdate);
}


if (isset($_POST['btnexit']) or $_POST['btnexit']=="Exit")
header("location:homeindex.php");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GRN Listing</title>
<link rel="stylesheet" href="css/style.css" type="text/css"></head>

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
        <td colspan="2">
          <input name="hdflag" type="hidden" id="hdflag" value="<?php echo $flag ;?>" />
        </td>
      </tr>
      <tr>
        <td width="15%"></td>
    	<td align="left"  width="25%">Division</td>
        <td width="847"><strong>
          <select name="lstfac" size="1" id="lstfac" onchange="submit()" class="styleselect1">
            <option selected="selected"><?php echo $tfac;?></option>
            <?php
	  
	
	  $sql="select * from division_masterfile order by div_name ";
		  $result=mysql_query($sql) or die("Error in SQL");
		  while($row=mysql_fetch_array($result))
		  echo '<option>'.$row['div_name'].'</option>' ;   	 
		 
		 
		  
	  ?>
          </select>
        </strong></td>
      </tr>
      <tr>
        <td width="15%"></td>
    <td align="left"  width="25%">Unit</td>

        <td><select name="lstdept" id="lstdept" onchange="submit()"  class="styleselect1">
		<option selected="selected"><?php echo $tdept;?></option>
          <?php
		
		 $q1=addslashes(trim($tfac)); 
$sql="select * from division_masterfile where div_name='$q1'"	;   
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	   
	   $pcode=$row['div_code'];

		 
		 ///
		  
 $sql="select * from unit_masterfile where div_code='$pcode' order by unit_name ";
		  $result=mysql_query($sql) or die("Error in SQL");
		  while($row=mysql_fetch_array($result))
		  echo '<option>'.$row['unit_name'].'</option>' ;  
		 
?>
        </select></td>
      </tr>
      <tr>
        <td></td><td>Item Type</td>
        <td><select name="lstitype" id="lstitype" class="styleselect1">
          <option selected="selected"><?php echo $titype; ?></option>


          <?php

		$sql="select * from item_type order by item_type_name "	;   
	     
		 
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	    				
		echo '<option>'.$row['item_type_name'].'</option>'  ;			
		
		?>
        </select></td>
      </tr>
      <tr>
        <td></td><td>From</td>
        <td><strong>
          <select name="lstfdd" id="lstfdd" class="styleselect1">
            <option selected="selected"><?php echo $fdd;?></option>
            <?php
	  //echo '<option>'.'-dd-'.'</option>';
	  for ( $i=1;$i<=31;$i++)
	 {echo '<option>'.$i.'</option>';
	  }
	   	  
	  ?>
          </select>
          <select name="lstfmm" id="lstfmm" class="styleselect1">
            <option selected="selected"><?php echo $fmonth;?></option>
            <?php
		  for ( $i=1;$i<=12;$i++)
	 {echo '<option>'.$i.'</option>';
	  }
		?>
          </select>
          <select name="lstfyy" id="lstfyy" class="styleselect1">
            <option selected="selected"><?php echo $fyear;?></option>
            <?php
	  	  
	  for ( $i=2012;$i<=$ty;$i++)
	  {echo '<option>'.$i.'</option>';
	  }
	  	    
	  ?>
          </select>
        </strong></td>
      </tr>
      <tr>
        <td height="28"></td><td>To</td>
        <td height="28"><select name="lsttdd" id="lsttdd" class="styleselect1">
          <option selected="selected"><?php echo $tdd;?></option>
          <?php
	  //echo '<option>'.'-dd-'.'</option>';
	  for ( $i=1;$i<=31;$i++)
	 {echo '<option>'.$i.'</option>';
	  }
	   	  
	  ?>
        </select>
          <select name="lsttmm" id="lsttmm" class="styleselect1">
            <option selected="selected"><?php echo $tmonth;?></option>
            <?php
	//	 echo '<option>'.'-mm-'.'</option>';
		  for ( $i=1;$i<=12;$i++)
	 {echo '<option>'.$i.'</option>';
	  }
		?>
          </select>
          <select name="lsttyy" id="lsttyy" class="styleselect1">
            <option selected="selected"><?php echo $tyear;?></option>
            <?php
	  // echo '<option>'.'-yy-'.'</option>';
	  
	  for ( $i=2012;$i<=$ty;$i++)
	  {echo '<option>'.$i.'</option>';
	  }
	  
	  
	  
	  ?>
          </select></td>
      </tr>
      <tr>
        <td height="28" colspan="2"><input name="btnGRN" type="button" class="style3" id="btnGRN" value="GRN List" onclick="if( validateform()){document.forms.item('form1').action='rptgrnlist.php';submit();};"/>
        <input name="btnexit" type="submit" id="btnexit" value="Exit" class="btn2" /></td>
      </tr>
    </table>
</form>
</body>
</html>
