<?php
require_once("verificalogin.php"); VerificaNivel(4); 
require_once('Connections/dbOS.php'); 

mysql_select_db($database_dbOS, $dbOS);
$sql_EM = "SELECT id,descricao from empresa order by descricao";
$qry_EM = mysql_query($sql_EM, $dbOS) or die(mysql_error());
$row_EM = mysql_fetch_assoc($qry_EM);
$tot_EM = mysql_num_rows($qry_EM);

$id = (isset($_POST['id']))? $_POST['id'] : 0;

mysql_select_db($database_dbOS, $dbOS);
$sql_AT = "select os.*,dp.nome_depto,co.descricao,at.apelido
              from ordem_servico os, comum.depto dp, comp_defeito co, atendente at
              where os.localizacao=dp.codigo_depto and co.id=os.componente and
                    os.atendente=at.id and os.at='S' and os.id=".$id;

$qry_AT = mysql_query($sql_AT, $dbOS) or die(mysql_error());
$row_AT = mysql_fetch_assoc($qry_AT);
$tot_AT = mysql_num_rows($qry_AT);

$cod = $row_AT['id'];	
$dat = FormataData($row_AT['data']);
$hor = $row_AT['hora'];
$usu = $row_AT['usuario'];
$loc = $row_AT['nome_depto'];
$req = $row_AT['requisitante'];
$ram = $row_AT['ramal'];
$cop = $row_AT['descricao'];
$ai  = $row_AT['ai'];
$pat = $row_AT['patrimonio'];
$com = $row_AT['comodato'];
$def = $row_AT['defeito'];
$sol = $row_AT['solucao'];
$ip  = $row_AT['ip'];
$ate = $row_AT['apelido'];
$sal = $row_AT['sala'];
$emp = $row_AT['empresa'];
$dte = FormataData($row_AT['data_e']);
$dts = FormataData($row_AT['data_s']);
$fi  = $row_AT['fi'];

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
<style type="text/css">
<!--
.style4 { color: #000000; 	}
-->
</style>
<script language="javascript" src="js/mask.js"></script>
<script language="javascript" src="js/scripts.js"></script>
<script language="javascript">
function vclick(vOp) {
   document.form_cons_assistencia.op2.value = vOp;  
}
</script>
</head>
<body>
<?php include("cabe.php"); ?>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col">
    <h2 class="style5"><span class="style3 style17"><strong>Detalhes da Ordem de Servi&ccedil;o<br/>
    encaminhada para Assist&ecirc;ncia T&eacute;cnica</strong></span></h2>
	<form name="form_cons_assistencia" id="form_cons_assistencia" method="post" action="man_ordem.php" onSubmit="return verifica_ordem_servico3(document.form_cons_assistencia)">
	  <table width="600" border="0" bgcolor="#ABC8E6" class="borda2" align="center">
	    <tr>
		  <td>&nbsp;<input name="id" type="hidden" id="id" value="<?php echo $cod; ?>"></td>
      	  <td>&nbsp;<input name="op" type="hidden" id="op" value="T"><input name="op2" type="hidden" id="op2" value=""></td>
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
          <td align="left"><input name="localizacao" type="text" class="borda2" id="localizacao" size="60" maxlength="50" value="<?php echo $loc; ?>" readonly="true">
		  </td>
        </tr>
		<tr>
	      <td class="style5"><div align="right" class="style4">Sala:&nbsp;</div></td>
	      <td align="left"><input name="sala" type="text" class="borda2" id="sala" value="<?php echo $sal; ?>" size="40" maxlength="30" readonly="true"></td>
	    </tr>
	    <tr>
	      <td><div align="right" class="style4">Requisitante:&nbsp;</div></td>
	      <td align="left"><input name="requisitante" type="text" class="borda2" id="requisitante" size="60" maxlength="50" value="<?php echo $req; ?>" readonly="true"></td>
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
          <td align="left"><input name="componente" type="text" class="borda2" id="componente" value="<?php echo $cop; ?>" size="50" maxlength="50" readonly="true"></td>
		</tr>
	    <tr>
	      <td valign="middle"><div align="right" class="style4">Defeito:&nbsp;</div></td>
	      <td align="left"><textarea name="defeito" cols="60" rows="6" class="borda2" id="defeito" readonly="true"><?php echo $def; ?></textarea></td>
	    </tr>
	    <tr>
	      <td><div align="right" class="style4">Atendente:&nbsp;</div></td>
	      <td align="left"><input name="atendente" type="text" class="borda2" id="atendente" value="<?php echo $ate; ?>" readonly="true"></td>
		</tr>
	    <tr>
	      <td valign="middle"><div align="right" class="style4">Solução:&nbsp;</div></td>
	      <td align="left"><textarea name="solucao" cols="60" rows="6" class="borda2" id="solucao" readonly="true"><?php echo $sol; ?></textarea></td>
	    </tr>
	    <tr>
    	  <td colspan="2"><hr noshade class="borda2"></td>
	    </tr>
	    <tr>
	      <td class="style4"><div align="right">Empresa:&nbsp;</div></td>
	      <td align="left">
	        <select name="empresa" id="empresa">
		        <option value="0">----- Selecione uma Empresa -----</option>
		        <?php do { ?>
  			    <option value="<?php echo $row_EM['id']; ?>"<?php if ($row_EM['id']==$emp) { echo ' selected'; } ?>><?php echo $row_EM['descricao']; ?></option>
      			<?php } while ($row_EM = mysql_fetch_assoc($qry_EM)); ?>
	        </select>
		  </td>
	    </tr>
	    <tr>
	     <td><div align="right" class="style4">Entrada:&nbsp;</div></td>
	     <td align="left">
            <input name="data_e" type="text" class="borda2" id="data_e" size="15" maxlength="10" value="<?php echo $dte; ?>" onKeyPress="return maskEvent(this, 10, '##/##/####', event)">
   		    <span class="style4">&nbsp;&nbsp;&nbsp;&nbsp;Sa&iacute;da:&nbsp;</span> <input name="data_s" type="text" class="borda2" id="data_s2" size="15" maxlength="10" value="<?php echo $dts; ?>" onKeyPress="return maskEvent(this, 10, '##/##/####', event)">
		    <span class="style4">&nbsp;&nbsp;&nbsp;&nbsp;FI:&nbsp;
		    <input name="fi" type="text" class="borda2" id="fi" size="20" maxlength="15" value="<?php echo $fi; ?>">
		    </span>
		 </td>
	    </tr>
		<tr>
          <td>&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left">
		      <input name="btnSalvar" type="submit" class="caixa1" id="btnSalvar" value="S A L V A R" onClick="vclick('G')">&nbsp;
		      <input name="btnBaixar" type="submit" class="caixa1" id="btnBaixar" value="B A I X A R" onClick="vclick('B')">&nbsp;
		      <input name="btnSubir"  type="submit" class="caixa1" id="btnSubir"  value="S U B I R"   onClick="vclick('S')">&nbsp;
 		  </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
    </table>
	</form>
	<p><a href="assistencia_tecnica.php" class="style5 style3"><strong>&lt;&lt; Voltar</strong></a></p>
    </th>
  </tr>
</table>
<?php include("rodape.htm"); ?>
</body>
</html>
<?php mysql_free_result($qry_AT);?>
<?php mysql_free_result($qry_EM);?>
