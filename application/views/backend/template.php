<?php
$entidad = UsuarioBackendSesion::getEntidad();
$servicio = UsuarioBackendSesion::getServicio();
$cntflujos = FALSE; //deshabilitamos los flujos para que los contadores solo muestren las fichas que faltan procesar (creadas, actualizables, etc)

$creadas = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'creadas', 'justCount' => TRUE, 'flujos' => $cntflujos));
$pendientes = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'actualizables', 'justCount' => TRUE, 'flujos' => $cntflujos));
$rechazadas = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'rechazado', 'justCount' => TRUE, 'flujos' => $cntflujos));
$revision = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'enrevision', 'justCount' => TRUE, 'flujos' => $cntflujos));
$publicados = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'publicados', 'justCount' => TRUE, 'flujos' => $cntflujos));
$nopublicados = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'nopublicados', 'justCount' => TRUE, 'flujos' => $cntflujos));
$flujospublicados = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'publicados', 'justCount' => TRUE, 'flujos' => TRUE));
$metafichas = Doctrine::getTable('Ficha')->findMaestros($entidad, $servicio, array('estado' => 'metafichas', 'justCount' => TRUE, 'flujos' => $cntflujos));

$subfichas_creadas = Doctrine::getTable('SubFicha')->findMaestros($entidad, $servicio, array('estado' => 'creadas', 'justCount' => TRUE));
$subfichas_pendientes = Doctrine::getTable('SubFicha')->findMaestros($entidad, $servicio, array('estado' => 'actualizables', 'justCount' => TRUE));
$subfichas_rechazadas = Doctrine::getTable('SubFicha')->findMaestros($entidad, $servicio, array('estado' => 'rechazado', 'justCount' => TRUE));
$subfichas_revision = Doctrine::getTable('SubFicha')->findMaestros($entidad, $servicio, array('estado' => 'enrevision', 'justCount' => TRUE));
$subfichas_publicados = Doctrine::getTable('SubFicha')->findMaestros($entidad, $servicio, array('estado' => 'publicados', 'justCount' => TRUE));
$subfichas_nopublicados = Doctrine::getTable('SubFicha')->findMaestros($entidad, $servicio, array('estado' => 'nopublicados', 'justCount' => TRUE));

$eventos_publicados = Doctrine::getTable('Evento')->findMaestros($entidad, $servicio, array('estado' => 'publicados', 'actuales' => true, 'justCount' => TRUE));
$eventos_nopublicados = Doctrine::getTable('Evento')->findMaestros($entidad, $servicio, array('estado' => 'nopublicados', 'actuales' => true,'justCount' => TRUE));
$eventos_rechazados = Doctrine::getTable('Evento')->findMaestros($entidad, $servicio, array('estado' => 'rechazados', 'actuales' => true,'justCount' => TRUE));
$eventos_expirados = Doctrine::getTable('Evento')->findMaestros($entidad, $servicio, array('estado' => 'expirados', 'justCount' => TRUE));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= $title ?></title>
        <base href="<?= base_url() ?>" />
        <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.ico') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/reset.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/backend-new.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery-ui/jquery-ui.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery-ui/jquery.ui.autocomplete.custom.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/chosen16/chosen.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/fileuploader/fileuploader.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/js/jquery.datetimepicker/jquery.datetimepicker.css'); ?>"/>
        <script type="text/javascript">
            var site_url="<?= site_url() ?>";
        </script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script src="<?= base_url('assets/js/jquery-migrate-1.1.1.min.js') ?>"></script>

        <script type="text/javascript" src="<?= base_url('assets/js/jquery-ui/jquery-ui-1.10.2.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery-tools/jquery-tools-1.2.5.js') ?>" ></script>
        <script type="text/javascript" src="<?= base_url('assets/js/tag-it/tag-it.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/tiny_mce/tiny_mce.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/chosen16/chosen.jquery.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/highcharts/highcharts.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/fileuploader/fileuploader.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/script.js') ?>" ></script>
        <script type="text/javascript" src="<?= base_url('assets/js/backend.js') ?>" ></script>
        <script type="text/javascript" src="<?= base_url('assets/js/comentarios.backend.js') ?>" ></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.datetimepicker/jquery.datetimepicker.js'); ?>"></script>
    </head>

    <body>
        <div id="wrapper">
            <div id="header">
                <div class="logo">Chile Atiende</div>
                <div class="logo-ChA">Chile Atiende</div>
                <div class="tools">
                    <ul class="menu">
                        <li class="usuario"><a href="<?= site_url('backend/cuenta/index') ?>"><?= UsuarioBackendSesion::usuario()->nombres . ' ' . UsuarioBackendSesion::usuario()->apellidos ?></a></li>
                        <li><?= dia(strftime("%u")) . strftime(", %d de ") . mes(intval(strftime("%m"))) . strftime(" de %Y") ?></li>
                        <li class="home"><a href="<?= site_url('/') ?>" target="_blank">Ver Portada</a></li>
                        <li class="salir"><a href="<?= site_url('backend/autenticacion/logout') ?>">Salir</a></li>
                    </ul>
                </div>
            </div>

            <div id="main">
                <div id="secondary">
                    <h2>Menú Principal</h2>
                    <ul>
                        <li><strong></strong></li>
                        <li><a href="<?= site_url('backend/cuenta/index') ?>">Mis datos</a></li>
                        <li><a href="<?= site_url('backend/portada') ?>">Panel de Control</a></li>
                    </ul>

                    <?php if (UsuarioBackendSesion::usuario()->tieneRol('mantenedor')) { ?>
                        <br />
                        <h2>Administración</h2>
                        <ul>
                            <li>General
                                <ul>
                                    <li><a href="<?= site_url('backend/configuraciones') ?>">Configuración</a></li>
                                    <li><a href="<?= site_url('backend/mantenimiento') ?>">Mantenimiento</a></li>
                                    <li><a href="<?= site_url('backend/usuariosbackend') ?>">Usuarios </a></li>
                                    <li><a href="<?= site_url('backend/entidades') ?>">Entidades</a></li>
                                    <li><a href="<?= site_url('backend/servicios') ?>">Instituciones</a></li>
                                </ul>
                            </li>
                            <li>Otras opciones
                                <ul>
                                    <li><a href="<?= site_url('backend/oficinas') ?>">Oficinas</a></li>
                                    <li><a href="<?= site_url('backend/tramitesenconvenio') ?>">Trámites en convenio</a></li>
                                    <?php if (UsuarioBackendSesion::usuario()->tieneRol('jefaturaweb')) { ?>
                                        <li><a href="<?= site_url('backend/alertas') ?>">Alertas</a></li>
                                    <?php } ?>
                                    <li><a href="<?= site_url('backend/sectores') ?>">Sectores</a></li>                            
                                    <li><a href="<?= site_url('backend/modulosatencion') ?>">Módulos de atención</a></li>
                                    <li><a href="<?= site_url('backend/uploads') ?>">Carga de archivos</a></li>
                                </ul>
                            </li>
                            <li>Chileatiende
                                <ul>
                                    <li><a href="<?= site_url('backend/etapasvida') ?>">Etapas</a></li>
                                    <li><a href="<?= site_url('backend/hechosvida') ?>">Hechos</a></li>
                                    <li><a href="<?= site_url('backend/temas') ?>">Temas</a></li>
                                </ul>
                            </li>
                            
                            <li>Buscador
                                <ul>
                                    <li><a href="<?=site_url('backend/searchpromocionados')?>">Resultados Con Todo</a></li>
                                </ul>
                            </li>

                            <li>Emprendete
                                <ul>
                                    <li><a href="<?= site_url('backend/etapasempresa') ?>">Etapas Empresa</a></li>
                                    <li><a href="<?= site_url('backend/hechosempresa') ?>">Hechos Empresa</a></li>
                                    <li><a href="<?= site_url('backend/temasempresa') ?>">Temas Empresa</a></li>
                                    <li><a href="<?= site_url('backend/apoyosestado') ?>">Apoyo del Estado</a></li>
                                </ul>
                            </li>
                        </ul>

                    <?php } ?>

                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('editor', 'aprobador', 'publicador', 'mantenedor'))) { ?>
                        <br />
                        <h2>Trámites y Servicios</h2>
                        <ul>
                            <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('editor'))) { ?>
                                <li><a href="<?= site_url('backend/fichas/agregar') ?>" title="Permite crear una nueva ficha de información en el sistema">Agregar Ficha</a></li>
                            <?php } ?>
                            <li>
                                <a href="<?= site_url('backend/fichas') ?>" title="Listar todas las fichas disponibles en el sistema">Ver Fichas</a>
                                <ul>
                                    <li><a href="<?= site_url('backend/fichas/index/creadas') ?>" title="Fichas para revisión del servicio">Para revisión <?= ($creadas) ? '(' . $creadas . ')' : ''; ?></a></li>
                                    <li><a href="<?= site_url('backend/fichas/index/enrevision') ?>" title="Fichas en proceso de revisión editorial">En revisión ChileAtiende <?= ($revision) ? '(' . $revision . ')' : ''; ?></a></li>
                                    <li><a href="<?= site_url('backend/fichas/index/rechazado') ?>" title="Fichas con comentarios editoriales ChileAtiende">Con observaciones <?= ($rechazadas) ? '(' . $rechazadas . ')' : ''; ?></a></li>

                                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('publicador'))) { ?>

                                        <li><a href="<?= site_url('backend/fichas/index/nopublicados') ?>" >No Publicadas <?= ($nopublicados) ? '(' . $nopublicados . ')' : '' ?></a></li>
                                        <li><a href="<?= site_url('backend/fichas/index/actualizables') ?>" >Actualizables <?= ($pendientes) ? '(' . $pendientes . ')' : ''; ?></a></li>

                                        <li><a href="<?= site_url('backend/fichas/index/destacado') ?>" >Destacadas</a></li>
                                        <li><a href="<?= site_url('backend/fichas/index/chileclic') ?>" >ChileClic</a></li>

                                    <?php } ?>

                                    <li><a href="<?= site_url('backend/fichas/index/publicados') ?>" title="Fichas disponibles a la ciudadanía en el portal">Publicadas <?= ($publicados) ? '(' . $publicados . ')' : ''; ?></a></li>

                                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('metaficha'))): ?>
                                    <li><a href="<?= site_url('backend/fichas/index/metafichas') ?>" title="Fichas con SubFichas asociadas">Metafichas <?= ($metafichas) ? '(' . $metafichas . ')' : ''; ?></a></li>
                                    <?php endif; ?>
                                    
                                    <?php if($fichas_exterior['total']>0):?>
                                    <li><a href="<?= site_url('backend/fichas/index/exterior') ?>" title="Fichas para chilenos en el Exterior"> Chilenos en el Exterior (<?= $fichas_exterior['total']?>)</a></li>
                                    <?php endif;?>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>

                    <?php if (
                    UsuarioBackendSesion::usuario()->tieneRol(array('editor', 'aprobador', 'publicador', 'mantenedor')) &&
                    ( $subfichas_creadas + $subfichas_revision + $subfichas_rechazadas + $subfichas_nopublicados + $subfichas_pendientes + $subfichas_publicados > 0 )
                        ) { ?>
                        <br />
                        <h2>SubFichas</h2>
                        <ul>
                            <li>
                                <a href="<?= site_url('backend/subfichas') ?>" title="Listar todas las subfichas disponibles en el sistema">Ver SubFichas</a>
                                <ul>
                                    <li><a href="<?= site_url('backend/subfichas/index/creadas') ?>" title="SubFichas para revisión del servicio">Para revisión <?= ($subfichas_creadas) ? '(' . $subfichas_creadas . ')' : ''; ?></a></li>
                                    <li><a href="<?= site_url('backend/subfichas/index/enrevision') ?>" title="SubFichas en proceso de revisión editorial">En revisión ChileAtiende <?= ($subfichas_revision) ? '(' . $subfichas_revision . ')' : ''; ?></a></li>
                                    <li><a href="<?= site_url('backend/subfichas/index/rechazado') ?>" title="SubFichas con comentarios editoriales ChileAtiende">Con observaciones <?= ($subfichas_rechazadas) ? '(' . $subfichas_rechazadas . ')' : ''; ?></a></li>

                                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('publicador'))) { ?>

                                        <li><a href="<?= site_url('backend/subfichas/index/nopublicados') ?>" >No Publicadas <?= ($subfichas_nopublicados) ? '(' . $subfichas_nopublicados . ')' : '' ?></a></li>
                                        <li><a href="<?= site_url('backend/subfichas/index/actualizables') ?>" >Actualizables <?= ($subfichas_pendientes) ? '(' . $subfichas_pendientes . ')' : ''; ?></a></li>
                                    <?php } ?>

                                    <li><a href="<?= site_url('backend/subfichas/index/publicados') ?>" title="SubFichas disponibles a la ciudadanía en el portal">Publicadas <?= ($subfichas_publicados) ? '(' . $subfichas_publicados . ')' : ''; ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>

                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('cal-editor', 'cal-publicador', 'mantenedor'))): ?>
                    <br/>
                    <h2>Eventos y Postulaciones</h2>
                    <ul>
                        <li><a href="<?= site_url('backend/eventos/agregar') ?>">Agregar Evento</a></li>
                        <li><a href="<?= site_url('backend/eventos') ?>">Ver Eventos</a>
                            <ul>
                                <li><a href="<?= site_url('backend/eventos/index/publicados') ?>">Publicados <?= $eventos_publicados ? '('. $eventos_publicados .')' : '' ?></a></li>
                                <li><a href="<?= site_url('backend/eventos/index/nopublicados') ?>">No Publicados <?= $eventos_nopublicados ? '('. $eventos_nopublicados .')' : '' ?></a></li>
                                <li><a href="<?= site_url('backend/eventos/index/rechazados') ?>">Con observaciones <?= $eventos_rechazados ? '('. $eventos_rechazados .')' : '' ?></a></li>
                                <li><a href="<?= site_url('backend/eventos/index/expirados') ?>">Terminados <?= $eventos_expirados ? '('. $eventos_expirados .')' : '' ?></a></li>
                            </ul>
                        </li>
                    </ul>
                    <?php endif; ?>

                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('mantenedor', 'publicador'))) { ?>
                        <br />
                        <h2>Flujos</h2>
                        <ul>
                            <li><a href="<?= site_url('backend/fichas/agregarflujo') ?>" title="Permite crear un flujo de información en el sistema">Agregar Flujo</a></li>
                            <li>
                                <a href="<?= site_url('backend/fichas/listarflujos') ?>">Ver Flujos</a>
                                <ul>
                                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('publicador'))) { ?>
                                        <li><a href="<?= site_url('backend/fichas/listarflujos/nopublicados') ?>" >No Publicados</a></li>
                                    <?php } ?>
                                    <li><a href="<?= site_url('backend/fichas/listarflujos/publicados') ?>" title="Flujos disponibles a la ciudadanía en el portal">Publicadas <?= ($flujospublicados) ? '(' . $flujospublicados . ')' : ''; ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>

                    <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('reportero', 'mantenedor'))) { ?>
                        <br />
                        <h2>Noticias</h2>
                        <ul>
                            <li>
                                <a href="<?= site_url('backend/noticias') ?>">Listar Noticias</a>
                                <?php if (UsuarioBackendSesion::usuario()->tieneRol(array('reportero', 'mantenedor'))) { ?>
                                    <ul>
                                        <li><a href="<?= site_url('backend/noticias/agregar') ?>">Agregar Noticia</a></li>
                                    </ul>
                                <?php } ?>
                            </li>
                        </ul>
                    <?php } ?>
                    <?php if (UsuarioBackendSesion::usuario()->tieneRol('mantenedor')) { ?>
                        <br />
                        <h2>Contenidos</h2>
                        <ul>
                            <li>
                                <a href="<?php echo site_url('backend/contenidos'); ?>">Listar Contenidos</a>
                                <ul>
                                    <li>
                                        <a href="<?php echo site_url('backend/contenidos/agregar'); ?>">Agregar Contenido</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
                <div id="primary">
                    <?php $this->load->view($content); ?>
                </div>
            </div>

            <div id="footer">
                <address>
                    Gobierno de Chile - Modernización y Gobierno Digital - Ministerio Secretaría General de la Presidencia<br />
                    Dirección: Teatinos Teatinos Nº 92 piso 9, Santiago <br />
                    Teléfonos: +562 2219 8327 +562 2219 8407
                </address>
            </div>
        </div>
    </body>
</html>