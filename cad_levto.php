<?php 
require_once("verificalogin.php"); VerificaNivel(4); 
require_once('Connections/dbOS.php');
require_once('Connections/dbComum.php');
require_once('Connections/dbLevto.php');

mysql_select_db($database_dbOS, $dbOS);
$sql_CO = "SELECT id,descricao from comp_defeito order by descricao";
$qry_CO = mysql_query($sql_CO, $dbOS) or die(mysql_error());
$row_CO = mysql_fetch_assoc($qry_CO);
$tot_CO = mysql_num_rows($qry_CO);

$sql_EM = "SELECT id,descricao from empresa order by descricao";
$qry_EM = mysql_query($sql_EM, $dbOS) or die(mysql_error());
$row_EM = mysql_fetch_assoc($qry_EM);

mysql_select_db($database_dbComum, $dbComum);
$sql_DP = "SELECT codigo_depto,nome_depto from depto order by nome_depto";
$qry_DP = mysql_query($sql_DP, $dbComum) or die(mysql_error());
$row_DP = mysql_fetch_assoc($qry_DP);
$tot_DP = mysql_num_rows($qry_DP);

if (isset($_GET['id']) ) { 
   $id = $_GET['id'];
} else {  
   $id = 0; 
}

mysql_select_db($database_dbLevto, $dbLevto);
$sql_AT = "select * from levto where id=".$id;
$qry_AT = mysql_query($sql_AT, $dbLevto) or die(mysql_error());
$row_AT = mysql_fetch_assoc($qry_AT);
$tot_AT = mysql_num_rows($qry_AT);

$tip = ($tot_AT > 0) ? 'U' : 'I'; 
 
$cod = $row_AT['id'];	
$des = $row_AT['descricao'];
$ser = $row_AT['num_serie'];
$ai_ = $row_AT['ai'];
$mod = $row_AT['modelo'];
$tpo = $row_AT['tipo'];
$emp = $row_AT['empr_aquisicao'];
$dta = ($row_AT['Data_Aquisicao']!='')?FormataData($row_AT['Data_Aquisicao']):'';
$gar = ($row_AT['garantia']!='')?FormataData($row_AT['garantia']):'';
$sig = $row_AT['sigla'];
$nom = $row_AT['nome_ua'];
$com = $row_AT['complemento'];
$pat = $row_AT['patrimonio'];
$cdt = $row_AT['comodato'];
$sit = ($row_AT['situacao']!='')?$row_AT['situacao']:'Ativo';
$dtb = ($row_AT['data_baixa']!='' && $row_AT['data_baixa']!='0000-00-00')?FormataData($row_AT['data_baixa']):'';
$obs = $row_AT['observacao'];
$hos = $row_AT['host'];
$ip_ = $row_AT['ip'];
$pla = $row_AT['placa_mae'];
$chi = $row_AT['chipset'];
$ram = $row_AT['ram'];
$hd_ = $row_AT['hd'];
$aid = ($row_AT['aida']!='')?$row_AT['aida']:'Sim';
$tua = ($row_AT['tipo_ua']!='')?$row_AT['tipo_ua']:'Administrativo';
$ccp = ($row_AT['codigo_componente']!=0)?$row_AT['codigo_componente']:0;
$cdp = ($row_AT['codigo_depto']!='')?$row_AT['codigo_depto']:0;

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
<link href="./css/estilos.css" rel="stylesheet" type="text/css">

<script language="javascript" src="js/mask.js"></script>
<script language="javascript" src="js/scripts.js"></script>
</head>
<body>
<?php include("cabe.php"); ?>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col">
    <h2 class="style5"><span class="style3 style17"><strong>E Q U I P A M E N T O</strong></span></h2>
	<form name="form_levto" id="form_levto" method="post" action="man_levto.php" onSubmit="return verifica(document.form_levto)">
	  <table width="600" border="0" bgcolor="#ABC8E6" class="borda2" align="center">
	    <tr>
		  <td>&nbsp;<input name="id" type="hidden" id="id" value="<?php echo $cod; ?>"></td>
      	  <td align="left">&nbsp;
      	    <input name="op" type="hidden" id="op" value="<?php echo $tip; ?>"></td>
	    </tr>
          <td valign="middle"><div align="right" class="style4">Equipamento:&nbsp; </div></td>
          <td align="left"><input name="descricao" type="text" class="borda2" id="descricao" value="<?php echo $des; ?>" size="60" maxlength="50"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">AI:&nbsp; </div></td>
          <td align="left"><input name="ai" type="text" class="borda2" id="ai" value="<?php echo $ai_; ?>" size="10" maxlength="10"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Patrimonio:&nbsp; </div></td>
          <td align="left"><input name="patrimonio" type="text" class="borda2" id="patrimonio" value="<?php echo $pat; ?>" size="10" maxlength="10"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Comodato:&nbsp; </div></td>
          <td align="left"><input name="comodato" type="text" class="borda2" id="comodato" value="<?php echo $cdt; ?>" size="10" maxlength="10"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">N.Serie:&nbsp; </div></td>
          <td align="left"><input name="numSerie" type="text" class="borda2" id="numSerie" value="<?php echo $ser; ?>" size="20" maxlength="20"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Modelo:&nbsp; </div></td>
          <td align="left"><input name="modelo" type="text" class="borda2" id="modelo" value="<?php echo $mod; ?>" size="60" maxlength="50"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Tipo:&nbsp; </div></td>
          <td align="left"><input name="tipo" type="text" class="borda2" id="tipo" value="<?php echo $tpo; ?>" size="60" maxlength="50"></td>
        </tr>
        <tr>
          <td class="style17"><div align="right" class="style4">Adquirido na:&nbsp;</div></td>
          <td align="left" class="style4">
		    <select name="Empresa" class="borda2" id="Empresa">
                  <option value="0" <?php echo ($emp==0)?'selected':''; ?>>----- Selecione uma empresa -----</option>
			      <?php do { ?>
  			        <option value="<?php echo $row_EM['id']; ?>"<?php if (strcmp($row_EM['id'],$emp)==0) { echo ' selected'; } ?>><?php echo $row_EM['descricao']; ?></option>
      			  <?php } while ($row_EM = mysql_fetch_assoc($qry_EM)); ?>
            </select>
		  </td>
        </tr>
        <tr>
          <td class="style17"><div align="right" class="style4">Garantia até:&nbsp;</div></td>
          <td align="left" class="style4"><input name="DataGarantia" type="text" class="borda2" id="DataGarantia" value="<?php echo $gar; ?>" size="14" maxlength="10" onKeyPress="return maskEvent(this, 10, '##/##/####', event)">
            Ex: DD/MM/AAAA <strong> </strong></td>
        </tr>
        <tr>
          <td class="style17"><div align="right" class="style4">Data Aquisicao:&nbsp;</div></td>
          <td align="left" class="style4"><input name="DataAquisicao" type="text" class="borda2" id="DataAquisicao" value="<?php echo $dta; ?>" size="14" maxlength="10" onKeyPress="return maskEvent(this, 10, '##/##/####', event)">
            Ex: DD/MM/AAAA <strong> </strong></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Sigla:&nbsp; </div></td>
          <td align="left"><input name="sigla" type="text" class="borda2" id="sigla" value="<?php echo $sig; ?>" size="10" maxlength="10"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Departamento:&nbsp; </div></td>
          <td align="left"><input name="NomeUa" type="text" class="borda2" id="NomeUa" value="<?php echo $nom; ?>" size="60" maxlength="50"></td>
        </tr>
        <tr>
          <td valign="middle" class="style4"><div align="right" class="style4">Complemento:&nbsp; </div></td>
          <td align="left"><input name="complemento" type="text" class="borda2" id="complemento" value="<?php echo $com; ?>" size="60" maxlength="50"></td>
        </tr>
        <tr>
          <td class="style4"><div align="right">Situa&ccedil;&atilde;o:&nbsp;</div></td>
          <td align="left"><select name="situacao" class="borda2" id="situacao">
              <option value="Ativo" selected>Ativo</option>
              <option value="Inativo">Inativo</option>
            </select>
		  </td>
        </tr>
        <tr>
          <td class="style4"><div align="right">Data da Baixa:&nbsp;</div></td>
          <td align="left" class="style4"><input name="dataBaixa" type="text" class="borda2" id="dataBaixa" value="<?php echo $dtb; ?>" size="14" maxlength="10" onKeyPress="return maskEvent(this, 10, '##/##/####', event)">
        Ex: DD/MM/AAAA <strong> </strong></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Observa&ccedil;&atilde;o:&nbsp; </div></td>
          <td align="left"><input name="observacao" type="text" class="borda2" id="observacao" value="<?php echo $obs; ?>" size="60" maxlength="50"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Host:&nbsp; </div></td>
          <td align="left"><input name="host" type="text" class="borda2" id="host" value="<?php echo $hos; ?>" size="20" maxlength="20"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Ip:&nbsp; </div></td>
          <td align="left"><input name="ip" type="text" class="borda2" id="ip" value="<?php echo $ip_; ?>" size="30" maxlength="30"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Placa M&atilde;e:&nbsp; </div></td>
          <td align="left"><input name="placaMae" type="text" class="borda2" id="placaMae" value="<?php echo $pla; ?>" size="60" maxlength="50"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">ChipSet:&nbsp; </div></td>
          <td align="left"><input name="chipset" type="text" class="borda2" id="chipset" value="<?php echo $chi; ?>" size="60" maxlength="50"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">RAM:&nbsp; </div></td>
          <td align="left"><input name="ram" type="text" class="borda2" id="ram" value="<?php echo $ram; ?>" size="10" maxlength="10"></td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">HD:&nbsp; </div></td>
          <td align="left"><input name="hd" type="text" class="borda2" id="hd" value="<?php echo $hd_; ?>" size="10" maxlength="10"></td>
        </tr>
        <tr>
          <td class="style17"><div align="right" class="style4">AIDA:&nbsp;</div></td>
          <td align="left">
		    <select name="aida" class="borda2" id="aida">
                <option value="Sim" <?php echo ($aid=='Sim')?'selected':''; ?>>Sim</option>
                <option value="Nao" <?php echo ($aid=='Nao')?'selected':''; ?>>Nao</option>
            </select>
		  </td>
        </tr>
        <tr>
          <td class="style17"><div align="right" class="style4">Tipo UA:&nbsp;</div></td>
          <td align="left">
		    <select name="tipoUa" class="borda2" id="tipoUa">
                <option value="Administrativo" <?php echo ($tua=='Administrativo')?'selected':''; ?>>Administrativo</option>
                <option value="Didatico" <?php echo ($tua=='Didatico')?'selected':''; ?>>Didatico</option>
            </select>
		  </td>
        </tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Categoria:&nbsp; </div></td>
          <td align="left">
		    <select name="CodigoComponente" class="borda2" id="CodigoComponente">
                  <option value="0" <?php echo ($ccp==0)?'selected':''; ?>>----- Selecione um componente -----</option>
			      <?php do { ?>
  			        <option value="<?php echo $row_CO['id']; ?>"<?php if (strcmp($row_CO['id'],$ccp)==0) { echo ' selected'; } ?>><?php echo $row_CO['descricao']; ?></option>
      			  <?php } while ($row_CO = mysql_fetch_assoc($qry_CO)); ?>
            </select>
  		  </td>
		</tr>
        <tr>
          <td valign="middle"><div align="right" class="style4">Codigo UA:&nbsp; </div></td>
          <td align="left">
		     <select name="CodigoDepto" class="borda2" id="CodigoDepto">
              	<option value="0" <?php echo ($cdp==0)?'selected':''; ?>>----- Selecione um departamento -----</option>
 		      	<?php do { ?>
  			       <option value="<?php echo $row_DP['codigo_depto']; ?>"<?php if (strcmp($row_DP['codigo_depto'],$cdp)==0) { echo ' selected'; } ?>><?php echo $row_DP['nome_depto']; ?></option>
      			 <?php } while ($row_DP = mysql_fetch_assoc($qry_DP)); ?>
            </select>
		  </td>
		</tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left"><input name="btnIncluir" type="submit" class="caixa1" id="btnIncluir" value="<?php echo (isset($_GET['id']))?'Atualizar':'Incluir'; ?>">
            &nbsp;<input name="btnLimpar" type="reset" class="caixa1" id="btnLimpar" value="Limpar"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
    </table>
	</form>
	<p><a href="cons_levto.php" class="style5 style3"><strong>&lt;&lt; Voltar</strong></a></p>
    </th>
  </tr>
</table>
<?php include("rodape.htm"); ?>
</body>
</html>
<?php mysql_free_result($qry_AT);?>
<?php mysql_free_result($qry_CO);?>
<?php mysql_free_result($qry_DP);?>