<?php 
require_once("verificalogin.php"); VerificaNivel(1);
require_once("Connections/dbOS.php");
mysql_select_db($database_dbOS, $dbOS);

if (isset($_POST["id"]))
	
$sql = "DELETE FROM ordem_servico WHERE id = ".$_POST['id'];

$qry = mysql_query($sql, $dbOS);

header("Content-Type:text/plain");

if (!$qry) {
 	echo "false";
} else {
	echo "true";
}
?>