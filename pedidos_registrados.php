<?php
require_once("verificalogin.php"); VerificaNivel(1); 
require_once("Connections/dbOS.php");
mysql_select_db($database_dbOS, $dbOS);
			
$sql_opened     = "SELECT 
		              os.id, 
		              os.data, 
		              os.hora,  
		              os.requisitante, 
					  os.ramal, 
					  os.defeito,
                      os.solucao, 
		              co.descricao componente 
		           FROM ordem_servico os, comp_defeito co 
		           WHERE co.id = os.componente AND os.atendente = 0 
		              AND os.usuario='".$_SESSION['user']."' 
		           ORDER BY data DESC, hora DESC";

$sql_started    = "SELECT 
						os.id, 
						os.data,
						os.hora,
						os.requisitante,
						os.ramal,
						os.defeito,
			       		os.solucao,
						co.descricao AS componente,
						at.nome AS atendente
				   FROM 
						ordem_servico os, 
		 				comp_defeito co, 
						atendente at
				   WHERE 
						co.id=os.componente 
						AND os.atendente = at.id 
				  		AND os.usuario = '".$_SESSION['user']."' 
				  		AND os.at = 'N' 
				  		AND(data_baixa IS  NULL 
				  			 OR  data_baixa = '0000-00-00')  			
				   ORDER BY data DESC, hora DESC";

$sql_assistence = "SELECT 
						os.id, 
						os.data,
						os.hora,
						os.requisitante,
						os.ramal,
						os.defeito,
			       		os.solucao,
						co.descricao componente
				   FROM 
						ordem_servico os, 
		 				comp_defeito co, 
						atendente at
				   WHERE 
						co.id=os.componente 
						AND os.atendente = at.id 
				  		AND os.usuario = '".$_SESSION['user']."' 
				  		AND os.at = 'S' 
				  		AND(data_baixa IS  NULL 
				  			 OR  data_baixa = '0000-00-00')  			
				   ORDER BY data DESC, hora DESC";

$sql_finished   = "SELECT 
						os.id, 
						os.data,
						os.hora,
						os.requisitante,
						os.ramal,
						os.defeito,
			       		os.solucao,
						co.descricao componente
				   FROM 
						ordem_servico os, 
		 				comp_defeito co, 
						atendente at
				   WHERE 
						co.id=os.componente 
						AND os.atendente = at.id 
				  		AND os.usuario = '".$_SESSION['user']."' 
				  		AND (data_baixa IS NOT NULL 
				  			 AND  data_baixa <> '0000-00-00')  			
				   ORDER BY data DESC, hora DESC";

$qry_opened = mysql_query($sql_opened, $dbOS) or die(mysql_error());
$row_opened = mysql_fetch_assoc($qry_opened);

$qry_started = mysql_query($sql_started, $dbOS) or die(mysql_error());
$row_started = mysql_fetch_assoc($qry_started);

$qry_assistence = mysql_query($sql_assistence, $dbOS) or die(mysql_error());
$row_assistence = mysql_fetch_assoc($qry_assistence);

$qry_finished = mysql_query($sql_finished, $dbOS) or die(mysql_error());
$row_finished = mysql_fetch_assoc($qry_finished);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>UNESP</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
	$("#tabs").tabs();	

	$("button.detail").button({
		icons: {primary: "ui-icon-info"},
	    text: false
	}).click(function() {
		$("#info-" + $(this).attr("accesskey")).dialog("open");	
	});
	
	$("button.cancel").button({
		icons: {primary: "ui-icon-close"},
	    text: false		
	}).click(function() {
		var that = this;
		
		$.ajax({
			url  : "delete_service_order.php",
			data : {id: $(this).attr("accesskey")},
			type : "POST",
			beforeSend : function() {

				var result = false;
				
				if (confirm(
					"Você realmente deseja cancelar a ordem de serviço " + 
					$(that).attr("accesskey") + "?"))
					result = true;

				return result;
			}
		}).done(function(response) {

				if (response == "true") {
					alert("Ordem de serviço cancela com sucesso.");
					$(that).parents("tr").remove();
				} else {
					alert("Ação efetuada sem sucesso.");
				}
			}
		);
		
	});
	
	$(".details").dialog({
		autoOpen: false,
		modal: true
	});
});
</script>

<style>
@IMPORT url("./css/redmond/jquery-ui-1.10.3.custom.min.css");
@IMPORT url("./css/main-list.css");
@IMPORT url("./css/main-form.css");
</style>

</head>

<body>

	<div id="content">

		<div id="form" style="width: 550px !important">

			<h1>Ordens de Serviço</h1>

			<div id="tabs">
				<ul>
					<li><a href="#tabs-1">Em aberto</a></li>
					<li><a href="#tabs-2">Em andamento</a></li>
					<li><a href="#tabs-3">Enviadas para Assistência</a></li>
					<li><a href="#tabs-4">Finalizadas</a></li>
				</ul>
				<div id="tabs-1">
					<?php
					if (mysql_num_rows($qry_opened) <= 0) {
					?>
					<div class="ui-widget">
						<div class="ui-state-highlight ui-corner-all"
							style="margin-top: 20px; padding: 0 .7em;">
							<p>
								<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
								Não há ordens de serviço em aberto.
							</p>
						</div>
					</div>
					<?php 
					} else {
					?>
					<table class="list">
						<thead>
							<tr>
								<th>Código</th>
								<th>Data</th>
								<th>Hora</th>
								<th>Componente</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
					        <?php
					        do { ?>
							<tr
								bgcolor="<?= (!isset($cor) || $cor == "#EEF3F7") ? $cor = "#FFFFFF" : $cor = "#EEF3F7"; ?>">
								<td width="10%"><?= $row_opened['id']; ?></td>
								<td width="15%"><?php $a = explode("-", $row_opened['data']); echo $a[2]."/".$a[1]."/".$a[0]; ?></td>
								<td width="15%"><?= $row_opened['hora']; ?></td>
								<td width="40%"><?= $row_opened['componente']; ?></td>
								<td width="20%">
									<button class="cancel ui-state-error"
										accesskey="<?=$row_opened['id'];?>">Cancelar Ordem de Serviço</button>
								</td>
							</tr>
				        	<?php
					        } while ($row_opened = mysql_fetch_assoc($qry_opened)); ?>
				        </tbody>
					</table>
					<?php 
					}
					?>
				</div>
				<div id="tabs-2">
					<?php
					if (mysql_num_rows($qry_started) <= 0) {
					?>
					<div class="ui-widget">
						<div class="ui-state-highlight ui-corner-all"
							style="margin-top: 20px; padding: 0 .7em;">
							<p>
								<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
								Não há ordens de serviço em andamento.
							</p>
						</div>
					</div>
					<?php 
					} else {
					?>
					<table class="list">
						<thead>
							<tr>
								<th>Código</th>
								<th>Data</th>
								<th>Hora</th>
								<th>Componente</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
					        <?php
					        do { ?>
							<tr
								bgcolor="<?= ($cor == "#EEF3F7") ? $cor = "#FFFFFF" : $cor = "#EEF3F7"; ?>">
								<td width="10%"><?= $row_started['id']; ?></td>
								<td width="15%"><?php $a = explode("-", $row_started['data']); echo $a[2]."/".$a[1]."/".$a[0]; ?></td>
								<td width="15%"><?= $row_started['hora']; ?></td>
								<td width="40%"><?= $row_started['componente']; ?></td>
								<td width="20%">
									<button class="detail" accesskey="<?= $row_started['id'];?>">Detalhes</button>
									<div class="details" id="info-<?=$row_started['id'];?>"
										title="Detalhes da Ordem de Serviço <?=$row_started['id'] ?>">
										<p>
											<b>Atendente: </b>
							    		<?php 
							    		if ($row_started['atendente'] != "")
							    			echo $row_started['atendente'];
							    		else
							    			echo "Não há um atendente designado à ordem de serviço."
							    		?>
							    		</p>
										<hr />
										<p>
											<b>Defeito: </b><?=$row_started['defeito']?></p>
										<hr />
										<p>
											<b>Informações do atendente: </b>
							    		<?php
							    		if ($row_started['solucao'] != "")
							    			echo $row_started['solucao'];
							    		else
							    			echo "Não há informações adicionais fornecidas pelo atendente no momento.";
							    		?> 
							    		</p>
									</div>
								</td>
							</tr>
				        	<?php
					        } while ($row_started = mysql_fetch_assoc($qry_started)); ?>
				        </tbody>
					</table>
					<?php
					}
					?>
				</div>
				<div id="tabs-3">
					<?php
					if (mysql_num_rows($qry_assistence) <= 0) {
					?>
					<div class="ui-widget">
						<div class="ui-state-highlight ui-corner-all"
							style="margin-top: 20px; padding: 0 .7em;">
							<p>
								<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
								Não há ordens de serviço enviadas para assistência.
							</p>
						</div>
					</div>
					<?php 
					} else {
					?>
					<table class="list">
						<thead>
							<tr>
								<th>Código</th>
								<th>Data</th>
								<th>Hora</th>
								<th>Componente</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
					        <?php
					        do { ?>
							<tr
								bgcolor="<?= (!isset($cor) || $cor == "#EEF3F7") ? $cor = "#FFFFFF" : $cor = "#EEF3F7"; ?>">
								<td width="10%"><?= $row_assistence['id']; ?></td>
								<td width="15%"><?php $a = explode("-", $row_assistence['data']); echo $a[2]."/".$a[1]."/".$a[0]; ?></td>
								<td width="15%"><?= $row_assistence['hora']; ?></td>
								<td width="40%"><?= $row_assistence['componente']; ?></td>
								<td width="20%">
									<button class="detail" accesskey="<?= $row_assistence['id'];?>">Detalhes</button>
									<div class="details" id="info-<?=$row_assistence['id'];?>"
										title="Detalhes da Ordem de Serviço <?=$row_started['id'] ?>">
										<p>
											<b>Atendente: </b>
							    		<?php 
							    		if ($row_assistence['atendente'] != "")
							    			echo $row_assistence['atendente'];
							    		else
							    			echo "Não há um atendente designado à ordem de serviço."
							    		?>
							    		</p>
										<hr />
										<p>
											<b>Defeito: </b><?=$row_assistence['defeito']?></p>
										<hr />
										<p>
											<b>Informações do atendente: </b>
							    		<?php
							    		if ($row_assistence['solucao'] != "")
							    			echo $row_assistence['solucao'];
							    		else
							    			echo "Não há informações adicionais fornecidas pelo atendente no momento.";
							    		?> 
							    		</p>
									</div>
								</td>
							</tr>
				        	<?php
					        } while ($row_assistence = mysql_fetch_assoc($qry_assistence)); ?>
				        </tbody>
					</table>
					<?php 
					}
					?>
				</div>
				<div id="tabs-4">
					<?php
					if (mysql_num_rows($qry_finished) <= 0) {
					?>
					<div class="ui-widget">
						<div class="ui-state-highlight ui-corner-all"
							style="margin-top: 20px; padding: 0 .7em;">
							<p>
								<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
								Não há ordens de serviço finalizadas.
							</p>
						</div>
					</div>
					<?php 
					} else {
					?>
					<table class="list">
						<thead>
							<tr>
								<th>Código</th>
								<th>Data</th>
								<th>Hora</th>
								<th>Componente</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
					        <?php
					        do { ?>
							<tr
								bgcolor="<?= (!isset($cor) || $cor == "#EEF3F7") ? $cor = "#FFFFFF" : $cor = "#EEF3F7"; ?>">
								<td width="10%"><?= $row_finished['id']; ?></td>
								<td width="15%"><?php $a = explode("-", $row_finished['data']); echo $a[2]."/".$a[1]."/".$a[0]; ?></td>
								<td width="15%"><?= $row_finished['hora']; ?></td>
								<td width="40%"><?= $row_finished['componente']; ?></td>
								<td width="20%">
									<button class="detail" accesskey="<?= $row_finished['id'];?>">Detalhes</button>
									<div class="details" id="info-<?=$row_finished['id'];?>"
										title="Detalhes da Ordem de Serviço <?=$row_started['id'] ?>">
										<p>
											<b>Atendente: </b>
							    		<?php 
							    		if ($row_finished['atendente'] != "")
							    			echo $row_finished['atendente'];
							    		else
							    			echo "Não há um atendente designado à ordem de serviço."
							    		?>
							    		</p>
										<hr />
										<p>
											<b>Defeito: </b><?=$row_finished['defeito']?></p>
										<hr />
										<p>
											<b>Informações do atendente: </b>
							    		<?php
							    		if ($row_finished['solucao'] != "")
							    			echo $row_finished['solucao'];
							    		else
							    			echo "Não há informações adicionais fornecidas pelo atendente no momento.";
							    		?> 
							    		</p>
									</div>
								</td>
							</tr>
				        	<?php
					        } while ($row_finished = mysql_fetch_assoc($qry_finished)); ?>
				        </tbody>
					</table>
					<?php 
					}
					?>
				</div>
			</div>

			<a
				class="ui-state-error ui-button ui-widget ui-state-default ui-corner-all 
								ui-button-text-only ui-state-focus"
				style="padding: 5px !important; margin-top: 5px; margin-left: 90%"
				href="index.php">Voltar</a>
		</div>
	</div>
</body>
</html>
<?php mysql_free_result($qry_OS); ?>