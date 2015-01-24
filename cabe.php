<?php
if (!isset($xml)) {
	
	require_once("xml_parser.php"); 
	$xml = new xml_parser;
	$result = $xml->parser("Connections/parameters.xml",true); 
}
?>


<table width="580" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th><img src="img/sosi2.jpg"><br/>
      <span class="style1">Sistema de Ordem de Servi&ccedil;o de Inform&aacute;tica</span></th>
  </tr>
  <tr>
    <th>&nbsp;</th>
  </tr>
  <tr>
    <?php if (isset($_SESSION) ) if ($_SESSION['nivel'] == 1) { ?>
       <th height="24" nowrap><img src="img/baradm1.jpg" align="absmiddle"></th>
	<?php } else if (isset($_SESSION) ) if ($_SESSION['nivel'] == 2) { ?>
       <th height="24" nowrap><img src="img/barest1.jpg" align="absmiddle"></th>
	<?php } else if (isset($_SESSION) ) if ($_SESSION['nivel'] == 3) { ?>
       <th height="24" nowrap><img src="img/barusu1.jpg" align="absmiddle" /></th>
	<?php } else { ?>
       <th height="24" nowrap><img src="img/bariden1.jpg" align="absmiddle"></th>
	<?php }  ?>	  
  </tr>
</table>
