<div class="background span12"></div>
<div class="contenedor-principal">	
	<div class="header-search cont-busqueda">
		<form action="<?= site_url('buscar/fichas') ?>" method="get" id="main_search">
	        <h3>Más de <?php echo number_format($nroFichas, 0, ',', '.') ?> servicios y beneficios a tu disposición</h3>
	        <input accesskey="b" autofocus="autofocus" id="main_search_input" class="<?php echo (!$this->config->item("lite_mode"))?'active_search':''; ?> main_search_input" autocomplete="off" name="buscar" placeholder="Ingresa el servicio o beneficio que buscas" type="text" <?php echo (isset($hidden_string)) ? "value='" . $hidden_string . "'" : "" ?> />
	        <button type="submit" accesskey="s" class="searchbtn">Buscar</button>
	        <input type="hidden" name="e" value="<?php echo $hidden_buscador ?>">
	    </form>
	</div>

	<div class="row-fluid">
		<div class="span12 titulos-accesos visible-desktop">
			<div class="span6">
				<h3 class="etapas">En qué etapa estás?</h3>
			</div>
			<!--
			<div class="span3">
				<h3 class="puntos">Puntos de atención</h3>
			</div>
		-->
		</div>
		<div class="span12 nav-principal">
			<?php
			$selected = 'selected';
			foreach($etapas as $e) {
			?>
			<div class="span2<?php echo ' '.$selected ?>" data-id="<?php echo $e->id ?>">
				<h3><a class="etapa-id" data-val="<?php echo $e->id ?>" href="#"><?php echo $e->nombre ?></a></h3>
			</div>
			<?php
				$selected = '';
			}
			?>
		</div>
		<div class="span12 nav-secundaria">
			<div class="aprende"></div>
			<div class="apoyo"></div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12 subcontenido">
			<div class="span6">
				<div class="cabecera">
					<h3>Destacados</h3>
				</div>
				<div class="row destacados">
				</div>
				
			</div>
			<div class="span6">
				<div class="cabecera">
					<h3>Más visitados</h3>
				</div>
				<div class="row">
					<ul>
						<?php 
						foreach($fichasMasVistas as $mv) {
							?>
							<li>
								<!--<span class="label label-success"><?php echo $mv->total ?></span>-->
								<a href="<?php echo site_url('fichas/ver/'.$mv->maestro_id) ?>"><?php echo $mv->titulo ?></a>
								<span class="institucion"><?php echo $mv->Servicio->nombre ?></span>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>