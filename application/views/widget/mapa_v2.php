<div class="row-fluid">
    <div class="breadcrumbs span12 no-print">
        <a href="<?php echo site_url('/') ?>">Portada</a> / <a href="<?=site_url('widget')?>">ChileAtiende en tu sitio</a> / Mapa Oficinas
    </div>
</div>
<div id="content" class="widget">
    <div class="row-fluid">
        <div class="encabezado-contenido">
            <div class="span12">
                <h3>Mapa de oficinas ChileAtiende</h3>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>            
    <div id="maincontent">
        <div class="row-fluid">
            <div class="span12">
                <div class="control-group">
                    <div id="mapaChileAtiende">
                        <iframe src="<?php echo site_url(); ?>api/mapa?dominio=http://www.chileatiende.cl&amp;comuna=&amp;titulo=&amp;filtros=&amp;width=1060&amp;height=220&amp;zoom=15" frameborder="0" width="1060" height="220"></iframe>
                    </div>
                </div>
            </div>
            <form id="formGeneradorMapa">
                <div class="cont_config_mapa">
                    <div class="span6">
                        <div class="cont-titulo-mapa">
                            <span>1</span>
                            <h4>Personaliza tus datos</h4>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <label for="dominio">Dominio institución<span class="obligatorio">*</span></label>
                            </div>
                            <div class="controls">
                                <input type="text" id="dominio" name="dominio" value="" placeholder="http://www.dominio.gob.cl">
                                <input type="hidden" value="mapaChileAtiende" id="id_container" name="id_container">    
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <label for="dominio">Comuna seleccionada</label>
                            </div>
                            <div class="controls">
                                <select name="comuna" id="comuna">
                            <option value="">- Ninguna -</option>
                            <?php foreach ($comunas as $c): ?>
                              <option value="<?= $c->codigo ?>" data-nombre="<?= $c->nombre ?>"><?= $c->nombre ?> (<?= ($c->noficinas>1) ? $c->noficinas.' puntos de atención' : $c->noficinas.' punto de atención' ?>)</option>
                            <?php endforeach; ?>
                          </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <label for="titulo">
                                    Mostrar título
                                    <input type="checkbox" value="1" id="titulo" name="titulo">
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <label for="filtro">
                                    Mostrar filtro de comunas
                                    <input type="checkbox" value="1" id="filtro" name="filtro">
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <label for="width">Ancho</label>
                            </div>
                            <div class="controls">
                                <input type="number" class="dimensiones" value="630" id="width" name="width">px
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <label for="height">Alto</label>
                            </div>
                            <div class="controls">
                                <input type="number" class="dimensiones" value="450" id="height" name="height">px
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <label for="zoom">Zoom</label>
                            </div>
                            <div class="controls">
                                <select name="zoom" id="zoom">
                                    <option value="12">Muy lejano</option>
                                    <option value="13">Lejano</option>
                                    <option value="14">Medio</option>
                                    <option value="15">Cerano</option>
                                    <option value="16">Ubicación precisa</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <button class="btn boton btn-primary" id="btn_generar_mapa">Generar código</button>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group contenedor-codigo">
                            <div class="cont-titulo-mapa">
                                <span>2</span>
                                <h4>Copia el código del mapa</h4>
                            </div>
                            <label>Pega este código donde quieras que aparezca el mapa.</label>
                            <textarea id="codigo_mapa" class="codigo_mapa codigo_generado" rows="10" readonly="readonly">
                            </textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="clearfix">&nbsp;</div>
            <script type="text/javascript" src="<?php echo site_url('assets/js/jquery.validate.min.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo site_url('assets/js/generamapachileatiende.js'); ?>"></script>
        </div>
    </div>
</div>