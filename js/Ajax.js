/**
 * Classe utilizada para solicitações ao servidor com o objeto XMLHttpRequest (XHR)
 * @author Lucas Venezian Povoa
 * @since 09/11/2009
 */
Ajax = function() {
	
	/**
	 * Atributo utilizado para armazenar a referência ao objeto XHR
	 */
	this.xmlHttp;
	
	/**
	 * Método utilizado para setar os valores padrões aos atributos.
	 */
	this.resetParams = function() {
		
		this.method;
		this.action;
		this.assync = true;
		this.username = null;
		this.password = null;
		this.params = null;
		this.textType = "text/plain";
		this.encoding = "UTF-8";
	};
	
	/**
	 * Método utilizado para setar os valores padrões 
	 * para os atributos que armazenam as respostas do servidor
	 */
	this.resetResponse = function() {
		
		//Estados da requisição
		this.response = null;
		this.responseXML = null; 
		this.responseStatus = new Array( 2 );
	};
	
	/**
	 * Método utilizado para setar os valores 
	 * padrões para os eventos de respostar do objeto XHR
	 */
	this.resetEvents = function() {
		
  		this.onLoading = function() {};
  		this.onLoaded = function() {};
  		this.onInteractive = function() {};
  		this.onCompletion = function() {};
  		this.onError = function() {};
	};	
	
	/* métodos setters'n getters */
	
	this.setMethod = function ( method ) {
	
		this.method = method;
	};
	
	this.getMethod = function () {
		
		return this.method;
	};

	this.setAction = function ( action ) {
		
		this.action = action;
	};
	
	this.getAction = function () {
		
		return this.action;
	};
	
	this.setAssync = function ( assync ) {
		
		if ( assync )			
			this.assync = true;
		else
			this.assync = false;
	};
	
	this.getAssync = function () {
		
		return this.assync;
	};
	
	this.setUsername = function ( username ) {
		
		this.username = username;
	};
	
	this.getUsername = function () {
		
		return this.username;
	};
	
	this.setPassword = function ( password ) {
		
		this.password = password;
	};
	
	this.getPassword = function () {
		
		return this.password;
	};	
	
	this.setParams = function( params ) {
		
		this.params = params;
	};
	
	this.getResponse = function () {
		
		return this.response;
	};
	
	this.getResponseXML = function () {
		
		return this.responseXML;
	};		
	
	this.setRequestHeader = function( name, value ) {
		
		this.xmlHttp.setRequestHeader( name, value );
	};
	
	/**
	 * Este método retorna o valor do header informado no parâmetro name
	 * @param String name é o nome do atributo ao qual se quer saber a valor (e.g Content-Type)
	 * @return String com o valor do header desejado
	 */
	this.getResponseHeader = function( name ) {
		
		return this.xmlHttp.getResponseHeader( name );
	};
	
	this.getAllResponseHeaders = function() {
		
		return this.xmlHttp.getAllResponseHeaders();
	};
	
	this.setHeader = function( textType, encoding ) {
		
		this.encoding = encoding;
		this.typeText = textType;
	};
	
	/**
	 * @param index
	 * 0 - retorna o estado em formato numérico
	 * 1 - retorna o estado em formato texto
	 */
	this.getResponseStatus = function ( index ) {
		
		return this.responseStatus[index];
	};	
	
	/**
	 * Método utilizado para criar o objeto XMLHttpRequest para solicitação
	 * dinâmica ao servidor.
	 * @author Lucas Venezian Povoa
	 * @since 01/11/2009
	 * @return true caso o objeto XMLHttpRequest tenha sido criado com sucesso ou já esteja instânciado
	 */
	this.createXMLHttpRequest = function() {
		
		result = false;
		
		if ( this.xmlHttp == null ) { //Internet Explorer
			
			if ( window.ActiveXObject ) {
		
				try {
					this.xmlHttp = new ActiveXObject( "Microsoft.XMLHTTP" );
				} 
				catch (exception1) {
					
					try {
						this.xmlHttp = new ActiveXObject( "Msxml2.XMLHTTP" );
					} 
					catch ( exception2 ) {
						this.xmlHttp = null;
					}
				}
				
				result = true;
			}
			else if ( typeof XMLHttpRequest != "undefined" ) { //Padrão W3C
		
				this.xmlHttp = new XMLHttpRequest();
				result = true;
			}
		}
		else {
			
			result = true;
		}
		
		return result;
	};//fim do método createXMLHttpRequest
	
	/**
	 * Método utilizado para executar a solicitação ao servidor
	 * @since 04/11/2009
	 */
	this.run = function () {

		if ( this.xmlHttp ) {
			
			this.resetResponse();
			
			var self = this;
							
			try {
				
				switch ( this.method ) {
						
					case 0: //Caso o método seja get ou put 
						
						if ( this.params != null ) {
							
							var url = this.action + "?" + this.params;
							this.xmlHttp.open( "GET", url, this.assync );
							this.params = null;
						}
						else
							this.xmlHttp.open( "GET", this.action, this.assync );
						
						if ( this.typeText != null );
							this.xmlHttp.setRequestHeader( "Content-Type", this.textType + "; charset=" + this.encoding );
						
					  break;
				  
					case 1: //caso o método seja POST
						
						this.xmlHttp.open( "POST", this.action, this.assync );
						this.xmlHttp.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded; charset=" + this.encoding );
					  break;
				}	
			} 
			catch ( exception ) {}

			this.xmlHttp.onreadystatechange = function() {
				
				switch ( self.xmlHttp.readyState ) {
				
					case 1:
						self.onLoading();
					  break;
					  
					case 2:
						self.onLoaded();
					  break;
					  
					case 3:
						self.onInteractive();
					  break;
					  
					case 4:
						self.response = self.xmlHttp.responseText;
						self.responseXML = self.xmlHttp.responseXML;
						self.responseStatus[0] = self.xmlHttp.status;
						self.responseStatus[1] = self.xmlHttp.statusText;
					
						if ( self.responseStatus[0] == "200" ) //sucesso!
							self.onCompletion();
						else
							self.onError();

					  break;
				}//fim do switch
			};//fim do onReadyStateChange
			
			this.xmlHttp.send( this.params );
		}
	};//fim do método run
	
	/**
	 * @return true caso a resposta seja em xml e false caso não.
	 */
	this.responseInXML = function() {
		
		var result = false;
		
		if ( window.ActiveXObject ) { //Internet Explorer
			
			if ( this.getResponseXML().childNodes.length > 0 )
				result = true;
		}
		else { //Padrão W3C
			
			if ( this.getResponseXML() != null  )
				result = true;
		}
		
		return result;
	};
	
	this.resetParams();
	this.resetEvents();
	this.createXMLHttpRequest();
};

//constantes
Ajax.GET  = 0;
Ajax.POST = 1;
Ajax.PUT  = 2;