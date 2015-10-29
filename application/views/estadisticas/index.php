<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175">
        <a href="<?= site_url('/') ?>">Portada</a> / <?php echo $title; ?>
    </div>
</div>
<div id="content" class="contenido contenido-estadisticas">
    <div class="row-fluid">
        <div class="encabezado-contenido">
            <div class="span12">
                <h2><?php echo $title; ?></h2>
            </div>
            <?php /* ?>
            <div class="cont-sociales-ficha">
                <a href="https://twitter.com/share" class="twitter-share-button" data-via="ChileAtiende" data-lang="es" data-url="<?php echo current_url(); ?>">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo current_url(); ?>&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=20" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:20px;" allowTransparency="true"></iframe>
            </div>
            <?php */ ?>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="estadisticas-chileatiende">
        <div class="seccion-grafico info-numero-atenciones">
            <div class="row-fluid">
                <div class="span12">
                    <h1>Número de Atenciones</h1>
                    <h2>Por Canal</h2>
                    <hr/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2 span2-lista-canales">
                    <ul class="lista-canales unstyled">
                        <li>
                            <img src="<?php echo site_url('assets_v2/estadisticas/images/icon_oficina.png'); ?>" alt="Icono atención oficinas"/>
                            <p>
                                Canal<br>presencial
                            </p>
                        </li>
                        <li>
                            <img src="<?php echo site_url('assets_v2/estadisticas/images/icon_telefonico.png'); ?>" alt="Icono atención telefónico"/>
                            <p>
                                Canal<br>telefónico
                            </p>
                        </li>
                        <li>
                            <img src="<?php echo site_url('assets_v2/estadisticas/images/icon_online.png'); ?>" alt="Icono atención online"/>
                            <p>
                                Canal<br>digital
                            </p>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="span10 span10-cont-nun-atenciones">
                    <div id="cont-nun-atenciones">
                        <div class="row-fluid">
                            <!-- Se llena vía Javascript -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <h6 class="pull-right"><a target="_blank" href="<?php echo site_url('estadisticas/descarga/num-atenciones'); ?>"><i class="icon-download"></i>Descargar Datos</a></h6>
                </div>
            </div>
        </div>
        <div class="seccion-grafico info-evolucion-visitas">
            <div class="row-fluid no-relative">
                <div class="span4">
                    <h1>Evolución visitas sitio</h1>
                    <h2>Chileatiende.cl</h2>
                </div>
                <div class="span8">
                    <div class="row-fluid no-relative">
                        <div class="cont-slider">
                            <div class="span12">
                                <input id="slider-evolucion-visitas" type="hidden" class="span2" value="" data-toggle="slider" data-slider-selection="after" data-slider-tooltip="hide">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span12">
                    <hr/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 no-relative">
                    <svg id="line-evolucion-visitas" style="height:300px"></svg>
                </div>
                <div class="span12">
                    <h6 class="pull-right"><a target="_blank" href="<?php echo site_url('estadisticas/descarga/visitas-sitio'); ?>"><i class="icon-download"></i>Descargar Datos</a></h6>
                </div>
            </div>
        </div>
        <div class="seccion-grafico info-evolucion-tiempo-espera">
            <div class="row-fluid">
                <div class="span4">
                    <h1>Evolución tiempo de espera nacional</h1>
                    <h2>Presencial</h2>
                </div>
                <div class="span8">
                    <div class="row-fluid no-relative">
                        <div class="cont-slider">
                            <div class="span12">
                                <input id="slider-evolucion-tiempo-espera" type="hidden" class="span2" value="" data-toggle="slider" data-slider-selection="after" data-slider-tooltip="hide">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span12">
                    <hr/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 no-relative">
                    <svg id="line-evolucion-tiempo-espera" style="height:300px"></svg>
                </div>
                <div class="span12">
                    <h6 class="pull-right"><a target="_blank" href="<?php echo site_url('estadisticas/descarga/tiempo-espera'); ?>"><i class="icon-download"></i>Descargar Datos</a></h6>
                </div>
            </div>
        </div>
        <div class="seccion-grafico info-atencion-por-region">
            <div class="row-fluid">
                <div class="span9">
                    <h1>Atenciones por región</h1>
                    <h2>Canal presencial</h2>
                </div>
                <div class="span3">
                    <div class="row-fluid">
                        <div class="span5">
                            <br/>
                            <select class="form-control" name="periodos-atenciones-region" id="periodos-atenciones-region">
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                        <div class="span6 offset1">
                            <br/>
                            <select class="form-control" name="mes-atenciones-region" id="mes-atenciones-region">
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span12">
                    <hr/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <div class="tooltip-mapa" id="tooltip-mapa">
                        <h3 class="nombre-region"></h3>
                        <h2 class="cant-atenciones"></h2>
                        <h4 class="text-atenciones"></h4>
                    </div>
                </div>
                <div class="span6">
                    <table id="tabla-instituciones" class="table table-striped">
                        <thead>
                        <tr>
                            <th width="80%">Instituciones</th>
                            <th>Atenciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2" class="no-data">
                                <strong>Seleccione un mes y una región</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div id="cont-mapa-chile"></div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <h6 class="pull-right"><a target="_blank" href="<?php echo site_url('estadisticas/descarga/presencial-region'); ?>"><i class="icon-download"></i>Descargar Datos</a></h6>
                </div>
                <div class="span12">
                    <h6 class="pull-right"><a target="_blank" href="<?php echo site_url('estadisticas/descarga/instituciones-region'); ?>"><i class="icon-download"></i>Descargar Datos Instituciones</a></h6>
                </div>
            </div>
        </div>
        <div class="seccion-grafico info-evolucion-sucursales">
            <div class="row-fluid">
                <div class="span4">
                    <h1>Evolución crecimiento</h1>
                    <h2>Sucursales ChileAtiende</h2>
                    <hr/>
                </div>
                <div class="span8">
                    <div class="row-fluid no-relative">
                        <div class="cont-slider">
                            <div class="span12">
                                <input id="slider-evolucion-sucursales" type="hidden" class="span2" value="" data-toggle="slider" data-slider-selection="after">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 no-relative">
                    <svg id="line-evolucion-sucursales" style="height:300px"></svg>
                </div>
                <div class="span12">
                    <h6 class="pull-right"><a target="_blank" href="<?php echo site_url('estadisticas/descarga/evolucion-sucursales'); ?>"><i class="icon-download"></i>Descargar Datos</a></h6>
                </div>
            </div>
        </div>
        <div class="seccion-grafico info-numero-comunas">
            <div class="row-fluid">
                <div class="span12">
                    <h1>Número de comunas</h1>
                    <h2>con ChileAtiende</h2>
                    <hr/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span8">
                    <div class="cont-puntos-comunas"></div>
                </div>
                <div class="span4">
                    <div class="cont-cantidad-comunas">
                        <h3 class="cantidad-comunas"></h3>
                        <p>
                            comunas de Chile<br>
                            cuentan con un punto<br>
                            ChileAtiende
                        </p>
                    </div>
                    <div class="cont-porcentaje-poblacion">
                        <p>
                            Equivalente al
                        </p>
                        <h3 class="porcentaje-poblacion"></h3>
                        <p>
                            de la población
                        </p>
                    </div>
                </div>
                <div class="span12">
                    <h6 class="pull-right"><a target="_blank" href="<?php echo site_url('estadisticas/descarga/numero-comunas'); ?>"><i class="icon-download"></i>Descargar Datos</a></h6>
                </div>
            </div>
        </div>
        <div class="seccion-grafico info-numero-oficinas-moviles">
            <div class="row-fluid">
                <div class="span12">
                    <h2>Oficinas Móviles</h2>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <img src="<?php echo base_url('assets_v2/estadisticas/images/icon_oficina_movil.png'); ?>" alt=""/>
                    <strong id="num-oficinas-moviles"></strong>
                    <span>oficinas móviles</span>
                </div>
                <div class="span3">
                    <strong id="num-regiones-oficinas-moviles"></strong>
                    <span>regiones del país</span>
                </div>
                <div class="span5">
                    <strong id="num-comunas-oficinas-moviles"></strong>
                    <span>cubiertas con puntos de atención móvil</span>
                </div>
            </div>
        </div>
        <div class="seccion-grafico info-evolucion-crecimiento">
            <div class="row-fluid">
                <div class="span4">
                    <h1>Evolución crecimiento</h1>
                    <h2>Productos en ChileAtiende</h2>
                    <hr/>
                </div>
                <div class="span8">
                    <div class="row-fluid no-relative">
                        <div class="cont-slider">
                            <div class="span12">
                                <input id="slider-evolucion-crecimiento" type="hidden" class="span2" value="" data-toggle="slider" data-slider-selection="after">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 no-relative">
                    <svg id="line-evolucion-crecimiento" style="height:300px"></svg>
                </div>
                <div class="span12">
                    <h6 class="pull-right"><a target="_blank" href="<?php echo site_url('estadisticas/descarga/evolucion-crecimiento'); ?>"><i class="icon-download"></i>Descargar Datos</a></h6>
                </div>
            </div>
        </div>
    </div>
</div>