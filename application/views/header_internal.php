<?php 
$isEmpresa = false;
include('header_selector.php'); ?>

<header class="no-print internal-header">     
    <div class="container">
        <div class="header-top">
            <div class="row-fluid">
                <div class="span4">
                    <h1>
                        <a href="/">
                            <?php if($es_exterior=="1"):?>
                                <img class="chileatiende-img" src="<?php echo config_item('base_url').'assets_v2/img/header/chileatiende-en-el-exterior_logo.png'; ?>" alt="ChileAtiende en el Exterior" />
                            <?php else: ?>
                                <img class="chileatiende-img" src="<?php echo config_item('base_url').'assets_v2/img/nueva_home/logo_chileatiende.png'; ?>" alt="ChileAtiende" />
                            <?php endif; ?>
                        </a>
                    </h1>
                </div>
                <div class="span8">
                    <div class="row-fluid">
                        <div class="span12">
                            <?php 
                            if(!isset($addBuscador) || $addBuscador){
                                $this->load->view('busqueda/buscador'); 
                            } ?> 
                        </div>
                    </div>
                    <div class="row-fluid hidden-phone">
                        <div class="span12">
                            <div class="btn-group pull-right atencion-consultas-dropdown">
                              <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Atención y Consultas
                                <span class="caret"></span>
                              </a>
                              <ul class="dropdown-menu">
                                <li class="internal-shortcut">
                                    <a class="btn-primary" href="<?php echo config_item('base_url').'contenidos/en-linea'; ?>" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="En línea">
                                    <img src="<?php echo config_item('base_url').'assets_v2/img/nueva_home/ico_digital.png'; ?>" />
                                    <span>En línea</span></a>
                                </li>
                                <li class="internal-shortcut">
                                    <a class="btn-primary" href="<?php echo config_item('base_url').'contenidos/callcenter'; ?>" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="101">
                                    <img src="<?php echo config_item('base_url').'assets_v2/img/nueva_home/ico_101.png'; ?>" />
                                    <span>101</span></a>
                                </li>
                                <li class="internal-shortcut">
                                    <a class="btn-primary" href="<?php echo config_item('base_url').'contenidos/oficinamovil'; ?>" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="Oficinas móviles">
                                    <img src="<?php echo config_item('base_url').'assets_v2/img/nueva_home/ico_movil.png'; ?>" />
                                    <span>Oficinas móviles</span></a>
                                </li>
                                <li class="internal-shortcut">
                                    <a class="btn-primary" href="<?php echo config_item('base_url').'oficinas'; ?>" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="Puntos de atención">
                                    <img src="<?php echo config_item('base_url').'assets_v2/img/nueva_home/ico_sucursales.png'; ?>" />
                                    <span>Sucursales</span></a>
                                </li>
                                <li class="internal-shortcut">
                                    <a class="btn-primary" href="<?php echo config_item('base_url').'contenidos/preguntas-frecuentes'; ?>" data-ga-te-category="Menu Interna" data-ga-te-action="clic" data-ga-te-value="Preguntas Frecuentes">
                                    <img width="20" src="<?php echo config_item('base_url').'assets_v2/img/nueva_home/ico_preguntas-frecuentes.png'; ?>" />
                                    <span>Preguntas Frecuentes</span></a>
                                </li>
                                <li class="internal-shortcut lista-contactos">
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
                                </li>
                              </ul>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>



    </div>
</header>
