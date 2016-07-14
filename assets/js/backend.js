function createUploader(){
    var uploader = new qq.FileUploader({
        element: document.getElementById('uploads'),
        action: site_url+'backend/uploads/subirArchivo',
        multiple: true,    
        template: '<div class="qq-uploader">' + 
        '<div class="qq-upload-drop-area"><span>Arrastre sus archivos aquí</span></div>' +
        '<div class="qq-upload-button">Cargar sus archivos</div>' +
        '<ul class="qq-upload-list"></ul>' + 
        '</div>',
        fileTemplate: '<li>' +
        '<span class="qq-upload-file"></span>' +
        '<span class="qq-upload-spinner"></span>' +
        '<span class="qq-upload-size"></span>' +
        '<a class="qq-upload-cancel" href="#">Cancelar</a>' +
        '<span class="qq-upload-failed-text">Falló</span>' +
        '</li>'
    });
    
}

$(document).ready(function(){
    //habilita/deshabilita la posibilidad de llenar datos extendidos para fichas personas
    $('#personas').click(function(){
        $('#clasificacion-personas').attr('style','display:block');
        $('#clasificacion-emprendete').attr('style','display:none');
    });
    $('#ambos').click(function(){
        $('#clasificacion-personas').attr('style','display:block');
        $('#clasificacion-emprendete').attr('style','display:block');
    });
    $('#empresas').click(function(){
        $('#clasificacion-personas').attr('style','display:none');
        $('#clasificacion-emprendete').attr('style','display:block');
    });
    $('#chkbox_exterior').on('change', function(e){
        // if(this.checked){

        // }
        $('#tipo_residente').prop('disabled', !this.checked).trigger("chosen:updated");
        $('#chkbox_exterior_destacado').prop('disabled', !this.checked);
    });

    // INFO: habilita/deshabilita las opciones de metaficha
    $('#metaficha_si').click(function(){
        $("form").find('input[name^=metaficha_]').each(function(index, elem) { 
            if(parseInt($(this).attr("value")) == 0)
                $(this).click();
        });
        $('.metaficha_display').each(function(index, elem) {
            if($(this).is('tr'))
                $(this).attr('style','display:table-row');
            else
                $(this).attr('style','display:block');
        });
    });
    $('#metaficha_no').click(function(){
        // INFO: vuelve todas las opciones a "Si"
        $("form").find('input[name^=metaficha_]').each(function(index, elem) { 
            if(parseInt($(this).attr("value")) == 1)
                $(this).click();
        });
        $('.metaficha_display').attr('style','display:none');
    });
    $('input[name^=metaficha_]').click(function() {
        var input_name = $(this).attr("name").substring(10);
        var input_id = $('textarea[name^='+input_name+']').attr('id');
        var selector = (input_id === undefined) ? 'input[name^='+input_name+']' : "#"+input_id;
        var input_value = parseInt($(this).attr("value"));
        if(input_value == 1) {
            $(selector).attr('readonly', false);
            $(selector).attr('rows', '15');
            if(input_id !== undefined)
                tinyMCE.execCommand("mceAddControl", true, input_id);
        } else {
            if(input_id !== undefined)
                tinyMCE.execCommand("mceRemoveControl", true, input_id);
            $(selector).attr('readonly', 'readonly');
            $(selector).attr('rows', '3');
            $(selector).attr('value', '');
        }
    });
    $("select[name='metaficha_categoria']").change(function() {
        if($(this).children(':selected').attr('value') == 'region-comuna')
            $('#metaficha_categoria_msg').attr('style', 'display: block');
        else
            $('#metaficha_categoria_msg').attr('style', 'display: none');
    });

    $('.fps').click(function(){
        //$('#puntaje_fps').attr('style','display:none');
        // $('#puntaje_fps_min').val('');
        // $('#puntaje_fps_max').val('');
        $('#puntaje_fps_min').attr('disabled','disabled');
        $('#puntaje_fps_max').attr('disabled','disabled');

        if($('.fps').filter(':checked').val() == 1) {
            $('#puntaje_fps_min').removeAttr('disabled');
            $('#puntaje_fps_max').removeAttr('disabled');
            //$('#puntaje_fps').attr('style','display:block');
        }
    });

    $('input[name="rubro_sel"]').click(function(){
        $('.rubro-select').attr('style','display:block');
        if(parseInt($(this).val()))
            $('.rubro-select').attr('style','display:none');
    });

    $('input[name="venta_anual_sel"]').click(function(){
        $('.venta_anual-select').attr('style','display:block');
        if(parseInt($(this).val()))
            $('.venta_anual-select').attr('style','display:none');
    });

    $('input[name="formalidad_sel"]').click(function(){
        $('.formalidad-select').attr('style','display:block');
        if(parseInt($(this).val()))
            $('.formalidad-select').attr('style','display:none');
    });
    
    //$("ul li a[title]").tooltip();
    //hermosea los select list
    $(".chzn-select").chosen(); 
    
    $("#vista").click(function(){ 
        $("#secondary").attr('id','secondary-icon').toggle( 'blind', options, 500 );
    });

    $("#crear").click(function(){
        $("#password").attr('value','');
        $("#confirm_password").attr('value','');
        $(".crear").attr('style', 'display:block');
        $(".generar").attr('style', 'display:none');
    });
    
    $("#generar").click(function(){
        $("#generated_pw").attr('value','');
        $(".crear").attr('style', 'display:none');
        $(".generar").attr('style', 'display:block');
    });
    
    //efecto acordeon menu izquierdo sistema
    $( "#secondary h2" ).click(function(){
        if($(this).next(".content").css("display") == "block"){
            $(this).next(".content").animate({
                opacity:0, 
                height: 0
            },500,function(){
                $(this).css('display','none');
            });
        }else{
            $(".content").animate({
                opacity:0, 
                height: 0
            },100,function(){
                $(this).css('display','none');
            });
            $(this).next(".content").animate({
                opacity:0,
                opacity:1, 
                height: '100%'
            },200,function(){
                $(this).css('display','block');
            });
        }

    });
    
    //despliega/oculta acceso rápido de la portada
    var cnt = 1;
    $(".graph").click( function(){
        var options = {};
        $( ".stats" ).toggle( 'blind', options, 500 );
        if(cnt) {
            $('.graph').html('Gráficos (+)');
            cnt=0;
        } else {
            $('.graph').html('Gráficos (-)');
            cnt=1;
        }
    });
    
    // INFO: Selecciona los INPUT que van a ser cargados automaticamente con TinyMCE
    var elementos = 'editorA,editorN,editorT';
    $("form").find('input[name^=metaficha_]').each(function(index, elem) { 
        var input_name = $(this).attr("name").substring(10);
        var input_id = $('textarea[name^='+input_name+']').attr('id');
        if ( ($(this).attr('checked') == 'checked' && parseInt($(this).attr("value")) == 1) ) {
            elementos = elementos + (input_id === undefined ? '' : ','+input_id);
        }
        else if ( ($(this).attr('checked') == 'checked' && parseInt($(this).attr("value") ) == 0) ) {
            var selector = (input_id === undefined) ? 'input[name^='+input_name+']' : "#"+input_id;
            $(selector).attr('readonly', 'readonly');
            $(selector).attr('rows', '3');
        }
    });

    //carga editor wyswyg tinimce
    tinyMCE.init({
        // General options
        mode : "exact",
        theme : "advanced",
        // elements : "editorA,editorB,editorC,editorD,editorE,editorF,editorG,editorH,editorI,editorJ,editorK,editorL,editorM,editorN,editorO,editorP,editorQ,editorR,editorS,editorT,editorU,editorV,editorW,editorX,editorY,editorZ",
        elements : elementos,
        //plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        //language : "es",
        //gecko_spellcheck : true,
        //valid_elements: "a,strong/b,br,ul,li,ol,p,table,tr,td,iframe",
        //spellchecker_languages : "+Spanish=es,English=en",
        //extended_valid_elements : "a[href|target=_blank],script[type|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder]",

        entity_encoding: "raw",
        
        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,|,cut,copy,paste,pasteword,|,bullist,numlist,|,undo,redo,|,removeformat,|,outdent,indent,blockquote,|,link,unlink,|,search,replace,|,code,preview",
        theme_advanced_buttons2 : "tablecontrols,spellchecker,media,image,styleselect",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        
        handle_event_callback : function(event,editor){
            if(event.type == 'keypress' || event.keyCode == '8' || event.keyCode == '46'){
                //Esto permite que aparezca el boton comentar en los campos tinyMCE
                $("#"+editor.id).next().next().find('span').show('fast')
            }
        },
        // Style formats
        style_formats : [
                // {title : 'Descripción Ficha', block : 'div', classes : 'descripcion_ficha'},
                {title : 'Título - celeste', block : 'p', classes : 'titulo_celeste'},
                {title : 'Título - rojo', block : 'p', classes : 'titulo_rojo'},
                {title : 'Título - azul', block : 'p', classes : 'titulo_azul'},
                {title : 'Icono lista - Oficina', selector : 'li', classes : 'icono-canal-oficina'},
                {title : 'Icono lista - Online', selector : 'li', classes : 'icono-canal-online'},
                {title : 'Icono lista - Correo', selector : 'li', classes : 'icono-canal-correo'},
                {title : 'Icono lista - Callcenter', selector : 'li', classes : 'icono-canal-callcenter'}
        ],
        content_css : "/assets/css/tinymce/styles.css"
    });

    $(".tagitTags").tagit({
        source: site_url+"backend/tags/ajax_get_tags",
        forceSelect: false,
        name: "tags"
    });

    $(".tagitUrlAlertas").tagit({
        source: site_url+"backend/alertas/ajax_get_urls",
        forceSelect: false,
        name: "urls"
    });


    $(".selectEntidades").change(function(){
        if(this.value==0){
            $(".selectServicios").empty();
            var html="<option value='0'>Todos</option>";
            $(".selectServicios").html(html);
            $(".selectServicios").trigger("liszt:updated");
        }
        else{
            $.getJSON(site_url+'backend/backend/ajax_get_servicios/'+this.value,null,function(response){
                $(".selectServicios").empty();
                var html="<option value='0'>Todos</option>";

                $.each(response,function(index,value){
                    html+="<option value='"+value.codigo+"'>"+value.nombre+"</option>";
                });
                $(".selectServicios").html(html);
                $(".selectServicios").trigger("liszt:updated");
            });
        }
        
        
    });

    //Parte del formulario que te permite ingresar varios items de un select en una tabla.
    $(".widgetSelectTable .agregar").click(function(){
        var id=$(".widgetSelectTable select option:selected").val(); 
        //console.log(id);
        if(id!='') {
            var nombre=$(".widgetSelectTable select option:selected").attr('otro');
            var colorTmp=$("#tablaHV tr:last").attr('style');
            if(colorTmp)
                var color = colorTmp.split(':');
            else
                var color = ' #ededed';

            color = ((color==' #ededed')||(color[1].toLowerCase()==' #ededed')||(color[1]==' rgb(237, 237, 237);')) ? '#FFF' : '#EDEDED';

            $(".widgetSelectTable table tbody").append("<tr style='background-color: "+color+"'><td><span style='font-weight: bold;'>"+nombre+"</span><input type='hidden' name='hechosvida[]' value='"+id+"' /></td><td><a href='#' class='eliminar'>Eliminar</a></td></tr>");
        }
        return false;
    });
    $(".widgetSelectTable .eliminar").live("click",function(){
        $(this).parent().parent().remove();
        
        return false;
    });
    //Parte del formulario que te permite ingresar varios items de un select en una tabla.
    //emprendete
    $(".widgetSelectTableAE .agregar").click(function(){
        var id=$(".widgetSelectTableAE select option:selected").val(); 
        //console.log(id);
        if(id!='') {
            var nombre=$(".widgetSelectTableAE select option:selected").attr('otro');
            var colorTmp=$("#tablaAE tr:last").attr('style');
            if(colorTmp)
                var color = colorTmp.split(':');
            else
                var color = ' #ededed';

            color = ((color==' #ededed')||(color[1].toLowerCase()==' #ededed')||(color[1]==' rgb(237, 237, 237);')) ? '#FFF' : '#EDEDED';

            $(".widgetSelectTableAE table tbody").append("<tr style='background-color: "+color+"'><td><span style='font-weight: bold;'>"+nombre+"</span><input type='hidden' name='apoyosestado[]' value='"+id+"' /></td><td><a href='#' class='eliminar'>Eliminar</a></td></tr>");

            // Si se selecciona cualquier Apoyo Estado se tiene que setear por defecto la Ficha de Proteccion
            // Social al rango por defecto.
            $(".fps").prop('checked', true);
            $('#puntaje_fps_min').removeAttr('disabled');
            $('#puntaje_fps_max').removeAttr('disabled');
        }
        return false;
    });
    $(".widgetSelectTableAE .eliminar").live("click",function(){
        $(this).parent().parent().remove();
        
        return false;
    });

    $(".widgetSelectTableAS .agregar").click(function(){
        var id=$(".widgetSelectTableAS select option:selected").val(); 
        //console.log(id);
        if(id!='') {
            var nombre=$(".widgetSelectTableAS select option:selected").attr('otro');
            var colorTmp=$("#tablaAE tr:last").attr('style');
            if(colorTmp)
                var color = colorTmp.split(':');
            else
                var color = ' #ededed';

            color = ((color==' #ededed')||(color[1].toLowerCase()==' #ededed')||(color[1]==' rgb(237, 237, 237);')) ? '#FFF' : '#EDEDED';

            $(".widgetSelectTableAS table tbody").append("<tr style='background-color: "+color+"'><td><span style='font-weight: bold;'>"+nombre+"</span><input type='hidden' name='hechosempresa[]' value='"+id+"' /></td><td><a href='#' class='eliminar'>Eliminar</a></td></tr>");
        }
        return false;
    });
    $(".widgetSelectTableAS .eliminar").live("click",function(){
        $(this).parent().parent().remove();
        
        return false;
    });
    
    $("a.popup").click(function(){
        var url=this.href;
        newwindow=window.open(url,'window'+Math.random(),'height=880,width=760,scrollbars=yes,location=no,toolbar=no,resizable=yes');
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }); 
    
    $("a.popupcompara").click(function(){
        var url=this.href;
        newwindow=window.open(url,'window'+Math.random(),'height=768,width=1024,scrollbars=yes,location=no,toolbar=no,resizable=yes');
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }); 
    
    $(".dragProyecto").draggable({
        revert: "invalid",
        helper: "clone"
    });

    $(".dropProyecto").droppable({
        accept: ".dragProyecto",
        //activeClass: 'dropProyectoActive',
        hoverClass: 'dropProyectoActive',
        drop: function(ev, ui) {
            var dropProyecto=$(this);
            var proyectosList=$(dropProyecto).find("ul.proyectosList");
            var compareButton=$(dropProyecto).find("a.compareButton");
            var cleanButton=$(dropProyecto).find("a.clear");
            $(".dropProyecto").addClass("dropProyectoActive");
            if($(proyectosList).find("li").size()>=2){
                alert("Solo se pueden comparar 2 revisiones a la vez.");
            }
            else{
                $(ui.draggable).addClass("dropProyectoActive");
                var id=$(ui.draggable).find(".idItem").text();
                $(proyectosList).append("<li>Revisión <span class='idProyecto'>"+id+"</span></li>");
                if ($(proyectosList).find("li").size()==2){
                    var a=$(proyectosList).find("li:first .idProyecto").text();
                    var b=$(proyectosList).find("li:last .idProyecto").text();
                    $(compareButton).attr("href",site_url+"backend/fichas/ajax_ficha_comparar/"+a+"/"+b);
                    $(compareButton).show();
                    $(cleanButton).show();

                    $(".dropProyectoActive").addClass("dropProyectoComplete");
                    $(".dropProyectoActive").removeClass("dropProyectoActive");
                }
            }
        }
    });

    $(".dropProyecto .clear").click(function(){
        var dropProyecto=$(".dropProyecto");
        var proyectosList=$(dropProyecto).find("ul.proyectosList");
        var compareButton=$(dropProyecto).find("a.compareButton");
        var cleanButton=$(dropProyecto).find("a.clear");
        $(".dropProyectoComplete").removeClass("dropProyectoComplete");
        $(proyectosList).find("li").remove();
        $(compareButton).hide();
        $(cleanButton).hide();


        return false;
    });
    
    $('.ajaxOverlay').overlay({
        mask: {
            color: '#000000',
            loadSpeed: 200,
            opacity: 0.8
        },
        onBeforeLoad: function() {
            var url=this.getTrigger().attr("href");
            var wrapper=this.getOverlay().find(".wrapper");
            var loading=this.getOverlay().find(".loading");
            loading.show();
            wrapper.empty();
            wrapper.load(url, function(){
                loading.hide();
            });
        }
    });
    
    /*Funciones para la pantalla editar de ficha*/

    $('.comentario').click(function(){
        $(this).next('.comentario_texto').toggle('slow');
    });

    $('.ajaxForm input,.ajaxForm textarea').keyup(function(e){
        // Si esta bloqueado en MetaFicha no se despliega mensaje de comentario
        var readonly = $(this).attr('readonly');
        if(readonly !== 'readonly')
            $(this).next('.comentario_wrap').find('.comentario').show("fast");
    });

    $('.ajaxForm input,.ajaxForm textarea').click(function(){
        var readonly = $(this).attr('readonly');
        if(readonly === 'readonly'){
            var radio_button = $(this).parent().parent().find(':radio[value=1]');
            radio_button.click();
        }
    });

    //Para generar el preview del codigo del proyecto
    //se comprueba que exista el selector de instituciones, de no encontrarse, se
    //parametriza para obtener el código de la institucion desde un input oculto
    $("select[name=servicio_codigo]").change( codigoPreview );

    if($("#uploads").length) {
        createUploader();
    }

    $(".sello_chilesinpapeleo").on('click', function(e){
    	var elem = $(this);
    	if(confirm('Esta seguro que desea '+ (elem.data('estado')=='activo'?'desactivar':'activar') +' el sello de ChileSinPapeleo para la ficha ['+elem.data('titulo-ficha')+']')){
    		$.getJSON(elem.attr('href'), function(data){
    			if(!data.validacion){

    			}else{
    				var img = elem.find('img'),
    					src_replace = data.sello_chilesinpapeleo?{find:'off',replace:'on'}:{find:'on',replace:'off'};
    				img.attr('src', img.attr('src').replace(src_replace.find, src_replace.replace));
    			}
    		});
    	}
    	e.preventDefault();
    });

    //Datepicker en date de editar ficha
    $( ".fecha_de_actualizacion" ).datepicker({ 
        minDate: null,
        maxDate: new Date,
        numberOfMonths: 1,
        firstDay: 1, 
        dateFormat: "dd-mm-yy", 
        dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ], 
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"], 
        monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]
        
    });

    if($('#tramites_en_convenio_edit').size()){
        tramiteEnConvenio.init();
    }

});

var tramiteEnConvenio = {
    
    init: function(){

        //vars
        tramiteEnConvenio.world = $('#global');
        tramiteEnConvenio.include = $('#oficinas-include');
        tramiteEnConvenio.include_block = $('.oficinas-include-block');
        tramiteEnConvenio.exclude = $('#oficinas-exclude');
        tramiteEnConvenio.exclude_block = $('.oficinas-exclude-block');
        tramiteEnConvenio.get_oficinas = $('#trae_oficinas_ficha');
        tramiteEnConvenio.feedback = $('#feedback_service').hide();

        //events
        tramiteEnConvenio.world.on('change',tramiteEnConvenio.worldChange);
        tramiteEnConvenio.world.change();

        tramiteEnConvenio.get_oficinas.on('click',tramiteEnConvenio.getOficinas);
    },

    getOficinas: function(e){
        e.preventDefault();
        $.getJSON($(this).attr('href')+'/'+$('#ficha_oficina_id').val(),function(data){

            if(data.error){
                //Feedback
                tramiteEnConvenio.feedback.html("Error!: Trámite inexistente");

            } else {
                //Global
                if(data.global){
                    tramiteEnConvenio.world.attr('checked','checked');
                } else {
                    tramiteEnConvenio.world.removeAttr('checked');
                }

                //Clear input
                tramiteEnConvenio.world.change();
                tramiteEnConvenio.include.find("option:selected").removeAttr("selected");
                tramiteEnConvenio.exclude.find("option:selected").removeAttr("selected");
                
                //Set oficinas
                if(data.global){
                    tramiteEnConvenio.exclude.find("option").each(function(i,e1){
                        if($(e1).val() != '' && $.inArray( $(e1).val(), data.oficinas )==-1){
                            $(e1).attr('selected','selected');
                        }
                    });
                    tramiteEnConvenio.exclude.trigger("liszt:updated");
                } else {
                    tramiteEnConvenio.include.find("option").each(function(i,e2){
                        if($(e2).val() != '' && $.inArray( $(e2).val(), data.oficinas )>-1){
                            $(e2).attr('selected','selected');
                        }
                    });
                    tramiteEnConvenio.include.trigger("liszt:updated");
                }

                //Feedback
                tramiteEnConvenio.feedback.html("Sucursales copiadas desde:"+data.titulo);
            }

            tramiteEnConvenio.feedback.fadeIn().delay(5000).fadeOut();
            $('#ficha_oficina_id').delay(5000).val('');

        });
    },

    worldChange: function(){
        if($(this).is(':checked')){
            tramiteEnConvenio.exclude_block.show();

            tramiteEnConvenio.include_block.hide();
            tramiteEnConvenio.include.find("option:selected").removeAttr("selected");
            tramiteEnConvenio.include.trigger("liszt:updated");
        } else {
            tramiteEnConvenio.include_block.show();

            tramiteEnConvenio.exclude_block.hide();
            tramiteEnConvenio.exclude.find("option:selected").removeAttr("selected");
            tramiteEnConvenio.exclude.trigger("liszt:updated");
        }
    }
};

function suggestPassword(passwd_form) {
    // restrict the password to just letters and numbers to avoid problems:
    // 'editors and viewers regard the password as multiple words and
    // things like double click no longer work"
    var pwchars = "abcdefhjmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWYXZ#!$%()=";
    var passwordlength = 8;    // do we want that to be dynamic?  no, keep it simple :)
    var passwd = passwd_form.generated_pw;
    passwd.value = '';

    for ( i = 0; i < passwordlength; i++ ) {
        passwd.value += pwchars.charAt( Math.floor( Math.random() * pwchars.length ) )
    }
    passwd_form.password.value = passwd.value;
    passwd_form.confirm_password.value = passwd.value;
    //passwd_form.text_pma_pw2.value = passwd.value;
    return true;
}


//Para generar el preview del codigo del proyecto
function codigoPreview(){ 
    var servicio=$("select[name=servicio_codigo]").val();
    
    $("input.codigo_preview").val(servicio);
}

function generarCodigo(){
    var servicio_dueno=$(".codigo_preview").val();
    $.get(site_url+"backend/fichas/ajax_generar_codigo/"+servicio_dueno,null,function(data){
        $("input[name=correlativo]").val(data);
    });

    return false;
}