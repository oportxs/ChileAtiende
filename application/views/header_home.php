<?php 
$isEmpresa = false;
$isExterior = false;
include('header_selector.php'); ?>
<header class="no-print">     
    <div class="container">
        <div class="header-top">
            <div class="row-fluid">
                <div class="span3">
                    <h1>
                        <a href="<?php echo site_url(); ?>">
                            <img src="<?php echo base_url('assets_v2/img/nueva_home/logo_chileatiende.png'); ?>" alt="ChileAtiende" />
                        </a>
                    </h1>
                </div>
                <div class="span8">

                    <div class="row buscador-view">
                        <div class="span12">
                            <?php $this->load->view('busqueda/buscador'); ?>
                        </div>
                    </div>

                    <div class="row temas-destacados">
                        <?php foreach ($accesos as $key => $value) {?>
                            <a href="<?=base_url('buscar/fichas?temas='.$value->id)?>" data-ga-te-category="Menu Accesos" data-ga-te-action="clic" data-ga-te-value="<?php echo $value->id ?>"><span class="label label-info"><?php echo $value->nombre ?></span></a>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="row-fluid">
        <div class="container">
            <div class="span12 title title-home">
                Guía de trámites y beneficios del Estado
            </div>
        </div>
    </div>
    
    <div class="header-bottom">
        <div class="container">
            <div class="row-fluid">
                    <div class="span3 home-shortcut-container text-center">
                        <a class="home-shortcut" href="<?php echo site_url('contenidos/en-linea'); ?>" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="En línea">
                        <img src="<?php echo base_url('assets_v2/img/nueva_home/ico_digital.png'); ?>" />
                        <span>En línea</span></a>
                    </div>
                    <div class="span3 home-shortcut-container text-center">
                        <a class="home-shortcut" href="<?php echo site_url('contenidos/callcenter'); ?>" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="101">
                        <img src="<?php echo base_url('assets_v2/img/nueva_home/ico_101.png'); ?>" />
                        <span>101</span></a>
                    </div>
                    <div class="span3 home-shortcut-container text-center">
                        <a class="home-shortcut" href="<?php echo site_url('contenidos/oficinamovil'); ?>" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="Oficinas móviles">
                        <img src="<?php echo base_url('assets_v2/img/nueva_home/ico_movil.png'); ?>" />
                        <span>Oficinas móviles</span></a>
                    </div>
                    <div class="span3 home-shortcut-container text-center">
                        <a class="home-shortcut" href="<?php echo site_url('oficinas'); ?>" data-ga-te-category="Menu Encabezado" data-ga-te-action="clic" data-ga-te-value="Puntos de atención">
                        <img src="<?php echo base_url('assets_v2/img/nueva_home/ico_sucursales.png'); ?>" />
                        <span>Sucursales</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .front-container-portada {margin-top: -46px;}
        .header-bottom {margin-bottom: 25px !important;}
        @media (max-width: 979px) and (min-width: 768px) {
            .front-container-portada {margin-top: 0px;}
        }
        @media (max-width: 767px){
            .front-container-portada {margin-top: 0px;}
        }
    </style>
    <div class="row-fluid">
        <div class="container">
            <a class="registro-link" href="http://www.votoenelexterior.cl" target="_blank" onclick="_gaq.push(['_trackEvent', 'outgoing_links', 'www.votoenelexterior.cl'])">
                <img class="pull-right" src="/assets_v2/img/banners/votoexterior320X100.png" width="320" style="visibility:visible">
            </a>
        </div>
    </div>

</header>

