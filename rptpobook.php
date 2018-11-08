
<?php

require('pdfpath.php');

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

//////
function Footer()
{
   $this->SetX(10);
	$this->SetY(-15);
    
    $this->SetFont('Arial','I',8);
    // Page number
    
$this->Cell(0,10,'IMS UCSC ',0,0,'C');


}
///////

function Header()
{
$rfdate=$_GET['id1'];
$rtdate=$_GET['id2'];


$this->SetFont('Arial','',8);

///
$this->SetY(10);
		$this->SetX(120);
		$this->Cell(0,5,"University of Colombo School of Computing");


//$this->Cell(0,5,$this->PageNo());
$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');



$this->SetFont('Arial','B',12);
$this->SetY(20);
		$this->SetX(120);
		$this->Cell(0,5,"Purchase Order Book");

$this->SetFont('Arial','',10);
$this->SetY(30);
		$this->SetX(110);
		$this->Cell(0,5,"From :");
		
$this->SetY(30);
		$this->SetX(122);
		$this->Cell(0,5,$rfdate);

$this->SetY(30);
		$this->SetX(145);
		$this->Cell(0,5,"To :");
		
$this->SetY(30);
		$this->SetX(156);
		$this->Cell(0,5,$rtdate);

$this->SetY(40);
		$this->SetX(20);
		$this->Cell(0,5,'PO #');
		
$this->SetY(40);
		$this->SetX(52);
		$this->Cell(0,5,'PO Date');

$this->SetY(40);
		$this->SetX(80);
		$this->Cell(0,5,'Supplier');
		
$this->SetY(40);
		$this->SetX(180);
		$this->Cell(0,5,'Division');

$this->SetY(40);
		$this->SetX(237);
		$this->Cell(0,5,'Unit');

$this->SetY(45);
		$this->SetX(25);
		$this->Cell(0,5,'Item Description');

$this->SetY(45);
		$this->SetX(142);
		$this->Cell(0,5,'Qty');		

$this->SetY(45);
		$this->SetX(155);
		$this->Cell(0,5,'Unit Price');

$this->SetY(45);
		$this->SetX(179);
		$this->Cell(0,5,'Sub Total');
		
$this->SetY(45);
		$this->SetX(197);
		$this->Cell(0,5,'Total Amount');
		
$this->SetY(45);
		$this->SetX(220);
		$this->Cell(0,5,'Auth. By');
		
$this->SetY(45);
		$this->SetX(236);
		$this->Cell(0,5,'GRN Date');

$this->SetY(45);
		$this->SetX(255);
		$this->Cell(0,5,'GRN #');

$this->SetY(45);
		$this->SetX(269);
		$this->Cell(0,5,'Auth. By');

$this->SetY(49);
		$this->SetX(25);
		$this->Cell(0,5,'fund');



$this->SetY(50);
		$this->SetX(20);
		$this->Cell(0,5,'_____________________________________________________________________________________________________________________________________');

}
}

/////////

require('getconnection.php');
//require('getcon.php');
$pdf = new PDF('L');
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$gtot=0;
$tot=0;
$y=98;

$rfdate=$_GET['id1'];
$rtdate=$_GET['id2'];
/////
$fndcode='';
$ffaccode='';
$fdeptcode='';
$fprogramcode='';

/////////////
$y=60;
$sql7="select * from purch_ord_mas where '$rfdate'<=pom_date and pom_date<='$rtdate'";
	$result7=mysql_query($sql7) or die("Mysql error!");

	while ($row=mysql_fetch_array($result7))
{

$ty=$row['pom_acct_yr'];
$tn=$row['pom_po_no'];
$tu=$row['user_add'];
$tsupcode=$row['pom_sup_code'];
$tfacno=$row['dep_code']  ;
$tdeptno=$row['sec_code']  ;
$freight=$row['freight']  ;
$insurance=$row['insurance']  ;
$fother=$row['for_other']  ;
$currency=$row['pom_currency'];
$fndcode=$row['fund_code'];
$ffaccode=$row['fund_fac'];
$fdeptcode=$row['fund_dept'];
$fprogramcode=$row['fund_prog'];
////
//if ($y>180)
if ($y>170)
{
$y=60;
$pdf->CheckPageBreak($y);
}

////

$tp=$ty.'/'.trim($tu).'/'.str_pad($tn,5,0,STR_PAD_LEFT);
$pdf->SetY($y); 
$pdf->SetX(20);
$pdf->multicell(0,5,$tp,'',L);

$pdf->SetY($y); 
$pdf->SetX(50);
$pdf->multicell(0,5,$row['pom_date'],'',L);

$sql1="select * from supplier where supplier_code='$tsupcode' and sup_year='$ty'";
$result1=mysql_query($sql1) or die("Mysql error11");

while ($row=mysql_fetch_array($result1))
$tsupname=$row['supplier_name'];

$pdf->SetY($y); 
$pdf->SetX(77);
$pdf->multicell(0,5,$tsupname,'',L);



$sql="select * from division_masterfile where div_code='$tfacno'";
	$result=mysql_query($sql) or die("Mysql errorq");

	while ($row=mysql_fetch_array($result))

	$tfacname=$row['div_name']  ;

$pdf->SetY($y); 
$pdf->SetX(180);
$pdf->multicell(0,5,substr($tfacname,0,32),'',L);


	$sql="select * from unit_masterfile where unit_code='$tdeptno'";
	$result=mysql_query($sql) or die("Mysql error");

	while ($row=mysql_fetch_array($result))

	$tdeptname=$row['unit_name'];


$pdf->SetY($y); 
//$pdf->SetX(230);
$pdf->SetX(238);
//$pdf->multicell(0,5,$tdeptname,'',L);
$pdf->multicell(0,5,substr($tdeptname,0,28),'',L);

//////

$totval=0;
$sql8="select * from purch_ord_det where pod_po_no='$tn' and pod_acct_yr='$ty'";

	$result8=mysql_query($sql8) or die("Mysql errorbb");


	while ($row=mysql_fetch_array($result8))

	{
	$tit=$row['pod_item_code']  ;
	
	$tqt=$row['pod_qty']  ;
$tuprice=$row['pod_unit_price'];
$pnbt=$row['pod_nbt'];
$pvat=$row['pod_vat'];
$othertax=$row['pod_other'];
$totforvat=$tuprice ;
$vat= ($totforvat * $pvat/100) ;
$up= $tuprice + $vat   ;

$tval=$row['pod_amount']  ;

//
$sql4="select * from item_masterfile where item_code='$tit'";
$result4=mysql_query($sql4) or die("Mysql error!5");

while ($row=mysql_fetch_array($result4))
$titemdes=$row['item_description'];

$y=$y+5;

//if ($y>180)
if ($y>170)
{
$y=60;
$pdf->CheckPageBreak($y);
}



$pdf->SetY($y); 
$pdf->SetX(25);
$pdf->multicell(0,5,$titemdes,'',L);


$pdf->SetY($y); 
$pdf->SetX(120);
$pdf->multiCell(30,5,number_format($tqt,2),'','R');

$pdf->SetY($y); 
$pdf->SetX(140);
$pdf->multiCell(30,5,number_format($up,2),'','R');


$pdf->SetY($y); 
$pdf->SetX(168);
$pdf->multiCell(30,5,number_format($tval,2),'','R');

$totval=$totval+$tval ;

//$y +=5;

}

///
if ($currency<>'Rs.' )
{
$y +=5;
$pdf->SetY($y); 
$pdf->SetX(25);
$pdf->multicell(0,5,'Total Freight, Insurance, other','',L);

$pdf->SetY($y); 
$pdf->SetX(168);
$tfio=($freight * $texrate)  + ($insurance * $texrate) + ($fother * $texrate);
$pdf->multicell(30,5,number_format($tfio,2),'',R);
$totval=$totval + $tfio    ;
}
///

$y +=5;

////////
$pdf->SetY($y); 
$pdf->SetX(25);
$pdf->multiCell(30,5,$fndcode,'',L);

///
$tffac='';
$sql="select * from division_masterfile where div_code='$ffaccode'";
	$result=mysql_query($sql) or die("Mysql errorq");

	while ($row=mysql_fetch_array($result))

	$tffac=$row['div_name']  ;

//
$tfdept='';
	$sql="select * from unit_masterfile where unit_code='$fdeptcode'";
	$result=mysql_query($sql) or die("Mysql error");

	while ($row=mysql_fetch_array($result))

	$tfdept=$row['unit_name'] ;


$funddept=trim($tffac).'  ' .trim($tfdept).'  '.trim($tfprog);
/////

$pdf->SetY($y); 
$pdf->SetX(40);
$pdf->multiCell(100,5,$funddept,'',L);


////////

$pdf->SetFont('Arial','B',10);

$pdf->SetY($y); 
$pdf->SetX(187);
$pdf->multiCell(30,5,number_format($totval,2),'','R');
$pdf->SetFont('Arial','',10);

$pdf->SetY($y); 
$pdf->SetX(20);
$pdf->multiCell(0,5,'______________________________________________________________________________________________________________________________________');

/////
$y +=10;
}

////////////

$pdf->Output();

?>