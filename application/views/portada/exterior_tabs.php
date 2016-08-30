<div class="background span12"></div>
<div class="contenedor-principal">	
	<div class="header-search cont-busqueda">
		
	</div>

	<div class="row-fluid">
		<div class="span12 titulos-accesos visible-desktop">
		</div>
		<div class="span12 nav-principal">
			<div class="span2 selected" data-id="1">
				<p class="tab" id="tab-default" onclick="showTab('viaje',this)"><a class="etapa-id" data-val="1" href="#">Chilenos de Viaje</a></p>
			</div>
			<div class="span2" data-id="2">
				<p class="tab" onclick="showTab('temporal',this)"><a class="etapa-id" data-val="2" href="#">Chilenos Residencia Temporal</a></p>
			</div>
			<div class="span2" data-id="3">
				<p class="tab" onclick="showTab('permanentes',this)"><a class="etapa-id" data-val="3" href="#">Chilenos Residentes Permanentes</a></p>
			</div>
			<div class="span2" data-id="4">
				<p class="tab"><a class="etapa-id" data-val="4" href="http://www.chilevacontigo.gob.cl/" target="_blank">Consulados</a></p>
			</div>
		</div>
		
		<?php foreach($fichas_exterior as $key=>$motivo): ?>
		<div class="span12 nav-secundaria fichas-exterior <?=$key?>" data-masonry='{ "itemSelector": ".masonry-item", "columnWidth": 200 }'>
			<?php foreach($motivo as $k=>$f): ?>
				<div class="masonry-item span3 <?php if($f['sello_chilesinpapeleo']) print "sello_chilesinpapeleo";?>">
					<?php if($f['sello_chilesinpapeleo']):?>
					<img src="http://contodo.chileatiende.cl/assets_v2/img/label_sello_chileatiende.png" class="label_chilesinpapeleo" alt="Trámite 100% digital de Chile sin papeleo">
					<?php endif;?>
					<h3><?=$f['nombre_servicio']?></h3>
					<h2><a href="http://contodo.chileatiende.cl/fichas/ver/<?php print $f['id'];?>?exterior=1"><?=$f['titulo']?></a></h2>
					<?php
					$disponible = array();
					if( isset($f['guia_correo']) && ($f['guia_correo']!='') ){
						array_push($disponible, "correo electrónico");
					}
					if(isset($f['guia_consulado']) && ($f['guia_consulado']!='') ){
						array_push($disponible, "consulado");
					}
					if( isset($f['guia_online_url']) && ($f['guia_online_url']!='') ){
						array_push($disponible, "en línea");
					}
					?>
					<?php if(sizeof($disponible)):?>
					<p>
						Disponible en:
						<?php foreach($disponible as $disp):?>
						<span class="label"><?=$disp?></span>
						<?php endforeach;?>
					</p>
					<?php endif;?>
				</div>
			<?php endforeach;?>
		</div>
		<?php endforeach;?>
		
	</div>

</div>