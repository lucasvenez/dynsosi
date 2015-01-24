<?php

	require_once("conecta.php");

	$senha = "";
	$email = "";
		
	$cli_login = $_POST["cpf"];			
	$cli_email = $_POST["email"];

	$sql   = "select senha_servidor from servidor WHERE cpf_servidor = '$cli_login'";
	
	$rs    = mysql_query($sql) or die("Erro no SQL");
	$reg   = mysql_fetch_Array($rs);

	$senha = $reg['senha_servidor'];

	$sql2   = "select email from servidor WHERE cpf_servidor = '".$cli_login."'";
	
	$rs2    = mysql_query($sql2) or die("Erro no SQL");
	$reg2   = mysql_fetch_Array($rs2);

    $email = $reg2['email'];
		
	if ( !$senha || $email != $cli_email ) {
		
		header("Location: ./confirma_envio_email.php?confirmado=N");
	}
	else {
		
		$message  = "Conforme solicitação,\n\nA senha para acesso ao sistema SOSI é: $senha";
		$message .= "\n\nAtenciosamente,\n\n\nServiço Técnico de Informática - STI\n";
		$message .= "http://www.ourinhos.unesp.br/sosi_v2/";
		$message .= "\nUNESP - Campus Experimental de Ourinhos\n";

		mail($cli_email, "[Sistema SOSI - Campus de Ourinhos] Reenvio de senha", $message, "From: sti@ourinhos.unesp.br");
		
		header("Location: ./confirma_envio_email.php?confirmado=S");
	}
?>