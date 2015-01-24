<?php require_once('Connections/dbOS.php'); ?>
<?php require_once("verificalogin.php"); VerificaNivel(4); ?>
<?php
 
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Aten = 10;
$pageNum_Aten = 0;
if (isset($_GET['pageNum_Aten'])) {
  $pageNum_Aten = $_GET['pageNum_Aten'];
}
$startRow_Aten = $pageNum_Aten * $maxRows_Aten;

mysql_select_db($database_dbOS, $dbOS);
$query_Aten = "SELECT id, nome, telefone, celular FROM atendente ORDER BY nome ASC";
$query_limit_Aten = sprintf("%s LIMIT %d, %d", $query_Aten, $startRow_Aten, $maxRows_Aten);
$Aten = mysql_query($query_limit_Aten, $dbOS) or die(mysql_error());
$row_Aten = mysql_fetch_assoc($Aten);

if (isset($_GET['totalRows_Aten'])) {
  $totalRows_Aten = $_GET['totalRows_Aten'];
} else {
  $all_Aten = mysql_query($query_Aten);
  $totalRows_Aten = mysql_num_rows($all_Aten);
}
$totalPages_Aten = ceil($totalRows_Aten/$maxRows_Aten)-1;
?>

<?php
$queryString_Aten = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Aten") == false && 
        stristr($param, "totalRows_Aten") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Aten = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Aten = sprintf("&totalRows_Aten=%d%s", $totalRows_Aten, $queryString_Aten);
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
   document.form_man_atendente.op.value = vOp;
   document.form_man_atendente.id.value = vId;   
}
</script>
</head>

<body>
    <?php include("cabe.php"); ?>
	<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<th scope="col"><h2 class="style5 style3 style8">A T E N D E N T E</h2>
				<form action="cad_atendente.php" method="post" name="form_cad_atendente" id="form_cad_atendente">
                   <p><input name="btnCadastrar" type="submit" class="caixa1" id="btnCadastrar" value="Cadastrar Novo Atendente"></p>
                </form>  
				<table width="100%" border="1" cellspacing="0" bordercolor="#000000" class="borda2">
				<tr bgcolor="#3879BD">
					<td bgcolor="#3879BD"><div align="center"><span class="style4">Nome</span></div></td>
					<td><div align="center"><span class="style4">Telefone</span></div></td>
					<td><div align="center"><span class="style4">Celular</span></div></td>
      				<td>&nbsp;</td>
				</tr>
    			<form action="man_atendente.php" method="post" name="form_man_atendente" id="form_man_atendente">
	    		  <?php $i=0; do { ?>
	    		  <tr bgcolor="<?php echo (($i%2)==0)?'#EEF3F7':'#9FC0E1' ?>">
      		      	  <td align="left" bgcolor="<?php echo (($i%2)==0)?'#EEF3F7':'#9FC0E1' ?>" width="50%">
						<span class="style6"><?php echo $row_Aten['nome']; ?></span>
					  </td>
      		          <td align="center"><span class="style6">&nbsp;<?php echo $row_Aten['telefone']; ?></span></td>
      		          <td align="center"><span class="style6"><?php echo $row_Aten['celular']; ?></span></td>
      		          <td width="135" align="center">
					    <input name="btnAlterar" type="submit" class="caixa1" id="btnAlterar" value="Alterar" onClick="vclick('E',<?php echo $row_Aten['id']; ?>)">
						<input name="btnExcluir" type="submit" class="caixa1" id="btnExcluir" value="Excluir" onClick="vclick('D',<?php echo $row_Aten['id']; ?>);return excluir('Deseja excluir o(a) atendente:\n<?php echo $row_Aten['nome']; ?>?')">
					  </td>
    		      </tr>
	    		  <?php $i++; } while ($row_Aten = mysql_fetch_assoc($Aten)); ?>
	    		  <tr bgcolor="#3879BD">
	    		    <td colspan="4">
                      <table border="0" width="50%" align="center">
                        <tr>
                          <td width="23%" align="center">
                            <?php if ($pageNum_Aten > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_Aten=%d%s", $currentPage, 0, $queryString_Aten); ?>"><img src="img/first.gif" alt="Primeiro" width="18" height="13" border=0></a>
                            <?php } // Show if not first page ?>
                          </td>
                          <td width="31%" align="center">
                            <?php if ($pageNum_Aten > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_Aten=%d%s", $currentPage, max(0, $pageNum_Aten - 1), $queryString_Aten); ?>"><img src="img/previous.gif" alt="Anterior" width="14" height="13" border=0></a>
                            <?php } // Show if not first page ?>
                          </td>
                          <td width="23%" align="center">
                            <?php if ($pageNum_Aten < $totalPages_Aten) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_Aten=%d%s", $currentPage, min($totalPages_Aten, $pageNum_Aten + 1), $queryString_Aten); ?>"><img src="img/next.gif" alt="Pr&oacute;ximo" width="14" height="13" border=0></a>
                            <?php } // Show if not last page ?>
                          </td>
                          <td width="23%" align="center">
                            <?php if ($pageNum_Aten < $totalPages_Aten) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_Aten=%d%s", $currentPage, $totalPages_Aten, $queryString_Aten); ?>"><img src="img/last.gif" alt="&Uacute;ltimo" width="18" height="13" border=0></a>
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
mysql_free_result($Aten);
?>
