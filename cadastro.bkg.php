<!DOCTYPE HTML PUBLIC "-//W3C//Dtd HTML 4.01 Transitional//EN" "http://www.w3.org/tr/html4/loose.dtd">

<html>
<head>
	<title>:: UNESP - Campus Experimental de Ourinhos ::</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	
	<link rel="shortcut icon" href="./images/icone.ico">
	
	<link href="./css/themes/base/ui.all.css" rel="stylesheet" type="text/css" rev="stylesheet"/>
	
	<link href="./css/mensagem.css" rel="stylesheet" type="text/css">
	<link href="./css/estrutura.css" rel="stylesheet" type="text/css">	
	<link href="./css/estilos.css" rel="stylesheet" type="text/css">
	<link href="./css/menu.css" rel="stylesheet" type="text/css">
	
	<link href="../folha.css" rel="stylesheet" type="text/css">
	<link href="../imprimir.css" rel="stylesheet" media="print" type="text/css">
	
	<script type="text/javascript" src="./js/Util.js"></script>
	
	<script type="text/javascript" src="./js/Ajax.js"></script>
	<script type="text/javascript" src="./js/Tools.js"></script>
	<script type="text/javascript" src="./js/ui/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="./js/ui/ui.datepicker.js"></script>
	<script type="text/javascript" src="./js/ui/i18n/ui.datepicker-pt-BR.js"></script>

</head>

<body onLoad="Util.onLoadCadastro();">

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
    	<td width="10">&nbsp;</td>
    	<td vAlign="top" width="615">
      		<table>
        		<tr>
          			<td>
            			<table id="conteudo">
              				<tr>
                				<td height=20 class="NomeArea style1 style2">SOSI (Sistema de Ordem de Servi&ccedil;o de Inform&aacute;tica) :::</td>
              				</tr>  
              				<tr>
                				<td valign="top">
									<form name="form" onsubmit="return false;">
										<table width="100%" cellpadding="3" cellspacing="3">
                      						<tr> 
                        						<td id="mensagem" colspan="2">
                        							<span class="style3"><br/>
  														Digite as informa&ccedil;&otilde;es abaixo 
  														para efetuar o cadastro no SOSI e solicitar
  														 servi&ccedil;os de Inform&aacute;tica.
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
                        						<td colspan="2">
													<table width="100%">
		                      							<tr> 
		                        							<td>
		                        								<div align="left" class="style7">INFORMA&Ccedil;&Otilde;ES PESSOAIS </div>
		                        							</td>
        		              							</tr>
													</table>
												</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">Nome Completo:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="nome" id="nome" type="text" id="nome" size="50" maxlength="50">
                        						</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">Sexo:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="sexo" type="radio" value="2">Feminino 
       				  								<input name="sexo" type="radio" value="1">Masculino
       				  							</td>
       				  						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">Endere&ccedil;o:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="logradouro" type="text" id="logradouro" size="50" maxlength="50">
                        						</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">Bairro:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="bairro" type="text" id="bairro" size="30" maxlength="30">
                        						</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">CEP:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input type="text" id="cep" name="cep" onkeydown='return Tools.zipCodeKeyPress( event, this );'size="10" maxlength="9"/>
                        						</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">Cidade:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="cidade" type="text" id="cidade" value="Ourinhos" size="30" maxlength="30">
                        						</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">Estado:</td>
												<td width="70%" height="40" class="tabela-linha">
													<input id="uf" name="uf" type="text" value="SP" size="5" maxlength="5"/>
												</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">Data de Nascimento:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="nascimento" id="nascimento" onkeydown="return Util.dateKey(event);"/>
                        						</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">Natural de:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="naturalidade" type="text" id="naturalidade" size="30" maxlength="30"/>
                        						</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">RG:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="rg" type="text" id="rg" size="15" maxlength="12"/>
                        						</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">Telefone:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="fone" type="text" id="fone" size="15" maxlength="13"/>
												</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">E-mail:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="email" type="text" id="email" size="50" maxlength="50"/>
                        						</td>
                      						</tr>
					  						<tr> 
                        						<td width="30%" height="40" align="right" class="tabela-titulo style1 style2">N&ordm; de Matr&iacute;cula:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="matricula" type="text" id="matricula" size="10" maxlength="7"/>
                        						</td>
                      						</tr>
					  						<tr>
                        						<td colspan="2">
                        							<table width="100%">
                            							<tr>
	                              							<td>
    	                          								<div class="style7">
        	                      									<br/>DADOS DE LOGIN
            	                  								</div>
                	              							</td>
                    	        						</tr>
                        							</table>
                        						</td>
				      						</tr>
                      						<tr> 
                        						<td width="30%" height="40" class="tabela-titulo style1 style2">CPF:</td>
												<td width="70%" height="40" class="tabela-linha">
                        							<input name="cpf" id="cpf" type="text" size="50" maxlength="14"/>
                       							</td>
                      						</tr>
                      						<tr>
                        						<td height="40" class="tabela-titulo">Senha:</td>
                        						<td height="40" class="tabela-linha">
                        							<input name="senha" id="senha" type="password" size="20" maxlength="20" onkeypress="Util.passwordKey();">
                        						</td>
                      						</tr>
                      						<tr>
                        						<td height="40" class="tabela-titulo">Confirmação da senha:</td>
                        						<td height="40" class="tabela-linha">
                        							<input name="confirmacaosenha" type="password" size="20" maxlength="20">
                        						</td>
                      						</tr>  
                      						<tr>
                        						<td class="tabela-titulo">Nível de segurança:</td>
                        						<td class="tabela-linha">
                        							<div id="security-level">
                        								<label name="content-security-level" id="content-security-level">nenhum</label>
                        								<p>
                        									Esse campo exibi o nível de segurança da sua senha. 
                        									Para sua segurança utilize senhas com níveis entre forte e muito forte.
                        								</p>
                        							</div>
                        						</td>                      
                      						</tr>                    
					  						<tr align="center"> 
                        						<td height="65" colspan="2">
                        							<p>
                        								<a href="javascript: Util.cadastrar()" class="LinkLaranja">[Submeter dados ao SOSI]</a>
                        							</p>
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