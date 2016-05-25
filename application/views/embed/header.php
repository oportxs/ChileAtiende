<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encabezado Embedido Chileatiende</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="<?php echo base_url('assets_v2/css/frontend.css'); ?>?v=10">
</head>
<body class="no-background">
    <div id='navegacion' class='no-print'>
        <div class='wrapper'>
            <ul>
                <li class='active' ><a href='<?php echo site_url(); ?>'><img src='<?=base_url('assets_v2/img/navegacion/cchileatiende.png')?>' alt='Chileatiende' /> ChileAtiende</a></li>
                <li><a href='<?php echo site_url('empresas'); ?>'><img src='<?=base_url('assets_v2/img/navegacion/barra_estado_ico_chileatiendeempresas.png')?>' alt='Chileatiende Pymes' /> ChileAtiende Pymes</a></li>
                <li><a class='visible-desktop' href='http://www.chilesinpapeleo.cl' target='_blank'><img src='<?=base_url('assets_v2/img/navegacion/barra_estado_ico_chilesinpapeleo.png')?>' alt='Chile sin Papeleo' /> Chile Sin Papeleo</a></li>
                <li><a class='visible-desktop' href='http://www.gobiernoabierto.cl' target='_blank'><img src='<?=base_url('assets_v2/img/navegacion/barra_estado_ico_gobiernoabierto.png')?>' alt='Gobierno Abierto' /> Gobierno Abierto</a></li>
            </ul>
        </div>
    </div>
    <header class="no-print">
        <div class="container">
            <div class="header-top">
                <div class="row-fluid">
                    <div class="span4">
                        <h1>
                            <a href="<?php echo site_url(); ?>">
                                <img src="<?php echo base_url('assets_v2/img/logo_chileatiende_beta_2x.png'); ?>" alt="ChileAtiende" />
                            </a>
                        </h1>
                    </div>
                    <div class="offset4 span4 <?php echo isset($esPortada)?'visible-desktop':''; ?>">
                        <?php /* ?>
                            <div class="accede-con">
                                <span>Accede con:</span>
                                <a href="#" class="btn-claveunica">Claveúnica</a>
                            </div>
                            <?php */ ?>
                        <?php if (!isset($esPortada)): ?>
                            <?php $this->load->view('busqueda/buscador'); ?>
                        <?php else: ?>
                            <a href="<?php echo site_url('descubre'); ?>" class="cont-descubre hidden-phone">
                                <img src="<?php echo base_url('assets_v2/img/iconos/ico_descubre-nuevo.png'); ?>" alt="Descubre el nuevo portal Chileatiende">
                                <strong>Descubre</strong>
                                <span>el nuevo portal ChileAtiende</span>
                            </a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="header-bottom">
                <div class="row-fluid">
                    <div class="span4">
                        <div class="row-fluid">
                            <div class="nav-areas hidden-phone">
                                <div class="span6">
                                    <a href="<?php echo site_url('portada/etapas'); ?>" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="Etapas" title="Hechos de vida" accesskey="h">
                                        Etapas de vida
                                    </a>
                                </div>
                                <div class="span6">
                                    <a href="<?php echo site_url('portada/temas'); ?>" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="Temas" title="Temas de interés" accesskey="t">
                                        Temas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span6 span-nav-contactos">
                        <div class="row-fluid">
                            <div class="nav-contactos">
                                <div class="span6">
                                    <div class="nav-contacto-icon contactos-puntos-atencion pull-right">
                                        <a href="<?php echo site_url('oficinas'); ?>" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="Puntos de atención">Puntos de atención</a>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="nav-contacto-icon contactos-oficinamovil pull-right">
                                        <a href="<?php echo site_url('contenidos/oficinamovil'); ?>" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="Oficinas móviles">Oficinas móviles</a>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="nav-contacto-icon contactos-callcenter pull-right">
                                        <a class="hidden-phone" href="<?php echo site_url('contenidos/callcenter'); ?>" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="101">101</a>
                                        <a class="visible-phone" href="tel:101" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="101">101</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span2 visible-desktop">
                        <ul class="unstyled lista-contactos">
                            <li class="contactos-facebook">
                                <a href="https://www.facebook.com/ChileAtiende" target="_blank" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="Facebook">Facebook</a>
                            </li>
                            <li class="contactos-twitter">
                                <a href="https://twitter.com/ChileAtiende" target="_blank" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="Twitter">Twitter</a>
                            </li>
                            <li class="contactos-correo">
                                <a class="hidden-phone" href="https://contacto.chileatiende.cl/formulario.php?origen=<?php echo site_url(); ?>" data-toggle="modal-chileatiende" data-modal-type="iframe" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="Contacto">Contacto</a>
                                <a class="visible-phone" href="https://contacto.chileatiende.cl/formulario.php?origen=<?php echo site_url(); ?>" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="Contacto">Contacto</a>
                            </li>
                            <li class="contactos-texto">Contacto</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
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
