<form action="./"  name="formmenu_esq" method="post">
<input name="menu_esq1" type="hidden" value="<?php if( isset($_REQUEST['menu_esq1']) ) { echo $_REQUEST['menu_esq1'];}?>"/>
<input name="menu_esq2" type="hidden" value="<?php if( isset($_REQUEST['menu_esq2']) ) { echo $_REQUEST['menu_esq2'];}?>"/>
<table width="100"  border="0" cellpadding="0" cellspacing="0" id="menu_esquerdo">
  <tr> 
    <td valign="top" class="MenuEsqDetalhe">
      <table width="100px" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td><img src="../imagens/spacer.gif" width="50" height="2"/></td>
        </tr>
      </table>
    </td>
  </tr>
    <tr> 
    <td class="MenuEsqDivisor">&nbsp;</td>
  </tr>
  <tr> 
    <td class="MenuEsqFundo"><a href="login.php" class="MenuEsqEfeito">Inicio</a></td>
  </tr>
  <tr> 
    <td class="MenuEsqDivisor">&nbsp;</td>
  </tr>
  <tr> 
    <td class="MenuEsqFundo"><p><a href="cadastro.php" class="MenuEsqEfeito">Cadastro SOSI</a></p></td>
  </tr>
  <tr> 
    <td class="MenuEsqDivisor">&nbsp;</td>
  </tr>
  <tr>
    <td class="MenuEsqFundo"><p><a href="recuperasenha.php" class="MenuEsqEfeito">Esqueci a Senha</a></p></td>
  </tr>
  <tr> 
    <td class="MenuEsqDivisor">&nbsp;</td>
  </tr>
   <tr>
  <td class="MenuEsqFundo"><p><a href="../informatica/index.php" target="_blank" class="MenuEsqEfeito">Contato</a></p></td>
   </tr>
  <tr> 
    <td class="MenuEsqDivisor">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</form>
