<?php

require_once("conecta.php");

//definindo variaveis e armazenando o valor dos campos do formul�rio
$nome = $_POST['nome'];
$sexo = $_POST['sexo'];
$endereco = $_POST['endereco'];
$bairro = $_POST['bairro'];
$cep = $_POST['cep'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$nascimento = $_POST['nascimento'];
$naturalidade = $_POST['naturalidade'];
$rg = $_POST['rg'];
$fone = $_POST['fone'];
$email = $_POST['email'];
$matricula = $_POST['matricula'];
$cpf = $_POST['usuario'];
$senha = $_POST['senha'];

	$sql   = "select email from servidor WHERE cpf_servidor = '$usuario'";
	
	$rs    = mysql_query($sql) or die("Erro no SQL");
	$reg   = mysql_fetch_array($rs);

	$em = $reg['email'];
	
	$sql2   = "select cpf_servidor from servidor WHERE email = '$email'";
	
	$rs2    = mysql_query($sql2) or die("Erro no SQL");
	$reg2   = mysql_fetch_array($rs2);

    $em2 = $reg2['cpf_servidor'];
	
	
	if (($em != $email) || ($em2 != $usuario)) {
		
		header("Location: ./confirma_envio_cadastro.php?confirmado=N");
	}
	else {

		$altera = "INSERT INTO servidor (" .
						"cpf_servidor, " .
						"nome_servidor, " .
						"senha_servidor, " .
						"naturalidade, " .
						"data_nascimento, " .
						"rg, " .
						"endereco_residencia, " .
						"" .
				  ") " .
				  "VALUESSET nome_servidor 		= '$nome', " .
				  	  "senha_servidor 		= '$senha', " .
				  	  "naturalidade 		= '$naturalidade', " .
				  	  "data_nascimento 		= '$nascimento', " .
				  	  "rg 					= '$rg', " .
				  	  "endereco_residencia 	= '$endereco', " .
				  	  "fone 				= '$fone', " .
				  	  "cep 					= '$cep', " .
				  	  "uf 					= '$estado', " .
				  	  "cidade 				= '$cidade', " .
				  	  "sexo 				= '$sexo', " .
				  	  "matricula 			= '$matricula', " .
				  	  "bairro 				= '$bairro' " .
				  "WHERE cpf_servidor = '$usuario'";

		mysql_query ($altera, $conexao) 
		and die("<script language=JavaScript>alert('DADOS CADASTRADOS COM SUCESSO! AGORA FA�A O LOGIN!');</script>".require_once'login.php')
		or die ("<script language=JavaScript>alert('OCORREU UM ERRO AO CADASTRAR! TENTE NOVAMENTE!');</script>".require_once'cadastro.php');
	}
?>