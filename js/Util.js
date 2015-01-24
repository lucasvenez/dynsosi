Util = function() {};

Util.prototype = new Object();

Util.onLoadLogin = function() {
	
	document.getElementById("email").focus();
};

Util.onLoadCadastro = function() {
	
	document.getElementById( "nome" ).focus();
	
	Util.MM_reloadPage( true );

	$( "#addressSearch" ).click( function() { Util.addressSearchByZipCode( $( "#cep" ).val() ) } )
	$( "#cep" ).keydown( function() { return Tools.zipCodeKeyDown( event, this ) } );
	$( "#nome" ).keypress( function() { return Tools.justLetter( event ) } );
	$( "#naturalidade" ).keypress( function() { return Tools.justLetter( event ) } );
	$( "#matricula" ).keypress( function() { return Tools.justNumber( event ) } );
	
	$( "#cidade" ).keypress( function() { return Tools.justLetter(); } );
	
	$( "#fone" ).keypress( function() { return Tools.phoneKeyPress( event, this ); } );
	$( "#fone" ).keydown( function() { return Tools.phoneKeyDown( event, this ); } );
	
	$( "#cpf" ).keypress( function() { return Tools.justNumber( event ); } );
	$( "#senha" ).keyup( Util.passwordKey );
	
	$( "#nascimento" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy",
		minDate: "-110y",
		maxDate: "-18y",
		yearRange: "1900:2200",
		regional: "pt-BR",
		onSelect: function() { document.form.rg.focus(); },
		onChangeMonthYear: function() { document.form.rg.focus() }
	});
};

/**
 * This method is used to search a full address from a zip code.
 * @param Integer zipCode is the param of query [format: ########].  
 */
Util.addressSearchByZipCode = function( zipCode ) {
	
	var action = "./buscar_endereco_por_cep.php";
	
	var ajax = new Ajax();
	
	var params = "cep=" + zipCode;
	
	ajax.setAction( action );
	ajax.setMethod( Ajax.POST );
	ajax.setParams( params );
	
	ajax.onCompletion = function() {
		
		if ( ajax.responseInXML() ) {
		
			var root = ajax.getResponseXML().getElementsByTagName( "ceplivre" )[0];

			var endereco = root.getElementsByTagName( "cep" )[0];
			
			var success = endereco.getElementsByTagName( "sucesso" )[0].firstChild.nodeValue;
			
			if ( success == 0 ) {
				
				document.getElementById( "mensagem" )
				.appendChild(
					
					Tools.createMessageElement(
						"warning",
						"CEP não cadastrado",
						"Desculpe, mas o CEP informado não existe no banco de dados do projeto " +
						"<a href='http://ceplivre.pc2consultoria.com/'>CEP Livre</a>. Para colaborar com o projeto clique " +
						"<a href='http://ceplivre.pc2consultoria.com/index.php?module=cep&event=formeditacep'>aqui</a>."
					)
				);
				
				window.scrollTo( 0, 0 );
			}
			else {
				
				for ( var i = 0; i < document.getElementById( "uf" ).options.length; i++ ) {
				
					if ( document.getElementById( "uf" ).options[i].value == endereco.getElementsByTagName( "estado_sigla" )[0].firstChild.nodeValue ) {
						document.getElementById( "uf" ).selectedIndex = i;
						break;
					}
				}
				
				document.getElementById( "cidade" ).value = endereco.getElementsByTagName( "cidade" )[0].firstChild.nodeValue;

				document.getElementById( "bairro" ).value =  endereco.getElementsByTagName( "bairro" )[0].firstChild.nodeValue;
				
				document.getElementById( "logradouro" ).value = 
					endereco.getElementsByTagName( "tipo_logradouro" )[0].firstChild.nodeValue + " " + 
					endereco.getElementsByTagName( "logradouro" )[0].firstChild.nodeValue;
				
				document.getElementById( "logradouro" ).focus();
				document.getElementById( "logradouro" ).select();
			}
		}//fim do if
	};
	
	ajax.onError = function() {
		
		document.getElementById( "mensagem" )
		.appendChild(
			
			Tools.createMessageElement(
				"error",
				"Falha na comunicação",
				"Desculpe, houve um erro na comunicação com os servidores. Tente novamente mais tarde, por favor."
			)
		);
	};
	
	ajax.run();
};

Util.MM_reloadPage = function (init) {  //reloads the window if Nav4 resized
	
	if (init==true) with (navigator) {
		if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
			document.MM_pgW=innerWidth;
			document.MM_pgH=innerHeight; 
			onresize=MM_reloadPage; 
		}
	}
	else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) 
		location.reload();
};

Util.menu1 = function() {
	
    if(document.formmenu_esq.menu_esq1.value != 1 ){
	 	document.formmenu_esq.menu_esq1.value = 1;
     	document.formmenu_esq.submit();
	}
    else{
		document.formmenu_esq.menu_esq1.value = "";
     	document.formmenu_esq.submit();
	}
};

Util.logar = function() {
	
	var erro = 0;
	
	if (!document.form.email.value) {
		
		alert( "Por favor, informe seu e-mail." );
		document.form.email.focus();
		erro = 1;
	} 

	if ( (!document.form.senha.value) && (erro == 0) ) {
		
		alert( "Por favor, informe sua senha." );
		document.form.senha.focus();
		erro = 1;
	}

	if (erro == 0) {
		
		document.form.action = "./autenticacao.php";
		document.form.submit();
	}
};
	
Util.passwordKey = function() {
	
	var usuario = document.getElementById( "cpf" ).value;
	var senha   = document.getElementById( "senha" ).value;


	if ( Tools.passwordLevel( usuario, senha ) < 6 ) 		
		$( "#content-security-level" ).html( "fraco" );
	else if ( Tools.passwordLevel( usuario, senha ) < 8 )
		$( "#content-security-level" ).html( "médio" );
	else if ( Tools.passwordLevel( usuario, senha ) < 10 )
		$( "#content-security-level" ).html( "forte" );
	else
		$( "#content-security-level" ).html( "muito forte" );	
};

Util.dateKey = function( event ) {
	
	var key = event.keyCode;

	if ( key == 9 || key == 40 )
		return true;
	else
		return false;
};

Util.cadastrar = function() {
	
	if (!document.form.nome.value || !document.form.sobrenome.value ) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, preencha seu <a href='javascript: document.form.nome.focus()'>nome completo</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	}
	else if ( !Tools.validateRegistrationNumber(document.form.matricula.value) ) {

		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Matrícula inválida", 
				"Atenção: o <a href='javascript: document.form.matricula.focus();'>número de matrícula</a> não é válido."
			)
		);

		window.scrollTo( 0, 0 );
	}	
	else if (!document.form.nascimento.value) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe corretamente a sua <a href='javascript: document.form.nascimento.focus();'>data de nascimento</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	}
	else if (!document.form.rg.value) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe o seu <a href='javascript: document.form.rg.focus();'>RG</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	}
	else if (!document.form.naturalidade.value) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe sua <a href='javascript: document.form.naturalidade.focus();'>naturalidade</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	}
	else if (!document.form.fone.value) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe o seu <a href='javascript: document.form.fone.focus();'>telefone</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	} 
	else if (!document.form.email.value) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe o seu <a href='javascript: document.form.email.focus();'>email</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	}
	else if ( !document.form.sexo[0].checked && 
			  !document.form.sexo[1].checked 
	) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe o seu <a href='javascript: document.form.sexo[0].focus();'>sexo</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	}
	else if ( !document.form.logradouro.value || document.form.logradouro.value.length < 8 ) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe o seu <a href='javascript: document.form.logradouro.focus();'>endereço completo</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	}
	else if (!document.form.bairro.value) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe o seu <a href='javascript: document.form.bairro.focus();'>bairro</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	} 
	else if (!document.form.cep.value) {

		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe o seu <a href='javascript: document.form.cep.focus();'>CEP</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	}
	else if (!document.form.cidade.value) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe a sua <a href='javascript: document.form.cidade.focus();'>cidade</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	} 
	else if (!document.form.uf.value) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe o seu <a href='javascript: document.form.uf.focus();'>estado</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	} 	
	else if ( !Util.validarEmail(document.form.email.value) ) {

		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"O campo <a href='javascript: document.form.email.focus();'>e-mail</a> deve conter um endereçoeletrônico válido"
			)
		);
		
		window.scrollTo( 0, 0 );
	}	
    else if (!document.form.cpf.value) {

		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe o seu número de <a href='javascript: document.form.cpf.focus();'>CPF</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	} 
	else if ( !Util.checaCPF(document.form.cpf.value ) ) {

		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"O número de <a href='javascript: document.form.cpf.focus();'>CPF</a> informado não é válido, confire-o por favor."
			)
		);
		
		window.scrollTo( 0, 0 );
	}
	else if ( !document.form.senha.value ) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"Por favor, informe sua <a href='javascript: document.form.senha.focus();'>senha</a>."
			)
		);
		
		window.scrollTo( 0, 0 );
	}
	else if ( document.form.senha.value != document.form.confirmacao.value ) {
		
		document.getElementById( "mensagem" )
		.appendChild( 
			Tools.createMessageElement ( 
				"warning", 
				"Campo obrigatório", 
				"As <a href='javascript: document.form.senha.focus();'>senhas</a> não conferem, redigite-as, por favor."
			)
		);
		
		window.scrollTo( 0, 0 );
	}
	else {

		var ajax = new Ajax();
		ajax.setMethod( Ajax.POST );
		ajax.setAction( "./persistir.php" );
		
		var sexo = null;
		
		for ( var i = 0; i < document.form.sexo.length; i++ ) {
			
			if ( document.form.sexo[i].checked ) {
				
				sexo = document.form.sexo[i].value;
				break;
			}
		}
		
		var params = 
			"nome=" 			+ document.form.nome.value + " " + document.form.sobrenome.value +
			"&sexo="			+ sexo								+
			"&logradouro=" 		+ document.form.logradouro.value	+
			"&bairro=" 			+ document.form.bairro.value 		+
			"&cep=" 			+ document.form.cep.value 			+
			"&cidade=" 			+ document.form.cidade.value 		+
			"&uf=" 				+ document.form.uf.value 			+
			"&nascimento=" 		+ document.form.nascimento.value 	+
			"&naturalidade="	+ document.form.naturalidade.value 	+
			"&rg=" 				+ document.form.rg.value 			+
			"&fone=" 			+ document.form.fone.value 			+
			"&email=" 			+ document.form.email.value 		+
			"&matricula=" 		+ document.form.matricula.value 	+
			"&cpf=" 			+ document.form.cpf.value 			+
			"&senha=" 			+ document.form.senha.value;
		
		ajax.setParams( params );
		
		var mensagem = null;
		
		ajax.onCompletion = function() {
			
			var anwser = ajax.getResponse();
			
			switch( anwser ) {
			
				case "0": 
					
					mensagem = 
						Tools.createMessageElement ( 
							"success",
							"Cadastro efetudo com sucesso!",
							"Seu cadastro foi efetuado com sucesso, " +
								"seu usuário e senha foram enviados para o seu e-mail. Para afetuar login clique " +
								"<a href='./login.php'>aqui</a>."
						);
					
					break;
				case "1":
					
					mensagem = 
						Tools.createMessageElement (
								"warning",
								"E-mail existente",
								"O e-mail " + document.form.email.value + " já está cadastrado. " +
									"Por favor, informe outro endereço eletrônico."
						);
					break;
				case "2":
					
					mensagem = 
						Tools.createMessageElement (
								"warning",
								"Identificador existente",
								"Seu número de CPF e/ou matrícula já estão cadastrados. " +
									"Para recuperar sua senha clique <a href='./recuperasenha.php'>aqui</a>."
						);
					
					break;
				case "3":
					
					mensagem = 
						Tools.createMessageElement (
								"error",
								"Falha na comunicação",
								"Desculpe, houve uma falha na comunicação com os servidores, " +
									"tente novamente mais tarde, por favor."
						);
					
					break;
				default:
					alert( ajax.getResponse() );
			}
			
			if ( mensagem != null )
				document.getElementById( "mensagem" ).appendChild( mensagem );
			
			window.scrollTo( 0, 0 );
		}
		
		ajax.run();
	}
};

Util.validarEmail = function( email ) {
	 
	return true;
}

Util.checaCPF = function (CPF) {
	
	if ( CPF.length != 11 || 
		 CPF == "00000000000" || CPF == "11111111111" || CPF == "22222222222" || 
		 CPF == "33333333333" || CPF == "44444444444" || CPF == "55555555555" || 
		 CPF == "66666666666" || CPF == "77777777777" || CPF == "88888888888" || 
		 CPF == "99999999999"
	) {
		return false;
	}
	
	soma = 0;
	for (i=0; i < 9; i ++)
		soma += parseInt(CPF.charAt(i)) * (10 - i);
	resto = 11 - (soma % 11);
	if (resto == 10 || resto == 11)
		resto = 0;
	if (resto != parseInt(CPF.charAt(9)))
		return false;
	soma = 0;
	for (i = 0; i < 10; i ++)
		soma += parseInt(CPF.charAt(i)) * (11 - i);
	resto = 11 - (soma % 11);
	if (resto == 10 || resto == 11)
		resto = 0;
	if (resto != parseInt(CPF.charAt(10)))
		return false;

	return true;

}