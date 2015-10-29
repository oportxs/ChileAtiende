<div class="row-fluid">
    <div class="breadcrumbs span12 no-print">
        <a href="<?= site_url('/') ?>">Portada</a> / Resultados de Búsqueda
    </div>
</div>
<div id="content" class="resultado-busqueda">
    <div class="row-fluid">
        <?php 
        if(!isset($vista_filtros)) $vista_filtros = 'filtros_v2' ;
        $this->load->view('busqueda/'.$vista_filtros); 
        ?>
        <div class="span8">
            <div id="maincontent" role="main">
                <?php if ((isset($fichas) && count($fichas) > 0) || count($promocionados)>0): ?>
                    <div class="info-busqueda">
                        <div class='texto-busqueda<?php echo !$query?' no-string':''; ?>'>
                            <?php if ($query): ?>
                                <span><?php echo "\"".htmlspecialchars($query)."\""; ?></span> <b>:</b>
                            <?php endif ?>
                            <strong><?php echo ($total_fichas+count($promocionados)); ?></strong> Resultados.
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                    <?php if($suggest):?>
                        <div class="alert alert-warning">Buscar, en cambio, <a href="<?=url_buscador('buscar',$suggest)?>&exacto=1"><?=$suggest?></a></div>
                    <?php endif ?>
                    <ul class="searchresults">
                        <?php foreach($promocionados as $p):?>
                        <li class="promocionado">
                            <div class="resultado-resumen">
                                <span class="num-ficha"><i class="icon-ok icon-white"></i></span>
                                <h2><a href="<?=$p->url?>" data-ga-te-category="Acciones Buscador" data-ga-te-action="Resultado patrocinado" data-ga-te-value="<?php echo $p->id; ?>"><?=$p->titulo?></a></h2>
                                <p><?=$p->introtext?></p>
                            </div>
                            <div class="resultado-info">
                                        
                            </div>
                            <div class="clearfix"></div>
                        </li>
                        <?php endforeach ?>
                        <?php $num_ficha = $offset ?>
                        <?php foreach ($fichas as $ficha): ?>
                            <?php if ($ficha->flujo): ?>
                                <li class="<?php echo 'flujo'.($num_ficha%2?' par':' none'); ?>">
                                    <div class="resultado-resumen">
                                        <span class="num-ficha"><?php echo $num_ficha+1; ?></span>
                                        <h2>
                                            <?php if ($ficha->Maestro->sello_chilesinpapeleo): ?>
                                                <img class="sello-chilesinpapeleo has-tooltip-chilesinpapeleo" title="Este sello es otorgado a los trámites del Estado que se realizan completamente por Internet y no requieren presencia física de las personas para su realización." src="<?php echo base_url('assets/images/ico_chilesinpapeleo_32_on.png'); ?>" alt="Sello ChileSinPapeleo">
                                            <?php endif ?>
                                            <a href="<?php echo site_url("fichas/ver/" . $ficha->maestro_id); ?>" ><?php echo $ficha->titulo; ?></a>
                                        </h2>
                                        <p>
                                            <?php echo $ficha->resumenFicha($query?explode(' ',$query):null); ?>
                                        </p>
                                    </div>
                                    <div class="resultado-info">
                                        
                                    </div>
                                    <div class="clearfix"></div>
                                </li>
                            <?php else: ?>
                                <li class="<?php echo ($num_ficha%2?'par':'none'); ?>">
                                    <div class="resultado-resumen">
                                        <span class="num-ficha"><?php echo $num_ficha+1; ?></span>
                                        <h2>
                                            <?php if ($ficha->Maestro->sello_chilesinpapeleo): ?>
                                                <img class="sello-chilesinpapeleo has-tooltip-chilesinpapeleo" title="Este sello es otorgado a los trámites del Estado que se realizan completamente por Internet y no requieren presencia física de las personas para su realización." src="<?php echo base_url('assets/images/ico_chilesinpapeleo_32_on.png'); ?>" alt="Sello ChileSinPapeleo">
                                            <?php endif ?>
                                            <a href="<?php echo site_url("fichas/ver/" . $ficha->maestro_id); ?>" ><?php echo $ficha->titulo ?></a>
                                        </h2>
                                        <p>
                                            <?php echo $ficha->resumenFicha($query?explode(' ',$query):null); ?>
                                        </p>
                                        <p class="adicional">
                                            <a href="<?= site_url("servicios/ver/" . $ficha->Servicio->codigo); ?>"><?= $ficha->Servicio->nombre ?><?= ($ficha->Servicio->sigla) ? ' ('.$ficha->Servicio->sigla.')' : '' ?></a>
                                        </p>
                                    </div>
                                    <div class="resultado-info">
                                        <div class="tipotramite">
                                            <?= ($ficha->guia_online ? '<span class="tipo_tramite_online" title="En Línea">En línea</span>' : '') ?>
                                            <?= ($ficha->guia_oficina ? '<span class="tipo_tramite_oficina" title="En oficina">En oficina</span>' : '') ?>
                                            <?= ($ficha->guia_telefonico ? '<span class="tipo_tramite_telefonico" title="Por teléfono">Por teléfono</span>' : '') ?>
                                            <?= ($ficha->guia_correo ? '<span class="tipo_tramite_correo" title="Por correo">Por correo</span>' : '') ?>
                                            <div class="clearfix"></div>
                                        </div>
                                        <?php if ($ficha->guia_online_url): ?>
                                            <?php echo botonTramiteOnline($ficha); ?>
                                        <?php endif ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </li>
                            <?php endif ?>
                            <?php $num_ficha++ ?>
                        <?php endforeach; ?>
                    </ul>
                    <div class="row-fluid">
                        <div class="span3">
                            <div class="contador-resultados">
                                <?php echo $offset+1; ?>-<?php echo $offset+count($fichas); ?> de <?php echo ($total_fichas+count($promocionados)); ?>
                            </div>
                        </div>
                        <div class="span9">
                            <?= $this->pagination->create_links() ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="span9">
                        <div style="padding: 20px;">
                            <p><strong>No se han encontrado resultados<?= $query?' para "'.htmlspecialchars($query).'"':''; ?>.</strong></p>
                            <p>Sugerencias:</p>
                            <ul>
                                <li>Asegúrate de que todas las palabras estén escritas correctamente.</li>
                                <li>Prueba diferentes palabras clave.</li>
                                <li>Prueba palabras clave más generales.</li>
                            </ul>
                        </div>
                        </div>
                        <?php if($suggest):?>
                        <div class="alert alert-warning">Quizás quisiste decir: <a href="<?=url_buscador('buscar',$suggest)?>"><?=$suggest?></a></div>
                    <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
