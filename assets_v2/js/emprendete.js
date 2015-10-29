function removeVariableFromURL(url_string, variable_name) {
    var URL = String(url_string);
    var regex = new RegExp( "\\?" + variable_name + "=[^&]*&?", "gi");
    URL = URL.replace(regex,'?');
    regex = new RegExp( "\\&" + variable_name + "=[^&]*&?", "gi");
    URL = URL.replace(regex,'&');
    URL = URL.replace(/(\?|&)$/,'');
    regex = null;
    return URL;
}

$(document).ready(function() {
	loadApoyosByEtapa(1);
	loadHechosEmpresaByEtapa(1);
    loadDestacadosByEtapa(1);

    // IF MOBILE
    if($(".nav-secundaria-movil").css("font-family") == "mobile") {
        $(".nav-secundaria-movil").css("display", "none");
        $(".nav-principal div").removeClass('selected');
    }

	$('.nav-principal .span2 h3 a').click(function(event){
		event.preventDefault();
		var EtapaId = $(this).attr('data-val');
        var alreadySelected = $(".nav-principal div[data-id='"+EtapaId+"']").hasClass('selected');

        $.when(
            loadApoyosByEtapa( EtapaId ),
            loadHechosEmpresaByEtapa( EtapaId ),
            loadDestacadosByEtapa( EtapaId )
            ).done(function() {
                $(".nav-principal div").removeClass('selected');
                $(".nav-principal div[data-id='"+EtapaId+"']").addClass('selected');

                // IF MOBILE
                if($(".nav-secundaria-movil").css("font-family") == "mobile") {
                    $(".nav-secundaria-movil").css("display", "none");
                    if(!alreadySelected)
                        $(".nav-secundaria-movil[data-id='"+EtapaId+"']").slideDown(500);
                    else
                        $(".nav-principal div[data-id='"+EtapaId+"']").removeClass('selected');
                }                
            });
    });

    $('#button_fps').click(function(event){
        var fps_num = $('input[id=input_fps]').val();
        if (isNaN(fps_num))
        {
            $('#msg_fps').html('Ingresa tu Puntaje en la Ficha de Protección Social');
            $('#msg_fps').css('color','red');
            $('#msg_fps').css('display','block');
            $('#input_fps').focus();
        }
        else if (! fps_num)
        {
            document.location.href = removeVariableFromURL(document.location.href,'fps');
        }
        else if (fps_num < 2000 || fps_num > 20000)
        {
            $('#msg_fps').html('El Puntaje debe estar en el rango de 2000 a 20000');
            $('#msg_fps').css('color','red');
            $('#msg_fps').css('display','block');
            $('#input_fps').focus();
        }
        else
        {
            document.location.href = removeVariableFromURL(document.location.href,'fps')+"&fps="+fps_num;
        }
    });
    $('#input_fps').keypress(function(event){
        if(event.which == 13) {
            $('#button_fps').click();
        }
    });
    
});

function loadApoyosByEtapa(etapaId){
	$.getJSON(site_url+'etapasempresa/getApoyosByEtapaId', "etapa_id="+etapaId, function(response){
        if(response[0] != undefined)
            response = response[0].ApoyosEstado;

        var html="";
        for(var i in response){
            if( response[i].nombre != undefined ) {
            	html+='<div class="span3">';
				html+='<h3 class="apoyo">Apoyo del Estado</h3>';
				html+='<h2><a href="'+site_url+'buscar/fichas?apoyo_estado='+response[i].id+'&e=1">';
				html+=response[i].nombre;
				html+='</a></h2>';
				html+='</div>';
            }
        }

        $(".apoyo").html(html);
    });
}

function loadHechosEmpresaByEtapa(etapaId){
	$.getJSON(site_url+'etapasempresa/getHechosEmpresaByEtapaId', "etapa_id="+etapaId, function(response){
		if(response[0] != undefined)
            response = response[0].HechosEmpresa;

        var html="";
        for(var i in response){
            if( response[i].nombre != undefined ) {
            	html+='<div class="span3">';
				html+='<h3>Aprende sobre</h3>';
				html+='<h2><a href="'+site_url+'buscar/fichas?etapa_empresa='+etapaId+'&hecho_empresa='+response[i].id+'&e=1">';
				html+=response[i].nombre;
				html+='</a></h2>';
				html+='</div>';
            }
        }

        $(".aprende").html(html);
    });
}

function loadDestacadosByEtapa(etapaId){
    $.getJSON(site_url+'etapasempresa/MasDestacadasByEtapaId', "etapa_id="+etapaId, function(response){
        if(!response.length)
            return false;

        var html="";
        
        html+='<ul>';
        for(var i in response){
            if( response[i].titulo != undefined ) {
                html+='<li>';
                html+='<a href="'+site_url+'fichas/ver/'+response[i].maestro_id+'">';
                html+=response[i].titulo;
                html+='</a>';
                html+='<span class="institucion">'+response[i].Servicio.nombre+'</span>'
                html+='</li>';
            }
        }
        html+='</ul>';

        $(".destacados").html(html);
    });
}
