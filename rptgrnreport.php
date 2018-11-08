<?php

//require('fpdf17/fpdf.php');
require('pdfpath.php');
require('db.inc.php');
 
class PDF extends PDF_MC_Table
{
	
function Header()
{
	global $grnid;
	$grnyr = $_GET['grnyr'];
	$this->Image('images/ucsclogo.png',10,5,35,35);
   // $this->Ln(2);	
	//$this->Line(10,45,200,45);
    $this->Ln(2);
	$this->SetFont('Times','B',13);
	//$this->SetTextColor(78,0,0);
	$this->Cell(40);
	$this->Cell(5,15,'UNIVERSITY OF COLOMBO SCHOOL OF COMPUTING',0,0,'L');
	$this->Cell(23);
	$this->Cell(10,30,'Goods Received Note ',0,0,'L');
	//$this->SetFont('Times','B',13);
	$this->Cell(23);
	$this->Cell(48,80,"GRN No.: ".$grnyr."/".$grnid,0,0,'L');
	//$this->Cell(10,43,'GRN No:',0,0,'L');
	$this->Cell(67);
	$this->SetFont('Helvetica','BIU',13);
	$this->Cell(10,47,$grnyr."/".$grnid,0,1,'C');    
}

function Footer()
{
	// Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',7);
	// Text color in gray
    $this->SetTextColor(128);
    // Page number
	$this->Cell(0,10,'Desgned By: IMS - UCSC '.'(Page '.$this->PageNo().')',0,0,'C');
}


function BasicTable($rptsupcode,$rptdate,$rptsupname,$rptref,$rptadd1,$rptadd2,$rptlcno,$rptadd3,$rptadd4,$rptpoyr,$rptuser,$rptpono,$rptsupadd2,$rptloccode,$rptfol,$rptshipno)
{
	$this->SetY(48);
	$this->SetFont('Times','B',12);
	$this->Cell(28,8,'Supplier Name',0,0,'L',false);
	$this->SetFont('Helvetica','',10);
	$this->Cell(45,8,': '.$rptsupname,0);
	$this->Ln(7);
	$this->SetFont('Times','B',12);	
	$this->Cell(102,8,' ',0,0,'L',false);	
	/* $this->SetFont('Helvetica','',10);
	$this->Cell(73,8,': '.$rptref,0); */		
	$this->SetFont('Times','B',12);
	$this->Cell(10,8,'Date',0,0,'L',false);
	$this->SetFont('Helvetica','',10);
	$this->Cell(45,8,': '.$rptdate,0);
	$this->Ln(1);
	$this->SetFont('Times','B',12);
	$this->Cell(28,2,' ',0,0,'L',false);
	$this->SetFont('Helvetica','',10);
	$this->Cell(73,8,': '.$rptadd1.','.$rptadd2,0);
	$this->SetFont('Times','B',12);
	$this->Cell(35,8,'',0,0,'L',false);
	$this->Ln(7);
	$this->SetFont('Times','B',12);
	$this->Cell(35,8,'',0,0,'L',false);
	if($rptadd3 != ''){
	$this->SetFont('Helvetica','',10);
	$this->Cell(73,8,' '.$rptadd3.','.$rptadd4,0);
	/* $this->SetFont('Times','B',12);
	$this->Cell(28,8,'LC/TT/BD No',0,0,'L',false); */
	$this->SetFont('Helvetica','',10);
	if($rptfol == 'Foreign'){
	$this->Cell(45,8,': '.$rptlcno,0);}
	if($rptfol == 'Local'){
	$this->Cell(45,8,': ',0);}
	$this->Ln(7);
	$this->SetFont('Times','B',12);
	$this->Cell(35,8,'',0,0,'L',false);
	$this->SetFont('Helvetica','',10);
	$this->Cell(73,8,'  '.$rptsupadd2,0);
	$this->SetFont('Times','B',12);
	$this->Cell(28,8,'P.O.No',0,0,'L',false);
	/* $this->SetFont('Helvetica','',10);
	$this->Cell(45,8,': '.$rptpoyr.' / '.$rptuser.' / '.$rptpono,0); */
	$this->Ln(7);
	$this->SetFont('Times','B',12);
	$this->Cell(108,8,'',0,0,'L',false);
	/* $this->SetFont('Times','B',12);
	$this->Cell(28,8,'Store Location',0,0,'L',false);
	$this->SetFont('Helvetica','',10);
	$this->Cell(45,8,': '.$rptloccode,0); */
	$this->Ln(7);
	}
	else{
	$this->SetFont('Helvetica','',10);
	$this->Cell(73,8,'  '.$rptsupadd2,0);
	/* $this->SetFont('Times','B',12);
	$this->Cell(28,8,'LC/TT/BD No',0,0,'L',false);
	$this->SetFont('Helvetica','',10);
	if($rptfol == 'Foreign'){
	$this->Cell(45,8,': '.$rptlcno,0);}
	if($rptfol == 'Local'){
	$this->Cell(45,8,': ',0);}
	$this->Ln(7);
	$this->SetFont('Times','B',12);
	$this->Cell(108,8,'',0,0,'L',false); 
	$this->SetFont('Times','B',12);
	$this->Cell(28,8,'P.O.No',0,0,'L',false);
	$this->SetFont('Helvetica','',10);
	$this->Cell(45,8,': '.$rptpoyr.' / '.$rptuser.' / '.$rptpono,0);
	$this->Ln(7);
	$this->SetFont('Times','B',12);
	$this->Cell(108,8,'',0,0,'L',false);
	$this->SetFont('Times','B',12);
	$this->Cell(28,8,'Store Location',0,0,'L',false);
	$this->SetFont('Helvetica','',10);
	$this->Cell(45,8,': '.$rptloccode,0);
	$this->Ln(7);*/
	}
	
	if($rptfol == 'Foreign')
	{
	$this->SetFont('Times','B',12);
	$this->Cell(35,8,'Local/Foreign',0,0,'L',false);
	$this->SetFont('Helvetica','',10);
	$this->Cell(73,8,': '.$rptfol,0);
	$this->SetFont('Times','B',12);
	$this->Cell(28,8,'Shipment No.',0,0,'L',false);
	$this->SetFont('Helvetica','',10);
	$this->Cell(45,8,': '.$rptshipno,0);
	}
	$this->Ln(13); 
}



function FacTable($rptfacname,$rptdeptname,$rptprogname)
{
	$this->Ln(5);
	$this->SetFont('Times','B',12);
	$this->Cell(22,5,'Division : ',0,0,'L');
	$this->SetFont('Helvetica','',10);
	$this->Cell(73,5,$rptfacname,0,0,'L');
	$this->SetFont('Times','B',12);
	$this->Cell(10,5,'Unit : ',0,0,'L');
	$this->SetFont('Helvetica','',10);
	$this->Cell(45,5,$rptdeptname,0,0,'L');
	$this->SetFont('Times','B',12);
	$this->Ln(7);
}


function ItemTable($grnid,$grnyr,$rptpono,$rptpoyr,$rptgrtot,$rptfol,$rptfob,$rptfortot,$rptlkrtot,$rptbkchrg,$rptcur,$rptfrgt,$rptinsu,$rptother,$rptexcrate)
{	
	$this->Ln(2);
	$this->SetFont('Times','B',10);
	//######################################################################
	//$width=array(80,30,30,26,23);
	$this->SetWidths(array(7,20,15,63,10,30,30,12));
	//$this->SetFillColor(239,239,239);
	$header = array('No','PO no./Date','Invoice no.','Description','Qty', 'Unit Price(Rs)','Value(Rs)','Stock book page no.');
	$this->SetAligns(array('C','C','C','C','C','C','C','C'));
	
	$this->Row($header);
	//foreach($header as $row)
//{
//	$this->Cell($width[0],5,$row[0],'1',0,'C');
//}
	$this->SetAligns(array('L','L','R','R','R','R','R','R'));
	//$this->Ln();
	//######################################################################
	
	//$this->Cell(80,8,'ItemCode & Item Description',1,0,'C');
//	$this->Cell(30,8,'Qty. Recieved',1,0,'C');
//	//$this->Cell(18,5,'Qty. Ordered',1);
//	//$this->Cell(17,5,'Rec. Already',1);
//	//$this->Cell(12,5,'Balance',1);
//	//$this->Cell(19,5,'PO_Unit Price',1);
//	$this->Cell(30,8,'PO_Unit Price',1,0,'C');
//	//$this->Cell(10,5,'NBT%',1);
//	//$this->Cell(10,5,'VAT%',1);
//	//$this->Cell(11,5,'Other',1);
//	$this->Cell(26,8,'Tax Per Unit',1,0,'C');
//	$this->Cell(23,8,'Value',1,0,'C');
//	$this->Ln();
	
	$this->SetFont('Helvetica','',9);
	//$this->Cell(49,5,'d',1);
	$sqlitem="SELECT `grnd_item_code`,`grnd_qty_recd`,`grnd_edit_price`,`tax_per_unit`,`invoice_num`,`tot_value` FROM `grn_detail` WHERE `grnd_number`='$grnid' and `grnd_acct_yr`='$grnyr'";

	$resultitem=mysql_query($sqlitem) or die("Mysql error3!!");
	
	while($rowitem = mysql_fetch_array($resultitem))
	{
	
	$rptitemcode=$rowitem['grnd_item_code'];
	$rptqtyrec=$rowitem['grnd_qty_recd'];
	$rptprice=$rowitem['grnd_edit_price'];
	$rpttax=$rowitem['tax_per_unit'];
	$rptin=$rowitem['invoice_num'];
	$rpttot=$rowitem['tot_value'];
	
	$sqlvat="SELECT `pod_item_code`,`pod_nbt`,`pod_vat`,`pod_other`,`item_description` FROM `purch_ord_det`,item_masterfile  WHERE `pod_po_no`='$rptpono' and `pod_item_code`='$rptitemcode' and `pod_acct_yr`='$rptpoyr' and `item_code`=`pod_item_code`";
	
	$resultvat=mysql_query($sqlvat) or die("Mysql error4!!");
	
  	$count=1;
	$rowvat = mysql_fetch_array($resultvat);	
	$rptitemdesc=$rowvat['item_description'];
		
	$data=array($count,$rptpoyr."/".$rptpono,$rptin,$rptitemcode." ".$rptitemdesc,$rptqtyrec,$rptprice,$rpttot," ");
	
//	
//	$this->Cell(80,7,$rptitemcode.' -  '.$rptitemdesc,1);
//	//$this->MultiCell(73,14,$rptitemcode.' -  '.$rptitemdesc,1);
//	//$this->Cell(49,5,$rptitemcode.' - ',1);
//	$this->Cell(30,7,$rptqtyrec,1,0,'R');
//	//$this->Cell(18,5,'100000',1);
//	//$this->Cell(17,5,'123434',1);
//	//$this->Cell(12,5,'122122',1);
//	//$this->Cell(19,5,'1222222.99',1);
//	$this->Cell(30,7,$rptprice,1,0,'R');
//	//$this->Cell(10,5,'4.66',1);
//	//$this->Cell(10,5,'4.66',1);
//	//$this->Cell(11,5,'3.6565',1);
//	$this->Cell(26,7,$rpttax,1,0,'R');
//	$this->Cell(23,7,$rpttot,1,0,'R');
//	$this->Ln();
	$count +=1;
	$this->Row($data);
	if (($count % 18) =='0')
	{
		$this->AddPage();
		$this->Ln(5);
		$this->SetFont('Times','B',12);
		$this->SetAligns(array('C','C','C','C','C','C','C','C'));
		$this->SetWidths(array(7,20,10,68,10,30,30,12));
		$this->Row($header);
		$this->SetAligns(array('L','L','R','R','R','R','R','R'));
		$this->SetFont('Helvetica','',11);
	}
	}
		
	$this->Cell(23,8,'',0);
	$this->Cell(57,8,'',0);
	$this->Cell(30,8,'',0);
	$this->Cell(30,8,'',0);
	$this->SetFont('Times','B',12);
	
	$this->Cell(26,8,'Grand Total',0);
	$this->SetFont('Helvetica','',11);
	$this->Cell(23,6,$rptgrtot,0,0,'R');
	
	$this->Ln(30);
	//$this->sety(150);
	//$this->Line(10,0,200,0);
	$this->Ln(5);
	//$this->Line(10,160,200,160);
	//$this->Ln(2);
	$this->SetFont('Times','B',12);
	$this->Cell(90,5,'Notes & Remarks',0,0,'L');
	$this->Ln(5);
	$this->Cell(190,12,'',1,0,'C');
	$this->Ln(25);
	$this->SetFont('Times','B',12);
	$this->Cell(100,7,'..................................................................',0,0,'C');
	$this->Cell(70,7,'.................................................',0,0,'C');
	$this->Ln();
	$this->Cell(100,5,'Signature',0,0,'C');
	$this->Cell(74,5,'Date',0,0,'C');
	$this->Ln();
}

//function FooterTable()
//{
//	$this->sety(150);
//	//$this->Ln(5);
//	$this->SetFont('Helvetica','B',7);
//	$this->Cell(100,5,'......................................................................',0,0,'C');
//	$this->Cell(60,5,'......................................',0,0,'C');
//	$this->Ln();
//	$this->Cell(100,5,'Signature',0,0,'C');
//	$this->Cell(60,5,'Date',0,0,'C');
//	$this->Ln();
//}

}

//##################################################################################################

$pdf = new PDF('P','mm','A4');

//$header = array('ItemCode & Item Description', 'Qty Recieved', 'Qty Ordered', 'PO_Unit Price', 'PO_Edit Price','Tax Per Unit','value');
$grnid=$_GET['grnid'];
$grnyr=$_GET['grnyr'];
//$tgrnArr =explode('/',$grnid);
//$tgrnyr=$tgrnArr[0];
//$tmgrnno= $tgrnArr[1];
//$tgrnno=str_pad($tmgrnno,6,0,STR_PAD_LEFT);
$pdf->SetTitle($grnid);

$sqlgrnm="SELECT distinct `grnm_supplier_code`,`supplier_name`,`supplier_address1`,`supplier_address2`,`supplier_address3`,`grnd_po_no`,`grnd_po_acct_yr`,grn_detail.`dep_code`,grn_detail.`sec_code`,grn_detail.`prog_code`,`grnm_lc_no`,`location_code`,`grnm_supp_foreign_local`,`grnm_narration`,`grnm_fob_value`,`grnm_foreign_total`,`grnm_lkr_total`,`grnm_bank_charg`,`grnm_grand_tot`,`grnm_reference`,`grnm_shipment_num`,`grnm_exch_rate`,grn_master.`user_add_date` FROM `grn_master`,supplier,grn_detail WHERE `grnm_number`='$grnid' and `grnm_acct_yr`='$grnyr' and supplier.`supplier_code` =grn_master.`grnm_supplier_code` and `grnd_number`=`grnm_number` and `grnd_acct_yr`=`grnm_acct_yr` and `grnd_po_acct_yr`=supplier.sup_year";

$resultgrnm=mysql_query($sqlgrnm) or die("Mysql error1!!");
$rowgrnm=mysql_fetch_array($resultgrnm);
//echo ;
$rptsupcode=$rowgrnm['grnm_supplier_code'];
$rptsupname=$rowgrnm['supplier_name'];
$rptsupadd1=$rowgrnm['supplier_address1'];
$rptadd=explode(',',$rptsupadd1);
$rptadd1=$rptadd[0];
$rptadd2=$rptadd[1];
$rptadd3=$rptadd[2];
$rptadd4=$rptadd[3];
$rptsupadd2=$rowgrnm['supplier_address2'];
$rptsupadd3=$rowgrnm['supplier_address3'];
$rptloccode=$rowgrnm['location_code'];
$rptfol1=$rowgrnm['grnm_supp_foreign_local'];
if($rptfol1 == 'L')$rptfol='Local';
if($rptfol1 == 'F')$rptfol='Foreign';
$rptadddate=$rowgrnm['user_add_date'];
$rptdt = explode(' ',$rptadddate);
$rptdate=$rptdt[0];
$rptlcno=$rowgrnm['grnm_lc_no'];
$rptshipno=$rowgrnm['grnm_shipment_num'];
$rptexcrate=$rowgrnm['grnm_exch_rate'];
$rptpono=$rowgrnm['grnd_po_no'];
$rptpoyr=$rowgrnm['grnd_po_acct_yr'];
$rptfob=$rowgrnm['grnm_fob_value'];
$rptfortot=$rowgrnm['grnm_foreign_total'];
$rptlkrtot=$rowgrnm['grnm_lkr_total'];
$rptbkchrg=$rowgrnm['grnm_bank_charg'];
$rptgrtot=$rowgrnm['grnm_grand_tot'];
$rptref=$rowgrnm['grnm_reference'];
$rptfac=$rowgrnm['dep_code'];
$rptdep=$rowgrnm['sec_code'];
$rptprog=$rowgrnm['prog_code'];

$sqlfac="SELECT `div_name` FROM `division_masterfile` WHERE `div_code`='$rptfac'";
$resultfac=mysql_query($sqlfac) or die("Mysql errorI!!");
$rowfac=mysql_fetch_array($resultfac);
$rptfacname=$rowfac['div_name'];

$sqldept="SELECT `unit_name` FROM `unit_masterfile` WHERE `unit_code`='$rptdep'";
$resultdept=mysql_query($sqldept) or die("Mysql errorII!!");
$rowdept=mysql_fetch_array($resultdept);
$rptdeptname=$rowdept['unit_name'];
	

/*$rptsupcode=$row['grnm_shipment_num'];*/

//#################################################################################################################

$sqlpo="SELECT `user_add` FROM `purch_ord_mas` WHERE `pom_po_no`='$rptpono' and `pom_acct_yr`='$rptpoyr'";

$resultpo=mysql_query($sqlpo) or die("Mysql error2!!");
$rowpo=mysql_fetch_array($resultpo);

$rptuser=$rowpo['user_add'];

//#################################################################################################################

$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->BasicTable($rptsupcode,$rptdate,$rptsupname,$rptref,$rptadd1,$rptadd2,$rptlcno,$rptadd3,$rptadd4,$rptpoyr,$rptuser,$rptpono,$rptsupadd2,$rptloccode,$rptfol,$rptshipno);
//$pdf->BasicTable($rptsupcode,$rptsupname,$rptsupadd1,$rptsupadd2,$rptsupadd3,$rptloccode,$rptfol,$rptdate);
//$pdf->POTable($rptpono,$rptpoyr,$rptuser);	
$pdf->FacTable($rptfacname,$rptdeptname,$rptprogname);
$pdf->ItemTable($grnid,$grnyr,$rptpono,$rptpoyr,$rptgrtot,$rptfol,$rptfob,$rptfortot,$rptlkrtot,$rptbkchrg,$rptcur,$rptfrgt,$rptinsu,$rptother,$rptexcrate);
//$pdf->FooterTable();
$pdf->Output();
?>