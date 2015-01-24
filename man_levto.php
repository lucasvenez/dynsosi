<?php
require_once("verificalogin.php");
VerificaNivel(4); 

if ((isset($_POST['op'])) && ($_POST['op'] != '')) {

    if ($_POST['op'] == 'E') {
       header("Location: cad_levto.php?id=".$_POST['id']); 
	} 

    require_once("Connections/dbLevto.php");
    mysql_select_db($database_dbLevto, $dbLevto);

	if ($_POST['op'] == 'D') {
       $deleteSQL = "DELETE FROM levto WHERE id=" . $_POST['id'];   
       $Result1 = mysql_query($deleteSQL, $dbLevto) or die(mysql_error());

       header("Location: cons_levto.php"); 
	}

	if ($_POST['op'] == 'I') {                      
	   $insertSQL = sprintf("insert into levto (descricao,num_serie,ai,modelo,tipo,data_aquisicao,sigla,
	                           nome_ua,complemento,patrimonio,comodato,situacao,data_baixa,observacao,
							   host,ip,placa_mae,chipset,ram,hd,aida,tipo_ua,codigo_depto,codigo_componente,empr_aquisicao,garantia) 
							 values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
								SQLTxt($_POST['descricao']),		SQLTxt($_POST['numSerie']),
								SQLTxt($_POST['ai']),				SQLTxt($_POST['modelo']),    
								SQLTxt($_POST['tipo']),				SQLTxt(FormataDataBD($_POST['DataAquisicao'])),
								SQLTxt($_POST['sigla']),			SQLTxt($_POST['NomeUa']),
								SQLTxt($_POST['complemento']),		SQLTxt($_POST['patrimonio']),
								SQLTxt($_POST['comodato']),			SQLTxt($_POST['situacao']),
								SQLTxt(FormataDataBD($_POST['dataBaixa'])),	SQLTxt($_POST['observacao']),
								SQLTxt($_POST['host']),				SQLTxt($_POST['ip']),
								SQLTxt($_POST['placaMae']),			SQLTxt($_POST['chipset']),
								SQLTxt($_POST['ram']),				SQLTxt($_POST['hd']),
								SQLTxt($_POST['aida']),				SQLTxt($_POST['tipoUa']),
								SQLTxt($_POST['CodigoDepto']),		$_POST['CodigoComponente'],
								$_POST['Empresa'],					SQLTxt(FormataDataBD($_POST['DataGarantia'])) );

 	   $Result1 = mysql_query($insertSQL, $dbLevto) or die(mysql_error());						   
       header("Location: cons_levto.php"); 
	}	
		 
	if ($_POST['op'] == 'U') {
 	    $updateSQL = sprintf("update levto set descricao=%s, num_serie=%s, ai=%s, modelo=%s, 
		                       tipo=%s, data_aquisicao=%s, sigla=%s, nome_ua=%s, complemento=%s, 
							   patrimonio=%s, comodato=%s, situacao=%s, data_baixa=%s, observacao=%s,
							   host=%s, ip=%s, placa_mae=%s, chipset=%s, ram=%s, hd=%s, aida=%s, tipo_ua=%s,
							   codigo_depto=%s, codigo_componente=%s, empr_aquisicao=%s, garantia=%s where id=".$_POST['id'],
								SQLTxt($_POST['descricao']),		SQLTxt($_POST['numSerie']),
								SQLTxt($_POST['ai']),				SQLTxt($_POST['modelo']),    
								SQLTxt($_POST['tipo']),				SQLTxt(FormataDataBD($_POST['DataAquisicao'])),
								SQLTxt($_POST['sigla']),			SQLTxt($_POST['NomeUa']),
								SQLTxt($_POST['complemento']),		SQLTxt($_POST['patrimonio']),
								SQLTxt($_POST['comodato']),			SQLTxt($_POST['situacao']),
								SQLTxt(FormataDataBD($_POST['dataBaixa'])),	SQLTxt($_POST['observacao']),
								SQLTxt($_POST['host']),				SQLTxt($_POST['ip']),
								SQLTxt($_POST['placaMae']),			SQLTxt($_POST['chipset']),
								SQLTxt($_POST['ram']),				SQLTxt($_POST['hd']),
								SQLTxt($_POST['aida']),				SQLTxt($_POST['tipoUa']),
								SQLTxt($_POST['CodigoDepto']),		SQLTxt($_POST['CodigoComponente']),
								SQLTxt($_POST['Empresa']),			SQLTxt(FormataDataBD($_POST['DataGarantia'])) );

  		$Result1 = mysql_query($updateSQL, $dbLevto) or die(mysql_error());						   
       header("Location: cons_levto.php"); 
	}	
}

function SQLTxt($value) {
	$value = ($value != "") ? "'" . $value . "'" : "NULL";
	return $value;
}

function FormataDataBD($data) {
	if ($data == '') {
		return '';
	} else {
		$dt = explode('/',$data);
		return $dt[2] . '-' . $dt[1] . '-'. $dt[0];
	}
}

?>