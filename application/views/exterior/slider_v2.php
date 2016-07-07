<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175">
        <a href="<?= site_url('/') ?>">Portada</a> / <?php echo $title; ?>
    </div>
</div>
<div id="content" class="contenido etapas-temas">
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
                <div class="cont-filtros-home">
                    <div class="row-fluid">
                        <h4><?php echo $titulo; ?></h4>
                    </div>
                    <div class="cont-seleccion-filtros">
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="cont-seleccion cont-seleccion-etapas <?php echo $active_slide=='etapas'?'active':''; ?>">
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <ul class="unstyled lista-etapas">
                                                <?php foreach ($etapas as $key => $etapa){ ?>
                                                    <li<?php echo $etapa->id==4?' clasS="active"':''; ?>>
                                                        <a data-etapa="<?php echo $etapa->id; ?>" href="#etapa-<?php echo $etapa->id; ?>"><?php echo ucfirst(strtolower($etapa->nombre)); ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="span9">
                                            <div class="row-fluid cont-carga-etapa"></div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="cont-seleccion cont-seleccion-temas <?php echo $active_slide=='temas'?'active':''; ?>">
                                <form action="<?php echo site_url('buscar/fichas'); ?>" method="get">
                                    <ul class="unstyled lista-temas">
                                        <?php foreach ($temas as $key => $tema){ ?>
                                            <?php if ($key%4==0 && $key!=0): ?>
                                                </ul>
                                                <ul class="unstyled lista-temas">
                                            <?php endif ?>
                                            <li><input type="radio" name="temas" id="tema-<?php echo $tema->id; ?>" value="<?php echo $tema->id; ?>"><label for="tema-<?php echo $tema->id; ?>"><?php echo ucfirst(strtolower($tema->nombre)); ?></label></li>
                                        <?php } ?>
                                    </ul>
                                    <div class="clearfix"></div>
                                    <div class="row-fluid">
                                        <p>
                                            <strong>Para obtener mejores resultados, ingresa los siguiente datos (opcionales)</strong>
                                        </p>
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label for="edad">Edad</label>
                                            </div>
                                            <div class="controls">
                                                <input type="number" class="input-medium" name="edad" id="edad" value="" max="120" min="1">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label for="genero">Sexo</label>
                                            </div>
                                            <div class="controls">
                                                <select  class="input-medium" name="genero" id="genero">
                                                    <option value="1">Ambos</option>
                                                    <option value="2">Masculino</option>
                                                    <option value="3">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Buscar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
