<!DOCTYPE HTML PUBLIC "-//W3C//Dtd HTML 4.01 Transitional//EN" "http://www.w3.org/tr/html4/loose.dtd">
<html>

<head>

	<title>:: UNESP - Campus Experimental de Ourinhos ::</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	
	<link rel="shortcut icon" href="./images/icone.ico">

	<link href="./css/estilos.css" rel="stylesheet" type="text/css">
	<link href="./css/estrutura.css" rel="stylesheet" type="text/css">
	<link href="./css/menu.css" rel="stylesheet" type="text/css">
	
	<link href="../folha.css" rel="stylesheet" type="text/css">
	<link href="../imprimir.css" rel="stylesheet" media="print" type="text/css">

	<script type="text/javascript" src="./js/Util.js"></script>
</head>

<body onload="document.form.email.focus();">
<?php include "./ssi_topo.php"; ?>
<table width="770" border="0" cellspacing="0" cellpadding="0">
	<tr>
    	<td width="150" height="86">&nbsp;</td>
		<td width="10">&nbsp;</td>
		<td width="615">&nbsp;</td>
    </tr>
    <tr>
		<td class="container-menu-esquerdo">
			<?php include "./ssi_menu_esquerdo.php"; ?>
		</td>
		<td width=10>&nbsp;</td>
    	<td vAlign=top width="615">
      		<table id="Nome da Area" cellSpacing=0 cellPadding=0 width="615" border=0>
        		<tr>
          			<td vAlign=top height=20 width="615">
            			<table id=conteudo cellSpacing=0 cellPadding=0 width="615" border=0>
              				<tr>
                				<td height=20 class=NomeArea style1 style2>SOSI (Sistema de Ordem de Servi&ccedil;o de Inform&aacute;tica) :::</td>
              				</tr>			    		  
              				<tr>
                				<td height="40" valign="middle"> 
                  					<span class="style5">Envio de senha por email</span><br/>
                				</td>
              				</tr>
              				<tr>
                				<td valign="top">
									<form name="form" method="post" action="verifica_email.php">
										<table width="100%" cellpadding="3" cellspacing="3">
                      						<tr> 
                        						<td colspan="2">	
                        							<span class="style3"><br/>
  														Se voc&ecirc; j&aacute; &eacute; cadastrado no sistema 
  														SOSI do Campus de Ourinhos e esqueceu a senha, informe os 
                          								dados abaixo e clique em Solicitar Senha. Se os dados 
                          								estiverem corretos, a senha ser&aacute; enviada por 
                          								email.
                          							</span>
                        						</td>
                      						</tr>
                      						<tr> 
                        						<td colspan="2">
													<table width="100%">
		                      							<tr> 
		                        							<td class="DivisorHorizontal">&nbsp;</td>
        		              							</tr>
													</table>
												</td>
                      						</tr>
                      						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">Email:</td>
                        						<td width="70%" height="40" class="tabela-linha"><input name="email" type="text" size="50" maxlength="50"></td>
                      						</tr>
                      						<tr>
                        						<td height="40" align="right" class="tabela-titulo">CPF:</td>
                        						<td height="40" class="tabela-linha"><input name="cpf" type="text" id="cpf" size="20" maxlength="11">
                        							(Somente n&uacute;meros)
                        						</td>
                      						</tr>
					  						<tr align="center"> 
                        						<td height="65" colspan="2">
                        							<a href="javascript:document.form.submit()" class="LinkLaranja">[Solicitar Senha]</a>
                        						</td>
                      						</tr>
                    					</table>
									</form>
			  					</td>
			  				</tr>
              				<tr> 
                  				<td class="DivisorHorizontal">&nbsp;</td>
              				</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php include "./ssi_rodape.php"; ?>
</body>
</html>