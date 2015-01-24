<?php require_once("verificalogin.php"); VerificaNivel(4); ?>
<?php require_once('Connections/dbOS.php'); ?>
<?php
mysql_select_db($database_dbOS, $dbOS);

$sql_UF = "SELECT id,descricao from estado ORDER BY descricao ASC";
$qry_UF = mysql_query($sql_UF, $dbOS) or die(mysql_error());
$row_UF = mysql_fetch_assoc($qry_UF);
$tot_UF = mysql_num_rows($qry_UF);

if (isset($_GET['id']) ) { 
   $id = $_GET['id'];
} else {  
   $id = 0; 
}

$sql_AT = "SELECT * from empresa where id=".$id;
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
$cnp = $row_AT['cnpj'];
$con = $row_AT['contato'];
$tec = $row_AT['tecnico'];
$tel = $row_AT['telefone'];
$cel = $row_AT['celular'];
$fax = $row_AT['fax'];
$hpg = $row_AT['homepage'];
$ema = $row_AT['email'];
$end = $row_AT['endereco'];
$bai = $row_AT['bairro'];
$cid = $row_AT['cidade'];
$uf_ = ($row_AT['uf']!='')?$row_AT['uf']:'SP';
$cep = $row_AT['cep'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>UNESP</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">

<script language="javascript" src="js/mask.js"></script>
<script language="javascript" src="js/scripts.js"></script>
<script language="javascript" src="js/valida_docs.js"></script>
</head>
<body>
<?php include("cabe.php"); ?>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col">
    <h2><span class="style3 style17"><strong>E M P R E S A</strong></span><br/></h2>
	<form name="form_empresa" id="form_empresa" method="post" action="man_empresa.php" onSubmit="return verifica_empresa(document.form_empresa)">
	<table width="600" border="0" bgcolor="#ABC8E6" class="borda2" align="center">
	   <tr>
		  <td align="right">&nbsp;
		    <input name="id" type="hidden" id="id" value="<?php echo $cod; ?>"></td>
      	  <td align="left">&nbsp;
      	    <input name="op" type="hidden" id="op" value="<?php echo $tip; ?>"></td>
 	   </tr>
	  
	   <tr>
		  <td align="right" class="style4"><div align="right">* Descri&ccedil;&atilde;o:&nbsp;</div></td>
		  <td align="left"><input name="descricao" type="text" class="borda2" id="descricao" size="70" maxlength="60" value="<?php echo $des; ?>"></td>
	   </tr>
       <tr>
		  <td align="right" class="style4"><div align="right">* CNPJ:&nbsp;</div></td>
    	  <td align="left"><input name="cnpj" type="text" class="borda2" id="cnpj" size="25" maxlength="18" value="<?php echo $cnp; ?>" onKeyPress="return maskEvent(this, 18, '##.###.###/####-##', event)" onblur="">&nbsp;<span class="style4">Ex.: 99.999.999/9999-99</span></td>
	   </tr>
       <tr>
          <td align="right" class="style4"><div align="right">* Contato:&nbsp;</div></td>
          <td align="left"><input name="contato" type="text" class="borda2" id="contato" size="30" maxlength="20" value="<?php echo $con; ?>"></td>
       </tr>
       <tr>
          <td align="right" class="style4"><div align="right">T&eacute;cnico:&nbsp;</div></td>
          <td align="left"><input name="tecnico" type="text" class="borda2" id="tecnico" size="30" maxlength="20" value="<?php echo $tec; ?>"></td>
       </tr>
       <tr>
          <td align="right" class="style4"><div align="right">* Telefone:&nbsp;</div></td>
          <td align="left"><input name="telefone" type="text" class="borda2" id="telefone" size="20" maxlength="14" value="<?php echo $tel; ?>" onKeyPress="return maskEvent(this, 14, '(##) ####-####', event)">&nbsp;<span class="style4">Ex.: (99) 9999-9999</span></td>
       </tr>
       <tr>
          <td align="right" class="style4"><div align="right">Celular:&nbsp;</div></td>
          <td align="left"><input name="celular" type="text" class="borda2" id="celular" size="20" maxlength="14" value="<?php echo $cel; ?>" onKeyPress="return maskEvent(this, 14, '(##) ####-####', event)">&nbsp;<span class="style4">Ex.: (99) 9999-9999</span></td>
       </tr>
       <tr>
          <td align="right" class="style4"><div align="right">Fax:&nbsp;</div></td>
          <td align="left"><input name="fax" type="text" class="borda2" id="fax" size="20" maxlength="14" value="<?php echo $fax; ?>" onKeyPress="return maskEvent(this, 14, '(##) ####-####', event)">&nbsp;<span class="style4">Ex.: (99) 9999-9999</span></td>
       </tr>
      <tr>
          <td align="right" class="style4"><div align="right">Home Page:&nbsp;</div></td>
          <td align="left"><input name="homepage" type="text" class="borda2" id="homepage" size="60" maxlength="50" value="<?php echo $hpg; ?>"></td>
      </tr>
      <tr>
          <td align="right" class="style4"><div align="right">E-mail:&nbsp;</div></td>
          <td align="left"><input name="email" type="text" class="borda2" id="email" size="60" maxlength="50" value="<?php echo $ema; ?>"></td>
      </tr>
      <tr>
          <td align="right" class="style4"><div align="right">* Endere&ccedil;o:&nbsp;</div></td>
          <td align="left"><input name="endereco" type="text" class="borda2" id="endereco" size="60" maxlength="50" value="<?php echo $end; ?>"></td>
      </tr>
      <tr>
          <td align="right" class="style4"><div align="right">* Bairro:&nbsp;</div></td>
          <td align="left"><input name="bairro" type="text" class="borda2" id="bairro" size="40" maxlength="30" value="<?php echo $bai; ?>"></td>
      </tr>
      <tr>
          <td align="right" class="style4"><div align="right">* Cidade:&nbsp;</div></td>
          <td align="left"><input name="cidade" type="text" class="borda2" id="cidade" size="40" maxlength="30" value="<?php echo $cid; ?>"></td>
      </tr>
      <tr>
          <td align="right" class="style4"><div align="right">* UF:&nbsp;</div></td>
          <td align="left"><select name="uf" class="borda2" id="uf">
			    <?php do { ?>
			    <option value="<?php echo $row_UF['id']; ?>"<?php if ($row_UF['id']==$uf_) { echo ' selected'; } ?>><?php echo $row_UF['descricao']; ?></option>
    			<?php } while ($row_UF = mysql_fetch_assoc($qry_UF)); ?>
            </select>		  </td>
      </tr>
      <tr>
          <td align="right" class="style4"><div align="right">* CEP:&nbsp;</div></td>
          <td align="left"><input name="cep" type="text" class="borda2" id="cep" size="14" maxlength="10" value="<?php echo $cep; ?>" onKeyPress="return maskEvent(this, 10, '##.###-###', event)">&nbsp;<span class="style4">Ex.: 99.999-999</span></td>
      </tr>
      <tr>
          <td align="right" class="style4"><div align="right"></div></td>
          <td align="left">&nbsp;</td>
      </tr>
      <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input name="btnIncluir" type="submit" class="caixa1" id="btnIncluir" value="<?php echo (isset($_GET['id']))?'Atualizar':'Incluir'; ?>">
          &nbsp;<input name="btnLimpar" type="reset" class="caixa1" id="btnLimpar2" value="Limpar"></td>
      </tr>
      <tr>
          <td align="right">&nbsp;</td>
          <td align="left">&nbsp;</td>
       </tr>
    </table>
	</form>
	<p class="style4">* - Campo Obrigat&oacute;rio</p>
	<p><a href="cons_empresa.php" class="style3"><strong>&lt;&lt; Voltar</strong></a></p>
    </th>
  </tr>
</table>
<?php include("rodape.htm"); ?>
</body>
</html>
<?php mysql_free_result($qry_AT);?>