<ul id="sti-menu" class="sti-menu">
    <li style="display:none"></li>
    <li id="portada_etapas">
        <h2 class="sti-item"><img src="assets/images/bullet_rojo.png" width="9" height="12" alt="" />Guías para tu etapa</h2>
        <h3 class="sti-item"></h3>

        <span class="letrachica">
            <?php
            $cnt = 0;
            $cnt_x = 1;
            $nro_etapas = count($etapas);
            //echo $nro_etapas;
            foreach ($etapas as $e): 
                $idEtapa = $e['id'];
                $tituloEtapa = $e['nombre'];//substr($e['nombre'],0,10);
                foreach($e['HechosEmpresa'] as $ev) :
                    $idHecho = $ev['id'];
                    $tituloHecho = $ev['nombre'];//substr($ev['nombre'],0,10);
                    echo '<a href="'.site_url('/buscar/fichas/?hechoempresa='.$idHecho.'&flujo=1').'">'.$tituloHecho.'</a>'. (($cnt_x<$nro_etapas) ? ', ' : '') ;
                endforeach;
                $cnt_x++;
            endforeach;
            ?>
        </span>
        <span class="sti-icon sti-icon-info sti-item"></span>
    </li>
    <li id="portada_temas">
        <h2 class="sti-item"><img src="assets/images/bullet_rojo.png" width="9" height="12" alt="" />
            Trámites
        </h2>
        <h3 class="sti-item">
            
        </h3>

        <span class="letrachica">
            <?php foreach ($temas as $t): ?>
            <?php
            $salto = '';
            if(strlen($t->nombre)>15)
                $salto = '<br />';
            ?>
            <a href="<?=  site_url('/buscar/fichas/?temasempresa='.$t->id)?>"><?=$t->nombre?></a><?=$salto?>
            <?php endforeach; ?>
        </span>
        <span class="sti-icon sti-icon-family sti-item"></span>
    </li>
    <li id="portada_busqueda">
        <h2 class="sti-item"><img src="assets/images/bullet_rojo.png" width="9" height="12" alt="" />Apoyo Estatal</h2>
        <h3 class="sti-item"></h3>

        <span class="letrachica">
            <?php foreach ($apoyosestado as $ae): ?>
            <a href="<?=  site_url('/buscar/fichas/?apoyos='.$ae->id)?>"><?=$ae->nombre?></a>
            <?php endforeach; ?>
        </span>
        <span class="sti-icon sti-icon-technology sti-item"></span>
    </li>
</ul>
<script type="text/javascript">
    $(document).ready(function() {
        /*
        $("#portada_etapas").click(function(){
            _gaq.push(['_trackEvent', 'Acciones', 'Etapas', 'Slider']);
            window.location.href = site_url+"portada/etapas";
        });
        $("#portada_temas").click(function(){
            _gaq.push(['_trackEvent', 'Acciones', 'Temas', 'Slider']);
            window.location.href = site_url+"portada/temas";
        });
        $("#portada_busqueda").click(function(){
            _gaq.push(['_trackEvent', 'Acciones', 'Búsqueda', 'Slider']);
            $("#buscador").expose({
                onBeforeLoad: function(event) {
                    $("#exposeMask").css('opacity','1!important');
                    //$("#exposeMask").css('background-image','url(assets/prueba/img/overlay_txt_buscador.png)');
                    $("#exposeMask").css('background-repeat','no-repeat');
                    $("#exposeMask").css('background-position','top center');
                },
                onClose: function(event) {
                    $("#exposeMask").css('opacity','.8!important');
                    $("#exposeMask").css('background-color','rgba(0,0,0,.9) !important');
                    $("#exposeMask").css('background-image','none');
                    $("#exposeMask").css('background-repeat','no-repeat');
                    $("#exposeMask").css('background-position','top center');
                }
            });
        });
        */
    });
</script>