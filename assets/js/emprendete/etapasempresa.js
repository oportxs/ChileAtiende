$(document).ready(function() {
    //llamadas para que funcione el widget etapas
    loadApoyos(3);
    loadHechosEmpresa(3);
    $("#my-list li:nth-child(2)").addClass('on');
        
    /* Acciono los botones de filtro */
    $('#my-list li label').click(function(event){
        $(this).closest("li").siblings().removeClass("on");
        $(this).closest("li").addClass("on");
        $(this).find('input').attr('checked','checked');
        loadHechosEmpresa( $("#my-list li label input:radio:checked").val() );
        loadApoyos( $("#my-list li label input:radio:checked").val() );
    });

});

function loadHechosEmpresa(etapaId){
    $.getJSON(site_url+'hechosempresa/ajax_get_hechos', "etapa_id="+etapaId, function(response){
            
        response=response.HechosEmpresa;
        var html="";
        for(var i in response){
            if( response[i].nombre != undefined ) {
                html+="<li>";
                html+="<label for='hecho-"+response[i].id+"'>";
                html+="<a href='buscar/fichas/?etapaempresa="+etapaId+"&hechoempresa="+response[i].id+"&e=1&button=Buscar'>";
                html+=response[i].nombre;
                html+="</a></label>";
                html+="</li>";
            }
        }
        $("#etapas .paso2").find("ul.hechos").html(html)
    });
}

function loadApoyos(apoyoId){
    $.getJSON(site_url+'apoyos/ajax_get_apoyos', "etapa_id="+apoyoId, function(response){
        
        response=response.ApoyosEstado;
        var html="";
        for(var i in response){
            if( response[i].nombre != undefined ) {
                html+="<li>";
                html+="<label for='hecho-"+response[i].id+"'>";
                html+="<a href='buscar/fichas/?etapa="+apoyoId+"&apoyos="+response[i].id+"&e=1&button=Buscar'>";
                html+=response[i].nombre;
                html+="</a></label>";
                html+="</li>";
            } 
        }
        
        $("#etapas .paso2").find("ul.apoyos").html(html)
    });
}