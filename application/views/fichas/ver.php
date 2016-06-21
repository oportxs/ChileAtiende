<?php
$url_chilesinpapeleo = 'http://www.chilesinpapeleo.cl/';
?>
<script type="text/javascript">
    $(document).ready(function(){
        $.post(site_url+"fichas/ajax_inserta_visita/"+<?= $ficha->Maestro->id ?>);
        
<?php
if ($ficha->Servicio->codigo == 'ZZ002' && $ficha->flujo) {
    ?>          
                $('a.t_paso_a_paso').click(function(e){
                    var parent = $(this).parents('li'),
                    strongText = parent.find('strong').text(); //strongText tiene el texto del <strong>
                    $.cookie('nombrePaso',strongText);
                    $.cookie('idFicha', <?= $ficha->Maestro->id ?>);
                });     
    <?php
}
?>
        if($.cookie('idFicha')) {
            if($.cookie('nombrePaso'))
                $('#migapasopaso').html('<a href="/fichas/ver/'+$.cookie('idFicha')+'">Paso a Paso</a> / <a href="/fichas/ver/'+$.cookie('idFicha')+'">'+$.cookie('nombrePaso')+'</a> /');
            $.removeCookie('nombrePaso');
        }
    });
</script>

<div id="content" class="clearfix">
    <div id="readspeaker_container">
        <div id="readspeaker_button1" class="rs_skip">
            <a class="btn_start_readspeaker" accesskey="L" href="http://app.na.readspeaker.com/cgi-bin/rsent?customerid=6404&amp;lang=es_419&amp;readid=maincontent&amp;url=<?php echo urlencode('http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); ?>" target="_blank" onclick="readpage(this.href, 'xp1'); return false;">
                <img style="border-style: none" src="<?php echo site_url('assets/images/leer.png'); ?>" alt="Escucha esta p&aacute;gina utilizando ReadSpeaker" title="Escucha esta p&aacute;gina utilizando ReadSpeaker" />
                Escuchar
            </a>
        </div>
        <div id='xp1'></div>
    </div>
    <div id="maincontent" class="left clearfix<?php echo $ficha->Maestro->sello_chilesinpapeleo ? ' ficha-chilesinpapeleo' : ''; ?>">
        <!-- RSPEAK_STOP -->
        <div class="breadcrumbs">
            <?php if (isset($perfil) && $perfil == 'empresas'): ?>
                <a href="<?= site_url('/') ?>">Portada</a> / <a href="<?= site_url('/empresas/') ?>">Empresas y Organizaciones</a> /
                <?php
                if ($subtema) {
                    list($st_id, $st_nombre) = explode("#", $subtema);
                    echo anchor(site_url('/empresas/subtemas/' . $st_id), $st_nombre) . " /";
                }
                ?>
                <?= $ficha->titulo ?>
            <?php else: ?>
                <a href="<?= site_url('/') ?>">Portada</a> / <span id="migapasopaso"></span> <?= $ficha->titulo ?>
            <?php endif; ?>
        </div>
        <div class="wrap_header_ficha clearfix">
            <!-- RSPEAK_START -->
            <h2 class="title">
                <?= $ficha->titulo ?>
            </h2>
            <p class="responsible">Información proporcionada por: <strong> <a href="<?= site_url('servicios/ver/' . $ficha->Servicio->codigo) ?>"><?= $ficha->Servicio->nombre . ( ($ficha->Servicio->sigla) ? ' (' . $ficha->Servicio->sigla . ')' : '' ) ?></a></strong></p>
            <?php if ($ficha->publicado_at): ?><p class="meta">Última actualización: <?= strftime('%d/%m/%Y', mysql_to_unix($ficha->publicado_at)) ?></p><?php endif; ?>
            <!-- RSPEAK_STOP -->
            <dl id="options">
                <?php
                if (!empty($ficha->guia_online) || !empty($ficha->guia_oficina) || !empty($ficha->guia_telefonico) || !empty($ficha->guia_correo)) {
                    ?>
                    <dd><a href="<?= current_url() ?>#howto" class="red-text">Cómo realizar este trámite</a></dd>
                    <?php
                }
                ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        loadRating(".ratingFicha", <?= $ficha->Maestro->id ?>);
                    });
                </script>
                <dd class="ratingFicha"></dd>
                <?php if ($ficha->Maestro->sello_chilesinpapeleo): ?>
                    <img class="sello-chilesinpapeleo-large has-tooltip-chilesinpapeleo" title="Este sello es otorgado a los trámites del Estado que se realizan completamente por Internet y no requieren presencia física de las personas para su realización." src="<?php echo base_url('assets/images/sello_chile-sin-papeleo_L.png'); ?>" alt="">
                <?php endif ?>
            </dl>
            <?php
            $this->load->view("fichas/access_share_menu.php");
            ?>
        </div>
        <div class="shadow">&nbsp;</div>
        <!-- RSPEAK_START -->
        <div class="txt">
            <?php
            if (!$ficha->flujo || ($ficha->Servicio->codigo == 'ZZ002')) {
                ?>
                <h3 class="first_topic"><span class="title-bullet"></span>Descripción</h3>
                <div <?= ($ficha->Servicio->codigo == 'ZZ002') ? '' : 'class="descripcion_ficha"' ?>>
                    <?= prepare_content_ficha($ficha->objetivo) ?>
                </div>
                <?php
            }
            if (!empty($ficha->beneficiarios)) {
                if (!$ficha->flujo) {
                    ?>
                    <hr />
                    <h3><span class="title-bullet"></span>Beneficiarios</h3>
                    <?php
                }
                echo ($ficha->Servicio->codigo == 'ZZ002') ? '<div class="descripcion_ficha">' : '';
                echo prepare_content_ficha($ficha->beneficiarios);
                echo ($ficha->Servicio->codigo == 'ZZ002') ? '</div>' : '';
                ?>
                <?php
            }

            if (!empty($ficha->doc_requeridos)) {
                ?>
                <hr />
                <h3><span class="title-bullet"></span>Documentos requeridos</h3>
                <?= prepare_content_ficha($ficha->doc_requeridos) ?>
                <?php
            }
            ?>
        </div>
        <?php
        if (!empty($ficha->guia_online) || !empty($ficha->guia_oficina) || !empty($ficha->guia_telefonico) || !empty($ficha->guia_correo)) {
            ?>

            <hr /><a name="howto"></a>
            <h3><span class="title-bullet"></span>Paso a paso: Cómo realizar el trámite</h3>
            <div id="howto_tramite">

                <!-- the tabs -->
                <ul class="nav">
                    <?php
                    echo!empty($ficha->guia_online) ? '<li><a href="#online">En Línea</a></li>' : '';
                    echo!empty($ficha->guia_oficina) ? '<li><a href="#oficina">En Oficina</a></li>' : '';
                    echo!empty($ficha->guia_telefonico) ? '<li><a href="#telefono">Por Teléfono</a></li>' : '';
                    echo!empty($ficha->guia_correo) ? '<li><a href="#correo">Por Correo</a></li>' : '';
                    ?>
                </ul>

                <!-- tab "panes" -->
                <div class="panes">
                    <?php
                    $mejorar_tramite_online = '<div class="cont_btn_denuncia"><a class="mejorar_tramite tooltip_denuncia">¿Podemos mejorar este trámite?</a></div><div class="clear"></div>';
                    if (empty($ficha->guia_online)) { //Se debe mostrar el boton de "quiero tramite online" solo si este no existe
                        $solicita_tramite_online = '<div class="cont_btn_denuncia"><a class="quiero_online tooltip_denuncia">Quisierass este trámite disponible en línea</a></div><div class="clear"></div>';
                    } else {
                        $solicita_tramite_online = $mejorar_tramite_online;
                    }
                    $tramite_online = ($ficha->guia_online_url) ? '<div class="t_online"><a href="' . $ficha->guia_online_url . '" target="_blank" alt="Realizar en línea" id="selecciona">Ir al Trámite</a></div>' : '';
                    echo!empty($ficha->guia_online) ? '<div id="online" class="pane-tramite" data-tramite="online">' . prepare_content_ficha($ficha->guia_online) . $tramite_online . $mejorar_tramite_online . '</div>' : '';
                    echo!empty($ficha->guia_oficina) ? '<div id="oficina" class="pane-tramite" data-tramite="oficina">' . prepare_content_ficha($ficha->guia_oficina) . $solicita_tramite_online . '</div>' : '';
                    echo!empty($ficha->guia_telefonico) ? '<div id="telefono" class="pane-tramite" data-tramite="telefono">' . prepare_content_ficha($ficha->guia_telefonico) . $solicita_tramite_online . '</div>' : '';
                    echo!empty($ficha->guia_correo) ? '<div id="correo" class="pane-tramite" data-tramite="correo">' . prepare_content_ficha($ficha->guia_correo) . $solicita_tramite_online . '</div>' : '';
                    ?>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $(".t_online a").click(function(){
                            _gaq.push(['_trackEvent', 'Fichas', 'Botón Trámite Online', '<?= $ficha->Maestro->id ?>']);
                        });
                    });
                </script>
            </div>
            <?php
        }
        ?>
        <!-- RSPEAK_STOP -->
        <div class="pasos_print">
            <?php
            $tramite_online = ($ficha->guia_online_url) ? '<div class="t_online"><a href="' . $ficha->guia_online_url . '" target="_blank" alt="Realizar en línea" title="Realizar en línea">Ir al Trámite</a></div>' : '';
            echo!empty($ficha->guia_online) ? '<div id="online"><h3 class="print">En Línea</h3>' . $ficha->guia_online . $tramite_online . '</div>' : '';
            echo!empty($ficha->guia_oficina) ? '<div id="oficina"><h3 class="print">En Oficina</h3>' . $ficha->guia_oficina . '</div>' : '';
            echo!empty($ficha->guia_telefonico) ? '<div id="telefono"><h3 class="print">Por Teléfono</h3>' . $ficha->guia_telefonico . '</div>' : '';
            echo!empty($ficha->guia_correo) ? '<div id="correo"><h3 class="print">Por Correo</h3>' . $ficha->guia_correo . '</div>' : '';
            ?>
        </div>
        <hr class="hidden" />
        <!-- RSPEAK_START -->
        <ul id="resumen_tramite" class="clearfix">
            <?php echo!empty($ficha->plazo) ? '<li class="first"><h4>Tiempo de realización</h4>' . prepare_content_ficha($ficha->plazo) . '</li>' : '' ?>
            <?php echo!empty($ficha->vigencia) ? '<li class="first"><h4>' . ( ($ficha->Servicio->codigo == 'ZZ002') ? 'Recuerda' : 'Vigencia del trámite' ) . '</h4>' . prepare_content_ficha($ficha->vigencia) . '</li>' : '' ?>
            <?php echo!empty($ficha->costo) ? '<li class="first"><h4>Costo del trámite</h4>' . prepare_content_ficha($ficha->costo) . '</li>' : '' ?>
            <?php echo!empty($ficha->cc_observaciones) ? '<li class="first"><h4>Información relacionada</h4>' . prepare_content_ficha($ficha->cc_observaciones) . '</li>' : '' ?>
            <?php echo!empty($ficha->marco_legal) ? '<li class="marco_legal second"><h4>Marco legal</h4>' . prepare_content_ficha($ficha->marco_legal) . '</li>' : '' ?>
        </ul>
        <?php
        echo ($ficha->fps) ? '<h3><span class="title-bullet"></span>Máximo Puntaje Ficha Protección Social</h3> <p>Mínimo: '.$ficha->puntaje_fps_min.', Máximo: '.$ficha->puntaje_fps_max.'</p>' : '';
        echo ($ficha->formalizacion) ? '<h3><span class="title-bullet"></span>Nivel de Formalización</h3> <p>'.( ($ficha->formalizacion == 1) ? 'Informal' : 'Formal' ) .'</p>' : '';
        echo ($ficha->venta_anual) ? '<h3><span class="title-bullet"></span>Tamaño Empresa</h3> <p>'.( ($ficha->venta_anual==1) ? 'Micro': ( ($ficha->venta_anual==2) ? 'Pequeño' : ( ($ficha->venta_anual==3) ? 'Mediano' : ( ($ficha->venta_anual==4) ? 'Grande' : '' ) ) ) ).'</p>' : '';
        
        echo ($ficha->req_adicional) ? '<h3>Requisito adicional</h3><p>'.$ficha->req_adicional.'</p>' : '';
        echo ($ficha->req_especial) ? '<h3>Requisito especial</h3><p>'.( ($ficha->req_especial == 1) ? 'Mujer' : 'Indígena' ).'</p>' : '';
        ?>
        <!-- RSPEAK_STOP -->
        <br />
        <div class="ratingFicha"></div>

        <?php
        //$this->load->view("fichas/access_share_menu.php");
        ?>
    </div>
    <?php $this->load->view('widgets/relatedbar.php'); ?>



</div><!-- Content -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#maincontent').waitForImages(function(){
            if ($("div#maincontent").height() > $("div#sidebar").height()) {
                $("div#sidebar").height($("div#maincontent").height())
            }else{
                $("div#maincontent").height($("div#sidebar").height())
            }
        });
    });
</script>
<div class="tooltip" id="elTooltip">
    <table border="0" cellspacing="0" cellpadding="0">

        <tr>
            <td colspan="<?php echo $ficha->tipo == 3 ? 2 : 1; ?>">¿Qué eres?</td>
        </tr>
        <tr>
            <?php if ($ficha->tipo == 1 || $ficha->tipo == 3) { ?>
                <td class="borde">
                    <a target="_blank" href="<?php echo $url_chilesinpapeleo . 'digitalizacion/formulario?origen=' . $ficha->getCodigo() . '&tipo=p'; ?>"><img alt="Persona" src="assets/images/tooltip_persona.png" /><br /><br />Persona</a>
                </td>
            <?php } ?>
            <?php if ($ficha->tipo == 2 || $ficha->tipo == 3) { ?>
                <td>
                    <a target="_blank" href="<?php echo $url_chilesinpapeleo . 'digitalizacion/formulario?origen=' . $ficha->getCodigo() . '&tipo=e'; ?>"><img alt="Empresas" src="assets/images/tooltip_empresas.png" /><br /><br />Empresa u Organización</a>
                </td>
            <?php } ?>
        </tr>
    </table>
</div>
<script>
    $(document).ready(function() {
<?php if ($ficha->tipo == 3) { ?>
            $('#elTooltip a').each(function(i, elem){
                $(elem).data('href', $(elem).attr('href'));
            });
            $(".tooltip_denuncia").tooltip({ 
                effect: 'slide', 
                tip:'#elTooltip',
                onBeforeShow:function(event,position){
                    var a = $(event.target),
                    tramite = a.parents('.pane-tramite').data('tramite'),
                    tooltip = $('#elTooltip');
                    tooltip.find('a').each(function(i, elment){
                        var href = $(elment).data('href');
                        $(elment).attr('href', href+'&tipo_tramite='+tramite);
                    });
                }
            });
<?php } else { ?>
            $('.tooltip_denuncia').each(function(i, anchor){
                var a = $(anchor),
                tramite = a.parents('.pane-tramite').data('tramite');
                a.attr({
                    'href':'<?php echo $url_chilesinpapeleo . 'digitalizacion/formulario?origen=' . $ficha->getCodigo() . '&tipo=' . ($ficha->tipo == 1 ? "p" : "e"); ?>&tipo_tramite='+tramite,
                    'target':'_blank'
                });
            });
<?php } ?>
    });
</script>
