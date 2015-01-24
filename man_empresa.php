<?php
require_once("verificalogin.php");
VerificaNivel(4); 

if ((isset($_POST['op'])) && ($_POST['op'] != '')) {

    if ($_POST['op'] == 'E') {
       header("Location: cad_empresa.php?id=".$_POST['id']); 
	} 

    require_once("Connections/dbOS.php");
    mysql_select_db($database_dbOS, $dbOS);

	if ($_POST['op'] == 'D') {
       $deleteSQL = "DELETE FROM empresa WHERE id=" . $_POST['id'];   
       $Result1 = mysql_query($deleteSQL, $dbOS) or die(mysql_error());

       header("Location: cons_empresa.php"); 
	}

	if ($_POST['op'] == 'I') {                      
	   $insertSQL = sprintf("insert into empresa (descricao,cnpj,contato,tecnico,telefone,celular,
	                         fax,homepage,email,endereco,bairro,cidade,uf,cep) 
							 values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
								SQLTxt($_POST['descricao']),		SQLTxt($_POST['cnpj']),
								SQLTxt($_POST['contato']),			SQLTxt($_POST['tecnico']),
								SQLTxt($_POST['telefone']),			SQLTxt($_POST['celular']),
								SQLTxt($_POST['fax']),				SQLTxt($_POST['homepage']),
								SQLTxt($_POST['email']),			SQLTxt($_POST['endereco']),
								SQLTxt($_POST['bairro']),			SQLTxt($_POST['cidade']),
								SQLTxt($_POST['uf']),				SQLTxt($_POST['cep']) );

 	   $Result1 = mysql_query($insertSQL, $dbOS) or die(mysql_error());						   
       header("Location: cons_empresa.php"); 
	}	
		 
	if ($_POST['op'] == 'U') {
 	    $updateSQL = sprintf("update empresa set descricao=%s, cnpj=%s, contato=%s, tecnico=%s, 
		                       telefone=%s, celular=%s, fax=%s, homepage=%s, email=%s, endereco=%s, 
							   bairro=%s, cidade=%s, uf=%s, cep=%s where id=".$_POST['id'],
								SQLTxt($_POST['descricao']),		SQLTxt($_POST['cnpj']),
								SQLTxt($_POST['contato']),			SQLTxt($_POST['tecnico']),
								SQLTxt($_POST['telefone']),			SQLTxt($_POST['celular']),
								SQLTxt($_POST['fax']),				SQLTxt($_POST['homepage']),
								SQLTxt($_POST['email']),			SQLTxt($_POST['endereco']),
								SQLTxt($_POST['bairro']),			SQLTxt($_POST['cidade']),
								SQLTxt($_POST['uf']),				SQLTxt($_POST['cep']) );

  		$Result1 = mysql_query($updateSQL, $dbOS) or die(mysql_error());						   
       header("Location: cons_empresa.php"); 
	}	
}

function SQLTxt($value) {
     $value = ($value != "") ? "'" . $value . "'" : "NULL";
	 return $value;
}

?>