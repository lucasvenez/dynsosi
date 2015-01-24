<?php
/*
 * Created on 15/07/2010
 * Author Lucas Venezian Povoa
 * Script created to persist a new user at servidor table from comum schema.
 */
include ( "./Tools.php" );
require_once ( "./conecta.php" );

/**
 * 0 - SUCCESS;
 * 1 - DUPLICATED EMAIL;
 * 2 - DUPLICATED ID;
 * 3 - COMUNICATION ERROR
 */
$result = 0;

if ( $db != null ) {

	$nome			= $_POST['nome'];
	$sexo 			= $_POST['sexo'];
	$logradouro		= $_POST['logradouro'];
	$bairro 		= $_POST['bairro'];
	$cep 			= $_POST['cep'];
	$cidade 		= $_POST['cidade'];
	$uf				= $_POST['uf'];
	$nascimento 	= Tools::toMySQLFormat($_POST['nascimento']);
	$naturalidade 	= $_POST['naturalidade'];
	$rg 			= $_POST['rg'];
	$fone 			= $_POST['fone'];
	$email 			= $_POST['email'];
	$matricula 		= $_POST['matricula'];
	$cpf	 		= $_POST['cpf'];
	$senha 			= $_POST['senha'];
	
	$query = "SELECT COUNT(*) " .
	 	 	 "FROM servidor " .
	 		 "WHERE email LIKE '$email'";
			 
	$resultSet = mysql_query( $query );
	$verificarEmail = mysql_fetch_array( $resultSet );
	
	if ( $verificarEmail[0] > 0 ) {
		
		$result = 1;
		mysql_free_result( $resultSet );
	}	
	else {
		
		mysql_free_result( $resultSet );
		
		$query = "SELECT COUNT(*) " .
				 "FROM servidor " .
				 "WHERE cpf_servidor LIKE '$cpf' OR " .
				 	   "matricula = '$matricula'";
			 
		$resultSet = mysql_query( $query );
		$identificadores = mysql_fetch_array( $resultSet );	
		
		if ( $identificadores[0] > 0 ) {
		
			$result = 2;
			mysql_free_result( $resultSet );
		}
		else {
			
			mysql_free_result( $resultSet );
			
			$query = "INSERT INTO servidor ( " .
						"cpf_servidor, " .
						"nome_servidor, " .
						"senha_servidor, " .
						"naturalidade, " .
						"data_nascimento, " .
						"rg, " .
						"fone, " .
						"uf, " .
						"cidade, " .
						"cep, " .
						"bairro, " .
						"endereco_residencia, " .
						"email, " .
						"sexo, " .
						"matricula " .
					") " .
					"VALUES (" .
						"'$cpf', " .
						"'$nome', " .
						"'$senha', " .
						"'$naturalidade', " .
						"'$nascimento', " .
						"'$rg', " .
						"'$fone', " .
						"'$uf', " .
						"'$cidade', " .
						"'$cep', " .												
						"'$bairro', " .
						"'$logradouro', " .						
						"'$email', " .
						"$sexo, " .
						"$matricula " .
					")";
					
			if ( !mysql_query( $query ) ) {
				
				$result = 3;
			}
			else {
				//send an e-mail
				$message  = "Olá Sr(a) $nome.\n";
				$message .= "Seu cadastramento no sistema interno do Campus de Ourinhos foi efetuado com sucesso.\n";
				$message .= "Seus dados de acesso são:\n";
				$message .= "usuário: $cpf\n";
				$message .= "senha: $senha\n";
				
				$message .= "\n\nAtenciosamente,\n\n\nServiço Técnico de Informática - STI\n";
				$message .= "http://www.ourinhos.unesp.br/\n";
				$message .= "\nUNESP - Campus Experimental de Ourinhos\n";
		
				mail($email, "[Cadastramento - Campus de Ourinhos] Dados cadastrais.", $message, "From: sti@ourinhos.unesp.br");	
			}
		}
	}
}
else {
	
	$result = 3;
}

print ( $result );
?>