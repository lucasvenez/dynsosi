<?
//DADOS PARA CONEX�O
$servidor = "localhost";   //SERVIDOR
$bd       = "comum";       //DATABASE
$usuario  = "anonymous";   //USU�RIO
$senha    = "";            //SENHA

$conexao = mysql_connect( $servidor, $usuario, $senha );
$db = null;

if ( $conexao ) {
	
	$db = mysql_select_db($bd, $conexao);
}     
?>