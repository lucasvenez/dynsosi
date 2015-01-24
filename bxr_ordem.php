<?php require_once("verificalogin.php"); VerificaNivel(6); ?>
<?php require_once('Connections/dbOS.php'); ?>
<?php require_once('Connections/dbComum.php'); ?>
<?php
$nivel = $_SESSION['nivel'];

mysql_select_db($database_dbOS, $dbOS);
$sql_CO = "SELECT id,descricao from comp_defeito order by descricao";
$qry_CO = mysql_query($sql_CO, $dbOS) or die(mysql_error());
$row_CO = mysql_fetch_assoc($qry_CO);
$tot_CO = mysql_num_rows($qry_CO);
mysql_select_db($database_dbComum, $dbComum);
$sql_DP = "SELECT codigo_depto,nome_depto from depto order by nome_depto";
$qry_DP = mysql_query($sql_DP, $dbComum) or die(mysql_error());
$row_DP = mysql_fetch_assoc($qry_DP);
$tot_DP = mysql_num_rows($qry_DP);

mysql_select_db($database_dbOS, $dbOS);
$sql_PE = "SELECT id,nome from atendente order by nome";
$qry_PE = mysql_query($sql_PE, $dbOS) or die(mysql_error());
$row_PE = mysql_fetch_assoc($qry_PE);
$tot_PE = mysql_num_rows($qry_PE);

$id = (isset($_GET['id']))? $_GET['id'] : 0;

mysql_select_db($database_dbOS, $dbOS);
$sql_AT = "select * from ordem_servico where id=".$id;
$qry_AT = mysql_query($sql_AT, $dbOS) or die(mysql_error());
$row_AT = mysql_fetch_assoc($qry_AT);
$tot_AT = mysql_num_rows($qry_AT);

$cod = $row_AT['id'];	
$dat = ($row_AT['data']!='' && $row_AT['data']!='0000-00-00')?FormataData($row_AT['data']):Date('d/m/Y');
$hor = ($row_AT['hora']!='')?$row_AT['hora']:Date('H:m:s:');
$usu = ($row_AT['usuario']!='')?$row_AT['usuario']:$_SESSION['user'];
$loc = $row_AT['localizacao'];
$req = $row_AT['requisitante'];
$ram = $row_AT['ramal'];
$cop = $row_AT['componente'];
$ai  = $row_AT['ai'];
$pat = $row_AT['patrimonio'];
$com = $row_AT['comodato'];
$def = $row_AT['defeito'];
$sol = $row_AT['solucao'];
$ip  = ($row_AT['ip']!='')?$row_AT['ip']:$_SERVER['SERVER_ADDR']!=""?$_SERVER['SERVER_ADDR']:$_SERVER['REMOTE_ADDR'];;
$ate = $row_AT['atendente'];
$sal = $row_AT['sala'];

function FormataData($data) {
   $dt = explode('-',$data);
   return $dt[2] . '/' . $dt[1] . '/'. $dt[0];
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>UNESP</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style4 { color: #000000; 	}
-->
</style>
<script language="javascript" src="js/mask.js"></script>
<script language="javascript" src="js/scripts.js"></script>
<script language="javascript">
function vclick(vOp,vId) {
   document.form_bxr_ordem.op.value = vOp;
   document.form_bxr_ordem.id.value = vId; 
}
</script>
</head>
<body>
<?php include("cabe.php"); ?>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col">
    <h2 class="style5"><span class="style3 style17"><strong>Baixar Ordem de Serviço</strong></span></h2>
	<form name="form_bxr_ordem" id="form_bxr_ordem" method="post" action="man_ordem.php" onSubmit="return verifica_ordem_servico2(document.form_bxr_ordem)">
	  <table width="600" border="0" bgcolor="#ABC8E6" class="borda2" align="center">
	    <tr>
		  <td>&nbsp;<input name="id" type="hidden" id="id" value="<?php echo $cod; ?>"></td>
      	  <td>&nbsp;<input name="op" type="hidden" id="op" value=""></td>
	    </tr>
	    <tr>
	      <td><div align="right" class="style4">Data:&nbsp;</div></td>
	      <td align="left"><input name="data" type="text" class="borda2" id="data" size="12" maxlength="10" value="<?php echo $dat; ?>" readonly="true"></td>
	    </tr>
	    <tr>
	      <td><div align="right"><span class="style4">Hora:&nbsp;</span></div></td>
	      <td align="left"><input name="hora" type="text" class="borda2" id="hora2" size="12" maxlength="8" value="<?php echo $hor; ?>" readonly="true"></td>
    	</tr>
	    <tr>
	      <td><div align="right" class="style4">Usu&aacute;rio:&nbsp;</div></td>
	      <td align="left"><input name="usuario" type="text" class="borda2" id="usuario" size="18" maxlength="14" value="<?php echo $usu; ?>" readonly="true"></td>
	    </tr>
	    <tr>
	      <td><div align="right"><span class="style4">IP:&nbsp;</span></div></td>
	      <td align="left"><input name="ip" type="text" class="borda2" id="ip2" size="20" maxlength="15" value="<?php echo $ip; ?>" readonly="true"></td>
	    </tr>
	    <tr>
	      <td colspan="2"><hr noshade class="borda2"></td>
	    </tr>
	    <tr>
	      <td><div align="right" class="style4">Localiza&ccedil;&atilde;o:&nbsp;</div></td>
          <td align="left">
  		     <?php if ($nivel == 1) { ?>
		     <select name="CodigoDepto" class="borda2" id="CodigoDepto">
 		      	<?php do { ?>
  			       <option value="<?php echo $row_DP['codigo_depto']; ?>"<?php if (strcmp($row_DP['codigo_depto'],$loc)==0) { echo ' selected'; } ?>><?php echo $row_DP['nome_depto']; ?></option>
      			 <?php } while ($row_DP = mysql_fetch_assoc($qry_DP)); ?>
            </select>
			<?php } else { ?>
			  <input name="CodigoDepto" type="hidden" value="<?php echo $loc; ?>">
			  <?php do { 
			        if ($row_DP['codigo_depto'] == $loc) { ?>
  			          <input name="localizacao" type="text" class="borda2" value="<?php echo $row_DP['nome_depto']; ?>" size="75" readonly="True">
      			 <?php }  ?>
      		  <?php } while ($row_DP = mysql_fetch_assoc($qry_DP)); ?>					  
			<?php } ?>
		  </td>
        </tr>
		<tr>
	      <td class="style5"><div align="right" class="style4">Sala:&nbsp;</div></td>
	      <td align="left"><input name="sala" type="text" class="borda2" id="sala" value="<?php echo $sal; ?>" size="40" maxlength="30" readonly="<?php echo ($nivel==1)?"False":"True"; ?>"></td>
	    </tr>
	    <tr>
	      <td><div align="right" class="style4">Requisitante:&nbsp;</div></td>
	      <td align="left"><input name="requisitante" type="text" class="borda2" id="requisitante" size="60" maxlength="50" value="<?php echo $req; ?>" readonly="<?php echo ($nivel==1)?"False":"True"; ?>"></td>
	    </tr>
	    <tr>
	      <td><div align="right"><span class="style4">Ramal:&nbsp;</span></div></td>
    	  <td align="left"><input name="ramal" type="text" class="borda2" id="ramal2" size="8" maxlength="4" value="<?php echo $ram; ?>"></td>
	    </tr>
	    <tr>
	      <td><div align="right"><span class="style4">AI:&nbsp;</span></div></td>
	      <td align="left"><input name="ai" type="text" class="borda2" id="ai" size="15" maxlength="10" value="<?php echo $ai; ?>"></td>
	    </tr>
	    <tr>
	      <td><div align="right"><span class="style4">Patrim&ocirc;nio:&nbsp;</span></div></td>
	      <td align="left"><input name="patrimonio" type="text" class="borda2" id="patrimonio2" size="15" maxlength="10" value="<?php echo $pat; ?>"></td>
	    </tr>
	    <tr>
	      <td><div align="right"><span class="style4">Comodato:&nbsp;</span></div></td>
	      <td align="left"><input name="comodato" type="text" class="borda2" id="comodato2" size="15" maxlength="10" value="<?php echo $com; ?>"></td>
	    </tr>
	    <tr>
	      <td><div align="right" class="style4">Componente:&nbsp;</div></td>
          <td align="left">
		    <select name="CodigoComponente" class="borda2" id="CodigoComponente">
			      <?php do { ?>
  			        <option value="<?php echo $row_CO['id']; ?>"<?php if ($row_CO['id']==$cop) { echo ' selected'; } ?>><?php echo $row_CO['descricao']; ?></option>
      			  <?php } while ($row_CO = mysql_fetch_assoc($qry_CO)); ?>
            </select>
  		  </td>
		</tr>
	    <tr>
	      <td valign="middle"><div align="right" class="style4">Defeito:&nbsp;</div></td>
	      <td align="left"><textarea name="defeito" cols="60" rows="6" class="borda2" id="defeito"><?php echo $def; ?></textarea></td>
	    </tr>
		<?php if (isset($_GET['id'])) { ?>
	    <tr>
	      <td><div align="right" class="style4">Atendente:&nbsp;</div></td>
	      <td align="left">
		    <?php if ($nivel == 1) { ?>
		    <select name="atendente" class="borda2" id="atendente">
			      <?php do { ?>
  			        <option value="<?php echo $row_PE['id']; ?>"<?php if ($row_PE['id']==$ate) { echo ' selected'; } ?>><?php echo $row_PE['nome']; ?></option>
      			  <?php } while ($row_PE = mysql_fetch_assoc($qry_PE)); ?>
            </select>
			<?php } else { ?>
			  <input name="atendente" type="hidden" value="<?php echo $ate; ?>">
			  <?php do { 
			        if ($row_PE['id'] == $ate) { ?>
  			          <input name="nomeatend" type="text" size="20" class="borda2" value="<?php echo $row_PE['nome']; ?>" readonly="True">
      			 <?php }  ?>
      		  <?php } while ($row_PE = mysql_fetch_assoc($qry_PE)); ?>					  
			<?php } ?>
		  </td>
		</tr>
	    <tr>
	      <td valign="middle"><div align="right" class="style4">Solução:&nbsp;</div></td>
	      <td align="left"><textarea name="solucao" cols="60" rows="6" class="borda2" id="solucao"><?php echo $sol; ?></textarea></td>
	    </tr>
		<?php } ?>
		<tr>
          <td>&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
	      <td colspan="3" align="left">
		  	  <input name="btnBaixar" type="submit" class="caixa1" id="btnBaixar" value="B A I X A R" onClick="vclick('B',<?php echo $cod; ?>)">&nbsp;
		      <input name="btnLimpar" type="reset" class="caixa1" id="btnLimpar" value="L I M P A R">&nbsp;&nbsp;&nbsp;
      		  <input name="btnEAT" type="submit" class="caixa1" id="btnEAT" value="Encaminhar p/ Assistência Técnica" onClick="vclick('A',<?php echo $cod; ?>)">     
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
    </table>
	</form>
	<p><a href="ordens_servico_abertas.php" class="style5 style3"><strong>&lt;&lt; Voltar</strong></a></p>
    </th>
  </tr>
</table>
<?php include("rodape.htm"); ?>
</body>
</html>
<?php mysql_free_result($qry_AT);?>
<?php mysql_free_result($qry_CO);?>
<?php mysql_free_result($qry_DP);?>
<?php mysql_free_result($qry_PE);?>