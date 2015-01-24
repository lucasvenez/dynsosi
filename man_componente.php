<?php
require_once("verificalogin.php");
VerificaNivel(4); 

if ((isset($_POST['op'])) && ($_POST['op'] != '')) {

    if ($_POST['op'] == 'E') {
       header("Location: cad_componente.php?id=".$_POST['id']); 
	} 

    require_once("Connections/dbOS.php");
    mysql_select_db($database_dbOS, $dbOS);

	if ($_POST['op'] == 'D') {
       $deleteSQL = "DELETE FROM comp_defeito WHERE id=" . $_POST['id'];   
       $Result1 = mysql_query($deleteSQL, $dbOS) or die(mysql_error());

       header("Location: cons_componente.php"); 
	}

	if ($_POST['op'] == 'I') {                      
	   $insertSQL = sprintf("insert into comp_defeito (descricao) values (%s)",SQLTxt($_POST['descricao']) );					   
 	   $Result1 = mysql_query($insertSQL, $dbOS) or die(mysql_error());						   
       header("Location: cons_componente.php"); 
	}	
		 
	if ($_POST['op'] == 'U') {
 	    $updateSQL = sprintf("update comp_defeito set descricao=%s where id=".$_POST['id'],
						 SQLTxt($_POST['descricao']) );
  		$Result1 = mysql_query($updateSQL, $dbOS) or die(mysql_error());						   
        header("Location: cons_componente.php"); 
	}	
}

function SQLTxt($value) {
     $value = ($value != "") ? "'" . $value . "'" : "NULL";
	 return $value;
}

?>