
<html>
<head>
<title>:: UNESP - Campus Experimental de Ourinhos ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="./css/styles.css" rel="stylesheet" type="text/css">
<link href="../folha.css" rel="stylesheet" type="text/css">
<link href="../imprimir.css" rel="stylesheet" media="print" type="text/css">

</head>

<body onLoad="javascript: document.form.n_cod_tipo.focus();" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="FundoPaginaInterna">
<?php include "./ssi_topo.php"; ?>
<table width="770" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="150" height="86">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="615">&nbsp;</td>
    </tr>
    <tr>
      <td width="150" valign="top" class="container-menu-esquerdo">
      
<?php include "./ssi_menu_esquerdo.php"; ?>
      </td>
    <TD width=10>&nbsp;</TD>
    <TD vAlign=top width="615">
      <TABLE id="Nome da Area" cellSpacing=0 cellPadding=0 width="615" border=0>
        <TR>
          <TD vAlign=top height=20 width="615">
            <TABLE id=conteudo cellSpacing=0 cellPadding=0 width="615" border=0>
              <TR>
                <TD class=NomeArea height=20>SOSI (Sistema de Ordem de Servi&ccedil;o de Inform&aacute;tica) :::</TD>
              </TR>			    		  
              <TR>
                <TD height="40" valign="middle"> <span class="TituloDestaque2"> 
                  Cadastro SOSI<br/>
                </span></TD>
              </TR>
              <TR>
                <TD valign="top" height="300">
					<table width="100%" cellpadding="1" cellspacing="1">				
<?php
					$confirmado = $_GET["confirmado"];
				
					if ($confirmado == "S")
					{
?>
	                    <tr> 
	                      
                      <td><span class="style2 style1 Texto"><strong><br/>
                        <br/>
                        SUCESSO</strong></span></td>
	                    </tr>
	                    <tr> 
	                      <td class="style2 style1 DivisorHorizontal">&nbsp;</td>
	                    </tr>
	                    <tr> 
	                      <td><p class="style9">O cadastro no sistema SOSI foi 
	                        efetivado.<br/>
	                        Em instantes voc&ecirc; receber&aacute; um e-mail com os dados de login.</p>
	                        </td>
	                    </tr>
<?php
					}
					else
					{
?>					
	                    <tr> 
	                      
                      <td><span class="style2 style1 Texto"><strong><br/>
                        <br/>
                        <span class="style11">AVISO!</span></strong></span></td>
	                    </tr>
	                    <tr> 
	                      <td class="style2 style1 DivisorHorizontal">&nbsp;</td>
	                    </tr>
	                    <tr> 
	                      
                      <td><span class="style5"><span class="style10">Os dados informados 
                        para cadastro est&atilde;o incorretos. </span><br/>
                        <br/>
                        <span class="style10">Clique em</span> <a href="cadastro.php" class="LinkLaranja">voltar</a> 
                        <span class="style10">na tela de castro e tentar novamente.</span><br/>
                        <br/>
                        </span></td>
	                    </tr>
<?php
					}
?>
                  </table>
                </TD>
			  </TR>
              <tr> 
                  <td class="DivisorHorizontal">&nbsp;</td>
              </tr>
		</TABLE></TD></TR></TABLE>
	</TD></TR></TABLE>
<?php include "./ssi_rodape.php"; ?></BODY></HTML>