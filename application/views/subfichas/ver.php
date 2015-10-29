<?php
$metaficha = $subficha->MetaFicha;
$metaficha_campos = unserialize($metaficha->metaficha_campos);
$metaficha_servicios = unserialize($metaficha->metaficha_servicios);
$metaficha_servicios = $metaficha_servicios === false ? array() : $metaficha_servicios;
$campos = array(
    'cc_observaciones' => "Detalles",
    'beneficiarios' => "Beneficiarios",
    'vigencia' => "Vigencia",
    'doc_requeridos' => "Documentos Requeridos",
    'costo' => "Costo",
    'marco_legal' => "Marco Legal",
    'plazo' => "Plazo",
    'informacion_multimedia' => "Información Multimedia"
);
?>      

<?php
$_metaficha_obj00 = $metaficha_campos['beneficiarios'] == 1 ? $metaficha : $subficha;
if (!empty($_metaficha_obj00->beneficiarios) && ($metaficha->flujo)): ?>
    <div class="text-content <?php echo ($metaficha->Servicio->codigo == 'ZY000') ? 'paso-paso-emprendete' : '' ?>">
        <a id="beneficiarios" class="anchor-top">&nbsp;</a>
        <?php if (!$metaficha->flujo): ?>
            <h3>Beneficiarios</h3>
            <?php echo prepare_content_ficha($_metaficha_obj00->beneficiarios); ?>
        <?php else: ?>
            <?php 
                $contenido_flujo = prepare_content_ficha($_metaficha_obj00->beneficiarios, false, true);
                echo $contenido_flujo['texto'];
            ?>
            <?php if (isset($contenido_flujo['videos']) && $contenido_flujo['videos']): ?>
                <?php foreach ($contenido_flujo['videos'] as $video): ?>
                    <div class="cont-video-flujo"><?php echo $video; ?></div>
                <?php endforeach ?>
            <?php endif ?>
            <?php if (isset($contenido_flujo['pasos']) && $contenido_flujo['pasos']): ?>
                <div class="contenedor-pasos-flujo">
                    <div class="row-fluid">
                        <div class="span4 rs_skip">
                            <div class="pasos-indice">
                                <?php foreach ($contenido_flujo['pasos'] as $key => $paso): ?>
                                    <div class="cont-paso-titulo<?php echo $key==0?' active':''; ?>" data-paso="<?php echo $key+1; ?>" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab pasos aprende sobre" data-ga-te-value="<?php echo $metaficha->maestro_id; ?>">
                                        <?php echo $paso; ?>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="span8">
                            <div class="pasos-contenidos">
                                <?php foreach ($contenido_flujo['contenidos'] as $key => $contenido_paso): ?>
                                    <div class="cont-paso-contenido<?php echo $key==0?' active':''; ?>" data-paso="<?php echo $key+1; ?>">
                                        <?php echo $contenido_flujo['pasos'][$key]; ?>
                                        <?php echo $contenido_paso; ?>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>
<?php endif ?>

<?php 
$_metaficha_obj00 = $metaficha_campos['guia_online'] == 1 ? $metaficha : $subficha;
$_metaficha_obj01 = $metaficha_campos['guia_oficina'] == 1 ? $metaficha : $subficha;
$_metaficha_obj02 = $metaficha_campos['guia_telefonico'] == 1 ? $metaficha : $subficha;
$_metaficha_obj03 = $metaficha_campos['guia_correo'] == 1 ? $metaficha : $subficha;
if (    !empty($_metaficha_obj00->guia_online) || 
        !empty($_metaficha_obj01->guia_oficina) || 
        !empty($_metaficha_obj02->guia_telefonico) || 
        !empty($_metaficha_obj03->guia_correo)
    ): ?>
    <div class="canales-tramite">
        <a id="como-realizar-el-tramite" class="anchor-top">&nbsp;</a>
        <ul class="nav nav-tabs no-print rs_skip" id="tabs-canales-tramite">
            <?php echo !empty($_metaficha_obj00->guia_online)?'<li class="online"><a href="#online" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Online" data-ga-te-value="'.$metaficha->maestro_id.'">En línea</a></li>':''; ?>
            <?php echo !empty($_metaficha_obj01->guia_oficina)?'<li class="oficina"><a href="#oficina" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Oficina" data-ga-te-value="'.$metaficha->maestro_id.'">En oficina</a></li>':''; ?>
            <?php echo !empty($_metaficha_obj02->guia_telefonico)?'<li class="telefonico"><a href="#telefonico" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Telefono" data-ga-te-value="'.$metaficha->maestro_id.'">Por teléfono</a></li>':''; ?>
            <?php echo !empty($_metaficha_obj03->guia_correo)?'<li class="correo"><a href="#correo" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Correo" data-ga-te-value="'.$metaficha->maestro_id.'">Por correo</a></li>':''; ?>
        </ul>
        <div class="tab-content">
            <?php if (!empty($_metaficha_obj02->vigencia) && !($metaficha->flujo)): ?>
                
            <?php endif ?>
            <?php
                // INFO: pre-procesamiento prepre_content para enlace a lightbox principal
                foreach($campos as $campo => $titulo)
                    if($metaficha_campos[$campo] == 1) {
                        $pattern = '/\{\{campo\['.$campo.'\]:([^\}\}]+)\}\}/';
                        $replacement = '{{campo[mas_informacion#'.$campo.']:$1}}';

                        $_metaficha_obj00->guia_online = preg_replace($pattern, $replacement, $_metaficha_obj00->guia_online);
                        $_metaficha_obj01->guia_oficina = preg_replace($pattern, $replacement, $_metaficha_obj01->guia_oficina);
                        $_metaficha_obj02->guia_telefonico = preg_replace($pattern, $replacement, $_metaficha_obj02->guia_telefonico);
                        $_metaficha_obj03->guia_correo = preg_replace($pattern, $replacement, $_metaficha_obj03->guia_correo);
                    }

                // INFO: se muestra la informacion de costo y vigencia sobre el paso a paso en cada canal
                $_metaficha_obj04 = $metaficha_campos['costo'] == 1 ? $metaficha : $subficha;
                $_metaficha_obj02 = $metaficha_campos['vigencia'] == 1 ? $metaficha : $subficha;
                $txt_costo = !empty($_metaficha_obj04->costo) ? '
                <div class="text-content mensaje mensaje-costo" data-seccion="costo-tramite">
                    <a id="costo-tramite" class="anchor-top">&nbsp;</a>
                    '.prepare_content_ficha($_metaficha_obj04->costo).'
                </div>' : '';
                $txt_vigencia = (!empty($_metaficha_obj02->vigencia) && !$metaficha->flujo) ? ('
                <div class="text-content mensaje mensaje-calendario '.( ($metaficha->Servicio->codigo == 'ZY000' && $metaficha->flujo) ? 'paso-paso-emprendete' : '').'" data-seccion="vigencia">
                    <a id="vigencia" class="anchor-top">&nbsp;</a>
                    '.prepare_content_ficha($_metaficha_obj02->vigencia).'
                </div>') : '';
            ?>
            <?php echo !empty($_metaficha_obj00->guia_online)?'<h4 class="print">En Línea</h4><div class="tab-pane text-content" id="online">'.$txt_costo.$txt_vigencia.prepare_content_ficha($_metaficha_obj00->guia_online).botonTramiteOnline($subficha).botonMejorarTramite($subficha, 'online').'<div class="clearfix"></div></div>':''; ?>
            <?php echo !empty($_metaficha_obj01->guia_oficina)?'<h4 class="print">En Oficina</h4><div class="tab-pane text-content" id="oficina">'.$txt_costo.$txt_vigencia.prepare_content_ficha($_metaficha_obj01->guia_oficina).botonMejorarTramite($subficha, 'oficina').'<div class="clearfix"></div></div>':''; ?>
            <?php echo !empty($_metaficha_obj02->guia_telefonico)?'<h4 class="print">Por Teléfono</h4><div class="tab-pane text-content" id="telefonico">'.$txt_costo.$txt_vigencia.prepare_content_ficha($_metaficha_obj02->guia_telefonico).botonMejorarTramite($subficha, 'telefonico').'<div class="clearfix"></div></div>':''; ?>
            <?php echo !empty($_metaficha_obj03->guia_correo)?'<h4 class="print">Por correo</h4><div class="tab-pane text-content" id="correo">'.$txt_costo.$txt_vigencia.prepare_content_ficha($_metaficha_obj03->guia_correo).botonMejorarTramite($subficha, 'correo').'<div class="clearfix"></div></div>':''; ?>
        </div>
    </div>
<?php endif ?>

<div class="subficha-encabezado">
    <h5>Información proporcionada por: <a href="<?php echo site_url('servicios/ver/'.$subficha->Servicio->codigo); ?>"><?php echo $subficha->Servicio->nombre.($subficha->Servicio->sigla?' ('.$subficha->Servicio->sigla.')':''); ?></a></h5>
    <h6>(Actualizado el <?php echo strftime('%A %d de %B del %Y', mysql_to_unix($subficha->publicado_at)); ?>)</h6>
</div>

<?php
// INFO: Se prepara contenido para los LightBox de cada campo
foreach($campos as $campo => $titulo) {
    if($metaficha_campos[$campo] != 1 && !empty($subficha[$campo]))
        echo '<div id="campo-'.$campo.'" style="display: none;"><h3>'.$titulo.'</h3><p>'.prepare_content_ficha($subficha[$campo]).'</p></div>';    
}
?>
