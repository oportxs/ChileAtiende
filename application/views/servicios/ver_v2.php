<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175">
        <a href="<?= site_url('/') ?>">Portada</a> / <a href="<?= site_url('/servicios/directorio/') ?>">Listado de Instituciones</a> / <?php echo $servicio->nombre; ?>
    </div>
</div>
<div id="content" class="institucion">
    <div class="row-fluid">
        <div class="span8 span-maincontent">
            <div class="institucion-encabezado">
                <div class="row-fluid print">
                    <div class="pull-right">
                        <h6>Última actualización</h6>
                    </div>
                </div>
                <h2 class="institucion-titulo"><?php echo $servicio->nombre; ?></h2>
                <div class="clearfix"></div>
            </div>
            <div id="maincontent" role="main">
                <?php if ($servicio->mision): ?>
                    <h3 class="first_topic">Misión institucional</h3>
                    <p><?= $servicio->mision ?></p>
                <?php endif ?>
                <?php if ($servicio->url): ?>
                    <p>
                        <a href="<?= $servicio->url ?>" target="_blank"><?= $servicio->url ?></a>
                    </p>
                <?php endif ?>
                <p class="institucion-depende">
                    Esta institución depende de: <strong><a href="<?= site_url('entidades/ver/' . $entidad->codigo ) ?>"><?= $entidad->nombre ?></a></strong>
                </p>
                <div class="fichas">
                    <h3>Servicios o beneficios de la Institución (<?php echo $total; ?>)</h3>
                    <ul class="listado-fichas">
                        <?php foreach ($fichas as $key => $ficha):
                            // INFO: link para metafichas con servicio pre-seleccionado. Depende de que las metafichas vienen con maestro_id == NULL (ver findFichaOnServicio en ficha_table.php)
                            $ficha_id = $ficha->maestro_id ? $ficha->maestro_id : $ficha->id."?codigo=".$servicio->codigo;
                        ?>
                            <li class="ficha-institucion row-fluid">
                                <div class="span2 hidden-phone">
                                    <a class="ver-ficha" href="<?php echo site_url('fichas/ver/'.$ficha_id); ?>">Ver ficha</a>
                                </div>
                                <div class="span10">
                                    <h4><a href="<?php echo site_url('fichas/ver/'.$ficha_id); ?>"><?php echo $ficha->titulo; ?></a></h4>
                                    <p>
                                        <?php echo prepare_content_ficha_resumen($ficha->objetivo, 20, true); ?><a href="<?php echo site_url('fichas/ver/'.$ficha_id); ?>" class="ver-mas">Ver más</a>
                                    </p>
                                    <?php if (count($ficha->Temas)): ?>
                                        <div class="temas">
                                            Temas:
                                            <?php $temas = array(); ?>
                                            <?php foreach ($ficha->Temas as $key => $tema){ $temas[] = $tema->nombre; } ?>
                                            <span><?php echo enumerar_en_espanol($temas); ?></span>
                                        </div>                                
                                    <?php endif ?>
                                    <div class="tipotramite">
                                        <?= ($ficha->guia_online ? '<span class="tipo_tramite_online" title="En Línea">En línea</span>' : '') ?>
                                        <?= ($ficha->guia_oficina ? '<span class="tipo_tramite_oficina" title="En oficina">En oficina</span>' : '') ?>
                                        <?= ($ficha->guia_telefonico ? '<span class="tipo_tramite_telefonico" title="Por teléfono">Por teléfono</span>' : '') ?>
                                        <?= ($ficha->guia_correo ? '<span class="tipo_tramite_correo" title="Por correo">Por correo</span>' : '') ?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div class="pagination-centered">
                    <?php echo $paginacion; ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="span4 span-side-bar no-print">
            <div class="side-bar visible-desktop" data-offset-top="175" data-offset-bottom="300">
                <div class="temas-destacados listado-fichas">
                    <h4 class="accordion-heading toggle active">Recomendados:</h4>
                    <ul class="accordion-body" style="display:block;">
                        <?php foreach ($fichasDestacadas as $key => $ficha){ ?>
                            <div class="ficha-sidebar ficha-relacionada<?php echo $ficha->flujo?' flujo':''; ?>">
                                <?php if ($ficha->flujo): ?>
                                    <img src="<?php echo base_url('assets_v2/img/label_aprende_sobre.png'); ?>" class="label_flujo" alt="Label Flujo">
                                <?php endif ?>
                                <div class="ficha-top">
                                    <h5>
                                        <a href="<?php echo site_url('fichas/ver/'.$ficha_id); ?>"><?php echo $ficha->titulo; ?></a>
                                    </h5>
                                    <span><?php echo $ficha->Servicio->nombre; ?></span>
                                </div>
                                <div class="tipotramite">
                                    <?= ($ficha->guia_online ? '<span class="tipo_tramite_online" title="En Línea">En línea</span>' : '') ?>
                                    <?= ($ficha->guia_oficina ? '<span class="tipo_tramite_oficina" title="En oficina">En oficina</span>' : '') ?>
                                    <?= ($ficha->guia_telefonico ? '<span class="tipo_tramite_telefonico" title="Por teléfono">Por teléfono</span>' : '') ?>
                                    <?= ($ficha->guia_correo ? '<span class="tipo_tramite_correo" title="Por correo">Por correo</span>' : '') ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>