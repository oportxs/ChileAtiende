<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="205">
        <a href="<?= site_url('/') ?>">Portada</a> / Listado de instituciones
    </div>
</div>

<div id="content" class="instituciones">
    <div class="row-fluid">
        <div class="encabezado-contenido">
            <div class="span12">
                <h2>Listado de instituciones asociadas</h2>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div id="maincontent" role="main">
                <div class="contenedor-abc">
                    <ul class="vistas">
                        <li>Vistas</li>
                        <li class="lista active"><a href="#" title="Ver como listas">Ver como listas</a></li>
                        <li class="grupo"><a href="#" title="Ver como grupos">Ver como grupos</a></li>
                    </ul>
                    <ul class="abcedario no-print">
                        <li>Índice</li> 
                        <?php
                            // Listado Alfabético
                            $tmpLetra = '';
                            foreach ($servicios as $servicio) {
                            $tmp = $servicio->nombre;
                            $letra = $tmp[0];
                            echo ($letra == $tmpLetra) ? '' : '<li><a href="#' . $letra . '">' . $letra . '</a></li>';
                            $tmpLetra = $letra;
                            }
                        ?>
                    </ul>
                </div>
                <div id="instituciones">
                    <div class="row-fluid contenedor-instituciones">
                        <?php $letra_actual = null; ?>
                        <?php foreach ($servicios as $servicio): ?>
                            <?php if ($letra_actual != $servicio->nombre[0] && $letra_actual != null): ?>
                                    </div>
                                </div>
                                <div class="row-fluid contenedor-instituciones">
                            <?php endif; ?>
                            <?php if ($letra_actual != $servicio->nombre[0]): ?>
                                    <div class="span1">
                                        <a name="<?php echo $servicio->nombre[0]; ?>"></a>
                                        <h4><?php echo $servicio->nombre[0]; ?></h4>
                                    </div>
                                    <div class="span11">
                            <?php endif ?>
                            <div class="institucion">
                                <a href="<?php echo site_url('servicios/ver/'.$servicio->codigo) ?>">
                                    <?php echo $servicio->nombre; ?>
                                    <?php if ($servicio->sigla): ?>
                                        (<?php echo $servicio->sigla; ?>)
                                    <?php endif ?>
                                </a>
                            </div>
                            <?php $letra_actual = $servicio->nombre[0]; ?>
                        <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('widget/menu-inferior'); ?>
