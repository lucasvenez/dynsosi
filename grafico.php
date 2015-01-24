<?php
require_once('Connections/dbOS.php'); 
require_once('charts.php'); 

$ini = (isset($_GET['ini'])) ? $_GET['ini'] : date('d/m/Y');
$fim = (isset($_GET['fim'])) ? $_GET['fim'] : date('d/m/Y');
$gra = (isset($_GET['gra'])) ? $_GET['gra'] : 'O';

$ini = FormataDataDB($ini);
$fim = FormataDataDB($fim);
if ($gra == 'O') {

	
  $query_sql = "SELECT  
					'Em aberto' nome, 
					count(id) -
					(( SELECT COUNT(id) FROM ordem_servico WHERE (data_baixa!='0000-00-00' or data_baixa is not null or data_baixa!='') and atendente!=0 and (data_e='0000-00-00' or data_e is null or data_e = '') and at = 'N' and data between '$ini' and '$fim' ) +
					( SELECT COUNT(id) FROM ordem_servico WHERE atendente!=0 and (data_e!='0000-00-00' and data_e is not null and data_e!='') and data between '$ini' and '$fim' ))  
					AS qtde 
				FROM ordem_servico
				WHERE data BETWEEN '$ini' and '$fim'
				UNION ";
		
  $query_sql .=  "select 'Solucionadas' nome,count(id) qtde from ordem_servico
				 where (data_baixa!='0000-00-00' or data_baixa is not null
				      or data_baixa!='') and atendente!=0 and (data_e='0000-00-00'
				      or data_e is null or data_e = '') and at = 'N' and
					  data between '$ini' and '$fim'
				 union
				 select 'Assist. Tecnica' nome,count(id) qtde from ordem_servico
				 where atendente!=0 and (data_e!='0000-00-00' and
				       data_e is not null and data_e!='') and
					   data between '$ini' and '$fim'
			     order by qtde desc";
}
if ($gra == 'M') {
  $query_sql = "select '<center><br/><strong><i>nenhum registro encontrado</i></strong><br/><br/></center>' nome,'' qtde";
}
if ($gra == 'D') {
  $query_sql = "select d.nome_popular nome, COUNT(os.localizacao) qtde
                from os.ordem_servico AS os, comum.depto d
                where os.localizacao = d.codigo_depto  and
					   data_baixa between '$ini' and '$fim'
                group by os.localizacao
                order by qtde desc";
}
if ( $gra == 'C' ) {
  $query_sql = "select c.descricao nome, COUNT(os.componente) qtde
				from os.ordem_servico AS os, comp_defeito c
				where os.componente = c.id  and
					   data between '$ini' and '$fim'
				group by os.componente
				order by qtde desc";
}
if ( $gra == 'A' ) {
  $query_sql = "select a.apelido nome, COUNT(os.atendente) qtde
				from os.ordem_servico os, atendente a
				where os.atendente = a.id  and
					  data between '$ini' and '$fim'
				      and a.termino>='$ini'
				group by os.atendente
				order by qtde desc";
}

mysql_select_db($database_dbOS, $dbOS);
$sql = mysql_query($query_sql, $dbOS) or die(mysql_error());
$tot = mysql_num_rows($sql);

mt_srand( date(s) );

//Configuração do Grafico   
//if ($tot > 10) {
//   $chart['chart_grid_h'] = array ( 'thickness'=>1 );
//   $chart['chart_type']  = "column";
//} else {
   $chart['chart_grid_h'] = array ( 'thickness'=>0 );
   $chart['chart_type']  = "3d pie";
//}

for ( $i=0; $i <= $tot; $i++ ) {
	if ($chart['chart_type'] == 'column') {
	   $chart["chart_data"][$i][0] = TiraAcento($row_sql['nome']);
	   $chart["chart_data"][$i][1] = $row_sql['qtde'];
	} else {
	   $chart["chart_data"][0][$i] = TiraAcento($row_sql['nome']);
	   $chart["chart_data"][1][$i] = $row_sql['qtde'];
	}
	if ($i > 0) { $chart['series_color'][$i] = GeraCor($i); }
	$row_sql = mysql_fetch_assoc($sql);
}

$chart['chart_pref']   = array ( 'rotation_x'=>60 ); 
$chart['chart_rect']   = array ( 'x'=>40, 'y'=>10, 'width'=>200, 'height'=>200, 'positive_alpha'=>0 );
$chart['chart_transition'] = array ( 'type'=>"spin", 'delay'=>.5, 'duration'=>.75, 'order'=>"category" );
$chart['chart_value'] = array ( 'color'=>"000000", 'alpha'=>65, 'font'=>"arial", 'bold'=>true, 'size'=>10, 'position'=>"outside", 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );
//$chart['draw'] = array ( array ( 'type'=>"text", 'color'=>"000000", 'alpha'=>15, 'font'=>"arial", 'size'=>140, 'x'=>-50, 'y'=>0, 'width'=>500, 'height'=>50, 'text'=>"ORDENS DE SERVICO", 'h_align'=>"center", 'v_align'=>"middle" )) ;
$chart['legend_label'] = array ( 'layout'=>"horizontal", 'bullet'=>"circle", 'font'=>"arial", 'bold'=>true, 'size'=>10, 'color'=>"000000", 'alpha'=>85 ); 
$chart['legend_rect'] = array ( 'x'=>300, 'y'=>0, 'width'=>50, 'height'=>110, 'margin'=>10, 'fill_color'=>"ffffff", 'fill_alpha'=>10, 'line_color'=>"000000", 'line_alpha'=>0, 'line_thickness'=>0 );  
$chart['legend_transition'] = array ( 'type'=>"dissolve", 'delay'=>0, 'duration'=>1 );

SendChartData( $chart ); 

function FormataDataDB($data) {
   if ($data == '') {
      return '';
   } else {
      $dt = explode('/',$data);
      return $dt[2] . '-' . $dt[1] . '-'. $dt[0];
   }
}

function GeraCor($idx) {
	$red  = (($idx % 3) == 0) ? dechex(mt_rand(200,255)) : dechex(mt_rand(0,200));
	$gree = (($idx % 3) == 1) ? dechex(mt_rand(200,255)) : dechex(mt_rand(0,200));
	$blue = (($idx % 3) == 2) ? dechex(mt_rand(200,255)) : dechex(mt_rand(0,200));
	return StrZero($red,2).StrZero($gree,2).StrZero($blue,2);
}

function StrZero($txt,$num) {
    $rtn = '';
	for ($i=0; $i<($num-strlen($txt)); $i++) {
	  $rtn .='0';
	}
	return $rtn.$txt;
}

function TiraAcento($txt) {
   $spec = "áéíóúçâêîôûçãéíõúçàèìòùçäëïöüçÁÉÍÓÚÇÂÊÎÔÛÇÃÉÍÕÚÇÀÈÌÒÙÇÄËÏÖÜÇ";
   $char = "aeiouc";
   
   for ($i=0; $i<(strlen($spec)-1); $i++) {
	  $pos = ($i >= 6) ? ($i%6) : $i;
      $txt = str_replace( substr($spec,$i,1), substr($char,$pos,1), $txt);
   }
   return ucwords(strtolower($txt));
}
?>