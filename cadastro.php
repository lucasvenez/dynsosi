<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>:: UNESP - Campus Experimental de Ourinhos ::</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	
	<link rel="shortcut icon" href="./images/icone.ico"/>
	
	<link href="./css/styles.css" rel="stylesheet" type="text/css"/>
	
	<link href="../folha.css" rel="stylesheet" type="text/css"/>
	<link href="../imprimir.css" rel="stylesheet" media="print" type="text/css"/>
	
	<script type="text/javascript" src="./js/Util.js"></script>
	
	<script type="text/javascript" src="./js/Ajax.js"></script>
	<script type="text/javascript" src="./js/Tools.js"></script>
	<script type="text/javascript" src="./js/ui/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="./js/ui/ui.datepicker.js"></script>
	<script type="text/javascript" src="./js/ui/i18n/ui.datepicker-pt-BR.js"></script>

</head>

<body onload="Util.onLoadCadastro();">

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
    	<td vAlign="top" width="615" colspan="2">

			<form name="form" onsubmit="return false;">
			
				<div class="title">SOSI (Sistema de Ordem de Servi&ccedil;o de Inform&aacute;tica) :::</div>
				<div id="mensagem"></div>
			
				<fieldset>
				
					<legend>Dados Pessoais</legend>

					<div>
						<div>
							<label>Nome:</label>
							<input type="text" id="nome" name="nome" maxlength="20"/>
						</div>
						
						<div>
							<label>Sobrenome:</label>
							<input type="text" id="sobrenome" name="sobrenome" maxlength="50"/>
						</div>
					</div>
																
					<div>
						<div>
							<label>Número de Matrícula:</label>
							<input type="text" id="matricula" name="matricula" maxlength="7"/>
						</div>
						
						<div>
							<label>Nascimento:</label>
							<input type="text" id="nascimento" onkeypress="return false" name="nascimento" class="inline"/>
						</div>
					</div>				
					
					<div>
						<div>
							<label>RG:</label>
							<input type="text" id="rg" name="rg"  maxlength="15"/>
						</div>
						
						<div>
							<label>Natural de:</label>
							<input type="text" id="naturalidade" name="naturalidade" maxlength="20"/>
						</div>

					</div>

					<div>
						<div>
							<label>Telefone:</label>
							<input type="text" id="fone" name="fone"  maxlength="13"/>
						</div>
						
						<div>
							<label>E-mail:</label>
							<input type="text" id="email" name="email" maxlength="40"/>
						</div>

					</div>											
					
					<div>
						<div>
							<label>Sexo:</label>
							
							<div class="inline">
								<input type="radio" name="sexo" value="1"/>
								<label>Masculino</label>
								
								<input type="radio" name="sexo" value="2"/>
								<label>Feminino</label>
							</div>
						</div>
						
					</div>											
						
				</fieldset>
	
				<fieldset>
				
					<legend>Endereço</legend>
					
					<div>
						<div>
							<label>CEP:</label>
							<input type="text" id="cep" name="cep"  class="inline"/>
							<a id="addressSearch" class="inline search" title="Buscar endereço"></a>
						</div>
						
						<div>
							<label>UF:</label>
							<select id="uf" name="uf">  
								<option value="AC">AC</option>  
								<option value="AL">AL</option>  
								<option value="AM">AM</option>  
								<option value="AP">AP</option>  
								<option value="BA">BA</option>  
								<option value="CE">CE</option>  
								<option value="DF">DF</option>  
								<option value="ES">ES</option>  
								<option value="GO">GO</option>  
								<option value="MA">MA</option>  
								<option value="MG">MG</option>  
								<option value="MS">MS</option>  
								<option value="MT">MT</option>  
								<option value="PA">PA</option>  
								<option value="PB">PB</option>  
								<option value="PE">PE</option>  
								<option value="PI">PI</option>  
								<option value="PR">PR</option>  
								<option value="RJ">RJ</option>  
								<option value="RN">RN</option>  
								<option value="RO">RO</option>  
								<option value="RR">RR</option>  
								<option value="RS">RS</option>  
								<option value="SC">SC</option>  
								<option value="SE">SE</option>  
								<option value="SP">SP</option>  
								<option value="TO">TO</option>  
							</select>
						</div>
					</div>
					
					<div>
						<div>
							<label>Cidade:</label>
							<input type="text" id="cidade" name="cidade" maxlength="30"/>
						</div>
						
						<div>
							<label>Bairro:</label>
							<input type="text" id="bairro" name="bairro" maxlength="30"/>
						</div>
					</div>
					
					<div>
						<div>
							<label>Logradouro:</label>
							<input type="text" id="logradouro" name="logradouro" maxlength="40"/>
						</div>
					</div>
					
				</fieldset>
				
				<fieldset>
				
					<legend>Dados de login</legend>
					
					<div>
						<label>CPF:</label>
						<input type="text" id="cpf" name="cpf" maxlength="11"/>
					</div>				
	
					<div>
						<div>
							<label>Senha:</label>
							<input type="password" id="senha" name="senha" maxlength="10"/>
							<div class="security-level">
								<h1>Nível de Segurança</h1>
								<p id="content-security-level">nenhum</p>
							</div>
						</div>
						
						<div>
							<label>Confirmação da senha:</label>
							<input type="password" id="confirmacao" name="confirmacao" maxlength="10"/>
						</div>
					</div>
								
				</fieldset>	
				
				<p class="buttons center">
					<a href="javascript: Util.cadastrar()" class="LinkLaranja">[Submeter dados ao SOSI]</a>
				</p>
			</form>      		
		</td>
	</tr>
</table>

<?php include "./ssi_rodape.php"; ?>

</body>
</html>