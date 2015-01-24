<?php
session_start();
 
function VerificaNivel($nv) {
	if ( (!isset($_SESSION['user'])) || (!isset($_SESSION['nivel'])) ) {
	     header("Location: login.php"); 
	} 
	if ($_SESSION['system'] != 'informatica') {
 	     header("Location: login.php"); 
	} 
	$str = StrZero( decbin( $nv ), 3 );	

	if ( substr( $str, $_SESSION['nivel']-1, 1 ) != 1 ) {
	     header("Location: login.php"); 
	}
} 

function StrZero($txt,$num) {
    $rtn = '';
	for ($i=0; $i<($num-strlen($txt)); $i++) {
	  $rtn .='0';
	}
	return $rtn.$txt;
}

?>