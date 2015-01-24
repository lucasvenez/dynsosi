<?php require_once("verificalogin.php"); VerificaNivel(4); ?>
<?php require_once('Connections/dbOS.php'); ?>
<?php
$ini = (isset($_POST['ini'])) ? $_POST['ini'] : Date('d/m/Y');
$fim = (isset($_POST['fim'])) ? $_POST['fim'] : Date('d/m/Y');
$gra = (isset($_POST['gra'])) ? $_POST['gra'] : 'O';

$ini_db = FormataDataDB($ini);
$fim_db = FormataDataDB($fim);

if ($gra == 'O') {
  $titulo = 'Ordens de Serviço';
  
  $query_sql =  "select  concat('Solicitadas ao STI',space(40)) nome,count(id) qtde from ordem_servico
				 where data between '".$ini_db. "' and '".$fim_db."'
				 union
				 select 'Solucionadas pelo STI' nome,count(id) qtde from ordem_servico
				 where (data_baixa!='0000-00-00' or data_baixa is not null
				      or data_baixa!='') and atendente!=0 and (data_e='0000-00-00'
				      or data_e is null or data_e = '') and at = 'N' and
					  data between '".$ini_db. "' and '".$fim_db."'
				 union
				 select 'Encaminhadas para a Assistência Técnica' nome,count(id) qtde from ordem_servico
				 where atendente!=0 and (data_e!='0000-00-00' and
				       data_e is not null and data_e!='') and
					   data between '".$ini_db. "' and '".$fim_db."' 
				 UNION ";
  
  $query_sql .= "SELECT  
					'Socitações em aberto' nome, 
					count(id) -
					(
						( SELECT COUNT(id) FROM ordem_servico WHERE (data_baixa!='0000-00-00' or data_baixa is not null or data_baixa!='') and atendente!=0 and (data_e='0000-00-00' or data_e is null or data_e = '') and at = 'N' and data between '$ini_db' and '$fim_db' ) +
						( SELECT COUNT(id) FROM ordem_servico WHERE atendente!=0 and (data_e!='0000-00-00' and data_e is not null and data_e!='') and data between '$ini_db' and '$fim_db' )
					)  
					AS qtde 
				FROM ordem_servico
				WHERE data BETWEEN '$ini_db' and '$fim_db'";
}
if ($gra == 'M') {
  $titulo = 'Ordens de Serviço<br/>Média de Atendimentos';
  $query_sql = "select '<center><br/><strong><i>nenhum registro encontrado</i></strong><br/><br/></center>' nome,'' qtde";
}
if ($gra == 'D') {
  $titulo = 'Ordens de Serviço<br/>Atendimentos por Departamento';
  $query_sql = "select d.nome_popular nome, COUNT(os.localizacao) qtde
                from os.ordem_servico AS os, comum.depto d
                where os.localizacao = d.codigo_depto  and
					   data_baixa between '".$ini_db. "' and '".$fim_db."'
                group by os.localizacao
                order by d.nome_depto asc";
}
if ( $gra == 'C' ) {
  $titulo = 'Ordens de Serviço<br/>Atendimentos por Componente';
  $query_sql = "select c.descricao nome, COUNT(os.componente) qtde
				from os.ordem_servico AS os, comp_defeito c
				where os.componente = c.id  and
					   data between '".$ini_db. "' and '".$fim_db."'
				group by os.componente
				order by c.descricao asc";
}
if ( $gra == 'A' ) {
  $titulo = 'Ordens de Serviço<br/>Atendimentos por Atendente';
  $query_sql = "select a.nome, COUNT(os.atendente) qtde,a.termino
				from os.ordem_servico os, atendente a
				where os.atendente = a.id  and
					  data between '".$ini_db. "' and '".$fim_db."'
				      and a.termino>='".$ini_db."'
				group by os.atendente
				order by a.nome asc";
}

mysql_select_db($database_dbOS, $dbOS);
$sql = mysql_query($query_sql, $dbOS) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$tot = mysql_num_rows($sql);

function FormataDataDB($data) {
   if ($data == '') {
      return '';
   } else {
      $dt = explode('/',$data);
      return $dt[2] . '-' . $dt[1] . '-'. $dt[0];
   }
}
function FormataData($data) {
   if ($data == '') {
      return '';
   } else {
      $dt = explode('-',$data);
      return $dt[2] . '/' . $dt[1] . '/'. $dt[0];
   }
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
function Enviar(vOp) {
  document.form_periodo.gra.value = vOp;
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
	     <form name="form_periodo" action="rel_estatistica.php" method="post" onsubmit="return verifica_rel_periodo(document.form_periodo)">
		 <h2 class="style5 style3 style8">Estatística</h2>
		 <table width="50%" border="0" cellspacing="0" bordercolor="#000000" class="borda2" align="center">
			<tr bgcolor="#3879BD" align="center">
				<td width="20%"><a href="#" onClick="Enviar('O')"><span class="style4">Ordem<br/>Serviço</span></a></td>
	      		<td width="20%"><a href="#" onClick="Enviar('D')"><span class="style4">Atendimento<br/>Departamento</span></a></td>
      			<td width="20%"><a href="#" onClick="Enviar('C')"><span class="style4">Atendimento<br/>Componente</span></a></td>
	      		<td width="20%"><a href="#" onClick="Enviar('A')"><span class="style4">Atendimento<br/>Atendente</span></a></td>
			</tr>				
		 </table><br/>
	     <table border="0" bgcolor="#E2E2E2" class="borda2">
			<tr>
		        <td class="style2">Data Inicial:</td>
		        <td>&nbsp;</td>
		        <td class="style2">Data Final:</td>
		        <td>&nbsp;</td>
		    </tr>
		    <tr>
		        <td><input name="ini" type="text" size="12" maxlength="10" value="<?php echo $ini; ?>" onKeyPress="return maskEvent(this, 10, '##/##/####', event)"></td>
	       		<td><input name="gra" type="hidden" value="<?php echo $gra; ?>">&nbsp;A&nbsp;</td>
		        <td><input name="fim" type="text" size="12" maxlength="10" value="<?php echo $fim; ?>" onKeyPress="return maskEvent(this, 10, '##/##/####', event)"></td>
		        <td><div align="center"><input name="btnPesquisar" type="submit" class="caixa1" id="btnPesquisar" value="Pesquisar"></div></td>
            </tr>
	     </table>
		 </form>
		 </th>
	  <tr>
		 <th><br/>
		    <table width="60%" border="1" cellspacing="0" bordercolor="#000000" align="center">
		        <tr><td colspan="2"><div align="center" class="style17">&nbsp;<br/><?php echo $titulo; ?><br/>&nbsp;</div></td></tr>
    		    <?php $i=0; ?>
	   		    <?php do { ?>
    		    <tr bgcolor="<?php echo (($i%2)==0)?'#EEF3F7':'#9FC0E1' ?>">
	      	      <td align="left"  class="style6" width="90%"><?php echo $row_sql['nome']; ?></td>
	      	      <td align="right" class="style6" width="10%"><?php echo $row_sql['qtde']; ?></td>
			    </tr>
 			    <?php $i++; ?>
    		    <?php 
	   		    	if ( $i == 1 ) $tot = $row_sql['qtde'];	
	   		    } while ($row_sql = mysql_fetch_assoc($sql)); 
	   		    ?>
				
			    <tr>
			        <td class="style18" colspan="2">
			        	<form action="gera_grafico.php" name="form_graf_ordens" method="post">
							<input type="hidden" name="dtinicial" value="<?php echo $ini; ?>">
							<input type="hidden" name="dtfinal"   value="<?php echo $fim; ?>">
							<input type="hidden" name="grafico"   value="<?php echo $gra; ?>">
							<input type="hidden" name="total"     value="<?php echo $tot; ?>">
							<input type="submit" name="btnDetalhes" value="Mais detalhes..." class="caixa1">&nbsp;&nbsp;
					 	</form>
					</td>
			      </tr>
         	</table>
    	    <p>
    	    	<a href="index.php" class="style5 style3">&lt;&lt; Voltar</a>
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
