<?php
$metaficha_campos = unserialize($ficha->metaficha_campos);
$metaficha_servicios = unserialize($ficha->metaficha_servicios);
$metaficha_servicios = $metaficha_servicios === false ? array() : $metaficha_servicios;
?>

<link rel="stylesheet" href="<?php echo base_url('assets_v2/css/exterior_ficha.css'); ?>">

<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175">
        <a href="<?= site_url('/exterior') ?>">Portada</a> / <?php echo $ficha->titulo; ?>
    </div>
</div>
<div id="content" class="ficha<?php echo $ficha->flujo?' ficha-flujo':''; ?><?php echo $ficha->Maestro->sello_chilesinpapeleo?' ficha-sello-chilesinpapeleo':''; ?><?php echo $ficha->metaficha ? ' ficha-metaficha':''; ?>">
    <div id="readspeaker_container" class="readspeaker_container">
        <div id="readspeaker_button1" class="rs_skip rsbtn rs_preserve">
            <a class="rsbtn_play" accesskey="L" title="Escuchar esta pagina utilizando ReadSpeaker" href="https://app.readspeaker.com/cgi-bin/rsent?customerid=6404&amp;lang=es_419&amp;readid=maincontent-ficha&amp;url=<?php echo urlencode('http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]); ?>">
                <span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span>Escuchar</span></span></span><span class="rsbtn_right rsimg rsplay rspart"></span>
            </a>
        </div>
    </div>
    
    <?php // TODO: eliminar o reemplazar (solo para gatillar initInfografias) ?>
    <div class="row-ficha-encabezado" style="display: none"></div>
    
    <div class="row-fluid row-ficha">
        <div class="span8 span-maincontent" id="maincontent-ficha">
            <div class="ficha-encabezado">
                <div class="row-fluid print rs_skip">
                    <div class="pull-left">
                        <img class="logo-print" src="<?php echo base_url('assets_v2/img/header/chileatiende-en-el-exterior_logo.png'); ?>" alt="ChileAtiende en el Exterior">
                    </div>
                    <div class="pull-right">
                        <h6>Última actualización</h6>
                        <p><?= strftime('%A %d de %B de %Y', mysql_to_unix($ficha->publicado_at)) ?></p>
                    </div>
                </div>
                <?php if ($ficha->Maestro->sello_chilesinpapeleo): ?>
                    <img src="<?php echo base_url('assets_v2/img/sello_chile-sin-papeleo_L.png'); ?>" class="sello-chilesinpapeleo rs_skip" data-toggle="tooltip" alt="Sello Chilesinpapeleo" title="Este sello es otorgado a los trámites del Estado que se realizan completamente por Internet y no requieren presencia física de las personas para su realización.">
                <?php endif ?>
                <h2 class="ficha-titulo"><?php echo $ficha->titulo; ?></h2>
                
                <?php if($ficha->metaficha == 0): ?>
                <div class="row-fluid">
                    <h5>Información proporcionada por: <a href="<?php echo site_url('servicios/ver/'.$ficha->Servicio->codigo); ?>"><?php echo $ficha->Servicio->nombre.($ficha->Servicio->sigla?' ('.$ficha->Servicio->sigla.')':''); ?></a></h5>
                    <h6>Última actualización: 
                        <?php $updatedDate = ($ficha->updated_data_at)? $ficha->updated_data_at : $ficha->publicado_at; ?>
                        <?php echo strftime('%A %d de %B del %Y', mysql_to_unix($updatedDate)); ?>
                    </h6>
                </div>
                <?php endif; ?>

                <div class="clearfix"></div>
                <?php if ($ficha->flujo): ?>
                    <img src="<?php echo base_url('assets_v2/img/label_aprende_sobre_big.png'); ?>" class="label_flujo no-print rs_skip" alt="Label Flujo">
                <?php endif ?>
            </div>
            <div id="maincontent"  class="row-ficha-contenido" role="main">
                <div class="opciones-accesibilidad no-print rs_skip">
                    <ul class="nav nav-pills">
                        <li class="ajusta-tamano-fuente">
                            <a href="#" class="tamano-fuente" data-dir="1">+A</a>
                        </li>
                        <li class="ajusta-tamano-fuente">
                            <a href="#" class="tamano-fuente" data-dir="-1">-A</a>
                        </li>
                        <li class="escuchar">
                            <a href="#">Escuchar</a>
                        </li>
                        <li class="imprimir hidden-phone">
                            <a href="javascript:print();">Imprimir</a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
                <?php echo getAlertasUrl(); ?>
                <?php if (!$ficha->flujo || ($ficha->Servicio->codigo == 'ZY000')) { ?>
                    <div class="text-content">
                        <a id="descripcion" class="anchor-top">&nbsp;</a>
                        <?php if($ficha->Servicio->codigo != 'NADA' /* TODO: 'ZY000' */ ) { ?><h3 class="cabecera">Descripción</h3><?php } ?>
                        <?php echo prepare_content_ficha($ficha->objetivo); ?>
                        
                        <?php 
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

                            // INFO: solo se muestra el enlace si almenos un campo debe ser mostrado
                            foreach($campos as $campo => $titulo):
                                if($metaficha_campos[$campo] == 1 && !empty($ficha[$campo])):
                        ?>
                        <a href="" class="ver-mas-detalles-metaficha" data-modal-type="div" data-modal-id="mas_informacion#inicio" data-toggle="modal-chileatiende"  data-ga-te-category="Acciones Ficha" data-ga-te-action="Ver Mas Detalles (modal)" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Ver más detalles</a>
                        <?php
                                    break;
                                endif;
                            endforeach;
                        ?>
                        <div id="mas_informacion" style="display: none">
                            <a href="" id="inicio" class="anchor"></a>
                            <h4>Más detalles</h4>
                            <div class="detalles-content">
                        <?php
                            $nro = 1;
                            foreach($campos as $campo => $titulo) {
                                if($metaficha_campos[$campo] == 1 && !empty($ficha[$campo]))
                                    echo '<div id="'.$campo.'" class="anchor"><h3>'.$nro++.'. '.$titulo.'</h3><p>'.prepare_content_ficha($ficha[$campo]).'</p></div>';  
                            }
                        ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php 
                // INFO: Seleccion de subficha para metafichas con agrupación geografica
                if($ficha->metaficha): ?>
                    <div class="metaficha-menu row-fluid" >
                    <?= $this->load->view('fichas/metaficha_menu');  ?>
                        <div id="ajax-content">
                <?php 
                endif;

                $_metaficha_show00 = $ficha->metaficha == 0 ;// || ($ficha->metaficha == 1 && $metaficha_campos['beneficiarios'] == 1) ? true : false;
                if ($_metaficha_show00 && !empty($ficha->beneficiarios) && ($ficha->flujo)): ?>
                    <div class="text-content <?php echo ($ficha->Servicio->codigo == 'ZY000') ? 'paso-paso-emprendete' : '' ?>">
                        <a id="beneficiarios" class="anchor-top">&nbsp;</a>
                        <?php if (!$ficha->flujo): ?>
                            <h3>Beneficiarios</h3>
                            <?php echo prepare_content_ficha($ficha->beneficiarios); ?>
                        <?php else: ?>
                            <?php 
                                $contenido_flujo = prepare_content_ficha($ficha->beneficiarios, false, true);
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
                                                    <div class="cont-paso-titulo<?php echo $key==0?' active':''; ?>" data-paso="<?php echo $key+1; ?>" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab pasos aprende sobre" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">
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
                $_metaficha_show00 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['guia_online'] == 1) ? true : false;
                $_metaficha_show01 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['guia_oficina'] == 1) ? true : false;
                $_metaficha_show02 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['guia_telefonico'] == 1) ? true : false;
                $_metaficha_show03 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['guia_correo'] == 1) ? true : false;
                $_metaficha_show04 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['guia_correo'] == 1) ? true : false;
                if (    ($_metaficha_show00 && !empty($ficha->guia_online)) || 
                        ($_metaficha_show03 && !empty($ficha->guia_correo)) ||
                        ($_metaficha_show01 && !empty($ficha->guia_oficina)) ||
                        ($_metaficha_show04 && !empty($ficha->guia_consulado))
                    ): ?>

                    <div class="canales-tramite">
                        <a id="como-realizar-el-tramite" class="anchor-top">&nbsp;</a>
                        <ul class="nav nav-tabs no-print rs_skip" id="tabs-canales-tramite">
                            <?php echo ($_metaficha_show00 && !empty($ficha->guia_online))?'<li class="online"><a href="#online" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Online" data-ga-te-value="'.$ficha->maestro_id.'">En línea</a></li>':''; ?>
                            <?php echo ($_metaficha_show03 && !empty($ficha->guia_correo))?'<li class="correo"><a href="#correo" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Correo" data-ga-te-value="'.$ficha->maestro_id.'">Por correo</a></li>':''; ?>
                            <?php echo ($_metaficha_show04 && !empty($ficha->guia_consulado))?'<li class="consulados"><a href="#consulado" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Correo" data-ga-te-value="'.$ficha->maestro_id.'">En Consulado</a></li>':''; ?>
                            <?php echo ($_metaficha_show04 && !empty($ficha->guia_oficina))?'<li class="oficina"><a href="#oficinachile" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Correo" data-ga-te-value="'.$ficha->maestro_id.'">En oficina en Chile</a></li>':''; ?>
                            
                        </ul>
                        <div class="tab-content">
                            <?php echo ($_metaficha_show00 && !empty($ficha->guia_online))?'<h4 class="print">En Línea</h4><div class="tab-pane text-content" id="online">'.prepare_content_ficha($ficha->guia_online).botonTramiteOnline($ficha).botonMejorarTramite($ficha, 'online').'<div class="clearfix"></div></div>':''; ?>
                            <?php echo ($_metaficha_show03 && !empty($ficha->guia_correo))?'<h4 class="print">Por correo</h4><div class="tab-pane text-content" id="correo">'.prepare_content_ficha($ficha->guia_correo).botonMejorarTramite($ficha, 'correo').'<div class="clearfix"></div></div>':''; ?>
                            <?php echo ($_metaficha_show04 && !empty($ficha->guia_consulado))?'<h4 class="print">En Consulado</h4><div class="tab-pane text-content" id="consulado">'.prepare_content_ficha($ficha->guia_consulado).botonMejorarTramite($ficha, 'consulado').'<div class="clearfix"></div></div>':''; ?>
                            <?php echo ($_metaficha_show04 && !empty($ficha->guia_oficina))?'<h4 class="print">En Oficina en Chile</h4><div class="tab-pane text-content" id="oficinachile">'.prepare_content_ficha($ficha->guia_oficina).botonMejorarTramite($ficha, 'oficinachile').'<div class="clearfix"></div></div>':''; ?>
                        </div>
                    </div>
                <?php endif ?>

                
                <?php 
                $_metaficha_show00 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['beneficiarios'] == 1) ? true : false;
                $_metaficha_show01 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['cc_observaciones'] == 1) ? true : false;
                $_metaficha_show02 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['vigencia'] == 1) ? true : false;
                $_metaficha_show03 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['doc_requeridos'] == 1) ? true : false;
                $_metaficha_show04 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['costo'] == 1) ? true : false;
                $_metaficha_show05 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['marco_legal'] == 1) ? true : false;
                $_metaficha_show06 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['plazo'] == 1) ? true : false;
                $_metaficha_show07 = $ficha->metaficha == 0;//  || ($ficha->metaficha == 1 && $metaficha_campos['informacion_multimedia'] == 1) ? true : false;
                if (
                        !($ficha->flujo) && (
                            ($_metaficha_show00 && !empty($ficha->beneficiarios)) || 
                            ($_metaficha_show01 && !empty($ficha->cc_observaciones)) || 
                            ($_metaficha_show02 && !empty($ficha->vigencia)) || 
                            ($_metaficha_show03 && !empty($ficha->doc_requeridos)) || 
                            ($_metaficha_show04 && !empty($ficha->costo)) || 
                            ($_metaficha_show05 && !empty($ficha->marco_legal)) || 
                            ($_metaficha_show06 && !empty($ficha->plazo)) || 
                            ($_metaficha_show07 && !empty($ficha->informacion_multimedia))
                        )
                    ): ?>
                    <div class="indice-secciones no-print">
                        <h4 id="mas-detalles">Más detalles</h4>
                        <ol class="rs_skip">
                            <?php if (($_metaficha_show01 && !empty($ficha->cc_observaciones)) && !($ficha->flujo)): ?>
                                <li>
                                    <a href="#detalles" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - detalles" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Detalles</a>
                                </li>
                            <?php endif ?>
                            <?php if (($_metaficha_show00 && !empty($ficha->beneficiarios)) && !($ficha->flujo)): ?>
                                <li>
                                    <a href="#beneficiarios" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - beneficiarios" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Beneficiarios</a>
                                </li>
                            <?php endif ?>
                            <?php if (($_metaficha_show02 && !empty($ficha->vigencia)) && !($ficha->flujo)): ?>
                                <li>
                                    <a href="#vigencia" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - vigencia" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Vigencia</a>
                                </li>
                            <?php endif ?>

                            <?php if (($_metaficha_show03 && !empty($ficha->doc_requeridos))): ?>
                                <li>
                                    <a href="#documentos-requeridos" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - documentos-requeridos" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Documentos requeridos</a>
                                </li>
                            <?php endif ?>
                            <?php if (($_metaficha_show04 && !empty($ficha->costo))): ?>
                                <li>
                                    <a href="#costo-tramite" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - costo-tramite" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Costo del trámite</a>
                                </li>
                            <?php endif ?>
                            <?php if (($_metaficha_show05 && !empty($ficha->marco_legal))): ?>
                                <li>
                                    <a href="#marco-legal" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - marco-legal" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Marco legal</a>
                                </li>
                            <?php endif ?>
                            <?php if (($_metaficha_show06 && !empty($ficha->plazo))): ?>
                                <li>
                                    <a href="#plazo" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - plazo" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Tiempo de realización</a>
                                </li>
                            <?php endif ?>
                            <?php if (($_metaficha_show07 && !empty($ficha->informacion_multimedia))): ?>
                                <li>
                                    <a href="#multimedia" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - multimedia" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Infografía, audio y video</a>
                                </li>
                            <?php endif ?>
                        </ol>
                        <div class="cont-ver-todo rs_skip">
                            <a href="#ver-todo" class="ver-todo" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - ver-todo" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Ver todo</a>
                        </div>
                    </div>
                    <?php $count = 1; ?>
                    <?php if (($_metaficha_show01 && !empty($ficha->cc_observaciones))  && !($ficha->flujo) ): ?>
                        <div class="text-content texto-seccion print <?php echo ($ficha->Servicio->codigo == 'ZY000' && ($ficha->flujo)) ? 'paso-paso-emprendete' : '' ?>" data-seccion="detalles">
                            <a id="detalles" class="anchor-top">&nbsp;</a>
                            <?php if (!$ficha->flujo): ?>
                                <h3><?php echo $count++; ?>. Detalles</h3>
                            <?php endif ?>
                            <?php echo prepare_content_ficha($ficha->cc_observaciones); ?>
                        </div>
                    <?php endif ?>
                    <?php if (($_metaficha_show00 && !empty($ficha->beneficiarios))  && !($ficha->flujo) ): ?>
                        <div class="text-content texto-seccion print <?php echo ($ficha->Servicio->codigo == 'ZY000' && ($ficha->flujo)) ? 'paso-paso-emprendete' : '' ?>" data-seccion="beneficiarios">
                            <a id="beneficiarios" class="anchor-top">&nbsp;</a>
                            <?php if (!$ficha->flujo): ?>
                                <h3><?php echo $count++; ?>. Beneficiarios</h3>
                            <?php endif ?>
                            <?php echo prepare_content_ficha($ficha->beneficiarios); ?>
                        </div>
                    <?php endif ?>
                    <?php if (($_metaficha_show02 && !empty($ficha->vigencia)) && !($ficha->flujo) ): ?>
                        <div class="text-content texto-seccion print <?php echo ($ficha->Servicio->codigo == 'ZY000' && ($ficha->flujo)) ? 'paso-paso-emprendete' : '' ?>" data-seccion="vigencia">
                            <a id="vigencia" class="anchor-top">&nbsp;</a>
                            <?php if (!$ficha->flujo): ?>
                                <h3><?php echo $count++; ?>. Vigencia</h3>
                            <?php endif ?>
                            <div class="mensaje mensaje-reloj">
                                <?php echo prepare_content_ficha($ficha->vigencia); ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if (($_metaficha_show03 && !empty($ficha->doc_requeridos))): ?>
                        <div class="text-content texto-seccion print" data-seccion="documentos-requeridos">
                            <a id="documentos-requeridos" class="anchor-top">&nbsp;</a>
                            <h3><?php echo $count++; ?>. Documentos requeridos</h3>
                            <?php $doc_requeridos = prepare_content_ficha($ficha->doc_requeridos, false, true); ?>
                            <?php if ($doc_requeridos['doc_requeridos']): ?>
                                <table class="table-striped documentos-requeridos">
                                    <?php foreach ($doc_requeridos['doc_requeridos'] as $doc_requerido): ?>
                                        <?php echo $doc_requerido; ?>
                                    <?php endforeach ?>
                                </table>
                            <?php else: ?>
                                <?php echo $doc_requeridos['texto']; ?>
                            <?php endif ?>
                        </div>
                    <?php endif ?>
                    <?php if (($_metaficha_show04 && !empty($ficha->costo))): ?>
                        <div class="text-content texto-seccion print" data-seccion="costo-tramite">
                            <a id="costo-tramite" class="anchor-top">&nbsp;</a>
                            <h3><?php echo $count++; ?>. Costo del trámite</h3>
                            <div class="mensaje mensaje-costo">
                                <?php echo prepare_content_ficha($ficha->costo); ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if (($_metaficha_show05 && !empty($ficha->marco_legal))): ?>
                        <div class="text-content texto-seccion print" data-seccion="marco-legal">
                            <a id="marco-legal" class="anchor-top">&nbsp;</a>
                            <h3><?php echo $count++; ?>. Marco legal</h3>
                            <?php echo prepare_content_ficha($ficha->marco_legal); ?>
                        </div>
                    <?php endif ?>
                    <?php if (($_metaficha_show06 && !empty($ficha->plazo))): ?>
                        <div class="text-content texto-seccion print" data-seccion="plazo">
                            <a id="plazo" class="anchor-top">&nbsp;</a>
                            <h3><?php echo $count++; ?>. Tiempo de realización</h3>
                            <?php echo prepare_content_ficha($ficha->plazo); ?>
                        </div>
                    <?php endif ?>
                    <?php if (($_metaficha_show07 && !empty($ficha->informacion_multimedia))): ?>
                        <div class="text-content texto-seccion print" data-seccion="multimedia">
                            <a id="multimedia" class="anchor-top">&nbsp;</a>
                            <h3><?php echo $count++; ?>. Infografía, audio y video</h3>
                            <?php echo prepare_content_ficha($ficha->informacion_multimedia); ?>
                        </div>
                    <?php endif ?>
                <?php endif ?>

                <?php 
                if ( ($ficha->flujo) && ($_metaficha_show05 && !empty($ficha->marco_legal)) ): ?>
                    <div class="indice-secciones rs_skip">
                        <h4 id="mas-detalles">Más detalles</h4>
                        <ol>
                            <?php if (($_metaficha_show05 && !empty($ficha->marco_legal))): ?>
                                <li>
                                    <a href="#marco-legal">Marco legal</a>
                                </li>
                            <?php endif ?>
                        </ol>
                        <div class="cont-ver-todo">
                            <a href="#ver-todo" class="ver-todo">Ver todo</a>
                        </div>
                    </div>
                    <?php if (($_metaficha_show05 && !empty($ficha->marco_legal))): ?>
                        <div class="text-content texto-seccion print" data-seccion="marco-legal">
                            <a id="marco-legal" class="anchor-top">&nbsp;</a>
                            <h3>Marco legal</h3>
                            <?php echo prepare_content_ficha($ficha->marco_legal); ?>
                        </div>
                    <?php endif ?>
                <?php endif ?>
                
                <?php 
                if($ficha->metaficha)
                    echo '</div><!-- <div id="ajax-content"> --></div><!-- metaficha-menu -->';
                ?>

                <div class="print rs_skip">
                    <hr>
                    <img class="qr" src="https://chart.googleapis.com/chart?chs=220x220&amp;cht=qr&amp;chid=<?= md5(uniqid(rand(), true)) ?>&amp;chl=Tr&aacute;mite:%20<?= $ficha->titulo ?>%0D%0A%0D%0AURL:%20<?= site_url('fichas/ver/' . $ficha->maestro_id . '/') ?>" alt="<?= $ficha->titulo ?>" />
                    <p><?php echo current_url(); ?></p>
                </div>
                <?php echo $this->load->view('widget/participacion'); ?>
            </div>
        </div>
        <div class="span4 span-side-bar no-print hidden-phone">
            <div class="side-bar" data-offset-top="174" data-offset-bottom="276">
                
                <div class="cont-sociales">
                    <div class="row-fluid">
                        <?php if(!$this->config->item("lite_mode")){?>
                            <div class="span6 valoracion-ficha <?php if(isset($_GET['exterior']) && $_GET['exterior'] == "1") print "hide";?>" data-id-ficha="<?php echo $ficha->maestro_id; ?>" data-modificador="0">
                                <p>¿Te gusta?:</p>
                                <div class="voto voto-positivo" data-voto="positivo">
                                    <a href="#" data-ga-te-category="Acciones Ficha" data-ga-te-action="Voto positivo" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">+</a>
                                    <span class="total-votos"></span>
                                </div>
                                <div class="voto voto-negativo" data-voto="negativo">
                                    <a href="#" data-ga-te-category="Acciones Ficha" data-ga-te-action="Voto negativo" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">-</a>
                                    <span class="total-votos"></span>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="span6 visible-desktop">
                            <p>Compartir:</p>
                            <ul class="lista-redes-sociales">
                                <li class="compartir_twitter">
                                    <a target="_blank" href="http://twitter.com/intent/tweet?text=<?php echo urlencode($ficha->titulo); ?>&url=<?php echo current_url(); ?>&via=chileatiende"  data-ga-te-category="Acciones Ficha" data-ga-te-action="Compartir Twitter" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Twitter</a>
                                </li>
                                <li class="compartir_facebook">
                                    <a  target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()); ?>&t=<?php echo urlencode($ficha->titulo); ?>"  data-ga-te-category="Acciones Ficha" data-ga-te-action="Compartir Facebook" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Facebook</a>
                                </li>
                                <li class="compartir_correo">
                                    <a href="<?php echo site_url('contacto/enviaramigo'); ?>" data-toggle="modal-chileatiende"  data-ga-te-category="Acciones Ficha" data-ga-te-action="Compartir Correo" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Correo</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


                <?php
                // INFO: se muestra lista de eventos destacados solo para portal pymes
                if(($ficha->Servicio->codigo == 'ZY000' || ($ficha->tipo==2) ) && count($eventos)) :
                ?>
                    <div class="emprendete-calendario listado-fichas">
                        <h4 class="accordion-heading toggle active">Calendario:</h4>
                        <ul class="accordion-body" style="display:block;">
                            <?php 
                                $dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
                                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

                                foreach($eventos as $evento):
                                    
                                    if($evento->permanente == 1)
                                        $strPeriodo = "Evento permanente";
                                    else
                                    {
                                        $same_year = date('Y', strtotime($evento->postulacion_start)) == date('Y', strtotime($evento->postulacion_end));
                                        $strPeriodo = 'Del '.$dias[date('w', strtotime($evento->postulacion_start))].
                                            " ".date('d', strtotime($evento->postulacion_start)).
                                            " de ".$meses[date('n', strtotime($evento->postulacion_start))-1].
                                            (!$same_year ? ' del '.date('Y', strtotime($evento->postulacion_start)) : '').
                                            ' al '.$dias[date('w', strtotime($evento->postulacion_end))].
                                            " ".date('d', strtotime($evento->postulacion_end)).
                                            " de ".$meses[date('n', strtotime($evento->postulacion_end))-1].
                                            (!$same_year ? ' del '.date('Y', strtotime($evento->postulacion_end)) : '');
                                    }
                                    $aRegiones = array();
                                    foreach($evento->Regiones as $region)
                                        $aRegiones[] = $region->nombre;
                                    $strRegiones = (count($aRegiones) == 15) ? 'Todas las Regiones' : join(', ', $aRegiones);
                            ?>
                                <div class="ficha-sidebar">
                                    <div class="ficha-top">
                                        <h5>
                                            <?php 
                                                $e_link = preg_replace('/\[\[(\d+)\]\]/', site_url('fichas/ver/$1'), $evento->url);
                                            ?>
                                            <a href="<?php echo $e_link; ?>"><?php echo $evento->titulo; ?></a>
                                        </h5>
                                        <small><?= $strPeriodo ?><br /></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <?php if ($fichasRelacionadas): ?>
                    <div class="temas-sugerido listado-fichas">
                        <h4 class="accordion-heading toggle active">Relacionados:</h4>
                        <ul class="accordion-body" style="display:block;">
                            <?php foreach ($fichasRelacionadas as $key => $fichaRelacionada){ ?>
                                <div class="ficha-sidebar ficha-relacionada<?php echo $fichaRelacionada->flujo?' flujo':''; ?><?php echo ($fichaRelacionada->Maestro->sello_chilesinpapeleo?' sello_chilesinpapeleo':''); ?>">
                                    <?php if ($fichaRelacionada->flujo): ?>
                                        <img src="<?php echo base_url('assets_v2/img/label_aprende_sobre.png'); ?>" class="label_flujo" alt="Contenido aprende sobre">
                                    <?php endif ?>
                                    <?php if ($fichaRelacionada->Maestro->sello_chilesinpapeleo): ?>
                                        <img src="<?php echo base_url('assets_v2/img/label_sello_chileatiende.png'); ?>" class="label_chilesinpapeleo" alt="Trámite 100% digital de Chile sin papeleo">
                                    <?php endif ?>
                                    <div class="ficha-top">
                                        <h5>
                                            <a href="<?php echo site_url('fichas/ver/'.$fichaRelacionada->maestro_id); ?>" data-ga-te-category="Acciones Ficha" data-ga-te-action="Fichas relacionadas" data-ga-te-value="<?php echo $fichaRelacionada->maestro_id; ?>"><?php echo $fichaRelacionada->titulo; ?></a>
                                        </h5>
                                        <span><?php echo $fichaRelacionada->Servicio->nombre; ?></span>
                                    </div>
                                    <div class="tipotramite">
                                        <?= ($fichaRelacionada->guia_online ? '<span class="tipo_tramite_online" title="En Línea">En línea</span>' : '') ?>
                                        <?= ($fichaRelacionada->guia_oficina ? '<span class="tipo_tramite_oficina" title="En oficina">En oficina</span>' : '') ?>
                                        <?= ($fichaRelacionada->guia_telefonico ? '<span class="tipo_tramite_telefonico" title="Por teléfono">Por teléfono</span>' : '') ?>
                                        <?= ($fichaRelacionada->guia_correo ? '<span class="tipo_tramite_correo" title="Por correo">Por correo</span>' : '') ?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </ul>
                    </div>
                <?php endif ?>
                <div class="temas-destacados listado-fichas">
                    <h4 class="accordion-heading active">Destacados ChileAtiende:</h4>
                    <ul class="accordion-body" style="display:block;">
                        <?php foreach ($fichasDestacadas as $key => $fichaDestacada){ ?>
                            <div class="ficha-sidebar ficha-destacada<?php echo $fichaDestacada->flujo?' flujo':''; ?><?php echo ($fichaDestacada->Maestro->sello_chilesinpapeleo?' sello_chilesinpapeleo':''); ?>">
                                <?php if ($fichaDestacada->flujo): ?>
                                    <img src="<?php echo base_url('assets_v2/img/label_aprende_sobre.png'); ?>" class="label_flujo" alt="Contenido aprende sobre">
                                <?php endif ?>
                                <?php if ($fichaDestacada->Maestro->sello_chilesinpapeleo): ?>
                                    <img src="<?php echo base_url('assets_v2/img/label_sello_chileatiende.png'); ?>" class="label_chilesinpapeleo" alt="Trámite 100% digital de Chile sin papeleo">
                                <?php endif ?>
                                <div class="ficha-top">
                                    <h5>
                                        <a href="<?php echo site_url('fichas/ver/'.$fichaDestacada->maestro_id); ?>" data-ga-te-category="Acciones Ficha" data-ga-te-action="Fichas destacadas" data-ga-te-value="<?php echo $fichaDestacada->maestro_id; ?>"><?php echo $fichaDestacada->titulo; ?></a>
                                    </h5>
                                    <span><?php echo $fichaDestacada->Servicio->nombre; ?></span>
                                </div>
                                <div class="tipotramite">
                                    <?= ($fichaDestacada->guia_online ? '<span class="tipo_tramite_online" title="En Línea">En línea</span>' : '') ?>
                                    <?= ($fichaDestacada->guia_oficina ? '<span class="tipo_tramite_oficina" title="En oficina">En oficina</span>' : '') ?>
                                    <?= ($fichaDestacada->guia_telefonico ? '<span class="tipo_tramite_telefonico" title="Por teléfono">Por teléfono</span>' : '') ?>
                                    <?= ($fichaDestacada->guia_correo ? '<span class="tipo_tramite_correo" title="Por correo">Por correo</span>' : '') ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            <?php if(!$this->config->item("lite_mode")){?>
                $.post(site_url+"fichas/ajax_inserta_visita/"+<?= $ficha->Maestro->id ?>);
            <?php } ?>
            
            <?php
            if ($ficha->Servicio->codigo == 'ZY000' && $ficha->flujo) {
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
</div>

<?php if($ficha->guia_online) : ?>
<script src="/assets_v2/js/survey.js" type="text/javascript"></script>
<?php endif; ?>
