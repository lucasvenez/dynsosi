/**
 *
 * function mask(_mask, val)
 *
 * _mask = Mascara Exemplo: ##/##/#### ou ###.###.###-##
 * val   = Valor a ser formatado.
 *
 * Formata um valor  para a mascara definida.
 *
 * pedro.leao@ig.com.br 2003/08/16
 */
function mask(_mask, val) {
	var i, mki;
	var aux="";
	
	for(i=mki=0; i<val.length; i++, mki++) {
		if(_mask.charAt(mki)=='' || _mask.charAt(mki)=='#' || _mask.charAt(i)==val.charAt(i)) {
			aux+=val.charAt(i);
		} else {
			aux+=_mask.charAt(mki)+val.charAt(i);
			mki++;
		}
	}
	return aux;
}

/**
 * function maskEvent(field, _mask, event)
 *
 * field = Objeto que esta enviando o evendo onKeyPress()
 * _mask = Mascara Exemplo: ##/##/#### ou ###.###.###-##
 * event = Evento a ser observado.
 *
 * Formata um valor para a mascara definida conforma o valor vai sendo digitado.
 */
function maskEvent(field, field_size, _mask, event) {
	var key ='';
	var aux='';
	var len=0;
	var i=0;
	var strCheck = '0123456789';
	var rcode = (window.Event) ? event.which : event.keyCode;

	if((rcode == 13) || (rcode == 8) || (rcode == 9) || (rcode == 0)) {
		//Enter         BreakSpace       TAB             OUTROS
		return true;
	}

    if(field.value.length < field_size) {
  		//Get key value from key code
		key=String.fromCharCode(rcode);
	
		if(strCheck.indexOf(key)==-1) {
			//Not a valid key
			return false;
		}
	
		aux=field.value+key;
		//window.alert(aux);
		aux=mask(_mask,aux);
		//window.alert(aux);
		field.value=aux;	
	}
	return false;
}

/**
 *
 * function currencyFormat(fld, milSep, decSep, e)
 *
 * fld    = Objeto a ser verficado.
 * milSep = Separador para milhar.
 * decSep = Separador para decimal.
 * e      = Evento.
 *
 * Formata um valor decimal conforme for digitado no box.
 * Criação: Anonima (coletada em http://http://www.scriptbrasil.com/?class=2&secao=javascript&categoria=Formulários&menu=javascript&ini=1
 * Revisao: pedro.leao@ig.com.br	2003/08/16
 */
function currencyFormat(fld, milSep, decSep, e) {
	var sep = 0;
	var key = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '0123456789';
	var aux = aux2 = '';
	var whichCode = (window.Event) ? e.which : e.keyCode;

	if (whichCode == 13) {
		return true;  // Enter
	}
	key = String.fromCharCode(whichCode);  // Get key value from key code
	if (strCheck.indexOf(key) == -1) {
		return false;  // Not a valid key
	}
	len = fld.value.length;
	for(i = 0; i < len; i++) {
		if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)){
			 break;
		}
	}
	
	aux = '';
	for(; i < len; i++) {
		if (strCheck.indexOf(fld.value.charAt(i))!=-1){
			aux += fld.value.charAt(i);
		}
	}
	aux += key;
			
	len = aux.length;
	if (len == 0) {
		fld.value = '';
	} else if (len == 1) {
		fld.value = '0'+ decSep + '0' + aux;
	} else if (len == 2) {
		fld.value = '0'+ decSep + aux;
	} else if (len > 2) {
		aux2 = '';

		for (j = 0, i = len - 3; i >= 0; i--) {
			if (j == 3) {
				aux2 += milSep;
				j = 0;
			}
			aux2 += aux.charAt(i);
			j++;
		}
		fld.value = '';
		len2 = aux2.length;
		for (i = len2 - 1; i >= 0; i--) {
			fld.value += aux2.charAt(i);
		}
		
		fld.value += decSep + aux.substr(len - 2, len);
	}
	return false;
}
