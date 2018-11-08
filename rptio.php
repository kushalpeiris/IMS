<?php
require('pdfpath.php');

class PDF extends FPDF
{

function CheckPageBreak($h)

{       if($this->GetY()+$h>$this->PageBreakTrigger)    
   $this-> AddPage($this->CurOrientation);
}

function Footer()
{
   $this->SetX(10);
	$this->SetY(-20);
    $this->SetFont('Arial','I',8);
	$this->Cell(0,10,'Designed by - IMS UCSC',0,0,'C');
}

function Header(){
$this->Image('images/ucsclogo.png',10,10,23,23);
$this->SetY(7);
		$this->SetX(40);
		$this->SetFont('Arial','B',20);
		$this->Cell(0,10,'University of Colombo School of Computing',0,0,'C');
$this->SetY(13);
		$this->SetX(40);
		$this->SetFont('Arial','B',14);
		$this->Cell(0,10,'Goods Issue Note',0,0,'C');
$tio=$_GET['id1'];
$ty=(int)substr($tio,0,4);
$tn=(int)substr($tio,5,5);

$sql2="select * from issue_order_note_header  where ionh_doct_year='$ty' and ionh_doct_no='$tn'";
$result2=mysql_query($sql2) or die("Mysql error!!");
while ($row=mysql_fetch_array($result2)){
$tiodate=$row['ionh_date'];
$tprocode=$row['ionh_to_faculty'];
$tdeptcode=$row['ionh_to_department'];
$programcode=$row['ionh_to_programme'];
$tpodate=$row['podate'];
$tref=$row['ionh_reference'];
$tloc=$row['ionh_from_loc'];
}

$sql="select * from division_masterfile where div_code='$tprocode'";
$result=mysql_query($sql) or die("Mysql error1!");
while ($row=mysql_fetch_array($result))
$tproject=$row['div_name'];

$sql="select * from unit_masterfile where unit_code='$tdeptcode'";
$result=mysql_query($sql) or die("Mysql error2!");
while ($row=mysql_fetch_array($result))
$tdept=$row['unit_name'];

$this->SetFont('Arial','',10);

$this->SetY(7);
		$this->SetX(180);
        $this->SetY(36);
		$this->SetX(10);
		$this->Cell(0,5,$tlocation);


$this->SetY(36);
$this->SetX(15);
$this->Cell(0,5,substr("Department/Unit : ".$tproject,0,50));
$this->SetY(36);
$this->SetX(150);
$this->Cell(0,5,substr("GIN no : ".$tio,0,50));

$this->SetY(42);
$this->SetX(15);
$this->Cell(0,5,substr("Requisition no. : __________________",0,50));
$this->SetY(42);
$this->SetX(150);
$this->Cell(0,5,substr("Date :     ".$tiodate,0,50));

$sql="select * from issue_order_note_detail where ionh_doct_year='$ty' and ionh_doct_no=$tn";
$result=mysql_query($sql) or die("Mysql error4!");
while ($row=mysql_fetch_array($result))
$ticd=$row['iond_item_code'];
					
		$sql1="select * from item_masterfile where item_code='$ticd' ";

$result1=mysql_query($sql1) or die("Mysql error");

while ($row=mysql_fetch_array($result1))
        $titype=$row['item_type_code']  ;

$this->SetY(36);
$this->SetX(171);
$this->Cell(0,5,substr($tdept,0,25));

$this->SetY(40);
$this->SetX(171);
$this->Cell(0,5,substr($tprogramme,0,25));

$this->SetFont('Arial','B',10);
$this->SetY(52);
$this->SetX(5);
$this->Cell(0,5,substr("Item Code",0,10));
$this->SetY(52);
$this->SetX(28);
$this->Cell(0,5,substr("Item Description",0,20));
$this->SetY(52);
$this->SetX(110);
$this->Cell(0,5,substr("Qty.",0,20));
$this->SetY(52);
$this->SetX(147);
$this->Cell(0,5,substr("Unit Price",0,20));
$this->SetY(52);
$this->SetX(180);
$this->Cell(0,5,substr("Value",0,20));
}

}
/////////

require('getconnection.php');
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->SetFont('Arial','',10);
$gtot=0;
$tot=0;
$y=60;
$tio=$_GET['id1'];

$ty=(int)substr($tio,0,4);
$tn=(int)substr($tio,5,5);

$sql="select * from issue_order_note_detail where ionh_doct_year='$ty' and ionh_doct_no=$tn";
$result=mysql_query($sql) or die("Mysql error5!");
$tno=mysql_num_rows($result);
$tcount=0;

while ($row=mysql_fetch_array($result))
{

$tcount +=1;
$tqty=$row['qty'];
$tuprice=$row['unit_price'];
$tval=$tqty * $tuprice;
$tot=$tot+$tval;
$gtot=$gtot+$tval;
	
		$ticd=$row['iond_item_code'];
					
		$sql1="select * from item_masterfile where item_code='$ticd' ";

$result1=mysql_query($sql1) or die("Mysql error");

while ($row=mysql_fetch_array($result1))
	   $titemdes=$row['item_description']  ;

		
		$pdf->SetY($y); 
		$pdf->SetX(5);	
		$pdf->multiCell(0,5,$ticd,'',L);
				
		$pdf->SetY($y);
		$pdf->SetX(28);
		
		$pdf->multiCell(0,5,$titemdes,'','L');

		$pdf->SetY($y);
		$pdf->SetX(90);
		
		$pdf->multiCell(30,5,number_format($tqty,2),'','R');
	
	$pdf->SetY($y);
		$pdf->SetX(130);
	$pdf->multiCell(30,5,number_format($tuprice,2),'','R');
	
	$pdf->SetY($y);
		$pdf->SetX(162);
	$pdf->multiCell(30,5,number_format($tval,2),'','R');
	
	
	$y=$y+10;

$pflg=0;
if($y>200)
{
$pflg=1;
$pdf->SetFont('Arial','B',10);
$pdf->SetY(215);
$pdf->SetX(162);
$pdf->multiCell(30,5,"Total".number_format($tot,2),'','R');


$tot=0;
	
//$y=60;
if ($tcount<$tno)
$pdf->CheckPageBreak($y);


$y=60;
}
}

if ($pflg==0)
{$pdf->SetY(215);
$pdf->SetX(132);
$pdf->SetFont('Arial','BU',10);
$pdf->multiCell(60,5,"Total value(Rs.)  ".number_format($tot,2),'','R');
}


if ($pdf->pageno()<> 1)
{
$pdf->SetY(230);
$pdf->SetX(70);
$pdf->multiCell(30,5,'Grand Total','','R');
$pdf->SetY(230);
$pdf->SetX(162);
$pdf->multiCell(30,5,number_format($gtot,2),'','R');
}
///

$pdf->Output();

?>