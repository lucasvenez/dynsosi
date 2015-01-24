<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
if (!isset($xml)) {
	
	require_once("xml_parser.php");
	 
	$xml = new xml_parser;
	$result = $xml->parser("Connections/parameters.xml",true); 
}

$hostname_dbLevto = $xml->get_element_value('servidor_db');
$database_dbLevto = "levto";
$username_dbLevto = "anonymous";
$password_dbLevto = "";
$dbLevto = mysql_connect($hostname_dbLevto, $username_dbLevto, $password_dbLevto) or trigger_error(mysql_error(),E_USER_ERROR); 
?>