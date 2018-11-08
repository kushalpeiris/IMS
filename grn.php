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
$tusergroup = $_SESSION["usergroup"];
require('db.inc.php');
extract($_POST);
$i=0;
$tot = 0;
$ic=1;
$result1=null;
$result2=null;

$tdate=strftime("%d/%m/%Y");
$tyear = strftime("%Y");
$tdatetime=strftime("%Y-%m-%d %H:%M:%S");

//*************************************************************

$j = false;

if (isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
{
	$txtNarration="";
	$txtRef="";
	$txtLC="";
	$txtShip="";
	$tinv="";
	$lstYear=0;
	unset($_REQUEST);
}

if (isset($_POST['btnSave']) || $_POST['btnSave']=="Save")
{
	$tsupcode=$_POST['lstSupplier'];
	$tlocation=$_POST['lstLocation'];
	$tref=$_POST['txtRef'];
	$tdate=$_POST['hddate'];
	$tlof=$_POST['lstLOF'];
	$tlc=$_POST['txtLC'];
	$tship=$_POST['txtShip'];
	$tinv=$_POST['txtInv'];
	$texchrate=$_POST['txtExchRate'];
	$tgttot=$_POST['txtGTot'];
	$tfob=$_POST['txtFOB'];
	$tlkrtot=$_POST['txtLkrTotal'];
	$tfrtot=$_POST['txtFrTot'];
	$tbankchar=$_POST['txtBnkCharg'];
	$tponoArr =explode('-',$_POST['lstPO']);
		$tpono=$tponoArr[0];
		$tpoyear= $tponoArr[1];
	
	$count1=$_POST['hdrows']; 
	$tdateArr =explode('/',$_POST['hddate']);
		$tdateh=$tdateArr[2].'/'.$tdateArr[1].'/'.$tdateArr[0];
		
	
	//*************************************************************************************
	$tempitemcode=$_POST['txtItemCode_'.$ic];
	$temploc= $_POST['lstLocation'];
	
	$tempsql="SELECT `item_loc_code` FROM `item_masterfile` WHERE `item_code`='$tempitemcode'";
	$tempres= mysql_query($tempsql) or die(mysql_error());
	$temprow = mysql_fetch_assoc($tempres);
	$exactloc=$temprow['item_loc_code'];

	//*************************************************************************************
	$tyear=strftime("%Y");
	$maxno=0;

	$sql="select * from grn_detail where grnd_acct_yr='$tyear' order by grnd_number desc limit 1 ";
	$result=mysql_query($sql) or die("Mysql error6");
	$row= mysql_fetch_assoc($result);
	$maxno=$row['grnd_number']  ;
	$nextno=(int)$maxno+1;
	$tgrnno= str_pad($nextno,6,0,STR_PAD_LEFT);
	//*************************************************************************************	
	for ($count=1;$count<=$count1;$count++)
	{
		$titemcode=$_POST['txtItemCode_'.$count];
		$trecqty=$_POST['txtRecd_'.$count];
		$torqty=$_POST['txtOrQty_'.$count];
		$trecal=$_POST['txtRecAl_'.$count];
		$tbal=$_POST['txtBal_'.$count];
		$tprice = $_POST['txtUnitPrice_'.$count];
		$teditprice=$_POST['txtEditPrice_'.$count];
		$tunittax=$_POST['txtunitTax_'.$count];
		$ttotval=$_POST['txtVal_'.$count];
		if ($tprice != $teditprice)
		{
			$confirm = "Pending";
			$j= true;
		}
		else
		{
			$confirm= "Normal";
		}
		$tval=$_POST['txtVal_'.$count];
		
		$sql="SELECT `pom_po_no`,`pom_acct_yr`,`dep_code`,`sec_code`,item_type_code,fund_code,fund_fac,fund_dept,fund_amount FROM `purch_ord_mas` WHERE `pom_po_no`='$tpono' AND `pom_acct_yr`='$tpoyear' ; ";
		$result=mysql_query($sql) or die("Mysql error7");
	
		while ($row=mysql_fetch_array($result))
		{
			$tdepcode=$row['dep_code']  ;
			$tseccode=$row['sec_code']  ;
			$tprogcode=$row['prog_code']  ;
			

$grantcode=$row['item_type_code']  ;
$fundcode=$row['fund_code']  ;
$fundfac=$row['fund_fac']  ;
$funddept=$row['fund_dept']  ;
$fundprog=$row['fund_prog']  ;
$fundamt=$row['fund_amount']  ;
$fundpoyear=$row['pom_acct_yr']  ;
		}
		
//............................fund end............................
		
		$maxno=0;
		$sql="SELECT * FROM `grn_detail` WHERE `batch_num` LIKE '$tdate/%' order by batch_num desc limit 1";
		$result=mysql_query($sql) or die("Mysql error8");
		if ($result)
		{
			$row=mysql_fetch_array($result);
			$maxbno=$row['batch_num'];
		}
		else
		{
			$maxbcode=0;
		}	   
		$maxbcodeArr= explode('/',$maxbno);
		$maxbcode=$maxbcodeArr[3];
		$nextno=(int)$maxbcode+1;
		$tbatcode= str_pad($nextno,6,0,STR_PAD_LEFT);
		$tbatno=$tdate."/". $tbatcode; 
		if($trecqty!="0")
		{
		$recalr=$trecqty + $trecal;
		$sqlgrnd="insert into grn_detail(grnd_number,grnd_transact_number,grnd_source,grnd_item_code,grnd_qty_recd,grnd_unit_price,grnd_edit_price,tax_per_unit,tot_value,grnd_acct_yr,grnd_po_no,grnd_po_status,grnd_po_acct_yr,grnd_order_qty,grnd_already_received_qty,batch_num,os_user,machine_id,user_add,user_add_date,purchase_type_flag,dep_code,sec_code,prog_code,invoice_num) values ('$tgrnno','$count','GRN','$titemcode','$trecqty','$tprice','$teditprice','$tunittax','$ttotval','$tyear','$tpono','$confirm','$tpoyear','$torqty','$recalr', '$tbatno','$tusername',null,'$tusername','$tdatetime',null,'$tdepcode','$tseccode','$tprogcode','$tinv')"	 ; 
		
		$result1= mysql_query($sqlgrnd) or die(mysql_error());
	//**********************************item detailcheck**********************************
	$sqltemp ="SELECT `qty_in_hand` FROM `item_masterfile` WHERE `item_code`='$titemcode'";
			$tempresult= mysql_query($sqltemp) or die(mysql_error());
			$temprow = mysql_fetch_assoc($tempresult);
			$titmasqih = $temprow['qty_in_hand'];

	$sql_qoh="SELECT `id_doct_number`,`id_on_hand` FROM `item_detail` WHERE `batch_num`='$tbatno' order by `user_add_date` desc limit 1";

	$result_qoh= mysql_query($sql_qoh) or die(mysql_error());
	$row = mysql_fetch_assoc($result_qoh);
	$tqoh = $row['id_on_hand'];
	$qoh=($trecqty+$tqoh);
	$tdocno =$row['id_doct_number'];
	//new item balance
	$itmasqih=($trecqty+$titmasqih);


	$sqlitemdet="INSERT INTO `item_detail`(`id_doct_number`, `id_date`, `id_source`, `id_transact_number`,`id_transact_narration`, `id_item_code`, `id_receipts_qty`, `id_issues_qty`, `id_location`, `id_currency`, `id_exch_rate`,`id_post`,`id_unit_cost_price`, `batch_num`, `id_on_hand`,`id_cancel`,`user_add`, `user_add_date`, `div_code`, `unit_code`) VALUES ('$tyear$tgrnno','$tdatetime','GRN','$count','Purchase through GRN','$titemcode','$trecqty','0','$tlocation','$hdcur','1','Y','$teditprice','$tbatno','$qoh','N','$tusername','$tdatetime','$tdepcode','$tseccode')";
	$result3= mysql_query($sqlitemdet) or die(mysql_error());

	$sqlitemdetail="UPDATE `item_masterfile` SET `qty_in_hand`='$itmasqih' WHERE `item_code`='$titemcode'";
	$resultitemdetail= mysql_query($sqlitemdetail) or die(mysql_error());
	//**************************************************************************************
	
		}
	}
	if ($tship==='')
		$tship='0';
	else
		$tship="'$tship'";
		
	if ($tlc==='')
		$tlc='0';
	else
		$tlc="'$tlc'";
			
	if ($texchrate==='')
		$texchrate='1';
	else
		$texchrate="'$texchrate'";
			
	if($j)
	{
		$flag="PendingGRN";
	}
	else
	{
		$flag ="NormalGRN";
	}
	if ($fundpoyear>2012)
	{
	
	$sql="SELECT sum(pod_qty) as totqty FROM `purch_ord_det` WHERE pod_po_no='$tpono' AND pod_acct_yr='$tpoyear' ";
	
		$result=mysql_query($sql) or die("Mysql error9");
		while ($row=mysql_fetch_array($result))
	$totpoqty= $row['totqty'];
	
	
	$sql="SELECT sum(grnd_already_received_qty) as totrqty FROM `grn_detail` WHERE `grnd_po_no`='$tpono' AND `grnd_acct_yr`='$tpoyear' and (grnd_po_status = 'Approved' or grnd_po_status = 'Normal' or grnd_po_status = 'Pending')  ";
		$result=mysql_query($sql) or die("Mysql error10");
		while ($row=mysql_fetch_array($result))
	$totgrnqty= $row['totrqty'];
	
	$totgrnamt= 0 ;
	$grnmoretot= 0 ;
	$sql1="SELECT distinct grnd_number,grnd_acct_yr from grn_detail where grnd_po_no='$tpono' and grnd_po_acct_yr='$tpoyear' and (grnd_po_status = 'Approved' or grnd_po_status = 'Normal' or grnd_po_status = 'Pending' ) ";
		$result1=mysql_query($sql1) or die("Mysql error11");
		while ($row=mysql_fetch_array($result1))
	{
	$fgrnno=$row['grnd_number'];
	$fgrnyr=$row['grnd_acct_yr'];
	
	
		$sql2="SELECT * from grn_master where grnm_number='$fgrnno' and grnm_acct_yr='$fgrnyr' ";
		$result2=mysql_query($sql2) or die("Mysql error12");
		while ($row=mysql_fetch_array($result2))
	{
	$totgrnamt=$totgrnamt + $row['grnm_grand_tot']  ;
	$grnmoretot= $grnmoretot + $row['grnm_value_more']  ;
	}
	
	}
	
	$less=0;
	$more=0;
	if ($totpoqty==$totgrnqty and ($totgrnamt + $tgttot) <$fundamt)
	$less=$fundamt-($totgrnamt  + $tgttot);
	
	if (($totgrnamt + $tgttot) >$fundamt)
	$more=($totgrnamt + $tgttot)-($fundamt+$grnmoretot);

$sqlgrnm="insert into grn_master(`grnm_number`,`grnm_date`,`grnm_supplier_code`,`grnm_narration`,`grnm_shipment_num`,  `grnm_pur_inv_entered` ,`grnm_tp_no`,`location_code`,`grnm_acct_yr`,`grnm_fob_value`, `grnm_foreign_total`, `grnm_lkr_total`,`grnm_bank_charg`,`grnm_grand_tot`,`grnm_reference`,`grnm_modifiable`,`grnm_cancelled`,`grnm_supp_foreign_local`,`os_user`,`machine_id`,`user_add`,`user_add_date`,`doct_source`,`purchase_type_flag`,`grnm_lc_no`,`grnm_exch_rate`,grnm_fund_yr,grnm_grant_code,grnm_fund_code,grnm_fund_fac,grnm_fund_dept,grnm_fund_prog,grnm_value_more,grnm_value_less)values ('$tgrnno','$tdateh','$tsupcode','$tusername/$tpono',$tship,'N','$tusername/$tyear/$tpono','$tlocation','$tyear','$tfob','$tfrtot','$tlkrtot','$tbankchar','$tgttot','$tref','$tmodify','N','$tlof','$tusername',null,'$tusername','$tdatetime','GRN','$flag',$tlc,$texchrate,$tpoyear,'$grantcode','$fundcode','$fundfac','$funddept','$fundprog',$more,$less)"	 ; 
}
else{
	$sqlgrnm="insert into grn_master(`grnm_number`,`grnm_date`,`grnm_supplier_code`,`grnm_narration`,`grnm_shipment_num`,  `grnm_pur_inv_entered`,`grnm_tp_no`,`location_code`,`grnm_acct_yr`,`grnm_fob_value`,`grnm_foreign_total`,`grnm_lkr_total`,`grnm_bank_charg`,`grnm_grand_tot`,`grnm_reference`,`grnm_modifiable`,`grnm_cancelled`,`grnm_supp_foreign_local`,`os_user`,`machine_id`,`user_add`,`user_add_date`,`doct_source`,`purchase_type_flag`,`grnm_lc_no`,`grnm_exch_rate`)values ('$tgrnno','$tdateh','$tsupcode','$tusername/$tpono',$tship,'N','$tusername/$tyear/$tpono','$tlocation','$tyear','$tfob','$tfrtot','$tlkrtot','$tbankchar','$tgttot','$tref','$tmodify','N','$tlof','$tusername',null,'$tusername','$tdatetime','GRN','$flag',$tlc,$texchrate)"	 ; 
}	
	


//fund Part 2..........................................................................
		$result2= mysql_query($sqlgrnm) or die(mysql_error());
		
	echo "<script> alert ('GRN $tgrnno - $tdateh added successfully!!'); </script>"; 
	if ($confirm == "Normal")
	{
		//echo self.print();
		header("location:rptgrnreport.php?grnid=".$tgrnno."&grnyr=".$tyear);
	}
	unset($_REQUEST);

	if ($j)
	{
		$to ="dbsupplies@kln.ac.lk";
		$subject="Requsting for approval to change item unit price";
		$message=" Date : $tdatetime\n\n GRN No : $tgrnno - $tdateh\n Supplier : $lstSupplier \n PO No : $lstPO\n User : $tusername\n\n Please Pay Your Attention.\n Thank You";
		$headers = "From: uokfinadmin@kln.ac.lk";
		$mailnew= mail($to,$subject,$message,$headers);
		if ($mailnew)
		{
		echo "<script> alert ('PO unit price differ than GRN unit price. Informing Management.......Mail has been sent to management successfully')</script>";
		}
		else
		{
		echo "<script> alert ('Failed to sent the mail')</script>";
		}
	}
}

$tyear=strftime("%Y");
$maxno=0;

$sql="select * from grn_detail where grnd_acct_yr='$tyear' order by grnd_number desc limit 1 ";
$result=mysql_query($sql) or die("Mysql error13");
$row= mysql_fetch_assoc($result);
$maxno=$row['grnd_number']  ;

$nextno=(int)$maxno+1;
$disgrnno= str_pad($nextno,6,0,STR_PAD_LEFT);
$grnno=$tyear."/". $disgrnno; 


?>

<!--*********************************************************************************************************-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Good Recieved Note</title>

<link rel="stylesheet" href="css/style.css" type="text/css">

<script>

function calcBal(i)
{
	txtRecd=document.getElementById('txtRecd_'+i);
	txtOrderQty=document.getElementById('txtOrQty_'+i);
	txtRecdAlready=document.getElementById('txtRecAl_'+i);
	txtBal=document.getElementById('txtBal_'+i);
	//..................
	txtunitTax=document.getElementById('txtunitTax_' +i);
	txtVal=document.getElementById('txtVal_' +i);
	txtGTot=document.getElementById('txtGTot');
	//......................
	txtBal1= +txtOrderQty.value-(+txtRecdAlready.value + +txtRecd.value);
	if (txtBal1 < "0")
	{
		alert('Recieved Quantity Is Greater Than The Ordered Quantity');
		txtBal.value = "";
		txtRecd.value= "";
		txtVal.value="";
		txtunitTax.value="";
		txtGTot.value="";
		return false;
	}
	else
	{
		txtBal.value=txtBal1;
		return true;
	}
}

//...........................On and Before 2012-08-02 get tax without round off ..............> 
function calcTax_02082012(i)
{
	txtEditPrice=document.getElementById('txtEditPrice_'+i);
	txtNBT=document.getElementById('txtNBT_'+i);
	txtVAT=document.getElementById('txtVAT_'+i);
	txtOther=document.getElementById('txtOther_'+i);
	txtunitTax=document.getElementById('txtunitTax_'+i);
	
	varunitNBT = (+txtEditPrice.value * (+txtNBT.value / 100));
	vartotNBT = (+txtEditPrice.value + +varunitNBT);
	varunitVAT = (+vartotNBT * (+txtVAT.value / 100)); 
	numtax = (+varunitNBT + +varunitVAT + +txtOther.value);
	txtunitTax.value = numtax;  
}

function calcVal_02082012(i)
{
	txtRecieved=document.getElementById('txtRecd_'+i);
	txtunitTax=document.getElementById('txtunitTax_' +i);
	txtEditPrice=document.getElementById('txtEditPrice_' +i);
	txtVal=document.getElementById('txtVal_' +i);
	txtNBT=document.getElementById('txtNBT_'+i);
	txtVAT=document.getElementById('txtVAT_'+i);
	txtOther=document.getElementById('txtOther_'+i);
	
	varunitNBT = (+txtEditPrice.value * (+txtNBT.value / 100));
	vartotNBT = (+txtEditPrice.value + +varunitNBT);
	varunitVAT = (+vartotNBT * (+txtVAT.value / 100)); 
	numtax = (+varunitNBT + +varunitVAT + +txtOther.value);
	varunittot = (+txtEditPrice.value + +numtax);
	numtot = (+varunittot * (+txtRecieved.value)) ;
	txtVal.value = numtot.toFixed(2); 
	
}

//....................................................................<

//...........................On and Before 2012-08-15 get tax to two decimal points without round off ..............> 
function calcTax_15082012(i)
{
		
	txtEditPrice=document.getElementById('txtEditPrice_'+i);
	txtNBT=document.getElementById('txtNBT_'+i);
	txtVAT=document.getElementById('txtVAT_'+i);
	txtOther=document.getElementById('txtOther_'+i);
	txtunitTax=document.getElementById('txtunitTax_'+i);
	
	varunittNBT = (+txtEditPrice.value * (+txtNBT.value / 100));	
	varunitNBT1 = (varunittNBT + "").split(".");
	varunitNBTint =  varunitNBT1[0];			
	varNBTlen = varunitNBTint.toString().length;	
	varunitNBT = (varunittNBT + " ").substr(0,varNBTlen + 3) ;
	vartotNBT = (+txtEditPrice.value + +varunitNBT);	
	varunittVAT = (+vartotNBT * (+txtVAT.value / 100));
	varunitVAT1 = (varunittVAT + "").split(".");
	varunitVATint =  varunitVAT1[0];	
	varVATlen = varunitVATint.toString().length;
	varunitVAT = (varunittVAT + "").substr(0,varVATlen + 3); 
	numtax = (+varunitNBT + +varunitVAT + +txtOther.value);
	txtunitTax.value = numtax;  
}

function calcVal_15082012(i)
{
	txtRecieved=document.getElementById('txtRecd_'+i);
	txtunitTax=document.getElementById('txtunitTax_' +i);
	txtEditPrice=document.getElementById('txtEditPrice_' +i);
	txtVal=document.getElementById('txtVal_' +i);
	txtNBT=document.getElementById('txtNBT_'+i);
	txtVAT=document.getElementById('txtVAT_'+i);
	txtOther=document.getElementById('txtOther_'+i);
	
	varunittNBT = (+txtEditPrice.value * (+txtNBT.value / 100));	
	varunitNBT1 = (varunittNBT + "").split(".");
	varunitNBTint =  varunitNBT1[0];	
	varNBTlen = varunitNBTint.toString().length;
	varunitNBT = (varunittNBT + "").substr(0,varNBTlen + 3) ;
	vartotNBT = (+txtEditPrice.value + +varunitNBT);
	varunittVAT = (+vartotNBT * (+txtVAT.value / 100));
	varunitVAT1 = (varunittVAT + "").split(".");
	varunitVATint =  varunitVAT1[0];	
	varVATlen = varunitVATint.toString().length;
	varunitVAT = (varunittVAT + "").substr(0,varVATlen + 3) ; 
	numtax = (+varunitNBT + +varunitVAT + +txtOther.value);
	varunittot = (+txtEditPrice.value + +numtax);
	numtot = (+varunittot * (+txtRecieved.value)) ;
	txtVal.value = numtot.toFixed(2);  
}

//.......................On and Before 2012-11-13 calculate the tax to unitprice.............................................<

function calcTax_13112012(i)
{
	txtEditPrice=document.getElementById('txtEditPrice_'+i);
	txtNBT=document.getElementById('txtNBT_'+i);
	txtVAT=document.getElementById('txtVAT_'+i);
	txtOther=document.getElementById('txtOther_'+i);
	txtunitTax=document.getElementById('txtunitTax_'+i);
	
	vartunitNBT = (+txtEditPrice.value * (+txtNBT.value / 100));
	varunitNBT = vartunitNBT.toFixed(2);
	vartotNBT = (+txtEditPrice.value + +varunitNBT);
	vartunitVAT = (+vartotNBT * (+txtVAT.value / 100)); 
	varunitVAT= vartunitVAT.toFixed(2);
	numtax = (+varunitNBT + +varunitVAT + +txtOther.value);
	txtunitTax.value = numtax; 
}

function calcVal_13112012(i)
{
	txtRecieved=document.getElementById('txtRecd_'+i);
	txtunitTax=document.getElementById('txtunitTax_' +i);
	txtEditPrice=document.getElementById('txtEditPrice_' +i);
	txtVal=document.getElementById('txtVal_' +i);
	txtNBT=document.getElementById('txtNBT_'+i);
	txtVAT=document.getElementById('txtVAT_'+i);
	txtOther=document.getElementById('txtOther_'+i);
	
	vartunitNBT = (+txtEditPrice.value * (+txtNBT.value / 100));
	varunitNBT = vartunitNBT.toFixed(2);
	vartotNBT = (+txtEditPrice.value + +varunitNBT);
	vartunitVAT = (+vartotNBT * (+txtVAT.value / 100));
	varunitVAT= vartunitVAT.toFixed(2); 
	numtax = (+varunitNBT + +varunitVAT + +txtOther.value);
	varunittot = (+txtEditPrice.value + +numtax);
	numtot = (+varunittot * (+txtRecieved.value)) ;
	txtVal.value = numtot.toFixed(2);
	txtRecieved.readOnly = true; 
}

//..........................After 2012-11-13 calculate the tax for total quantity..........................................<

function calcTax(i)
{
	txtRecieved=document.getElementById('txtRecd_'+i);
	txtEditPrice=document.getElementById('txtEditPrice_'+i);
	txtNBT=document.getElementById('txtNBT_'+i);
	txtVAT=document.getElementById('txtVAT_'+i);
	txtOther=document.getElementById('txtOther_'+i);
	txtunitTax=document.getElementById('txtunitTax_'+i);
	
	vartot = (+txtEditPrice.value * (+txtRecieved.value));
	varunitNBT = (+vartot * (+txtNBT.value / 100));
	vartotNBT = (+vartot + +varunitNBT);
	varunitVAT = (+vartotNBT * (+txtVAT.value / 100));
	numtax = (+varunitNBT + +varunitVAT + +txtOther.value);
	if(txtRecieved.value == 0)
	{
		unittax = 0;
	}
	else
	{
	unittax= +numtax / (+txtRecieved.value);
	}
	txtunitTax.value = unittax; 
}

function calcVal(i)
{
	txtRecieved=document.getElementById('txtRecd_'+i);
	txtunitTax=document.getElementById('txtunitTax_' +i);
	txtEditPrice=document.getElementById('txtEditPrice_' +i);
	txtVal=document.getElementById('txtVal_' +i);
	txtNBT=document.getElementById('txtNBT_'+i);
	txtVAT=document.getElementById('txtVAT_'+i);
	txtOther=document.getElementById('txtOther_'+i);
	
	vartot = (+txtEditPrice.value * (+txtRecieved.value));
	varunitNBT = (+vartot * (+txtNBT.value / 100));
	vartotNBT = (+vartot + +varunitNBT);
	varunitVAT = (+vartotNBT * (+txtVAT.value / 100));
	numtax = (+varunitNBT + +varunitVAT + +txtOther.value);
	vartottax= numtax.toFixed(2); 
	vargrtot = (+vartot + +vartottax);
	txtVal.value = vargrtot;
	txtRecieved.readOnly = true; 
}
//.........................................................................

function calcTot(i)
{
	var t=0;
	var grTot=0;
	var frTot=0;
	txtRecieved=document.getElementById('txtRecd_'+i);
	txtGTot=document.getElementById('txtGTot');
	lstLOF=document.getElementById('lstLOF');
	txtFreight=document.getElementById('txtFreight');
	txtInsu=document.getElementById('txtInsu');
	txtOther=document.getElementById('txtOther');
	if(isNaN(txtRecieved.value))
	{
		alert("Invalid entry!!");
		return false;
	}
	else
	{
	for (t=1;t<=i;t++)
	{
		txtTot=document.getElementById('txtVal_' +t);
		//alert(txtTot.value);
		//alert(grTot);
		grTot = (+grTot + (+txtTot.value)) ;
		
	}
	//alert(grTot.toFixed(2));
	txtGTot.value= grTot.toFixed(2);
	if (lstLOF.value=="F")
	{
		txtFOB.value= grTot.toFixed(2);
		frTot = (+grTot + (+txtFreight.value) + (+txtInsu.value) + (+txtOther.value));
		txtFrTot.value= frTot;
	}
	}
	
}

function calcLkrTotal()
{
	txtExchRate=document.getElementById('txtExchRate');
	txtFrTot=document.getElementById('txtFrTot');
	txtLkrTotal=document.getElementById('txtLkrTotal');
	txtBnkCharg=document.getElementById('txtBnkCharg');
	txtFrGrTot=document.getElementById('txtFrGrTot');
	
	if (txtExchRate.value == "" || txtBnkCharg.value == "")
	{
		alert("Please enter the exchange rate/bank charges");
		return false;
	}
	//!!!!!!!!!!!!!!!!!!!!!!!!!
	
	theNum = txtBnkCharg.value.toString();  
    var regExp = /^\d{1,}\.\d{2}$/;  //format #.## required  
    var formatLine = theNum.match(regExp);  
    if(!formatLine)
	{ //Test if there was no match  
  		alert("The amount entered: " + theNum + " is not in the correct format of x.xx"); //Display Error  
  txtBnkCharg.focus();  //Force User To Enter Correct Amount  
	}
	
	theRate = txtExchRate.value.toString();  
    //var regExp = /^\d{0,}\.\d{2}$/;    //format  .## required  
    var regExp1 = /^\d{1,}\.\d{7}$/;  //format #.## required  
    var formatLine1 = theRate.match(regExp1);  
    if(!formatLine1)
	{ //Test if there was no match  
  		alert("The amount entered: " + theRate + " is not in the correct format of x.xxxxxxxx"); //Display Error  
  txtExchRate.focus();  //Force User To Enter Correct Amount  
	}
  //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	else
	{	
	LkrTotal = (+txtFrTot.value) * (+txtExchRate.value);
	txtLkrTotal.value = LkrTotal.toFixed(2);
	FrGrTot = (+txtLkrTotal.value + (+txtBnkCharg.value));
	txtFrGrTot.value = FrGrTot.toFixed(2);
	txtExchRate.readOnly = true;
	txtBnkCharg.readOnly = true;
	}
	
}


function validateForm()
{	
	tyear=document.getElementById('lstYear');
	tsupplier=document.getElementById('lstSupplier');
	tlocation=document.getElementById('lstLocation');
	tpo=document.getElementById('lstPO');
	tref=document.getElementById('txtRef');
	tlc=document.getElementById('txtLC');
	tship=document.getElementById('txtShip');
	texch=document.getElementById('txtExchRate');
	tbnkch=document.getElementById('txtBnkCharg');
	tgtot=document.getElementById('txtGTot');
	tlkrtot=document.getElementById('txtLkrTotal');
	tfrgrtot=document.getElementById('txtFrGrTot');
	tcurtype=document.getElementById('txtCurType');
	
	if (tyear.value=="0")
	{
		alert('Please select a supplier registered year');
		return false;
	}
	
	if (tsupplier.value=="0")
	{
		alert('Please select a supplier');
		return false;
	}
	
	if (tpo.value=="0")
	{
		alert('Please select a PO');
		return false;
	}
	
	if (tref.value=="")
	{
		alert('Please enter a reference');
		return false;
	}
	
	if (tgtot.value=="" || tgtot.value==0)
	{
		alert('Please get the Grand Total');
		return false;
	}
	
	
	if (tlkrtot.value=="" || tlkrtot.value==0)
	{
		alert('Please get the LKR Total');
		return false;
	}
	
	
	if (lstLOF.value=='F')
	{

	if(tfrgrtot.value == "" || tfrgrtot.value==0) 
		{
			alert('Please get the Grand Total');
			return false;
		}
		if(tlc.value == "") 
		{
			alert('Please enter the L.C./T.T./B.D. number');
			return false;
		}
	}
	
	if (isNaN(tlc.value) || isNaN(tship.value) || isNaN(texch.value) || isNaN(tbnkch.value))
	{
		alert('Invalid entry');
		return false;
	}
	
	titemrows=document.getElementById('hdrows');
	var pricechange=false;
	for (i=1;i<=titemrows.value;i++)
	{
		trecqty=document.getElementById('txtRecd_'+i);
		if (trecqty.value=="")
		{
			alert('Please enter Received Quantity');
			return false;
		}
		tprice=document.getElementById('txtUnitPrice_'+i);
		teditprice=document.getElementById('txtEditPrice_'+i);
		pricechange1=pricechange || (tprice.value!=teditprice.value);	
	}
	
	if (pricechange1)
	{
		var confirmation = confirm('PO unit price differ than GRN unit price. Are you sure you want to save?');
		if (confirmation)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	else
	{
		tbuttons=document.getElementById('buttons');
		tfooter=document.getElementById('footer');
		theader=document.getElementById('header');
		theader.style.display='inline';
		tbuttons.style.display='none';
		tfooter.style.display='inline';
		return true;
	}
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


<form id="form1" name="form1" method="post" action="" >

<table width="100%" border="0" id="cmd" style="background-color:lightblue;">
<tr><td>
<table width="75%" border="0" id="cmd" style="background-color:lightblue;" align="center">				
                <tr>
					<td align="left">
                      <div style="height:auto" align="left"><strong><span style="text-align: left"></span>GRN No.
                          <?php 
							echo $grnno; 
						?>
                          </strong></div></td>
                          <td><span class="style31">Date&nbsp;&nbsp;&nbsp;</span>								<span class="style28"><strong>
									<?php echo $tdate; ?>
									<input name="hddate" type="hidden" id="hddate" value="<?php echo $tdate ?>" /></strong></span>								</td>
				</tr>
				<tr>
					<td width="15%"><span>Supplier Year</span></td>											
					<td width="15%"><select name="lstYear" id="lstYear" onchange="submit()" class="styleselect1" >
							              <option value="0" selected="selected">Select... </option>
							              <option value="<?php echo $tyear-2; ?>" <?php if ($lstYear==$tyear-2) {echo "selected=\"selected\"";}?>>
					                      <?php echo $tyear-2; ?>						                    </option>
							              <option value="<?php echo $tyear-1; ?>" <?php if ($lstYear==$tyear-1) {echo "selected=\"selected\"";}?>> 
					                      <?php echo $tyear-1; ?>						                    </option>
							              <option value="<?php echo $tyear; ?>" <?php if ($lstYear==$tyear) {echo "selected=\"selected\"";}?>> 
					                      <?php echo $tyear; ?>						                    </option>
					              </select>
						       
					          </label></td>
                              <td width="15%" align="right">Supplier&nbsp;&nbsp;&nbsp;</td>
								<td class="style31"><select name="lstSupplier" id="lstSupplier" onChange="submit()" class="styleselect1">
                                  <option value="0">Select... </option>
                                  <?php
											$sql="select distinct supplier_code,supplier_name from supplier where `sup_year`='$lstYear' order by `supplier_name` asc ";
											$result = mysql_query($sql) or die("Mysql error2");
											while($row=mysql_fetch_assoc($result))
											{
										?>
                                  <option value="<?php echo $row['supplier_code']?>" 
										<?php 
											if (!isset($_REQUEST['lstSupplier'])) 
											$_REQUEST['lstSupplier'] = "undefine"; 
											if($row['supplier_code']===$_REQUEST['lstSupplier'])
											echo " selected=\"selected\" " ;
										?>>
                                  <?php	 
											echo $row['supplier_name'].' - '.$row['supplier_code'];
										?>
                                  </option>
                                  <?php
											}
										?>
                                </select></td>
						    </tr>
							<tr>
                            	<td height="26"><span class="style31">Referance</span>								</td>
								<td> <input name="txtRef" type="text" id="txtRef" />								</td>
								<td align="right"><!--<span>Remark&nbsp;&nbsp;&nbsp;&nbsp;</span>-->								</td>
								<td>                	
								  <!--<input name="txtNarration" type="text" id="txtNarration" readonly="readonly" />-->								</td>
							</tr>
							<tr>
								
							</tr>
				<tr>
                	<td></td>
					<td height="100%" colspan="2"><span class="style31">PO no.<span>
					  <select name='lstPO' id="lstPO" style="width:50%;" onChange="submit()" class="styleselect1">
                        <option value="0">Select... </option>
                        <?php
								if (isset($_REQUEST['lstSupplier']) && $_REQUEST['lstSupplier']!=0)
								{ 
								$sql="select distinct `pod_po_no`,`pod_acct_yr` from vSupPoHasBalance WHERE pom_sup_code=$_REQUEST[lstSupplier] AND pod_acct_yr='$lstYear' AND `grn_status`!='Pending'  ORDER BY `pod_po_no` ASC";
								$result = mysql_query($sql) or die("Mysql error1");
								while($row=mysql_fetch_assoc($result))
								{
									$temppo =$row['pod_po_no'];
									$temppoyr =$row['pod_acct_yr'];
									$tempsql="SELECT `grn_master`.`purchase_type_flag` FROM `grn_master`, `grn_detail` WHERE  `grnm_number`=`grnd_number` and `grnm_acct_yr`= `grnd_acct_yr` and `grnd_po_acct_yr`=$temppoyr and `grnd_po_no`=$temppo  order by `grnd_number` desc limit 1";
									$tempresult = mysql_query($tempsql) or die("Mysql error2");
									$temprow=mysql_fetch_assoc($tempresult);
									$tempstatus= $temprow['purchase_type_flag'];
									$fundcheck="SELECT `pom_cancel`,`fund_avail`,`po_approved` FROM `purch_ord_mas` WHERE `pom_po_no`=$temppo and `pom_acct_yr`=$temppoyr";
									$tempfund = mysql_query($fundcheck) or die("Mysql error3");
									$fundrow=mysql_fetch_assoc($tempfund);
									$temppoc =$fundrow['pom_cancel'];
									$temppoavail =$fundrow['fund_avail'];
									$temppoapp =$fundrow['po_approved'];
									if ($tempstatus != 'PendingGRN' && $temppoc != 'Y' && $temppoavail != 'N' && ($temppoavail != 'Y' || $temppoapp != 'Y'))
									{
									
							?>
                        <option value="<?php echo $row['pod_po_no'].' - '. $row['pod_acct_yr'];?>"
							<?php 
								if (!isset($_REQUEST['lstPO'])) 
								$_REQUEST['lstPO'] = "undefine"; 
								if(($row['pod_po_no'].' - '.$row['pod_acct_yr'])===$_REQUEST['lstPO'])
								echo "selected=\"selected\"" ;
							?>>
                        <?php 
								echo $row['pod_po_no'].' - '.$row['pod_acct_yr'];
							?>
                        </option>
                        <?php
									}
								}
								}
							?>
                    </select>
				  </span></span></td>
                    <td>
                    <span class="style31"><abbr title="Format: xx.xxxxxxx ">Invoice no.</abbr></span> 
					<input type="text" name="txtInv" id="txtInv" maxlength="25" /></td>
				</tr>
			</table>
			<table border="2" width="100%">
			  <tr>
					
					<td width="105" rowspan="2" colspan="2"><div align="center" class="style28"><strong>Item Code &amp; Description </strong></div>					</td>
					<td colspan="4"><div align="center" class="style28"><strong>Quantity</strong></div>					</td>
					<td colspan="7"><div align="center" class="style28"><strong>Price</strong></div>					</td>
				</tr>
				<tr>
					<td width="59"><div align="center" class="style28"><strong>Recieved</strong></div>					</td>
					<td width="59"><div align="center" class="style28"><strong>Ordered</strong></div>					</td>
					<td width="72"><div align="center" class="style28"><strong>Rec.Already</strong></div>					</td>
					<td width="65"><div align="center" class="style28"><strong>Balance</strong></div>					</td>
					<td width="86"><div align="center" class="style28"><strong>PO_Unit Price </strong></div>					</td>
					<td width="105"><div align="center" class="style28"><strong>Edited_Unit Price</strong></div>					</td>
					<td width="44" class="style28"><strong>VAT</strong>(%)</td>
					<td width="84"><strong class="style3">Tax Per Unit</strong></td>
					<td width="60" class="style28"><strong>Value</strong></td>
				</tr>
				<?php 
					if (!isset($_REQUEST['lstPO'])) 
					$_REQUEST['lstPO'] = "undefine"; 
					$str = explode(' - ',$_REQUEST['lstPO']);
					if (isset($_REQUEST['lstPO']) && $_REQUEST['lstPO']!=0)
					{
					$bl = false;
					//.............................Get po date............... 
				$podatesql="SELECT `pom_date` FROM `purch_ord_mas` WHERE `pom_po_no`=$str[0] and `pom_acct_yr`=$str[1]";
				$podateresult = mysql_query($podatesql) or die("Mysql error5");
				$podaterow=mysql_fetch_assoc($podateresult);
				$podate =$podaterow['pom_date'];
					//.......................................................
					
					$sql="select `pod_po_no`,`pod_item_code`,`item_description`,`pod_qty`,`pod_unit_price`,`edit_price`,`pod_nbt`,`pod_vat`,`pod_other`,`already_recd`,`grn_status` from vSupPoHasBalance where balance>0 and `pod_po_no` = $str[0] AND `pod_acct_yr`=$str[1] ;";
					$result=mysql_query($sql);
					$i=0;
					while($row=mysql_fetch_assoc($result))
					{
					$i++;
				?>
				<tr>
				  <td class="style3" colspan="2"><input 
							name="txtItemCode_<?php echo $i;?>" 
							id="txtItemCode_<?php echo  $i;?>" 
							style="border:none" 
							value ="<?php echo $row['pod_item_code'];?>" 
							size="9%" 
							readonly=""
							 /></td>
				  <td colspan="8" class="style3">
			        			      </td>
		      </tr>
				<tr>
					<td colspan="2"><?php 
							echo $row['item_description'];
						?><input style="visibility:hidden"
						  name="txtNBT_<?php echo $i;?>" 
						  type="text" 
						  id="txtNBT_<?php echo $i;?>" 
						  size="1%" 
						  readonly="readonly"
						  value="<?php echo $row['pod_nbt'];?>" 
					  /><input 
						  name="txtOther_<?php echo $i;?>" style="visibility:hidden"
						  type="text" 
						  id="txtOther_<?php echo $i;?>" 
						  readonly="readonly" 
						  value="<?php echo $row['pod_other'];?>"
					  /></td>
					<td><input
							size="8%" 
							style="border:none"
							name="txtRecd_<?php echo $i;?>" 
							id="txtRecd_<?php echo  $i;?>" 
							onblur="calcBal(<?php echo  $i;?>)" 
							onchange="<?php 
							if($podate < date("Y-m-d",strtotime("2012-08-03"))) 
							{
								echo "calcTax_02082012($i);calcVal_02082012($i);calcTot($i)";
							}
								else if($podate < date("Y-m-d",strtotime("2012-08-16"))) 
								{
									echo "calcTax_15082012($i);calcVal_15082012($i);calcTot($i)";
								}
									else if($podate < date("Y-m-d",strtotime("2012-11-14"))) 
									{
										echo "calcTax_13112012($i);calcVal_13112012($i);calcTot($i)";
									}
										else
										{
											echo "calcTax($i);calcVal($i);calcTot($i)";
										}
									?>"
						/></td>
					<td>
					  <input 
							size="8%"  
							style="border:none" 
							readonly=""
							name="txtOrQty_<?php echo $i;?>" 
							id="txtOrQty_<?php echo $i;?>"  
							value=" <?php echo $row['pod_qty'];?>" 
						/>					</td>
					<td>
					  <input 
							size="8%"  
							style="border:none"
							readonly=""
							name="txtRecAl_<?php echo $i;?>" 
							id="txtRecAl_<?php echo $i;?>"  
							value=" <?php echo $row['already_recd'];?>" 
						/></td>
					<td>
					  <input 
							size="8%" 
							style="border:none"
							name="txtBal_<?php echo $i;?>" 
							id="txtBal_<?php echo  $i;?>"
                            readonly="readonly"
						/>					</td>
					<td><input 
							size="11%"  
							style="border:none"
							readonly=""
							name="txtUnitPrice_<?php echo $i;?>" 
							id="txtUnitPrice_<?php echo $i;?>" 
							value="<?php echo $row['pod_unit_price'];?>" 
						/></td>
					<td><input 
							size="10%"  
							style="border:none"
							name="txtEditPrice_<?php echo $i;?>" 
							id="txtEditPrice_<?php echo $i;?>"
							value="<?php if($row['grn_status']=='Normal' || $row['grn_status']=='Approved'){ echo $row['edit_price']; } else {echo $row['pod_unit_price'];}?>" 
							onchange="<?php 
							if($podate < date("Y-m-d",strtotime("2012-08-03"))) 
							{
								echo "calcTax_02082012($i);calcVal_02082012($i);calcTot($i)";
							}
								else if($podate < date("Y-m-d",strtotime("2012-08-16"))) 
								{
									echo "calcTax_15082012($i);calcVal_15082012($i);calcTot($i)";
								}
									else if($podate < date("Y-m-d",strtotime("2012-11-14"))) 
									{
										echo "calcTax($i);calcVal($i);calcTot($i)";
									}
										else
										{
											echo "calcTax($i);calcVal($i);calcTot($i)";
										}
									?>"  
						/></td>
					<td><input 
						  name="txtVAT_<?php echo $i;?>" 
						  type="text" 
						  id="txtVAT_<?php echo $i;?>" 
						  size="5%" 
						  readonly="readonly" 
						  value="<?php echo $row['pod_vat'];?>"
					  /></td>
					<td><input 
							size="10%" 
							type="text"  
							style="border:none"
							name="txtunitTax_<?php echo $i;?>" 
							id="txtunitTax_<?php echo $i;?>" 
                            readonly="readonly"  
						/></td>
				    <td>
						<input 
							size="10%"
							type="text"  
							style="border:none"
							name="txtVal_<?php echo $i;?>" 
							id="txtVal_<?php echo $i;?>" 
						    readonly="readonly"
						/>
						<input type="hidden" name="hdgtot" id="hdgtot" value="txtVal_<?php echo $i;?>"  />
				  </td>
				</tr>
				<?php
					}
					
					}
				?>
				<input type="hidden" name="hdrows" id="hdrows" value="<?php echo $i;?>" />
				<input type="hidden" name="hdcur" id="hdcur" value="<?php echo $pocur ; ?>" />
				
				<tr>
				  <td colspan="2">&nbsp;</td>
				  <td colspan="7">&nbsp;</td>
				  <td><strong><?php if($lstLOF !="F"){?>Grand <?php } ?> Total</strong></td>
				  <td><input name="txtGTot" type="text" readonly="readonly" id="txtGTot" size="10%" onclick="calcTot(<?php echo $i;?>)" /></td>
			  </tr>
              <?php if($lstLOF =="F"){?>
              <tr>
				  <td colspan="13" bgcolor="#CCCCCC" style="color:#FFF"><span> Foreign Suppliers Only</span></td>
			  </tr>
				</table></td>
				  <td><strong>Total<?php echo '['.$pocur.']'; ?></strong></td>
				  <td><input type="text" name="txtFrTot" id="txtFrTot" size="10%" readonly="readonly" /></td>
			  </tr>
				<tr>
				  <td><strong>Total [LKR]</strong></td>
				  <td><span>
				    <input type="text" name="txtLkrTotal" id="txtLkrTotal" size="10%" readonly="readonly"/>
				  </span></td>
			  </tr>
				<tr>
					<td  class="style28"><strong><abbr title="Format: x.xx ">Bank Charges</abbr></strong></td>
					 
			        <td class="style28"><input type="text" name="txtBnkCharg" id="txtBnkCharg" size="10%" /></td>
				</tr>
				<tr>
				  <td  class="style28"><strong>Grand Total </strong></td>
                  <td  class="style28"><input type="text" name="txtFrGrTot" id="txtFrGrTot" size="10%" readonly="readonly" onclick="calcLkrTotal();" /></td>
			  </tr>
              <?php } ?>
			</table>
	  </td>
	</tr>
	<tr>
	  <td height="100%" colspan="3">
	  <div id="buttons"><input name="btnSave" type="submit" class="btn2" id="btnSave" value="Save" onclick="return validateForm()"/>
	    <label>
	    <input name="btnClear" type="submit" id="btnClear" value="Clear" class="btn2" />
	    </label>
	    </div>
			<!--<div id="footer" style="visibility:hidden;z-index:-1;display:none" >-->
            <div id ="footer" style="display:none">
          
			<table width="100%" border="0">
            <tr>
            <td height="45" align="center"><p><br />
            ......................<br />Signature</p></td>
			<td align="center"><p><br />
			  ........................<br />Date</p></td>
            </tr>
			<tr>
			<td height="40"></td>
			<td></td> 
			</tr>
            </table>
            
			<?php include 'footer.php'; ?> </div></td>
	</tr>

</body>
</html>
