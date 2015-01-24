/**
 * Classe utilizada para solicita��es ao servidor com o objeto XMLHttpRequest (XHR)
 * @author Lucas Venezian Povoa
 * @since 09/11/2009
 */
Ajax = function() {
	
	/**
	 * Atributo utilizado para armazenar a refer�ncia ao objeto XHR
	 */
	this.xmlHttp;
	
	/**
	 * M�todo utilizado para setar os valores padr�es aos atributos.
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
	 * M�todo utilizado para setar os valores padr�es 
	 * para os atributos que armazenam as respostas do servidor
	 */
	this.resetResponse = function() {
		
		//Estados da requisi��o
		this.response = null;
		this.responseXML = null; 
		this.responseStatus = new Array( 2 );
	};
	
	/**
	 * M�todo utilizado para setar os valores 
	 * padr�es para os eventos de respostar do objeto XHR
	 */
	this.resetEvents = function() {
		
  		this.onLoading = function() {};
  		this.onLoaded = function() {};
  		this.onInteractive = function() {};
  		this.onCompletion = function() {};
  		this.onError = function() {};
	};	
	
	/* m�todos setters'n getters */
	
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
	 * Este m�todo retorna o valor do header informado no par�metro name
	 * @param String name � o nome do atributo ao qual se quer saber a valor (e.g Content-Type)
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
	 * 0 - retorna o estado em formato num�rico
	 * 1 - retorna o estado em formato texto
	 */
	this.getResponseStatus = function ( index ) {
		
		return this.responseStatus[index];
	};	
	
	/**
	 * M�todo utilizado para criar o objeto XMLHttpRequest para solicita��o
	 * din�mica ao servidor.
	 * @author Lucas Venezian Povoa
	 * @since 01/11/2009
	 * @return true caso o objeto XMLHttpRequest tenha sido criado com sucesso ou j� esteja inst�nciado
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
			else if ( typeof XMLHttpRequest != "undefined" ) { //Padr�o W3C
		
				this.xmlHttp = new XMLHttpRequest();
				result = true;
			}
		}
		else {
			
			result = true;
		}
		
		return result;
	};//fim do m�todo createXMLHttpRequest
	
	/**
	 * M�todo utilizado para executar a solicita��o ao servidor
	 * @since 04/11/2009
	 */
	this.run = function () {

		if ( this.xmlHttp ) {
			
			this.resetResponse();
			
			var self = this;
							
			try {
				
				switch ( this.method ) {
						
					case 0: //Caso o m�todo seja get ou put 
						
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
				  
					case 1: //caso o m�todo seja POST
						
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
	};//fim do m�todo run
	
	/**
	 * @return true caso a resposta seja em xml e false caso n�o.
	 */
	this.responseInXML = function() {
		
		var result = false;
		
		if ( window.ActiveXObject ) { //Internet Explorer
			
			if ( this.getResponseXML().childNodes.length > 0 )
				result = true;
		}
		else { //Padr�o W3C
			
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