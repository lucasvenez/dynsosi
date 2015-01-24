<?
require_once("verificalogin.php"); VerificaNivel(4);
require_once("Connections/dbLevto.php");
	
mysql_select_db($database_dbLevto, $dbLevto);
$qry = "select descricao,ai,patrimonio,sigla,modelo,ip,ram,hd from levto.levto where 1 ";

if ( (isset($_GET['equip'])) && ($_GET['equip'] != '') && ($_GET['equip'] != '0') ) {
   $qry .= " and codigo_componente = '". $_GET['equip'] ."'";
}
if ( (isset($_GET['depto'])) && ($_GET['depto'] != '') && ($_GET['depto'] != '0') ) {
   $qry .= " and sigla = '". $_GET['depto'] ."'";
}
				
$qry .= " order by ".$_GET['ord'];
$sql = mysql_query($qry, $dbLevto) or die(mysql_error());
$tot = mysql_num_rows( $sql );
	
if ($tot > 0 ) {
	include("fpdf/fpdf.php");
	$pdf = new FPDF();
	$pdf->SetMargins(20,20,20);
	$pdf->SetTitle("RELAÇÃO DOS EQUIPAMENTOS");
	$pdf->SetFont('Arial', '', 10);
    $pdf->AddPage('L');
	//
   	$pdf->SetXY(5, 40); 
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell(80, 6, "EQUIPAMENTO", 1, 0, 'L', 1);
	$pdf->Cell(20, 6, "AI", 1, 0, 'C', 1);
	$pdf->Cell(25, 6, "PATRIMONIO", 1, 0, 'C', 1);
	$pdf->Cell(15, 6, "DEPTO", 1, 0, 'C', 1);
	$pdf->Cell(80, 6, "DESCRIÇÃO", 1, 0, 'C', 1);
	$pdf->Cell(30, 6, "IP", 1, 0, 'C', 1);
	$pdf->Cell(15, 6, "RAM", 1, 0, 'C', 1);
	$pdf->Cell(15, 6, "HD", 1, 0, 'C', 1);
	//
	while ($row=mysql_fetch_assoc($sql)) {
    	$pdf->SetXY(5,$pdf->GetY()+6); 
		$pdf->Cell(80, 6, $row['descricao'], 1, 0, 'L');
		$pdf->Cell(20, 6, $row['ai'], 1, 0, 'C');
		$pdf->Cell(25, 6, $row['patrimonio'], 1, 0, 'C');
		$pdf->Cell(15, 6, $row['sigla'], 1, 0, 'C');
		$pdf->Cell(80, 6, $row['modelo'], 1, 0, 'L');
		$pdf->Cell(30, 6, $row['ip'], 1, 0, 'C');
		$pdf->Cell(15, 6, $row['ram'], 1, 0, 'C');
		$pdf->Cell(15, 6, $row['hd'], 1, 0, 'C');
	}
	//
	$pdf->Output();  		
} else {
	$msg = "Equipamento não foi encontrado!!!";
}

function MesExtenso( $month ) {
	switch ($month) {
		case '01' : return 'Janeiro'; break;
		case '02' : return 'Fevereiro'; break;
		case '03' : return 'Mar&ccedil;o'; break;
		case '04' : return 'Abril'; break;
		case '05' : return 'Maio' ; break;
		case '06' : return 'Junho'; break;
		case '07' : return 'Julho'; break;
		case '08' : return 'Agosto'; break;
		case '09' : return 'Setembro'; break;
		case '10' : return 'Outubro' ; break;
		case '11' : return 'Novembro'; break;
		case '12' : return 'Dezembro'; break;
	}
}

if ($msg != '') {
	echo $msg;
}
?>
