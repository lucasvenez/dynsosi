<?php
require_once("verificalogin.php");
VerificaNivel(4);

if ((isset($_POST['op'])) && ($_POST['op'] != '')) {

    if ($_POST['op'] == 'E') {
       header("Location: cad_atendente.php?id=".$_POST['id']); 
	} 

    require_once("Connections/dbOS.php");
    mysql_select_db($database_dbOS, $dbOS);

	if ($_POST['op'] == 'D') {
       $deleteSQL = "DELETE FROM atendente WHERE id=" . $_POST['id'];   
       $Result1 = mysql_query($deleteSQL, $dbOS) or die(mysql_error());

       header("Location: cons_atendente.php"); 
	}

	if ($_POST['op'] == 'I') {                      
	   $insertSQL = sprintf("insert into atendente (apelido,senha,nome,data_nasc,endereco,bairro,cidade,
	                     cep,uf,telefone,celular,email,filiacao,endereco_origem,bairro_origem,
						 cidade_origem,uf_origem,cep_origem,telefone_origem,celular_origem,
						 tipo_vinculo,instituicao,inicio,termino,obs,nivel,cpf) 
						 values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
					     SQLTxt($_POST['apelido']),				SQLTxt($_POST['senha']),
						 SQLTxt($_POST['nome']),			    SQLTxt(FormataDataBD($_POST['data_nasc'])),
						 SQLTxt($_POST['endereco']),			SQLTxt($_POST['bairro']),
						 SQLTxt($_POST['cidade']),				SQLTxt($_POST['cep']),
						 SQLTxt($_POST['uf']),					SQLTxt($_POST['telefone']),
						 SQLTxt($_POST['celular']),				SQLTxt($_POST['email']),
						 SQLTxt($_POST['filiacao']),			SQLTxt($_POST['endereco_origem']),
						 SQLTxt($_POST['bairro_origem']), 		SQLTxt($_POST['cidade_origem']),
						 SQLTxt($_POST['uf_origem']), 			SQLTxt($_POST['cep_origem']),
					     SQLTxt($_POST['telefone_origem']),		SQLTxt($_POST['celular_origem']),
						 SQLTxt($_POST['tipo_vinculo']),		SQLTxt($_POST['instituicao']),
						 SQLTxt(formataDataBD($_POST['inicio'])),SQLTxt(FormataDataBD($_POST['termino'])),
						 SQLTxt($_POST['obs']),					SQLTxt($_POST['nivel']),
						 SQLTxt($_POST['cpf']) );
						   
  		$Result1 = mysql_query($insertSQL, $dbOS) or die(mysql_error());						   
        header("Location: cons_atendente.php"); 
	}	
		 
	if ($_POST['op'] == 'U') {
 	    $updateSQL = sprintf("update atendente set apelido=%s,senha=%s,nome=%s,data_nasc=%s,
	                     endereco=%s,bairro=%s,cidade=%s,cep=%s,uf=%s,telefone=%s,celular=%s,
						 email=%s,filiacao=%s,endereco_origem=%s,bairro_origem=%s,cidade_origem=%s,
						 uf_origem=%s,cep_origem=%s,telefone_origem=%s,celular_origem=%s,tipo_vinculo=%s,
						 instituicao=%s,inicio=%s,termino=%s,obs=%s,nivel=%s,cpf=%s where id=".$_POST['id'],
					     SQLTxt($_POST['apelido']),				SQLTxt($_POST['senha']),
						 SQLTxt($_POST['nome']),			    SQLTxt(FormataDataBD($_POST['data_nasc'])),
						 SQLTxt($_POST['endereco']),			SQLTxt($_POST['bairro']),
						 SQLTxt($_POST['cidade']),				SQLTxt($_POST['cep']),
						 SQLTxt($_POST['uf']),					SQLTxt($_POST['telefone']),
						 SQLTxt($_POST['celular']),				SQLTxt($_POST['email']),
						 SQLTxt($_POST['filiacao']),			SQLTxt($_POST['endereco_origem']),
						 SQLTxt($_POST['bairro_origem']), 		SQLTxt($_POST['cidade_origem']),
						 SQLTxt($_POST['uf_origem']), 			SQLTxt($_POST['cep_origem']),
					     SQLTxt($_POST['telefone_origem']),		SQLTxt($_POST['celular_origem']),
						 SQLTxt($_POST['tipo_vinculo']),		SQLTxt($_POST['instituicao']),
						 SQLTxt(formataDataBD($_POST['inicio'])),SQLTxt(FormataDataBD($_POST['termino'])),
						 SQLTxt($_POST['obs']),					SQLTxt($_POST['nivel']),
						 SQLTxt($_POST['cpf']) );
					   
  		$Result1 = mysql_query($updateSQL, $dbOS) or die(mysql_error());						   
        header("Location: cons_atendente.php"); 
	}	
		
}

function SQLTxt($value) {
     $value = ($value != "") ? "'" . $value . "'" : "NULL";
	 return $value;
}

function FormataDataBD($data) {
   $dt = explode('/',$data);
   return $dt[2] . '-' . $dt[1] . '-'. $dt[0];
}

?>