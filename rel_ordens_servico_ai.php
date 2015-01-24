<?php require_once("verificalogin.php"); VerificaNivel(4); ?>
<?php require_once('Connections/dbOS.php'); ?>
<?php

$ai = (isset($_POST['ai'])) ? $_POST['ai'] : '';
$ord = (isset($_POST['ordem'])) ? $_POST['ordem'] : 'data desc, hora desc';
   
mysql_select_db($database_dbOS, $dbOS);
$query_sql = "select os.id,os.data,os.hora,os.localizacao,dp.nome_popular,
                     os.requisitante,os.ramal,os.componente,co.descricao,os.solucao,
                     os.defeito,os.atendente,at.apelido 
              from ordem_servico os, comum.depto dp, comp_defeito co, atendente at
              where os.localizacao=dp.codigo_depto and co.id=os.componente and
                    os.atendente=at.id and ai='".$ai."'";

$query_sql .= " order by ".$ord;
$sql = mysql_query($query_sql, $dbOS) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);

function FormataData($data) {
   if ($data == '') {
      return '';
   } else {
      $dt = explode('-',$data);
      return $dt[2] . '/' . $dt[1] . '/'. $dt[0];
   }
}
function PreparaString($txt) {
 	for ($i=0; $i<strlen($txt)-1; $i++) {
		if ( ord(substr($txt,$i,1)) == 13 ) {
		   $txt = substr($txt,0,$i).' \n '.substr($txt,$i+2,strlen($txt)-$i);
		}
	}
	return $txt;
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
function exibirDetalhes(msg) {
   alert(msg);
}
</script>
</head>

<body>
    <?php include("cabe.php"); ?>
	<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
	     <th scope="col" align="center">
	     <form name="form_periodo" action="rel_ordens_servico_ai.php" method="post" onsubmit="return verifica_rel_periodo(document.form_periodo)">
		 <h2 class="style5 style3 style8">Relat&oacute;rio de Ordens de Serviço por Equipamento</h2>
	     <table border="0" bgcolor="#E2E2E2" class="borda2">
			<tr>
		        <td class="style2">N&uacute;mero do AI:</td>
				<td>&nbsp;</td>
		    </tr>
		    <tr>
		        <td><input name="ai" type="text" size="12" maxlength="10" value="<?php echo $ai; ?>"></td>
		        <td><div align="center">
					<input type="hidden" name="ordem" value="data desc, hora desc">
        			<input name="btnPesquisar" type="submit" class="caixa1" id="btnPesquisar" value="Pesquisar">
		        </div></td>
	         </tr>
	    </table><br/>
 		</form>
		</th>
	  </tr>
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
			      <td><div align="center"><span class="style4">Solução</span></div></td>
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
		          <td align="center" class="style11">
		      		 <input type="button" value="+" onclick="exibirDetalhes('<?= PreparaString($row_sql['solucao']); ?>')" class="caixa1">
		          </td>
   		      </tr>
			  <?php $i++; ?>
    		  <?php } while ($row_sql = mysql_fetch_assoc($sql)); ?>
    		  <tr bgcolor="#3879BD"><td colspan="9"><span class="style4">&nbsp;</span></td></tr>
			</table>
   	        <p><a href="index.php" class="style5 style3"><< Voltar</a></p>
   		</th>
	  </tr>		
	</table>
    <?php include("rodape.htm"); ?>
</body>
</html>
<?php mysql_free_result($sql); ?>
