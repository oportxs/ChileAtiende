(function($){
	
	$.validator.addMethod('notPlaceholder', function(val, el){
		return this.optional(el) || ( val !== $(el).attr('placeholder') );
	}, 'Debe ingresar un dominio.');

	var btnGenerarMapa = $('#btn_generar_mapa'),
		dimensiones = $('.dimensiones'),
		form = $('#formGeneradorMapa');

	form.validate({
		rules : {
			'dominio':{'required':true, 'notPlaceholder':true,  'url':true},
			'id_container':{'required':true}
		},
		messages:{
			'dominio':{'required':'Debe ingresar un dominio.', 'url':'Debe ingresar un dominio válido. Ej: http://www.midominio.cl'}
		}
	});

	$('.codigo_generado').on('click', function(e){
		$(this).select();
		e.preventDefault();
	});

	dimensiones.on('keydown', function(e){
		return numericVal(e.keyCode);
	});

	btnGenerarMapa.on('click', function(e){
		var dominio = $('#dominio'),
			id_container = $('#id_container'),
			comuna = $('#comuna').val();

		if(!form.valid())
			return false;

		actializaMapaChileatiende({
			id_container:id_container.val(),
			dominio:dominio.val(),
			comuna:comuna,
			titulo:$('#titulo').is(':checked')?1:0,
			filtros:$('#filtro').is(':checked')?1:0,
			width:$('#width').val(),
			height:$('#height').val(),
			zoom:$('#zoom').val(),
			srcurl:site_url
		});
		e.preventDefault();
	});

	function actializaMapaChileatiende(config){
		console.log(config);

		var cont_mapa = $('#mapaChileAtiende'),
			codigo_mapa = $('#codigo_mapa');

		window.config = {
			'id_container':'mapaChileAtiende',
			'dominio':config.dominio,
			'comuna':config.comuna,
			'titulo':config.titulo,
			'filtros':config.filtros,
			'width':config.width,
			'height':config.height,
			'zoom':config.zoom,
			'srcurl':config.srcurl
		};

		cont_mapa.html('');

		var codigoMapaDemo = '<iframe src="'+site_url+'api/mapa?dominio='+config.dominio+'&amp;comuna='+config.comuna+'&amp;titulo='+config.titulo+'&amp;filtros='+config.filtros+'&amp;width=960&amp;height=200&amp;zoom='+config.zoom+'" frameborder="0" width="960" height="200"></iframe>';
		var codigoMapa = '<iframe src="'+site_url+'api/mapa?dominio='+config.dominio+'&amp;comuna='+config.comuna+'&amp;titulo='+config.titulo+'&amp;filtros='+config.filtros+'&amp;width='+config.width+'&amp;height='+config.height+'&amp;zoom='+config.zoom+'" frameborder="0" width="'+config.width+'" height="'+config.height+'"></iframe>';

		codigo_mapa.text(codigoMapa);
		cont_mapa.html(codigoMapaDemo);
		$('.cont-codigo-mapa').fadeIn();

	}

})(jQuery);
function numericVal(keyCode){
	return (keyCode > 47 && keyCode < 58)
		||(keyCode > 95 && keyCode < 106)
		||(keyCode==8||keyCode==46||keyCode==9)
		||(keyCode > 34 && keyCode < 41);
}