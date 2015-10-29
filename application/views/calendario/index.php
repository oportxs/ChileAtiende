<link rel="stylesheet" href="<?php echo base_url('assets_v2/css/calendario.css'); ?>">
<script src="<?php echo base_url('assets_v2/js/calendario.js'); ?>"></script>

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
        		<span id="titulo">Calendario</span>
                <span id="enlace"><a href="<?= base_url('calendario/permanentes'.($es_empresa ? '?e=1':'')); ?>">Postulaciones permanentes</a></span>
        	</div>
			<?php
			$data = isset($data) ? $data : Array();
			echo $this->calendario_pymes->generate($anio,$mes,$data);
			?>
        </div>
	</div>
</div>