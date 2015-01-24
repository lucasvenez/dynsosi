<?php require_once("verificalogin.php"); VerificaNivel(4); ?>
<?php require_once('Connections/dbOS.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_sql = 5;
$pageNum_sql = 0;
if (isset($_GET['pageNum_sql'])) {
  $pageNum_sql = $_GET['pageNum_sql'];
}
$startRow_sql = $pageNum_sql * $maxRows_sql;

mysql_select_db($database_dbOS, $dbOS);
$query_sql = "select os.id,os.data_e,os.fi,dp.nome_popular,co.descricao componente,
                em.descricao empresa,em.telefone,os.ai
              from ordem_servico os, comum.depto dp, comp_defeito co, empresa em
              where os.localizacao=dp.codigo_depto and co.id=os.componente and
                    em.id=os.empresa and os.at='S'
		      union
			  select os.id,os.data_e,os.fi,dp.nome_popular,co.descricao componente,' ',' ',os.ai
			  from ordem_servico os, comum.depto dp, comp_defeito co
			  where os.localizacao=dp.codigo_depto and co.id=os.componente and os.at='S' and os.empresa='' 
              order by id desc";

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
   if (($data == '') || ($data=='0000-00-00')) {
      return '&nbsp;';
   } else {
      $dt = explode('-',$data);
      return $dt[2] . '/' . $dt[1] . '/'. $dt[0];
   }
}
function FormataStr($txt) {
	return ($txt=='')?'&nbsp;':$txt;
}
function BuscaGarantia( $ai, $db ) {
	if ($ai == '') {
		return '&nbsp;';
	} else {	
		$qry2 = "select case when ( to_days(curdate())-to_days(max(data_s)) ) = '' then 'N&atilde;o'
		        	when ( to_days(curdate())-to_days(max(data_s)) ) >= 90 then 'Sim'
			        else 'N&atilde;o'   end garantia from ordem_servico where ai='".$ai."'";
		$sql2 = mysql_query($qry2, $db) or die(mysql_error());
		$row2 = mysql_fetch_assoc($sql2);
		
		return ($row2['garantia']=='')?'&nbsp;':$row2['garantia'];
	}
}

$queryString_sql = sprintf("&totalRows_sql=%d%s", $totalRows_sql, $queryString_sql);
?>
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>UNESP</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
			<th scope="col"><h2 class="style5 style3 style8">ASSIST&Ecirc;NCIA T&Eacute;CNICA</h2>
				<table width="100%" border="1" cellspacing="0" bordercolor="#000000" class="borda2">
				    <tr bgcolor="#3879BD">
				      <td><div align="center"><span class="style4">Entrada</span></div></td>
				      <td><div align="center"><span class="style4">FI</span></div></td>
				      <td><div align="center"><span class="style4">Depto.</span></div></td>
				      <td><div align="center"><span class="style4">Componente</span></div></td>
					  <td><div align="center"><span class="style4">Garantia</span></div></td>
				      <td colspan="2"><div align="center"><span class="style4">Empresa</span></div></td>
				      <td colspan="2"><div align="center"><span class="style4">&nbsp;</span></div></td>
				    </tr>
    			    <form action="cons_assistencia.php" method="post" name="form_consulta" id="form_consulta">
	    		    <?php do { ?>
 	    		    <?php $cor=($cor=='#EEF3F7')?'#9FC0E1':'#EEF3F7';  ?>
	    		    <tr bgcolor="<?= $cor ?>">
   		      	      <td align="center"><span class="style6"><?= FormataData($row_sql['data_e']); ?></span></td>
   		      	      <td align="center"><span class="style6"><?= FormataStr($row_sql['fi']); ?></span></td>
   		      	      <td align="center"><span class="style6"><?= FormataStr($row_sql['nome_popular']); ?></span></td>
   		      	      <td align="center"><span class="style6"><?= FormataStr($row_sql['componente']); ?></span></td>
					  <td align="center"><span class="style6"><?= BuscaGarantia($row_sql['ai'],$dbOS); ?></span></td>
   		      	      <td align="center"><span class="style6"><?= FormataStr($row_sql['empresa']); ?></span></td>
   		      	      <td align="center"><span class="style6"><?= FormataStr($row_sql['telefone']); ?></span></td>
   		      	      <td>
					    <?php if ($totalRows_sql > 0) { ?>
  				        <input name="btnDetail" type="submit" class="caixa1" id="btnDetail" value="Detalhar" onClick="vclick('T',<?php echo $row_sql['id']; ?>)">
						<?php } else { echo "&nbsp;"; } ?>
			          </td>
					  <td>
						<?php if ( $row_sql['empresa'] != '' ) {  ?>
						<a href="rel_nota_saida.php?id=<?= $row_sql['id']; ?>" target="_blank"><img src="img/print.jpg" border="0" align="top"/></a>
						<?php } else { echo "&nbsp;"; } ?>
					  </td>
    		      </tr>
	    		  <?php } while ($row_sql = mysql_fetch_assoc($sql)); ?>
	    		  <tr bgcolor="#3879BD">
	    		    <td colspan="9">
	    		      <table border="0" width="50%" align="center">
                        <tr>
                          <td width="23%" align="center">
                            <?php if ($pageNum_sql > 0) {  ?>
                            <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, 0, $queryString_sql); ?>"><img src="img/first.gif" width="18" height="13" border=0></a>
                            <?php }  ?>
                          </td>
                          <td width="31%" align="center">
                            <?php if ($pageNum_sql > 0) {  ?>
                            <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, max(0, $pageNum_sql - 1), $queryString_sql); ?>"><img src="img/previous.gif" width="14" height="13" border=0></a>
                            <?php }  ?>
                          </td>
                          <td width="23%" align="center">
                            <?php if ($pageNum_sql < $totalPages_sql) {  ?>
                            <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, min($totalPages_sql, $pageNum_sql + 1), $queryString_sql); ?>"><img src="img/next.gif" width="14" height="13" border=0></a>
                            <?php }  ?>
                          </td>
                          <td width="23%" align="center">
                            <?php if ($pageNum_sql < $totalPages_sql) { ?>
                            <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, $totalPages_sql, $queryString_sql); ?>"><img src="img/last.gif" width="18" height="13" border=0></a>
                            <?php }  ?>
                          </td>
                        </tr>
                      </table>
					  </td>
    		      </tr>
	    		  <input type="hidden" name="op" value="">
	    		  <input type="hidden" name="id" value="0">
		        </form> 
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
?>
