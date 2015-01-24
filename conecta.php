<?
//DADOS PARA CONEXÃO
$servidor = "localhost";   //SERVIDOR
$bd       = "comum";       //DATABASE
$usuario  = "anonymous";   //USUÁRIO
$senha    = "";            //SENHA

$conexao = mysql_connect( $servidor, $usuario, $senha );
$db = null;

if ( $conexao ) {
	
	$db = mysql_select_db($bd, $conexao);
}     
?>