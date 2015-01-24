<?
require_once("verificalogin.php"); VerificaNivel(4);

if ( (isset($_GET['id'])) && ($_GET['id'] != '') ) {
	require_once("Connections/dbOS.php");
	if (!isset($xml)) {
		require_once("xml_parser.php"); 
		$xml = new xml_parser;
		$result = $xml->parser("Connections/parameters.xml",true); 
	}
	
	mysql_select_db($database_dbOS, $dbOS);
	//
	if ($xml->get_element_value('base_equip')) {
		$qrysql = "select os.id,os.solucao,os.fi,os.patrimonio,os.ai,dp.nome_depto,
		    	   eq.descricao componente,eq.modelo,eq.num_serie,eq.tipo,eq.descricao,
			       em.descricao empresa,em.telefone,em.endereco,em.cidade,eq.modelo
				from ordem_servico os, comum.depto dp, comp_defeito co, empresa em, levto.levto eq
				where os.localizacao=dp.codigo_depto and co.id=os.componente and eq.ai=os.ai and
			      em.id=os.empresa and os.at='S' and os.id=".$_GET['id'];
	} else {				  
		$qrysql = "select os.id,os.solucao,os.fi,os.patrimonio,os.ai,dp.nome_depto,
		    	   co.descricao componente,em.descricao empresa,em.telefone,em.endereco,em.cidade
				from ordem_servico os, comum.depto dp, comp_defeito co, empresa em
				where os.localizacao=dp.codigo_depto and co.id=os.componente and 
			      em.id=os.empresa and os.at='S' and os.id=".$_GET['id'];
	}
	
	$sql = mysql_query($qrysql, $dbOS) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);
	$tot = mysql_num_rows( $sql );
	
	if ($tot > 0 ) {
		include("fpdf/fpdf.php");
		$pdf = new FPDF();
		$pdf->SetMargins(20,20,20);
		$pdf->SetTitle("NOTA DE SAIDA DE BENS MOVEIS");
		$pdf->SetFont('Arial', '', 10);
	    $pdf->AddPage('P');
		
		for ($i=1; $i<=3; $i++) {
			if ($i > 1) {
				$pdf->SetFont('Arial', '', 10);
				$pdf->AddPage('P');
			}
			$campus = $xml->get_element_value('nome_campus');
	    	$pdf->SetXY(10, 40); 
			$pdf->Cell(140 , 6, $campus.", ".date('d').' de '.MesExtenso(date('m')).' de '.date('Y').'.', 0, 0, 'L');
			$pdf->Cell( 50 , 4, $i."ª Via    ", 0, 1, 'R');
			if ($i == 1) {
				$txt = "Patrimônio";
			} else { 
				if ($i == 2) {
					$txt = " Empresa  ";
				} else {
					$txt = "   STI    ";
				}
			}
			$pdf->Cell(180 , 4, $txt, 0, 1, 'R');
	    	$pdf->SetXY(10,60); 
			$pdf->Cell(190 , 6, "Origem: ".$row['nome_depto'], 0, 1, 'L');
	    	$pdf->SetXY(10,66); 
			$pdf->Cell(170 , 6, "Destino: ".$row['empresa'], 0, 0, 'L');
			$pdf->Cell(10 , 6, "OS: ".$row['fi'], 0, 1, 'L');
			$pdf->SetFont('Arial', 'B', 10);
	    	$pdf->SetXY(10,76); 
			$pdf->Cell(33 , 6, "N.Ordem ", 'T', 0, 'L');
			$pdf->Cell(34 , 6, "Chapa", 'T', 0, 'L');
			$pdf->Cell(33 , 6, "Qtde.", 'T', 0, 'L');
			$pdf->Cell(90, 6, "Discriminação", 'T', 1, 'L');
			$pdf->SetFont('Arial', '', 10);
	    	$pdf->SetXY(10,81); 
			$pdf->Cell(33 , 6, "   01", 'T', 0, 'L');
			$pdf->Cell(34 , 6, $row['patrimonio'], 'T', 0, 'L');
			$pdf->Cell(33 , 6, "   01", 'T', 0, 'L');
			$pdf->Cell(90, 6, $row['componente'], 'T', 1, 'L');
			//
			if ($xml->get_element_value('base_equip')) {
		    	$pdf->SetXY(110,85); 
				$pdf->Cell(90, 6, "Modelo: ".$row['modelo'], 0, 1, 'L');
		    	$pdf->SetXY(110,89); 
				$pdf->Cell(90, 6, "Tipo: ".$row['tipo'], 0, 1, 'L');
		    	$pdf->SetXY(110,93); 
				$txt = ($row['num_serie']!='')?$row['num_serie']:$row['ai'];
				$pdf->Cell(90, 6, "Série: ".$txt, 0, 1, 'L');
			}
			//
	    	$pdf->SetXY(10,200); 
			if ($i == 1) {
				$pdf->Cell(190, 6, "Obs.: EQUIPAMENTO ENVIADO PARA MANUTENÇÃO/CONSERTO", 0, 1, 'L');
		    	$pdf->SetXY(10,204); 
				$pdf->Cell(190, 6, "         ".$row['endereco']." - ".$row['cidade']." - ".$row['telefone'], 0, 1, 'L');
			} else {
				$tam = ceil( strlen($row['solucao'])/190 )*4 ;
				$pdf->Write( $tam,"Defeito: ".$row['solucao']);
			}
			$pdf->SetXY(10,240);
			$pdf->Cell(63, 6, "Seção Cedente", 0, 0, 'C');		
			$pdf->Cell(63, 6, "Autorização do Patrimônio", 0, 0, 'C');		
			$pdf->Cell(64, 6, "Recebi Material", 0, 0, 'C');
			$pdf->SetXY(136,245);
			$pdf->Cell(64, 6, "em ___/___/______", 0, 1, 'C');		
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetXY(20,265);
			$pdf->Cell(50, 6, "Carimbo e Assinatura", 'T', 0, 'C');		
			$pdf->Cell(13, 6, "", 0, 0, 'C');		
			$pdf->Cell(50, 6, "Carimbo e Assinatura", 'T', 0, 'C');		
			$pdf->Cell(13, 6, "", 0, 0, 'C');		
			$pdf->Cell(54, 6, "Carimbo e Assinatura", 'T', 0, 'C');		
		}
			
		$pdf->Output();  
			
	} else {
		$msg = "Equipamento não foi encontrado!!! Verifica se o AI esta correto.";
	}
} else {
	$msg = "Erro ao gerar o relatório... Tente novamete!";
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
