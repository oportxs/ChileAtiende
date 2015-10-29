<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175" data-on-change-class="true">
        <img class="logo_breadcrumb" src="<?php echo site_url('assets_v2/img/logo_breadcrumb.png'); ?>" alt="Logo Chileatiende"/>
        <a href="<?= site_url('/') ?>">Portada</a> / <?php echo $ficha->titulo; ?>
        <button class="btn btn-realizar-tramite no-print" data-toggle="scroll-to" data-scroll-to="#realizar-tramite">
            Realiza este trámite aquí
        </button>
    </div>
</div>
<div id="content" class="ficha<?php echo $ficha->flujo?' ficha-flujo':''; ?><?php echo $ficha->Maestro->sello_chilesinpapeleo?' ficha-sello-chilesinpapeleo':''; ?>">
    <div id="readspeaker_container" class="readspeaker_container">
        <div id="readspeaker_button1" class="rs_skip rsbtn rs_preserve">
            <a class="rsbtn_play" accesskey="L" title="Escuchar esta pagina utilizando ReadSpeaker" href="http://app.na.readspeaker.com/cgi-bin/rsent?customerid=6404&amp;lang=es_419&amp;readid=maincontent-ficha&amp;url=<?php echo urlencode('http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]); ?>">
                <span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span>Escuchar</span></span></span><span class="rsbtn_right rsimg rsplay rspart"></span>
            </a>
        </div>
    </div>
    <div class="row-ficha-encabezado">
        <div class="row-fluid">
            <div class="span8">
                <div class="cont-titulo-ficha">
                    <h2><?php echo $ficha->titulo; ?></h2>
                    <div class="cont-sociales-ficha">
                        <a href="https://twitter.com/share" class="twitter-share-button" data-via="ChileAtiende" data-lang="es" data-url="<?php echo current_url(); ?>">Tweet</a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                        <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo current_url(); ?>&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=20" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:20px;" allowTransparency="true"></iframe>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <p class="informarcion-por">Información proporcionada por: <a href="<?php echo site_url('servicios/ver/'.$ficha->Servicio->codigo); ?>"><?php echo $ficha->Servicio->nombre.($ficha->Servicio->sigla?' ('.$ficha->Servicio->sigla.')':''); ?></a></p>
                <p><small>Última actualización: <?php echo strftime('%A %d de %B del %Y', mysql_to_unix($ficha->publicado_at)); ?></small></p>
                <?php if($ficha->sello_chilesinpapeleo): ?>
                    <p class="tamite-100-digital">Trámite 100% digital</p>
                <?php endif; ?>
            </div>
            <div class="span4">
                <button class="btn btn-realizar-tramite no-print" data-toggle="scroll-to" data-scroll-to="#realizar-tramite">
                    Realiza este trámite aquí
                </button>
            </div>
        </div>
    </div>
    <div id="maincontent" class="row-ficha-contenido">
        <div class="row-fluid">
            <div class="span3">
                <div class="contenedor-menu-ficha no-print hidden-phone">
                    <ul class="nav nav-list rs_skip  menu-ficha" data-spy="affix" data-offset-top="320">
                        <li>
                            <a href="#descripcion" data-toggle="scroll-to" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - descripcion" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Descripción</a>
                        </li>
                        <?php if (!empty($ficha->cc_observaciones)  && !($ficha->flujo) && !($ficha->maestro_id == '2272')): ?>
                            <li>
                                <a href="#detalles" data-toggle="scroll-to" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - detalles" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Detalles</a>
                            </li>
                        <?php endif ?>
                        <?php if (!empty($ficha->beneficiarios)  && !($ficha->flujo)): ?>
                            <li>
                                <a href="#beneficiarios" data-toggle="scroll-to" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - beneficiarios" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Beneficiarios</a>
                            </li>
                        <?php endif ?>
                        <?php if (!empty($ficha->vigencia)  && !($ficha->flujo)): ?>
                            <li>
                                <a href="#vigencia" data-toggle="scroll-to" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - vigencia" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Vigencia</a>
                            </li>
                        <?php endif ?>

                        <?php if (!empty($ficha->doc_requeridos)): ?>
                            <li>
                                <a href="#documentos-requeridos" data-toggle="scroll-to" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - documentos-requeridos" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Documentos requeridos</a>
                            </li>
                        <?php endif ?>
                        <?php if (!empty($ficha->costo)): ?>
                            <li>
                                <a href="#costo-tramite" data-toggle="scroll-to" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - costo-tramite" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Costo del trámite</a>
                            </li>
                        <?php endif ?>
                        <?php if (!empty($ficha->marco_legal)): ?>
                            <li>
                                <a href="#marco-legal" data-toggle="scroll-to" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - marco-legal" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Marco legal</a>
                            </li>
                        <?php endif ?>
                        <?php if (!empty($ficha->plazo)): ?>
                            <li>
                                <a href="#plazo" data-toggle="scroll-to" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - plazo" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Tiempo de realización</a>
                            </li>
                        <?php endif ?>
                        <?php if (!empty($ficha->informacion_multimedia) && !($ficha->maestro_id == '1000')): ?>
                            <li>
                                <a href="#multimedia" data-toggle="scroll-to" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - multimedia" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Infografía, audio y video</a>
                            </li>
                        <?php endif ?>
                        <?php if (!empty($ficha->guia_online) || !empty($ficha->guia_oficina) || !empty($ficha->guia_telefonico) || !empty($ficha->guia_correo)): ?>
                            <li>
                                <a href="#realizar-tramite" data-toggle="scroll-to" data-ga-te-category="Acciones Ficha" data-ga-te-action="Más detalles - realizar-tramite" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">Realizar trámite</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
            <div class="span9">
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
                <?php $numInfoFicha = 1; ?>
                <?php if (!$ficha->flujo || ($ficha->Servicio->codigo == 'ZY000')) { ?>
                    <div class="text-content contenedor-info-ficha">
                        <a id="descripcion" class="anchor-top">&nbsp;</a>
                        <?php if($ficha->Servicio->codigo != 'ZY000'): ?>
                            <h3 class="cabecera"><?php echo $numInfoFicha++; ?>. Descripción</h3>
                        <?php endif; ?>
                        <?php echo prepare_content_ficha($ficha->objetivo); ?>
                    </div>
                <?php } ?>
                <?php if (!empty($ficha->cc_observaciones)  && !($ficha->flujo) && !($ficha->maestro_id == '2272') && !($ficha->maestro_id == '24753')): ?>
                    <div class="text-content contenedor-info-ficha" data-seccion="detalles">
                        <a id="detalles" class="anchor-top">&nbsp;</a>
                        <?php if (!$ficha->flujo): ?>
                            <h3><?php echo $numInfoFicha++; ?>. Detalles</h3>
                        <?php endif ?>
                        <?php echo prepare_content_ficha($ficha->cc_observaciones); ?>
                        <div class="subir" data-toggle="scroll-to">Subir</div>
                        <div class="clearfix"></div>
                    </div>
                <?php endif ?>
                <?php if($ficha->beneficiarios): ?>
                    <div class="text-content contenedor-info-ficha">
                        <a id="beneficiarios" class="anchor-top">&nbsp;</a>
                        <h3><?php echo $numInfoFicha++; ?>. Beneficiarios</h3>
                        <?php echo prepare_content_ficha($ficha->beneficiarios); ?>
                        <div class="subir" data-toggle="scroll-to">Subir</div>
                        <div class="clearfix"></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($ficha->vigencia)  && !($ficha->flujo) ): ?>
                    <div class="text-content contenedor-info-ficha" data-seccion="vigencia">
                        <a id="vigencia" class="anchor-top">&nbsp;</a>
                        <?php if (!$ficha->flujo): ?>
                            <h3><?php echo $numInfoFicha++; ?>. Vigencia</h3>
                        <?php endif ?>
                        <div class="mensaje mensaje-reloj">
                            <?php echo prepare_content_ficha($ficha->vigencia); ?>
                        </div>
                        <div class="subir" data-toggle="scroll-to">Subir</div>
                        <div class="clearfix"></div>
                    </div>
                <?php endif ?>
                <?php if (!empty($ficha->doc_requeridos)): ?>
                    <div class="text-content contenedor-info-ficha" data-seccion="documentos-requeridos">
                        <a id="documentos-requeridos" class="anchor-top">&nbsp;</a>
                        <h3><?php echo $numInfoFicha++; ?>. Documentos requeridos</h3>
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
                        <div class="subir" data-toggle="scroll-to">Subir</div>
                        <div class="clearfix"></div>
                    </div>
                <?php endif ?>
                <?php if (!empty($ficha->costo)): ?>
                    <div class="text-content contenedor-info-ficha" data-seccion="costo-tramite">
                        <a id="costo-tramite" class="anchor-top">&nbsp;</a>
                        <h3><?php echo $numInfoFicha++; ?>. Costo del trámite</h3>
                        <div class="mensaje mensaje-costo">
                            <?php echo prepare_content_ficha($ficha->costo); ?>
                        </div>
                        <div class="subir" data-toggle="scroll-to">Subir</div>
                        <div class="clearfix"></div>
                    </div>
                <?php endif ?>
                <?php if (!empty($ficha->marco_legal)): ?>
                    <div class="text-content contenedor-info-ficha" data-seccion="marco-legal">
                        <a id="marco-legal" class="anchor-top">&nbsp;</a>
                        <h3><?php echo $numInfoFicha++; ?>. Marco legal</h3>
                        <?php echo prepare_content_ficha($ficha->marco_legal); ?>
                        <div class="subir" data-toggle="scroll-to">Subir</div>
                        <div class="clearfix"></div>
                    </div>
                <?php endif ?>
                <?php if (!empty($ficha->plazo)): ?>
                    <div class="text-content contenedor-info-ficha" data-seccion="plazo">
                        <a id="plazo" class="anchor-top">&nbsp;</a>
                        <h3><?php echo $numInfoFicha++; ?>. Tiempo de realización</h3>
                        <?php echo prepare_content_ficha($ficha->plazo); ?>
                        <div class="subir" data-toggle="scroll-to">Subir</div>
                        <div class="clearfix"></div>
                    </div>
                <?php endif ?>
                <?php if (!empty($ficha->informacion_multimedia) && !($ficha->maestro_id == '1000') && !($ficha->maestro_id == '24753')): ?>
                    <div class="text-content contenedor-info-ficha" data-seccion="multimedia">
                        <a id="multimedia" class="anchor-top">&nbsp;</a>
                        <h3><?php echo $numInfoFicha++; ?>. Infografía, audio y video</h3>
                        <?php echo prepare_content_ficha($ficha->informacion_multimedia); ?>
                        <div class="subir" data-toggle="scroll-to">Subir</div>
                        <div class="clearfix"></div>
                    </div>
                <?php endif ?>
                <?php if (!empty($ficha->guia_online) || !empty($ficha->guia_oficina) || !empty($ficha->guia_telefonico) || !empty($ficha->guia_correo)): ?>
                    <div class="canales-tramite contenedor-info-ficha">
                        <a id="realizar-tramite" class="anchor-top">&nbsp;</a>
                        <h3><?php echo $numInfoFicha++; ?>. Realizar trámite</h3>
                        <ul class="nav nav-tabs no-print rs_skip" id="tabs-canales-tramite">
                            <?php echo !empty($ficha->guia_online)?'<li class="online"><a href="#online" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Online" data-ga-te-value="'.$ficha->maestro_id.'">En línea</a></li>':''; ?>
                            <?php echo !empty($ficha->guia_oficina)?'<li class="oficina"><a href="#oficina" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Oficina" data-ga-te-value="'.$ficha->maestro_id.'">En oficina</a></li>':''; ?>
                            <?php echo !empty($ficha->guia_telefonico)?'<li class="telefonico"><a href="#telefonico" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Telefono" data-ga-te-value="'.$ficha->maestro_id.'">Por teléfono</a></li>':''; ?>
                            <?php echo !empty($ficha->guia_correo)?'<li class="correo"><a href="#correo" data-toggle="tab" data-ga-te-category="Acciones Ficha" data-ga-te-action="Tab Correo" data-ga-te-value="'.$ficha->maestro_id.'">Por correo</a></li>':''; ?>
                        </ul>
                        <div class="tab-content">
                            <?php echo !empty($ficha->guia_online)?'<h4 class="print">En Línea</h4><div class="tab-pane text-content contenedor-info-ficha" id="online">'.botonTramiteOnline($ficha).botonMejorarTramite($ficha, 'online').'<div class="clearfix"></div><h4 class="titulo_celeste">Paso a paso para realizar este trámite:</h4>'.prepare_content_ficha($ficha->guia_online).'<div class="clearfix"></div></div>':''; ?>
                            <?php echo !empty($ficha->guia_oficina)?'<h4 class="print">En Oficina</h4><div class="tab-pane text-content contenedor-info-ficha" id="oficina">'.botonMejorarTramite($ficha, 'oficina').'<div class="clearfix"></div><h4 class="titulo_celeste">Paso a paso para realizar este trámite:</h4>'.prepare_content_ficha($ficha->guia_oficina).'<div class="clearfix"></div></div>':''; ?>
                            <?php echo !empty($ficha->guia_telefonico)?'<h4 class="print">Por Teléfono</h4><div class="tab-pane text-content contenedor-info-ficha" id="telefonico">'.botonMejorarTramite($ficha, 'telefonico').'<div class="clearfix"></div><h4 class="titulo_celeste">Paso a paso para realizar este trámite:</h4>'.prepare_content_ficha($ficha->guia_telefonico).'<div class="clearfix"></div></div>':''; ?>
                            <?php echo !empty($ficha->guia_correo)?'<h4 class="print">Por correo</h4><div class="tab-pane text-content contenedor-info-ficha" id="correo">'.botonMejorarTramite($ficha, 'correo').'<div class="clearfix"></div><h4 class="titulo_celeste">Paso a paso para realizar este trámite:</h4>'.prepare_content_ficha($ficha->guia_correo).'<div class="clearfix"></div></div>':''; ?>
                        </div>
                        <div class="subir" data-toggle="scroll-to"><img src="<?php echo site_url('assets_v2/img/contenidos/flecha_subir.png') ?>" alt="flecha_subir" width="44" height="45"> Subir</div>
                        <div class="clearfix"></div>
                    </div>
                <?php endif ?>
                <div class="tramites-relacionados no-print">
                    <h3>Trámites relacionados</h3>
                    <?php foreach ($fichasRelacionadas as $key => $fichaRelacionada){ ?>
                        <div class="ficha-relacionada<?php echo $fichaRelacionada->flujo?' flujo':''; ?><?php echo ($fichaRelacionada->Maestro->sello_chilesinpapeleo?' sello_chilesinpapeleo':''); ?>">
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
                    <div class="clearfix"></div>
                </div>
                <?php echo $this->load->view('widget/participacion'); ?>
            </div>
        </div>
    </div>
</div>