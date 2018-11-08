
<?php

require('pdfpath.php');

class PDF extends FPDF

{

function CheckPageBreak($h)

{       if($this->GetY()+$h>$this->PageBreakTrigger)    
   $this-> AddPage($this->CurOrientation);

}


///////

function Footer()
{

$this->SetY(-18);
		$this->SetX(20);
		$this->Cell(0,5,'____________________________________________________________________________________________________________________________________');


   $this->SetX(10);
	$this->SetY(-15);
    
    $this->SetFont('Arial','I',8);
    // Page number
    
$this->Cell(0,10,'IMS UCSC -  All Rights Reserved ',0,0,'C');

}

////////


function Header()
{

$rtfaccode=$_GET['id1'];
$rtdeptcode=$_GET['id2'];
$rtprogcode=$_GET['id3'];
$rtitype=$_GET['id4'];
$rfdate=$_GET['id5'];
$rtdate=$_GET['id6'];

//////

$sql="select * from division_masterfile where div_code='$rtfaccode'";
	$result=mysql_query($sql) or die("Mysql errorq");

	while ($row=mysql_fetch_array($result))

	$tfac=$row['div_name']  ;

	$sql="select * from unit_masterfile where unit_code='$rtdeptcode'";
	$result=mysql_query($sql) or die("Mysql error");

	while ($row=mysql_fetch_array($result))
	$tdept=$row['unit_name'] ;

$this->SetFont('Arial','',8);

///
$this->SetY(10);
		$this->SetX(120);
		$this->Cell(0,5,"University of Colombo School of Computing");

$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

$this->SetFont('Arial','B',12);
$this->SetY(18);
		$this->SetX(115);

if ($rtitype=='')
$this->Cell(0,5,"Listing of Purchase Orders  - All Items");
else
		$this->Cell(0,5,"Listing of Purchase Orders  - ".$rtitype);

$this->SetFont('Arial','',10);
$this->SetY(23);
		$this->SetX(115);
		$this->Cell(0,5,"From :");
		
$this->SetY(23);
		$this->SetX(127);
		$this->Cell(0,5,$rfdate);

$this->SetY(23);
		$this->SetX(150);
		$this->Cell(0,5,"To :");
		
$this->SetY(23);
		$this->SetX(161);
		$this->Cell(0,5,$rtdate);


$this->SetY(30);
		$this->SetX(20);
		$this->Cell(0,5,'Division :');

$this->SetY(30);
		$this->SetX(35);
		$this->Cell(0,5,$tfac);


if ($rtdeptcode <> '')
{
$this->SetY(30);
		$this->SetX(110);
		$this->Cell(0,5,'Unit:');

$this->SetY(30);
		$this->SetX(122);
		$this->Cell(0,5,$tdept);
}


 if ($rtprogcode<>'')
{
$this->SetY(30);
		$this->SetX(205);
		$this->Cell(0,5,'Program :');

$this->SetY(30);
		$this->SetX(225);
		$this->Cell(0,5,$tprog);
}


$this->SetY(40);
		$this->SetX(20);
		$this->Cell(0,5,'PO #');
		
$this->SetY(40);
		$this->SetX(56);
		$this->Cell(0,5,'PO Date');

$this->SetY(40);
		$this->SetX(76);
		$this->Cell(0,5,'Item Code');

$this->SetY(40);
		$this->SetX(108);
		$this->Cell(0,5,'Description');


$this->SetY(40);
		$this->SetX(212);
		$this->Cell(0,5,'Qty');		

$this->SetY(40);
		$this->SetX(235);
		$this->Cell(0,5,'Unit Price');

$this->SetY(40);
		$this->SetX(270);
		$this->Cell(0,5,'Value');

$this->SetY(44);
		$this->SetX(20);
		$this->Cell(0,5,'____________________________________________________________________________________________________________________________________');


}
}

/////////

require('getconnection.php');

$pdf = new PDF('L');
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$gtot=0;
$tot=0;
//$y=90;

$rtfaccode=$_GET['id1'];
$rtdeptcode=$_GET['id2'];
$rtitype=$_GET['id4'];
$rfdate=$_GET['id5'];
$rtdate=$_GET['id6'];

/////////////
$y=53;
$gtot=0;

if ($rtitype<>"")
{
if ($rtdeptcode <>"")
{

$sql7="select * from purch_ord_mas where '$rfdate'<=pom_date and pom_date<='$rtdate' and sec_code='$rtdeptcode' and dep_code= '$rtfaccode' and item_type_code='$rtitype' and pom_cancel<>'Y' and (fund_avail='Y' or po_approved='Y') order by pom_acct_yr, pom_po_no ";
}


elseif ($rtfaccode <>"")
{

$sql7="select * from purch_ord_mas where '$rfdate'<=pom_date and pom_date<='$rtdate' and dep_code='$rtfaccode' and item_type_code='$rtitype' and pom_cancel<>'Y' and (fund_avail='Y' or po_approved='Y') order by pom_acct_yr, pom_po_no ";

}
}

////

if ($rtitype == "")
{
if ($rtdeptcode <>"")
{
$sql7="select * from purch_ord_mas where '$rfdate'<=pom_date and pom_date<='$rtdate' and dep_code='$rtfaccode' and sec_code='$rtdeptcode' and pom_cancel<>'Y' and (fund_avail='Y' or po_approved='Y') order by pom_acct_yr, pom_po_no ";
}


elseif ($rtfaccode <>"")
{
$sql7="select * from purch_ord_mas where '$rfdate'<=pom_date and pom_date<='$rtdate' and dep_code='$rtfaccode' and pom_cancel<>'Y' and (fund_avail='Y' or po_approved='Y') order by pom_acct_yr, pom_po_no ";

}

}

	$result7=mysql_query($sql7) or die("Mysql error!!");

	while ($row=mysql_fetch_array($result7))
{

$ty=$row['pom_acct_yr'];
$tu=$row['user_add'];
$tn=$row['pom_po_no'];
$texrate=$row['pom_exchrate']  ;
$freight=$row['freight']  ;
$insurance=$row['insurance']  ;
$fother=$row['for_other']  ;
$currency=$row['pom_currency'];
////
//if ($y>180)
if ($y>170)
{
$y=53;
$pdf->CheckPageBreak($y);
}

////

$tp=$ty.'/'.trim($tu).'/'.str_pad($tn,5,0,STR_PAD_LEFT);
$pdf->SetY($y); 
$pdf->SetX(20);
$pdf->multicell(0,5,$tp,'',L);

$pdf->SetY($y); 
$pdf->SetX(53);
$pdf->multicell(0,5,$row['pom_date'],'',L);


//////

$totval=0;
$sql8="select * from purch_ord_det where pod_po_no='$tn' and pod_acct_yr='$ty'";

	$result8=mysql_query($sql8) or die("Mysql errorbb");
 $trec=mysql_num_rows($result8);
	while ($row=mysql_fetch_array($result8))

	{
	$tit=$row['pod_item_code']  ;
	
	$tqt=$row['pod_qty']  ;
$tuprice=$row['pod_unit_price'];
$pnbt=$row['pod_nbt'];
$pvat=$row['pod_vat'];
$othertax=$row['pod_other'];
$nbt=0;
if ($pnbt>0)
$nbt=$tuprice * $pnbt/100;
$totforvat=$tuprice + $nbt ;
$vat=0;
if ($pvat>0)
$vat= ($totforvat * $pvat/100) ;

$up= ($tuprice + $nbt + $vat + $othertax) ;

$tval=$row['pod_amount'] ;

//
$sql4="select * from item_masterfile where item_code='$tit'";
$result4=mysql_query($sql4) or die("Mysql error!5");

while ($row=mysql_fetch_array($result4))
$titemdes=$row['item_description'];

//if ($y>180)
if ($y>170)
{
$y=55;
$pdf->CheckPageBreak($y);
}

$pdf->SetY($y); 
$pdf->SetX(75);
$pdf->multicell(0,5,$tit);


$pdf->SetY($y); 
$pdf->SetX(96);
$pdf->multicell(0,5,$titemdes,'',L);


$pdf->SetY($y); 
$pdf->SetX(190);
$pdf->multiCell(30,5,number_format($tqt,2),'','R');

$pdf->SetY($y); 
$pdf->SetX(220);
$pdf->multiCell(30,5,number_format($up,2),'','R');


$pdf->SetY($y); 
$pdf->SetX(250);

if ($trec==1)
{
$pdf->SetFont('Arial','B',10);

}

$pdf->multiCell(30,5,number_format($tval,2),'','R');
$pdf->SetFont('Arial','',10);

$totval=$totval+$tval ;

$gtot=$gtot + $tval ;

/* if ($trec==1 and $currency<>'Rs.' )
{
$y +=7;
$pdf->SetY($y); 
$pdf->SetX(75);
$pdf->multicell(0,5,'Total Freight, Insurance, other','',L);

$pdf->SetY($y); 
$pdf->SetX(250);
$tfio=($freight * $texrate)  + ($insurance * $texrate) + ($fother * $texrate);
$pdf->multicell(30,5,number_format($tfio,2),'',R);
$totval=$totval + $tfio   ;
$gtot=$gtot + $tfio  ;
} */
$y +=7;

}





if ($trec>1)
{

if ($currency<>'Rs.')
{
/* 
$pdf->SetY($y); 
$pdf->SetX(75);
$pdf->multicell(0,5,'Total Freight, Insurance, other','',L);

$pdf->SetY($y); 
$pdf->SetX(250);
$tfio=($freight * $texrate)  + ($insurance * $texrate) + ($fother * $texrate);
$pdf->multicell(30,5,number_format($tfio,2),'',R);
$totval=$totval + ($freight * $texrate)  + ($insurance * $texrate) + ($fother * $texrate)    ;
$gtot=$gtot + $tfio   ;
$y +=7; */
}



$pdf->SetFont('Arial','B',10);
//$totval=$totval + ($freight * $texrate)  + ($insurance * $texrate) + ($fother * $texrate)    ;
//$gtot=$gtot + ($freight * $texrate)  + ($insurance * $texrate) + ($fother * $texrate)    ;
$pdf->SetY($y); 
$pdf->SetX(250);
$pdf->multiCell(30,5,number_format($totval,2),'','R');
$pdf->SetFont('Arial','',10);

/////

$y +=7;
}
}

///////
$y+=3;
$pdf->SetFont('Arial','B',10);
$pdf->SetY($y); 
$pdf->SetX(200);

$pdf->multiCell(30,5,'Total');

$pdf->SetY($y); 
$pdf->SetX(250);

$pdf->multiCell(30,5,number_format($gtot,2),'','R');

$y+=5;
$pdf->SetY($y); 
$pdf->SetX(200);

$pdf->multiCell(0,5,'======================================');


////////////

$pdf->Output();

?>