<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= $title ?> - ChileAtiende Pymes - Al servicio de los emprendedores</title>
        <base href="<?= base_url() ?>" />
        <meta name="google-site-verification" content="" />
        <meta http-equiv="Content-Language" content="es-CL" />
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
        <link rel="alternate" type="application/rss+xml" title="Destacamos en Emprendete Chile" href="<?php echo base_url('rss/destacadas'); ?>" />
        <link rel="alternate" type="application/rss+xml" title="Más vistos esta semana en Emprendete Chile" href="<?php echo base_url('rss/masvistas'); ?>" />
        <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.ico') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/reset.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/emprendete/frontend.css') ?>" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/emprendete/css.css') ?>" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery.hoverscroll.css') ?>" media="screen" />
        <link rel="stylesheet" href="<?= base_url('assets/css/print.css" type="text/css') ?>" media="print" />
        <link type="text/plain" rel="author" href="<?= base_url('assets/humans.txt') ?>" />
        <script type="text/javascript" src="<?= base_url('assets/js/modernizr-latest.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery-1.7.1.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.iconmenu.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.hoverscroll.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.placeholder/jquery.placeholder-1.0.1.js') ?>" ></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery-tools/jquery-tools-1.2.5.js') ?>" ></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.cookie/jquery.cookie.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.raty/js/jquery.raty.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.waitforimages.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/qtip/jquery.qtip.min.js') ?>"></script>
        <script src="<? echo base_url('assets/js/rs_embhl_v2_es_419.js') ?>" type="text/javascript"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
            var site_url="<?= base_url() ?>";
            var base_url="<?= base_url() ?>";
        </script>
        <script type="text/javascript" src="<?= base_url('assets/js/script.js') ?>" ></script>
        <script type="text/javascript" src="<?= base_url('assets/js/frontend.js') ?>" ></script>

    </head>

    <body class="oneColFixCtr">
        <div id="header">
            <div class="header_content">
                <?php
                $home_url = (isset($perfil) && $perfil == "empresas") ? base_url('/empresas/') : base_url('/');
                ?>
                <div class="logo">
                    <h1><a href="<?= base_url('/') ?>" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Home','Header']);">Portal Servicios Estado</a></h1>
                </div>
                <img class="logoPrint" alt="ChileAtiende Pymes - Al servicio de los emprendedores" src="assets/images/logo_chile_atiende.png" />
                <div class="perfil">
                    ¿Qué eres?
                    <a href="<?= base_url('/') ?>" class="personas" accesskey="p" title="Personas (alt+p)">Personas</a><a href="<?= base_url('/empresas') ?>" class="organizacionesOn" accesskey="o" title="Empresas y Organizaciones (alt+o)">Empresas y Organizaciones</a>
                </div>
                <div class="funciones">
                    <a href="<?= base_url("/"); ?>#" class="overlay correo" rel="#formacontacto"><img src="<?= base_url('assets/images/header/correo.png') ?>" alt="Contacto" />Contacto</a> <a href="http://info.chileatiende.cl/preguntas-frecuentes/" class="ayuda"><img src="<?= base_url('assets/images/header/ayuda.png') ?>" alt="Ayuda" /> Ayuda</a>
                </div>

             <?php
                $nroFichas = Doctrine::getTable('Ficha')->totalPublicados();
                $nroFichas = ( substr($nroFichas, -1) > 0 ) ? $nroFichas - substr($nroFichas, -1) : $nroFichas;
                ?>
                <style>
                    .submenu {
                        float: right;
                    }
                    .submenu ul li {
                        display: inline-block;
                        padding-top: 15px;
                        padding-left: 15px;
                    }
                </style>
                
                <div class="texto"><!-- Más de <strong><?= number_format($nroFichas, 0, ',', '.') ?></strong> -->Trámites, Servicios y Beneficios para tu emprendimiento.</div>
                <div id="menu">
                    <ul>
                        <li <?= (!$this->uri->segment(2)) ? 'class="on"' : '' ?>><a href="<?= $home_url; ?>/empresas" class="inicio" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Home', 'Nav']);" title="Página de inicio (alt+i)" accesskey="i">Inicio</a></li>
                    </ul>
                </div>
                <div class="buscador" id="buscador">
                    <form action="<?= base_url('buscar/fichas') ?>" method="get" id="main_search">
                        <label for="main_search_input"><input accesskey="b" id="main_search_input" name="buscar" type="text" <?php echo (isset($hidden_string)) ? "value='" . $hidden_string . "'" : "" ?> /></label>
                        <input type="submit" accesskey="s" class="searchbtn" value="Buscar" />
                    </form>
                </div>
                <!--
                <div class="submenu">
                    <ul>
                        <li><a href="">Noticias</a></li>
                        <li><a href="">Agenda</a></li>
                        <li><a href="">Red de Apoyo</a></li>
                        <li><a href="">Manual del Emprendimiento</a></li>
                    </ul>
                </div>
                -->
                <div class="clear"></div>
            </div>
        </div>
        <div id="container">
            <!--CONTENIDO-->
            <div id="main">
                <?php
                $this->load->view($content);
                ?>
            </div>

            <!--FOOTER-->
            <div class="clear"></div>
            <div id="footer">
                <div class="logo">
                    <img src="<?= base_url('assets/images/emprendete/logo_minecon.jpg') ?>" />
                </div>
                <div class="marcas">
                    <ul>
                        <li><a href="http://www.gobiernodechile.cl/" target="_blank"><img src="<?= base_url('assets/images/emprendete/gob_chile.png') ?>" border="0" /></a></li>
                        <li><a href="http://www.corfo.cl/sala-de-prensa/llamados-especiales/llamado-especial-de-programa-de-apoyo-al-entorno-cultura-de-innovacion" target="_blank"><img src="<?= base_url('assets/images/emprendete/cultura_PAE_164x55.jpg') ?>" border="0" /></a></li>
                        <li><a href="http://www.sellopropyme.gob.cl/" target="_blank"><img src="<?= base_url('assets/images/emprendete/banner_sello_propyme.jpg') ?>" border="0" /></a></li>
                    </ul>
                    <ul>
                        <li><a href="http://www.economia.gob.cl/atencion-proveedores/" target="_blank"><img src="<?= base_url('assets/images/emprendete/Atencion-Proveedores-164x55.jpg') ?>" border="0" /></a></li>
                        <li><a href="http://www.economia.gob.cl/ley-de-agilizacion-de-tramites/" target="_blank"><img src="<?= base_url('assets/images/emprendete/ley_emprendedores_new.png') ?>" border="0" /></a></li>
                        <li><a href="http://www.impulsocompetitivo.gob.cl/" target="_blank"><img src="<?= base_url('assets/images/emprendete/impulso.jpg') ?>" border="0" /></a></li>
                    </ul>
                </div>
                <script type="text/javascript" src="http://www.chileatiende.gob.cl/assets/js/widget-buscador-cha.js"></script>
                <div id="buscadorChA"></div>
                <div class="contacto"><a href="http://creativecommons.org/licenses/by/3.0/cl/" title="Creative Commons">CC BY 3.0</a> | <a href="http://validator.w3.org/check?uri=<?= base_url() ?>" title="Validación W3C">W3C</a></div>
                <div class="moduloatencion">&nbsp;</div>
            </div>
            <div id="detalle">
                <div class="color"></div>
            </div>
            <!-- end #container -->
        </div>
        <?php
        $this->load->view("modal/ingreso");
        $this->load->view("modal/no_disponible");
        $this->load->view("modal/beta");
        // $this->load->view("modal/opciones");
        $this->load->view("modal/formacontacto");
        $this->load->view("modal/amigo");

        if (isset($display_mod_atencion)) {
            $this->load->view("modal/modulo_atencion");
        }
        ?>
        <!-- Tags de métricas -->

        <script type="text/javascript">
            $(document).ready(function(){
                $('#main_search_input').attr('placeholder','Ingresa el término');
            });
        </script>

        <script type="text/javascript">
            window.____aParams = {"gobabierto":"1","domain":"http://www.chileatiende.gob.cl","icons":"1"};
            (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.modernizacion.cl/barra/js/barraEstado.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
            })();
        </script>


        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '']);
            _gaq.push(['_setDomainName', '']);
            _gaq.push(['_trackPageview']);
            
            //marca barra
            //_gaq.push(['barra._setAccount', 'UA-23675324-7']);
            //_gaq.push(['barra._trackPageview']);
            
            if($.cookie('overlayModuloAtencion')){
                var idModulo = $.cookie('overlayModuloAtencion');
                _gaq.push(['_setCustomVar', 1, 'ModuloAutoatencion', idModulo, 1]);
            }
            
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>

    </body>
</html>
