<?php
header('X-UA-Compatible: IE=edge,chrome=1');
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        
        <title><?= $title ?> - ChileAtiende en el Exterior - Trémites para chilenos en el extranjero</title>
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
        ?>
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="<?php echo base_url('assets_v2/css/frontend.css?v=20140421'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets_v2/css/exterior.css'); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
        <script src="<?php echo base_url('assets_v2/js/vendor/jquery-1.9.1.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js'); ?>"></script>

        <script type="text/javascript">
            var site_url="<?= base_url() ?>";
            var base_url="<?= base_url() ?>";
            var current_url="<?= current_url(); ?>";
        </script>
    </head>
    <body data-spy="scroll" data-target=".nav-scrollspy">
        <?php 
        $isEmpresa = false;
        $isExterior = true;
        include('header_selector.php'); ?>
        <header class="no-print header-exterior">
            <div class="container">
                <div class="header-top">
                    <div class="row-fluid">
                        <div class="span4">
                            <h1>
                                <a href="<?php echo site_url('/empresas'); ?>">
                                    <img src="<?php echo base_url('assets_v2/img/header/chileatiende-en-el-exterior_logo.png'); ?>" alt="ChileAtiende en el Exterior">
                                </a>
                            </h1>
                        </div>
                        <div class="span8 search-bar">
                            <form action="<?= site_url('buscar/fichas') ?>" method="get" id="main_search">
                                <input accesskey="b" autofocus="autofocus" id="main_search_input" class="pull-left <?php echo (!$this->config->item("lite_mode"))?'active_search':''; ?> main_search_input" autocomplete="off" name="buscar" placeholder="Busca lo que necesitas" type="text" <?php echo (isset($hidden_string)) ? "value='" . $hidden_string . "'" : "" ?> />
                                <button type="submit" accesskey="s" class="pull-right searchbtn"><span class="fa fa-search" aria-hidden="true"></span> Buscar</button>
                                <input type="hidden" name="e" value="<?php echo $hidden_buscador ?>">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="layer-sitio-inactivo"></div>
            </div>
        </header>
        <div class="container main-container <?php echo (isset($esPortada))? 'esPortada' : '' ?>">
            <?php $this->load->view($content); ?>
            <div class="layer-sitio-inactivo">
                <div class="modal-inactivo">
                    ¿Eres un emprendedor?<br>Pronto podrás acceder a más contenidos para tu empresa.
                </div>
            </div>
        </div>
        <footer class="no-print">
            <div class="footer-top">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span4 sobre-chileatiende">
                            <h4>
                                Sobre ChileAtiende en el Exterior
                            </h4>
                            <ul class="unstyled">
                                <li><a href="<?= base_url('contenidos/que-es-chileatiendepymes')."?e=1" ?>">¿Qué es ChileAtiende en el Exterior?</a></li>
                                <li><a href="<?= base_url('contenido/politicadeprivacidad') ?>">Servicios disponibles en Consulados</a></li>
                                <li><a href="<?= base_url('contenidos/terminos-y-condiciones-de-uso-pymes') ?>">Instituciones Asociadas</a></li>
                                <li><a href="<?= base_url('contenidos/preguntas-frecuentes') ?>">Preguntas Frecuentes</a></li>
                            </ul>
                        </div>
                        <div class="span4 terminos-condiciones">
                            <h4>
                                Términos y Condiciones
                            </h4>
                            <ul class="unstyled">
                                <li><a href="<?= base_url('contenido/politicadeprivacidad') ?>">Política de Privacidad</a></li>
                                <li><a href="<?= base_url('contenidos/terminosycondiciones') ?>">Términos de Uso</a></li>
                                <li><a href="<?= base_url('/sitemap') ?>" title="Mapa del Sitio">Mapa del Sitio</a></li>
                                <li><a href="<?= base_url('contenido/visualizadores') ?>">Herramientas de visualización de datos</a></li>
                            </ul>
                        </div>
                        <div class="span4 accesos-directos">
                            <h4>
                                Nuestra Red de Atención
                            </h4>
                            <div class="row-fluid">
                                <div class="span1">CASA</div>
                                <div class="span1">MAIL</div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="footer-bottom visible-desktop">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span4">
                            <ul>
                                <li class="creative-commons"><a href="http://creativecommons.org/licenses/by/3.0/cl/" title="Creative Commons">CC BY 3.0</a></li>
                            </ul>
                            <div class="modernizacion">
                                <a href="http://www.economia.gob.cl/acerca-de/autoridades/jefes-de-divisiones/emt/" target="_blank">División Empresas de Menor Tamaño</a><br />
                                Ministerio de Economía, Fomento y Turismo<br/>
                                <span>Portal en <span class="label label-info">BETA</span></span><br />
                            </div>
                        </div>
                        <div class="span4 offset4 cont-logo-footer">
                            <a class="gobierno-chile" target="_blank" href="http://www.gobiernodechile.cl/">Gobierno de Chile</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <a href="http://www.imagendechile.cl/" target="_blank" class="sobre-esta-imagen visible-desktop">
            <img src="<?php echo base_url('assets_v2/img/sobre_esta_imagen.png'); ?>" alt="Sobre esta imagen">
        </a>
        <div id="modal-chileatiende" class="modal hide fade">
        </div>
        <script src="<?php echo base_url('assets_v2/js/vendor/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/vendor/jquery.cookie.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/frontend.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/emprendete.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/vendor/rs_embhl_v2_es_419.js') ?>" type="text/javascript"></script>
        <script>
            var _gaq = _gaq || [];
            var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';
            _gaq.push(['_require', 'inpage_linkid', pluginUrl]);
            _gaq.push(['_setAccount', 'UA-28124406-2']);
            _gaq.push(['_setDomainName', 'chileatiende.gob.cl']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
    </body>
</html>
