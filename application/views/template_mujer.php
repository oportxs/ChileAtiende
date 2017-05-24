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
        
        <title><?= $title ?> - ChileAtiende Mujer</title>
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
        <link rel="stylesheet" href="<?php echo base_url('assets_v2/css/mujer.css?v=20170522'); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
        <script src="<?php echo base_url('assets_v2/js/vendor/jquery-1.9.1.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js'); ?>"></script>

        <script type="text/javascript">
            var site_url="<?= base_url() ?>";
            var base_url="<?= base_url() ?>";
            var current_url="<?= current_url(); ?>";
        </script>
    </head>
    <?php if(isset($ficha->objetivo)){ ?>
        <body class="body-ficha-mujer" data-spy="scroll" data-target=".nav-scrollspy">
    <?php }else{ ?>
        <body data-spy="scroll" data-target=".nav-scrollspy">
    <?php } ?>
        <?php 
        $isMujer = true;
        include('header_selector.php'); ?>
        <?php if(isset($ficha->objetivo)){ ?>
            <header class="no-print header-mujer-home">
        <?php }else{ ?>
            <header class="no-print header-mujer">
        <?php } ?>
        
            <div class="container">
                <div class="header-top">
                    <div class="row-fluid">
                        <div class="span7">
                            <h1>
                                <a href="<?php echo site_url('/mujer'); ?>">
                                    <img src="<?php echo base_url('assets_v2/img/header/chileatiende-en-el-mujer_logo.png'); ?>" alt="ChileAtiende Mujer">
                                </a>
                            </h1>
                        </div>
                        <div class="span5 search-bar">
                            <form action="<?= site_url('buscar/fichas') ?>" method="get" id="main_search">
                                <input style="border: none !important" accesskey="b" autofocus="autofocus" id="main_search_input" class="pull-left <?php echo (!$this->config->item("lite_mode"))?'active_search':''; ?> main_search_input" autocomplete="off" name="buscar" placeholder="Busca lo que necesitas..." type="text" <?php echo (isset($hidden_string)) ? "value='" . $hidden_string . "'" : "" ?> />
                                <button type="submit" accesskey="s" class="pull-right searchbtn"><span class="fa fa-search" aria-hidden="true"></span></button>
                                <input type="hidden" name="e" value="2">
                            </form>
                            <?php if(count($tramites_mujer_destacado)>0): ?>
                            <div class="section-destacados">
                                <div class="destacados-mujer-title">
                                Destacados
                                </div>
                            <?php
                                foreach ($tramites_mujer_destacado as $key => $value) {
                            ?>
                                <div class="destacados-mujer">
                                    <a href="/fichas/ver/<?php print $value['id'];?>?mujer=1">
                                        <?php echo $value['titulo']; ?>
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>    
                                    </a>
                                </div>
                            <?php
                                }
                            ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="layer-sitio-inactivo"></div>
            </div>
        </header>
        <div class="container main-container <?php echo (isset($esPortada))? 'esPortada' : '' ?>">
            <?php $this->load->view($content); ?>
        </div>
        <footer class="no-print">
            <div class="footer-top">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span3 sobre-chileatiende hidden-phone">
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
        <a href="http://www.imagendechile.cl/" target="_blank" class="sobre-esta-imagen visible-desktop">
            <img src="<?php echo base_url('assets_v2/img/sobre_esta_imagen.png'); ?>" alt="Sobre esta imagen">
        </a>
        <div id="modal-chileatiende" class="modal hide fade">
        </div>
        <script src="<?php echo base_url('assets_v2/js/vendor/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/vendor/jquery.cookie.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/vendor/jquery.masonry.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/vendor/imagesloaded.pkgd.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/frontend.js'); ?>"></script>
        <script src="<?php echo base_url('assets_v2/js/mujer.js'); ?>"></script>
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
