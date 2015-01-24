<?php
$email 	= $_POST['email'];
$senha	= $_POST['senha'];

/**
 * Níveis de acesso:
 * 	1 - Administrador;
 *  2 - Atendente;
 *  3 - Usuário;
 */
if ( !isset($_POST["loginadministrativo"]) ) {
		 
	include('./Connections/dbComum.php');
	
	mysql_select_db($database_dbComum, $dbComum) or die ( print mysql_error() );
	
	$sql = "SELECT 
				cpf_servidor, 
				senha_servidor, 
				nome_servidor 
		   FROM 
		   		servidor 
		   WHERE 
		   		email = '$email' 
		   		AND senha_servidor = '$senha'";
	
	$res = mysql_query( $sql ) or die ( print mysql_error() );
	$row = mysql_fetch_assoc($res);
	$tot = mysql_num_rows($res);	
	
	if ( $tot > 0 ) {
		
	    session_start();
	    
	    $_SESSION['user']  = $row['cpf_servidor'];
	    $_SESSION['nome']  = $row['nome_servidor'];
	    $_SESSION['system'] = 'informatica';
	    $_SESSION['session'] = session_id();
	    
		$nv = 3;
	
		$sql = "SELECT " .
					"nivel_acesso, " .
					"codigo_depto, " .
					"codigo_sistema " .
			   "FROM " .
			   		"servidor_permissao " .
			   "WHERE " .
			   		"habilitado='S' AND " .
			   		"cpf_servidor='$cpf'";
	 
		$res=mysql_query($sql);
		$row=mysql_fetch_assoc($res);
		$tot=mysql_num_rows($res);
		
		if ($tot > 0) {
			
	        $_SESSION['depto'] = $row['codigo_depto'];
	        
			do {
				
				if ( ($row['codigo_sistema'] == 'os' ) && ($row['nivel_acesso'] == 9) ) {
					$nv = 1;
				}
				
			} while ($row = mysql_fetch_assoc($res));
		}
		 
	    $_SESSION['nivel'] = $nv;
	
	    header("Location: index.php");
	}
	else {
		
		header( "Location: login.php" );
	}
} else {
	
    require_once('./Connections/dbOS.php');
    
	mysql_select_db($database_dbOS, $dbOS);
	
	$sql = "SELECT 
				apelido, 
				senha, 
				nivel 
			FROM atendente 
            WHERE apelido = '$email' 
	              AND senha = '$senha'";

    $res = mysql_query($sql);
    $row = mysql_fetch_assoc($res);
    $tot = mysql_num_rows($res);

    if ($tot > 0 ) {
    	 
       session_start();
       
       $_SESSION['user'] = $row['apelido'];
       $_SESSION['nivel'] = ($row['nivel']==9) ? 1 : 2;
       $_SESSION['system'] = 'informatica';
       $_SESSION['session'] = session_id();
    }

    if ($_SESSION['nivel'] == 1) {
    	
	    header("Location: index.php"); 
    } 
    else {
    	
	    header("Location: ordens_servico_abertas.php"); 
    }
}

mysql_free_result($res);
?>