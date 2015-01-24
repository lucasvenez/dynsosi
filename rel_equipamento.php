<?php require_once("verificalogin.php"); VerificaNivel(4); 
require_once('Connections/dbOS.php');
require_once('Connections/dbLevto.php');

mysql_select_db($database_dbOS, $dbOS);
$sql_EQ = "select * from os.comp_defeito order by descricao";
$qry_EQ = mysql_query($sql_EQ, $dbLevto) or die(mysql_error());
$row_EQ = mysql_fetch_assoc($qry_EQ);

$dep = (isset($_POST['depto'])) ? $_POST['depto'] : '0';
$equ = (isset($_POST['equip'])) ? $_POST['equip'] : '0';
$ord = (isset($_POST['ordem'])) ? $_POST['ordem'] : 'descricao, sigla';

//if ($ord == 'IP') { $ord = "substring(ip,1,3),substring(ip,5,3),substring(ip,9,3),lpad(substring(ip,13,3),3,0)"; } 
if ($ord == 'ip') { $ord = " host "; } 

mysql_select_db($database_dbLevto, $dbLevto);
$sql_DP = "select distinct(sigla) descricao from levto.levto order by descricao";
$qry_DP = mysql_query($sql_DP, $dbLevto) or die(mysql_error());
$row_DP = mysql_fetch_assoc($qry_DP);

$query_sql = "select descricao,ai,patrimonio,sigla,modelo,host,ram,hd,ip from levto.levto where 1 ";
if ( (isset($_POST['equip'])) && ($_POST['equip'] != '') && ($_POST['equip'] != '0') ) {
   $query_sql .= " and codigo_componente = '". $_POST['equip'] ."'";
}
if ( (isset($_POST['depto'])) && ($_POST['depto'] != '') && ($_POST['depto'] != '0') ) {
   $query_sql .= " and sigla = '". $_POST['depto'] ."'";
}
					
$query_sql .= " order by ".$ord;
$sql = mysql_query($query_sql, $dbLevto) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);

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
</script>

</head>

<body>
    <?php include("cabe.php"); ?>
	<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
	     <th scope="col" align="center">
	     <form name="form_periodo" action="rel_equipamento.php" method="post">
		 <h2 class="style5 style3 style8">Relat&oacute;rio de Equipamentos</h2>
	     <table border="0" bgcolor="#E2E2E2" class="borda2">
			<tr>
		        <td class="style2">Sigla:</td>
		        <td class="style2">Componente:</td>
				<td colspan="2">&nbsp;</td>
		    </tr>
		    <tr>
		        <td><select name="depto" id="depto">
		            <option value="0">--- Todos os departamentos ---</option>
			        <?php do { ?>
  				    <option value="<?=$row_DP['descricao']; ?>" <?php if(!strcmp($row_DP['descricao'],$dep)){ echo 'selected'; } ?>><?= $row_DP['descricao']; ?></option>
      				<?php } while ($row_DP = mysql_fetch_assoc($qry_DP)); ?>
			        </select>
				</td>
		        <td><select name="equip" id="equip">
			        <option value="0">--- Todos os equipamentos ---</option>
			        <?php do { ?>
  				    <option value="<?php echo $row_EQ['id']; ?>" <?php if($row_EQ['id']==$equ){ echo 'selected'; } ?>><?php echo $row_EQ['descricao']; ?></option>
      				<?php } while ($row_EQ = mysql_fetch_assoc($qry_EQ)); ?>
			        </select>
				</td>
		        <td align="center">
					<input type="hidden" name="ordem" value="<?=$ord;?>">
        			<input name="btnPesquisar" type="submit" class="caixa1" id="btnPesquisar" value="Pesquisar">
		        </td>
				<td><a href="print_equip.php?ord=<?=$ord;?>&equip=<?=$equ;?>&depto=<?=$dep;?>" target="_blank"><img src="img/print.jpg" border="0"></a></td>
	         </tr>
	    </table><br/>
		</form>
		<tr>
			<th>
				<table width="100%" border="1" cellspacing="0" bordercolor="#000000" class="borda2">
				    <tr bgcolor="#3879BD">
				      <td align="center">  <a href="#" onClick="Enviar('descricao, sigla')"><span class="style4">Equipamento</span></a></td>
				      <td align="center"><a href="#" onClick="Enviar('ai')"><span class="style4">AI</span></a></td>
				      <td align="center"><a href="#" onClick="Enviar('patrimonio')"><span class="style4">Patrimônio</span></a></td>
				      <td align="center"><a href="#" onClick="Enviar('sigla')"><span class="style4">Depto</span></a></td>
				      <td align="center">  <a href="#" onClick="Enviar('modelo')"><span class="style4">Descrição</span></a></td>
				      <td align="center"><a href="#" onClick="Enviar('ip')"><span class="style4">IP</span></a></td>
				      <td align="center"><a href="#" onClick="Enviar('ram')"><span class="style4">Memória</span></a></td>
				      <td align="center"><a href="#" onClick="Enviar('hd')"><span class="style4">HD</span></a></td>
				    </tr>
 	    		    <?php $i=0;  ?>
	    		    <?php do { ?>
	    		    <tr bgcolor="<?php echo (($i%2)==0)?'#EEF3F7':'#9FC0E1' ?>">
   		      	      <td align="left"   class="style6"><?= $row_sql['descricao'];?></td>
   		      	      <td align="center" class="style6"><?= $row_sql['ai']; ?></td>
   		      	      <td align="center" class="style6"><?= $row_sql['patrimonio']; ?></td>
   		      	      <td align="center" class="style6"><?= $row_sql['sigla']; ?></td>
   		      	      <td align="left"   class="style6"><?= $row_sql['modelo']; ?></td>
   		      	      <td align="center" class="style6"><?= $row_sql['ip']; ?></td>
   		      	      <td align="center" class="style6"><?= $row_sql['ram']; ?></td>
   		      	      <td align="center" class="style6"><?= $row_sql['hd']; ?></td>
    		      </tr>
				  <?php $i++; ?>
	    		  <?php } while ($row_sql = mysql_fetch_assoc($sql)); ?>
	    		  <tr bgcolor="#3879BD"><td colspan="8">&nbsp;</td></tr>
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
mysql_free_result($qry_EQ);
mysql_free_result($qry_DP);
?>
