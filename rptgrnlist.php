<?php
require('db.inc.php');
require('pdfpath.php');
$type=$_REQUEST['rdbItemType'];
$typesec = $_REQUEST['rdbSecType'];
$factype=$_REQUEST['lstFac'];
$deptype=$_REQUEST['lstDep'];
$count=0;

class PDF extends PDF_MC_Table
{	
	function Header()
	{
	global $title;
	global $title2;
	$this->SetLeftMargin(20);
	$this-> Image('images/ucsclogo.png',20,6,25,25);
    $this->SetFont('Arial','BU',18);
	$this->Cell(38);
    $this->Cell(0,10,$title,0,0,'L');
	$this->Ln();
	$this->SetFont('Arial','B',14);
	$this->Cell(38);
	$this->Cell(0,11,$title2,0,0,'L');
    $this->Ln(16);
	$this->TopTable();
	$this->Line(20,41,280,41);
	$this->SetFont('Arial','B',9);	
	//$this->FacTable();
	}

	function TopTable()
	{
	$this->SetFont('Times','B',12);
	$this->Cell(40,5,'Purchase Order #',0,0,'L');
	$this->Cell(30,5,'Item Code',0,0,'L');
	$this->Cell(75,5,'Description',0,0,'L');
	$this->Cell(35,5,'Unit Price',0,0,'R');
	$this->Cell(45,5,'Received Quantity',0,0,'R');
	$this->Cell(35,5,'Value',0,0,'R');
	$this->Ln(6);
	}

	function FacTable()
	{
	$this->SetFont('Times','B',12);
	$this->Cell(40,5,'Faculty :',0,0,'L');
	$this->Cell(30,5,'',0,0,'L');
	$this->Cell(75,5,'',0,0,'L');
	$this->Cell(35,5,'Programme :',0,0,'L');
	$this->Cell(45,5,'',0,0,'L');
	$this->Cell(35,5,'',0,0,'L');
	$this->Ln();
	$this->SetFont('Times','B',12);
	$this->Cell(40,5,'Department :',0,0,'L');
	$this->Cell(30,5,'',0,0,'L');
	$this->Cell(75,5,'',0,0,'L');
	$this->Cell(35,5,'',0,0,'L');
	$this->Cell(45,5,'',0,0,'L');
	$this->Cell(35,5,'',0,0,'L');
	$this->Ln(6);
	}
}

//Instanciation of inherited class
//*********************************************************************************

$pdf = new PDF('L');
$gfrom = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
$gto= isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";

if($type == "1" && $typesec == "4")
$fac ="";
if($type == "2" && $typesec == "4")
$fac ="All Recurrent Items -";
if($type == "3" && $typesec == "4")
$fac ="All Capital Items -";
if($type == "1" && $typesec == "5")
$fac ="Faculty wise All Items -";
if($type == "1" && $typesec == "6")
$fac ="Department wise All Items -";
if($type == "2")
$fac ="Recurrent Item wise -";
if($type == "2" && $typesec == "5")
$fac ="Faculty wise Recurrent Items -";
if($type == "2" && $typesec == "6")
$fac ="Department wise Recurrent Items -";
if($type == "3")
$fac ="Capital Item wise -";
if($type == "3" && $typesec == "5")
$fac ="Faculty wise Capital Items -";
if($type == "3" && $typesec == "6")
$fac ="Department wise Capital Items -";

if($type == "1"){ $title="UCSC - Listing of GRNs ";}

if($type == "2"){ $title="UCSC - Listing of GRNs";}
if($type == "3"){ $title="UCSC - Listing of GRNs";}


$title2="$fac from : $gfrom to : $gto";
//echo $typesec;

$pdf->SetWidths(array(40,30,75,35,45,35));
$pdf->AddPage();
$tdep = "";
$tsec = "";
$tgrn = "";
$tpgrn = "";
$countsec =0;
$count=0;
if($type==2)
{
	$typeSql=" and `item_masterfile`.`item_type_code`!='CA' ";
}
elseif($type==3)
{
	$typeSql=" and `item_masterfile`.`item_type_code`='CA' ";
}
else
{
	$typeSql="";
}

if($typesec==5)
{
	$depsql=" AND `grn_detail`.dep_code=$factype";
}
elseif($typesec==6)
{
	$depsql=" AND `grn_detail`.sec_code=$deptype";
}
else
{
	$depsql="";
}
/* $sql="SELECT BASIC.grnm_date,BASIC.grnm_grand_tot,BASIC.grnd_acct_yr,BASIC.grnd_number,BASIC.dep_code,division_masterfile.dep_name,BASIC.sec_code,unit_masterfile.sec_name,BASIC.prog_code,payroll_programme_mfile.prog_name,BASIC.grnd_item_code,BASIC.tot_value,BASIC.grnd_qty_recd,BASIC.grnd_po_acct_yr,BASIC.grnmuser,BASIC.grnd_po_no,BASIC.item_description
 FROM 
(SELECT `grn_detail`.*,`item_masterfile`.*,`grn_master`.`grnm_date`,`grn_master`.`grnm_grand_tot`, `grn_master`.`user_add` as grnmuser
FROM `grn_detail`,`item_masterfile`,`grn_master` 
WHERE 
`item_masterfile`.`item_code`=`grn_detail`.`grnd_item_code` and `grn_master`.`grnm_number`=`grn_detail`.`grnd_number` and `grn_master`.`grnm_acct_yr` =`grn_detail`.`grnd_acct_yr` and  (`grnm_date` between  '$gfrom' and '$gto') $typeSql and `grn_detail`.grnd_qty_recd != 0 $depsql)
AS BASIC 
LEFT OUTER JOIN `division_masterfile` ON `division_masterfile`.`dep_code` = `BASIC`.`dep_code` 
LEFT OUTER JOIN `unit_masterfile` ON `unit_masterfile`.`sec_code`=`BASIC`.`sec_code` 
LEFT OUTER JOIN `payroll_programme_mfile` ON `payroll_programme_mfile`.`prog_code`=`BASIC`.`prog_code`
 
ORDER BY `BASIC`.`dep_code`,`BASIC`.`sec_code`,`BASIC`.grnd_number,`BASIC`.grnd_acct_yr"; */
$sql="SELECT BASIC.grnm_date,BASIC.grnm_grand_tot,BASIC.grnd_acct_yr,BASIC.grnd_number,BASIC.dep_code,division_masterfile.div_name,BASIC.sec_code,
unit_masterfile.unit_name,BASIC.grnd_item_code,BASIC.tot_value,
BASIC.grnd_qty_recd,BASIC.grnd_po_acct_yr,BASIC.grnmuser,BASIC.grnd_po_no,BASIC.item_description
 FROM
(SELECT `item_masterfile`.*,`grn_detail`.grnd_acct_yr,`grn_detail`.grnd_number,`grn_detail`.dep_code,`grn_detail`.sec_code,
`grn_detail`.prog_code,`grn_detail`.grnd_item_code,`grn_detail`.tot_value,`grn_detail`.grnd_qty_recd,`grn_detail`.grnd_po_acct_yr,`grn_detail`.grnd_po_no,
`grn_master`.`grnm_date`,`grn_master`.`grnm_grand_tot`, `grn_master`.`user_add` as grnmuser
FROM `grn_detail`,`item_masterfile`,`grn_master`
WHERE
`item_masterfile`.`item_code`=`grn_detail`.`grnd_item_code` and `grn_master`.`grnm_number`=`grn_detail`.`grnd_number` and
`grn_master`.`grnm_acct_yr` =`grn_detail`.`grnd_acct_yr` and  (`grnm_date` between  '$gfrom' and '$gto') $typeSql and
 `grn_detail`.grnd_qty_recd != 0 $depsql)
AS BASIC
LEFT OUTER JOIN `division_masterfile` ON `division_masterfile`.`div_code` = `BASIC`.`dep_code`
LEFT OUTER JOIN `unit_masterfile` ON `unit_masterfile`.`unit_code`=`BASIC`.`sec_code`
ORDER BY `BASIC`.`dep_code`,`BASIC`.`sec_code`,`BASIC`.grnd_number,`BASIC`.grnd_acct_yr";
//echo $sql;
$result = mysql_query($sql) or die(mysql_error());
while($row=mysql_fetch_assoc($result))
{	
//echo "<pre>";
//print_r($row);
//echo"</pre>";
	$count++;
	$grnyr=$row['grnd_acct_yr'];
	$grnno= str_pad($row['grnd_number'], 6, "0", STR_PAD_LEFT);	
	$total=$row['grnm_grand_tot'];
	$date=$row['grnm_date'];
	$depcode=$row['div_code'];
	$depname=$row['div_name'];
	$seccode=$row['unit_code'];
	$secname=$row['unit_name'];
	$progcode=$row['prog_code'];
	$progname=$row['prog_name'];
	if($progcode == "")$progname ="";
	
	if($tdep!==$depcode && $typesec == 5)
	{
		$countsec += 1;
		if($countsec >1)
		$pdf->AddPage();
		
		$pdf->SetFont('Arial','B',9);	
		//$pdf->Ln(2);	
		$pdf->Cell(30,10,"Faculty : $depcode - $depname");	
		$tdep=$depcode;
	}
	if($tsec!==$seccode && $typesec == 6)
	{
		$countsec += 1;
		if($countsec >1)
		$pdf->AddPage();
		
		$pdf->SetFont('Arial','B',9);	
		//$pdf->Ln(2);	
		$pdf->Cell(40,10,"Faculty : $depcode - $depname");
		$pdf->Ln(5);	
		$pdf->Cell(40,10,"Department : $seccode - $secname");
		$tsec=$seccode;
	}
	if($tgrn!==$grnno)
	{
		
		$pdf->SetFont('Arial','B',9);	
		$pdf->Ln(5);	
		$pdf->Cell(40,10,"GRN # : $grnyr - $grnno  ($date)  -  Total  : $total",0,0);
		//if($count!=1)
		//{
		//$pdf->Cell(80,10,"Total  - ".$total);
		//$data1=array('','','','','Total',$total);
		//$pdf->Row($data1);
		//}
		$pdf->Ln(8);	
		$tgrn=$grnno;
	}
	$pdf->SetAligns(array('L','L','L','R','R','R'));
		
		$item= $row['grnd_item_code'];
		$ttot= $row['tot_value'];
		$tot =number_format((float)$ttot, 2, '.', ',');
		$qty= $row['grnd_qty_recd'];
		$po=$row['grnd_po_acct_yr'].'/'.$row['grnmuser'].'/'.$row['grnd_po_no'];
		if(!$qty || $qty==0)
		$qty=1;
		$tunit=($ttot / $qty);
		$unit =number_format((float)$tunit, 2, '.', ',');
      	$data=array($po,
		$row['grnd_item_code'],
		$row['item_description'],
		$unit,
		$qty,
		$tot);
	$pdf->SetFont('Arial','',9);	
    $pdf->Row($data);
	$pdf->Ln(0);
	//$itemdis =0;
}
$pdf->AliasNbPages();
$pdf->Output();
?>


