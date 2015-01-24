<?php
require_once("verificalogin.php");  VerificaNivel(1);
require_once("Connections/dbOS.php"); 
require_once("Connections/dbComum.php");


/*
 * Variables
 */

$cpf          = $_POST["usuario"];
$requisitante = $_POST['requisitante'];

$localizacao  = $_POST['localizacao'];
$sala         = $_POST['sala'];

$ramal        = $_POST['ramal'];

$componente   = $_POST['componente'];
$defeito      = $_POST['defeito'];

$data         = date("d/m/Y");
$hora         = date('H:i:s');

$ip           = $_POST['ip'];

//Inseri ordem de servido no banco
mysql_select_db( $database_dbOS, $dbOS );

$insertSQL = sprintf(
	"INSERT INTO ordem_servico (
		data, 
		hora, 
        usuario, 
	    ip, 
        localizacao, 
 	    requisitante, 
		ramal, 
		ai,
		patrimonio, 
		comodato, 
		componente, 
		defeito, 
		sala) 
	 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
		SQLTxt(FormataDataBD($data)), 
		SQLTxt($hora),
		SQLTxt($cpf), 
		SQLTxt($ip),
		SQLTxt($localizacao), 
		SQLTxt($requisitante),
		SQLTxt($ramal),
		SQLTxt("0000"),
		SQLTxt("0000"),
		SQLTxt("0000"),
		SQLTxt($componente),
 		SQLTxt($defeito),
		SQLTxt($sala));
					   
$Result1 = mysql_query($insertSQL, $dbOS) or die(mysql_error());						   

/*
 * Caso o equipamento ja retornou da Assist.Tecnica e ainda não foi informada a data de saida, mada um email
 */
$sql_OS = sprintf("SELECT id, data, hora, ai, fi, at, data_e, data_s, data_baixa, hora_baixa
				   FROM ordem_servico
				   WHERE IFNULL(data_e, '') <>'' AND data_e <> '0000-00-00'
					      AND (IFNULL(data_s, '') = '' OR data_s = '0000-00-00')
					      AND fi <> '' AND ai <> '9999999999' AND ai = %s", SQLTxt($_POST['ai']) );
					 
$qry_OS = mysql_query($sql_OS, $dbOS) or die ( mysql_error() );
$row_OS = mysql_fetch_assoc($qry_OS);
$t_rows = mysql_num_rows($qry_OS);

if ($t_rows > 0) {
	
    $corpo     = "EQUIPAMENTO RETORNOU DA ASSISTÊNCIA TÉCNICA E NÃO FOI CADASTRADO A DATA DE RETORNO!!!\n\n";
    $corpo    .= "Data: " . FormataData($row_OS['data']) . "\n";
    $corpo    .= "Hora: " . $row_OS['hora'] . "\n";
    $corpo    .= "AI: "   . $row_OS['ai'] . "\n";
    $corpo    .= "FI: "   . $row_OS['fi'] . "\n";
    $corpo    .= "Data Entrada: " . FormataData($row_OS['data_e']) . "\n";
    $corpo    .= "Data Baixa: "   . FormataData($row_OS['data_baixa']) . "\n";
    $corpo    .= "Hora Baixa: "   . $row_OS['hora_baixa'] . "\n";
    $corpo    .= "\n\nWebmaster";
    
    mail( "sti@ourinhos.unesp.br", "[SOSI] Equipamento inexistente no levantamento", $corpo, "From: SOSI <sti@ourinhos.unesp.br>\r\n"); 

} else {
	
	/*
	 * Consulta aos schemas comum e os.
	 */
	
	/*
	 * Instrução SQL utilizada para recuperar o id da ordem de serviço efetuada.
	 */
	$query = "SELECT MAX(id) " . 
			 "FROM ordem_servico"; 
	
	$resultSet = mysql_query( $query, $dbOS ) or die ( mysql_error() );
	$result    = mysql_fetch_array ( $resultSet );
	$numero    = $result[0];
	
	/*
	 * Instrução SQL utilizada para recuperar o nome do componente que será reparado.
	 */
	$query = "SELECT descricao " . 
			 "FROM comp_defeito " . 
			 "WHERE id = $componente";
	
	$resultSet  = mysql_query( $query, $dbOS ) or die ( mysql_error() );
	$result     = mysql_fetch_array ( $resultSet );
	$componente = $result[0];
	
	/*
	 * Selecionando o schema comum
	 */
	mysql_select_db( $database_dbComum, $dbComum );

	/*
	 * Instrução SQL utilizada para recuperar o local onde está o problema. 
	 */
	$query = "SELECT nome_depto " .
			 "FROM depto " .
			 "WHERE codigo_depto = '$localizacao'";
	
	$resultSet   = mysql_query( $query, $dbComum ) or die ( mysql_error() );
	$result      = mysql_fetch_array ( $resultSet );
	$localizacao = $result[0];
	
	/*
	 * Instruçao SQL utilizada para recuperar o e-mail do usuário solicitante
	 */
	$query = "SELECT email " .
			 "FROM servidor " .
			 "WHERE cpf_servidor = '$cpf'";
	
	$resultSet = mysql_query( $query, $dbComum ) or die ( mysql_error( $dbComum ) );
	$result    = mysql_fetch_array( $resultSet );
	$email     = $result[0];
	
	/*
	 * E-mails.
	 */
	
	$headers  = "From: SOSI <sti@ourinhos.unesp.br>";
		
	/*
	 * E-mail a ser enviado para os atendentes.
	 */
	
	$mensagem  = "Solicitação de Ordem de Serviço efetuada por $requisitante [ramal: $ramal]\n\n";

	$mensagem .= "=====================================================\n";
	
	$mensagem .= "Localização:  $localizacao\n";
	$mensagem .= "Sala: $sala\n";
	
	$mensagem .= "Dia: " . date("d/m/Y") . "\n";
	$mensagem .= "Hora: " . date("H:i:s") . "\n";
	
	$mensagem .= "Componente: $componente\n";
	
	$mensagem .= "Defeito: $defeito\n";
	
	$mensagem .= "=====================================================";
	
	mail( "sti@ourinhos.unesp.br", "[SOSI] Ordem de serviço $numero", $mensagem, $headers );
		
	/*
	 * E-mail a ser enviado para o cliente que efetuou a ordem de serviço.
	 */
	
	$mensagem  = "Caro Requisitante,\n\n";
	
	$mensagem .= "Sua solicitação de ordem de serviço foi efetuada com sucesso.\n\n";
	
	$mensagem .= "=====================================================\n";
	$mensagem .= "Número da Ordem de serviço: $numero\n\n";
	$mensagem .= "Dia: " . date("d/m/Y") . "\n";
	$mensagem .= "Hora: " . date("H:i:s") . "\n\n";
	
	$mensagem .= "Componente: $componente\n";
	
	$mensagem .= "Defeito: $defeito\n";
	$mensagem .= "=====================================================\n\n";

	$mensagem .= "Em no máximo 48 horas haverá um parecer sobre o problema.\n\n";
	
	$mensagem .= "Atenciosamente\n";
	$mensagem .= "Seção Técnica de Informática";
	
	mail( $email, "[SOSI] Solicitação efetuada com sucesso" , $mensagem, $headers );
}	

mysql_close( $dbComum );
mysql_close( $dbOS );

//Mensagem OK
echo '<script language="javascript">';
echo '  alert("Pedido de Ordem de Serviço registrado com sucesso!");';
echo '  window.location = "index.php"; ';
echo '</script>';					   

function SQLTxt($value) {
     $value = ($value != "") ? "'" . $value . "'" : "NULL";
	 return $value;
}
function FormataDataBD($data) {
   $dt = explode('/',$data);
   return $dt[2] . '-' . $dt[1] . '-'. $dt[0];
}
function FormataData($data) {
   $dt = explode('-',$data);
   return $dt[2] . '/' . $dt[1] . '/'. $dt[0];
}

?>