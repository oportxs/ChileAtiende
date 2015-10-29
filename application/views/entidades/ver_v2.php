<?php $sigla = ($entidad->sigla)?"(".$entidad->sigla.")":""; ?>
<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175">
        <a href="<?= site_url('/') ?>">Portada</a> / <?= $entidad->nombre." ".$sigla; ?>
    </div>
</div>
<div id="content" class="institucion entidad">
    <div class="row-fluid">
        <div class="span8 span-maincontent">
            <div class="institucion-encabezado">
                <h2 class="institucion-titulo">
                    <?= $entidad->nombre." ".$sigla; ?>
                </h2>
                <div class="clearfix"></div>
            </div>
            <div id="maincontent" role="main">
                <?php if (!empty($entidad->mision)): ?>
                    <h3 class="first_topic">Misión Institucional</h3>
                    <p><?= $entidad->mision ?></p>
                <?php endif ?>
                <h3>Organismos públicos (<?php echo count($servicios); ?>)</h3>
                <ul class="organismos-asociados unstyled">
                    <?php foreach ($servicios as $key => $servicio): ?>
                        <li><a href="<?php echo site_url('servicios/ver/'.$servicio->codigo); ?>"><?php echo $servicio->nombre; ?></a></li>
                    <?php endforeach ?>
                </ul>
                <div class="fichas">
                    <h3>Servicios o beneficios de la Institución (<?php echo $total; ?>)</h3>
                    <ul class="listado-fichas">
                        <?php foreach ($fichas as $key => $ficha): ?>
                            <li class="ficha-institucion row-fluid">
                                <div class="span2 hidden-phone">
                                    <a class="ver-ficha" href="<?php echo site_url('fichas/ver/'.$ficha->maestro_id); ?>">Ver ficha</a>
                                </div>
                                <div class="span10">
                                    <h4><a href="<?php echo site_url('fichas/ver/'.$ficha->maestro_id); ?>"><?php echo $ficha->titulo; ?></a></h4>
                                    <p>
                                        <?php echo prepare_content_ficha_resumen($ficha->objetivo, 20, true); ?><a href="<?php echo site_url('fichas/ver/'.$ficha->maestro_id); ?>" class="ver-mas">Ver más</a>
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
            <div class="side-bar visible-desktop" data-offset-top="174" data-offset-bottom="276">
                <div class="temas-destacados listado-fichas">
                    <h4 class="accordion-heading active">Recomendados:</h4>
                    <ul class="accordion-body" style="display:block;">
                        <?php foreach ($fichasDestacadas as $key => $ficha){ ?>
                            <div class="ficha-sidebar ficha-destacada<?php echo $ficha->flujo?' flujo':''; ?>">
                                <?php if ($ficha->flujo): ?>
                                    <img src="<?php echo base_url('assets_v2/img/label_aprende_sobre.png'); ?>" class="label_flujo" alt="Label Flujo">
                                <?php endif ?>
                                <div class="ficha-top">
                                    <h5>
                                        <a href="<?php echo site_url('fichas/ver/'.$ficha->maestro_id); ?>"><?php echo $ficha->titulo; ?></a>
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