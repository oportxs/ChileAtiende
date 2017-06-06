<div class="background span12"></div>
<div class="contenedor-principal">	
	<div class="header-search cont-busqueda"></div>
	<div class="row-fluid">
		<div class="span12 nav-secundaria-movil fichas-mujer <?=$key?>" data-masonry='{ "itemSelector": ".masonry-item", "columnWidth": 200 }'>
			<?php  
				foreach($tramites_mujer as $key=>$f): 
			?>
			  <div class="mujer-box masonry-item span3 <?php if($f['sello_chilesinpapeleo']) print "sello_chilesinpapeleo";?>">
					<?php if($f['sello_chilesinpapeleo']):?>
					<img src="/assets_v2/img/label_sello_chileatiende.png" class="label_chilesinpapeleo" alt="Trámite 100% digital de Chile sin papeleo">
					<?php endif;?>
					<h3><?php echo $f['nombre_servicio']; ?></h3>
					<h2><a href="/fichas/ver/<?php echo $f['maestro_id'];?>?mujer=1"><?=$f['titulo']?></a></h2>
					<?php
					$disponible = array();
					if( isset($f['guia_correo']) && ($f['guia_correo']!='') ){
						array_push($disponible, "por correo electrónico");
					}
					if(isset($f['guia_consulado']) && ($f['guia_consulado']!='') ){
						array_push($disponible, "en consulado");
					}
					if( isset($f['guia_online_url']) && ($f['guia_online_url']!='') ){
						array_push($disponible, "en línea");
					}
					if( isset($f['guia_oficina']) && ($f['guia_oficina']!='') ){
						array_push($disponible, "en oficina en Chile");
					}
					?>
					<?php if(sizeof($disponible)):?>
					<p>
						Disponible:
						<?php foreach($disponible as $disp):?>
						<span class="label"><?=$disp?></span>
						<?php endforeach;?>
					</p>
					<?php endif;?>
				</div>
			<?php endforeach;?>
		</div>		
	</div>
</div>
