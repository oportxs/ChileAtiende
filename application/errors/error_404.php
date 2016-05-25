<?php
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    $site_url = 'https://www.chileatiende.gob.cl/';
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Error 404 - Página no encontrada - ChileAtiende - Personas a tu servicio</title>
        <meta name="description" content="" />
        <meta name="keywords" content="Chileatiende, chile atiende, Trámites, Trámite Fácil, Chile, Clic, ChileClick, Click, Chile, servicios, estado, Gobierno de Chile, transparencia, servicios, beneficios del Estado" />
        <meta name="author" content="" />
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="<?php echo $site_url; ?>assets_v2/css/frontend.css">

        <script src="<?php echo $site_url; ?>assets_v2/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <!--[if lt IE 9]>
            <script src="<?php echo $site_url; ?>assets_v2/js/vendor/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="">

        <?php 
        $addBuscador = false;
         include('application/views/header_internal.php'); ?>

        <div class="container">
            <div class="main-container">
                <div class="row-fluid">
                    <div class="breadcrumbs span12 no-print affix-top" data-spy="affix" data-offset-top="175">
                        <a href="<?php echo $site_url; ?>">Portada</a> / Error 404
                    </div>
                </div>
                <div id="content" class="error-404 contenido">
                    <div class="row-fluid">
                        <div class="encabezado-contenido">
                            <div class="span12">
                                <h3>Error 404 - Página no encontrada</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="main-content">
                            <div class="span3">
                                <img src="<?php echo $site_url; ?>assets_v2/img/error.png" alt="Error 404">
                            </div>
                            <div class="span9">
                                <h4>
                                    Lo sentimos<br/>
                                    La página solicitada no fue encontrada
                                </h4>
                                <p>
                                    Para solucionar éste inconveniente le recomendamos realizar alguna de las siguientes acciones.
                                </p>
                                <ul>
                                    <li>Comprobar que la dirección (URL) sea la correcta</li>
                                    <li>Dirigirse a la página inicial</li>
                                    <li>Realizar una nueva búsqueda</li>
                                </ul>
                                <div class="cont-busqueda">
                                    <form action="<?php echo $site_url; ?>buscar/fichas" method="get" id="main_search">
                                        <input accesskey="b" autofocus="autofocus" id="main_search_input" class="active_search main_search_input" autocomplete="off" name="buscar" placeholder="Ingrese su búsqueda" type="text"  />
                                        <button type="submit" accesskey="s" class="searchbtn">Buscar</button>
                                        <input type="hidden" name="e" value="">
                                    </form>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="no-print">
            <div class="footer-top">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span3 sobre-chileatiende hidden-phone">
                            <h4>Sobre ChileAtiende</h4>
                            <ul class="unstyled">
                                <li><a href="<?php echo $site_url; ?>contenidos/que-es-chileatiende" alt="Encuentra toda la información relacionada al proyecto ChileAtiende">¿Qué es ChileAtiende?</a></li>
                                <li><a href="<?php echo $site_url; ?>estadisticas" alt="Estadísticas ChileAtiende">Estadísticas</a></li>
                                <li><a href="<?php echo $site_url; ?>serviciosdisponibles" alt="Encuentra todos los servicios y beneficios  disponibles en ChileAtiende">Servicios disponibles en sucursales</a></li>
                                <li><a href="<?php echo $site_url; ?>servicios/directorio" alt="Listado de todas las instituciones en convenio con ChileAtiende">Instituciones asociadas</a></li>
                                <li><a href="<?php echo $site_url; ?>contenidos/preguntas-frecuentes" rel="help" data-ga-te-category="Acciones" data-ga-te-action="Ayuda" data-ga-te-value="Footer" alt="Preguntas Frecuentes">Preguntas frecuentes</a></li>
                            </ul>
                        </div>
                        <div class="span3 terminos-condiciones">
                            <h4>
                                Términos y condiciones
                            </h4>
                            <ul class="unstyled">
                                <li><a href="<?php echo $site_url; ?>contenido/politicadeprivacidad" alt="Política de privacidad">Política de privacidad</a></li>
                                <li><a href="<?php echo $site_url; ?>contenido/terminosycondiciones" alt="Términos de uso">Términos de uso</a></li>
                                <li><a href="<?php echo $site_url; ?>contenido/visualizadores" alt="Visualizadores">Visualizadores</a></li>
                            </ul>
                        </div>
                        <div class="span3 accesos-directos hidden-phone">
                            <h4>
                                Accesos directos
                            </h4>
                            <ul class="unstyled">
                               <li><a href="<?php echo $site_url; ?>sitemap" alt="Mapa del sitio">Mapa del sitio</a></li>
                               <li><a target="_blank" href="<?php echo $site_url; ?>desarrolladores" alt="API para desarrolladores">API para desarrolladores</a></li>
                               <li><a href="<?php echo $site_url; ?>widget" alt="ChileAtiende en tu sitio">ChileAtiende en tu sitio</a></li>
                            </ul>
                        </div>
                        <div class="span3 red-multicanal">
                            <h4>
                                Nuestra red multicanal
                            </h4>
                            <div class="lista-canales">
                                <a class="canal-twitter" href="https://twitter.com/ChileAtiende" target="_blank" alt="Twitter"></a>
                                <a class="canal-facebook" href="https://www.facebook.com/ChileAtiende" target="_blank" alt="Facebook"></a>
                                <a class="canal-oficina" href="<?php echo $site_url; ?>oficinas" alt="Puntos de atención"></a>
                                <a class="hidden-phone canal-mail" href="https://contacto.chileatiende.cl/formulario.php?origen=http://www.chileatiende.gob.cl/" data-toggle="modal-chileatiende" data-modal-type="iframe"></a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="lista-canales-callcenter">
                                <a class="canal-callcenter" href="<?php echo $site_url; ?>contenidos/callcenter" alt="Twitter">CallCenter 101</a>
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
            <img src="<?php echo $site_url; ?>assets_v2/img/sobre_esta_imagen.png" alt="Sobre esta imagen">
        </a>
        <div id="modal-chileatiende" class="modal hide fade">
        </div>
        <script type="text/javascript">
            var site_url="<?php echo $site_url; ?>";
            var base_url="<?php echo $site_url; ?>";

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-28124406-2']);
            _gaq.push(['_setDomainName', 'chileatiende.gob.cl']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

            _gaq.push(['_trackPageview']);

        </script>

        <script src="<?php echo $site_url; ?>assets_v2/js/vendor/bootstrap.js"></script>
        <script src="<?php echo $site_url; ?>assets_v2/js/vendor/jquery.cookie.min.js"></script>
        <script src="<?php echo $site_url; ?>assets_v2/js/vendor/jquery.masonry.min.js"></script>
        <script src="<?php echo $site_url; ?>assets_v2/js/vendor/rs_embhl_v2_es_419.js" type="text/javascript"></script>
        <script src="<?php echo $site_url; ?>assets_v2/js/frontend.js"></script>
    </body>
</html>
