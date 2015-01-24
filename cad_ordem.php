<?php 
require_once("verificalogin.php"); VerificaNivel(1); 
require_once('Connections/dbComum.php');
require_once('./Connections/dbOS.php'); 

mysql_select_db($database_dbOS, $dbOS);
$sql_CO = "SELECT id, descricao FROM comp_defeito ORDER BY descricao";
$qry_CO = mysql_query($sql_CO, $dbOS) or die(mysql_error());
$row_CO = mysql_fetch_assoc($qry_CO);

mysql_select_db($database_dbComum, $dbComum);
$sql_DP = "SELECT codigo_depto,nome_depto,nome_popular FROM depto ORDER BY nome_depto";
$qry_DP = mysql_query($sql_DP, $dbComum) or die(mysql_error());
$row_DP = mysql_fetch_assoc($qry_DP);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>UNESP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>

	<script type="text/javascript">

	var updateDateTime = function() {

		var d = new Date();

		months = ["janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", 
		  		  "agosto", "setembro", "outubro", "novembro", "dezembro"];

		date   = d.getDate() + " de " + months[d.getMonth()] + " de " + d.getFullYear();
		
		time   = (d.getHours()   < 10 ? "0" + d.getHours()   : d.getHours())   + ":" + 
				 (d.getMinutes() < 10 ? "0" + d.getMinutes() : d.getMinutes()) + ":" + 
				 (d.getSeconds() < 10 ? "0" + d.getSeconds() : d.getSeconds());

		$("#date").text(date);
		$("#time").text(time);

		setTimeout(updateDateTime, 1000);
	};

	var onLoad = function() {
		updateDateTime();
	}

	var validation = function() {

		var result = true;
		
		$(".item input, .item select, .item textarea").removeClass("invalid-value");
		
		if ($("#location").val() == 0)
			$("#location").addClass("invalid-value");

		if ($("#component").val() == 0)
			$("#component").addClass("invalid-value");

		if (isNaN(parseInt($("#phone").val())))
			$("#phone").addClass("invalid-value");

		if ($("#problem").val().trim() == "")
			$("#problem").addClass("invalid-value");

		if ($("#room").val().trim() == "")
			$("#room").addClass("invalid-value");

		if ($(".invalid-value").size() > 0) {
			result = false;
			alert("Há valores inválidos em seu formulário. Os campos destacados devem ser corrigidos.");
		}

		return result;
	};
	
	</script>
	
	<style type="text/css">
		@IMPORT url("./css/redmond/jquery-ui-1.10.3.custom.min.css");
		@IMPORT url("./css/main-form.css");
	</style>
</head>

<body onload="onLoad();">

	<form name="form_cad_ordem" method="post" action="inc_ordem.php" onSubmit="return validation();">
		  
		<div id="content">
			<div id="form">
				
				<h1>Cadastro de Nova Ordem de Serviço</h1>
				
				<div class="item">
				
					<label>Requisitante:</label>
					<span><?php echo $_SESSION['nome'] ?></span>

					<input name="requisitante" type="hidden" 
						id="usuario" value="<?php echo $_SESSION['nome'] ?>"
					/>
					
					<input name="usuario" type="hidden" 
						id="usuario" value="<?php echo $_SESSION['user'] ?>"
					/>
					
				</div>										
				
				<div class="item">
					<label>Data:</label>
					<span id="date"></span>
				</div>

				<div class="item">
					<label>Hora:</label>
					<span id="time"></span>
				</div>
				
				<div class="item">
					<label>Endereço IP:</label>
					<span>
						<?php echo $_SERVER['REMOTE_ADDR'] != "" ? $_SERVER['REMOTE_ADDR'] : $_SERVER['SERVER_ADDR']; ?>
					</span>
					<input type="hidden" name="ip"
					       value="<?php echo $_SERVER['REMOTE_ADDR'] != "" ? $_SERVER['REMOTE_ADDR'] : $_SERVER['SERVER_ADDR']; ?>"/>
				</div>
				
				<hr/>
				
				<div class="item">
					<label>Localização:</label>
					<select name="localizacao" id="location">
						<option value="0"></option>
	 		      		<?php do { ?>
							<option
								value="<?php echo $row_DP['codigo_depto']; ?>"
								<?php if ($row_DP['codigo_depto'] == $_SESSION['depto']) { echo ' selected'; } ?>
							>
								<?php echo $row_DP['nome_depto']; ?>
							</option>
						<?php } while ($row_DP = mysql_fetch_assoc($qry_DP)); ?>
					</select>			
				</div>
				
				<div class="item">
					<label>Prédio/Sala:</label>
					<input name="sala" type="text" id="room" maxlength="20"/>
				</div>
				
				<div class="item">
					<label>Ramal:</label>
					<input name="ramal" type="text" id="phone" maxlength="4"/>
				</div>
				
				<div class="item">
					<label>Componente:</label>
					<select name="componente" id="component">
                        <option value="0" selected></option>
		                <?php do { ?>
 	                    <option value="<?php echo $row_CO['id']; ?>"
 	                    	<?php if ($row_CO['id'] == $cop) { echo ' selected'; } ?>
 	                    >
 	                    	<?php echo $row_CO['descricao']; ?>
 	                    </option>
			            <?php } while ($row_CO = mysql_fetch_assoc($qry_CO)); ?>
                    </select>
				</div>
				
				<div class="item">
					<label>Defeito:</label>
					<textarea name="defeito" cols="45" rows="6" id="problem"></textarea>
				</div>
				
				<div class="botton">
					<a href="index.php" style="padding: 5px !important; margin-left:150px;" 
						class="ui-state-error ui-button ui-widget ui-state-default ui-corner-all 
						ui-button-text-only ui-state-focus">Cancelar</a>
						
					<input style="background-color: red; padding: 5px !important; 
					    margin-top: -28px; margin-left:237px;" 
						class="ui-button ui-widget ui-state-default ui-corner-all 
						ui-button-text-only ui-state-focus"
						name="btnCadastrar" type="submit"id="btnEnviar" value="Registrar Ordem de Serviço"/>
				</div>
				
			</div>
		</div>
		  
	</form>
    
</body>
</html>
<?php mysql_free_result($qry_DP);?>