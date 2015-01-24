<?php
require_once("verificalogin.php"); VerificaNivel(6);
require_once("Connections/dbOS.php");
require_once("Connections/dbComum.php");

if ((isset($_POST['op'])) && ($_POST['op'] != '')) {

    if ($_POST['op'] == 'E') {
       
    	header("Location: alt_ordem.php?id=".$_POST['id']);
        
	} else if ($_POST['op'] == 'L') {
       
		header("Location: bxr_ordem.php?id=".$_POST['id']);
		 
	} else {

	    mysql_select_db($database_dbOS, $dbOS);
	
		if ($_POST['op'] == 'D') {
			
	       $deleteSQL = "DELETE FROM ordem_servico WHERE id=" . $_POST['id'];   
	       $Result1 = mysql_query($deleteSQL, $dbOS) or die(mysql_error());
	
	       header("Location: ordens_servico_abertas.php");
	        
		} else {
	
			/*
			 * Getting requester's e-mail
			*/
			$query = "SELECT usuario FROM ordem_servico WHERE id = '" . $_POST['id'] . "'";
			 
			$result = mysql_query($query, $dbOS) or die(mysql_error());
			
			$row = mysql_fetch_array($result);
			 
			$CPF_SERVIDOR = $row[0];
			
			/*
			 * Selecionando o schema comum
			*/
			mysql_select_db( $database_dbComum, $dbComum );
			 
			$query = "SELECT email FROM servidor WHERE cpf_servidor = '$CPF_SERVIDOR'";
			 
			$result = mysql_query($query, $dbComum) or die(mysql_error());
			 
			$row = mysql_fetch_array($result);
			mysql_free_result($result);
			
			$email = $row[0];
			
			mysql_select_db($database_dbOS, $dbOS);
			
			$mensagem  = null;
			$titulo    = "[SOSI] ";
			
			$headers  = "From: SOSI <sti@ourinhos.unesp.br>\r\n";
			$headers .= "Cc: Seção Técnica de Informática <sti@ourinhos.unesp.br>";
			
			if ($_POST['op'] == 'I') {                      
			   $insertSQL = sprintf("insert into ordem_servico (data,usuario,hora,ip,localizacao,sala,
			                           requisitante,ramal,ai,patrimonio,comodato,componente,defeito,atendente)
									   values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
							     SQLTxt(FormataDataBD($_POST['data'])),	SQLTxt($_POST['usuario']),
								 SQLTxt($_POST['hora']),			    SQLTxt($_POST['ip']),
								 SQLTxt($_POST['CodigoDepto']),			SQLTxt($_POST['sala']),
								 SQLTxt($_POST['requisitante']),		SQLTxt($_POST['ramal']),
								 SQLTxt($_POST['ai']),					SQLTxt($_POST['patrimonio']),
								 SQLTxt($_POST['comodato']),			SQLTxt($_POST['CodigoComponente']),
								 SQLTxt($_POST['defeito']),				0 );
								   
		  	   $Result1 = mysql_query($insertSQL, $dbOS) or die(mysql_error());						   
		       header("Location: ordens_servico_abertas.php"); 
			
			} else if ($_POST['op'] == 'U') {
				
		       $updateSQL = sprintf("update ordem_servico set localizacao=%s, sala=%s, requisitante=%s,
				                       ramal=%s, ai=%s, patrimonio=%s, comodato=%s, componente=%s,
									   defeito=%s, atendente=%s, solucao=%s WHERE id=" . $_POST['id'],
								 SQLTxt($_POST['CodigoDepto']),			SQLTxt($_POST['sala']),
								 SQLTxt($_POST['requisitante']),		SQLTxt($_POST['ramal']),
								 SQLTxt($_POST['ai']),					SQLTxt($_POST['patrimonio']),
								 SQLTxt($_POST['comodato']),			SQLTxt($_POST['CodigoComponente']),
								 SQLTxt($_POST['defeito']),				SQLTxt($_POST['atendente']),
								 SQLTxt($_POST['solucao']) );
			   
		       $titulo   .= "Ordem de serviço " . $_POST['id'] . " atualizada";
		       
		       $mensagem  = "Caro Requisitante,\n\n";
		       
		       $mensagem .= "Sua solicitação de ordem de serviço " . $_POST['id'] . " foi atualizada.\n\n";
		       
		       $mensagem .= "Atenciosamente\n";
		       $mensagem .= "Seção Técnica de Informática";
		       
		  	   $Result1 = mysql_query($updateSQL, $dbOS) or die(mysql_error());						   
		       header("Location: ordens_servico_abertas.php"); 
			
			} else if ($_POST['op'] == 'B') {
				
		       $updateSQL = sprintf("update ordem_servico set localizacao=%s, sala=%s, requisitante=%s,
				                       ramal=%s, ai=%s, patrimonio=%s, comodato=%s, componente=%s,
									   defeito=%s, atendente=%s, solucao=%s, data_baixa=%s,
									   hora_baixa=%s WHERE id=" . $_POST['id'],
								 SQLTxt($_POST['CodigoDepto']),			SQLTxt($_POST['sala']),
								 SQLTxt($_POST['requisitante']),		SQLTxt($_POST['ramal']),
								 SQLTxt($_POST['ai']),					SQLTxt($_POST['patrimonio']),
								 SQLTxt($_POST['comodato']),			SQLTxt($_POST['CodigoComponente']),
								 SQLTxt($_POST['defeito']),				SQLTxt($_POST['atendente']),
								 SQLTxt($_POST['solucao']),				SQLTxt(Date('Y-m-d')),
								 SQLTxt(Date('H:i:s')) );
		
		  	   $Result1 = mysql_query($updateSQL, $dbOS) or die(mysql_error());						   
		
		  	   $titulo   .= "Ordem de serviço " . $_POST['id'] . " finalizada";
		  	    
		  	   $mensagem  = "Caro Requisitante,";
		  	   
		  	   $mensagem .= "Sua solicitação de ordem de serviço " . $_POST['id'] . " foi finalizada com a seguinte descrição:\n\n";
		  	   
		  	   $mensagem .= "=================================================================================================\n";
		  	   $mensagem .= $_POST['solucao'] . "\n";
		  	   $mensagem .= "=================================================================================================\n\n";
		  	   
		  	   $mensagem .= "Atenciosamente\n";
		  	   $mensagem .= "Seção Técnica de Informática";
		  	   
			   echo '<script language="javascript">';
			   echo ' alert("Pedido de Ordem de Serviço baixado com sucesso!");';
			   echo ' window.location = "ordens_servico_abertas.php"; ';
			   echo '</script>';					   
			
			} else if ($_POST['op'] == 'A') {
				
		       $updateSQL = sprintf("update ordem_servico set localizacao=%s, sala=%s, requisitante=%s,
				                       ramal=%s, ai=%s, patrimonio=%s, comodato=%s, componente=%s,
									   defeito=%s, atendente=%s, solucao=%s, at=%s WHERE id=" . $_POST['id'],
								 SQLTxt($_POST['CodigoDepto']),			SQLTxt($_POST['sala']),
								 SQLTxt($_POST['requisitante']),		SQLTxt($_POST['ramal']),
								 SQLTxt($_POST['ai']),					SQLTxt($_POST['patrimonio']),
								 SQLTxt($_POST['comodato']),			SQLTxt($_POST['CodigoComponente']),
								 SQLTxt($_POST['defeito']),				SQLTxt($_POST['atendente']),
								 SQLTxt($_POST['solucao']),				SQLTxt('S') );
							   
		  	   $Result1 = mysql_query($updateSQL, $dbOS) or die(mysql_error());						   
		
		  	   $titulo   .= "Ordem de serviço " . $_POST['id'] . " encaminhada";
		  	   
		  	   $mensagem  = "Caro Requisitante,\n\n";
		  	   
		  	   $mensagem .= "Sua solicitação de ordem de serviço " . $_POST['id'] . " foi encaminhada para assistência técnica terceirizada.\n\n";
		  	   
		  	   $mensagem .= "Atenciosamente\n";
		  	   $mensagem .= "Seção Técnica de Informática";
		  	   
			   echo '<script language="javascript">';
			   echo ' alert("Pedido de Ordem de Serviço encaminhado para Assistência Técnica!"); ';
			   echo ' window.location = "ordens_servico_abertas.php"; ';
			   echo '</script>';					   
			
			} else if ($_POST['op'] == 'S') {
				
		       $updateSQL = "update ordem_servico set data_baixa='', hora_baixa='' WHERE id=" . $_POST['id'];   
		       $Result1 = mysql_query($updateSQL, $dbOS) or die(mysql_error());
		
		       $titulo   .= "Ordem de serviço " . $_POST['id'] . " reaberta";
		       	
		       $mensagem   = "Caro Requisitante,\n\n";
		       
		       $mensagem .= "Sua solicitação de ordem de serviço " . $_POST['id'] . " foi reaberta.\n\n";
		       
		       $mensagem .= "Atenciosamente\n";
		       $mensagem .= "Seção Técnica de Informática";
		       
			   echo '<script language="javascript">';
			   echo ' alert("Pedido de Ordem de Serviço em aberto novamente!"); ';
			   echo ' window.location = "ordens_servico_baixadas.php"; ';
			   echo '</script>';					   
			
			} else if ($_POST['op'] == 'T') {
		
		       $updateSQL = '';
		
			   if ($_POST['op2'] == 'G') {
		         $updateSQL = sprintf("update ordem_servico set ramal=%s, ai=%s, patrimonio=%s, comodato=%s, solucao=%s,
				 						empresa=%s, data_e=%s, data_s=%s, fi=%s WHERE id=" . $_POST['id'],
								SQLTxt($_POST['ramal']),			 SQLTxt($_POST['ai']),
								SQLTxt($_POST['patrimonio']),		 SQLTxt($_POST['comodato']),
								SQLTxt($_POST['solucao']),
								SQLTxt($_POST['empresa']),	SQLTxt(FormataDataBD($_POST['data_e'])),
								SQLTxt(FormataDataBD($_POST['data_s'])), SQLTxt($_POST['fi']) );
		
				 $vtxt      = "Informações do Pedido de Ordem de Serviço armazenadas com sucesso!";
				 
				 $titulo   .= "Ordem de serviço " . $_POST['id'] . " atualizada.";
				 	
				 $mensagem  = "Caro Requisitante,\n\n";
				 
				 $mensagem .= "Sua solicitação de ordem de serviço número " . $_POST['id'] . " foi atualizada.\n\n";
				 	 	
				 $mensagem .= "Atenciosamente\n";
				 $mensagem .= "Seção Técnica de Informática";
		       
			   } else if ($_POST['op2'] == 'B') {
			   	
		         $updateSQL = "update ordem_servico set at='N', solucao='".$_POST['solucao']."', data_baixa='".Date('Y-m-d')."', hora_baixa='".Date('H:i:s')."' WHERE id=" . $_POST['id'];   
				 $vtxt = "Pedido de Ordem de Serviço baixado com sucesso!";
				 
				 $titulo   .= "Ordem de serviço " . $_POST['id'] . " finalizada.";
				 
				 $mensagem   = "Caro Requisitante,\n\n";
				 
				 $mensagem  .= "Sua solicitação de ordem de serviço número " . $_POST['id'] . " foi finalizada com sucesso.\n\n";
				 
				 $mensagem .= "Abaixo segue o descritivo da solução: \n";
		
				 $mensagem .= "===========================================================================================\n";
				 $mensagem .= $_POST['solucao'] . "\n";
				 $mensagem .= "===========================================================================================\n\n";
				 
				 $mensagem .= "Atenciosamente\n";
				 $mensagem .= "Seção Técnica de Informática";
				 
		       } else if ($_POST['op2'] == 'S') {
		       	
		         $updateSQL = "update ordem_servico set data_baixa='', hora_baixa='', at='N' WHERE id=" . $_POST['id'];
				 $vtxt = "Pedido de Ordem de Serviço reaberta!";
				 
				 $titulo   .= "Ordem de serviço " . $_POST['id'] . " reaberta.";
				 	
				 $mensagem  = "Caro Requisitante,\n\n";
				 
				 $mensagem .= "Sua solicitação de ordem de serviço número " . $_POST['id'] . " foi reaberta.\n\n";
				 	
				 $mensagem .= "Atenciosamente\n";
				 $mensagem .= "Seção Técnica de Informática";
		       }
		
			   if ($updateSQL != '') {
		
			   	  mysql_select_db( $database_dbOS, $dbOS );
		          $Result1 = mysql_query($updateSQL, $dbOS) or die(mysql_error());
		          
			   } else
			     $vtxt = "Erro ao enviar os dados!";
		
			   echo '<script language="javascript">';
			   echo ' alert("'.$vtxt.'");';
			   echo ' window.location = "assistencia_tecnica.php"; ';
			   echo '</script>';					   
			}
		}
		
		
		if (isset($_POST['id'])) {
			/*
			 * Enviando e-mail para o cliente que efetuou a ordem de serviço.
			*/
			mail( $email, $titulo, $mensagem, $headers );
		}
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
