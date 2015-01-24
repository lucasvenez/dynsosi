<?php require_once("verificalogin.php"); VerificaNivel(4); ?>
<?php require_once('Connections/dbOS.php'); ?>
<?php
mysql_select_db($database_dbOS, $dbOS);

$sql_UF = "SELECT id,descricao from estado ORDER BY descricao ASC";
$qry_UF = mysql_query($sql_UF, $dbOS) or die(mysql_error());
$row_UF = mysql_fetch_assoc($qry_UF);
$tot_UF = mysql_num_rows($qry_UF);

$sql_IE = "SELECT id,descricao from instituicao ORDER BY descricao ASC";
$qry_IE = mysql_query($sql_IE, $dbOS) or die(mysql_error());
$row_IE = mysql_fetch_assoc($qry_IE);
$tot_IE = mysql_num_rows($qry_IE);

if (isset($_GET['id']) ) { 
   $id = $_GET['id'];
} else {  
   $id = 0; 
}

$sql_AT = "SELECT * from atendente where id=".$id;
$qry_AT = mysql_query($sql_AT, $dbOS) or die(mysql_error());
$row_AT = mysql_fetch_assoc($qry_AT);
$tot_AT = mysql_num_rows($qry_AT);

if ($tot_AT > 0) { 
  $tip = 'U'; 
} else { 
  $tip = 'I'; 
}
  
$cod = $row_AT['id'];	
$ape = $row_AT['apelido'];		
$sen = $row_AT['senha'];
$nom = $row_AT['nome'];
$cpf = $row_AT['cpf'];
$dtn = ($row_AT['data_nasc']!='')?FormataData($row_AT['data_nasc']):'';
$end = $row_AT['endereco'];
$bai = $row_AT['bairro'];
$cid = $row_AT['cidade'];
$cep = $row_AT['cep'];
$uf_ = ($row_AT['uf']!='')?$row_AT['uf']:'SP';
$tel = $row_AT['telefone'];
$cel = $row_AT['celular'];
$ema = $row_AT['email'];
$fil = $row_AT['filiacao'];
$eno = $row_AT['endereco_origem'];
$bao = $row_AT['bairro_origem'];
$cio = $row_AT['cidade_origem'];
$ufo = ($row_AT['uf_origem']!='')?$row_AT['uf_origem']:'SP';
$cpo = $row_AT['cep_origem'];
$teo = $row_AT['telefone_origem'];
$ceo = $row_AT['cep_origem'];
$vin = $row_AT['tipo_vinculo'];
$ins = $row_AT['instituicao'];
$ini = ($row_AT['inicio']!='')?FormataData($row_AT['inicio']):'';
$ter = ($row_AT['termino']!='')?FormataData($row_AT['termino']):'';
$obs = $row_AT['obs'];
$niv = $row_AT['nivel'];

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

<script language="javascript" src="js/mask.js"></script>
<script language="javascript" src="js/scripts.js"></script>
<script language="javascript" src="js/valida_docs.js"></script>
</head>
<body>
<?php include("cabe.php"); ?>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col">
    <h2 class="style5"><span class="style3 style17"><strong>A T E N D E N T E</strong></span><br/></h2>
	<form name="form_atendente" id="form_atendente" method="post" action="man_atendente.php" onSubmit="return verifica_atendente(document.form_atendente)">
	<table width="600" border="0" bgcolor="#ABC8E6" class="borda2" align="center">
	  <tr>
	    <td><div align="right"></div></td>
	    <td align="left">&nbsp;
	      <input name="id" type="hidden" id="id" value="<?php echo $cod; ?>">
		  <input name="op" type="hidden" id="op" value="<?php echo $tip; ?>"></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* Apelido:&nbsp; </div></td>
	    <td align="left"><input name="apelido" type="text" class="borda2" id="apelido" value="<?php echo $ape; ?>" size="30" maxlength="20"></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* Senha:&nbsp; </div></td>
	    <td align="left"><input name="senha" type="password" class="borda2" id="senha" value="<?php echo $sen; ?>" size="30" maxlength="20"></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* Nome:&nbsp; </div></td>
	    <td align="left"><input name="nome" type="text" class="borda2" id="nome" value="<?php echo $nom; ?>" size="60" maxlength="50"></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* C.P.F.:&nbsp; </div></td>
	    <td align="left" class="style4">
		<table width="100%" cellpadding="0" cellspacing="0">
		  <tr>
		    <td width="20%" align="left"><input name="cpf" type="text" class="borda2" id="cpf" value="<?php echo $cpf; ?>" size="15" maxlength="14" onKeyPress="return maskEvent(this, 14, '###.###.###-##', event)"></td>
			<td valign="middle" class="style4"><div align="right">* Nivel:&nbsp; </div></td>
			<td align="left"><input name="nivel" type="text" class="borda2" id="nivel" value="<?php echo $niv; ?>" size="2" maxlength="1"></td>
		  </tr>
		</table>
	  </tr>
	  <tr>
	    <td class="style4"><div align="right">* Data nascimento:&nbsp;</div></td>
	    <td align="left" class="style4"><input name="data_nasc" type="text" class="borda2" id="data_nasc" value="<?php echo $dtn; ?>" size="14" maxlength="10" onKeyPress="return maskEvent(this, 10, '##/##/####', event)">
	      Ex: DD/MM/AAAA <strong> </strong></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* Endere&ccedil;o:&nbsp;</div></td>
	    <td align="left"><input name="endereco" type="text" class="borda2" id="endereco" value="<?php echo $end; ?>" size="60" maxlength="50"></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* Bairro:&nbsp;</div></td>
	    <td align="left"><input name="bairro" type="text" class="borda2" id="bairro" value="<?php echo $bai; ?>" size="40" maxlength="30"></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* Cidade:&nbsp; </div></td>
	    <td align="left"><input name="cidade" type="text" class="borda2" id="cidade" value="<?php echo $cid; ?>" size="40" maxlength="30"></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* CEP:&nbsp;</div></td>
	    <td align="left"><input name="cep" type="text" class="borda2" id="cep" value="<?php echo $cep; ?>" size="20" maxlength="10" onKeyPress="return maskEvent(this, 10, '##.###-###', event)">
	      <span class="style4"> Ex: 99.999-999</span></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* UF:&nbsp;</div></td>
	    <td align="left"><select name="uf" class="borda2" id="uf">
			<?php do { ?>
			<option value="<?php echo $row_UF['id']; ?>"<?php if ($row_UF['id']==$uf_) { echo ' selected'; } ?>><?php echo $row_UF['descricao']; ?></option>
			<?php } while ($row_UF = mysql_fetch_assoc($qry_UF)); ?>
            </select>
		</td>
	  </tr>
	  <tr>
	    <td class="style4"><div align="right">Telefone:&nbsp;</div></td>
	    <td align="left"><input name="telefone" type="text" class="borda2" id="telefone" value="<?php echo $tel; ?>" size="20" maxlength="14" onKeyPress="return maskEvent(this, 14, '(##) ####-####', event)">
	        <span class="style4">Ex.: (99) 9999-9999</span></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">Celular:&nbsp;</div></td>
	    <td align="left"><input name="celular" type="text" class="borda2" id="celular" value="<?php echo $cel; ?>" size="20" maxlength="14" onKeyPress="return maskEvent(this, 14, '(##) ####-####', event)">
        <span class="style4">Ex.: (99) 9999-9999</span></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">E-mail:&nbsp;</div></td>
	    <td align="left"><input name="email" type="text" class="borda2" id="email" value="<?php echo $ema; ?>" size="60" maxlength="50"></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* Filia&ccedil;&atilde;o:&nbsp;</div></td>
	    <td align="left"><textarea name="filiacao" cols="50" rows="3" class="borda2"><?php echo $fil; ?></textarea></textarea></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">Endere&ccedil;o de origem:&nbsp; </div></td>
	    <td align="left"><input name="endereco_origem" type="text" class="borda2" id="endereco_origem" value="<?php echo $eno; ?>" size="60" maxlength="50"></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">Bairro de origem:&nbsp; </div></td>
	    <td align="left"><input name="bairro_origem" type="text" class="borda2" id="bairro_origem" value="<?php echo $bao; ?>" size="40" maxlength="30"></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">Cidade de origem:&nbsp; </div></td>
	    <td align="left"><input name="cidade_origem" type="text" class="borda2" id="cidade_origem" value="<?php echo $cio; ?>" size="40" maxlength="30"></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">UF de origem:&nbsp; </div></td>
	    <td align="left"><select name="uf_origem" class="borda2" id="uf_origem">
			<?php  mysql_data_seek($qry_UF,0); do { ?>
			<option value="<?php echo $row_UF['id']; ?>"<?php if ($row_UF['id']==$ufo) { echo ' SELECTED'; } ?>><?php echo $row_UF['descricao']; ?></option>
			<?php } while ($row_UF = mysql_fetch_assoc($qry_UF)); ?>
            </select>
		</td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">CEP de origem:&nbsp; </div></td>
	    <td align="left"><input name="cep_origem" type="text" class="borda2" id="cep_origem" value="<?php echo $cpo; ?>" size="20" maxlength="10" onKeyPress="return maskEvent(this, 10, '##.###-###', event)">
	      <span class="style4"> Ex: 99.999-999</span></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">Telefone de origem:&nbsp; </div></td>
	    <td align="left"><input name="telefone_origem" type="text" class="borda2" id="telefone_origem" value="<?php echo $teo; ?>" size="20" maxlength="14" onKeyPress="return maskEvent(this, 14, '(##) ####-####', event)">
	        <span class="style4">Ex.: (99) 9999-9999</span></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">Celular de origem:&nbsp; </div></td>
	    <td align="left"><input name="celular_origem" type="text" class="borda2" id="celular_origem" value="<?php echo $ceo; ?>" size="20" maxlength="14" onKeyPress="return maskEvent(this, 14, '(##) ####-####', event)">
	        <span class="style4">Ex.: (99) 9999-9999</span></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* Tipo de v&iacute;nculo:&nbsp;</div></td>
	    <td align="left"><select name="tipo_vinculo" class="borda2" id="tipo_vinculo">
		        <option value="Bolsista" <?php if($vin=='Bolsista'){ echo ' selected';} ?>>Bolsista</option>
	    	    <option value="Volunt&aacute;rio" <?php if($vin=='Bolsista'){ echo ' selected';} ?>>Volunt&aacute;rio</option>
		        <option value="Funcion&aacute;io" <?php if($vin=='Bolsista'){ echo ' selected';} ?>>Funcion&aacute;io</option>
		    </select>
		</td>
	  </tr>
	  <tr>
	    <td class="style4"><div align="right">* Institui&ccedil;&atilde;o:&nbsp;</div></td>
	    <td align="left"><select name="instituicao" class="borda2" id="instituicao">
			<?php do { ?>
			<option value="<?php echo $row_IE['id']; ?>" <?php if($row_IE['id']==$ins){ echo ' selected';} ?>><?php echo $row_IE['descricao']; ?></option>
			<?php } while ($row_IE = mysql_fetch_assoc($qry_IE)); ?>
            </select>		</td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* In&iacute;cio:&nbsp;</div></td>
	    <td align="left"><input name="inicio" type="text" class="borda2" id="inicio" value="<?php echo $ini; ?>" size="14" maxlength="10" onKeyPress="return maskEvent(this, 10, '##/##/####', event)">
	      <span class="style4"> Ex: DD/MM/AAAA</span></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">* T&eacute;rmino:&nbsp;</div></td>
	    <td align="left"><input name="termino" type="text" class="borda2" id="termino" value="<?php echo $ter; ?>" size="14" maxlength="10" onKeyPress="return maskEvent(this, 10, '##/##/####', event)">
	      <span class="style4"> Ex: DD/MM/AAAA</span></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right">Observa&ccedil;&otilde;es:&nbsp;</div></td>
	    <td align="left"><textarea name="obs" cols="50" rows="5" class="borda2" id="obs"><?php echo $obs; ?></textarea></td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right"></div></td>
	    <td align="left">&nbsp;</td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right"></div></td>
	    <td align="left"><input name="btnIncluir" type="submit" class="caixa1" id="btnIncluir" value="<?php echo (isset($_GET['id']))?'Atualizar':'Incluir'; ?>">&nbsp;
	        <input name="btnLimpar" type="reset" class="caixa1" id="btnLimpar" value="Limpar">		</td>
	    </tr>
	  <tr>
	    <td class="style4"><div align="right"></div></td>
	    <td>&nbsp;</td>
	    </tr>
	</table>
	</form>
	<p class="style4">* - Campo Obrigat&oacute;rio </p>
	<p><a href="cons_atendente.php" class="style5 style3"><strong>&lt;&lt; Voltar</strong></a></p>
    </th>
  </tr>
</table>
<?php include("rodape.htm"); ?>
</body>
</html>
<?
mysql_free_result($qry_UF);
mysql_free_result($qry_IE);
?>