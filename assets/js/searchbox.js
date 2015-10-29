(function($){
	var searchbox = {
		init : function(){
			this.contBuscador = $('#buscador');
			this.formBuscador = $('#main_search');
			this.inputBuscador = this.formBuscador.find('#main_search_input');
			this.contSugerencias = $('<ul id="sugerenciasBusqueda"></ul>').appendTo(this.contBuscador);
			this.timeoutSugerencias = null;
			this.sugerenciaActiva = null;
			this.ultimaBusqueda = '';

			this.bindEvents();
		},

		bindEvents : function(){
	    searchbox.inputBuscador.on('keyup', function(e){
	    	var elem = $(this);
	    	if (e.keyCode == 38 || e.keyCode == 40){
	    		e.preventDefault();
	    		searchbox.navegaSugerencias(e.keyCode == 38);
	    	}else{
		    	searchbox.buscaSugerencias(elem);
	    	}
	    }).on('blur', function(e){
	    	setTimeout(function(){ searchbox.ocultaSugerencias();	}, 200);
	    }).on('focus', function(e){
	    	var elem = $(this);
	    	setTimeout(function(){ searchbox.buscaSugerencias(elem);	}, 200);
	    });

	    searchbox.contBuscador.on('click', '#sugerenciasBusqueda li', function(){
	    	searchbox.inputBuscador.val($(this).find('.sugerencia').text());
	    	searchbox.formBuscador.submit();
	    });
		},

		buscaSugerencias : function(elem){
            return false; //Se deshabilita la busqueda
			var busqueda = elem.val();
			elem.data('busqueda-original', busqueda);
			if(busqueda.length >= 3){

				if(busqueda == searchbox.ultimaBusqueda){
					searchbox.muestraSugerencias();
				}else{
					clearTimeout(searchbox.timeoutSugerencias);
					searchbox.timeoutSugerencias = setTimeout(function(){

			  		$.ajax({
			  			url : site_url+'buscar/ajax_sugerencias_busqueda/'+busqueda,
			  			dataType : 'json'
			  		}).done(function(data){
			  			searchbox.actualizaSugerencias(data);
			  			searchbox.ultimaBusqueda = busqueda;
			  			searchbox.sugerenciaActiva = null;
			  		});

					}, 300);
				}

			}else{

				searchbox.ocultaSugerencias();

			}
		},

		muestraSugerencias : function(){
			searchbox.contSugerencias.show();
		},

		ocultaSugerencias : function(){
			searchbox.contSugerencias.hide();
		},

		actualizaSugerencias : function(data){
			var	sugerencias = '';

			if(!data.length){
				searchbox.ocultaSugerencias();
				return false;
			}

			for(var i = 0; i < data.length; i++){
				sugerencias += '<li data-sugerencia="'+data[i].sugerencia.toLowerCase()+'"><span class="sugerencia">'+data[i].sugerencia.toLowerCase()+'</span> <span class="hits">'+data[i].hits+'</span></li>';
			}
			searchbox.contSugerencias.html(sugerencias);
			searchbox.contSugerencias.highlight(searchbox.inputBuscador.val());
			searchbox.muestraSugerencias();
		},

		navegaSugerencias : function(up){
			if(!searchbox.sugerenciaActiva){
				searchbox.sugerenciaActiva = searchbox.contSugerencias.find('li:'+(up?'last':'first'));
			}else{
				searchbox.sugerenciaActiva.removeClass('active');
				
				if(up)
					searchbox.sugerenciaActiva = searchbox.sugerenciaActiva.prev('li');
				else
					searchbox.sugerenciaActiva = searchbox.sugerenciaActiva.next('li');

				if(!searchbox.sugerenciaActiva.length){
					searchbox.sugerenciaActiva = null
				}
			}

			if(searchbox.sugerenciaActiva){
				searchbox.sugerenciaActiva.addClass('active');
				searchbox.inputBuscador.val(searchbox.sugerenciaActiva.data('sugerencia'));
			}else{
				searchbox.inputBuscador.val(searchbox.inputBuscador.data('busqueda-original'));
			}

		}
	};

	$(function(){
		window.searchbox = searchbox.init();	
	});
})(jQuery);