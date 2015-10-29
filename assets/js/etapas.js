$(document).ready(function() {
    //llamadas para que funcione el widget etapas
    loadHechos(4);
    $("#my-list li:nth-child(4)").addClass('on');
        
    /* Acciono los botones de filtro */
    $('#my-list li label').click(function(event){
        $(this).closest("li").siblings().removeClass("on");
        $(this).closest("li").addClass("on");
        $(this).find('input').attr('checked','checked');
        loadHechos( $("#my-list li label input:radio:checked").val() );
    });

});

function loadHechos(etapaId){
    $.getJSON(site_url+'hechos/ajax_get_hechos', "etapa_id="+etapaId, function(response){
            
        response=response.HechosVida;
        var html="";
        for(var i in response){
            if( response[i].nombre != undefined ) {
                html+="<li>";
                html+="<label for='hecho-"+response[i].id+"'>";
                html+="<a href='buscar/fichas/?etapa="+etapaId+"&hecho="+response[i].id+"&button=Buscar'>";
                html+=response[i].nombre;
                html+="</a></label>";
                html+="</li>";
            }
        }
        $("#etapas .paso2").find("ul").html(html)
    });
}
