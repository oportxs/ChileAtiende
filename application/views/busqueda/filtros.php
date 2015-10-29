<div id="sidebar" class="left clearfix">

    <script type="text/javascript">
        $(document).ready(function(){
            
            var temas = (<?= ($hidden_filter_temas) ? 1 : 0; ?> || <?= (count($temas) < 15) ? 1 : 0 ?>);
            var temasempresa = (<?= ($hidden_filter_temasempresa) ? 1 : 0; ?> || <?= (count($temasempresa) < 15) ? 1 : 0 ?>);
            var servicios = (<?= ($hidden_filter_servicios) ? 1 : 0; ?> || <?= (count($instituciones) < 15) ? 1 : 0 ?>);
            var apoyos = (<?= ($hidden_filter_apoyos) ? 1 : 0; ?> || <?= (count($apoyos) < 15) ? 1 : 0 ?>);
            
            if(temas) toggle("#f_temas","#temas_filtro");
            if(temasempresa) toggle("#f_temasempresa","#temasempresa_filtro");
            if(servicios) toggle("#f_instituciones","#instituciones_filtro");
            if(apoyos) toggle("#f_apoyos","#apoyos_filtro");

            toggle("#f_flujo","#flujo_filtro");
            toggle("#f_tramite","#tramite_filtro");
            
            $("#f_temas").click(function(){toggle(this,"#temas_filtro");});
            $("#f_temasempresa").click(function(){toggle(this,"#temasempresa_filtro");});
            $("#f_instituciones").click(function(){toggle(this,"#instituciones_filtro");});
            $("#f_flujo").click(function(){toggle(this,"#flujo_filtro");});
            $("#f_tramite").click(function(){toggle(this,"#tramite_filtro");});
            $("#f_apoyos").click(function(){toggle(this,"#apoyos_filtro");});

            //Captura el evento click de los filtros
            var filtros = $('a[data-filtro]');
            filtros.on('click', function(e){
                var elem = $(this),
                filtro = elem.data('filtro'),
                valor = elem.data('value')+'', // Se debe asegurar que el tipo de dato sea un string
                multi = elem.data('multi'),
                active = elem.hasClass('on'),
                //Se obtiene el hidden asociado al filtro
                hidden_input = $('input[name="'+filtro+'"]');

                if(multi){

                    var filter_values = hidden_input.val().length ? hidden_input.val().split(',') : [];

                    if(active){
                        filter_values.splice(filter_values.indexOf(valor), 1);
                    }else{
                        filter_values.push(valor);
                    }

                    if(!filter_values.length)
                        hidden_input.attr('disabled', 'disabled');
                    else
                        hidden_input.removeAttr('disabled');

                    hidden_input.val(filter_values.join(','));

                }else{

                    if(active){
                        hidden_input.val('').attr('disabled', 'disabled');
                    }else{
                        hidden_input.val(valor).removeAttr('disabled');
                    }

                }
            	
                $('#formFiltrosBusqueda').submit();

                e.preventDefault();
            });
            
        });
        
        function toggle(thiselement,element){
            $(element).toggleClass('blink','fast').toggle("fast").toggleClass('blink','slow');
            $(thiselement).toggleClass('on');
            
            $("#sidebar").attr('style', 'height:auto;');
        }
        
    </script>

    <h2>Filtrar resultados por <img src="assets/images/bullet_busqueda.png" alt="ico" /></h2>
    <p class="instruccion">Obtenga resultados más específicos, seleccione temas relacionados o si conoce la institución que lo realiza. </p>
    <form id="formFiltrosBusqueda" method="get" action="<?php echo base_url('buscar/fichas'); ?>">
        <input type="hidden" name="buscar" value="<?= (isset($hidden_string)) ? $hidden_string : ""; ?>" />

        <input type="hidden" name="hecho" value="<?= (isset($hidden_hecho)) ? $hidden_hecho : ""; ?>" <?php echo!isset($hidden_hecho) ? 'disabled="disabled"' : ''; ?>/>
        <input type="hidden" name="genero" value="<?= (isset($genero)) ? $genero : ""; ?>" <?php echo!isset($genero) ? 'disabled="disabled"' : ''; ?>/>
        <input type="hidden" name="edad" value="<?= (isset($edad)) ? $edad : ""; ?>" <?php echo!isset($edad) ? 'disabled="disabled"' : ''; ?>/>
        <input type="hidden" name="temas" value="<?php echo ($hidden_filter_temas) ? implode(",", $hidden_filter_temas) : ""; ?>" <?php echo!$hidden_filter_temas ? 'disabled="disabled"' : ''; ?>>
        <input type="hidden" name="temasempresa" value="<?php echo ($hidden_filter_temasempresa) ? implode(",", $hidden_filter_temasempresa) : ""; ?>" <?php echo!$hidden_filter_temasempresa ? 'disabled="disabled"' : ''; ?>>
        <input type="hidden" name="instituciones" value="<?php echo ($hidden_filter_servicios) ? implode(",", $hidden_filter_servicios) : ""; ?>" <?php echo!$hidden_filter_servicios ? 'disabled="disabled"' : ''; ?>>
        <input type="hidden" name="flujo" value="<?php echo ($hidden_filter_flujo) ? $hidden_filter_flujo : ''; ?>" <?php echo!isset($hidden_filter_flujo) ? 'disabled="disabled"' : ''; ?>>
        <input type="hidden" name="tramites" value="<?php echo ($hidden_filter_tramites) ? implode(",", $hidden_filter_tramites) : ''; ?>" <?php echo!isset($hidden_filter_tramites) ? 'disabled="disabled"' : ''; ?>>
        <input type="hidden" name="apoyos" value="<?php echo ($hidden_filter_apoyos) ? implode(",", $hidden_filter_apoyos) : ""; ?>" <?php echo!$hidden_filter_apoyos ? 'disabled="disabled"' : ''; ?>>

        <?php if (isset($tramites) && count($tramites) > 0) { ?>
            <p id="f_tramite" class="toggle filter_title lightblue-text">Tipo de trámite</p>
            <ul id="tramite_filtro" class="text-small toggable">
                <?php
                if (!isset($hidden_filter_tramites))
                    $hidden_filter_tramites = '';
                foreach ($tramites as $codigo_tramite => $tramite) {
                    ?>
                    <li class="<?php echo in_array($codigo_tramite, $hidden_filter_tramites) ? 'on' : ''; ?>">
                        <a class="<?php echo in_array($codigo_tramite, $hidden_filter_tramites) ? 'on' : ''; ?>" href="#" data-multi="true" data-filtro="tramites" data-value="<?php echo $codigo_tramite; ?>"><?php echo $tramite['nombre']; ?></a>
                        <span>(<?php echo $tramite['numero_fichas']; ?>)</span>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>

        <p id="f_flujo" class="toggle filter_title lightblue-text">Tipo de información</p>
        <ul id="flujo_filtro" class="text-small toggable">
            <?php foreach ($flujos as $codig_flujo => $flujo) { ?>
                <li class="<?php echo (isset($hidden_filter_flujo) && $hidden_filter_flujo == $codig_flujo) ? 'on' : ''; ?>">
                    <a class="<?php echo (isset($hidden_filter_flujo) && $hidden_filter_flujo == $codig_flujo) ? 'on' : ''; ?>" href="#" data-filtro="flujo" data-value="<?php echo $codig_flujo; ?>"><?php echo $flujo['nombre']; ?></a>
                    <span>(<?php echo $flujo['numero_fichas']; ?>)</span>
                </li>
            <? } ?>
        </ul>

        <?php if (isset($temas) && count($temas) > 0) { ?>
        <p id="f_temas" class="toggle filter_title lightblue-text"><!--<img src="assets/images/bullet_new_big.png" alt="Temas" />-->Temas</p>
        <ul id="temas_filtro" class="text-small toggable">
            <?php foreach ($temas as $tema) { ?>
                <?php $class = in_array($tema->id, $hidden_filter_temas) ? 'on' : ''; ?>
                <li class="<?php echo $class; ?>">
                    <a class="<?php echo $class; ?>" href="#" data-multi="true" data-filtro="temas" data-value="<?php echo $tema->id; ?>"><?php echo $tema->nombre; ?></a>
                    <span>(<?php echo $tema->numero_fichas; ?>)</span>
                </li>
            <?php } ?>
        </ul>
        <?php } ?>
        
        <?php if (isset($temasempresa) && count($temasempresa) > 0) { ?>
        <p id="f_temasempresa" class="toggle filter_title lightblue-text">Temas empresa</p>
        <ul id="temasempresa_filtro" class="text-small toggable">
            <?php foreach ($temasempresa as $tema) { ?>
                <?php $class = in_array($tema->id, $hidden_filter_temasempresa) ? 'on' : ''; ?>
                <li class="<?php echo $class; ?>">
                    <a class="<?php echo $class; ?>" href="#" data-multi="true" data-filtro="temasempresa" data-value="<?php echo $tema->id; ?>"><?php echo $tema->nombre; ?></a>
                    <span>(<?php echo $tema->numero_fichas; ?>)</span>
                </li>
            <?php } ?>
        </ul>
        <?php } ?>
        
        <?php if (isset($apoyos) && count($apoyos) > 0) { ?>
        <p id="f_apoyos" class="toggle filter_title lightblue-text">Apoyos estado</p>
        <ul id="apoyos_filtro" class="text-small toggable">
            <?php foreach ($apoyos as $apoyo) { ?>
                <?php $class = in_array($apoyo->id, $hidden_filter_apoyos) ? 'on' : ''; ?>
                <li class="<?php echo $class; ?>">
                    <a class="<?php echo $class; ?>" href="#" data-multi="true" data-filtro="apoyos" data-value="<?php echo $apoyo->id; ?>"><?php echo $apoyo->nombre; ?></a>
                    <span>(<?php echo $apoyo->numero_fichas; ?>)</span>
                </li>
            <?php } ?>
        </ul>
        <?php } ?>

        <?php if (isset($instituciones) && count($instituciones) > 0) { ?>
            <p id="f_instituciones" class="toggle filter_title lightblue-text">Institución</p>
            <ul id='instituciones_filtro' class='text-small toggable'>
                <?php foreach ($instituciones as $institucion) { ?>
                    <?php $class = in_array($institucion->codigo, $hidden_filter_servicios) ? 'on' : ''; ?>
                    <li class="<?php echo $class; ?>">
                        <a class="<?php echo $class; ?>" href="#" data-filtro="instituciones" data-value="<?php echo $institucion->codigo; ?>"><?php echo $institucion->nombre . ( ($institucion->sigla) ? ' (' . $institucion->sigla . ')' : '' ); ?></a>
                        <span>(<?php echo $institucion->numero_fichas; ?>)</span>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>

        <!--<input type="submit" class="bt_buscar2" name="filtrar_busqueda" value="Filtrar Búsqueda">-->
    </form>
</div>