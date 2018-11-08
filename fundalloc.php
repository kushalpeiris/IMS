<?php
require('getconnection.php');

session_start(); 
$flag=0;
$cdate=date("Y/m/d");
$cyear=date('Y',strtotime($cdate));
$cyear1=$cyear-1;
$year=$_POST['lstyear'];
$proj=$_POST['lstproj'];
$dept=$_POST['lstdept'];
$prog=$_POST['lstprogram'];
$tfundcode=$_POST['lstfundcode'];
$grant=$_POST['lstgrant'];
$sgrant=$_SESSION['grant'];
$loguser = $_SESSION["username"];
$amount=intval(str_replace(',', '', $_POST['txtamount'])) ;

if ($sgrant!=$grant )
{
$tfundcode='';
$proj='';
$dept='';
$proj='';
$amount='';
}
$_SESSION['grant']=$grant;


$flag=$_POST['hdflag'];
$emsg='';
////
////
if (isset($_POST['btnclear']) or $_POST['btnclear']=="Clear")
{
$year='';
$tfundcode='';
$grant='';
$proj='';
$dept='';
$prog='';
$amount='';
$_SESSION['grant']='';
}

////
$proj1=addslashes(trim($proj));

$sql="select * from division_masterfile where div_name='$proj1'";
$result=mysql_query($sql) or die("Mysql error1q");
while ($row=mysql_fetch_array($result))
	   $faccode=$row['div_code'];


$dept1=addslashes(trim($dept));

$sql="select * from unit_masterfile where unit_name='$dept1' and div_code= '$faccode'";
$result=mysql_query($sql) or die("Mysql error2");
while ($row=mysql_fetch_array($result))
	   $deptcode=$row['unit_code'];

/////

$sql="select * from item_type_mf where item_type_name='$grant'";
$result=mysql_query($sql) or die("Mysql error22");
while ($row=mysql_fetch_array($result))
	   $grantcode=$row['item_type_code'];



///
if ($flag==0)
{
$_SESSION['seditflag']=0;
$flag=1;
$_SESSION['grant']='';

}

////////////////

if (isset($_POST['btnedit']) or $_POST['btnedit']=="Find")
{
$_SESSION['seditflag']=1;
//$editbtn="disabled";
$recno=0;

////
$i=0;

$fundcode='';
$x=substr($tfundcode,$i,1);

while ($x <> ' ') 
{
$fundcode=$fundcode.$x;
$i=$i+1;
$x=substr($tfundcode,$i,1);
}

//////

$sql="select * from fund_detail where grant_code='$grantcode' and  fund_code='$fundcode' and  year='$year' and fac_code='$faccode' and dept_code='$deptcode' and prog_code='$programcode'";
$result=mysql_query($sql) or die("Mysql error1q");
$recno= mysql_num_rows($result);
if($recno==0)
echo "<script> alert ('Record Not Found')</script>";



if($recno>0)
{
while ($row=mysql_fetch_array($result))
$amount=$row['amount'];
}

}

////////////

if (isset($_POST['btnsave']) or $_POST['btnsave']=="Save")
{
$error==0 ;
$recno=0;

if (!is_numeric($amount)and $amount!='' )
{$emsg="Please Enter a Numeric Value for Amount";
 $error=1;
 }

if ($amount=='')
{$emsg="Please Enter Amount";
 $error=1;
 }

if ($proj=='')
{$emsg="Please Select Faculty";
 $error=1;
 }

if ($grantcode=='')
{$emsg="Please Select Grant";
 $error=1;
 }

if ($tfundcode=='')
{$emsg="Please Select Fund";
 $error=1;
 }


if ($year=='')
{$emsg="Please Select Year";
 $error=1;
 }


////

if ($error==0)
{

////
$i=0;

$fundcode='';
$x=substr($tfundcode,$i,1);

while ($x <> ' ') 
{
$fundcode=$fundcode.$x;
$i=$i+1;
$x=substr($tfundcode,$i,1);
}


////
$fundamt=0;
$totamt=0;

$sql="select * from fund where grant_code='$grantcode' and fund_code='$fundcode' and year='$year'";
$result=mysql_query($sql) or die("Mysql error1q");
while ($row=mysql_fetch_array($result))
	   $fundamt=$row['amount'];

$sql="select sum(amount) as t from fund_detail where grant_code='$grantcode' and fund_code='$fundcode' and  year='$year' and !( fac_code='$faccode' and dept_code='$deptcode' and prog_code='$programcode') ";
$result=mysql_query($sql) or die("Mysql error2q");
while ($row=mysql_fetch_array($result))
	   $totamt=$row['t'];

$available=$fundamt - $totamt ;

if ($amount>$available)
{$emsg='Funds not available';
 $error=1;
 }
}


if ($error==0)
{
$fgiven=0;

$sql="select sum(grnm_value_more) as tm, sum(grnm_value_less) as tl from grn_master where grnm_fund_code='$fundcode' and grnm_grant_code='$grantcode' and grnm_fund_yr='$year' and grnm_fund_fac='$faccode' and grnm_fund_dept='$deptcode' and grnm_fund_prog='$programcode' and (purchase_type_flag='PendingGRN' or purchase_type_flag='NormalGRN' or purchase_type_flag='ApprovedGRN')";		
$result=mysql_query($sql) or die("Mysql error1qq");
  
while ($row=mysql_fetch_array($result))
	  {
	   $more=$row['tm'];
       $less=$row['tl'];
}

/////
$sql1="select sum(fund_amount) as t from purch_ord_mas where fund_code='$fundcode' and item_type_code='$grantcode' and pom_acct_yr='$year' and fund_fac='$faccode' and fund_dept='$deptcode' and fund_prog='$programcode' and pom_cancel<>'Y'";		


$result1=mysql_query($sql1) or die("Mysql error2q");
  
while ($row=mysql_fetch_array($result1))
	   $totfnd=$row['t'];
$fgiven=$totfnd + $more - $less ;

 
if ($amount<$fgiven)
{ 
$emsg1="Rs. ";
 $emsg2=" Already Allocated. Editing is not allowd";
$emsg=$emsg1.$fgiven.$emsg2;
 
 $error=1;
 }

}
/////

if ($error==0)


{


$proj1=addslashes(trim($proj));

$sql="select * from division_masterfile where div_name='$proj1'";
$result=mysql_query($sql) or die("Mysql error4q");
while ($row=mysql_fetch_array($result))
	   $faccode=$row['div_code'];

$dept1=addslashes(trim($dept));

$sql="select * from unit_masterfile where unit_name='$dept1' and div_code= '$projcode'";
$result=mysql_query($sql) or die("Mysql error23");
while ($row=mysql_fetch_array($result))
	   $deptcode=$row['unit_code'];


$program1=addslashes(trim($program));
$sql="select * from payroll_programme_mfile where prog_name='$program1' and unit_code='$deptcode' and div_code= '$faccode'";
$result=mysql_query($sql) or die("Mysql error42");
while ($row=mysql_fetch_array($result))
	   $programcode=$row['prog_code'];

/////////

$grantcode=strtoupper($grantcode);
$recno=0;

$sql="select * from fund_detail where year='$year' and fund_code='$fundcode' and grant_code='$grantcode' and fac_code='$faccode' and dept_code='$deptcode' and prog_code='$programcode'";
$result=mysql_query($sql) or die("Mysql error6a");  
	$recno= mysql_num_rows($result);
	
$d=strftime("%Y-%m-%d %H:%M:%S"); 
if ($recno==0)
{
$sql1="insert into fund_detail(year,fund_code,grant_code,fac_code,dept_code,prog_code,amount,user_add,user_add_date) values('$year','$fundcode','$grantcode','$faccode','$deptcode','$programcode','$amount','$loguser','$d')";
	$result1=mysql_query($sql1) or die("Mysql error");


$sql1="insert into txn_fund_detail(year,fund_code,grant_code,fac_code,dept_code,prog_code,amount,user,user_date) values('$year','$fundcode','$grantcode','$faccode','$deptcode','$programcode','$amount','$loguser','$d')";
	$result1=mysql_query($sql1) or die("Mysql error");



$proj='';
$dept='';
$prog='';
$grant='';
$tfundcode='';
$amount='';
$_SESSION['grant']='';
}
/////


if ($recno>0)
{
if ($_SESSION['seditflag']==1)
{
$sql1="update fund_detail set amount='$amount',user_mod='$loguser',user_mod_date='$d' where year='$year' and fund_code='$fundcode' and grant_code='$grantcode' and fac_code='$faccode' and dept_code='$deptcode' and prog_code='$programcode'" ;
  $result1=mysql_query($sql1) or die("Mysql error7"); 

$sql1="insert into txn_fund_detail(year,fund_code,grant_code,fac_code,dept_code,prog_code,amount,user,user_date) values('$year','$fundcode','$grantcode','$faccode','$deptcode','$programcode','$amount','$loguser','$d')";
	$result1=mysql_query($sql1) or die("Mysql error");


$proj='';
$dept='';
$prog='';
$grant='';
$tfundcode='';
$amount='';
$_SESSION['grant']='';
}

if ($_SESSION['seditflag']==0)
echo "<script> alert ('Record Found in the File.  Use <Find> to update Record')</script>";

}






}

$_SESSION['seditflag']=0;
}


if (isset($_POST['btnexit']) or $_POST['btnexit']=="Exit")
header("location:homeindex.php");


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<script type="text/javascript">

var xmlhttp;

function ShowHint(str)

{
 
  xmlhttp=GetXmlHttpObject();
  //Is browser creates the XMLHTTPRequest Object
  if(xmlhttp==null)
  {
  	alert("Your browser does not support XMLHTTP!");
	return;
  }

 
  var url="getaddress.php";

  url =url+"?q="+str;
  url=url+"&sid="+Math.random();
  xmlhttp.onreadystatechange=stateChanged;
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
 
}



function stateChanged()
{
  if (xmlhttp.readyState==4)
  {
  document.getElementById("txtaddress").innerHTML=xmlhttp.responseText;
  }
}



function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}

////////

function ShowHint2(str)
{
 
  xmlhttp=GetXmlHttpObject();
  //Is browser creates the XMLHTTPRequest Object
  if(xmlhttp==null)
  {
  	alert("Your browser does not support XMLHTTP!");
	return;
  }
 
  var url="getdept.php";
  url =url+"?q="+str;
  url=url+"&sid="+Math.random();
  xmlhttp.onreadystatechange=stateChanged2;
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
 
}


function stateChanged2()
{
  if (xmlhttp.readyState==4)
  {
  document.getElementById("lstdept").innerHTML=xmlhttp.responseText;
  }
}

//////////

function ShowHint3(str)
{
//alert (str);
   xmlhttp=GetXmlHttpObject();
  //Is browser creates the XMLHTTPRequest Object
  if(xmlhttp==null)
  {
  	alert("Your browser does not support XMLHTTP!");
	return;
  }
 
  var url="getitem.php";
  url =url+"?q="+str;
  url=url+"&sid="+Math.random();
  xmlhttp.onreadystatechange=stateChanged3;
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
 }


function stateChanged3()
{
  if (xmlhttp.readyState==4)
  {
  document.getElementById("lstitem").innerHTML=xmlhttp.responseText;
  }
}
////////

function ShowHint4(str)
{


//var str=str1.substr(0,7);
   xmlhttp=GetXmlHttpObject();
  //Is browser creates the XMLHTTPRequest Object
  if(xmlhttp==null)
  {
  	alert("Your browser does not support XMLHTTP!");
	return;
  }
  var url="getdes.php";
  url =url+"?q="+str;
  url=url+"&sid="+Math.random();
  xmlhttp.onreadystatechange=stateChanged4;
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
}


function stateChanged4()
{
  if (xmlhttp.readyState==4)
  {
  document.getElementById("lsticd").innerHTML=xmlhttp.responseText;
  }
}

////
function ShowHint5(str)
{
  xmlhttp=GetXmlHttpObject();
  //Is browser creates the XMLHTTPRequest Object
  if(xmlhttp==null)
  {
  	alert("Your browser does not support XMLHTTP!");
	return;
  }
 
  var url="getprogram.php";
  url =url+"?q="+str;
  url=url+"&sid="+Math.random();
  xmlhttp.onreadystatechange=stateChanged5;
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
}


function stateChanged5()
{
  if (xmlhttp.readyState==4)
  {
  document.getElementById("lstprogram").innerHTML=xmlhttp.responseText;
  }
}


////

function dellst(x)

{
 var elSel = document.getElementById(x);
 
  var i;
  for (i = elSel.length - 1; i>=0; i--) {
      elSel.remove(i);
  }
}

//////

//function GetConfirmation()

function dismessage()
{
	alert ("Invalid Purchase Order No.");
	
		var btn=document.getElementById("btnsave");
		btn.value="Savet";
        document.editForm.submit();
}

//////

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 


////

</script>


<style type="text/css">
<!--
.style1 {
	font-size: 24px;
	font-weight: bold;
	font-style: italic;
	border: 1;
	color: #000033;
}
.style6 {
	font-size: 18px;
	color: #FFFFFF;
}
-->
</style>

</head>

<body>
<form id="form1" name="form1" method="post" action="">
<table width="873" height="253" border="1">
  <tr>
    <td height="34" bgcolor="#999999"><span class="style1"><span class="style6">Fund Allocation </span>
          <label for="textfield"></label>
          <input name="hdflag" type="hidden" id="hdflag" value="<?php echo $flag ;?>" />
    </span></td>
    <td bgcolor="#999999"><div align="right"><strong>
      <input type="submit" name="btnsave" value="Save" id="btnsave"  <?php echo $savebtn; ?> />
      </strong><strong>
      <input name="btnexit" type="submit" id="btnexit" value="Exit" />
      <input name="btnclear" type="submit" id="btnclear" value="Clear" />
      </strong></div></td>
  </tr>
  
  <tr>
    <td width="226" height="26"><strong>Year</strong></td>
    <td><label for="label"></label>
    <label for="label">
    <select name="lstyear" id="lstyear" onchange="submit()">
      <option selected="selected"><?php echo $year;?></option>
      <?php
	 
	echo '<option>'.$cyear.'</option>';
	echo '<option>'.$cyear1.'</option>';	  
		  
	?>
    </select>
    </label></td>
  </tr>
  <tr>
    <td height="29"><strong>Grant</strong></td>
    <td><select name="lstgrant" id="lstgrant" onchange="submit()">
      <option selected="selected"><?php echo $grant; ?> </option>
      <?php
		$sql="select * from grants order by grant_code "	;   
	     
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	    				
		echo '<option>'.$row['grant_code'].'</option>'  ;			
		
		?>
    </select></td>
  </tr>
  <tr>
    <td height="29"><strong>Fund</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="29"><strong>Faculty</strong></td>
    <td><select name="lstproj" size="1" id="label5"  onchange="ShowHint2(this.value)">
      <option selected="selected"><?php echo $proj; ?></option>
      <?php
		
						
		  $sql="select * from division_masterfile order by div_name ";
		  $result=mysql_query($sql) or die("Error in SQL");
		  while($row=mysql_fetch_array($result))
		  echo '<option>'.$row['div_name'].'</option>' ;  
		
		  ?>
    </select>      <div align="center"></div></td>
    </tr>
  <tr>
    <td height="29"><strong>Department</strong></td>
    <td><select name="lstdept" size="1" id="lstdept" onchange="submit()"  >
      <option selected="selected"><?php echo $dept;?></option>
      <?php 
		
		 $q1=addslashes(trim($proj)); 
			
		$sql="select * from division_masterfile where div_name='$q1'"	; 

	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	   
	   $pcode=$row['div_code'];
		$sql="select * from unit_masterfile where div_code='$pcode' order by unit_name ";
		
		  $result=mysql_query($sql) or die("Error in SQL");
		  while($row=mysql_fetch_array($result))
		  echo '<option>'.$row['unit_name'].'</option>' ;  
		 


?>
    </select></td>
    </tr>
  <tr>
    <td height="29"><label for="Submit"><strong>Programme</strong></label></td>
    <td><label for="label5"></label>
        <label for="label"></label>
        <label for="select"></label>
        <label for="label2"></label>
        <label for="label5"></label>
      <label for="label2">
        <input name="btnedit" type="submit" onclick="" id="btnedit" value="Find" />
      </label></td>
    </tr>
  
  <tr>
    <td height="28"><strong>Amount</strong></td>
    <td><input name="txtamount" type="text" id="txtamount" value="<?php echo number_format($amount,2);?>" />
      <span style="color:#990000"><?php echo $emsg ; ?></span> </td>
  </tr>
</table>
<p>
  <label for="textarea"></label>
</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

 
</form>
</body>
</html>

