<?php

session_start(); 
require('db.inc.php');
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

if (!$_SESSION["login"])
{
	header("Location:../login.php");
}

if (isset($_POST['btnExit']) || $_POST['btnExit']=="Exit")
{
	header("location:homeindex.php");
}
$tcurrentdate= $_SESSION["currentdate"];
$loguser = $_SESSION["username"];
$sql = "SELECT `group` FROM `users` WHERE `username`='$loguser'";
	$result= mysql_query($sql) or die();
	while($row=mysql_fetch_assoc($result))
$tusergroup = $row['group'];
$tdatetime=strftime("%Y-%m-%d %H:%M:%S");
$pomark = '';
$hdUser =0;

$tn=(int)$_POST['txtno'] ;
$tyear=$_POST['txtyear'];

$cancelbtn="disabled";
/* if(($loguser == 'admin')||$tusergroup=='1'){
			$cancelbtn="";
			} */

function confund(){
$fund=$_POST["lstfund"] ;
$funddept=$_POST["lstfdept"] ;
$cdate=date("Y/m/d");
$cyear=date('Y',strtotime($cdate));
$tno=$_POST['txtno'];
$tn=(int)$tno ;
$tyear=$_POST['txtyear'];

$titype=$_POST['lstitemtype'];
$sql="select * from item_type where item_type_name='$titype'";
$result=mysql_query($sql) or die("Mysql error27");
while ($row=mysql_fetch_array($result))
	   $titypecode=$row['item_type_code'];

 $i=0;
 $len=strlen($funddept);
 $tffac='';
 $tfdept='';
 $tfprog='';
 $tcount=0;
 $printbtn="";
	while ($i<$len)
 {

 if (substr($funddept,$i,1)=='|')
 $tcount++;

 if (substr($funddept,$i,1)<>'|' and $tcount==0)

 $tffac=$tffac.substr($funddept,$i,1);

 if (substr($funddept,$i,1)<>'|' and $tcount==1)
 $tfdept=$tfdept.substr($funddept,$i,1);

 if (substr($funddept,$i,1)<>'|' and $tcount==2)
 $tfprog=$tfprog.substr($funddept,$i,1);

 $i++;


 }

 if ($tcount==1)
 {
 $tffac=trim($tffac);
 $tfdept='';
 }

 if ($tcount==2)
 {
 $tffac=trim($tffac);
 $tfdept=trim($tfdept);
 $tfprog='';
 }

 if ($tcount==3)
 {
 $tffac=trim($tffac);
 $tfdept=trim($tfdept);
 $tfprog=trim($tfprog);
 }

////

 $ffaccode='';
 $fdeptcode='';
 $fprogramcode='';
 $tffac1=addslashes(trim($tffac));

 $sql="select * from division_masterfile where div_name='$tffac1'";
 $result=mysql_query($sql) or die("Mysql error1q");
 while ($row=mysql_fetch_array($result))
	   $ffaccode=$row['div_code'];

 $tfdept1=addslashes(trim($tfdept));

 $sql="select * from unit_masterfile where unit_name='$tfdept1' and div_code= '$ffaccode'";
 $result=mysql_query($sql) or die("Mysql error28");
 while ($row=mysql_fetch_array($result))
	   $fdeptcode=$row['unit_code'];

 
 $sql="select * from fund_detail where itype_code='$titypecode' and year='$cyear' and div_code='$ffaccode' and unit_code='$fdeptcode'";
 $result=mysql_query($sql) or die("Mysql error21");
 while ($row=mysql_fetch_array($result))
	   	 
	  $famt=$row['amount'] ;

/////
 $more=0;
 $less=0;

 return $famt;
}
$newpobtn="disabled";

$approvebtn="disabled";
$roy="";
$emsg="";

$flag=0;
$error=0;
$pnbt=0;
$pvat=0;
$othertax=0;
$warranty=0;
$tuprice=0;
$tsname="";
$taddress="";
$tpro="";
$tdept="";
$tprogram="";
$tsref="";
$turef="";
$freight=0;
$insurance=0;
$fother=0;
$foreignflg='disabled';
$foreignflg1='';
$fund='';
$totval=0;
$titype=$_POST['lstitemtype'];
$tsname=$_POST['lstsname'];

$taddress=$_POST['txtaddress'];
$tpro=$_POST['lstproj'];
$tdept=$_POST['lstdept'];
$tprogram=$_POST['lstprogram'];
$tyear=$_POST['txtyear'];
$tuser=$_POST['txtuser'];
$tno=$_POST['txtno'];
$turef=$_POST['txturef'];
$tsref=$_POST['txtsref'];
$tcur=$_POST['lstcur'];
$terate=trim($_POST['txterate']);
$titem=$_POST['lstitem'];
$tqty=$_POST['txtqty'];
$tuprice=$_POST['txtuprice'];
$pnbt=$_POST['txtnbt'];
$pvat=$_POST['txtvat'];
$othertax=$_POST['txtothertax'];
$warranty=$_POST['txtwarr'];
$tdes=$_POST['txtdes'];
$tdate = $_POST['hddate'];
$flag=$_POST['hdflag'];
$totval=$_POST['hdtotval'];
$freight=$_POST['txtfreight'];
$insurance=$_POST['txtinsurance'];
$fother=$_POST['txtfother'];

$tn=(int)$tno ;
$pocancel=0;
$funddept=$_POST["lstfdept"] ;
$fund=$_POST["lstfund"] ;

$cdate=date("Y/m/d");
$cyear=date('Y',strtotime($cdate));

$sql="select * from item_type where item_type_name='$titype'";
$result=mysql_query($sql) or die("Mysql error22");
while ($row=mysql_fetch_array($result))
	   $titypecode=$row['item_type_code'];

$tpro1=addslashes(trim($tpro));

$sql="select * from division_masterfile where div_name='$tpro1'";
$result=mysql_query($sql) or die("Mysql error1q");
while ($row=mysql_fetch_array($result))
	   $tfaccode=$row['div_code'];
$tdept1=addslashes(trim($tdept));

$sql="select * from unit_masterfile where unit_name='$tdept1' and div_code= '$tfaccode'";
$result=mysql_query($sql) or die("Mysql error23");
while ($row=mysql_fetch_array($result))
	   $tdeptcode=$row['unit_code'];

$sql="select * from supplier where supplier_name='$tsname' order by sup_year desc limit 1";
$result=mysql_query($sql) or die("Mysql error11");

while ($row=mysql_fetch_array($result))
{	   
$tsupcode=$row['supplier_code'];
$tsupyear = $row['sup_year'];
$taddress=$row['supplier_address1']."\n".$row['supplier_address2']."\n".$row['supplier_address3']."\n".$row['sup_address4']  ;
}

$titem1=addslashes(trim($titem)); 
$sql="select *  from item_masterfile where item_description='$titem1'";

$result=mysql_query($sql) or die("Mysql error");
while ($row=mysql_fetch_array($result))
$ticode=$row['item_code'];

if (isset($_POST['btnexit']) or $_POST['btnexit']=="Exit")
header("location:homeindex.php");


if (isset($_POST['btnprint']) or $_POST['btnprint']=="Print")
header("location:rptporder.php?id1=".$_POST['hdno']."&id2=".$_POST['hdyear']."&id3=".$_POST['hduser']."&id5=".$_POST['hdsupyear']);

if (isset($_POST['btncancel']) or $_POST['btncancel']=="Cancel Order")
{
if($tusergroup=='1'){
$pocancel=1;
$editbtn="disabled";}
else
echo "<script> alert ('not authorized')</script>";
}

if (isset($_POST['btncanpur']) or $_POST['btncanpur']=="Cancel PO")
{
$savebtn="disabled";
$printbtn="disabled";
$editbtn="disabled";
$error=0;

$remark=$_POST['txtremark'];

if ($remark=="")
{
echo "<script> alert ('Please enter Remarks')</script>";
$error=1;
$pocancel=1;

}


if ($error==0)
{
$sql="select * from purch_ord_mas where pom_po_no='$tn' and pom_acct_yr='$tyear'";
$result=mysql_query($sql) or die("Mysql error!");
 
$sql2="update purch_ord_mas set pom_cancel='Y' where pom_po_no='$tn' and pom_acct_yr='$tyear'" ;
$result2=mysql_query($sql2) or die("Mysql error7");   

$sql1="insert into purchase_cancel(pic_num,pic_acct_yr,pic_date,pic_remarks,pic_user_can) values ('$tn','$tyear','$tdatetime','$remark','$loguser')";
$result1=mysql_query($sql1) or die("Mysql error10");
echo "<script> alert ('PO Cancelled')</script>";
}
}
if (isset($_POST['btnapprove']) or $_POST['btnapprove']=="Approve PO")
{
$sql="update purch_ord_mas set po_approved='Y',user_approved='$loguser',date_approved='$tdatetime',val_approved='$totval'  where pom_po_no='$tn' and pom_acct_yr='$tyear' and pom_po_mark ='$pomark'" ;

	  $result=mysql_query($sql) or die("Mysql error72");   

echo "<script> alert ('PO Approved')</script>";

$printbtn="";
$savebtn="disabled";
$editbtn="disabled";;

}
if ($flag==0 and !(isset($_POST['btndelete'])))
{
$tdate=date("Y/m/d");

$sql="delete from tporder where user='$loguser'";
$result=mysql_query($sql) or die("Mysql error1");
$flag=1;
$tyear=date('Y',strtotime($tdate));
$maxno=0;
$terate=1;
$tcur='Rs.';
$savebtn="disabled";
$printbtn="disabled";
$editbtn="";
$totval=0;
$_SESSION['sfund']='';

$sql="select max(pom_po_no) as t  from purch_ord_mas where pom_acct_yr='$tyear'";
$result=mysql_query($sql) or die("Mysql error");

while ($row=mysql_fetch_array($result))
	   $maxno=$row['t']  ;

$tno=str_pad($maxno+1,5,0,STR_PAD_LEFT);
$_SESSION['duetno']=$tno;
$_SESSION['dueyear']=$tyear;

$tuser=$_SESSION["username"];
$_SESSION['editflg']=0;
$_SESSION['addno']=0;
$_SESSION['noedit']=0;
$_SESSION['nofund']=0;
}
if ($_SESSION['sfund']<>$fund)
$funddept='';


if ($tcur <> 'Rs.')
{
$foreignflg='';
$foreignflg1='disabled';
}

if ($_SESSION['stcur'] <> $tcur)
$terate=1;

if ($tcur == 'Rs.')
{
$terate=1;
}

if ($_SESSION['noedit']==1)
{
$savebtn="disabled";
$addbtn="disabled";
}
if (isset($_POST['btnnewpo']) or $_POST['btnnewpo']=="New PO #")
{

$sql="select max(pom_po_no) as t  from purch_ord_mas where pom_acct_yr='$tyear' ";

$result=mysql_query($sql) or die("Mysql error");

while ($row=mysql_fetch_array($result))
	   $maxno=$row['t']  ;

$tno=str_pad($maxno+1,5,0,STR_PAD_LEFT);
$_SESSION['duetno']=$tno;
$printbtn="disabled";

}

if (isset($_POST['btnFind']) or $_POST['btnFind']=="Find")
{
$_SESSION['editflg']=1;
$tyear=$_POST['txtyear'];
$tuser=$_POST['txtuser'];
$tno=$_POST['txtno'];
$sname=$_POST['lstsname'];
$tno=str_pad((int)$tno,5,0,STR_PAD_LEFT);
$tn=(int)$tno ;
$tsname="" ;
$taddress=""; 
$tpro="";
$tdept="";
$tprogram='';
$turef="" ;
$tsref=""  ;
$tcur='Rs.';
$tdate=""  ;
$terate=1 ;
$titype=""  ;
$ffac='';
$fdept='';
$fprog='';


$sql="delete from tporder where user='$loguser' ";
$result=mysql_query($sql) or die("Mysql errora");

	$printbtn="";
	$savebtn="";

	$fndflg=0;

	$sql="select * from purch_ord_mas where pom_po_no='$tn' and pom_acct_yr='$tyear'";
	$result=mysql_query($sql) or die("Mysql error!");

	while ($row=mysql_fetch_array($result))
	{
	$fndflg=1;
	$tcan=$row['pom_cancel']  ;
	$tsupcode=$row['pom_sup_code']  ;
	$tsupyr=$row['pom_sup_year']  ;
	$tsupyear=$row['pom_sup_year']  ;
	$turef=$row['pom_uni_reference']  ;
	$tsref=$row['pom_reference']  ;
	$tcur=$row['pom_currency']  ;
	$tfaccode=$row['div_code']  ;
	$tdeptno=$row['unit_code']  ;
	$tprogramno=$row['prog_code'];
	$tdate=$row['pom_date']  ;
	$terate=$row['pom_exchrate']  ;
	$titypecode=trim($row['item_type_code'])  ;
	$tuser=$row['user_add']  ;
	$tgrnr=$row['pom_grn_raised']; 
    $freight=$row['freight']  ;
	$insurance=$row['insurance']  ;
	$fother=$row['for_other']  ;
	$fund=$row['fund_code']  ;
	$ffaccode=$row['fund_fac']  ;
	$fdeptcode=$row['fund_dept']  ;
	$fprogramcode=$row['fund_prog']  ;
	$titemval=$row['item_val']  ;
	$tfundavail=$row['fund_avail']  ;
    $tapprovepo=$row['po_approved']  ;
	$tapproveval=$row['val_approved']  ;
	$totval=$row['fund_amount'];
			
if ($tfundavail=='N' and $tapprovepo=='' and $tusergroup=='G' )	
$approvebtn="";
	
if ($tcur <> 'Rs.')
{
$foreignflg='';
$foreignflg1='disabled';
}
else
{
$foreignflg1='';
$foreignflg='disabled';
}    
}


 if ($fndflg==1)
 {

	$sql2="select * from item_type where item_type_code='$titypecode'";
	$result2=mysql_query($sql2) or die("Mysql errorz");

	while ($row=mysql_fetch_array($result2))
	{
	$titype=$row['item_type_name'];
    $_SESSION['stitype']=$titype;
	}
	$sql="select * from supplier where supplier_code='$tsupcode' and sup_year='$tsupyr' ";
	$result=mysql_query($sql) or die("Mysql errorz");


	while ($row=mysql_fetch_array($result))
	{
	$tsname=$row['supplier_name'];

	$taddress=$row['supplier_address1']."\n".$row['supplier_address2']."\n".$row['supplier_address3']."\n".$row['sup_address4']  ;

	}
	$sql="select * from division_masterfile where div_code='$tfaccode'";
	$result=mysql_query($sql) or die("Mysql errorq");

	while ($row=mysql_fetch_array($result))

	$tpro=$row['div_name']  ;

	$sql="select * from unit_masterfile where unit_code='$tdeptno'";
	$result=mysql_query($sql) or die("Mysql error");

	while ($row=mysql_fetch_array($result))
	$tdept=$row['unit_name'] ;
	
	$sql="select * from division_masterfile where div_code='$ffaccode'";
	$result=mysql_query($sql) or die("Mysql errorq");
	while ($row=mysql_fetch_array($result))
	$tffac=$row['div_name']  ;

	$sql="select * from unit_masterfile where unit_code='$fdeptcode'";
	$result=mysql_query($sql) or die("Mysql error");
	while ($row=mysql_fetch_array($result))
	$tfdept=$row['unit_name'] ;

	$sql="select * from fund_detail where grant_code='$titypecode' and year='$cyear' and div_code='$ffaccode' and unit_code='$fdeptcode'";
	$result=mysql_query($sql) or die("Mysql error24");
	while ($row=mysql_fetch_array($result))
	  $famt=$row['amount'] ;

$more=0;
$less=0;

$sql="select sum(grnm_value_more) as tm, sum(grnm_value_less) as tl from grn_master where grnm_fund_code='$fund' and grnm_grant_code='$titypecode' and grnm_fund_yr='$cyear' and grnm_fund_fac='$ffaccode' and grnm_fund_dept='$fdeptcode' and grnm_fund_prog='$fprogcode' and (purchase_type_flag='PendingGRN' or purchase_type_flag='NormalGRN' or purchase_type_flag='ApprovedGRN' )";	
$result=mysql_query($sql) or die("Mysql error1q1");
while ($row=mysql_fetch_array($result))
	  {
	   $more=$row['tm'];
       $less=$row['tl'];
		}
 
$sql1="select sum(fund_amount) as t from purch_ord_mas where item_type_code='$titypecode' and pom_acct_yr='$cyear' and fund_fac='$ffaccode' and fund_dept='$fdeptcode' and pom_cancel<>'Y' and (fund_avail='Y' or po_approved='Y') and  !(pom_po_no='$tn' and pom_acct_yr='$tyear')";		
$result1=mysql_query($sql1) or die("Mysql error1q2");
  
while ($row=mysql_fetch_array($result1))
	   $ttotfnd=$row['t'];


 $tavailable = $famt + $less  - ($ttotfnd + $more) ;

if ($tffac<>'' and $tfprog<>'' and $tfdept<>'')
	$funddept=$tffac.' | '.$tfdept.' | '.$tfprog.' |   ('.  number_format($tavailable,2).')';  
	if ($tfprog=='' and $tfdept<>'' and $tffac<>'')
	$funddept=$tffac.' | '.$tfdept.' |  ('.  number_format($tavailable,2).')' ;  
	if ($tfprog=='' and $tfdept=='' and $tffac<>'')
	$funddept=$tffac.' |  ('.  number_format($tavailable,2).')' ;  

	$sql="delete from tporder where user='$loguser'";
	$result=mysql_query($sql) or die("Mysql errora");

	$sql="select * from purch_ord_det where pod_po_no='$tn' and pod_acct_yr='$tyear' and pod_po_mark='$pomark'";
	$result=mysql_query($sql) or die("Mysql errorb");
	while ($row=mysql_fetch_array($result))
	{
	$tit=$row['pod_item_code']  ;
	$tde=$row['pod_des']  ;
	$tqt=$row['pod_qty']  ;
	$tup=$row['pod_unit_price']  ;
	$tnb=$row['pod_nbt']  ;
	$tva=$row['pod_vat']  ;
	$tothertax=$row['pod_other']  ;
	$tval=$row['pod_amount']  ;

	$sql="select * from item_masterfile where item_code='$tit'";
	$result1=mysql_query($sql) or die("Mysql errorb");
	while ($row=mysql_fetch_array($result1))
	$tide=$row['item_description']  ;
	$tide1=addslashes(trim($tide));
	$tde1=addslashes(trim($tde));

	$sql1="insert into tporder(itemcode,itemdes,des,qty,uprice,nbt,vat,otax,val,user) values ('$tit','$tide1','$tde1','$tqt','$tup','$tnb','$tva','$tothertax','$tval','$loguser')";
	$result1=mysql_query($sql1) or die("Mysql error");
	
	if ($tuser==$loguser or $tusergroup=='1')
	$cancelbtn="";
	}
$vtno=(int)$tno ;

$gdrno=0;
	$sql9="select * from grn_detail where grnd_po_no='$vtno' and grnd_po_acct_yr='$tyear' and grnd_mark='$pomark' and (grnd_po_status = 'Approved' or grnd_po_status = 'Normal' or grnd_po_status = 'Pending' ) ";
	$result9=mysql_query($sql9) or die("Mysql errorb");
	$gdrno= mysql_num_rows($result9);

if ($tcan=='Y')
{
echo "<script> alert ('Editing NOT permited. This PO is Cancelled')</script>";
$savebtn="disabled";
$cancelbtn="disabled";
$addbtn="disabled";
$printbtn="";
$_SESSION['noedit']=1;
}

if ($gdrno>0)
{
echo "<script> alert ('Editing NOT permited. GRN Raised for this PO.')</script>";
$savebtn="disabled";
$cancelbtn="disabled";
$printbtn="";
$addbtn="disabled";
$_SESSION['noedit']=1;
}

if ($tfundavail=='N' and $tapprovepo<>'Y')
$printbtn="disabled";
$editbtn="disabled";
}
if ($fndflg==0)
{
echo "<script> alert ('Record not found.')</script>";
$error=1;
$savebtn="disabled";
$printbtn="disabled";
$cancelbtn="disabled";
$tdate=date("Y/m/d");
}
}

if (isset($_POST['btndelete']) or $_POST['btndelete']=="Delete")
{
$cancelbtn="disabled";
$printbtn="disabled";
$editbtn="disabled";
$thdicode=$_POST['hdicode'];

$sql="select * from tporder where itemcode='$thdicode' and user='$loguser'";
$result=mysql_query($sql) or die("Mysql errorb");
while ($row=mysql_fetch_array($result))
{
	$tqty=$row['qty'];
	$tuprice=$row['uprice'];
	$pnbt=$row['nbt'];
	$pvat=$row['vat'];
	$othertax=$row['otax'];
	$warranty=$row['warr'];
	$tdes=$row['des'];
	$titem=$row['itemdes'];
	$ticode=$thdicode;
	$val=$row['val'];
}

$sql="delete from tporder where itemcode='$thdicode' and user='$loguser'" ;
$result=mysql_query($sql) or die("Mysql errord");
$flag=1;
$sql="select sum(val) as sval from tporder where user='$loguser'";
$result=mysql_query($sql) or die("Mysql errora1");
while ($row=mysql_fetch_array($result))
	 $totval=$row['sval']  ;
} 

if (isset($_POST['btnadd']) or $_POST['btnadd']=="Purchase")
{
$taddno=$_SESSION['addno']++;

if ($taddno==0)
$_SESSION['fitype']=$titype;

$roy="readonly";
$printbtn="disabled";
$editbtn="disabled";
$cancelbtn="disabled";
$savebtn="";
$error=0;
$tbtnflg="";
$recno=0;
$ticode= trim($_POST['lsticd']);

 $sql="select * from tporder where itemcode='$ticode' and user='$loguser'";
 $result=mysql_query($sql) or die("Mysql errorb");
 $recno= mysql_num_rows($result);

if ($funddept=="" or $fund=="")
{$emsg="Please select grant/allocation";
 $error=1;
 }

if ($recno>0)
{$emsg="Item already selected";
 $error=1;
 }

if (!is_numeric($pvat) and $pvat<>'')
{$emsg="Please enter a numeric value VAT";
 $error=1;
 }

if (!is_numeric($pnbt) and $pnbt<>'')
{$emsg="Please enter a numeric value for NBT";
 $error=1;
 }

if (!is_numeric($tuprice))
{$emsg="Please enter a numeric value for unit price";
 $error=1;
 }
 
if ($pvat >100)
{$emsg="Please enter % value for VAT";
 $error=1;
 }

if ($pnbt >100)
{$emsg="Please enter % value for NBT";
 $error=1;
 }

if (!is_numeric($tqty))
{$emsg="Please enter a numeric value for qty";
 $error=1;
 }

if ($ticode=="")
{$emsg="Item code not found";
 $error=1;
 }

if ($titem=="")
{$emsg="Please select an item";
 $error=1;
 }
 
/* if ($warranty=="")
{$emsg="You have not added warranty period!";
 //$error=1;
 }*/

if ($taddno>0 and $titype<>$_SESSION['fitype'])
{
$fitype=$_SESSION['fitype'];
$emsg1="Please do not change ITEM TYPE - ";
$emsg=$emsg1.$fitype;
 $error=1;
}


if($error==0)
{
$sql="select * from item_masterfile where item_code='$ticode'";
$result=mysql_query($sql) or die("Mysql errora");

while ($row=mysql_fetch_array($result))
{
	   $titem=$row['item_description']  ;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (strtotime($tdate)<strtotime(date("2012/11/14"))) 
{
$nbt=0;
$vat=0;
$pnbt=$_POST['txtnbt'];
$pvat=$_POST['txtvat'];
$othertax=$_POST['txtothertax'];
$tuprice=round($tuprice,2);
if ($pnbt>0)
{
$tnbt=$tuprice * $pnbt/100;
 $nbt=round($tnbt,2);
}
$totforvat=$tuprice + $nbt ;
 if ($pvat>0)
 {
 $tvat= ($totforvat * $pvat/100) ;
 $vat=round($tvat,2);
  }
   $val1=  ($tuprice + $nbt + $vat + $othertax) * $tqty ;
  $val=round($val1,2);

}
else{
$nbt=0;
$vat=0;
$pnbt=$_POST['txtnbt'];
$pvat=$_POST['txtvat'];
$othertax=$_POST['txtothertax'];
$warranty=$_POST['txtwarr'];
$unittotal=$tuprice * $tqty;

if ($pnbt>0)
$nbt=$unittotal * $pnbt/100;

$totforvat=$unittotal + $nbt ;
if ($pvat>0)
$vat= ($totforvat * $pvat/100) ;
$tax1= $nbt + $vat + $othertax  ;
$tax=round($tax1,2);   
$val=  $unittotal + $tax  ;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$titem1=addslashes(trim($titem)); 
$tdes1=addslashes(trim($tdes));
$sql="insert into tporder(itemcode,itemdes,des,qty,uprice,nbt,vat,otax,warr,val,user) values('$ticode','$titem1','$tdes1','$tqty','$tuprice','$pnbt','$pvat','$othertax','$warranty','$val','$loguser')";
$result=mysql_query($sql) or die("Mysql errora1");

$sql="select SUM(val) as sval from tporder where user='$loguser'";
$result=mysql_query($sql) or die("Mysql errora11");
while ($row=mysql_fetch_array($result))
	 $totval=$row['sval']  ;
	$tavailable=confund();
if ($totval > $tavailable and $_SESSION['nofund']==0)
{
echo "<script> alert ('Funds Not Available$totval$tavailable')</script>";
$_SESSION['nofund']=1;
}
}

if($error==0)
{
$tdes="";
$titem="";
$tqty="";
$tuprice="";
$pnbt="";
$pvat="";
$othertax="";
$warranty="";
$ticode="";
}
}

if ($_POST['btnsave']=="Save"){
$error=0 ;
if ($error==0){
if ($error==0){
if (($tno > $_SESSION['duetno'] and $tyear==$_SESSION['dueyear']) or  ($tyear > $_SESSION['dueyear'])){ 
$error=1;
$printbtn="disabled";
$savebtn="disabled";
$editbtn="disabled";
$cancelbtn="disabled";
echo "<script> alert ('Invalid PO No.')</script>";
}
if ($error==0){
if (( $tyear < $_SESSION['dueyear']  or ($tno< $_SESSION['duetno']  and $_SESSION['dueyear'] == $tyear)) and  $_SESSION['editflg']==0){
$error=1;
echo "<script> alert ('Please use <Find> to get PO information')</script>";
}
if ($error==0){
$recno=0;
$sql="select * from tporder where user='$loguser'" ;
$result=mysql_query($sql) or die("Mysql error4");
$recno= mysql_num_rows($result);

if ($recno==0){
$error=1;
echo "<script> alert ('Items not found for Purchase Order')</script>";
}

if ($error==0){
if ($tsname=="" or $tdept==""){
$error=1;
echo "<script> alert ('You have NOT selected Supplier Name or Unit Name')</script>";
}

if ($error==0){
if ($tyear>2016 and ($fund=="" or $funddept=="")){
$error=1;
}
if ($error==0){
$recno=0;
$tu=$loguser;
$tapprovepo='';
$tv=0;
$tapproveval=0;
$fundavail='Y';
$tuserapprove='';
$tdateapprove='0000-00-00 00:00:00';

$sql="select * from purch_ord_mas where pom_po_no='$tn' and pom_acct_yr='$tyear'";
$result=mysql_query($sql) or die("Mysql error6");  
	  while ($row=mysql_fetch_array($result))
	   {
	   $tu=$row['user_add'];
	 $tapprovepo=$row['po_approved']  ;
	 $tapproveval=$row['val_approved'];
	 $tuserapprove=$row['user_approved'];
	 $tdateapprove=$row['date_approved'];
	   $recno= mysql_num_rows($result);
   	    } 

if ($recno>0 and $tn== (int)$_SESSION['duetno'] and $tu<>$loguser )
{
$error=1;
$printbtn="disabled";
$savebtn="disabled";
$editbtn="disabled";
$newpobtn="";
echo "<script> alert ('This PO No. is Already Assigned. Please Click <New PO #> to assign a new PO No.')</script>";
}

if ($error==0){
if ($tu==$loguser or $tusergroup=='A'){
if ($tyear>2012){
$i=0;
 $len=strlen($funddept);
 $tffac='';
 $tfdept='';
 $tfprog='';
 $tcount=0;
 while ($i<$len){

 if (substr($funddept,$i,1)=='|')
 $tcount++;

 if (substr($funddept,$i,1)<>'|' and $tcount==0)

 $tffac=$tffac.substr($funddept,$i,1);

 if (substr($funddept,$i,1)<>'|' and $tcount==1)
 $tfdept=$tfdept.substr($funddept,$i,1);

 if (substr($funddept,$i,1)<>'|' and $tcount==2)
 $tfprog=$tfprog.substr($funddept,$i,1);

 $i++;
 }

 if ($tcount==1){
 $tffac=trim($tffac);
 $tfdept='';
 }

 if ($tcount==2){
 $tffac=trim($tffac);
 $tfdept=trim($tfdept);
 $tfprog='';
 }

 if ($tcount==3){
 $tffac=trim($tffac);
 $tfdept=trim($tfdept);
 $tfprog=trim($tfprog);
 }

 $ffaccode='';
 $fdeptcode='';
 $fprogramcode='';
 $tffac1=addslashes(trim($tffac));

 $sql="select * from division_masterfile where div_name='$tffac1'";
 $result=mysql_query($sql) or die("Mysql error1q");
 while ($row=mysql_fetch_array($result))
	   $ffaccode=$row['div_code'];

 $tfdept1=addslashes(trim($tfdept));

 $sql="select * from unit_masterfile where unit_name='$tfdept1' and div_code= '$ffaccode'";
 $result=mysql_query($sql) or die("Mysql error25");
 while ($row=mysql_fetch_array($result))
	   $fdeptcode=$row['unit_code'];

$sql="select SUM(val) as sval from tporder where user='$loguser'";
$result=mysql_query($sql) or die("Mysql errora11");
while ($row=mysql_fetch_array($result))
	 $totval=$row['sval']  ;
$tv=  $totval ;
$tavailable=confund();
 if ($tv > $tavailable){
 $fundavail='N';

 if ($_SESSION['editflg']==1){
 if ($tapprovepo=='Y' and $tv>$tapproveval ){
 $tapprovepo='';
 $tuserapprove='';
 $tdateapprove='0000-00-00 00:00:00';

 echo "<script> alert ('Total value is higher than the Approved PO. Please get approval again for this PO')</script>";
 $printbtn="disabled";
 }
 }

 else{
 echo "<script> alert ('Funds not available. Please get approval for this PO')</script>";
 $printbtn="disabled";
 }
 }

else{
$tapprovepo='';
$tapproveval=0;
$tuserapprove='';
$tdateapprove='0000-00-00 00:00:00';
}
}              
//////////////////////////////////////////////////////////////////////////////////////////////////
$sql="select * from item_type where item_type_name='$titype'";
$result=mysql_query($sql) or die("Mysql error2");
while ($row=mysql_fetch_array($result))
	   $titypecode=$row['item_type_code'];

$sql="delete from purch_ord_det where pod_po_no='$tn' and pod_acct_yr='$tyear' and `pod_po_mark`='$pomark'";
$result=mysql_query($sql) or die("Mysql error3");

$sql="select * from supplier where supplier_name='$tsname' order by sup_year desc limit 1";
$result=mysql_query($sql) or die("Mysql error11");
$row=mysql_fetch_array($result);
$tsupyear = $row['sup_year'];
$tsuppcode = $row['supplier_code'];

$sql="select * from tporder where user='$loguser'" ;
$result=mysql_query($sql) or die("Mysql error4");

$ttotval=0;
$no=0;
while ($row=mysql_fetch_array($result))
	  {
	  $no++;
	  $tic=$row['itemcode'];
	  $td=$row['des'];
	  $q=$row['qty'];
	  $up=$row['uprice'];
	  $nb=$row['nbt'];
	  $va=$row['vat'];
	  $oth=$row['otax'];
	  $w=$row['warr'];
	  $v=$row['val'];
	  $td1=addslashes(trim($td));
  
	 $sql1="insert into purch_ord_det(pod_po_no,pod_po_mark,pod_trans_no,pod_acct_yr,pod_item_code,pod_des,pod_qty,pod_unit_price,pod_warranty,pod_nbt,pod_vat,pod_other,pod_amount) values('$tn','$pomark','$no','$tyear','$tic','$td1','$q','$up','$w','$nb','$va','$oth','$v')"	 ; 
	 $result1=mysql_query($sql1) or die("Mysql error5");
	 }
	 $trecno=0;  

 	$sql="select * from purch_ord_mas where pom_po_no='$tn' and pom_acct_yr='$tyear'";
	$result=mysql_query($sql) or die("Mysql error61");  	   
	   	   $trecno= mysql_num_rows($result);
	$turef1=addslashes(trim($turef));
	$tsref1=addslashes(trim($tsref));
	if ($trecno>0){
	$sql="update purch_ord_mas set pom_sup_code='$tsuppcode',pom_sup_year='$tsupyear',pom_uni_reference='$turef1',pom_reference='$tsref1',pom_currency='$tcur',div_code='$tfaccode',unit_code='$tdeptcode',prog_code = '$tprogramcode',item_type_code='$titypecode' ,item_val='$totval', pom_exchrate='$terate', user_mod='$loguser',user_mod_date='$tdatetime', freight='$freight', insurance='$insurance', for_other='$fother' where pom_po_no='$tn' and pom_acct_yr='$tyear' and pom_po_mark='$pomark'" ;	 
	$result=mysql_query($sql) or die("Mysql error71"); 
	}
	if($trecno==0){
	$sql="INSERT INTO `imsdb`.`purch_ord_mas` (`pom_po_no`, `pom_date`, `pom_sup_code`, `pom_sup_year`, `pom_remark`, `pom_acct_yr`, `pom_uni_reference`, `pom_reference`, `pom_cancel`, `pom_grn_raised`, `dep_code`, `sec_code`, `user_add`, `user_add_date`, `user_mod`, `user_mod_date`, `item_type_code`, `item_val`, `fund_code`, `fund_amount`, `fund_fac`, `fund_dept`, `warranty_yr`, `fund_avail`, `po_approved`, `user_approved`, `date_approved`, `val_approved`, `pom_due_date`) 
values ('$tn','$tcurrentdate','$tsuppcode','$tsupyear','','$tyear','$turef1','$tsref1','','', '$tfaccode', '$tdeptcode','$loguser','$tdatetime','','','$titypecode','$totval','$fund','$tv','$ffaccode','$fdeptcode','$warranty', '$fundavail','$tapprovepo','','','','')";   
	$result=mysql_query($sql) or die("Mysql error8");
	echo "<script> alert ('PO saved successfully! Click Print.')</script>";
	}
$savebtn="disabled";
$editbtn="disabled";
}
else
echo "<script> alert ('You have no rights to Edit this Purchase Order')</script>";
}
}
}
}
}
}
}
}
}

if (!(isset($_POST['btndelete']))){
$_SESSION['it'] = $titype;
$_SESSION['sn'] =$tsname;
$_SESSION['scode'] =$tsupcode;
$_SESSION['addr'] = $taddress;
$_SESSION['stdept']=$tdept;
$_SESSION['chc']="";
$_SESSION['chk']="";
$_SESSION['stpro']=$tpro;
$_SESSION['stprogram']=$tprogram;
$_SESSION['stpcode']=$tpcode;
$_SESSION['styear']=$tyear;
$_SESSION['stuser']=$tuser;
$_SESSION['stno']=$tno;
$_SESSION['sturef']=$turef;
$_SESSION['stsref']=$tsref;
$_SESSION['stcur']=$tcur;
$_SESSION['sterate']=$terate;
$_SESSION['stdate']=$tdate;
$_SESSION['sfund']=$fund;
$_SESSION['sfunddept']= $funddept;
$_SESSION['sfreight']=$freight;
$_SESSION['sinsurance']=$insurance;
$_SESSION['sfother']=$fother;
$_SESSION['sforeignflg1']=$foreignflg1;
}

if (!(isset($_POST['btnFind']))){
$tsname=$_SESSION['sn'];
$titype=$_SESSION['it'];
$tsupcode=$_SESSION['scode'];
$taddress=$_SESSION['addr'];
$tpro=$_SESSION['stpro'];
$tdept=$_SESSION['stdept'];
$tprogram=$_SESSION['stprogram'];
$tyear=$_SESSION['styear'];
$tuser=$_SESSION['stuser'];
$tno=$_SESSION['stno'];
$turef=$_SESSION['sturef'];
$tsref=$_SESSION['stsref'];
$tcur=$_SESSION['stcur'];
$terate=$_SESSION['sterate'];
$tdate=$_SESSION['stdate'];
$funddept= $_SESSION['sfunddept'] ;
$fund= $_SESSION['sfund'];
$freight=$_SESSION['sfreight'];
$insurance=$_SESSION['sinsurance'];
$fother=$_SESSION['sfother'];
$foreignflg1=$_SESSION['sforeignflg1'];
}
$g="dismessage()";
$_SESSION['tempfnd']=$fund;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Purchase Order</title>
<script type="text/javascript">
var xmlhttp;

function GetXmlHttpObject(){
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

function ShowHint2(str){
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

function stateChanged2(){
  if (xmlhttp.readyState==4){
  document.getElementById("lstdept").innerHTML=xmlhttp.responseText;
  }
}

function ShowHint3(str){
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

function stateChanged3(){
  if (xmlhttp.readyState==4)
  {
  document.getElementById("lstitem").innerHTML=xmlhttp.responseText;
  }
}

function dellst(x){
 var elSel = document.getElementById(x);
 var i;
  for (i = elSel.length - 1; i>=0; i--) {
      elSel.remove(i);
  }
}

function dismessage()
{
	alert ("Invalid Purchase Order No.");
	
		var btn=document.getElementById("btnsave");
		btn.value="Savet";
        document.editForm.submit();
}

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 
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
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0" id="cmd" style="background-color:lightblue;">
<tr><td>
<table width="75%" border="0" id="cmd" style="background-color:lightblue;" align="center">
  <tr>
    <td colspan="2">
          <label for="textfield"></label>
          <input name="hdflag" type="hidden" id="hdflag" value="<?php echo $flag ;?>" />
          <input name="hdtotval" type="hidden" id="hdtotval" value="<?php echo $totval ;?>" />
    </span></td>
    <td>
	<input type="hidden" name="hdUser" id="hdUser" value="<?php echo $_REQUEST['lstLogUser'] ;?>" />
    <?php echo  $_REQUEST['hdUser']; ?>
     
<!-- ############################################################################## -->	</td>
  </tr>
  <tr>
    <td colspan="7"><strong><span class="style19">
      <?php if ($pocancel==1) include "pocancel.php"; ?>
    </span></strong></td>
  </tr>
  <tr><input name="hddate" type="hidden" id="hddate" value="<?php echo $tdate ?>" />
    <td><strong>Date : <label for="label"><?php echo $tdate;?></label> </strong>
        </td>
    <td></td>
   <td><label for="label2"><strong>Division : </strong></label><select name="lstproj" size="1" id="lstproj"  onchange="ShowHint2(this.value);submit();" class="styleselect1">
        <option selected="selected"><?php echo $tpro; ?></option>
        <?php
	  	$sql="select * from division_masterfile order by div_name ";
	  	$result=mysql_query($sql) or die("Error in SQL");
		  while($row=mysql_fetch_array($result))
		  {
		  	echo '<option>'.$row['div_name'].'</option>' ;  
		  }
		 ?>
    </select></td>
    <td colspan="2">
      </td> 
  </tr>
  <tr height="26"><td colspan="4" bgcolor="#0099CC"><label for="label2"><span class="style2"><strong>PO No</strong>.</span></label>
      UCSC/P/ORD/
      <input name="txtyear"  type="text" id="txtyear"  <?php echo $roy; ?>  value="<?php echo $tyear;?>" size="4" />
<input name="txtuser" type="text" id="txtuser"  style="color:#000000" readonly="readonly" value="<?php echo $tuser;?>" size="15" />
      <input name="txtno" type="text" id="txtno" value="<?php echo $tno;?>" size="5" />
      <label for="label2">
        <input name="btnFind" class="btn2" type="submit" onclick="" id="btnFind" value="Find" <?php echo $editbtn; ?>   />
        <!--input name="btnnewpo" class="btn2"  type="submit" id="btnnewpo" value="New PO #"  <?php echo $newpobtn; ?>/-->
        <input name="hdyear" type="hidden" id="hdyear" value="<?php echo $tyear;?>" />
        <input name="hdsupyear" type="hidden" id="hdsupyear" value="<?php echo $tsupyear;?>" />
        <input name="hduser" type="hidden" id="hduser" value="<?php echo $tuser;?>" />
        <input name="hdno" type="hidden" id="hdno" value="<?php echo $tno;?>" />
      </label></td></tr>
  <tr>
    <td>Unit</td>
    <td colspan="2"><select name="lstdept" size="1" id="lstdept" onchange="submit()" class="styleselect1">
      <option selected="selected"><?php echo $tdept;?></option>
      <?php 
		$q1=addslashes(trim($tpro)); 
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
    <td>Supplier
      <label for="select"> </label>
          <label for="radiobutton"></label>
          <label for="Submit"></label>
          <label for="Submit"></label></td>
    <td colspan="2"><label for="label5"></label>
        <label for="label"></label>
        <label for="select"></label>
        <label for="label2"></label>
        <label for="label5"></label>
        <label for="label2">
        <select name="lstsname" size="1" id="lstsname" onchange="submit()" class="styleselect1">
          <option selected="selected"><?php echo $tsname;?></option>
          <?php
		 $sql="select distinct supplier_code,supplier_name,sup_year,registered_status from supplier  where (sup_year='$tyear' and `registered_status`='RES') or (sup_year='$tyear' and `registered_status`='NRS')  order by registered_status desc, supplier_name";
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result)){
		echo '<option>'.$row['supplier_name'].'</option>'  ;			
		}
		?>
        </select>
      </label></td>
  <td></td>
    <td colspan="2" rowspan="2"><textarea name="txtaddress" cols="25" rows="2" hidden="true"  readonly="readonly" id="txtaddress"><?php echo $taddress;?></textarea></td>
  </tr>
  <tr>
  </tr>
  <tr><td rowspan="2"><label for="label"></label>
        <label for="textfield"> <strong>Item Type </strong></label></td><td colspan="2" rowspan="2">
        <select name="lstitemtype" id="lstitemtype"  onchange="submit()" class="styleselect1">
          <option selected="selected"><?php echo $titype; ?></option>
          <?php
		$sql="select * from item_type order by item_type_name "	;   
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	    echo '<option>'.$row['item_type_name'].'</option>'  ;			
		?>
        </select>
      </td>
      
    <td rowspan="2" colspan="2"><strong>
      <textarea name="lsticd" cols="10" id="lsticd" hidden="true"><?php echo $ticode;?></textarea>
    </strong></td></tr>
  <tr></tr>
  <tr>
    <td rowspan="2" style="padding-left:35px">Item</td>
      <td rowspan="2"><select name="lstitem" size="1" id="lstitem"  onchange="submit()" class="styleselect1" >
      <option selected="selected"><?php echo $titem;?></option>
      <?php
	  $sql="select * from item_type  where item_type_name='$titype'"	;   
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	   $icode=$row['item_type_code'];
		$sql="select * from item_masterfile  where item_type_code='$icode' order by item_description"	;   
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result)){	
	  echo '<option>'.trim($row['item_description']).'</option>'  ;
	}
	 	   ?>
    </select></td>
  </tr><tr height="27"></tr>
  <tr height="30">
    <td height="17">Ref. No. </td>
    <td><input name="txtsref" type="text" id="label" value="<?php echo $tsref;?>" size="30" maxlength="50" /></td>
    <td>VAT %
    <input name="txtvat" type="text" id="txtvat" value="<?php echo $pvat;?>" size="5" /></td>
    <td align="right"><!--<strong><span>Warranty (years) </span>
          <label for="label2"></label>
      </strong>--></td>
        <td><!--<input name="txtwarr" type="text" id="txtwarr" value="<?php echo $warranty;?>" size="8" />--></td>
    <!--td colspan="4" rowspan="3"><textarea name="txtdes" cols="50" rows="5" id="txtdes"><?php echo $tdes;?></textarea></td-->
  </tr>
  <tr height="17"></tr>
  <tr height="25">
    <td width="190">Qty.
    <input name="txtqty" type="text" id="label8" value="<?php echo $tqty;?>" size="8" /></td>
    <td colspan="2">
    Unit Price 
    
        <input name="txtuprice" type="text" id="label9" value="<?php echo $tuprice;?>" size="15" />
        <label for="textfield"></label></td>
    <td width="91" rowspan="2"></td>
  </tr>
  <tr height="10"></tr>
  <tr>
    <td colspan="4" align="right"><span style="color:#990000"><?php echo $emsg ; ?></span></td>
  </tr>
  
  
  <tr>
    <td height="28" colspan="7"><strong><span class="style19">
      <?php include "pofund.php"; ?>
    </span></strong><input type="submit" name="btnadd" value="Purchase" id="btnadd" class="btn2"  <?php echo $addbtn; ?> width="120"/></td>
  </tr>
</table></td></tr></table>
<p>&nbsp;</p>
  <table width="90%" border="1" style="background-color:lightblue;" align="center">
    <tr bgcolor="#B9DCFF">
       <th width="72"> <span class="style14">Item Code</span> </th>
       <th width="377"> <span class="style14">Description</span> </th>
     <th width="48"> <span class="style14">Qty</span> </th>
	  <th width="57"> <span class="style14">Unit Price </span></th>
	 <th width="40"><span class="style14">VAT%</span> </th>
	 <!--<th width="10"> <span class="style14">Warranty </span></th>-->
	 <th width="58"> <span class="style14">Value</span></th>
    <th width="62">  </th>
</tr>

<?php  
$sql="select * from tporder where user='$loguser'";
$result=mysql_query($sql) or die("Error in SQL");
  while($row=mysql_fetch_array($result)){
?>
<form action="" name="form1" method="post">
<tr>
<td align="center"><?php echo $row['itemcode']; ?></td>
<td align="center" ><label for="textarea"></label>
<textarea name="textarea"   readonly="readonly" cols="60" rows="1" id="textarea"><?php echo trim($row['itemdes'])."\n".$row['des']; ?></textarea></td>
<td align="right"> <?php echo number_format($row['qty'],2); ?></td>
<td align="right"> <?php echo number_format($row['uprice'],2); ?> </td>
<td align="right"> <?php echo number_format($row['vat'],2); ?> </td>
<!--<td align="right"> <?php echo number_format($row['warr'],2); ?> </td>-->
<td align="right"> <?php echo number_format($row['val'],2); ?> </td>
<td><div align="center">
<input name="hdicode" type="hidden" id="hdicode" value="<?php echo $row['itemcode']; ?>" />
<input type="submit" name="btndelete" value="Edit" id="btndelete" class="btn2" />
</form>
</div></td>
</tr>
<?php
}
?>   
</table>
<p>&nbsp;</p>
<p>
    <label for="textarea"></label>
  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
<td colspan="2" bgcolor="#999999" style="padding-left:50px"><div align="right"><strong>
      <input name="btncancel" class="btn2"  type="submit" id="btncancel" value="Cancel Order" <?php echo $cancelbtn; ?> />
       <input type="submit" class="btn2"  name="btnsave" value="Save" id="btnsave"  <?php echo $savebtn; ?> />
      <input type="submit" class="btn2"  name="btnprint" value="Print"   id="btnprint" <?php echo $printbtn; ?> />
	  <a target = '_blank' href=rptporder.php?id1=$tyear&id2=$tn&id3=$tuser&id5=$tsupyear>sna</a>
      </strong></div></td> 
</form>
</body>
</html>

