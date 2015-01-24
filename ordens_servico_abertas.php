<?php require_once("verificalogin.php"); VerificaNivel(6); ?>
<?php require_once('Connections/dbOS.php'); ?>
<?php
$nivel = $_SESSION['nivel'];
$user  = $_SESSION['user'];
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_sql = 100;
$pageNum_sql = 0;
if (isset($_GET['pageNum_sql'])) {
  $pageNum_sql = $_GET['pageNum_sql'];
}
$startRow_sql = $pageNum_sql * $maxRows_sql;

$ordem = (isset($_GET['ordem'])) ? $_GET['ordem'] : 'data desc,hora desc';

mysql_select_db($database_dbOS, $dbOS);
$query_sql = "select os.id,os.data,os.hora,os.localizacao,dp.nome_popular,
                     os.requisitante,os.ramal,os.componente,co.descricao,
                     os.defeito,os.atendente,at.apelido
              from ordem_servico os, comum.depto dp, comp_defeito co, atendente at
              where os.localizacao=dp.codigo_depto and co.id=os.componente and
                    os.atendente=at.id and os.at='N' and
                    (os.data_baixa is null or os.data_baixa='0000-00-00')
              union 
              select os.id,os.data,os.hora,os.localizacao,dp.nome_popular,
                     os.requisitante,os.ramal,os.componente,co.descricao,
                     os.defeito,os.atendente,''
              from ordem_servico os, comum.depto dp, comp_defeito co 
              where os.localizacao=dp.codigo_depto and co.id=os.componente and
                    os.atendente=0 and os.at='N' and
                    (os.data_baixa is null or os.data_baixa='0000-00-00')			  

              order by $ordem";

$query_limit_sql = sprintf("%s LIMIT %d, %d", $query_sql, $startRow_sql, $maxRows_sql);
$sql = mysql_query($query_limit_sql, $dbOS) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);

if (isset($_GET['totalRows_sql'])) {
  $totalRows_sql = $_GET['totalRows_sql'];
} else {
  $all_sql = mysql_query($query_sql);
  $totalRows_sql = mysql_num_rows($all_sql);
}
$totalPages_sql = ceil($totalRows_sql/$maxRows_sql)-1;

$queryString_sql = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_sql") == false && 
        stristr($param, "totalRows_sql") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_sql = "&" . htmlentities(implode("&", $newParams));
  }
}
function FormataData($data) {
   $dt = explode('-',$data);
   return $dt[2] . '/' . $dt[1] . '/'. $dt[0];
}

$queryString_sql = sprintf("&totalRows_sql=%d%s", $totalRows_sql, $queryString_sql);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>UNESP</title>&nbsp;
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="refresh" content="300">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/scripts.js"></script>
<script language="javascript">
function vclick(vOp,vId) {
   document.form_consulta.op.value = vOp;
   document.form_consulta.id.value = vId;   
}
</script>
</head>

<body>
    <?php include("cabe.php"); ?>
	<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<th scope="col"><h2 class="style5 style3 style8">Ordens de Serviço em Aberto</h2>
			    <?php if($nivel == 1) { ?>
				<form action="alt_ordem.php" method="post" name="form_cadastro" id="form_cadadastro">
                   <p><input name="btnCadastrar" type="submit" class="caixa1" id="btnCadastrar" value="Cadastrar Nova Ordem de Serviço"></p>
                </form>  
			    <?php } ?>
				<table width="100%" border="1" cellspacing="0" bordercolor="#000000" class="borda2">
				    <tr bgcolor="#3879BD">
				      <td><div align="center"><a href="ordens_servico_abertas.php"><span class="style4">Data</span></a></div></td>
				      <td><div align="center"><span class="style4">Hora</span></div></td>
				      <td><div align="center"><a href="ordens_servico_abertas.php?ordem=nome_popular"><span class="style4">Depto.</span></a></div></td>
				      <td><div align="center"><span class="style4">Requisitante</span></div></td>
				      <td><div align="center"><span class="style4">Ramal</span></div></td>
				      <td><div align="center"><span class="style4">Componente</span></div></td>
				      <td><div align="center"><span class="style4">Defeito</span></div></td>
				      <td><div align="center"><a href="ordens_servico_abertas.php?ordem=atendente"><span class="style4">Atendente</span></a></div></td>
				      <td><div align="center"><span class="style4">&nbsp;</span></div></td>
				    </tr>
    			    <form action="man_ordem.php" method="post" name="form_consulta" id="form_consulta">
					<?php if ($totalRows_sql > 0) { ?>
 	    		    <?php $i=0;  ?>
	    		    <?php do { ?>
	    		    <tr bgcolor="<?php echo (($i%2)==0)?'#EEF3F7':'#9FC0E1' ?>">
   		      	      <td align="left"><span class="style6">&nbsp;<?= FormataData($row_sql['data']); ?></span></td>
   		      	      <td align="center"><span class="style6">&nbsp;<?= $row_sql['hora']; ?></span></td>
   		      	      <td align="center"><span class="style6">&nbsp;<?= $row_sql['nome_popular']; ?></span></td>
   		      	      <td align="center"><span class="style6">&nbsp;<?= $row_sql['requisitante']; ?></span></td>
   		      	      <td align="center"><span class="style6">&nbsp;<?= $row_sql['ramal']; ?></span></td>
   		      	      <td align="center"><span class="style6">&nbsp;<?= $row_sql['descricao']; ?></span></td>
   		      	      <td align="center"><span class="style6">&nbsp;<?= $row_sql['defeito']; ?></span></td>
   		      	      <td align="center"><span class="style6">&nbsp;<?= $row_sql['apelido']; ?></span></td>
   		      	      <td align="center">
					    <?php if (($user == $row_sql['apelido']) || ($nivel == 1) ) { ?>
				        <input name="btnAlterar" type="submit" class="caixa1" id="btnAlterar" value="Alterar" onClick="vclick('E',<?php echo $row_sql['id']; ?>)"><br/>
				        <input name="btnAlterar" type="submit" class="caixa1" id="btnBaixar"  value="Baixar " onClick="vclick('L',<?php echo $row_sql['id']; ?>)"><br/>
						  <?php if ($nivel == 1) { ?>
					      <input name="btnExcluir" type="submit" class="caixa1" id="btnExcluir" value="Excluir" onClick="vclick('D',<?php echo $row_sql['id']; ?>);return excluir('Deseja excluir esta Ordem de Serviço?')">
						  <?php } ?>
                        <?php } else { echo "&nbsp;"; } ?>
			          </td>
    		      </tr>
				  <?php $i++; ?>
	    		  <?php } while ($row_sql = mysql_fetch_assoc($sql)); ?>
				  <?php } ?>
	    		  <tr bgcolor="#3879BD">
	    		    <td colspan="9">
	    		      <table border="0" width="50%" align="center">
                        <tr>
                          <td width="23%" align="center">
                            <?php if ($pageNum_sql > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, 0, $queryString_sql); ?>"><img src="img/first.gif" width="18" height="13" border=0></a>
                            <?php } // Show if not first page ?>
                          </td>
                          <td width="31%" align="center">
                            <?php if ($pageNum_sql > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, max(0, $pageNum_sql - 1), $queryString_sql); ?>"><img src="img/previous.gif" width="14" height="13" border=0></a>
                            <?php } // Show if not first page ?>
                          </td>
                          <td width="23%" align="center">
                            <?php if ($pageNum_sql < $totalPages_sql) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, min($totalPages_sql, $pageNum_sql + 1), $queryString_sql); ?>"><img src="img/next.gif" width="14" height="13" border=0></a>
                            <?php } // Show if not last page ?>
                          </td>
                          <td width="23%" align="center">
                            <?php if ($pageNum_sql < $totalPages_sql) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, $totalPages_sql, $queryString_sql); ?>"><img src="img/last.gif" width="18" height="13" border=0></a>
                            <?php } // Show if not last page ?>
                          </td>
                        </tr>
                      </table>
				    </td>
    		      </tr>
	    		  <input type="hidden" name="op" value="">
	    		  <input type="hidden" name="id" value="0">
		        </form> 
				</table>
    	        <p>
				  <?php if ($nivel == 1) { ?>
				     <a href="index.php" class="style5 style3"><< Voltar</a>
				  <?php } else { ?>
				     <a href="sair.php" class="style5 style3"><< Sair</a>
				  <?php }  ?>
				</p>
    		</th>
		</tr>		
	</table>
   <?php include("rodape.htm"); ?>
</body>
</html>
<?php
mysql_free_result($sql);
?>
