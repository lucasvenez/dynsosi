<?php
require_once('charts.php'); 

$ini = (isset($_POST['dtinicial'])) ? $_POST['dtinicial'] : Date('d/m/Y');
$fim = (isset($_POST['dtfinal'])) ? $_POST['dtfinal'] : Date('d/m/Y');
$gra = (isset($_POST['grafico'])) ? $_POST['grafico'] : 'O';
$tot = (isset($_POST['total'])) ? $_POST['total'] : 'O';

//$tot = ($tot<20) ? 20 : $tot;
$link = "grafico.php?ini=".$ini."&fim=".$fim."&gra=".$gra;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
	<title>UNESP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="estilos.css" rel="stylesheet" type="text/css">
	<script language="JavaScript" src="./js/Util.js" type="text/JavaScript"></script>
</head>

<body>
	<?php include("cabe.php"); ?>
	<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<th>
				<h2 class="style5 style3 style8">ORDENS DE SERVIÇO</h2>
					
				<p>Total de Ordens de Serviço: <?php echo $tot ?></p>	
				
				<div id="gamb" style="position: absolute; height: 240px; overflow:hidden">
					
					<table width="500" height="240px" border="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
					
				</div>
		   
				<?php echo InsertChart( "charts.swf", "charts_library", $link, 500, 240, "", true ); ?>
    		</th>
		</tr>		
	</table>
    
    <p align="center">
		<a href="javascript:history.back(-1)" class="style14">&lt;&lt; Voltar</a>
    </p>
    
    <?php include("rodape.htm"); ?>
</body>
</html>
