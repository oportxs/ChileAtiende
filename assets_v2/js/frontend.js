// In case we forget to take out console statements. IE becomes very unhappy when we forget. Let's not make IE unhappy
if(typeof(console) === 'undefined') {
    var console = {};
    console.log = console.error = console.info = console.debug = console.warn = console.trace = console.dir = console.dirxml = console.group = console.groupEnd = console.time = console.timeEnd = console.assert = console.profile = function() {};
}

//Se cambia la funcion de jQuery para agregarle un evento
(function($){
    var origAddClass = jQuery.fn.addClass;

    $.fn.addClass = function(){
        var result = origAddClass.apply(this, arguments);

        if(this.data('on-change-class'))
            this.trigger('onChangeClass');

        return result;
    }

})(jQuery);
(function($){
    var app = {
        init : function(){
            app.Body = $('body');
            app.Content = $('#content');
            app.esPortada = current_url == site_url;

            app.fontSize = parseInt(app.Content.css('font-size'),10);
            app.fontSizeFicha = parseInt(app.Content.find('.text-content').css('font-size'),10);

            app.loadSections();
            app.loadPlugins();

            return this;
        },
        loadSections : function(){
            if(app.Content.hasClass('ficha')){
                app.Ficha = ficha.init();
            }
            if(app.Content.hasClass('portada') || app.Content.hasClass('etapas-temas')){
                app.Portada = portada.init();
                app.Accesibilidad = accesibilidad.init();
            }
            if($('#instituciones').length){
                app.Instituciones = vistaInstituciones.init();
            }
            if(app.Content.hasClass('contenido-que-es-chileatiende') || app.Content.hasClass('contenido-oficinamovil')){
                app.Genericos = genericos.init();
            }
            if(app.Content.find('.participacion').length){
                app.Participacion = participacion.init();
            }
            if(app.Content.find('.pregunta-encabezado').length){
                app.PreguntasFrecuentes = preguntasFrecuentes.init();
            }
            if(app.Content.hasClass('puntosatencion') || app.Content.hasClass('ficha-metaficha')){
                app.PuntosdeAtencion = puntosatencion.init();
            }
            if(app.Content.hasClass('servicios-disponibles')){
                app.ServiciosDisponibles = serviciosdisponibles.init();
            }
            if(app.Content.hasClass('contenido-tne')){
                app.TneChileatiende = tneChileatiende.init();
            }
            if(app.Content.hasClass('contenido-en-linea')){
                app.EnLineaChileatiende = enLineaChileatiende.init();
            }
            if(app.Content.find('#modal-encuestas').length){
                app.EncuestasChileatiende = encuestasChileatiende.init();
            }
            app.Buscador = buscador.init();
        },
        loadPlugins : function(){
            //Marcas Google Analytics
            googleAnalytics.init();

            //Accordion
            if(app.Content.find('.accordion-heading').length){
                accordionChileatiende.init();
            }

            //Modal Chileatiende
            if($('a[data-toggle="modal-chileatiende"]').length){
                modalChileatiende.init();
            }

            if($('[data-toggle="scroll-to"]').length){
                scrollTo.init();
            }

            $('[data-toggle="tooltip"]').tooltip();

        },
        cambiaTamanoFuente : function(dir){
            if((dir === 1 && app.fontSize < 24) || (dir === -1 && app.fontSize > 12)){
                app.fontSize += (dir*2);
                app.fontSizeFicha += (dir*2);
                app.Content.css({
                    'font-size':app.fontSize+'px',
                    'line-height':(app.fontSize+4)+'px'
                });
                app.Content.find('.text-content, .tab-content, .tab-content li, .tab-content li p').css({
                    'font-size':app.fontSizeFicha+'px',
                    'line-height':(app.fontSizeFicha+22)+'px'
                });
            }
        }
    };

    /*Funcionalidades específicas para mejorar la accesibilidad del sitio*/
    var accesibilidad = {
        init : function () {
            accesibilidad.bindEvents();
            return this;
        },
        cambiaFocoFiltros : function (dir, e) {
            var active = portada.contFiltros.find('.lista-etapas li.active');
            if(dir === 1 && !active.is(':last-child')){
                active.next('li').find('a').focus();
                e.preventDefault();
            }
            if(dir === 1 && active.is(':last-child')){
                app.Portada.contFiltros.find('.btn-filtro-home.active').removeClass('active');
                app.Portada.toggleFiltros();
                app.Portada.contFiltros.find('.btn-filtro-temas a').focus();
                e.preventDefault();
            }
            if(dir === -1 && !active.is(':first-child')){
                active.prev('li').find('a').focus();
                e.preventDefault();
            }
        },
        bindEvents : function () {
            app.Portada.contFichas.on('keydown', '.masonry-item', function (e) {
                var elem = $(this),
                    panelActivo = app.Portada.navFichas.find('li.active');
                if(e.which === 9 && elem.is(':last-child') && !e.shiftKey){
                    if(!panelActivo.is(':last-child')){
                        panelActivo.next().find('a').trigger('click');
                        e.preventDefault();
                    }
                }
                if(e.which === 9 && elem.is(':first-child') && e.shiftKey){
                    if(!panelActivo.is(':first-child')){
                        panelActivo.prev().find('a').trigger('click');
                        e.preventDefault();
                    }
                }
            });

            app.Portada.contFiltros.on('keydown', '.lista-etapas li a', function(e){
                if(e.which === 9 && app.esPortada){
                    if(!e.shiftKey && $(e.target).parent().is(':last-child')){
                        app.Portada.contFiltros.find('.btn-filtro-home.active').removeClass('active');
                        app.Portada.toggleFiltros();
                        app.Portada.contFiltros.find('.btn-filtro-home:last-child a').focus();
                        e.preventDefault();
                    }
                    if(e.shiftKey && $(e.target).parent().is(':first-child')){
                        app.Portada.contFiltros.find('.btn-filtro-home.active a').focus();
                        e.preventDefault();
                    }
                }
            });

            app.Portada.contFiltros.on('keydown', '.cont-carga-etapa li a', function (e) {
                var elem = $(this);
                if(e.which === 9){
                    if(e.shiftKey == false && elem.parent().is(':last-child') && elem.parents('.cont-inner-lista-etapas').is(':last-child')){
                        accesibilidad.cambiaFocoFiltros(1,e);
                    }
                    if(e.shiftKey == true && elem.parent().is(':first-child') && elem.parents('.cont-inner-lista-etapas').is(':first-child')){
                        accesibilidad.cambiaFocoFiltros(-1,e);
                    }
                }
            });

            app.Portada.contFiltros.on('keydown', function (e) {
                if(e.which === 27 && app.esPortada){
                    app.Portada.contFiltros.find('.btn-filtro-home.active').removeClass('active');
                    app.Portada.toggleFiltros();
                }
            });

            app.Portada.contFiltros.on('keydown', '.btn-filtro-home', function (e) {
                var elem = $(this);
                if(e.which === 9 && !e.shiftKey && elem.hasClass('active')){
                    if(elem.data('tipo') == 'etapas')
                        app.Portada.contFiltros.find('.lista-etapas li a').first().focus();
                    else
                        app.Portada.contFiltros.find('.lista-temas input').first().focus();
                    e.preventDefault();
                }
            });

            app.Portada.contFiltros.on('keydown', '.cont-seleccion-temas button[type="submit"]', function (e) {
                if(e.which === 9 && !e.shiftKey && app.esPortada){
                    app.Portada.contFiltros.find('.btn-filtro-home.active').removeClass('active');
                    app.Portada.toggleFiltros();
                }
            });
        }
    };

    var preguntasFrecuentes = {
        init : function(){
            preguntasFrecuentes.encabezados = app.Content.find('.pregunta-encabezado');
            preguntasFrecuentes.contenidos = app.Content.find('.pregunta-contenido');
            preguntasFrecuentes.asignaIdentificador();
            preguntasFrecuentes.bindEvents();
            return this;
        },
        asignaIdentificador : function(){
            preguntasFrecuentes.encabezados.each(function(i, elem){
                $(elem).data('id-pregunta',(i+1));
            });
            preguntasFrecuentes.contenidos.each(function(i, elem){
                $(elem).addClass('id-contenido-pregunta-'+(i+1));
            });
        },
        bindEvents : function(){
            preguntasFrecuentes.encabezados.on('click', function(e){
                var elem = $(this),
                    id = elem.data('id-pregunta');
                elem.toggleClass('active');
                if(elem.hasClass('active')){
                    elem.siblings('.id-contenido-pregunta-'+id).first().stop().slideDown();
                }else{
                    elem.siblings('.id-contenido-pregunta-'+id).first().slideUp();
                }
            });
        }
    };

    var participacion = {
        init : function(){
            app.contParticipacion = app.Content.find('.participacion');
            app.contParticipacion.on('click', '.btn-participacion', function(e){
                var elem = $(this);
                if (app.contParticipacion.data('participacion'))
                    app.contParticipacion.removeClass(app.contParticipacion.data('participacion'));

                if(app.contParticipacion.data('participacion') == elem.data('participacion')){
                    app.contParticipacion.data('participacion', null);
                }else{
                    app.contParticipacion.data('participacion', elem.data('participacion'));
                    app.contParticipacion.addClass(app.contParticipacion.data('participacion'));
                }
                e.preventDefault();
            });

            app.contParticipacion.on('change', 'input[type="radio"]', function(e){
                var elem = $(this),
                    radio_name = elem.attr('name'),
                    selected_id = elem.attr('id'),
                    radio_inputs = app.contParticipacion.find('input[name="'+radio_name+'"]');
                radio_inputs.each(function(i, loop_elem){
                    if(selected_id != loop_elem.id){
                        $(loop_elem).parent('label').removeClass('checked');
                    }else{
                        $(loop_elem).parent('label').addClass('checked');
                    }
                });
            });

            app.contParticipacion.on('submit', 'form', function(e){
                var form = $(this),
                    contMsg = form.next('.ajax-msg'),
                    envio_formulario = $.getJSON(form.attr('action'), form.serialize());
                envio_formulario.success(function(data){
                    if(!data.error){
                        form.fadeOut(500, function(){
                            contMsg.html(data.msg).fadeIn(500);
                        });
                    }
                });
                e.preventDefault();
            });
        }
    };

    var buscador = {
        init : function(){
            buscador.contBuscador = $('.cont-busqueda');
            buscador.bindEvents();
            buscador.initTypeAhead();
            return this;
        },
        bindEvents : function () {
            buscador.contBuscador.on('submit', '#main_search', function (e) {
                var input = $('#main_search_input');
                if(input.val() == ''){
                    e.preventDefault();
                    return false;
                }
            });
        },
        initTypeAhead: function(){
            var buscadorInput=buscador.contBuscador.find('#main_search_input.active_search');

            $(buscadorInput).typeahead({
                source: function(query,process){
                    $.getJSON(site_url+"buscar/ajax_busqueda?buscar="+query,function(data){
                        data.unshift(query);    //Colocamos la busqueda que se esta escribiendo como primera sugerencia
                        process(data);
                        $(buscadorInput).siblings(".typeahead").find("li:first").hide();    //La primera sugerencia la escondemos (Ya se esta viendo en el input)
                    });
                },
                updater: function(item){
                    //Parche para que al seleccionar un resultado, se haga la busqueda en forma inmediata.
                    $(buscadorInput).val(item);
                    $(buscadorInput).closest("form").submit();
                    return item;
                },
                matcher: function(item){
                    return true;
                }
            });
        }
    };

    var portada = {
        init : function(){
            portada.contFichas = $('.cont-fichas-home');
            portada.navFichas = $('.nav-fichas-home');
            portada.contFiltros = $('.cont-filtros-home');
            portada.loadPlugins();
            return this;
        },

        loadPlugins : function(){
            portada.masonryFichas();
            portada.panelesFichas();
            portada.filtrosBusqueda();
        },
        masonryFichas : function(){
            portada.contFichas.imagesLoaded( function() {
                portada.contFichas.filter('.active').masonry({
                    itemSelector : '.masonry-item'
                });
                $(window).on("resize", function () {
                        portada.contFichas.filter('.active').masonry('reload')
                });
            });
        },
        panelesFichas : function(){
            portada.navFichas.on('click', 'a', function(e){
                var elem = $(this),
                    panelNuevo = elem.parent('li');
                if(!panelNuevo.hasClass('active')){
                    var panelActivo = portada.navFichas.find('li.active').removeClass('active');
                    panelNuevo.addClass('active');
                    portada.contFichas.filter('.fichas-'+panelActivo.data('seccion')).removeClass('active');
                    portada.contFichas.filter('.fichas-'+panelNuevo.data('seccion')).addClass('active');
                    portada.masonryFichas();
                    portada.contFichas.filter('.active').find('.masonry-item:first-child a').focus();
                }
                e.preventDefault();
            });
        },
        filtrosBusqueda : function(){
            //portada.cargaFiltrosEtapa();
            portada.contFiltros.on('click', '.lista-etapas li a', function(e){
                var etapa = $(this).parent('li');
                if(!etapa.hasClass('active')){
                    portada.contFiltros.find('.lista-etapas li.active').removeClass('active');
                    etapa.addClass('active');
                    portada.cargaFiltrosEtapa();
                }
                e.preventDefault();
            });
            portada.contFiltros.on('click', '.btn-filtro-home', function(e){
                var filtro = $(this);
                if(!filtro.hasClass('active')){
                    portada.contFiltros.find('.btn-filtro-home.active').removeClass('active');
                    filtro.addClass('active');
                }else{
                    filtro.removeClass('active');
                }
                portada.toggleFiltros();
                e.preventDefault();
            });
            app.Body.on('click', function (e) {
                if(app.Body.hasClass('filtro-active')){
                    var elem = $(e.target);
                    if(!elem.parents('.cont-filtros-home').length){
                        portada.contFiltros.find('.btn-filtro-home.active').removeClass('active');
                        portada.toggleFiltros();
                    }
                }
            });
        },
        toggleFiltros : function(){
            var contSeleccion = portada.contFiltros.find('.cont-seleccion-filtros'),
                filtroActivo = portada.contFiltros.find('.btn-filtro-home.active').data('tipo');
            if(portada.contFiltros.find('.btn-filtro-home.active').length){
                $.when( contSeleccion.find('.cont-seleccion.active').stop().slideUp(500).removeClass('active') ).then(function(){
                    contSeleccion.find('.cont-seleccion-'+filtroActivo).stop().slideDown(500).addClass('active');
                    app.Body.addClass('filtro-active');
                });
            }else{
                contSeleccion.find('.cont-seleccion').stop().slideUp(500).removeClass('active');
                app.Body.removeClass('filtro-active');
            }
        },
        cargaFiltrosEtapa : function(){
            var etapaId = portada.contFiltros.find('.lista-etapas li.active a').data('etapa');
            $.getJSON(site_url+'hechos/ajax_get_hechos', "etapa_id="+etapaId).done(function(data){
                portada.renderFiltrosEtapa(data);
            });
        },
        renderFiltrosEtapa : function(data){
            var total = data.HechosVida.length,
                html = '<div class="span6 cont-inner-lista-etapas"><ul>',
                contCarga = portada.contFiltros.find('.cont-carga-etapa');
            for(var i = 0; i < total; i++){
                var etapa = data.HechosVida[i];

                if(i === Math.ceil(total/2) && total > 12){
                    html += '</ul></div><div class="span6 cont-inner-lista-etapas"><ul>';
                }

                html += '<li><a href="'+site_url+'buscar/fichas/?etapa='+data.id+'&hecho='+etapa.id+'">'+etapa.nombre+'</a></li>';
            }
            html += '</ul></div>';
            contCarga.html(html);
            contCarga.find('li:first-child a').first().focus();
        }
    };

    var googleAnalytics = {
        init : function(){
            googleAnalytics.bindEvents();
            googleAnalytics.addLinksId();
        },
        bindEvents : function(){
            if(typeof _gaq !== "undefined"){
                app.Body.on('mousedown', '[data-ga-te-category]', function(e){
                    var elem = $(this),
                        category = elem.data('ga-te-category')||'',
                        action = elem.data('ga-te-action')||'',
                        label = elem.data('ga-te-label')||'',
                        value = elem.data('ga-te-value');
                    if(label){
                        _gaq.push(['_trackEvent', category, action, label, value]);
                    } else { 
                        _gaq.push(['_trackEvent', category, action, ''+value+'']);
                    }
                });
            }
        },
        addLinksId : function () {
            if(typeof(md5) == "function"){
                app.Body.find('a').each(function (i, e) {
                    var elem = $(this),
                        id = 'link-';
                    if(!elem.attr('id') && $.trim(elem.text())){
                        if(elem.parents('#navegacion').length){
                            id += 'navegacion';
                        }
                        if(elem.parents('footer').length){ /*Footer*/
                            id += 'footer';
                        }
                        if(elem.parents('header').length){ /*Header*/
                            id += 'header';
                        }
                        if(elem.parents('.main-container').length){ /*Main Container*/
                            id += 'main-container';
                        }
                        id += '-'+i+'-'+md5($.trim(elem.text()));
                        elem.attr('id', id);
                    }
                });
            }
        }
    };

    var ficha = {
        init : function(){
            ficha.loadPlugins();
            ficha.bindEvents();
            if(app.Content.hasClass('ficha-flujo')){
                ficha.generaIndiceConenidos();
            }
        },
        bindEvents : function(){
            $('.breadcrumbs').on('onChangeClass', function(e){
                var elem = $(this),
                    btnRealizarTramite = $('.row-ficha-encabezado .btn-realizar-tramite');
                if(elem.hasClass('affix')){
                    btnRealizarTramite.hide();
                }else{
                    btnRealizarTramite.show();
                }
            });

        },
        loadPlugins : function(){
            // Tooltips
            if (app.Content.find('.tooltip-ficha').length) {
                app.Content.find('.tooltip-ficha').tooltip();
            }

            // Valoraciones Ficha
            if(app.Content.find('.valoracion-ficha').length){
                valoracionFicha.init();
            }

            // Tamaño del texto
            app.Content.on('click', 'a.tamano-fuente', function(e){
                app.cambiaTamanoFuente($(this).data('dir'));
                e.preventDefault();
            });

            // ReadSpeaker
            if(app.Content.find('.opciones-accesibilidad .escuchar').length){
                readspeakerPlugin.init();
            }

            // Tabs
            $('#tabs-canales-tramite a:first').tab('show');
            $('#tabs-detalles-tramite a:first').tab('show');

            //Se encierra el contenido de las listas ordenadas en un P para poder estilizar los numeros
            app.Content.find('.tab-content ol li').each(function(i, elem){
                $(elem).wrapInner('<p></p>');
            });

            /*Secciones*/
            ficha.indiceSecciones();

            /*Infografias*/
            if(app.Content.find('.cont-infografia').length){
                ficha.initInfografias();
            }

        },
        generaIndiceConenidos : function(){
            //Busca si el flujo tiene pasos marcados
            ficha.pasos = app.Content.find('.cont-paso-titulo');
            ficha.contenidos = app.Content.find('.cont-paso-contenido');
            if(ficha.pasos.length){
                //Asigna clases a los pasos encontrados
                ficha.pasos.map(function(i, elem){
                    $(ficha.contenidos[i]).addClass('id-paso-'+(i+1));
                    return $(elem).data('paso',(i+1));
                });
                //Asigno los eventos a los pasos
                ficha.pasos.on('click', function(e){
                    var elem = $(this),
                        id = $(this).data('paso');
                    if(!elem.hasClass('active')){
                        ficha.pasos.filter('.active').removeClass('active');
                        ficha.contenidos.filter('.active').removeClass('active');
                        elem.addClass('active');
                        ficha.contenidos.filter('.id-paso-'+id).addClass('active');
                    }
                });
                //Fix para tablas
                var tablas = ficha.contenidos.find('table');
                if(tablas.length){
                    tablas.parents('.cont-paso-contenido').addClass('con-tabla');
                }
            }
        },
        indiceSecciones : function(){
            ficha.indice = app.Content.find('.indice-secciones');
            ficha.secciones = app.Content.find('.texto-seccion');

            ficha.indice.on('click', 'ol a', function(e){
                var elem = $(this).parent('li');
                if(ficha.indice.find('.ver-todo').hasClass('active')){
                    ficha.indice.find('.ver-todo').trigger('click');
                }
                if(elem.hasClass('active')){
                    ficha.toggleIndiceActivo(elem.removeClass('active'), false);
                }else{
                    if(ficha.indice.find('.active').length){
                        ficha.toggleIndiceActivo(ficha.indice.find('.active').removeClass('active'), false);
                    }
                    ficha.toggleIndiceActivo(elem.addClass('active'), true);
                }
                e.preventDefault();
            });

            ficha.indice.on('click', '.ver-todo', function(e){
                var elem = $(this);
                if(elem.hasClass('active')){
                    ficha.secciones.slideUp();
                    elem.removeClass('active').html('Ver todo');
                    elem.data('ga-te-action', 'Más detalles - ver-todo');
                }else{
                    ficha.secciones.slideDown();
                    elem.addClass('active').html('Ocultar');
                    elem.data('ga-te-action', 'Más detalles - ocultar');
                }
                ficha.indice.find('ol .active').removeClass('active');
                e.preventDefault();
            });

            ficha.indice.find('ol a').first().trigger('click');
        },
        toggleIndiceActivo : function(indice, muestra){
            var nombreIndice = indice.find('a').attr('href').replace('#','');
            if(muestra){
                $.when(ficha.secciones.filter('[data-seccion="'+nombreIndice+'"]').stop().slideDown());
            }else{
                ficha.secciones.filter('[data-seccion="'+nombreIndice+'"]').stop().slideUp();
            }
        },
        initInfografias : function(){
            if(!app.Content.find('.row-ficha-encabezado').length) //Solo aplica para la nueva version de la ficha
                return false;

            var infografias = app.Content.find('.cont-infografia');
            infografias.each(function(i, elem){
                var elem = $(elem),
                    textContent = elem.parents('.text-content'),
                    cabecera = textContent.find('.cabecera'),
                    verMasInfografia = elem.find('.ver-mas-infografia');
                cabecera.after(elem);
                elem.show();
            });
        }
    };

    var readspeakerPlugin = {
        init : function(){
            readspeakerPlugin.contentFicha = app.Content.find('#maincontent-ficha');
            app.Content.on('click', '.opciones-accesibilidad .escuchar', function(e){
                var elem = $(this),
                    rs_container = app.Content.find('#readspeaker_container');
                rs_container.toggleClass('active');
                if(rs_container.hasClass('active')){
                    readspeakerPlugin.contentFicha.addClass('readspeak_active');
                    rs_container.css({
                        'top' : elem.position().top,
                        'left' : elem.position().left-170
                    });
                    rs_container.find('.rsbtn_play').click();
                    rs_container.find('#rsPlayer').append('<param name="wmode" value="transparent">');
                }else{
                    readspeakerPlugin.contentFicha.removeClass('readspeak_active');
                }
                e.preventDefault();
            });
        }
    };

    var accordionChileatiende = {
        init : function(){
            app.Content.on('click', '.accordion-heading', function(e){
                var title = $(this),
                    body = title.next('.accordion-body');

                e.preventDefault();

                if(!body.length) return false;

                title.toggleClass('active');

                if(title.hasClass('active'))
                    body.slideDown();
                else
                    body.slideUp();
            });
        }
    };

    var modalChileatiende = {
        init : function(){
            modalChileatiende.container = $('#modal-chileatiende');
            modalChileatiende.form = modalChileatiende.container.find('.ajaxForm');
            modalChileatiende.bindEvents();
        },
        bindEvents : function(){
            $('a[data-toggle="modal-chileatiende"]').on('click', function(e){
                var elem = $(this),
                    src = elem.attr('href'),
                    type = elem.data('modal-type')||'inline',
                    modal = $('#modal-chileatiende').removeClass('iframe img div').attr('style','')
                    btnCerrar = '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">cerrar <span>x</span></button>',
                    btnCerrarImg =  '<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="'+site_url+'assets_v2/img/iconos/cerrar.png"></button>';
 

                switch(type){
                    case 'iframe':
                        var iframe = btnCerrar+'<iframe src="'+src+'" width="650" height="400" frameborder="0"></frame>';
                        modal.addClass('iframe').html(iframe).modal();
                        modal.on('shown', function () {
                            modal.find('button:first').focus();
                        });
                        break;
                    case 'img':
                        var img = $('<img>').attr('src', src).load(function(){
                            modal.css({width:this.width, 'margin-left':((this.width/2)*-1), top:$('body').scrollTop() + 20})
                            modal.addClass('img').html(btnCerrarImg+'<img src="'+src+'">').modal();
                        });
                        break;
                    case 'div':
                        var div_id = elem.data('modal-id'),
                            mas_informacion = div_id.indexOf('#'), /* Asume que parte con 'mas_informacion' */
                            anchor = null;
                        if(mas_informacion !== -1) {
                            anchor = div_id.substr(mas_informacion + 1);
                            div_id = 'mas_informacion';
                        }
                        var div_html = btnCerrar + $('#'+div_id).html();
                        modal.addClass('div').html(div_html).modal();
                        modal.on('shown', {anchor: anchor}, function(e) {
                            if(e.data.anchor !== null) {
                                var cont = $('#modal-chileatiende');
                                modal.find('.anchor').addClass('anchored');
                                var offset = $('#'+e.data.anchor+'.anchored').position().top + cont.scrollTop();
                                cont.animate({ scrollTop: offset }, 300);
                                e.data.anchor = null;
                            }
                        });
                        break;
                    default:
                        modal.load(src, function(){
                            modal.modal();
                            modalChileatiende.form = modalChileatiende.container.find('.ajaxForm');
                            modalChileatiende.initForm();
                            modal.on('shown', function () {
                                modalChileatiende.form.find('input:first').focus();
                            });
                        });
                }
                e.preventDefault();
            });

            modalChileatiende.container.on('keydown', function (e) {
                if(e.which === 27)
                    modalChileatiende.container.modal('hide');
            });

            if(modalChileatiende.form.length){
                modalChileatiende.initForm();
            }
        },
        initForm : function(){
            modalChileatiende.form.on('submit', function(e) {
                if (!modalChileatiende.form.submitting) {
                    var formUrl = modalChileatiende.form.attr('action'),
                            formData = modalChileatiende.form.serialize();
                    formSubmitButton = modalChileatiende.form.find('button[type="submit"]').attr('disabled', 'disabled');
                    modalChileatiende.form.submitting = true;
                    $.ajax({
                        type: 'POST',
                        url: formUrl,
                        data: formData,
                        dataType: 'json'
                    }).done(function(data) {
                        var contValidacion = modalChileatiende.form.find('.validacion');
                        contValidacion.html(data.msg);
                        if (!data.validacion) {
                            formSubmitButton.removeAttr('disabled');
                            modalChileatiende.form.submitting = false;
                        }
                    });
                }
                e.preventDefault();
            });
        }
    };

    var valoracionFicha = {
        init : function(){
            $.cookie.json = true;
            valoracionFicha.container = app.Content.find('.valoracion-ficha');
            valoracionFicha.idFicha = valoracionFicha.container.data('id-ficha');
            valoracionFicha.valoraciones = $.cookie('valoraciones_chileatiende')||{};

            valoracionFicha.textos = [];

            valoracionFicha.actualizaciones_bd = [];
            valoracionFicha.timer = null;
            valoracionFicha.getValoraciones();
            valoracionFicha.bindEvents();
        },
        bindEvents : function(){
            valoracionFicha.container.on('click', '.voto a', function(e){
                var elem = $(this),
                    tipoVoto = elem.parent('.voto').data('voto');

                valoracionFicha.asignarAccion(tipoVoto);
                e.preventDefault();
            });
        },
        asignarAccion : function(tipoVoto){
            if(valoracionFicha.valoraciones[valoracionFicha.idFicha]){
                if((valoracionFicha.valoraciones[valoracionFicha.idFicha] === tipoVoto)){
                    valoracionFicha.updateValoraciones(tipoVoto, 'quitar');
                }else{
                    valoracionFicha.updateValoraciones(tipoVoto, 'cambiar');
                }
            }else{
                valoracionFicha.updateValoraciones(tipoVoto, 'nuevo');
            }
            $.cookie('valoraciones_chileatiende', valoracionFicha.valoraciones);
        },
        updateValoraciones : function(tipoVoto, accion){
            var tipoInverso = tipoVoto==='positivo'?'negativo':'positivo';
            switch(accion){
                case 'quitar':
                    delete valoracionFicha.valoraciones[valoracionFicha.idFicha];
                    valoracionFicha.textos[tipoVoto] += -1;
                    valoracionFicha.actualizaciones_bd.push({tipo:tipoVoto,actualizacion:-1});
                break;
                case 'cambiar':
                    valoracionFicha.textos[tipoInverso] += -1;
                    valoracionFicha.actualizaciones_bd.push({tipo:tipoInverso,actualizacion:-1});
                    /* falls through */
                case 'nuevo':
                    valoracionFicha.textos[tipoVoto] += 1;
                    valoracionFicha.actualizaciones_bd.push({tipo:tipoVoto,actualizacion:1});
                    valoracionFicha.valoraciones[valoracionFicha.idFicha] = tipoVoto;
                break;
            }
            valoracionFicha.updateTextos();
            valoracionFicha.resetUpdateTimer();
        },
        updateTextos : function(){
            valoracionFicha.container.find('.voto-positivo .total-votos').html(valoracionFicha.textos['positivo']);
            valoracionFicha.container.find('.voto-negativo .total-votos').html(valoracionFicha.textos['negativo']);
            valoracionFicha.container.find('.voto').removeClass('active');
            if(valoracionFicha.valoraciones[valoracionFicha.idFicha])
                valoracionFicha.container.find('.voto-'+valoracionFicha.valoraciones[valoracionFicha.idFicha]).addClass('active');
        },
        resetUpdateTimer : function(){
            clearTimeout(valoracionFicha.timer);
            valoracionFicha.timer = setTimeout(function(){
                valoracionFicha.sendUpdate();
            }, 200);
        },
        sendUpdate : function(){
            var evaluacionUrl = site_url+'evaluaciones/evaluar/'+valoracionFicha.idFicha,
                evaluacionData = 'valoraciones='+JSON.stringify(valoracionFicha.actualizaciones_bd);
            $.ajax({
                type : 'POST',
                url : evaluacionUrl,
                data : evaluacionData,
                dataType : 'json'
            }).done(function(data){
                valoracionFicha.actualizaciones_bd = [];
            });
        },
        getValoraciones : function(){
            var evaluacionUrl = site_url+'evaluaciones/get_valoraciones/'+valoracionFicha.idFicha;
            $.getJSON(evaluacionUrl).done(function(data){
                valoracionFicha.textos['positivo'] = parseInt(data.votos_positivos, 10);
                valoracionFicha.textos['negativo'] = parseInt(data.votos_negativos, 10);
                valoracionFicha.updateTextos();
            });
        }
    };

    var vistaInstituciones = {
        init : function(){
            vistaInstituciones.bindEvents();
        },
        bindEvents : function(){
            $('.contenedor-abc').on('click', '.vistas li a', function(e){
                var elem = $(this),
                    parentLi = elem.parents('li'),
                    vistas = elem.parents('.vistas');

                vistas.find('.active').removeClass('active');
                parentLi.addClass('active');

                if(elem.parents('li').hasClass('grupo'))
                    $('.institucion').attr('style','float:left; width: 45%;');
                else
                    $('.institucion').attr('style','float:initial; width: initial;');

                e.preventDefault();
            });
            $('.contenedor-abc').on('click', '.abcedario li a', function(e){
                var letra = this.href.substr(-1,1),
                    anchor = $('#instituciones').find('a[name="'+letra+'"]');
                 $('body').animate({scrollTop : (anchor.position().top - 40)},'fast');
                 window.location.hash = letra;
                 e.preventDefault();
            });
        }
    };

    var serviciosdisponibles = {
        init : function(){
            serviciosdisponibles.servicios = app.Content.find('.cont-servicio');
            serviciosdisponibles.bindEvents();
            return serviciosdisponibles;
        },
        bindEvents : function () {
            serviciosdisponibles.servicios.on('click', 'th', function(e){
                var thead = $(this).parents('thead');
                thead.toggleClass('active');
            });
        }
    }

    var puntosatencion = {
        init : function(){
            // En Metaficha se llama app.init cada vez que se abre una subficha. Procesar denuevo la informacion quita opciones.
            if(puntosatencion.filtros !== undefined)
                return puntosatencion;

            puntosatencion.contResultados = app.Content.find('.cont-resultados');
            puntosatencion.filtros = app.Content.find('.filtros-puntosatencion');
            puntosatencion.filtroRegiones = puntosatencion.filtros.find('#region');
            puntosatencion.filtroProvincias = puntosatencion.filtros.find('#provincia');
            puntosatencion.filtroComunas = puntosatencion.filtros.find('#comuna');
            puntosatencion.obtieneInfoSectores();
            
            puntosatencion.bindEvents();

            //Se llama al evento change del filtro de regiones para actulizar los otros filtros
            puntosatencion.filtroRegiones.trigger('change');

            return puntosatencion;
        },
        bindEvents : function(){
            app.Content.on('click', '.mas-info-puntoatencion', function(e){
                var elem = $(this);

                if(elem.hasClass('active'))
                    elem.removeClass('active').trigger('classChanged');
                else{
                    elem.addClass('active').trigger('classChanged');
                    elem.siblings('.mas-info-puntoatencion').removeClass('active').trigger('classChanged');
                }
                e.preventDefault();
            });
            app.Content.on('classChanged', '.mas-info-puntoatencion', function(e){
                var elem = $(this),
                    masInfo = elem.data('mas-info'),
                    parent = elem.parents('.cont-puntoatencion'),
                    contMasInfo = parent.next('.cont-mas-info-puntoatencion');
                if(elem.hasClass('active')){
                    contMasInfo.find('.cont-'+masInfo).show();
                    if(masInfo=='mapa')
                        puntosatencion.cargaMapaPuntoatencion(elem, contMasInfo.find('.cont-mapa .row-fluid'));
                }else{
                    contMasInfo.find('.cont-'+masInfo).hide();
                }
            });
            puntosatencion.filtros.on('change', 'select', function(e){
                var value = this.value,
                    selected = null;
                if(this.id === 'provincia' && value === ''){
                    puntosatencion.filtroRegiones.trigger('change');
                    return false;
                }
                if(this.id === 'region'){
                    puntosatencion.filtroProvincias.html('<option value="">- Todas -</option>');
                    $.each(puntosatencion.provincias, function(i, elem){
                        if(elem.codigo.substr(0,value.length) === value){
                            selected = puntosatencion.provinciaSeleccionada == elem.codigo ?  'selected="selected"' : '';
                            puntosatencion.filtroProvincias.append('<option value="'+elem.codigo+'" '+selected+'>'+elem.nombre+'</option>');
                        }
                    });
                }
                if(this.id === 'provincia' || this.id === 'region'){
                    puntosatencion.filtroComunas.html('<option value="">- Todas -</option>');
                    $.each(puntosatencion.comunas, function(i, elem){
                        if(elem.codigo.substr(0,value.length) === value){
                            selected = puntosatencion.comunaSeleccionada == elem.codigo ?  'selected="selected"' : '';
                            puntosatencion.filtroComunas.append('<option value="'+elem.codigo+'" '+selected+'>'+elem.nombre+'</option>');
                        }
                    });
                }
            });
            app.Content.on('click', '.cont-region-oficinas h5.titulo-region', function(e){
                var elem = $(this);
                if(!elem.data('loaded')){
                    puntosatencion.obtienePuntosAtencionRegion(elem.data('region')).success(function(data){
                        if(!data.error){
                            puntosatencion.renderPuntosAtencionRegion(elem.parents('.cont-region-oficinas'), data);
                            elem.addClass('active').data('loaded', true);
                        }
                    });
                }else{
                    if(elem.hasClass('active')){
                        elem.removeClass('active').next('.row-oficinas').hide();
                    }else{
                        elem.addClass('active').next('.row-oficinas').show();
                    }
                }
                e.preventDefault();
            });
            app.Content.on('click', '.row-oficinas .paginacion a', function(e){
                var elem = $(this);
                puntosatencion.obtienePuntosAtencionRegion(null, elem.attr('href')+'&ajaxcall=true').success(function(data){
                    if(!data.error){
                        puntosatencion.renderPuntosAtencionRegion(elem.parents('.cont-region-oficinas'), data);
                    }
                });
                e.preventDefault();
            });
        },
        getUrlVars : function() {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
            });
            return vars;
        },
        obtienePuntosAtencionRegion : function(codigo, url){
            var site_type = puntosatencion.getUrlVars()["e"];
            if(site_type && site_type == 1)
                url = url || site_url+'/oficinas/index/o.sector_codigo/ASC?region='+codigo+'&e=1';
            else
                url = url || site_url+'/oficinas/index/o.sector_codigo/ASC?region='+codigo;
            return $.getJSON(url);
        },
        renderPuntosAtencionRegion : function(contenedorRegion, data){
            contenedorRegion.find('.row-oficinas').html(data.oficinas);
        },
        cargaMapaPuntoatencion : function(elem, contMapa){
            if(!$.trim(contMapa.html())){
                var codIframeMapa = '<iframe src="'+site_url+'/api/mapa?dominio='+site_url+'&id_oficina='+elem.data("oficina-id")+'&titulo=0&filtros=0&width=760&height=350&zoom=12" frameborder="0" width="760" height="350"></iframe>';
                contMapa.append(codIframeMapa);
            }
        },
        obtieneInfoSectores : function(){
            puntosatencion.provincias = [],
            puntosatencion.comunas = [];
            puntosatencion.provinciaSeleccionada = null;
            puntosatencion.comunaSeleccionada = null;

            puntosatencion.filtros.find('#provincia option').each(function(i, elem){
                if(elem.value != ''){
                    puntosatencion.provincias.push({codigo:elem.value, nombre:elem.textContent||elem.innerText});
                    if(elem.selected)
                        puntosatencion.provinciaSeleccionada = elem.value;
                }
            });

            puntosatencion.filtros.find('#comuna option').each(function(i, elem){
                if(elem.value != ''){
                    puntosatencion.comunas.push({codigo:elem.value, nombre:elem.textContent||elem.innerText});
                    if(elem.selected)
                        puntosatencion.comunaSeleccionada = elem.value;
                }
            });
        }
    };

    var scrollTo = {
        init : function(){
            scrollTo.elems = $('[data-toggle="scroll-to"]');
            scrollTo.breadcrumbs = $('.breadcrumbs');
            scrollTo.bindEvents();
        },
        bindEvents : function(){
            scrollTo.elems.on('click', function(e){
                var elem = $(this),
                    target = $(elem.data('scroll-to')),
                    ajusteAffix = 0;
                if(!target.length)
                    target = $(elem.attr('href'));
                if(!target.length)
                    target = $('body');

                //Se verifica que no esté activo el affix del breadcrumbs
                if(!scrollTo.breadcrumbs.hasClass('affix'))
                    ajusteAffix = scrollTo.breadcrumbs.height();

                $('body, html').animate({scrollTop : (target.offset().top - ajusteAffix)},500);
                e.preventDefault();
            });
        }
    };

    /*Se utiliza para los contenidos genéricos del sitio*/
    var genericos = {
        init : function(){
            genericos.infoVideos();
            genericos.bindEvents();
            return genericos;
        },
        bindEvents : function(){
            var videos = $('#maincontent .cont-videos');
            if(videos.length){
                videos.on('click', '.video-thumb', function(e){
                    var elem = $(this),
                        videoPrincipal = videos.find('.video-principal');
                    if(elem.hasClass('active'))
                        return false;
                    videos.find('.cont-videos-thumbs .active').removeClass('active');
                    elem.addClass('active');
                    videoPrincipal.find('iframe').attr('src','http://www.youtube-nocookie.com/embed/'+elem.data('video-id')+'?rel=0')
                });
            }
            var tabs = $('#maincontent .nav-tabs');
            if(tabs.length){
                tabs.on('click', 'a', function (e) {
                    var $elem = $(this),
                        content = $('#'+$elem.attr('rel')),
                        parentLi = $elem.parent('li'),
                        activeLi = tabs.find('li.active'),
                        activeContent = $('#'+activeLi.find('a').attr('rel'));
                    activeLi.removeClass('active');
                    activeContent.addClass('inactivo');

                    parentLi.addClass('active');
                    content.removeClass('inactivo');
                    e.preventDefault();
                });
            }
        },
        infoVideos : function(){
            var videos = $('.video-thumb');
            if(videos.length){
                videos.each(function(i, elem){
                    var video = $(elem);
                    $.ajax({
                        url : 'https://gdata.youtube.com/feeds/api/videos/'+video.data("video-id")+'?v=2&alt=jsonc',
                        dataType : 'jsonp',
                        success : function(d){
                            if(d.data){
                                video.find('p').html(d.data.title);
                            }
                        }
                    });
                });
            }
        }
    }

    //Tne ChileAtiende
    var tneChileatiende = {
        init : function(){
            this.content = $('.contenido-tne');
            this.tableServicios = this.content.find('.table-servicios-tne');
            this.breadcrumbs = $('.breadcrumbs');
            this.bindEvents();
            this.addAltAttributes();
            return this;
        },
        bindEvents : function(){
            var self = this;
            this.content.on('change', '#regiones-oficinas-tne', function(e){
                self.tableServicios.find('.active').removeClass('active');
                self.tableServicios.find('#region-'+this.value).addClass('active');
            });
            this.content.on('click', '.boton-tramite-tne', function(e){
                //Se verifica que no esté activo el affix del breadcrumbs
                var ajusteAffix = 0;
                if(!self.breadcrumbs.hasClass('affix'))
                    ajusteAffix = self.breadcrumbs.height();

                var titulo = self.content.find('h3').first();
                self.content.find('.row-tabla-oficinas-tne').fadeIn();
                $('body, html').animate({scrollTop : (titulo.offset().top - ajusteAffix - 60)},500);
            });
        },
        addAltAttributes : function(){
            var iconos = this.content.find('span.icon-tramite-primera-tarjeta, span.icon-tramite-revalidacion, span.icon-tramite-reposicion'),
                iconos_inactivos = iconos.filter('.inactivo');
            iconos.each(function(e, i){
                var elem = $(this),
                    title = 'Obtención disponible en esta oficina';
                if(elem.hasClass('icon-tramite-revalidacion'))
                    title = 'Revalidación disponible en esta oficina';
                if(elem.hasClass('icon-tramite-reposicion'))
                    title = 'Reposición disponible en esta oficina';
                elem.attr('title', title);
            });
            iconos_inactivos.each(function(e, i){
                var elem = $(this),
                    title = 'Obtención no disponible en esta oficina';
                if(elem.hasClass('icon-tramite-revalidacion'))
                    title = 'Revalidación no disponible en esta oficina';
                if(elem.hasClass('icon-tramite-reposicion'))
                    title = 'Reposición no disponible en esta oficina';
                elem.attr('title', title);
            });
            iconos.tooltip();
        }
    }

    //Tne ChileAtiende
    var enLineaChileatiende = {
        init : function(){
            this.content = $('.contenido-en-linea');
            this.content.find('.contenedor').hide();
            this.bindEvents();
            return this;
        },
        bindEvents : function(){
            var self = this;
            this.content.find('.opciones_menu').not('.opcion_menu_mobile').on('click', function(e){
                e.preventDefault();
                self.content.find('.contenedor').hide();
                self.content.find('#contenedor_'+this.id).fadeIn();
                self.content.find('.opciones_menu').removeClass('active');
                $(this).addClass('active');
                console.log('pala');
            });
        }
    }

    var encuestasChileatiende = {
        init : function(){
            var self = this;

            this.tiempoEspera = 60000;
            this.modal = $('#modal-encuestas');
            this.form = this.modal.find('#form-encuestas');
            this.contTexto = this.modal.find('.cont-texto-encuesta');
            this.contMensaje = this.modal.find('.cont-mensaje-encuesta');
            this.encuesta_id = this.form.find('#encuesta_id').val();

            if(!$.cookie('encuesta_chileatiende_' + this.encuesta_id )){
                if(Math.random() < 0.1){
                    this.timmer = setTimeout(function(){
                        self.muestraEncuesta();
                        $.cookie('encuesta_chileatiende_' + self.encuesta_id, true);
                    }, self.tiempoEspera);

                    this.bindEvents();
                }
            }

            return this;
        },

        bindEvents : function() {
            var self = this;
            this.form.on('submit', function(){
                e.preventDefault();
            });
            this.form.on('click', '.btn-form-encuesta', function(e){
                var btnResultado = $(this),
                    hiddenResultado = self.form.find('#encuesta_resultado');

                hiddenResultado.val(btnResultado.data('value'));

                var response = $.ajax(self.form.attr('action'), {
                    "data" : self.form.serialize(),
                    "dataType" : "json",
                    "method" : "post"
                });

                response.always(function(result){
                    self.contTexto.fadeOut(200, function(){
                        self.contMensaje.fadeIn(200);
                    });
                });
            });
        },

        muestraEncuesta : function(){
            if(!$('.cont-barra-campanas-modulo').length){
                this.modal.modal({
                    "backdrop" : false
                });
            }
        }
    }

    $(function(){
        window.app = app.init();
    });
})(jQuery);