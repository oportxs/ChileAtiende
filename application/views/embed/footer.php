<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encabezado Embedido Chileatiende</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="<?php echo base_url('assets_v2/css/frontend.css'); ?>?v=10">
</head>
<body class="no-background">
    <footer class="no-print">
        <div class="footer-top">
            <div class="container">
                <div class="row-fluid">
                    <div class="span3 sobre-chileatiende hidden-phone">
                        <h4>Sobre ChileAtiende</h4>
                        <ul class="unstyled">
                            <li><a href="<?php echo site_url('contenidos/que-es-chileatiende'); ?>" alt="Encuentra toda la información relacionada al proyecto ChileAtiende">¿Qué es ChileAtiende?</a></li>
                            <li><a href="<?php echo site_url('estadisticas'); ?>" alt="Estadísticas ChileAtiende">Estadísticas</a></li>
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
                    <div class="span3 accesos-directos hidden-phone">
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
                        <ul class="unstyled lista-canales">
                            <li class="canal-web">
                                <a href="<?php echo site_url(); ?>" alt="www.chileatiende.cl">www.chileatiende.cl</a>
                            </li>
                            <li class="canal-oficina">
                                <a href="<?php echo site_url('oficinas'); ?>" alt="Puntos de atención">Puntos de atención</a>
                            </li>
                            <li class="canal-callcenter">
                                <a class="hidden-phone" href="<?php echo site_url('contenidos/callcenter'); ?>" alt="CallCenter 101">CallCenter 101</a>
                                <a class="visible-phone" href="tel:101" alt="CallCenter 101">CallCenter 101</a>
                            </li>
                        </ul>
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
                        </div>
                    </div>
                    <div class="span4 pull-right cont-logo-footer visible-desktop">
                        <a class="gobierno-chile" target="_blank" href="http://www.gobiernodechile.cl/" alt="Gobierno de Chile">Gobierno de Chile</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        var links = $('a'),
            forms = $('form'),
            parent = window.parent;
        links.on('click', function(e){
            parent.location = this.href;
            e.preventDefault();
        });
        forms.attr('target', "_parent");
    </script>
</body>
</html>