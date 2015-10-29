<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175">
        <a href="<?= site_url('/') ?>">Portada</a> / Puntos de atención ChileAtiende
    </div>
</div>
<div id="content" class="puntosatencion">
    <div class="row-fluid">
        <div class="encabezado-puntosatencion">
            <div class="span12">
                <h2>Puntos de atención ChileAtiende</h2>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 span-maincontent">
            <div id="maincontent">
                <div class="row-fluid">
                    <div class="span12 filtros-puntosatencion">
                        <p>En <strong>206</strong> sucursales y <strong>5</strong> oficinas móviles podrás realizar un total aproximado de <strong><?php echo $count_tramites; ?></strong> trámites en convenio con distintas instituciones</p>
                        <form action="<?php echo site_url('oficinas'); ?>" method="get" class="form form-inline">
                            <div class="row-fluid">
                                <div class="span12">
                                    <h4>
                                        Busca una sucursal y encuentra los trámites disponibles en ella:
                                    </h4>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span3">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label for="region">Región</label>
                                        </div>
                                        <div class="controls">
                                            <select class="input-block-level" name="region" id="region">
                                                <option value="">- Todas -</option>
                                                <?php foreach ($regiones as $key => $region): ?>
                                                    <option<?php echo $region->codigo==substr($sector_codigo, 0, 2)?' selected="selected"':''; ?> value="<?php echo $region->codigo; ?>"><?php echo $region->nombre; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label for="provincia">Provincia</label>
                                        </div>
                                        <div class="controls">
                                            <select class="input-block-level" name="provincia" id="provincia">
                                                <option value="">- Todas -</option>
                                                <?php foreach ($provincias as $key => $provincia): ?>
                                                    <option<?php echo $provincia->codigo==substr($sector_codigo, 0, 3)?' selected="selected"':''; ?> value="<?php echo $provincia->codigo; ?>"><?php echo $provincia->nombre; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label for="comuna">Comuna</label>
                                        </div>
                                        <div class="controls">
                                            <select class="input-block-level" name="comuna" id="comuna">
                                                <option value="">- Todas -</option>
                                                <?php foreach ($comunas as $key => $comuna): ?>
                                                    <option<?php echo $comuna->codigo==substr($sector_codigo, 0, 5)?' selected="selected"':''; ?> value="<?php echo $comuna->codigo; ?>"><?php echo $comuna->nombre; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group-last">
                                        <button class="btn btn-primary">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php echo getAlertasUrl(); ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <?php if ($sector_codigo): ?>
                        <div class="span9">
                            <div class="cont-resultados">
                                <h4>Resultados:</h4>
                                <?php $this->load->view('oficinas/tmpl_oficinas') ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($regiones as $key => $region): ?>
                            <?php if ($region->codigo == 13): ?>
                                <div class="span9">
                                    <div class="cont-region-oficinas">
                                        <h5 class="titulo-region" data-region="<?php echo $region->codigo; ?>">
                                            <a href="<?php echo site_url('oficinas?region='.$region->codigo); ?>"><?php echo $region->nombre; ?></a>
                                        </h5>
                                        <div class="row-fluid row-oficinas"></div>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                        <?php foreach ($regiones as $key => $region): ?>
                            <?php if ($region->codigo != 13): ?>
                                <div class="span9">
                                    <div class="cont-region-oficinas">
                                        <h5 class="titulo-region" data-region="<?php echo $region->codigo; ?>">
                                            <a href="<?php echo site_url('oficinas?region='.$region->codigo); ?>"><?php echo $region->nombre; ?></a>
                                        </h5>
                                        <div class="row-fluid row-oficinas"></div>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>