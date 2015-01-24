<?php require_once("verificalogin.php"); VerificaNivel(4); ?>
<?php require_once('Connections/dbOS.php'); ?>
<?php require_once('Connections/dbComum.php'); ?>
<?php
mysql_select_db($database_dbComum, $dbComum);
$sql_DP = "select codigo_depto,nome_popular from comum.depto order by nome_popular";
$qry_DP = mysql_query($sql_DP, $dbComum) or die(mysql_error());
$row_DP = mysql_fetch_assoc($qry_DP);

mysql_select_db($database_dbOS, $dbOS);
$sql_AT = "select id,apelido from atendente order by apelido";
$qry_AT = mysql_query($sql_AT, $dbComum) or die(mysql_error());
$row_AT = mysql_fetch_assoc($qry_AT);

$ini = (isset($_POST['ini'])) ? $_POST['ini'] : Date('d/m/Y');
$fim = (isset($_POST['fim'])) ? $_POST['fim'] : Date('d/m/Y');
$dep = (isset($_POST['depto'])) ? $_POST['depto'] : '0';
$ate = (isset($_POST['atendente'])) ? $_POST['atendente'] : '0';
$ord = (isset($_POST['ordem'])) ? $_POST['ordem'] : 'data desc, hora desc';
   
$query_sql = "select os.id,os.data,os.hora,os.localizacao,dp.nome_popular,
                     os.requisitante,os.ramal,os.componente,co.descricao,
                     os.defeito,os.atendente,at.apelido
              from ordem_servico os, comum.depto dp, comp_defeito co, atendente at
              where os.localizacao=dp.codigo_depto and co.id=os.componente and
                    os.atendente=at.id and os.at='N' and (os.data between '".
					FormataDataDB($ini). "' and '".FormataDataDB($fim)."' ) ";

if ( (isset($_POST['atendente'])) && ($_POST['atendente'] != '') && ($_POST['atendente'] != '0') ) {
   $query_sql .= " and atendente = '". $_POST['atendente'] ."'";
}
if ( (isset($_POST['depto'])) && ($_POST['depto'] != '') && ($_POST['depto'] != '0') ) {
   $query_sql .= " and localizacao = '". $_POST['depto'] ."'";
}
					
$query_sql .= " order by ".$ord;
$sql = mysql_query($query_sql, $dbOS) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);

function FormataDataDB($data) {
   if ($data == '') {
      return '';
   } else {
      $dt = explode('/',$data);
      return $dt[2] . '-' . $dt[1] . '-'. $dt[0];
   }
}
function FormataData($data) {
   if ($data == '') {
      return '';
   } else {
      $dt = explode('-',$data);
      return $dt[2] . '/' . $dt[1] . '/'. $dt[0];
   }
}
?>
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>UNESP</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/scripts.js"></script>
<script language="javascript" src="js/mask.js"></script>
<script language="javascript">
function Enviar(vOrd) {
  document.form_periodo.ordem.value = vOrd;
  document.form_periodo.submit();
  return true;
}
</script>

</head>

<body>
    <?php include("cabe.php"); ?>
	<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
	     <th scope="col" align="center">
	     <form name="form_periodo" action="rel_ordens_servico.php" method="post" onsubmit="return verifica_rel_periodo(document.form_periodo)">
		 <h2 class="style5 style3 style8">Relat&oacute;rio de Ordens de Serviço</h2>
	     <table width="720" border="0" bgcolor="#E2E2E2" class="borda2">
			<tr>
		        <td class="style2">Data Inicial:</td>
		        <td>&nbsp;</td>
		        <td class="style2">Data Final:</td>
		        <td class="style2">Departamento:</td>
		        <td class="style2">Atendente:</td>
		        <td>&nbsp;</td>
		    </tr>
		    <tr>
		        <td><input name="ini" type="text" size="12" maxlength="10" value="<?php echo $ini; ?>" onKeyPress="return maskEvent(this, 10, '##/##/####', event)"></td>
        		<td><div align="center" class="style2">&nbsp;A&nbsp;</div></td>
		        <td><input name="fim" type="text" size="12" maxlength="10" value="<?php echo $fim; ?>" onKeyPress="return maskEvent(this, 10, '##/##/####', event)"></td>
		        <td><select name="depto" id="depto">
		            <option value="0">--- Selecione o departamento ---</option>
			        <?php do { ?>
  				    <option value="<?php echo $row_DP['codigo_depto']; ?>" <?php if(!strcmp($row_DP['codigo_depto'],$dep)){ echo 'selected'; } ?>><?php echo $row_DP['nome_popular']; ?></option>
      				<?php } while ($row_DP = mysql_fetch_assoc($qry_DP)); ?>
			        </select>
				</td>
		        <td><select name="atendente" id="atendente">
			        <option value="0">--- Selecione o atendente ---</option>
			        <?php do { ?>
  				    <option value="<?php echo $row_AT['id']; ?>" <?php if($row_AT['id']==$ate){ echo 'selected'; } ?>><?php echo $row_AT['apelido']; ?></option>
      				<?php } while ($row_AT = mysql_fetch_assoc($qry_AT)); ?>
			        </select>
				</td>
		        <td><div align="center">
					<input type="hidden" name="ordem" value="data desc, hora desc">
        			<input name="btnPesquisar" type="submit" class="caixa1" id="btnPesquisar" value="Pesquisar">
		        </div></td>
	         </tr>
			 <tr>
	    </table><br/>
		</form>
		<tr>
			<th>
				<table width="100%" border="1" cellspacing="0" bordercolor="#000000" class="borda2">
				    <tr bgcolor="#3879BD">
				      <td><a href="#" onClick="Enviar('data desc, hora desc')"><div align="center"><span class="style4">Data</span></div></a></td>
				      <td><div align="center"><span class="style4">Hora</span></div></td>
				      <td><a href="#" onClick="Enviar('nome_popular')"><div align="center"><span class="style4">Depto.</span></div></a></td>
				      <td><a href="#" onClick="Enviar('requisitante')"><div align="center"><span class="style4">Requisitante</span></div></a></td>
				      <td><a href="#" onClick="Enviar('ramal')"><div align="center"><span class="style4">Ramal</span></div></a></td>
				      <td><a href="#" onClick="Enviar('descricao')"><div align="center"><span class="style4">Componente</span></div></a></td>
				      <td><a href="#" onClick="Enviar('defeito')"><div align="center"><span class="style4">Defeito</span></div></a></td>
				      <td><a href="#" onClick="Enviar('apelido')"><div align="center"><span class="style4">Atendente</span></div></a></td>
				    </tr>
 	    		    <?php $i=0;  ?>
	    		    <?php do { ?>
	    		    <tr bgcolor="<?php echo (($i%2)==0)?'#EEF3F7':'#9FC0E1' ?>">
   		      	      <td align="center"><span class="style6"><?php echo FormataData($row_sql['data']); ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['hora']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['nome_popular']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['requisitante']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['ramal']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['descricao']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['defeito']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['apelido']; ?></span></td>
    		      </tr>
				  <?php $i++; ?>
	    		  <?php } while ($row_sql = mysql_fetch_assoc($sql)); ?>
	    		  <tr bgcolor="#3879BD"><td colspan="8"><span class="style4">&nbsp;</span></td></tr>
				</table>
    	        <p><a href="index.php" class="style5 style3"><< Voltar</a></p>
    		</th>
		</tr>		
	</table>
   <?php include("rodape.htm"); ?>
</body>
</html>
<?php
mysql_free_result($sql);
mysql_free_result($qry_AT);
mysql_free_result($qry_DP);
?>
