<?php
session_start(); 

if (!$_SESSION["login"])
{
	header("Location:../login.php");
}

//############################################
$tusername = $_SESSION["username"];
$tcurrentdate= $_SESSION["currentdate"];
$tdatetime=strftime("%Y-%m-%d %H:%M:%S");

//################################################

require('getconnection.php');
$flag=0;

$tdate = $_POST['hddate'];
$tref=$_POST['txtref'];
$itype=$_POST['lstgrant'];
$tproject=$_POST['lstproj'];
$tdept=$_POST['lstdept'];
$tiono=$_POST['txtiono'];
$flag=$_POST['hdflag'];
$tbatchno="";
$tqty=0;
$titemdes=$_POST['lstitem'];
$cancelbtn="disabled";
$loguser = $_SESSION["username"];
$_SESSION['ftime']=0;
$iocancel=0;
$tiono=$_POST['txtiono'];
$ty=(int)substr($tiono,0,4);
$tn=(int)substr($tiono,5,5);
$d=strftime("%Y-%m-%d %H:%M:%S"); 

$savebtn="disabled";
$printbtn="disabled";
$newiobtn="disabled";
$addbtn="disabled";

$titemdes1=addslashes(trim($titemdes)); 
$sql="select *  from item_masterfile where item_description='$titemdes1'";
$result=mysql_query($sql) or die("Mysql error");
while ($row=mysql_fetch_array($result))
$ticode=$row['item_code'];
//////
if ($flag==0 and !(isset($_POST['btndelete']))){
$sql="delete from tiorder where user='$loguser'";
$result=mysql_query($sql) or die("Mysql error1");
$flag=1;

$tdate=date("Y/m/d");
$savebtn="disabled";
$printbtn="disabled";
$editbtn="";
$tyear=date('Y',strtotime($tdate));
$maxno=0;
$tno=0;

$sql="select max(ionh_doct_no) as t  from issue_order_note_header where ionh_doct_year='$tyear' ";
$result=mysql_query($sql) or die("Mysql error");
while ($row=mysql_fetch_array($result))
	   $maxno=$row['t']  ;
$tno=$maxno+1;
$_SESSION['dueino']=$tno;
$_SESSION['dueyear']=$tyear;
$_SESSION['editflg']=0;

$tiono=$tyear."/".str_pad($tno,5,0,STR_PAD_LEFT);  
$_SESSION['addno']=0;
$_SESSION['fitype']=$titype;
$_SESSION['pitype']=$titype;
}
////
if ($titype<>$_SESSION['pitype']){
$titemdes='';
}

if (isset($_POST['btnexit']) or $_POST['btnexit']=="Exit")
header("location:homeindex.php");
if (isset($_POST['btnprint']) or $_POST['btnprint']=="Print"){
$savebtn="disabled";
header("location:rptio.php?id1=".$_POST['hdiono']);
}

if (isset($_POST['btnclear']) or $_POST['btnclear']=="Reset"){
$sql="delete from tiorder where user='$loguser'";
$result=mysql_query($sql) or die("Mysql error1");
$flag=1;
$tdate=date("Y/m/d");
$savebtn="disabled";
$printbtn="disabled";
$editbtn="";
$tyear=date('Y',strtotime($tdate));
$maxno=0;
$tno=0;

$sql="select max(ionh_doct_no) as t  from issue_order_note_header where ionh_doct_year='$tyear' ";
$result=mysql_query($sql) or die("Mysql error");
while ($row=mysql_fetch_array($result))
	   $maxno=$row['t']  ;
//echo"<script>alert($maxno);</script>";

$tno=$maxno+1;
$_SESSION['dueino']=$tno;
$_SESSION['dueyear']=$tyear;
$_SESSION['editflg']=0;

$tiono=$tyear."/".str_pad($tno,5,0,STR_PAD_LEFT);  
$_SESSION['addno']=0;
$_SESSION['fitype']=$titype;
$_SESSION['pitype']=$titype;

$tref='';
$tproject='';
$tdept='';
$tprogram='';
$titemdes='';
$tbatchno='';
$tqty='';
$ticode='';
$titype='';
}

if (isset($_POST['btncancel']) or $_POST['btncancel']=="IO Cancel")
{$iocancel=1;
$editbtn="disabled";
$savebtn="disabled";
$printbtn="disabled";
$addbtn="disabled";
$deletebtn="disabled";
}

if (isset($_POST['btnnewio']) or $_POST['btnnewio']=="New IO #"){
$sql="select max(ionh_doct_no) as t  from issue_order_note_header where ionh_doct_year='$ty' ";
$result=mysql_query($sql) or die("Mysql error");
while ($row=mysql_fetch_array($result))
	   $maxno=$row['t']  ;
$tno=str_pad($maxno+1,5,0,STR_PAD_LEFT);
$tiono=$ty."/".str_pad($tno,5,0,STR_PAD_LEFT);  
$_SESSION['dueino']=$tno;
$savebtn="";
}

if (isset($_POST['btncanio']) or $_POST['btncanpur']=="Cancel This IO"){
$savebtn="disabled";
$printbtn="disabled";
$editbtn="disabled";
$error=0;
$remark=$_POST['txtremark'];

if ($remark==""){
echo "<script> alert ('Please Enter Remarks')</script>";
$error=1;
$iocancel=1;
}
if ($error==0){
$sql="select * from issue_order_note_header where ionh_doct_no='$tn' and ionh_doct_year='$ty'";
$result=mysql_query($sql) or die("Mysql error!");
 
$sql2="update issue_order_note_header set ionh_cancel='Y' where ionh_doct_no='$tn' and ionh_doct_year='$ty'" ;
	  $result2=mysql_query($sql2) or die("Mysql error7");   

$sql1="insert into io_cancel(io_doct_num,io_acct_yr,io_date,io_remarks,io_user_can) values ('$tn','$ty','$d','$remark','$loguser')";
$result1=mysql_query($sql1) or die("Mysql errorq");;

$sql="select * from issue_order_note_header where ionh_doct_year='$ty' and ionh_doct_no='$tn'";
$result1=mysql_query($sql) or die("Mysql error1!");
while ($row=mysql_fetch_assoc($result1)){
$tloccode=$row['ionh_from_loc'];
$tprocode=$row['ionh_to_faculty'];
$tdeptcode=$row['ionh_to_department'];
$tprogramcode=$row['ionh_to_programme'];
}

$ttotval=0;
$i=0;

$sql="select * from issue_order_note_detail where ionh_doct_year='$ty' and ionh_doct_no='$tn'";
$result2=mysql_query($sql) or die("Mysql errorb");
while ($row=mysql_fetch_array($result2)){
	  $tic=$row['iond_item_code'];
	  $tba=$row['iond_batch_no'] ;
	  $q=$row['qty'];
	  $pr=$row['unit_price'];
	  $tval1=$q * $pr;
	  $tval=round($tval1,2);
	  $ttotval=$ttotval+$tval;
	 $rno=0;
	 $i++; 

$sql_qoh="SELECT `id_on_hand` FROM `item_detail` WHERE `batch_num`='$tba' order by `user_add_date` desc limit 1";
$result_qoh= mysql_query($sql_qoh) or die(mysql_error());
$row = mysql_fetch_assoc($result_qoh);
$tqoh = $row['id_on_hand'];
$qoh=($tqoh+$q);

$idn=$ty.str_pad($tn,5,0,STR_PAD_LEFT);
$d=strftime("%Y-%m-%d %H:%M:%S"); 

$sql1="insert into item_detail  (id_doct_number,id_date,id_source,id_transact_number,id_transact_narration,id_item_code,id_receipts_qty,id_location,id_unit_cost_price,batch_num,id_on_hand,user_add,user_add_date,div_code,sec_code,prog_code) values ('$idn','$d','IONC','$i','Issue Order Note_Cancelled' ,'$tic', '$q', '$tloccode', '$pr','$tba','$qoh','$loguser','$d','$tprocode','$tdeptcode','$tprogramcode')"	 ; 
$result1=mysql_query($sql1) or die("Mysql error5");
	  
$sql1="update item_masterfile set qty_in_hand=qty_in_hand + $q  where item_code='$tic'" ;
$result1=mysql_query($sql1) or die("Mysql error7");   
} 
echo "<script> alert ('IO Cancelled')</script>";
}
}

if (isset($_POST['btnedit']) or $_POST['btnedit']=="Find"){
$tiono=$ty.'/'.str_pad($tn,5,0,STR_PAD_LEFT);
$printbtn="";
$fndflg=0;
$sql="select * from issue_order_note_header where ionh_doct_year='$ty' and ionh_doct_no='$tn'";
$result1=mysql_query($sql) or die("Mysql error2!");
while ($row=mysql_fetch_assoc($result1)){
$fndflg=1;
$tdate = $row['ionh_date'];
$tref=$row['ionh_reference'];
$tloccode=$row['ionh_from_loc'];
$tprocode=$row['ionh_to_faculty'];
$tdeptcode=$row['ionh_to_department'];
$tprogramcode=$row['ionh_to_programme'];
$tcan=$row['ionh_cancel']  ;
$tuser=$row['user_add']  ;

$sql="select * from division_masterfile where div_code='$tprocode'";
$result=mysql_query($sql) or die("Mysql error1");
while ($row=mysql_fetch_array($result))
	   $tproject=$row['div_name'];

$sql="select * from unit_masterfile where unit_code='$tdeptcode'";
$result=mysql_query($sql) or die("Mysql error2");
while ($row=mysql_fetch_array($result))
	   $tdept=$row['unit_name'];

$sql="delete from tiorder where user='$loguser'";
$result=mysql_query($sql) or die("Mysql errora");

$sql="select * from issue_order_note_detail where ionh_doct_year='$ty' and ionh_doct_no='$tn'";
$result2=mysql_query($sql) or die("Mysql errorb");
while ($row=mysql_fetch_array($result2)){
$tit=$row['iond_item_code']  ;
$tbn=$row['iond_batch_no']  ;
$tqt=$row['qty']  ;
$tup=$row['unit_price']  ;

$sql="select * from item_masterfile where item_code='$tit' ";
$result=mysql_query($sql) or die("Mysql error");
while ($row=mysql_fetch_array($result)){
	   $tide=$row['item_description']  ;
$titypecode=$row['item_type_code']  ;
}
$tide1=addslashes(trim($tide)); 
$sql="insert into tiorder(user,itemcode,batchno,itemdes,qty,price) values('$loguser','$tit','$tbn',' $tide1','$tqt','$tup')";
	
	$result=mysql_query($sql) or die("Mysql errora1");
}

$sql="select * from item_type where item_type_code='$titypecode' "	;   
	     
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	    				
		$titype= $row['item_type_name']  ; ;			
		
if ($tcan<>'Y' and ($tuser==$loguser or $tusergroup=='A'))
	$cancelbtn="";
}

if ($fndflg==0)
{
$emsg="Record not found.";
$error=1;
}

if ($tcan=='Y')
{
echo "<script> alert ('This IO is Cancelled.')</script>";

$cancelbtn="disabled";
$printbtn="disabled";

}

$editbtn="disabled";
$savebtn="disabled";
$addbtn="disabled";
$deletebtn="disabled";

}

if (isset($_POST['btndelete']) or $_POST['btndelete']=="Delete")
{
$thdicode=$_POST['hdicode'];
$thdbatchno=$_POST['hdbatchno'];

$sql="select * from tiorder where itemcode='$thdicode' and batchno='$thdbatchno' and user='$loguser'";
$result=mysql_query($sql) or die("Mysql errorb");

while ($row=mysql_fetch_array($result))
{
$tqty=$row['qty'];
$tbatchno=$row['batchno'];
$titemdes=$row['itemdes'];
$ticode=$thdicode;
}

$sql="delete from tiorder where itemcode='$thdicode'and batchno='$thdbatchno' and user='$loguser'" ;
$result=mysql_query($sql) or die("Mysql errord");
$savebtn="";
}

if (isset($_POST['btnadd'])  or $_POST['btnadd']=="Add"){
$ty=(int)substr($tiono,0,4);
$tn=(int)substr($tiono,5,5);
$recinfl=0;
$sql="select * from tiorder where iono='$tn' and ioyear='$ty' and user<>'$loguser'";
$result=mysql_query($sql) or die("Mysql error");
$lrno= mysql_num_rows($result);
while ($row=mysql_fetch_array($result))
$pu= $row['user'];

if ($lrno>0)
{
 $sql="select * from issue_order_note_header where ionh_doct_year='$ty' and ionh_doct_no='$tn'";
$result=mysql_query($sql) or die("Mysql error6"); 
$recinfl= mysql_num_rows($result);
}

$printbtn="disabled";
$editbtn="disabled";
$savebtn="";
$taddno=$_SESSION['addno']++;

$_SESSION['addno']++;
$_SESSION['pitype']=$titype;


if ($taddno==0)
{$_SESSION['fitype']=$titype;
}


$tbatchno=substr($_POST['lstbatchno'],0,17);
$tqty=$_POST['txtqty'];
$ticode=trim($_POST['lsticd']);
$error=0;
$emsg="";

//validations
if (!is_numeric($tqty))
{$emsg="Please Enter a Numeric Value for QTY";
 $error=1;
 }

if ($tqty==0)
{$emsg="Please Enter a QTY";
 $error=1;
 }


if ($tbatchno=="")
{
$emsg="Please Select the Batch: " ;
  $error=1;
}


if ($ticode=="")
{
$emsg="Please Select the Item : " ;
  $error=1;
}


///
if ($taddno>0 and $titype<>$_SESSION['fitype'])
{
$fitype=$_SESSION['fitype'];
$emsg1="Please Do Not Change ITEM TYPE  - ";
$emsg=$emsg1.$fitype;
 $error=1;
}
if ($lrno>0 and $recinfl==0)
{$emsg1="Issue Order in Progress from ";
//$emsg2=$emsg1.$tlocation;
$emsg2=" User : ";
$emsg=$emsg1.$tlocation.$emsg2.$pu ;
 $error=1;
}
if ($error==0)
{
$sql="select *  from grn_master,grn_detail where grn_detail.grnd_item_code='$ticode' and grn_detail.batch_num='$tbatchno' and grn_master.grnm_cancelled<>'Y' and grn_master.grnm_acct_yr=grn_detail.grnd_acct_yr and grn_master.grnm_number=grn_detail.grnd_number";
$result=mysql_query($sql) or die("Mysql error");
$grnqty=0;
$grnprice=0;
while ($row=mysql_fetch_array($result))
{
$tx= $row['tax_per_unit'];
$grntot=$row['tot_value'];
$grnqty=$row['grnd_qty_recd'];
$erate=$row['grnm_exch_rate'];
$fl=$row['grnm_supp_foreign_local'];
$gpono=$row['grnd_po_no'];
$gpoyr=$row['grnd_po_acct_yr'];
$eprice=$row['grnd_edit_price'];
$bankchg=$row['grnm_bank_charg'];
$forpotax=$row['grnm_foreign_total'] - $row['grnm_fob_value'] ;
if ($fl=='F')
{
$totqty=0;
$sql1="SELECT sum(pod_qty) as tq FROM `purch_ord_det` WHERE pod_po_no='$gpono' and pod_acct_yr='$gpoyr' "  ;
$result1=mysql_query($sql1) or die("Mysql errorw");
while ($row=mysql_fetch_array($result1))
$totqty=$row['tq'];

$foreigntax=(($forpotax * $erate) + $bankchg)/$totqty ;
$grnprice1=($eprice*$erate)+ $foreigntax;
$grnprice=round($grnprice1,2);
}
else
$grnprice=round(($grntot/$grnqty),2);
}

$sql1="SELECT * FROM `item_detail` WHERE `batch_num`='$tbatchno' order by `user_add_date` desc limit 1"  ;
$result1=mysql_query($sql1) or die("Mysql error");
while ($row=mysql_fetch_array($result1))
$bal=$row['id_on_hand'];

if ($bal<$tqty)
  {$emsg="Stock in Hand : " . $bal ;
  $error=1;
 }

$rno=0;

$sql="select * from tiorder where itemcode='$ticode' and batchno='$tbatchno' and user='$loguser'";
$result=mysql_query($sql) or die("Mysql error");
$rno= mysql_num_rows($result);

if ($rno>0)
{$emsg="Item already selected from the same batch";
 $error=1;
 }

$sql="select * from item_masterfile where item_code='$ticode' ";
$result=mysql_query($sql) or die("Mysql error");
while ($row=mysql_fetch_array($result))
	   $titemdes=$row['item_description']  ;


if($error==0)
{$titemdes1=addslashes(trim($titemdes)); 
$sql="insert into tiorder(user,itemcode,batchno,itemdes,qty,price,iono,ioyear) values('$loguser','$ticode','$tbatchno','$titemdes1','$tqty','$grnprice','$tn','$ty')";
	
	$result=mysql_query($sql) or die("Mysql errora1");
}
if ($error==0)
{$tbatchno="";
$ticode= "";
$tqty="";
$titemdes="";
}
}
}

if ($_POST['btnsave']=="Save")
{
$ty=(int)substr($tiono,0,4);
$tn=(int)substr($tiono,5,5);
$tu=$loguser;

$error=0 ;
if ($loguser=="")
{$error=1;
echo "<script> alert ('Timeout for Log User')</script>";
}
if ($error==0)
{
if ($tref=="")
{$error=1;
echo "<script> alert ('Please Enter the Referance No.')</script>";
}
if ($error==0)
{
if ($tdept=="")
{$error=1;
echo "<script> alert ('Please Select the Department')</script>";
}
if ($error==0)
{
if ($tn<>$_SESSION['dueino'] or $ty<>$_SESSION['dueyear'])
{ 
$error=1;
$printbtn="disabled";
$savebtn="disabled";
$editbtn="disabled";
$addbtn="disabled";
$deletebtn="disabled";

echo "<script> alert ('Invalid IO No.')</script>";
}
if ($error==0)
{
$recno=0;
$sql="select * from tiorder where user='$loguser'" ;
$result=mysql_query($sql) or die("Mysql error4");
$recno= mysql_num_rows($result);

if ($recno==0)
{$error=1;
echo "<script> alert ('Items not found for Issue Order')</script>";
}
if ($error==0)
{
$sql="select * from location where location_name='$tlocation'";
$result=mysql_query($sql) or die("Mysql error2");
while ($row=mysql_fetch_array($result))
	   $tloccode=$row['location_code'];
$recno=0;
$tu=$loguser;

$sql="select * from issue_order_note_header where ionh_doct_year='$ty' and ionh_doct_no='$tn'";
$result=mysql_query($sql) or die("Mysql error6"); 
	  while ($row=mysql_fetch_array($result))
	   {
	   $tu=$row['user_add'];
    $recno= mysql_num_rows($result);
		} 
if ($recno>0 and $tn == $_SESSION['dueino'] and $tu<>$loguser )
{

$error=1;
$printbtn="disabled";
$savebtn="disabled";
$editbtn="disabled";
$addbtn="disabled";
$deletebtn="disabled";

$newiobtn="";
echo "<script> alert ('This IO No. is Already Assigned. Please Click <New IO #> to assign a new IO No.')</script>";
}

if ($error==0)
{
if ($recno==0)
{
$tproject1=addslashes(trim($tproject)); 
$sql="select * from division_masterfile where div_name='$tproject1'";
$result=mysql_query($sql) or die("Mysql error1");
while ($row=mysql_fetch_array($result))
	   $tprocode=$row['div_code'];

$tdept1=addslashes(trim($tdept)); 
$sql="select * from unit_masterfile where unit_name='$tdept1' and div_code= '$tprocode'";
$result=mysql_query($sql) or die("Mysql error2");
while ($row=mysql_fetch_array($result))
	   $tdeptcode=$row['sec_code'];

$sql="select * from location where location_name='$tlocation'";
$result=mysql_query($sql) or die("Mysql error2");
while ($row=mysql_fetch_array($result))
	   $tloccode=$row['location_code'];


$sql="select * from tiorder where user='$loguser'" ;
$result=mysql_query($sql) or die("Mysql error4");

$ttotval=0;
$i=0;
while ($row=mysql_fetch_array($result))
	  {
	  $tic=$row['itemcode'];
	  $tba=$row['batchno'];
	  $q=$row['qty'];
	  $pr=$row['price'];
	  $tval=$q * $pr;
	  $ttotval=$ttotval+$tval;
	 $rno=0;
	 
	 $i++; 
	  $sql1="insert into issue_order_note_detail  (ionh_doct_year,ionh_doct_no,iond_transact_no,iond_item_code,iond_batch_no,qty,unit_price) values ('$ty','$tn','$i','$tic','$tba','$q','$pr')"	 ; 
	  $result1=mysql_query($sql1) or die("Mysql error5a");
	    
$sql_qoh="SELECT `id_on_hand` FROM `item_detail` WHERE `batch_num`='$tba' order by `user_add_date` desc limit 1";

	$result_qoh= mysql_query($sql_qoh) or die(mysql_error());
	$row = mysql_fetch_assoc($result_qoh);
	$tqoh = $row['id_on_hand'];
	
	$qoh=($tqoh-$q);


$idn=$ty.str_pad($tn,5,0,STR_PAD_LEFT);
$d=strftime("%Y-%m-%d %H:%M:%S"); 

$sql1="insert into item_detail  (id_doct_number,id_date,id_source,id_transact_number,id_transact_narration,id_item_code,id_issues_qty,id_location,id_unit_cost_price,batch_num,id_on_hand,user_add,user_add_date,div_code,unit_code) values ('$idn','$d','ION','$i','Issue Order Note','$tic','$q','','$pr','$tba','$qoh','$loguser','$d','$tprocode','$tdeptcode')"	 ; 
$result1=mysql_query($sql1) or die("Mysql error5b");

$sql1="update item_masterfile set qty_in_hand=qty_in_hand - $q  where item_code='$tic'" ;
	  $result1=mysql_query($sql1) or die("Mysql error7");  

// ############################## Edit for FAR code generation ###############################################
	  
	  $sqlfacode="SELECT `item_fa_code` FROM `item_masterfile` WHERE `item_code`='$tic'";
	  $resultfacode = mysql_query($sqlfacode) or die("FAR Code Error");
	  $rowfacode = mysql_fetch_assoc($resultfacode);
	  $facode = $rowfacode['item_fa_code'];
	  $codecount = strlen($facode);
	  
	  if($codecount == '3' && $pr >= 5000)
	  {
		  $code = str_split($facode) ;
		  $facode = $code[0].$code[1];
		}
	  
	  if($facode != "" && $facode != "NA" && strlen($facode) != '3')
	  {
	  $sqlgrn = "SELECT `grnd_po_no`,`grnd_po_acct_yr`,`grnd_po_mark`,`grnm_supplier_code`,`grnm_supply_year`,`grnd_number`,`grnd_acct_yr` FROM `grn_detail`,`grn_master` WHERE `grnd_number`=`grnm_number` and `grnd_mark`=`grnm_mark` and `grnd_acct_yr`=`grnm_acct_yr` and batch_num ='$tba' ";
	  $resultgrn = mysql_query($sqlgrn) or die("Error 1");
	  $rowgrn = mysql_fetch_assoc($resultgrn);
	  $tpono = $rowgrn['grnd_po_no'];
	  $tpoyear = $rowgrn['grnd_po_acct_yr'];
	  $tpomark = $rowgrn['grnd_po_mark'];
	  $tsupcode = $rowgrn['grnm_supplier_code'];
	  $tsupyear = $rowgrn['grnm_supply_year'];
	  $tgrnno = $rowgrn['grnd_number'];
	  $tgrnyr = $rowgrn['grnd_acct_yr'];
	  }} 
$sql="insert into issue_order_note_header (ionh_doct_year,ionh_doct_no,ionh_date,ionh_from_loc ,ionh_to_faculty,ionh_to_department,ionh_to_programme,ionh_cancel,ionh_reference,ionh_total_value,user_add,user_add_date) values ('$ty','$tn','$tdate','$tloccode','$tprocode','$tdeptcode','$tprogramcode','N','$tref','$ttotval','$loguser','$d')";
$result=mysql_query($sql) or die("Mysql error8");
echo "<script> alert ('GIN saved successfully! Click Print.')</script>";
}
$printbtn="";
$savebtn="disabled";
$editbtn="disabled";
$addbtn="disabled";
$deletebtn="disabled";
unset($_REQUEST);
}}}}}}}


///////////////

//session_start(); 
if (!(isset($_POST['btndelete'])))
{
$_SESSION['stdate']=$tdate;
$_SESSION['stref'] = $tref;
$_SESSION['stlocation'] =$tlocation;
$_SESSION['stitype'] =$titype;

$_SESSION['stproject'] =$tproject;
$_SESSION['stdept'] = $tdept;
$_SESSION['stprogram'] = $tprogram;
$_SESSION['stiono']=$tiono;
$_SESSION['stflag']=$flag;

}


if (!(isset($_POST['btnedit'])))
{
$tdate=$_SESSION['stdate'];
$tref=$_SESSION['stref'] ;

$tlocation=$_SESSION['stlocation'];
$titype=$_SESSION['stitype'];
$tproject=$_SESSION['stproject'] ;
$tdept=$_SESSION['stdept'] ;
$tprogram=$_SESSION['stprogram'];
$tiono=$_SESSION['stiono'];
$flag=$_SESSION['stflag'];
}

$tn=(int)substr($tiono,5,5);
$_SESSION['ploc']=$tlocation;
$_SESSION['pitype']=$titype;

///////////////////////

if ($tn==$_SESSION['dueino'] and $ty==$_SESSION['dueyear'])
$addbtn="";

/////////
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Good Issue Note</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<script type="text/javascript">

var xmlhttp;

////

function ShowHint1(str)
{
//alert(str)
  xmlhttp=GetXmlHttpObject();
  //Is browser creates the XMLHTTPRequest Object
  if(xmlhttp==null)
  {
  	alert("Your browser does not support XMLHTTP!");
	return;
  }
 
  var url="getdataitem.php";
  url =url+"?q="+str;
  url=url+"&sid="+Math.random();
  xmlhttp.onreadystatechange=stateChanged1;
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
 
}


function stateChanged1()
{
  if (xmlhttp.readyState==4)
  {
  document.getElementById("lstitem").innerHTML=xmlhttp.responseText;
  }

}


////
function ShowHint2(str)
{
//alert(str)
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

////


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


function ShowHint3(str)
{
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
  xmlhttp.onreadystatechange=stateChanged3;
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
 }


function stateChanged3()
{
  if (xmlhttp.readyState==4)
  {
  document.getElementById("lsticd").innerHTML=xmlhttp.responseText;
  }
}

////////

function ShowHint4(str)
{


   xmlhttp=GetXmlHttpObject();
  //Is browser creates the XMLHTTPRequest Object
  if(xmlhttp==null)
  {
  	alert("Your browser does not support XMLHTTP!");
	return;
  }

  var url="getbatch.php";
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
  
  document.getElementById("lstbatchno").innerHTML=xmlhttp.responseText;
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


///

function dismessage()
{
	alert ("Invalid Issue Order No.");
	
		var btn=document.getElementById("btnsave");
		btn.value="Savet";
        document.editForm.submit();
}

////

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 
</script>
</style>
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
<tr><td>
<table width="75%" border="0" id="cmd" style="background-color:lightblue;" align="center">				
<tr>
    <td height="24" colspan="2" ><span class="style14"><span class="style6"></span></span><span class="style1"> <span class="style13">
    <label for="textfield"></label>
    </span>
        <input name="hdflag" type="hidden" id="hdflag" value="<?php echo $flag ;?>" />
    </span></td>
    <td colspan="3"></td>
    <td><div align="right">
      <!--input name="btncancel" type="submit" id="btncancel" value="IO Cancel" <?php echo $cancelbtn; ?> class="btn2" /-->
    </div></td>
  </tr>
  <tr>
    <td colspan="7"><strong><span class="style19">
      <?php if ($iocancel==1) include "iocancel.php"; ?>
    </span></strong></td><div align="right" hidden="true"><strong>
      <textarea name="lsticd" cols="15" id="lsticd"><?php echo $ticode;?></textarea>
    </strong></div>
  </tr>
  <tr>
    <td height="24" colspan="2">Date&nbsp;&nbsp;&nbsp;&nbsp;<label for="label2"><?php echo $tdate;?></label>
        <input name="hddate" type="hidden" id="hddate" value="<?php echo $tdate ?>" />
        <label for="textfield"></label></td>
    <td width="172" height="50"></label>
      <label for="Submit">Issue Order No.</label>
    <div align="right"></div></td>
    <td colspan="2" rowspan="2"><input name="txtiono" type="text" id="txtiono" value="<?php echo $tiono;?>" size="15" maxlength="15" />
      <input name="btnedit" type="submit" class="btn2" id="btnedit" value="Find" <?php echo $editbtn; ?> />
      <!--input name="btnnewio" type="submit" id="btnnewio" value="New IO #" class="btn2"  <?php echo $newiobtn; ?>/-->
    <label for="Submit">
    <input name="hdiono" type="hidden" id="hdiono" value="<?php echo $tiono;?>" />
    </label></td>
    <td width="186" colspan="-2" rowspan="2"></td>
  </tr>
  <tr>
    <td height="24">Reference <label style="color:#F00">*</label></td>
    <td height="24"><input name="txtref" type="text" id="label" value="<?php echo $tref;?>" size="30" maxlength="50" /></td>
  </tr>
  <tr>
    <td width="157"><label for="label4"></label>
    <label for="label">Division </label></td>
    <td width="261">
      <select name="lstproj" size="1" id="lstproj" onchange="submit()" class="styleselect1">
        <option selected="selected"><?php echo $tproject; ?></option>
        <?php
		  $sql="select * from division_masterfile order by div_name";
		  $result=mysql_query($sql) or die("Error in SQL");
		  while($row=mysql_fetch_array($result))
		  echo '<option>'.$row['div_name'].'</option>'  ;	 
		  ?>
      </select>
   </td>
    <td>Item</td>
    <td colspan="3"><select name="lstitem" size="1" id="lstitem"  onchange="submit()" class="styleselect1">
      <option selected="selected"><?php echo $titemdes;?></option>
 
     <?php
	$sql4="select * from item_type where item_type_name='$itype'";
	$result4=mysql_query($sql4) or die("Mysql error2");
	while ($row=mysql_fetch_array($result4))
	$titypecode=$row['item_type_code'];
	
	$sql5="select item_code,item_description from item_masterfile where item_type_code='$titypecode' order by item_description" ;
	$result5=mysql_query($sql5) or die("Error in SQL");  
	while ($row=mysql_fetch_array($result5)){
	$imicode=$row['item_code'];
	$imides=$row['item_description'];
	echo '<option>'.$imides.'</option>'  ;
	}
?>	 

	 
    </select></td>
  </tr>
  <tr>
    <td height="28"><label for="select"></label>
        <label for="label2"></label>
        <label for="label"></label>
        <label for="label"></label>
        <label for="label2"></label>
        <label for="label3">Unit</label></td>
    <td height="28"><label for="select">
      <select name="lstdept" id="lstdept" onchange="submit()" class="styleselect1">
        <option selected="selected"><?php echo $tdept; ?></option>
        <?php


$tproject1=addslashes(trim($tproject)); 
$sql="select * from division_masterfile where div_name='$tproject1' "	;   
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	   
	   $pcode=$row['div_code'];

		$sql="select * from unit_masterfile where div_code='$pcode' order by unit_name"	;   
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	     echo '<option>'.$row['unit_name'].'</option>'  ;

	   
		   ?>
      </select>
    </label></td>
		  
    <td><label for="textfield">Batch No.</label></td>
    <td colspan="3"><select name="lstbatchno" id="lstbatchno" class="styleselect1">
      <option selected="selected"><?php echo $tbatchno;?></option>
      <?php
	  $ides=$_POST['lstitem'];
	  $ides1=addslashes(trim($ides)); 
	$sql="select *  from item_masterfile where item_description='$ides1'";
	$result=mysql_query($sql) or die("Mysql error");
	while ($row=mysql_fetch_array($result))
	$ticode=$row['item_code'];
	  
	$sql="select *  from grn_master,grn_detail where grn_detail.grnd_item_code='$ticode'and grn_master.grnm_cancelled<>'Y' and (grn_detail.grnd_po_status='Approved' or grn_detail.grnd_po_status='Normal') and grn_master.grnm_acct_yr=grn_detail.grnd_acct_yr and grn_master.grnm_number=grn_detail.grnd_number";
	$result=mysql_query($sql) or die("Mysql error");
	while ($row=mysql_fetch_array($result)){
	$batchno=$row['batch_num'];
	$tdept=$row['div_code'];
	$tsec=$row['sec_code'];
	$tpro=$row['prog_code'];
	$tpno=$row['grnd_po_no'];
	$tpyr=$row['grnd_po_acct_yr'];
	$grnyr=$row['grnm_acct_yr'];
	$grnno=$row['grnm_number'];
	$tgrnno=$grnyr."/". str_pad($grnno,6,0,STR_PAD_LEFT); 

	$sql3="select * from purch_ord_mas where pom_po_no='$tpno' and pom_acct_yr='$tpyr'";
	$result3=mysql_query($sql3) or die("Mysql error6");  
	while ($row=mysql_fetch_array($result3))
	$tu=$row['user_add'];

	$tp=$tpyr.'/'.trim($tu).'/'.str_pad($tpno,5,0,STR_PAD_LEFT);
	$tdeptname='';
	$tsecname='';
	$tproname='';

	$sql1="select * from division_masterfile where div_code='$tdept'";
	$result1=mysql_query($sql1) or die("Mysql error1");
	while ($row=mysql_fetch_array($result1))
	   $tdeptname=$row['div_name'];
		$tsecname="";
	$sql2="select * from unit_masterfile where unit_code='$tsec' ";
	$result2=mysql_query($sql2) or die("Mysql error2");
	while ($row=mysql_fetch_array($result2))
	   $tsecname=$row['unit_name'];

	$sql1="SELECT * FROM `item_detail` WHERE `batch_num`='$batchno' order by `user_add_date` desc limit 1"  ;
	$result1=mysql_query($sql1) or die("Mysql error");
	while ($row=mysql_fetch_array($result1))
	$bal=$row['id_on_hand'];

	if ($bal>0)
	echo '<option>'.$batchno.'  :  ('.$bal.') - '.$tdeptname.' - '.$tsecname.'</option>'  ;
	}
	$batchno='';
	?>
    </select></td>
  </tr>
  <tr>
    <td height="28"></td>
    <td height="28"></td>
    <td>Qty.
      <label for="textfield"></label>
      <label for="Submit"></label></td>
    <td colspan="3"><input name="txtqty" type="text" id="txtqty" value="<?php echo $tqty;?>" />
    <input type="submit" name="btnadd" value="Add"  <?php echo $addbtn; ?> id="btnadd" class="btn2" /></td>
  </tr>
  <tr>
    <td height="28">Item Type </td>
    <td height="28"><select name="lstgrant" id="lstgrant" onchange="submit()" class="styleselect1">
      <option selected="selected"><?php echo $itype; ?> </option>
      <?php
		$sql="select * from item_type order by item_type_name "	;   
	     
	   $result=mysql_query($sql) or die("Error in SQL");
	   while ($row=mysql_fetch_array($result))
	    				
		echo '<option>'.$row['item_type_name'].'</option>'  ;			
		
		?>
    </select>    </td>
    <td colspan="4"><span style="color:#990000"><?php echo $emsg ; ?></span></td>
  </tr>
  <!--tr>
    <td height="28"><label for="label2"><strong>Location </strong></label>
      <label for="label2"></label>
      <label for="label2"></label>
      <label for="label2"></label>
      <label for="label4"></label>
      <label for="label2"></label>
      <label for="Submit"></label>
      <label for="label2"></label>
      <label for="label5"></label>
      <label for="label4"></label></td>
    <td height="28"><select name="lstloc" id="lstloc"  onchange="submit()">
      <option selected="selected"><?php echo $tlocation; ?></option>
      <?php
								
		   $sql="select * from location ";
		  $result=mysql_query($sql) or die("Error in SQL");
		  while($row=mysql_fetch_array($result))
		  {
		  $locnamet=$row['location_name'];
		  $loct=$row['location_code'] ;
		  
		  						
		  	 
			}	
				
		  ?>
    </select></td>
    <td colspan="4"><span style="color:#990000"><?php echo $emsg ; ?></span></td>
  </tr-->
</table>

 <table width="1100" border="2" align="center">
    <p align="right">&nbsp;</p> 
<tr>
       <th width="100"> <span class="style18"><span class="style13">Item Code</span></th>
       <th width="150"><span class="style18"><span class="style13">Description</span> </th>
    <th width="175"><span class="style18"> <span class="style13">Batch No</span> </th>
	 <th width="100"><span class="style18"> <span class="style13">Qty.</span> </th>
	  <th width="100"><span class="style18"> <span class="style13">Unit Price</span> </th>
	 <th width="150"><span class="style18"> <span class="style13">Value</span> </th>
	  
	   <th width="84"> <span class="style18"> </th>
</tr>



<?php  
$sql="select * from tiorder where user='$loguser'";

 $result=mysql_query($sql) or die("Error in SQL");

  while($row=mysql_fetch_array($result))
{

?>
<form action="" name="form1" method="post">
<tr>
<td align="center"><?php echo $row['itemcode']; ?></td>

<td align="center" ><label for="textarea"></label>
  <textarea name="textarea" readonly="readonly"  cols="50"  style="font-size:16px" rows="1" id="textarea"><?php echo $row['itemdes']; ?></textarea></td>
<td align="center"><?php echo $row['batchno']; ?></td>
<td align="right"><?php echo number_format($row['qty'],2); ?></td>
<td align="right"><?php echo number_format($row['price'],2); ?></td>
<td align="right"><?php echo number_format($row['price']*$row['qty'],2); ?></td>


<td><div align="center">


<input name="hdicode" type="hidden" id="hdicode" value="<?php echo $row['itemcode']; ?>" />
<input name="hdbatchno" type="hidden" id="hdbatchno" value="<?php echo $row['batchno']; ?>" />
<input type="submit" name="btndelete" value="Edit" <?php echo $deletebtn; ?> id="btndelete" class="btn2" />
</form>

</div></td>
</tr>
<?php
}
?>
</table>
<tr height="50px"></tr>
	<tr><td height="26" colspan="4" style="padding-right:240px" align="right"><input type="submit" name="btnsave" value="Save" id="btnsave"  <?php echo $savebtn; ?> class="btn2" />
    <input name="btnclear" class="btn2" type="submit" id="btnclear" value="Reset" />
	<input type="submit" name="btnprint" value="Print" id="btnprint" <?php echo $printbtn; ?> class="btn2" />
	</td>
	</tr>
</form>
</body>
</html>
