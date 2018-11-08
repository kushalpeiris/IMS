
<?php
require('db.inc.php');
require('pdfpath.php');
//require('rptfooter.php');
class PDF extends PDF_MC_Table
{


//******************Page Header************

function Header()
{
	global $title;
	//logo
	$this->SetLeftMargin(20);
	$this-> Image('images/ucsclogo.png',20,6,25,25);
	// Arial bold 15
    $this->SetFont('Arial','BU',18);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(80,10,$title,0,0,'C');
    // Line break
    $this->Ln(25);
}


}
//Instanciation of inherited class
//*********************************************************************************************************************************
require('db.inc.php');

$pdf = new PDF('L');
//$pdf = new PDF_MC_Table('L');
$scatcode = $_REQUEST['lstSupCat'];
$tyear=$_REQUEST['lstSupYear'];
$title="University of Colombo School of Computing - Suppliers $tyear";
$pdf->SetTitle($title);
$sql="SELECT `sup_cat_code`,`sup_cat_name` FROM `supplier_category`";
$result = mysql_query($sql) or die(mysql_error());
	//$pdf->SetWidths(array(10,10,56,52,29,20,20,18,20,39));
	$pdf->SetWidths(array(6,15,77,78,42,25));
		//$header = array('','Sup_No', 'Sup_Name', 'Address_1','Address_2','Phone_1','Phone_2','Phone_3','Fax','E_Mail');
			$header = array('','Sup_No', 'Supplier', 'Address 1','Address 2','Tel');
    

while($row=mysql_fetch_assoc($result))
{
	
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(35,10,"$row[sup_cat_code] - $row[sup_cat_name]");
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	//$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C'));
	$pdf->SetAligns(array('C','C','C','C','C','C'));
	$pdf->Row($header);
	$pdf->SetAligns(array('C','C','L','L','L','L'));
	//$pdf->SetAligns(array('C','C','L','L','L','L','L','L','L','L'));
	$tyear = $_REQUEST['lstSupYear'];
	$sql1="SELECT  `supplier_code`,`supplier_name`,`supplier_address1`,`supplier_address2`,`supplier_phone`,`supplier_fax`,`supplier_phone2`,`supplier_email`,`sup_refno`,`sup_cat_code` FROM `supplier` WHERE `sup_cat_code` = $row[sup_cat_code] and sup_year='$tyear' and `registered_status`='RES' order by `supplier_name` asc";
	//echo $sql1;
	$result1 = mysql_query($sql1) or die(mysql_error());
	//$pdf->PrintChapter($supcatcode,$row['sup_cat_name'],);
	$pdf->SetFont('Arial','',8);
	/*$html="<table border=\"1\">";*/
    $count=1;
	while($row1=mysql_fetch_array($result1))
	{
		$stel = explode('/',$row1['supplier_phone2']);
		//$sfax = explode('/',$row['supplier_fax']);
      	$data=array($count,
		$row1['supplier_code'],
		$row1['supplier_name'],
		$row1['supplier_address1'],
		$row1['supplier_address2'],
		$row1['supplier_phone'],
		);

	$count +=1;
    $pdf->Row($data);
	if (($count % 20) =='0')
	{
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,10,"$row[sup_cat_code] - $row[sup_cat_name]");
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		//$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C'));
		$pdf->SetAligns(array('C','C','C','C','C','C'));
		$pdf->Row($header);
		//$pdf->SetAligns(array('C','C','L','L','L','L','L','L','L','L'));
		$pdf->SetAligns(array('C','C','L','L','L','L'));
		$pdf->SetFont('Arial','',8);
	}
	}
	
//$pdf->Output();

	
}



$pdf->AliasNbPages();
$pdf->Output();
	
//}
?>


