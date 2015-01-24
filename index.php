<?php 
	require_once("verificalogin.php"); 
	VerificaNivel(5); 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>UNESP - Universidade Estadual Paulista</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link href="http://code.jquery.com/jquery-1.11.0.min.js" rel="stylesheet" type="text/css"/>

<style type="text/css">
@IMPORT url("css/redmond/jquery-ui-1.10.3.custom.min.css");
@IMPORT url("./css/main-form.css");
</style>

<script language="javascript" src="js/scripts.js"></script>

<script language="javascript" type="text/javascript">
	var ok = false;
	var ok2 = false;
	
	function exibir(xOp) {
		
		if (ok == false) {

			if (xOp) {
				
				menu_cadastro = "<menu id='cadastro_submenu'>"                                                +
					               "<li><a href=\"cons_atendente.php\">Atendentes</a></li>"                   +
					               "<li><a href=\"cons_componente.php\">Componentes</a></li>"                 +
					               "<li><a href=\"cons_empresa.php\">Empresas</a></li>"                       +
					               "<li><a href=\"cons_levto.php\">Equipamentos</a></li>"                     +
					               "<li><a href=\"cons_instituicao.php\">Institui&ccedil;&otilde;es</a></li>" +
					            "</menu>";
			
			} else {
				
				menu_cadastro = "<menu id='cadastro_submenu'>"                                                +
								   "<li><a href=\"cons_atendente.php\">Atendentes</a></li>"                   +
								   "<li><a href=\"cons_componente.php\">Componentes</a></li>"                 +
								   "<li><a href=\"cons_empresa.php\">Empresas</a></li>"                       +
								   "<li><a href=\"cons_instituicao.php\">Institui&ccedil;&otilde;es</a></li>" +
								   "</menu>";
			}
			
           	$("#cadastro").append($(menu_cadastro));
		   	ok = true;
		   	
		} else {
			
			alvo = null;
			ok   = false;
            $("#cadastro_submenu").remove();
            
		}
		
		return false;
	}
	
	function exibir2() {
		
		if (ok2 == false) {
			
			menu_relatorio  = 
			"<menu id='menu_relatorio'>"                                                              +
				"<li><a href=\"rel_ordens_servico.php\">Ordens de Serviço</a><li>"                    +
			 	"<li><a href=\"rel_ordens_servico_baixadas.php\">Ordens de Serviço Baixadas</a><li>"  +
			 	"<li><a href=\"rel_ordens_servico_ai.php\">Ordens de Serviço por Equipamento</a><li>" +
			 	"<li><a href=\"rel_ordens_servico_assistencia_tecnica.php\">Ordens de Serviço encaminhadas para Assistência Técnica</a><li>" +
			 	"<li><a href=\"rel_estatistica.php\">Estatística</a><li>"                             +
			 	"<li><a href=\"rel_equipamento.php\">Equipamentos</a><li>"                            +
			"</menu>";

            $("#relatorio").append($(menu_relatorio));			
			ok2 = true;

		} else {
			
			alvo2 = null;
			ok2 = false;
			$("#menu_relatorio").remove();	
					
		}
		
		return false;
	}
</script>

</head>
<body>

<form name="frm_menu" method="post" action="sair.php" onSubmit="return excluir('Deseja sair do Sistema?')">
		
	<div id="content">
		<div id="form">
		
			<h1>Menu</h1>
		
			<menu>
			
			<?php if (isset($_SESSION) ) if ($_SESSION['nivel'] == 1) { ?>	
				<li id="cadastro"><a href="index.php" onClick="return exibir(1)">Cadastros</a></li>
				<li><a href="ordens_servico_abertas.php">Ordens de Serviço em Aberto</a></li>
				<li><a href="ordens_servico_baixadas.php">Ordens de Serviço Baixadas</a></li>
				<li><a href="assistencia_tecnica.php">Assist&ecirc;ncia T&eacute;cnica</a></li>
				<li id="relatorio"><a href="index.php" onClick="return exibir2()">Relat&oacute;rios</a></li>
			<?php } else { ?>
				<li><a href="cad_ordem.php">Cadastro de Nova Ordem de Servi&ccedil;o</a></li>
				<li><a href="pedidos_registrados.php">Pedidos de Ordem de Servi&ccedil;o Registrados</a></li>
			<?php } ?>
			
			</menu>
			
			<a href="sair.php"
				style="padding: 5px !important; margin-left:420px;" 
				class="ui-button ui-widget ui-state-default ui-corner-all 
				ui-button-text-only ui-state-focus">Sair</a>
		</div>
	</div>
</form>
</body>
</html>
