<link rel="stylesheet" href="<?php echo base_url('assets_v2/css/calendario.css'); ?>">
<div style="background-color: #FFF; position: relative;">
	<div class="row-fluid">
		<div class="span4">
		    <div id="sidebar" class="filtros-busqueda">

		        <div class="filtros-header">
		            <h2>
		                Filtros
		            </h2>
		            <p class="instruccion">Para resultados más especificos.</p>
		            <div class="clearfix"></div>
		        </div>

                <div class="cont-form-filtros-busqueda">

                	<?php if (isset($regiones) && count($regiones) > 0): ?>
                	<h2>Regiones</h2>
                	<ul id="region" class="text-small toggable">
                	<?php foreach($regiones as $region): 
                		$activo = in_array($region->id, $filtro_region);
                	?>
                		<li class="<?php echo $activo ? 'on':''; ?>" style="padding: 0px;">
                			<a class="<?php echo $activo ? 'on':''; ?>" href="<?php echo url_buscador('r', $region->id, $activo, false); ?>"><?php echo $region->nombre; ?></a>
                		</li>
                	<?php endforeach; ?>
                	</ul>
	                <?php endif; ?>

                	<?php if (isset($instituciones) && count($instituciones) > 0): ?>
                	<h2>Instituciones</h2>
                	<ul id="institucion" class="text-small toggable">
                	<?php foreach($instituciones as $institucion): 
                		$activo = in_array($institucion->codigo, $filtro_institucion);
                	?>
                		<li class="<?php echo $activo ? 'on':''; ?>">
                			<a class="<?php echo $activo ? 'on':''; ?>" href="<?php echo url_buscador('i', $institucion->codigo, $activo, false); ?>"><?php echo $institucion->nombre; ?></a>
                		</li>
                	<?php endforeach; ?>
                	</ul>
	                <?php endif; ?>	                

                </div>

            </div>
        </div>
        <div class="span8">
        	<div class="calendario_top">
                <span id="enlace"><a href="<?= base_url('calendario'.($es_empresa ? '?e=1':'')); ?>">Calendario</a></span>
        		<span id="titulo">Postulaciones permanentes</span>
        	</div>

            <div class="pagination-centered">
                <?= $this->pagination->create_links() ?>
                <div class="clearfix"></div>
            </div>
			
            <!-- <table class="eventos_permanentes"> -->
            <ul class="searchresults">
            <?php
            $count = $this->input->get('offset') ? $this->input->get('offset') : 0;
            foreach($eventos as $evento):
                $count++;
            ?>
                <li class="<?= $count%2 ? 'par' : 'none' ?>">
                    <div class="resultado-resumen">
                        <span class="num-ficha"><?= $count ?></span>
                        <h2><a href="<?=   $evento['url']; ?>" title="<?= $evento['titulo']; ?>"><?= $evento['titulo']; ?></a></h2>
                        <p>
                        <?= $evento['info']; ?>
                        </p>
                        <p class="adicional">
                            <span style="font-size: small"><b>Región donde se realiza: </b><?php 
                            if(count($evento['regiones']) == 15) { echo "Todas las regiones."; }
                            else { 
                                $regiones = array();
                                foreach($evento['regiones'] as $region) $regiones[] = $region->nombre;
                                echo join(', ', $regiones);
                            } ?></span>
                            <br />
                            <span style="font-size: small; font-weight: bold">Institución que realiza la actividad: </span><a href="<?= site_url("servicios/ver/" . $evento['institucion']->codigo); ?>"><?= $evento['institucion']->nombre ?><?= ($evento['institucion']->sigla) ? ' ('.$evento['institucion']->sigla.')' : '' ?></a>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </li>

<!--                     <tr><td class="info permanente"></td></tr>
                    <tr><td class="info">Institución:</td><td><?= $evento['institucion']; ?></td></tr>
                    <tr><td class="info">Regiones:</td><td><?php 
                    if(count($evento['regiones']) == 15) { echo "Todas las regiones."; }
                    else { 
                        $regiones = array();
                        foreach($evento['regiones'] as $region) $regiones[] = $region->nombre;
                        echo join(', ', $regiones);
                    }
                    ?></td></tr>
                    <tr class="permanente separacion"><td class="info">Información:</td><td><?= $evento['info']; ?></td></tr> -->
            <?php
            endforeach;
			?>
            </ul>
            <!-- </table> -->
            
            <div class="pagination-centered">
                <?= $this->pagination->create_links() ?>
                <div class="clearfix"></div>
            </div>

        </div>
	</div>
</div>