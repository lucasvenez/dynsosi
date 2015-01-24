<?php require_once("verificalogin.php"); VerificaNivel(4);  ?>
<?php require_once('Connections/dbLevto.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_sql = 10000000;
$pageNum_sql = 0;
if (isset($_GET['pageNum_sql'])) {
  $pageNum_sql = $_GET['pageNum_sql'];
}

mysql_select_db($database_dbLevto, $dbLevto);
$query_sql = "select id,descricao,ai,patrimonio,sigla,modelo,complemento,host,ram,hd from levto
              order by sigla,descricao,patrimonio";

if ( (isset($_POST['ai'])) && ($_POST['ai']!='') ) {
  $bsk = mysql_query($query_sql, $dbLevto) or die(mysql_error());
//  $row = mysql_fetch_assoc($bsk);
  $reg = 0;
  do {
     if ($_POST['ai'] == $row['ai']) {
	    $pageNum_sql = ceil($reg/$maxRows_sql)-1;
		break;       
	 }
	 $reg++;
  } while ($row = mysql_fetch_assoc($bsk));
}
$startRow_sql = $pageNum_sql * $maxRows_sql;

$query_limit_sql = sprintf("%s LIMIT %d, %d", $query_sql, $startRow_sql, $maxRows_sql);
$sql = mysql_query($query_limit_sql, $dbLevto) or die(mysql_error());
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
			<th scope="col"><h2 class="style5 style3 style8">E Q U I P A M E N T O S</h2>
				<form action="cad_levto.php" method="post" name="form_cadastro" id="form_cadadastro">
                   <p><input name="btnCadastrar" type="submit" class="caixa1" id="btnCadastrar" value="Cadastrar Novo Equipamento"></p>
                </form>  
				<table width="100%" border="1" cellspacing="0" bordercolor="#000000" class="borda2">
				<tr bgcolor="#3879BD">
					<td bgcolor="#3879BD"><div align="center"><span class="style4">Descrição</span></div></td>
					<td bgcolor="#3879BD"><div align="center"><span class="style4">AI</span></div></td>
					<td bgcolor="#3879BD"><div align="center"><span class="style4">Patrimônio</span></div></td>
					<td bgcolor="#3879BD"><div align="center"><span class="style4">Sigla</span></div></td>
					<td bgcolor="#3879BD"><div align="center"><span class="style4">Modelo</span></div></td>
					<td bgcolor="#3879BD"><div align="center"><span class="style4">Complemento</span></div></td>
					<td bgcolor="#3879BD"><div align="center"><span class="style4">HOST</span></div></td>
					<td bgcolor="#3879BD"><div align="center"><span class="style4">RAM</span></div></td>
					<td bgcolor="#3879BD"><div align="center"><span class="style4">HD</span></div></td>
      				<td>
					  <form name="kd_ai" method="post" action="">
                        <span class="style4">AI:</span>                      
                        <input name="ai" type="text" class="style7" id="ai" size="10" maxlength="10">
                      </form>
					</td>
				</tr>
    			<form action="man_levto.php" method="post" name="form_consulta" id="form_consulta">
	    		  <?php do { ?>
	    		  <?php if ( (isset($_POST['ai'])) && ($_POST['ai'] == $row_sql['ai']) ) {
				           $i = '#00FFFF';
						} else {
				           $i=($i=='#EEF3F7')?'#9FC0E1':'#EEF3F7';  
						}
				  ?>
	    		  <tr bgcolor="<?= $i; ?>">
   		      	      <td align="left"><span class="style6"><?php echo $row_sql['descricao']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['ai']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['patrimonio']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['sigla']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['modelo']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['complemento']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['host']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['ram']; ?></span></td>
   		      	      <td align="center"><span class="style6"><?php echo $row_sql['hd']; ?></span></td>
   		      	      <td width="135" align="center">
				        <input name="btnAlterar" type="submit" class="caixa1" id="btnAlterar" value="Alterar" onClick="vclick('E',<?php echo $row_sql['id']; ?>)">
					    <input name="btnExcluir" type="submit" class="caixa1" id="btnExcluir" value="Excluir" onClick="vclick('D',<?php echo $row_sql['id']; ?>);return excluir('Deseja excluir o componente:\n <?php echo $row_sql['descricao']; ?>?')">
			          </td>
    		      </tr>
	    		  <?php } while ($row_sql = mysql_fetch_assoc($sql)); ?>
	    		  <tr bgcolor="#3879BD">
	    		    <td colspan="10">
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
                    </table></td>
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
