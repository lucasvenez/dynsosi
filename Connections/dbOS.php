<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
if (!isset($xml)) {
	
	require_once("xml_parser.php"); 
	$xml = new xml_parser;
	$result = $xml->parser("Connections/parameters.xml",true); 
}

$hostname_dbOS = $xml->get_element_value('servidor_db');
$database_dbOS = "os";
$username_dbOS = "anonymous";
$password_dbOS = "";

$dbOS = mysql_connect($hostname_dbOS, $username_dbOS, $password_dbOS) or trigger_error(mysql_error(),E_USER_ERROR); 
?>