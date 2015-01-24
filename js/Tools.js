/**
 * Classe com métodos úteis
 * @author Lucas Venezian Povoa
 * @since 11/01/2010
 * @constructor
 */
Tools = function() {};

//Herança com a classe Object
Tools.prototype = new Object();

Tools = {

	/**
	 * Método utilizado para capturar o valor de um determinado parâmetro.
	 * @param String param - nome do parâmetro passado da URL.
	 * @return o valor do parâmetro param
	 */		
	getParamValue: function( param ) { 
	
		var loc = location.search.substring( 1, location.search.length );   
		var paramValue = false;   
		var params = loc.split( "&" ); 
		
		for ( i = 0; i < params.length; i++ ) {
		  
			param_name = params[i].substring( 0, params[i].indexOf( "=" ) );
	      
			if ( param_name == param ) 			  
			    paramValue = params[i].substring( params[i].indexOf( "=" ) + 1 );   
		}   
		  	  
		  if ( paramValue )
		      return paramValue;      
		  else
		      return false;   
	},

	/**
	 * Método com a finalidade de retornar os valores após o último simbolo Sustenido.
	 * @author Lucas Venezian Povoa
	 * @return o valor após o último símbolo # da URL
	 */
	getMark: function() {
	
		var value = false;
		var loc = location.toString();
	
		if ( loc.lastIndexOf( '#' ) > 0 )
			value = loc.substring( loc.lastIndexOf( '#' ) + 1, loc.indexOf( "?" ) == -1 ? loc.length : loc.indexOf( "?" ) );
		
		return value;
	},

	/**
	 * @author Lucas Venezian Povoa
	 * @since 29/12/2009
	 * @param string nickname - login utilizado pelo usuário.
	 * @param string password - senha para avaliação de segurança.
	 * @return nota entre zero e dez, sendo que,
	 * 		valores entre zero e cinco representam um nível fraco de segurança; 
	 * 		valores entre seis e sete representam uma senha de nível médio;
	 * 		valores entre oito e nove representam uma senha de nível forte e;
	 * 		valor igual a dez representa uma senha de nível muito forte.
	 *	
	 *	@category
	 	<p>Critérios para uma boa senha:</p>
	
		<p>Níveis de seguraça: Fraco, Médio, Forte, Muito Forte<p>
	
		<p>Conjuntos de caracteres: [a-z] (1), [A-Z] (2), [0-9] (3), ["-;] (4)<p>
	
		<p>Muito Frote (Azul escuro):<p>
		 	<ul>
				<li>Possuir no mínimo oito caracteres; (4)</li>
				<li>Possuir no mínimo dois caracteres de cada conjunto; (4)</li>
				<li>Não ser uma substring de seus nickname; (2)</li>
			</ul>
	
		<p>Forte (Verde):</p>
			<ul>
				<li>Possuir no mínimo seis caracteres; (3)</li>
				<li>Possuir caracteres de três conjuntos; (3)</li>
				<li>Não ser uma substring equivalente ao nickname; (2)</li>
			</ul>
		<p>Médio (Amarelo):</p>
			<ul>
				<li>Possuir no mínimo quatro caracteres; (2)</li>
				<li>Possuir caracteres de dois conjuntos; (2)</li>
				<li>Não ser uma substring de seu nickname; (2)</li>
			</ul>
		
		<p>Fraco (Vermelho):</p>
			<ul>
				<li>Possuir menos que quatro caracteres; (0)</li>
				<li>Ser uma substring de seu nickname; (0)</li>
				<li>Possuir caracteres de um único conjunto; (0)</li>
			</ul>
	
		<p>Informações para o algoritmo:</p>
			
			<ul>
				<li>As senhas receberão notas quantitativas numeradas de zero a dez;<li>
				<li>Cada critério receberá uma pontuação;</li>
				<li>Para que a senha tenha um nível de segurançaa muito forte deve-se possuir nota dez;</li>
				<li>Para que a senha tenha um nível de segurançaa forte deve possuir nota entre oito e nove;</li>
				<li>Para que a senha tenha um nível de segurançaa médio deve possuir nota entre seis e sete;</li>
				<li>Para que a senha tenha um nível de segurançaa fraco deve possuir nota entre zero e cinco;</li>
			</ul>
	 */
	passwordLevel: function( nickname, password ) {
		
		var nota = 0;
	
		/* Avaliando o critério número de caracteres:
		 * >= 8 nota 4;
		 * >= 6 nota 3;
		 * >= 4 nota 2;
		 */
		if ( password.length >= 8 ) {
		
			nota += 4;
		}
		else if ( password.length >= 6 ) {
	
			nota += 3;
		}
		else if ( password.length >= 4 ) {
			
			nota += 2;
		}
		
		/* Verificar se a senha não é uma substring do
		 * login utilizado pelo usuário.
		 * Caso não seja a nota tem acréscimo de dois pontos.
		 */
		if ( nickname.indexOf( password ) < 0 ) {
	
			nota += 2;
		}
		
		/* Verificar quais são os conjuntos existentes na senha.
		 * Caso exista dois caracteres de cada conjunto é acrescentado quatro pontos a nota;
		 * Caso haja caracteres dos conjuntos um, dois e três é acrescentado três pontos a nota;
		 * Caso exista caracteres que pertençam somente ao conjunto um e três é acrescentado dois pontos a nota; 
		 */
		nota += this._checkSets( password );
		
		return nota;
	},

	/**
	 * Método utilizado para checar quais são os conjuntos presentes em uma senha.
	 * @private
	 * @author Lucas Venezian Povoa
	 * @param String password - a senha a ser analisada.
	 * @return int - nota entre zero e quatro.
	 */
	_checkSets: function( password ) {
			
		var result = 0;
		
		var stringSetOne   = "abcdefghijklmnopqrstuvwxyz";	
		var stringSetTwo   = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		var stringSetThree = "0123456789";
		var stringSetFour  = "'\"¹²³£¢¬!@#$%¨&*()-_=+§ºª`´^~;:.>,<çáàãâéèêíìîóòõôúùû|\\ü";
		
		var inSetOne   = 0;
		var inSetTwo   = 0;
		var inSetThree = 0;
		var inSetFour  = 0;
		
		for ( var i = 0; i < password.length; i++ ) {
			
			if ( stringSetOne.indexOf( password.charAt(i) ) > -1 )
				inSetOne++;
			else if ( stringSetTwo.indexOf( password.charAt(i).toString() ) > -1 )
				inSetTwo++;
			else if ( stringSetThree.indexOf( password.charAt(i).toString() ) > -1 )
				inSetThree++;
			else if ( stringSetFour.indexOf( password.charAt(i).toString() ) > -1 )
				inSetFour++;
		}
		
		if ( inSetOne > 1 && inSetTwo > 1 && inSetThree > 1 && inSetFour > 1 ) 
			result = 4;
		else {
			
			var inSet = 0;
			
			if ( inSetOne > 0 )
				inSet++;
			
			if ( inSetTwo > 0 )
				inSet++;
			
			if ( inSetThree > 0 )
				inSet++;
			
			if ( inSetFour > 0 )
				inSet++;
			
			switch( inSet ) {
		
				case 4: 
					result = 3;
					break;
				case 3: 
					result = 3;
					break;
				case 2: 
					result = 2;
					break;
			}
		}
		
		return result;
	},

	/**
	 * This method is used to alter  atribute class value of elements of a container to null.
	 * 
	 * @param String id é o identificador do elemento onde está os elementos que receberão null como valor do atributo class.
	 * @param String tagName is used to get the elements that will have their class name deleted.
	 */
	clearClass: function( id, tagName ) {
	
		elements = document.getElementById( id ).getElementsByTagName( tagName );
	
		for ( var i = 0; i < elements.length; i++ ) {
	
			if ( window.ActiveXObject ) //Internet Explorer
				elements[i].className = null;
			else //Padrão W3C
				elements[i].setAttribute( "class", null );
		}//fim do for
	},

	/**
	 * Method used to create a div element to insert a message. 
	 * This method should be used with /css/mensagem.css file.
	 * @author Lucas Venezian Povoa
	 * @since 16/07/2010
	 * @param String type [warning, error, success, information]
	 * @param String title is the title of message.
	 * @param String message is the message of the element.
	 * @return HTMLDivElement
	 */
	createMessageElement: function( type, title, message ) {
		
		var mensagem = document.createElement( "div" );
		var titulo   = document.createElement( "h1" );
		var conteudo = document.createElement( "p" );
		var fechar	 = document.createElement( "a" );
		
		mensagem.id = "message";
		mensagem.className = type;
		
		fechar.className = "close";
		fechar.setAttribute( "href", "#" );
		fechar.onclick = function() {
			
			this.parentNode.parentNode.removeChild( this.parentNode );
			return false;
		};		
		
		titulo.innerHTML = title;
		conteudo.innerHTML = message;
		fechar.innerHTML = "[fechar]";
		
		mensagem.appendChild( titulo );
		mensagem.appendChild( conteudo );
		//mensagem.appendChild( fechar );
		
		var message = document.getElementById( "message" );
		
		if ( message != null )
			message.parentNode.removeChild( message );
		
		return mensagem;
	},
	
	/**
	 * This method is used to set the zipCode mask (#####-###) in an input text.
	 * @param Event keypress is the event to get the key pressed.
	 * @param HTMLInputElement input is the text box that will have zipCode mask.
	 * @example <input type='text' onkeydown='javascript: return Tools.zipCodeKeyPress( event, this )'>
	 */
	zipCodeKeyDown: function( keypress, input ) {
		
		var result = false;
		
		var key = window.event ? event.keyCode : keypress.which;
		
		if ( ( ( key > 47 && key < 058 ) || ( key > 95 && key < 106 )) && (!keypress.ctrlKey) && (!keypress.shiftKey) && (key != 221) ) {
			
			if ( input.value.length == 5 ) {
				
				input.value += "-";
				result = true;
			}
			else if ( input.value.length < 9 ) {
				
				result = true;
			}
		}
		else if ( key == 09 || key == 116 || ( key > 37 && key < 41 ) ) {
			
			result = true;
		}
		else if ( key == 46 || key == 8 ) {
			
			input.value = input.value;
			
			if ( input.value.length == 7 )
				input.value = input.value.replace( "-", "" );
			
			result = true;
		}
		
		return result;
	},
	
	/**
	 * This method is used to format the phone number from an input text.
	 * @author Lucas Venezian Povoa
	 * @param KeyPressEvent keypress
	 * @param HTMLInputElement input
	 * @return Boolean - true if the key will be validate or false otherwise.
	 */
	phoneKeyPress: function( keypress, input ) {
		
		var result = false;
		
		var key = window.event ? event.keyCode : keypress.which;
		
		if ( Tools.justNumber( keypress ) && input.value.length < 13 ) {
			
			switch ( input.value.length ) {
				
				case 0:
					input.value = "(";
					break;
				case 3:
					input.value += ")";
					break;
				case 8:
					input.value += "-";
					break;
			}
			
			result = true;
		}

		return result;
	},
	
	phoneKeyDown: function( keypress, input ) {
		
		var result = true;
		
		var cursorPosition = Tools.getSelectionStart( input );
		
		var key = window.event ? event.keyCode : keypress.which;
		
		if ( keypress.shiftKey || keypress.ctrlKey || key == 46 ) {
		
			result = false;
		}
		else if ( key == 8 ) {
			
			input.value = input.value;
			
			if ( input.value.length == 10 )
				input.value = input.value.replace( "-", "" );
			
			if ( input.value.length == 5 )
				input.value = input.value.replace( ")", "" );
			
			if ( input.value.length == 2 )
				input.value = input.value.replace( "(", "" );
		}
			
		return result;
	},

	/**
	 * This method is used to valid registration number from Unesp.
	 * @author Lucas Venezian Povoa
	 * @since 20/07/2010
	 * @param Integer registration is the number that will be valid.
	 * @return true if the number will be valid or false else no.
	 */
	validateRegistrationNumber: function( registration ) {
		
		var result = false;
		
		var regularExpression = "^[0-9]{7,7}$"; 
		
		if ( registration.match( regularExpression ) != null  ) {
			
			var digit = parseInt(registration.charAt( 6 ) );
			registration = registration.substring( 0, 6 );
			
			var sum = 0;
			
			for ( var i = 0; i < 6; i++ )
				sum += parseInt( registration.charAt(i) ) * ( 7 - i );
			
			var mod = sum % 11;
			
			if ( mod == 10 )
				mod = 0;
			
			if ( mod == digit )
				result = true;
		}
		
		return result;
	},
	
	/**
	 * This method is used to enable just letters in a text box.
	 * @author Lucas Venezian Povoa
	 * @since 22/07/2010
	 * @param HTMLInputElement input
	 * @example <input type='text' onkeypress='return justLetters( event )'/>
	 */
	justLetter: function( e ) {
		
		var result = false;
		
		var tecla = window.event ? event.keyCode : e.which;
		
		if ( 
			( tecla > 064 && tecla < 091 ) || tecla == 197 || tecla == 201 ||
			( tecla > 096 && tecla < 123 ) || tecla == 205 || tecla == 211 ||
			( tecla > 192 && tecla < 196 ) || tecla == 218 || tecla == 229 ||
			( tecla > 224 && tecla < 228 ) || tecla == 231 || tecla == 237 || 
			( tecla > 232 && tecla < 235 ) || tecla == 250 || tecla == 252 ||  
			( tecla > 241 && tecla < 246 )
		) { 
			result = true;
		}
		else if (tecla == 8 || tecla == 32)
			result = true;

		return result;
	},
	
	/**
	 * This method is used to enable just letters without accents in a text box.
	 * @author Lucas Venezian Povoa
	 * @since 23/07/2010
	 * @param KeyPressEvent e
	 * @return boolean true if pressed key was a simple letter or false otherwise.
	 */
	justSimpleLetter: function( e ) {
		
		var result = false;
		
		var tecla = window.event ? event.keyCode : e.which;
		
		if ( ( tecla > 064 && tecla < 091 ) || ( tecla > 096 && tecla < 123 ) ) {
			
			result = true;
		}
		else if ( tecla == 8 ) {
			
			result == true;
		}
		
		return result;
	},
	
	/**
	 * This method is used to enable just numbers in a text box.
	 * @author Lucas Venezian Povoa
	 * @since 23/07/2010
	 * @param KeyPressEvent e
	 * @return boolean true if pressed key was a number or false otherwise.
	 * @example <input type="text" onkeypress="Tools.justNumber( event )"/>
	 */
	justNumber: function( e ) {
		
		var result = false;
		
		var tecla = window.event ? event.keyCode : e.which;
		
		if( tecla > 47 && tecla < 58 )
			result = true;
		else if ( tecla == 8 )
			result = true;

		return result;
	},
	
	/**
	 * This method is used to get start index value of cursor position from input param.
	 * @author Lucas Venezian Povoa
	 * @since 23/07/2010
	 * @param HTMLInputElement input
	 * @return Integer - value of cursor position from input param.
	 */
	getSelectionStart: function( input ) {
		
		var result = -1;
		
	    if ( input.createTextRange ) {
	    	
	        var r = document.selection.createRange().duplicate();
	        r.moveEnd( 'character', input.value.length );
	        
	        if ( r.text == '' ) 
	        	result = input.value.length;
	        else
	        	result = input.value.lastIndexOf( r.text );
	    } 
	    else 
	    	result = input.selectionStart;
	    
	    return result;
	},

	/**
	 * This method is used to get end index value of cursor position from input param.
	 * @author Lucas Venezian Povoa
	 * @since 23/07/2010
	 * @param HTMLInputElement input
	 * @return Integer - value of end cursor position from input param.
	 */
	getSelectionEnd: function( input ) {
		
		var result = -1
		
	    if ( input.createTextRange ) {
	    	
	        var r = document.selection.createRange().duplicate()
	        r.moveStart('character', -input.value.length)
	        result = r.text.length
	        
	    }
	    else 
	    	result = input.selectionEnd;
		
		return result;
	},
	
	/**
	 * This method is used to insert a substring in input param since index param. 
	 * @author Lucas Venezian Povoa
	 * @since 23/07/2010
	 * @param String substring
	 * @param Integer index
	 * @param HTMLInputElement input
	 */
	appendSubstringAt: function( substring, index, input ) {
	
		if ( index > -1 ) {
			
			input.value = 
				input.value.substring( 0, index ) + 
				substring + 
				input.value.substring( index, input.value.length ); 
		}
	}
};