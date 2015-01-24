<?php require_once("verificalogin.php"); VerificaNivel(4); ?>
<?php require_once('Connections/dbOS.php'); ?>
<?php require_once('Connections/dbComum.php'); ?>
<?php
mysql_select_db($database_dbComum, $dbComum);
$sql_DP = "select codigo_depto,nome_popular from depto order by nome_popular";
$qry_DP = mysql_query($sql_DP, $dbComum) or die(mysql_error());
$row_DP = mysql_fetch_assoc($qry_DP);

mysql_select_db($database_dbOS, $dbOS);
$sql_AT = "select id,apelido from atendente order by apelido";
$qry_AT = mysql_query($sql_AT, $dbOS) or die(mysql_error());
$row_AT = mysql_fetch_assoc($qry_AT);

$sql_EM = "select id,descricao from empresa order by descricao";
$qry_EM = mysql_query($sql_EM, $dbOS) or die(mysql_error());
$row_EM = mysql_fetch_assoc($qry_EM);

$ini = (isset($_POST['ini'])) ? $_POST['ini'] : Date('d/m/Y');
$fim = (isset($_POST['fim'])) ? $_POST['fim'] : Date('d/m/Y');
$emp = (isset($_POST['empresa'])) ? $_POST['empresa'] : '0';
$dep = (isset($_POST['depto'])) ? $_POST['depto'] : '0';
$ate = (isset($_POST['atendente'])) ? $_POST['atendente'] : '0';
$ord = (isset($_POST['ordem'])) ? $_POST['ordem'] : 'data desc, hora desc';
   
$query_sql = "select os.data_e,os.data,os.localizacao,dp.nome_popular,
		       os.requisitante,os.ramal,os.componente,co.descricao,
		       os.defeito,os.atendente,at.apelido,os.ai,os.patrimonio,
		       os.data_s,em.id empresa,em.descricao nempresa,em.telefone
			  from ordem_servico os, comum.depto dp, comp_defeito co,
		           atendente at,empresa em
              where os.localizacao=dp.codigo_depto and co.id=os.componente and
                    os.atendente=at.id and em.id=os.empresa and os.at='S'  
					and os.empresa>0 and (os.data_e between '".
					FormataDataDB($ini). "' and '".FormataDataDB($fim)."' ) ";

if ( (isset($_POST['atendente'])) && ($_POST['atendente'] != '') && ($_POST['atendente'] != '0') ) {
   $query_sql .= " and atendente = '". $_POST['atendente'] ."'";
}
if ( (isset($_POST['depto'])) && ($_POST['depto'] != '') && ($_POST['depto'] != '0') ) {
   $query_sql .= " and localizacao = '". $_POST['depto'] ."'";
}
if ( (isset($_POST['empresa'])) && ($_POST['empresa'] != '') && ($_POST['empresa'] != '0') ) {
   $query_sql .= " and empresa = '". $_POST['empresa'] ."'";
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
   if (($data == '') || ($data == '0000-00-00')) {
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
	     <form name="form_periodo" action="rel_ordens_servico_assistencia_tecnica.php" method="post" onsubmit="return verifica_rel_periodo(document.form_periodo)">
		 <h2 class="style5 style3 style8">Relat&oacute;rio de Ordens de Serviço encaminhadas a Assistência Técnica</h2>
	     <table width="720" border="0" bgcolor="#E2E2E2" class="borda2">
			<tr>
		        <td colspan="2" class="style2">Per&iacute;odo:&nbsp;
		          <input name="ini" type="text" size="12" maxlength="10" value="<?php echo $ini; ?>" onKeyPress="return maskEvent(this, 10, '##/##/####', event)">&nbsp;A&nbsp;
		          <input name="fim" type="text" size="12" maxlength="10" value="<?php echo $fim; ?>" onKeyPress="return maskEvent(this, 10, '##/##/####', event)">
		        </td>
		        <td class="style2"><div align="right">Empresa:&nbsp;</div></td>
		        <td class="style2">
				   <select name="empresa" id="empresa">
		            <option value="0">--- Selecione uma empresa ---</option>
			        <?php do { ?>
  				    <option value="<?php echo $row_EM['id']; ?>" <?php if($row_EM['id']==$emp){ echo 'selected'; } ?>><?php echo $row_EM['descricao']; ?></option>
      				<?php } while ($row_EM = mysql_fetch_assoc($qry_EM)); ?>
			       </select>
				</td>
		    </tr>
		    <tr>
		        <td><span class="style2">Departamento:&nbsp;</span></td>
		        <td><span class="style2">
		            <select name="depto" id="depto">
		            <option value="0">--- Selecione o departamento ---</option>
			        <?php do { ?>
  				    <option value="<?php echo $row_DP['codigo_depto']; ?>" <?php if($row_DP['codigo_depto']==$dep){ echo 'selected'; } ?>><?php echo $row_DP['nome_popular']; ?></option>
      				<?php } while ($row_DP = mysql_fetch_assoc($qry_DP)); ?>
			        </select>
				</td>
		        <td><div align="right"><span class="style2">Atendente:&nbsp;</span></div></td>
		        <td><select name="atendente" id="atendente">
			        <option value="0">--- Selecione o atendente ---</option>
			        <?php do { ?>
  				    <option value="<?php echo $row_AT['id']; ?>" <?php if($row_AT['id']==$ate){ echo 'selected'; } ?>><?php echo $row_AT['apelido']; ?></option>
      				<?php } while ($row_AT = mysql_fetch_assoc($qry_AT)); ?>
			        </select>
			        &nbsp;
					<input type="hidden" name="ordem" value="data desc, hora desc">
					<input name="btnPesquisar" type="submit" class="caixa1" id="btnPesquisar" value="Pesquisar">
				</td>
	         </tr>
	    </table><br/>
		</form>
		</th>
	 </tr>
	 <tr>
		<th>
			<table width="100%" border="1" cellspacing="0" bordercolor="#000000" class="borda2">
			    <tr bgcolor="#3879BD">
			      <td><a href="#" onClick="Enviar('data_e desc')"><div align="center"><span class="style4">Entrada</span></div></a></td>
			      <td><a href="#" onClick="Enviar('data desc, hora desc')"><div align="center"><span class="style4">OS</span></div></a></td>
			      <td><a href="#" onClick="Enviar('nome_popular')"><div align="center"><span class="style4">Depto.</span></div></a></td>
			      <td><a href="#" onClick="Enviar('ai')"><div align="center"><span class="style4">AI</span></div></a></td>
			      <td><a href="#" onClick="Enviar('patrimonio')"><div align="center"><span class="style4">Patrimônio</span></div></a></td>
			      <td><a href="#" onClick="Enviar('co.descricao')"><div align="center"><span class="style4">Componente</span></div></a></td>
			      <td colspan="2"><a href="#" onClick="Enviar('em.descricao')"><div align="center"><span class="style4">Empresa</span></div></a></td>
			      <td><div align="center"><span class="style4">Defeito</span></div></td>
			      <td><div align="center"><span class="style4">Solução</span></div></td>
			      <td><a href="#" onClick="Enviar('apelido')"><div align="center"><span class="style4">Atendente</span></div></a></td>
			      <td><a href="#" onClick="Enviar('data_s desc')"><div align="center"><span class="style4">Saída</span></div></a></td>
			    </tr>
    		    <?php $i=0;  ?>
    		    <?php do { ?>
    		    <tr bgcolor="<?php echo (($i%2)==0)?'#EEF3F7':'#9FC0E1' ?>">
	      	      <td align="center"><span class="style6"><?php echo FormataData($row_sql['data_e']); ?></span></td>
	      	      <td align="center"><span class="style6"><?php echo FormataData($row_sql['data']); ?></span></td>
	      	      <td align="center"><span class="style6"><?php echo $row_sql['nome_popular']; ?></span></td>
   		   	      <td align="center"><span class="style6"><?php echo $row_sql['ai']; ?></span></td>
   		   	      <td align="center"><span class="style6"><?php echo $row_sql['patrimonio']; ?></span></td>
   		   	      <td align="center"><span class="style6"><?php echo $row_sql['descricao']; ?></span></td>
   		   	      <td align="center"><span class="style6"><?php echo $row_sql['nempresa']; ?></span></td>
   		   	      <td align="center"><span class="style6"><?php echo $row_sql['telefone']; ?></span></td>
   		   	      <td align="center"><span class="style6"><?php echo $row_sql['defeito']; ?></span></td>
   		   	      <td align="center"><span class="style6"><?php echo $row_sql['solucao']; ?></span></td>
   		   	      <td align="center"><span class="style6"><?php echo $row_sql['apelido']; ?></span></td>
   		   	      <td align="center"><span class="style6"><?php echo FormataData($row_sql['data_s']); ?></span></td>
    		    </tr>
			   <?php $i++; ?>
	    	   <?php } while ($row_sql = mysql_fetch_assoc($sql)); ?>
     		   <tr bgcolor="#3879BD"><td colspan="12"><span class="style4">&nbsp;</span></td></tr>
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
mysql_free_result($qry_EM);
mysql_free_result($qry_DP);
?>
