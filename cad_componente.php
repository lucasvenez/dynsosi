<?php require_once("verificalogin.php"); VerificaNivel(4); ?>
<?php require_once('Connections/dbOS.php'); ?>
<?php
mysql_select_db($database_dbOS, $dbOS);

if (isset($_GET['id']) ) { 
   $id = $_GET['id'];
} else {  
   $id = 0; 
}

$sql_AT = "SELECT * from comp_defeito where id=".$id;
$qry_AT = mysql_query($sql_AT, $dbOS) or die(mysql_error());
$row_AT = mysql_fetch_assoc($qry_AT);
$tot_AT = mysql_num_rows($qry_AT);

if ($tot_AT > 0) { 
  $tip = 'U'; 
} else { 
  $tip = 'I'; 
}
  
$cod = $row_AT['id'];	
$des = $row_AT['descricao'];		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>UNESP</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/scripts.js"></script>
</head>
<body>
<?php include("cabe.php"); ?>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col">
    <h2><span class="style3 style17"><strong>C O M P O N E N T E</strong></span><br/></h2>
	<form name="form_componente" id="form_componente" method="post" action="man_componente.php" onSubmit="return verifica(document.form_componente)">
	<table width="600" border="0" bgcolor="#ABC8E6" class="borda2" align="center">
	  <tr>
		  <td>&nbsp;<input name="id" type="hidden" id="id" value="<?php echo $cod; ?>"></td>
      	  <td>&nbsp;<input name="op" type="hidden" id="op" value="<?php echo $tip; ?>"></td>
	  </tr>
      <tr>
          <td valign="middle"><div align="right" class="style4">Descri&ccedil;&atilde;o do Componente:&nbsp; </div></td>
          <td align="left"><input name="descricao" type="text" class="borda2" id="descricao" value="<?php echo $des; ?>" size="60" maxlength="50"></td>
      </tr>
      <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
       </tr>
       <tr>
          <td>&nbsp;</td>
          <td><input name="btnIncluir" type="submit" class="caixa1" id="btnIncluir" value="<?php echo (isset($_GET['id']))?'Atualizar':'Incluir'; ?>">
              &nbsp;<input name="btnLimpar" type="reset" class="caixa1" id="btnLimpar" value="Limpar"></td>
       </tr>
       <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
       </tr>
    </table>
	</form>
	<p><a href="cons_componente.php" class="style3"><strong>&lt;&lt; Voltar</strong></a></p>
    </th>
  </tr>
</table>
<?php include("rodape.htm"); ?>
</body>
</html>
<?php mysql_free_result($qry_AT);?>