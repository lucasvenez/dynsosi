<?php
if ( isset( $_REQUEST["cep"] ) ) {
	
	$cep = $_REQUEST["cep"];
	
	$dom = new DOMDocument();

	$dom->load( "http://ceplivre.pc2consultoria.com/index.php?module=cep&cep=" . $cep . "&formato=xml" );
	
	header('Content-type: text/xml');
	print( $dom->saveXML() ); 
}
?>
