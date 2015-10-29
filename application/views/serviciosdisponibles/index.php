<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175">
        <a href="<?= site_url('/') ?>">Portada</a> / <?php echo $title; ?>
    </div>
</div>

<div id="content" class="servicios-disponibles">
    <div class="row-fluid">
        <div class="encabezado-contenido">
            <div class="span12">
                <h2><?php echo $title; ?></h2>
                <?php if( isset($oficina) ){ ?>
                    <p>
                        <?php echo $oficina->direccion;?>
                    </p>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span9 span-maincontent">
            <div id="maincontent">
                <div class="row-fluid">
                    <p class="intro-servicios-disponibles">
                        ChileAtiende pone a tu disposición una amplia variedad de servicios y beneficios entregados por <strong><?php echo count($servicios); ?></strong> instituciones públicas en múltiples canales.
                    </p>
                    <ul class="lista-servicios-disponibles">
                        <?php foreach ($servicios as $key => $servicio): ?>
                            <li>
                                <div class="cont-servicio">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="2">
                                                    <h4><?php echo $servicio->nombre; ?><?php echo $servicio->sigla?' ('.$servicio->sigla.')':''; ?><span><?php echo count($servicio->Fichas); ?></span></h4>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Servicios disponibles en sucursales ChileAtiende</th>
                                                <th class="col-canales">Canales</th>
                                            </tr>
                                            <?php foreach ($servicio->Fichas as $key => $ficha): ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo site_url('fichas/ver/'.$ficha->id); ?>"><?php echo $ficha->titulo; ?></a>
                                                    </td>
                                                    <td>
                                                        <div class="tipotramite">
                                                            <?= ($ficha->guia_online ? '<span class="tipo_tramite_online" title="En Línea">En línea</span>' : '') ?>
                                                            <?= ($ficha->guia_oficina ? '<span class="tipo_tramite_oficina" title="En oficina">En oficina</span>' : '') ?>
                                                            <?= ($ficha->guia_telefonico ? '<span class="tipo_tramite_telefonico" title="Por teléfono">Por teléfono</span>' : '') ?>
                                                            <?= ($ficha->guia_correo ? '<span class="tipo_tramite_correo" title="Por correo">Por correo</span>' : '') ?>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                            <tr>
                                                <td colspan="2">
                                                    <a class="pull-right" href="<?php echo site_url('servicios/ver/'.$servicio->codigo); ?>">Ver otros servicios y trámites de la institución en ChileAtiende</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('widget/menu-inferior'); ?>
