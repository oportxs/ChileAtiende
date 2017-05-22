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


var showTab = function(motivo, el) {
       $('.nav-principal .span2').removeClass('selected');
       $(el).parent().addClass('selected');
        $('.nav-secundaria').hide();
        var selector =  '.nav-secundaria.' + motivo
        $(selector).show()
        $('.nav-secundaria').masonry({
            itemSelector: '.masonry-item'
        })
    }

$(document).ready(function() {
    $('.nav-secundaria').masonry({
            itemSelector: '.masonry-item'
        })
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
    
    window.onresize = function(event) {
        $('.nav-secundaria').masonry({
            itemSelector: '.masonry-item'
        })
    };

    setTimeout(function(){
        $('#tab-default').trigger('click');
    }, 1*500)

});
