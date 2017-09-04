<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="es"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="es"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es"> <!--<![endif]-->
    <head>        
        <?php if (isset($codigoMarcaTestAB)): ?>
            <!-- Google Analytics Content Experiment code -->
                <script>_udn="chileatiende.cl";</script>
                <script>function utmx_section(){}function utmx(){}(function(){var
                k='54672718-<?php echo $codigoMarcaTestAB; ?>',d=document,l=d.location,c=d.cookie;
                if(l.search.indexOf('utm_expid='+k)>0)return;
                function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
                indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
                length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
                '<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':
                '://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
                '&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
                valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
                '" type="text/javascript" charset="utf-8"><\/sc'+'ript>')})();
                </script><script>utmx('url','A/B');</script>
            <!-- End of Google Analytics Content Experiment code -->
        <?php endif ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <?php if ($title): ?>
            <title><?= $title ?> - ChileAtiende - Personas a tu servicio</title>
        <?php else: ?>
            <title>ChileAtiende - Personas a tu servicio</title>
        <?php endif ?>
        <link rel="icon" type="image/x-icon" href="<?=base_url()?>assets_v2/img/favicon.ico" />
        <?php
        if (isset($descripcion)) {
            ?>
            <meta name="description" content="<?= $descripcion ?>" />
            <meta name="keywords" content="<?= $keywords ?>" />
            <meta name="author" content="<?= $autor ?>" />
            <?php
        } else { //cuando se encuentra en la ficha
            ?>
            <meta name="description" content="<?php echo ( (isset($ficha->objetivo) ) ? mb_substr(strip_tags($ficha->objetivo),0,300) : '' ); ?>" />
            <meta name="keywords" content="<?php echo ( (isset($ficha->keywords) && ($ficha->keywords) ) ? $ficha->keywords.' ' : '' ); echo Doctrine::getTable('Configuracion')->find('keywords') ? Doctrine::getTable('Configuracion')->find('keywords')->valor : ''; ?>" />
            <meta name="author" content="<?php echo ( ( isset($ficha->Servicio->nombre) ) ? $ficha->Servicio->nombre : '') ; ?>" />
            <?php
        }

        if(isset($ficha->es_tramite_mujer) && $ficha->es_tramite_mujer == 1){
            $isMujer = true;
        }

        ?>
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="<?php echo base_url('assets_v2/css/frontend.css'); ?>?v=2017081601">
        <?php echo isset($assets) ? loadAssets($assets, 'css') : ''; ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
        <link rel="apple-touch-icon" href="<?php echo base_url('assets_v2/img/touch-icon-iphone.png'); ?>" />
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url('assets_v2/img/touch-icon-ipad.png'); ?>" />
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url('assets_v2/img/touch-icon-iphone-retina.png'); ?>" />
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url('assets_v2/img/touch-icon-ipad-retina.png'); ?>" />

        <script src="<?php echo base_url('assets_v2/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js'); ?>"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <!--[if lt IE 9]>
            <script src="<?php echo base_url('assets_v2/js/vendor'); ?>/respond.min.js"></script>
        <![endif]-->
    </head>
    <body data-spy="scroll" data-target=".contenedor-menu-ficha" class="<?php echo isset($esPortada)?' portada':''; ?><?php echo $this->session->userdata('id_modulo')?' tiene-barra-campana':''; ?>">

        <!-- HEADER -->

        <?php if (isset($esPortada)): ?>
            <?php include('header_home.php'); ?>
        <?php else: ?>
            <?php include('header_internal.php'); ?>
        <?php endif ?>

        <div class="container">
                <?php if (isset($esPortada)): ?>
                    <div class="front-container-portada">
                        <?php echo getAlertasUrl(); ?>
                        <?php $this->load->view($content); ?>
                    </div>
                <?php else: ?>
                    <div class="main-container">
                        <?php $this->load->view($content); ?>
                    </div>
                <?php endif ?>
            <div>
                <div class="row-fluid visible-phone">
                    <div class="span12" style="text-align: center; padding: 10px;">
                        <div style="width: 100%;" class="btn-group atencion-consultas-dropdown">
                          <a style="width: calc(100% - 40px);" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                            Atención y Consultas
                            <span class="caret"></span>
                          </a>
                          <ul class="dropdown-menu" style="width: 100%; background-color: #2168a8;">
                            <li class="internal-shortcut" style="text-align: left">
                                <a style="color: white !important" class="btn-primary" href="<?php echo config_item('base_url').'contenidos/en-linea'; ?>" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="En línea">
                                <img width="40" src="<?php echo config_item('base_url').'assets_v2/img/nueva_home/ico_digital.png'; ?>" />
                                <span>En línea</span></a>
                            </li>
                            <li class="internal-shortcut" style="text-align: left">
                                <a style="color: white !important" class="btn-primary" href="<?php echo config_item('base_url').'contenidos/callcenter'; ?>" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="101">
                                <img width="40" src="<?php echo config_item('base_url').'assets_v2/img/nueva_home/ico_101.png'; ?>" />
                                <span>101</span></a>
                            </li>
                            <li class="internal-shortcut" style="text-align: left">
                                <a style="color: white !important" class="btn-primary" href="<?php echo config_item('base_url').'contenidos/oficinamovil'; ?>" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="Oficinas móviles">
                                <img width="40" src="<?php echo config_item('base_url').'assets_v2/img/nueva_home/ico_movil.png'; ?>" />
                                <span>Oficinas móviles</span></a>
                            </li>
                            <li class="internal-shortcut" style="text-align: left">
                                <a style="color: white !important" class="btn-primary" href="<?php echo config_item('base_url').'oficinas'; ?>" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="Puntos de atención">
                                <img width="40" src="<?php echo config_item('base_url').'assets_v2/img/nueva_home/ico_sucursales.png'; ?>" />
                                <span>Sucursales</span></a>
                            </li>
                            <li class="internal-shortcut" style="text-align: left">
                                <a style="color: white !important" class="btn-primary" href="<?php echo config_item('base_url').'contenidos/preguntas-frecuentes'; ?>" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="Preguntas Frecuentes">
                                <img width="30" src="<?php echo config_item('base_url').'assets_v2/img/nueva_home/ico_preguntas-frecuentes.png'; ?>" />
                                <span>Preguntas Frecuentes</span></a>
                            </li>
                            <!-- <li class="internal-shortcut lista-contactos">
                                <div class="row-fluid">
                                    <div class="span4 text-center">
                                        <a class="contactos-facebook" href="https://www.facebook.com/ChileAtiende" target="_blank" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="Facebook">Facebook</a>
                                    </div>
                                    <div class="span4 text-center">
                                        <a class="contactos-twitter" href="https://twitter.com/ChileAtiende" target="_blank" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="Twitter">Twitter</a>
                                    </div>
                                    <div class="span4 text-center">
                                        <a class="contactos-correo hidden-phone" href="https://www.chileatiende.gob.cl/contacto/formulario.php?origen=http://www.chileatiende.gob.cl/" data-toggle="modal-chileatiende" data-modal-type="iframe" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="Contacto">Contacto</a>
                                        <a class="visible-phone contactos-correo" href="https://www.chileatiende.gob.cl/contacto/formulario.php?origen=http://www.chileatiende.gob.cl/" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="Contacto">Contacto</a>
                                    </div>
                                </div>
                            </li> -->
                          </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="no-print">
            <div class="footer-top">
                <div class="container">
                    <div class="row-fluid visible-phone">
                        <div class="terminos-condiciones">
                            <h4>
                                Términos y condiciones
                            </h4>
                            <ul class="unstyled">
                                <li><a href="<?= site_url('contenido/politicadeprivacidad') ?>" alt="Política de privacidad">Política de privacidad</a></li>
                                <li><a href="<?= site_url('contenido/terminosycondiciones') ?>" alt="Términos de uso">Términos de uso</a></li>
                                <li><a href="<?= site_url('contenido/visualizadores') ?>" alt="Visualizadores">Visualizadores</a></li>
                            </ul>
                        </div>
                        <div class="red-multicanal">
                            <h4>
                                Nuestra red multicanal
                            </h4>
                            <div class="lista-canales" style="margin-left: 0px;">
                                <a class="canal-twitter" href="https://twitter.com/ChileAtiende" target="_blank" alt="Twitter"></a>
                                <a class="canal-facebook" href="https://www.facebook.com/ChileAtiende" target="_blank" alt="Facebook"></a>
                                <a class="canal-oficina" href="<?php echo site_url('oficinas'); ?>" alt="Puntos de atención"></a>
                                <a class="hidden-phone canal-mail" href="https://www.chileatiende.gob.cl/contacto/formulario.php?origen=http://www.chileatiende.gob.cl/" data-toggle="modal-chileatiende" data-modal-type="iframe"></a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="lista-canales-callcenter" style="margin-left: 0px;">
                                <a class="canal-callcenter" href="<?php echo site_url('contenidos/callcenter'); ?>" alt="Twitter">CallCenter 101</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="row-fluid hidden-phone">
                        <div class="span3 sobre-chileatiende">
                            <h4>Sobre ChileAtiende</h4>
                            <ul class="unstyled">
                                <li><a href="<?php echo site_url('contenidos/que-es-chileatiende'); ?>" alt="Encuentra toda la información relacionada al proyecto ChileAtiende">¿Qué es ChileAtiende?</a></li>
                                <li><a href="<?php echo site_url('serviciosdisponibles'); ?>" alt="Encuentra todos los servicios y beneficios  disponibles en ChileAtiende">Servicios disponibles en sucursales</a></li>
                                <li><a href="<?php echo site_url('servicios/directorio/') ?>" alt="Listado de todas las instituciones en convenio con ChileAtiende">Instituciones asociadas</a></li>
                                <li><a href="<?php echo site_url('contenidos/preguntas-frecuentes'); ?>" rel="help" data-ga-te-category="Acciones" data-ga-te-action="Ayuda" data-ga-te-value="Footer" alt="Preguntas Frecuentes">Preguntas frecuentes</a></li>
                            </ul>
                        </div>
                        <div class="span3 terminos-condiciones">
                            <h4>
                                Términos y condiciones
                            </h4>
                            <ul class="unstyled">
                                <li><a href="<?= site_url('contenido/politicadeprivacidad') ?>" alt="Política de privacidad">Política de privacidad</a></li>
                                <li><a href="<?= site_url('contenido/terminosycondiciones') ?>" alt="Términos de uso">Términos de uso</a></li>
                                <li><a href="<?= site_url('contenido/visualizadores') ?>" alt="Visualizadores">Visualizadores</a></li>
                            </ul>
                        </div>
                        <div class="span3 accesos-directos">
                            <h4>
                                Accesos directos
                            </h4>
                            <ul class="unstyled">
                               <li><a href="<?= base_url('/sitemap') ?>" alt="Mapa del sitio">Mapa del sitio</a></li>
                               <li><a target="_blank" href="<?= base_url('/desarrolladores/') ?>" alt="API para desarrolladores">API para desarrolladores</a></li>
                               <li><a href="<?= base_url('/widget/') ?>" alt="ChileAtiende en tu sitio">ChileAtiende en tu sitio</a></li>
                            </ul>
                        </div>
                        <div class="span3 red-multicanal">
                            <h4>
                                Nuestra red multicanal
                            </h4>
                            <div class="lista-canales">
                                <a class="canal-twitter" href="https://twitter.com/ChileAtiende" target="_blank" alt="Twitter"></a>
                                <a class="canal-facebook" href="https://www.facebook.com/ChileAtiende" target="_blank" alt="Facebook"></a>
                                <a class="canal-oficina" href="<?php echo site_url('oficinas'); ?>" alt="Puntos de atención"></a>
                                <a class="hidden-phone canal-mail" href="https://www.chileatiende.gob.cl/contacto/formulario.php?origen=http://www.chileatiende.gob.cl/" data-toggle="modal-chileatiende" data-modal-type="iframe"></a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="lista-canales-callcenter">
                                <a class="canal-callcenter" href="<?php echo site_url('contenidos/callcenter'); ?>" alt="Twitter">CallCenter 101</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span8">
                            <ul>
                                <li class="creative-commons"><a href="http://creativecommons.org/licenses/by/3.0/cl/" alt="Creative Commons">CC BY 3.0</a></li>
                            </ul>
                            <div class="modernizacion">
                                <span>ChileAtiende es una marca registrada por: <a href="http://www.ips.gob.cl/" target="_blank" alt="Instituto de Previsión Social (MINTRAB)">Instituto de Previsión Social (MINTRAB)</a></span><br />
                                <span>Portal desarrollado por: <a href="http://www.modernizacion.gob.cl" target="_blank" alt="Unidad de modernización y gobierno digital">Unidad de modernización y gobierno digital </a><a href="http://www.modernizacion.gob.cl" target="_blank" alt="Ministerio Secretaría General de la Presidencia">(MINSEGPRES)</a></span><br />
                                <span>Portal en <span class="label label-info">BETA</span></span><br />
                            </div>
                        </div>
                        <div class="span4 pull-right cont-logo-footer visible-desktop">
                            <a class="gobierno-chile" target="_blank" href="http://www.gobiernodechile.cl/" alt="Gobierno de Chile">Gobierno de Chile</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- fondo_7  https://www.flickr.com/photos/stuckincustoms/3410783929/in/photolist-6cpaet-4ipxpv-qkRi2-pdbBa-hdfub-g2dNM-eYHEk-d1RyE-czVDy-c5iRx-bnH5S-dJZDWo-4RxcG8-jjRCQ-edPDSu-e46uko-dTzEcC-dQg5j7-dFx5a4-dB63aF-aTxszF-8JBJb4-7Vv4ks-7HRj55-7DLkTv-7B3ov4-7qzUSW-7ayEja-6RcAQ2-6LEbYs-6B5oYF-6wuWue-6bTA2B-5LRcX2-4TApkj-4GGyAH-47juCF-PMChv-CaQzd-ycupB-x9vi8-jTBjs-iJcSg-bBHBD-9em6u-9WtQcH-7wMAB5-5WZLzz-7vNJcY-4FVZZ8/ -->
        <a href="https://www.flickr.com/photos/39997856@N03/11398105296" target="_blank" class="sobre-esta-imagen" id="link-sobre-esta-imagen">
            <img src="<?php echo base_url('assets_v2/img/sobre_esta_imagen.png'); ?>" alt="Sobre esta imagen">
        </a>
        <div id="modal-chileatiende" class="modal hide fade">
        </div>
        <?php if (isset($display_mod_atencion) && $display_mod_atencion): ?>
            <div id="cont-modal-oficinas">
                <?php $this->load->view("moduloatencion/modal_oficinas"); ?>
            </div>
        <?php endif ?>
        <div id="cont-barra-modulo-atencion"></div>
        <script type="text/javascript">
            var site_url="<?= base_url() ?>";
            var base_url="<?= base_url() ?>";
            var current_url="<?= current_url(); ?>";
        </script>

        <script src="<?php echo base_url('assets_v2/js/vendor/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/vendor/jquery.cookie.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/vendor/jquery.masonry.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/vendor/imagesloaded.pkgd.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/vendor/md5.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/frontend.js'); ?>?v=20160707"></script>

        <script type="text/javascript">

            var _gaq = _gaq || [];
            var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';
            _gaq.push(['_require', 'inpage_linkid', pluginUrl]);
            _gaq.push(['_setAccount', 'UA-28124406-2']);
            _gaq.push(['_setDomainName', 'chileatiende.gob.cl']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
        <script>
            //Se maraca el origen de navegación en el sitio
            var origen_navegacion = $.cookie('origen_navegacion') || '';
            _gaq.push(['_setCustomVar', 3, 'origen_navegacion', origen_navegacion, 2]);
            if($.cookie('id_modulo') && $.cookie('id_modulo') != 'null'){
                var id_modulo = $.cookie('id_modulo'),
                    url_barra_modulo = '<?php echo site_url("portada/barramodulo"); ?>/'+id_modulo+'/1';

                $('#cont-barra-modulo-atencion').load(url_barra_modulo, function () {
                    $(this).on('click', '.accionModulo a', function (e) {
                        $.cookie('id_modulo', null, {path: '/'});
                        window.location = this.href;
                        e.preventDefault();
                    });
                    //El trackPageView se debe hacer despúes de inclur las customVars de la barra de modulos de autoatencion
                    _gaq.push(['_trackPageview']);
                });
            }else{
                if($('#cont-modal-oficinas').length){
                    $('#modal-moduloatencion').modal();
                    $('#modal-moduloatencion').on('submit', 'form', function (e) {
                        $.cookie('id_modulo', $(this).find('#id_modulo').val(), {path: '/'});
                        window.location = $(this).attr('action');
                        e.preventDefault();
                    });
                }
                //Si no se está cargando la barra del modulo de autoatencion, se marca la pagina
                _gaq.push(['_trackPageview']);
            }
        </script>

        <?php echo isset($assets) ? loadAssets($assets, 'js') : ''; ?>

        <div id="survey-modal" class="modal hide fade" tabindex="-1" role="dialog">
          <iframe name="hidden_iframe" id="hidden_iframe" style="display:none;" onload="if(submitted)"></iframe>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="close-modal">×</button>
              <h3>Nos interesa tu opinión</h3>
          </div>
          <div class="modal-body">
              <!-- <iframe id="gform" src="" height="250" frameborder="0"></iframe> -->
              <img src="/assets_v2/img/gob_cl.png">
              <form id="gform" 
                    class="form" 
                    target="hidden_iframe"
                    onsubmit="submitted=true;" 
                    action="https://docs.google.com/forms/d/e/1FAIpQLSdvAUG_4qXXNq17BC9q1dqt1yKKk42eICw8WuClElXs78LdZw/formResponse">
                <h4>Déjanos tu email para contactarte y tener tu opinión y evaluación de nuestro canal web</h4>
                <div class="form-group">
                    <label>e-mail</label>
                    <input class="input" id="gform-email" name="entry.175042737" type="email" required placeholder="ejemplo@dominio.com"/>
                </div>
                <div class="form-group">
                    <label>Región</label>
                    <select class="input" name="entry.879761844">
                      <option value="Región Metropolitana" selected="selected">Región Metropolitana</option>
                      <option value="Arica y Parinacota">Arica y Parinacota</option>
                      <option value="Tarapacá">Tarapacá</option>
                      <option value="Antofagasta">Antofagasta</option>
                      <option value="Atacama">Atacama</option>
                      <option value="Coquimbo">Coquimbo</option>
                      <option value="Valparaiso">Valparaiso</option>
                      <option value="O'Higgins">O'Higgins</option>
                      <option value="Tarapacá">Maule</option>
                      <option value="Biobío">Biobío</option>
                      <option value="La Araucanía">La Araucanía</option>
                      <option value="Los Ríos">Los Ríos</option>
                      <option value="Los Lagos">Los Lagos</option>
                      <option value="Aysen">Aysén</option>
                      <option value="Magallanes y Antártica">Magallanes y Antártica</option>
                    </select>
                </div>
                <div class="form-group text-right">
                    <input class="form-submit btn btn-primary" id="gform-submit" type="submit" value="Deseo participar"/>
                    <!-- <input class="form-submit btn btn-secondary" data-dismiss="modal" type="button" value="No deseo participar"/> -->
                </div>
            </form>

          </div>
          <!-- <div class="modal-footer">
            <button class="btn" data-dismiss="modal">Cerrar</button>
          </div> -->
        </div>

        <script src="/assets_v2/js/ReadSpeaker.js?pids=embhl" type="text/javascript"></script>
        <script src="/assets_v2/js/survey.js" type="text/javascript"></script>

    </body>
</html>
