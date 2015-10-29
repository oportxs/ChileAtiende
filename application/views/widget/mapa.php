<div class="generador_mapa_chile_atiende">
	<div class="breadcrumbs" style="margin: 0 0 20px 17px;"><a href="<?= site_url('/') ?>">Portada</a> / <a href="<?=site_url('widget')?>">ChileAtiende en tu sitio</a> / Mapa Oficinas</div>

	<h2 class="oficinas">Mapa de oficinas ChileAtiende</h2>
	<div class="clearfix">&nbsp;</div>
	<div class="control-group">
		<div id="mapaChileAtiende">
			<iframe src="<?php echo site_url(); ?>api/mapa?dominio=http://www.chileatiende.cl&amp;comuna=&amp;titulo=&amp;filtros=&amp;width=960&amp;height=220&amp;zoom=15" frameborder="0" width="960" height="220"></iframe>
		</div>
	</div>
	<form id="formGeneradorMapa">
		<div class="cont_config_mapa">
			<div class="columna-izquierda">
				<h3><span>1</span>Personalice sus datos</h3>
				<div class="control-group">
					<div class="control-label">
						<label for="dominio">Dominio Institución<span class="obligatorio">*</span></label>
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
							<input type="checkbox" value="1" id="titulo" name="titulo">
							Mostrar Título
						</label>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<label for="filtro">
							<input type="checkbox" value="1" id="filtro" name="filtro">
							Mostrar Filtro de Comunas
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
					<button class="btn boton" id="btn_generar_mapa">Generar Código</button>
				</div>
			</div>
			<div class="columna-derecha">
				<div class="control-group contenedor-codigo">
					<h3><span>2</span>Copie código mapa</h3>
					<p>Pega este código donde quieres que aprezca el mapa.</p>
					<textarea id="codigo_mapa" class="codigo_mapa codigo_generado" readonly="readonly">
					</textarea>
				</div>
			</div>
		</div>
	</form>
	<div class="clearfix">&nbsp;</div>
	<script type="text/javascript" src="<?php echo site_url('assets/js/jquery.validate.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo site_url('assets/js/generamapachileatiende.js'); ?>"></script>
</div>