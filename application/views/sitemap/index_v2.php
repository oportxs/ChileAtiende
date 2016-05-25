<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175">
        <a href="<?= site_url('/') ?>">Portada</a> / <?php echo $title; ?>
    </div>
</div>
<div id="content" class="contenido sitemap">
    <div class="row-fluid">
        <div class="encabezado-contenido">
            <div class="span12">
                <h3><?php echo $title; ?></h3>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 span-maincontent">
            <div id="maincontent">
                <div class="row-fluid">
                    <div class="span4">
                       <h3>Etapas</h3>
                        <?php foreach ($etapas as $key => $etapa): ?>
                            <h4><?php echo ucfirst(strtolower($etapa->nombre)); ?></h4>
                            <ul>
                                <?php foreach ($etapa->HechosVida as $key => $hechoVida): ?>
                                    <li>
                                        <a href="<?php echo site_url('buscar/fichas/?etapa='.$etapa->id.'&hecho='.$hechoVida->id); ?>">
                                            <?php echo $hechoVida->nombre; ?>
                                        </a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        <?php endforeach ?>

                        <h3>Temas</h3>
                        <ul>
                        <?php foreach ($temas as $key => $tema): ?>
                            <li>
                                <a href="<?php echo site_url('buscar/fichas/?temas='.$tema->id); ?>">
                                    <?php echo ucfirst(strtolower($tema->nombre)); ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                        </ul> 
                    </div>
                    <div class="span4">
                        <h3>Instituciones asociadas</h3>
                        <?php $letra = $servicios[0]->nombre[0]; ?>
                        <h4><?php echo ucfirst($letra); ?></h4>
                        <ul>
                            <?php foreach ($servicios as $servicio) { ?>
                                <?php if ($letra != $servicio->nombre[0]): ?>
                                    </ul>
                                    <h4><?php echo $servicio->nombre[0]; ?></h4>
                                    <ul>
                                <?php endif ?>
                                <li>
                                    <a href="<?= site_url('servicios/ver/' . $servicio->codigo ) ?>"><?= $servicio->nombre ?></a>
                                </li>
                                <?php $letra = $servicio->nombre[0]; ?>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="span4">
                        <h3>Sobre ChileAtiende</h3>
                        <ul>
                            <li><a href="<?php echo site_url('contenidos/que-es-chileatiende'); ?>">¿Qué es ChileAtiende?</a></li>
                            <li><a href="<?php echo site_url('serviciosdisponibles'); ?>">Servicios disponibles</a></li>
                            <li><a href="<?php echo site_url('servicios/directorio'); ?>" title="Instituciones Asociadas">Instituciones asociadas</a></li>
                            <li><a href="<?php echo site_url('contenidos/preguntas-frecuentes'); ?>" title="Preguntas Frecuentes" rel="help">Preguntas frecuentes</a></li>
                        </ul>

                        <h3>Términos y condiciones</h3>
                        <ul>
                            <li><a href="<?php echo site_url('contenido/politicadeprivacidad'); ?>">Política de privacidad</a></li>
                            <li><a href="<?php echo site_url('contenido/terminosycondiciones'); ?>">Términos de uso</a></li>
                            <li><a href="<?php echo site_url('contenido/visualizadores'); ?>">Visualizadores</a></li>
                        </ul>

                        <h3>Accesos directos</h3>
                        <ul>
                           <li><a href="<?php echo site_url('sitemap'); ?>" title="Mapa del Sitio">Mapa del sitio</a></li>
                           <li><a target="_blank" href="<?php echo site_url('desarrolladores'); ?>">API para desarrolladores</a></li>
                           <li><a href="<?php echo site_url('widget'); ?>">ChileAtiende en tu sitio</a></li>
                        </ul>

                        <h3>Puntos de atención</h3>
                        <ul>
                            <?php foreach ($oficinas_regiones as $key => $region): ?>
                                <li>
                                    <a href="<?php echo site_url('oficinas/?region='.$region->codigo); ?>">
                                        <?php echo $region->nombre; ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>

                        <h3>Redes Sociales</h3>
                        <ul>
                            <li>
                                <a href="http://facebook.com/chileatiende" target="_blank">Facebook</a>
                            </li>
                            <li>
                                <a href="http://twitter.com/chileatiende" target="_blank">Twitter</a>
                            </li>
                        </ul>

                        <h3>Funciones Comunes</h3>
                        <ul>
                            <li>
                                <a href="<?php echo site_url('sitemap'); ?>">Mapa del sitio</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('contenidos/preguntas-frecuentes'); ?>">Twitter</a>
                            </li>
                            <li>
                                <a href="https://contacto.chileatiende.cl/formulario.php?origen=<?php echo site_url(); ?>" data-toggle="modal-chileatiende" data-modal-type="iframe">Contacto</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
