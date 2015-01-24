<!DOCTYPE HTML PUBLIC "-//W3C//Dtd HTML 4.01 Transitional//EN" "http://www.w3.org/tr/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="shortcut icon" href="./images/icone.ico">
	<script type="text/javascript" src="./js/Util.js"></script>
	<style>
		@IMPORT url("css/redmond/jquery-ui-1.10.3.custom.min.css");
		@IMPORT url("css/main-form.css");
	</style>
</head>

<body onLoad="Util.onLoadLogin();">

	<form name="form" method="post">
		<div id="content">
			<div id="form">
				
				<h1>Sistema de Ordem de Serviço de Informática (SOSI)</h1>
				
				<div class="item">
					<label style="width: 52px !important">E-mail:</label>
					<input id="email" name="email" type="text"/>
				</div>
				
				<div class="item">
					<label style="width: 52px !important">Senha:</label>
					<input name="senha" type="password"/>
				</div>
				
				<div  class="item" style="position:absolute; margin-top: 5px; margin-left: 180px;">
					<input type="checkbox" name="loginadministrativo" value="true" />
					<b style="color: white">Login Administrativo</b>
				</div>

				<div>
					<button 
						style="padding: 5px !important; margin-left:350px;" 
						class="ui-button ui-widget ui-state-default ui-corner-all 
						ui-button-text-only ui-state-focus" onclick="Util.logar()">Entrar</a>
				</div>
			</div>
		</div>
	</form>
</body>
</html>
