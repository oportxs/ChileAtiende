<div class="span4">
	<div id="sidebar" class="filtros-busqueda">
        <div class="filtros-header">
            <h2>
                Filtros
            </h2>
            <p class="instruccion">Para resultados más específicos.</p>
            <div class="clearfix"></div>
        </div>
        <div class="cont-form-filtros-busqueda">
        	<h2>Etapa Empresa</h2>
        	<ul>
        		<?php
        		if(!isset($filtro_etapa_empresa)) $filtro_etapa_empresa = array();
        		foreach($etapas_empresa as $ee) {
        			$activo = in_array($ee['id'], $filtro_etapa_empresa);
        			?>
        			<li>
        				<a href="<?php echo url_buscador('ee', $ee['id'], $activo, false); ?>" class="<?php echo $activo ? 'on' : ''; ?>"><?php echo $ee['nombre'] ?></a>
        			</li>
        			<?php
        		}
        		?>
        	</ul>
        	<!--
        	<h2>Temas</h2>
        	<ul>
        		<?php
        		if(!isset($filtro_tema_empresa)) $filtro_tema_empresa = array();
        		foreach($temas_empresa as $te) {
        			$activo = in_array($te['id'], $filtro_tema_empresa);
        			?>
        			<li>
        				<a href="<?php echo url_buscador('te', $te['id'], $activo, false); ?>" class="<?php echo $activo ? 'on' : ''; ?>"><?php echo $te['nombre'] ?></a>
        			</li>
        			<?php
        		}
        		?>
        	</ul>
        	-->
        	<?php
        	if(count($apoyos_estado)) {
        	?>
        	<h2>Apoyo estatal</h2>
        	<ul>
        		<?php
        		if(!isset($filtro_apoyo_estado)) $filtro_apoyo_estado = array();
        		foreach($apoyos_estado as $ae) {
        			$activo = in_array($ae['id'], $filtro_apoyo_estado);
        			?>
        			<li>
        				<a href="<?php echo url_buscador('ae', $ae['id'], $activo, false); ?>" class="<?php echo $activo ? 'on' : ''; ?>"><?php echo $ae['nombre'] ?></a>
        			</li>
        			<?php
        		}
        		?>
        	</ul>
        	<?php
        	}
        	?>
        	<h2>Ventas anuales</h2>
        	<ul>
        		<?php
        		if(!isset($filtro_venta_anual)) $filtro_venta_anual = array();
        		foreach($ventas_anuales as $va) {
        			$activo = in_array($va['id'], $filtro_venta_anual);
        			$tipo_emp = '';
        			switch ($va['id']) {
        				case 1:
        					$tipo_emp = '0 - 2.400 U.F.';
        					break;
        				case 2:
        					$tipo_emp = '2.401 - 25.000 U.F.';
        					break;
        				case 3:
        					$tipo_emp = '25.001 - 100.000 U.F.';
        					break;
        				case 4:
        					$tipo_emp = '100.001 > U.F.';
        					break;
        			}
        			?>
        			<li>
        				<a href="<?php echo url_buscador('va', $va['id'], $activo, false); ?>" class="<?php echo $activo ? 'on' : ''; ?>"><?php echo $tipo_emp ?></a>
        			</li>
        			<?php
        		}
        		?>
        	</ul>
        	<h2>Rubros</h2>
        	<ul>
        		<?php
        		if(!isset($filtro_rubro)) $filtro_rubro = array();
        		foreach($rubros as $r) {
        			$activo = in_array($r['id'], $filtro_rubro);
        			?>
        			<li>
        				<a href="<?php echo url_buscador('r', $r['id'], $activo, false); ?>" class="<?php echo $activo ? 'on' : ''; ?>"><?php echo $r['nombre'] ?></a>
        			</li>
        			<?php
        		}
        		?>
        	</ul>
            <h2>Ficha Protección Social</h2>
            <ul>
                <small id="msg_fps" style="font-style: italic; color: #ccc; font-size: small; display: none;"></small>
                <input type="number" id="input_fps" name="fps" value="<?php echo $filtro_fps; ?>" maxlength="10" />
                <input type="image" id="button_fps" src="/assets_v2/img/resultados/icono_lupa_busqueda.png" alt="" />
            </ul>
        </div>
	</div>
</div>