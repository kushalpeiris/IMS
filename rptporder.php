
<?php
require('pdfpath.php');
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
class PDF extends FPDF

{
/////

function NbLines($w,$txt) 
{ 
$cw=&$this->CurrentFont['cw']; 
if($w==0) 
$w=$this->w-$this->rMargin-$this->x; 
$wmax=($w-2*$this->cMargin)*1000/$this->FontSize; 
$s=str_replace("\r",'',$txt); 
$nb=strlen($s); 
if($nb>0 and $s[$nb-1]=="\n") 
$nb--; 
$sep=-1; 
$i=0; 
$j=0; 
$l=0; 
$nl=1; 
while($i<$nb) 
{ 
$c=$s[$i]; 
if($c=="\n") 
{ 
$i++; 
$sep=-1; 
$j=$i; 
$l=0; 
$nl++; 
continue; 
} 
if($c==' ') 
$sep=$i; 
$l+=$cw[$c]; 
if($l>$wmax) 
{ 
if($sep==-1) 
{ 
if($i==$j) 
$i++; 
} 
else 
$i=$sep+1; 
$sep=-1; 
$j=$i; 
$l=0; 
$nl++; 
} 
else 
$i++; 
} 
return $nl; 
} 


///////
function CheckPageBreak($h)

{       if($this->GetY()+$h>$this->PageBreakTrigger)    
   $this-> AddPage($this->CurOrientation);

}

///
function Footer()
{
  ///

   $this->SetY(270);

		$this->SetX(190);
////$this->Cell(0,5,$this->PageNo());
$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
 
   $this->SetX(10);
	$this->SetY(-10);
    
    $this->SetFont('Arial','I',8);
        
$this->Cell(0,10,'IMS UCSC -  All Rights Reserved ',0,0,'C');

}

///////

function Header()
{
$this->Image('images/ucsclogo.png',140,10,35,35);
$tn=$_GET['id1'];
$ty=$_GET['id2'];
$tu=$_GET['id3'];
$tm=$_GET['id4'];
$tsy=$_GET['id5'];

$tp=$ty.'/'.trim($tu).'/'.str_pad($tn,5,0,STR_PAD_LEFT);

$sql5="select * from purch_ord_mas where pom_po_no='$tn' and pom_acct_yr='$ty'";
$result5=mysql_query($sql5) or die("Mysql error");
while ($row=mysql_fetch_array($result5))
{$tsupcode=$row['pom_sup_code'];
$tprocode=$row['dep_code'];
$tdeptcode=$row['sec_code'];
$tprogramcode=$row['prog_code'];
$tpodate=$row['pom_date'];
$fndcode=$row['fund_code'];
$titemtype=$row['item_type_code'];$_SESSION['currency']=$row['pom_currency'];
$uniref = $row['pom_uni_reference'];
$reference = $row['pom_reference'];
$duedate = $row['pom_due_date'];
$ref = $row['pom_reference'];

}

$sql="select * from supplier where supplier_code='$tsupcode' and sup_year='$tsy'";
$result=mysql_query($sql) or die("Mysql error!");
//echo $sql;
while ($row=mysql_fetch_array($result))
{$tsname=$row['supplier_name'];
$taddress1=$row['supplier_address1'];
$taddress2=$row['supplier_address2'];
$taddress3=$row['supplier_address3'];
$taddress4=$row['sup_address4'];
$ttel=$row['supplier_phone'];
$tfax=$row['supplier_fax'];
}


$sql="select * from division_masterfile where div_code='$tprocode'";
$result=mysql_query($sql) or die("Mysql error!!");

while ($row=mysql_fetch_array($result))
$tproject=$row['div_name'];

$sql="select * from unit_masterfile where unit_code='$tdeptcode'";
$result=mysql_query($sql) or die("Mysql error!!!");

while ($row=mysql_fetch_array($result))
$tdept=$row['unit_name'];

////


$this->SetFont('Arial','',10);

$y=13;

$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,"Purchase order No. : UCSC/P/ORD/");


$this->SetY($y);
		$this->SetX(80);
$this->Cell(0,5,$tn);

$y=$y+10;

$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,$tsname);

$y=$y+5;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,$taddress1);

$y=$y+5;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,$taddress2);

$y=$y+5;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,$taddress3);

$y=$y+5;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,$taddress4);
$y=$y+4;
$this->SetY($y);
		$this->SetX(165);
		$this->Cell(0,5,"Ref.No :");


$this->SetY($y);
		$this->SetX(180);
		$this->Cell(0,5,$ref);
		
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,$ttel);

$this->SetY($y);
		$this->SetX(50);
		$this->Cell(0,5,"fax :");


$this->SetY($y);
		$this->SetX(57);
		$this->Cell(0,5,$tfax);
$y=$y+10;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,"Dear Sir / Madam,");
$y=$y+5;
$this->SetFont('Arial','B',10);
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,"Purchase order for supply & delivery of goods to $tproject,");
$y=$y+5;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,"$tdept ");
$this->SetFont('Arial','',10);
$y=$y+8;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,"We are pleased to inform you that University of Colombo School of Computing has accepted your quotation");
$y=$y+4;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,"(Ref :$reference) and decided to purchase the below mentioned products from you.");
$y=$y+4;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,"We would be thankful if you could deliver the goods to $tproject before due date.");
$this->SetFont('Arial','B',10);		
$y=$y+10;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,"S No.");

$this->SetY($y);
		$this->SetX(55);
		$this->Cell(0,5,"Item");
		
$this->SetY($y);
		$this->SetX(120);
		$this->Cell(0,5,"Quantity(Nos.)");	
		

$this->SetY($y);
		$this->SetX(148);
		$this->Cell(0,5,"U.Price (Rs)");

//$this->SetY($y);
//		$this->SetX(147);
//		$this->Cell(0,5,$tdeptcode);

$this->SetY($y);
	//	$this->SetX(170);
	$this->SetX(175);
		$this->Cell(0,5,"Total (Rs)");
$y=$y+5;
$this->SetY($y);
		$this->SetX(155);
		$this->Cell(0,5,substr($tprogram,0,20));
/*********references
$y=$y+5;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,"University Ref.:".$uniref);
$y=$y+4;
$this->SetY($y);
		$this->SetX(23);
		$this->Cell(0,5,"Your Ref.:".$reference);
		
**/
$this->SetFont('Arial','',10);
/* $y=$y+17;
$this->SetY($y);
		$this->SetX(102);
		$this->Cell(0,5,$tdept); */
		
/* $y=$y+4;		
$this->SetY($y);
		$this->SetX(102);
		if ($duedate!='0000-00-00'){
		$this->Cell(0,5,"Due date:".$duedate);
		}
		else{
		$this->Cell(0,5,"Due date:not applicable");	
		} */
}
}

/////////

require('getconnection.php');
//require('getcon.php');
//$pdf = new PDF();
//$pdf = new PDF('P','mm',array(220,280));
$pdf = new PDF('P','mm','Letter');
$pdf->AliasNbPages();


$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$gtot=0;
$tot=0;
$totnovat=0;
$y=100;

$tn=$_GET['id1'];
$ty=$_GET['id2'];
$tm=$_GET['id4'];


//////

$sql1="select * from purch_ord_mas where pom_po_no='$tn' and pom_acct_yr='$ty'";
$result1=mysql_query($sql1) or die("Mysql error");

while ($row=mysql_fetch_array($result1))
{
$currency=$row['pom_currency'];
$freight=$row['freight'];
$insurance=$row['insurance'];
$fother=$row['for_other'];
}
///////
$sql="select * from purch_ord_det where pod_po_no='$tn' and pod_acct_yr='$ty' and 	pod_po_mark ='$tm'";
$result=mysql_query($sql) or die("Mysql error!4");
$tno=mysql_num_rows($result);
$tcount=0;

while ($row=mysql_fetch_array($result))
{

$tcount +=1;
$tot=$tot+$row['pod_amount'];
$gtot=$gtot+$row['pod_amount'];
$icode=$row['pod_item_code'] ;
$tdes=$row['pod_des'];
$tqty=$row['pod_qty'];
$tuprice=$row['pod_unit_price'];
$warr=$row['pod_warranty'];
$vat=$row['pod_vat'];
$nbt=$row['pod_nbt'];
$tvalue=$row['pod_amount'];
$tpnovat=$tuprice*$tqty;
$totnovat=$totnovat+$tpnovat;
$tup1=$tvalue/$tqty ;
$tup=round($tup1,2);

		$pdf->SetY($y); 
		$pdf->SetX(23);
		
		$pdf->multicell(0,5,$icode,'',L);
		
		$pdf->SetY($y);
		$pdf->SetX(43);

/////

$sql1="select * from item_masterfile where item_code='$icode'";
$result1=mysql_query($sql1) or die("Mysql error!5");

while ($row=mysql_fetch_array($result1))
$titemdes=$row['item_description'];
	
if($warr>0){
		$totdes=$titemdes."\n".$tdes."-".$warr." yrs warranty";
}
else{
		$totdes=$titemdes."\n".$tdes;
}
////		$pdf->MultiCell(0,5,$totdes,'','L');
$pdf->MultiCell(90,5,$totdes,'','L');
		$nl=$pdf->NbLines(90,$tdes);
		$pdf->SetY($y);
		$pdf->SetY($y);
		$pdf->SetX(105);
	$pdf->multiCell(30,5,number_format($tqty,2),'','R');
	
	if ($currency<>'Rs.')
	{
	$pdf->SetY($y);
		$pdf->SetX(135);
		$pdf->multiCell(30,5,$currency,'','R');
	}	
	
	$pdf->SetY($y);
		$pdf->SetX(131);
		$pdf->multiCell(30,5,number_format($tuprice,2),'','R');
	
	////
	
if ($currency <>'Rs.')
	{
	$pdf->SetY($y);
		$pdf->SetX(159);
		$pdf->multiCell(30,5,$currency,'','R');
	}		
		
//tax brkdwn*****************
	/* $pdf->SetY($y);
			$pdf->SetX(160);
			$pdf->multiCell(30,5,number_format((($tup*$vat)+($tup*$nbt)),2),'','R'); */
/****************************/

	$pdf->SetY($y);
		$pdf->SetX(160);
		$pdf->multiCell(30,5,number_format(($tuprice*$tqty),2),'','R');
	
/*****************************************Line break of a row of the table	*******************************************/
	$y=$y+(10*$nl/2)+10;

$pflg=0;


if($y>200)
{
$pflg=1;

if ($currency=='Rs.')
	{
	//$pdf->SetY(222);
	//	$pdf->SetX(144);
	//	$pdf->multiCell(30,5,$currency,'','R');
	//}
////
$pdf->SetY(247);
$pdf->SetX(175);
$pdf->multiCell(30,5,number_format($tot,2),'','R');

$tot=0;
	
//$y=120;
//$y=83;
}
$y=113;
if ($tcount<$tno)
$pdf->CheckPageBreak($y);


}

}


if ($pflg==0)
{

if ($currency<>'Rs.')
	{
	$pdf->SetY($y);
		$pdf->SetX(73);
		$pdf->multiCell(100,5,'Total Amount without VAT(Rs)','','L');
	$pdf->SetY($y);
		$pdf->SetX(177);
		$pdf->multiCell(100,5,number_format($totnovat,2),'','L');
	$y=$y+5;
	$pdf->SetY($y);
		$pdf->SetX(73);
		$pdf->multiCell(100,5,'11% V A T(Rs)','','L');
	$pdf->SetY($y);
		$pdf->SetX(177);
		$pdf->multiCell(100,5,number_format(($totnovat*0.11),2),'','L');
	$y=$y+5;
	$pdf->SetY($y);
		$pdf->SetX(73);
		$pdf->multiCell(100,5,'Grand Total with VAT (Rs)','','L');
	$pdf->SetY($y);
		$pdf->SetX(177);
		$pdf->multiCell(100,5,number_format(($totnovat*1.11),2),'','L');
	$y=$y+5;
	$pdf->SetY($y);
		$pdf->SetX(117);
		$pdf->multiCell(100,5,'____________________________________________','','L');
	
	$y=$y+8;
	$ftot=$tot + $freight + $insurance + $fother ;	
	///
	$pdf->SetY($y);
		$pdf->SetX(23);
		$pdf->multiCell(50,5,'Terms & Conditions','','L');
	$y=$y+5;
	$pdf->SetY($y);
		$pdf->SetX(30);
		$pdf->multiCell(250,5,'I. Items should be according to the Specification and Quotation No. ####, in good condition.','','L');
		$y=$y+5;
	$pdf->SetY($y);
		$pdf->SetX(30);
		$pdf->multiCell(250,5,'II. Should be delivered within "lead time" and payment within "considerable time" from the delivery date.','','L');
		$y=$y+5;
	$pdf->SetY($y);
		$pdf->SetX(30);
		$pdf->multiCell(250,5,'III. Delivery Point : "ordered person and address, within what time frame"','','L');
		$y=$y+5;
	$pdf->SetY($y);
		$pdf->SetX(23);
		$pdf->multiCell(250,5,'Thanking You','','L');
		$y=$y+10;
	$pdf->SetY($y);
		$pdf->SetX(23);
		$pdf->multiCell(250,5,'Senor Assistant Bursar ','','L');
		$y=$y+5;
	$pdf->SetY($y);
		$pdf->SetX(23);
		$pdf->multiCell(250,5,'cc: Store Keeper','','L');
		$y=$y+5;
	$pdf->SetY($y);
		$pdf->SetX(23);
		$pdf->multiCell(250,5,'Purchase Order File ','','L');
		$y=$y+5;
	$pdf->SetY($y);
		$pdf->SetX(23);
		$pdf->multiCell(250,5,'Reference File','','L');
	///
	$pdf->SetY($y);
		$pdf->SetX(159);
		$pdf->multiCell(30,5,$currency,'','R');
	
	$pdf->SetY($y);

/* $pdf->SetX(175);
$pdf->multiCell(30,5,number_format($tot,2),'','R');
	
		
$pdf->SetY(247);
$pdf->SetX(175);
$pdf->multiCell(30,5,number_format($ftot,2),'','R'); */
	///
	
	}

////
else
{
$pdf->SetY(247);

$pdf->SetX(175);
$pdf->multiCell(30,5,number_format($tot,2),'','R');
}
}



if ($pdf->pageno()<> 1 and $currency=='Rs.')
{
$pdf->SetY(252);
$pdf->SetX(85);
$pdf->multiCell(30,5,'Grand Total','','R');
if ($currency<>'Rs.')
	{
	$pdf->SetY(255);
		$pdf->SetX(159);
		$pdf->multiCell(30,5,$currency,'','R');
	}


$pdf->SetY(252);
$pdf->SetX(175);
$pdf->multiCell(30,5,number_format($gtot,2),'','R');
}
///


$pdf->Output();

?>