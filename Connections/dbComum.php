<?php

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

if ( !isset( $xml ) ) {
	
	require_once( "xml_parser.php" ); 
	
	$xml = new xml_parser;
	$result = $xml->parser("Connections/parameters.xml",true); 
}

$hostname_dbComum = $xml->get_element_value('servidor_db');
$database_dbComum = "comum";
$username_dbComum = "anonymous";
$password_dbComum = "";

$dbComum = mysql_connect($hostname_dbComum, $username_dbComum, $password_dbComum) or trigger_error(mysql_error(),E_USER_ERROR) or die ("erro");
?>