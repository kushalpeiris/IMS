<?php
$flag=0;
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


if ($flag==0)
{
$cdate=date("Y/m/d");

$fdd='1';
$fmonth='1';
$fyear=date('Y',strtotime($cdate));
$flag=1;
}



if (isset($_POST['btnprint']) or $_POST['btnprint']=="Print")
//header("location:rptpobook.php?id1=".$_POST['hdno']."&id2=".$_POST['hdyear']."&id3=".$_POST['hduser']);
header("location:rptpobook.php?id1=".$fdate."&id2=".$tdate);


if (isset($_POST['btnexit']) or $_POST['btnexit']=="Exit")
header("location:homeindex.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Purchase Book</title>
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
        
          <input name="hdflag" type="hidden" id="hdflag" value="<?php echo $flag ;?>" />
        </tr>
      <tr><td width="15%"></td>
    <td align="left"  width="15%">From</td>
        <td width="886"><select name="lstfdd" id="lstfdd" class="styleselect1" onchange="submit()">
            <option selected="selected"><?php echo $fdd;?></option>
            <?php
	  //echo '<option>'.'-dd-'.'</option>';
	  for ( $i=1;$i<=31;$i++)
	 {echo '<option>'.$i.'</option>';
	  }
	   	  
	  ?>
          </select>
          <select name="lstfmm" id="lstfmm" class="styleselect1" onchange="submit()">
            <option selected="selected"><?php echo $fmonth;?></option>
            <?php
		  for ( $i=1;$i<=12;$i++)
	 {echo '<option>'.$i.'</option>';
	  }
		?>
          </select>
          <select name="lstfyy" id="lstfyy" class="styleselect1" onchange="submit()">
            <option selected="selected"><?php echo $fyear;?></option>
            <?php
	  	  
	  for ( $i=2017;$i<=$ty;$i++)
	  {echo '<option>'.$i.'</option>';
	  }
	  	    
	  ?>
          </select></td>
      </tr>
      <tr><td></td>
        <td>To</td>
        <td><select name="lsttdd" id="lsttdd" class="styleselect1" onchange="submit()">
          <option selected="selected"><?php echo $tdd;?></option>
          <?php
	  	  for ( $i=1;$i<=31;$i++)
	 {echo '<option>'.$i.'</option>';
	  }
	   	  
	  ?>
        </select>
          <select name="lsttmm" id="lsttmm" class="styleselect1" onchange="submit()">
            <option selected="selected"><?php echo $tmonth;?></option>
            <?php
	//	 echo '<option>'.'-mm-'.'</option>';
		  for ( $i=$fmonth;$i<=12;$i++)
	 {echo '<option>'.$i.'</option>';
	  }
		?>
          </select>
          <select name="lsttyy" id="lsttyy" class="styleselect1" onchange="submit()">
            <option selected="selected"><?php echo $tyear;?></option>
            <?php
	  // echo '<option>'.'-yy-'.'</option>';
	  
	  for ( $i=$fyear;$i<=$ty;$i++)
	  {echo '<option>'.$i.'</option>';
	  }
	  ?>
          </select></td>
      </tr>
      <tr>
        <td colspan="4" style="padding-right:800px" align="right"><input name="btnprint" type="submit" id="btnprint" value="Print" class="btn2"/></td>
      </tr>
    </table>
</form>
</body>
</html>
