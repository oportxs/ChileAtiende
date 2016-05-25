<!DOCTYPE HTML>
<html lang="es-CL">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="<?php echo site_url('assets/css/map.css'); ?>">	
	</head>
	<body>
		<div id="map">
			<script>window.jQuery || document.write('<script src="<?php echo site_url('assets/js/jquery-1.7.1.min.js'); ?>"><\/script>')</script>
			<script>window.google || document.write('<script src="https://maps.googleapis.com/maps/api/js?sensor=false"><\/script>')</script>
			<script type="text/javascript">
				if (window!=window.top) {
					window.document.body.style.margin = 0;
					window.document.body.style.padding = 0;
				}	
			</script>
		  <script type="text/javascript">
		    $(document).ready(function(){
		    	var site_url = '<?php echo site_url(''); ?>';
		    	var comuna_seleccionada = '<?php echo $comuna_seleccionada; ?>';
                var id_oficina = marcador_seleccionado = lat_ofi = lng_ofi = null;
                <?php if($oficina_seleccionada){ ?>
                    id_oficina = '<?php echo $oficina_seleccionada->id; ?>';
                    lat_ofi = '<?php echo $oficina_seleccionada->lat; ?>';
                    lng_ofi = '<?php echo $oficina_seleccionada->lng; ?>';
                <?php } ?>
		    	var _z = <?php echo $zoom; ?>;

		      var myOptions = {
		        scaleControl: true,
		        streetViewControl: false,
		        center: new google.maps.LatLng(-33.444593,-70.653591),
		        zoom: _z,
		        mapTypeId: google.maps.MapTypeId.ROADMAP,
		        scrollwheel: false
		      };

		      var map = new google.maps.Map(document.getElementById('map_canvas'),
		      myOptions);

		      var image = '<?php echo site_url('assets/images/punto.png'); ?>';
		      var image_pyme = '<?php echo site_url('assets/images/punto_pyme.png'); ?>';

					<?php foreach ($oficinas as $o): ?>
					  marker = new google.maps.Marker({
					      id: <?= $o->id ?>,
					      map: map,
					      position: new google.maps.LatLng(<?= $o->lat ?>, <?= $o->lng ?>),
					      icon: <?php echo $o->tipo == 'empresas' ? 'image_pyme' : 'image'; ?>,
					      title: "<?= $o->nombre ?>"
					  });
					  google.maps.event.addListener(marker, 'click', function() {
					      var marcador=this;
					      $.get(site_url+"oficinas/ajax_load_infowindow/"+marcador.id,function(response){
					          var infowindow = new google.maps.InfoWindow({
					              content: response,
					              maxWidth: 400
					          });
					          infowindow.open(map,marcador);
					      });
					  });
                      if(id_oficina == '<?php echo $o->id; ?>'){
                        marcador_seleccionado = marker; 
                      }
					<?php endforeach; ?>

			    $("select[name=comuna]").change(function(){
			    	var idComuna = $(this).attr('value'),
			    		nombreComuna = $(this).find('option[value="'+idComuna+'"]').data('nombre');
			      $.getJSON(site_url+"sectores/ajax_get_info/"+idComuna,function(response){
			          map.panTo(new google.maps.LatLng(response.lat, response.lng));
			          map.setZoom(_z)
			      });
			    });

			    $("#comunair").click( function(e){
			    	var idComuna = $("#comuna").attr('value'),
			    		nombreComuna = $("#comuna").find('option[value="'+idComuna+'"]').data('nombre');
			      e.preventDefault();
			      $.getJSON(site_url+"sectores/ajax_get_info/"+idComuna,function(response){
			          map.panTo(new google.maps.LatLng(response.lat, response.lng));
			          map.setZoom(_z)
			      });
			    });
                if(id_oficina){
                    map.panTo(new google.maps.LatLng(lat_ofi, lng_ofi));
                    map.setZoom(_z)
                }
			    if(comuna_seleccionada!='' && id_oficina){
			    	if($("select[name=comuna]").length)
			    		$("select[name=comuna]").val(comuna_seleccionada);

			    	$.getJSON(site_url+"sectores/ajax_get_info/"+comuna_seleccionada,function(response){
			          map.panTo(new google.maps.LatLng(response.lat, response.lng));
			          map.setZoom(_z)
			      });
			    }
                if(marcador_seleccionado)
                    google.maps.event.trigger(marcador_seleccionado, 'click');
			  });

				var _gaq = _gaq || [];
		    _gaq.push(['_setAccount', 'UA-28124406-2']);
		    _gaq.push(['_trackPageview']);
		    _gaq.push(['_setCustomVar', 1, 'MapaEmbedido', '<?php echo $dominio; ?>', 1]);
		    
		    (function() {
		        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		    })();
		    
			</script>
			<?php if($titulo){ ?>
				<div class="tramites_frecuentes_subtitulo">Puntos de atención ChileAtiende</div>
			<?php } ?>
			<?php if($filtros){ ?>
				<div class="comuna">Selecciona una comuna
				  <form id="form1" name="form1" method="post" action="<?= site_url('/') ?>">
				    <label for="comuna">
				      <select name="comuna" id="comuna">
				        <option>Seleccionar...</option>
				        <?php foreach ($comunas as $c): ?>
				          <option value="<?= $c->codigo ?>" data-nombre="<?= $c->nombre ?>"><?= $c->nombre ?> (<?= ($c->noficinas>1) ? $c->noficinas.' puntos de atención' : $c->noficinas.' punto de atención' ?>)</option>
				        <?php endforeach; ?>
				      </select>
				    </label>
				    <input type="submit" id="comunair" value="Ir" />
				  </form>
				</div>
			<?php } ?>
		  <div align="center" id="map_canvas" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px; border-bottom: 1px solid #ccc;" /></div>
          <?php if(!$oficina_seleccionada){ ?>
		  <div class="cont-link-chileatiende">
				<a target="_blank" href="http://www.chileatiende.gob.cl/">Ir a ChileAtiende</a>
			</div>
            <?php } ?>
		</div>
	</body>
</html>