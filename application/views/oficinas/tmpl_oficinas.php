<div class="pagination-centered">
    <?= $this->pagination->create_links() ?>
    <div class="clearfix"></div>
</div>
<?php foreach ($oficinas as $key => $oficina): ?>
    <div class="row-fluid">
        <div class="cont-puntoatencion <?php echo $oficina->movil ? 'oficina-movil' : ''; ?>">
            <h5><?php echo $oficina->nombre; ?></h5>
            <div class="span8">
                <div class="info-puntoatencion direccion">
                    <?php echo $oficina->direccion; ?>
                </div>
                <?php if ($oficina->horario): ?>
                    <div class="info-puntoatencion horario-atencion">
                        <?php echo str_replace(' - ', '<br />', $oficina->horario); ?>
                    </div>
                <?php endif ?>
            </div>
            <div class="span4">
                <div class="mas-info-puntoatencion tramites" data-mas-info="tramites">
                    <a href="<?php echo site_url('serviciosdisponibles'); ?>">Trámites</a>
                </div>
                <?php if($oficina->lat && $oficina->lng): ?>
                <div class="mas-info-puntoatencion ver-mapa" data-mas-info="mapa" data-oficina-id="<?php echo $oficina->id; ?>">
                    <a href="">Ver mapa</a>
                </div>
                <?php endif; ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="cont-mas-info-puntoatencion">
            <div class="span12 cont-mas-info cont-tramites">
                <div class="row-fluid">
                    <h6>Trámites que se pueden realizar en esta sucursal.</h6>
                    <ul>
                        <?php foreach ($oficina->Tramites as $key => $tramite): ?>
                            <li class="tramite-destacado span6" <?php echo $tramite->url_imagen?'style="background-image:url('.$tramite->url_imagen.');"':''; ?>>
                                <a href="<?php echo $tramite->url_tramite; ?>"><?php echo $tramite->titulo; ?></a>
                            </li>
                        <?php endforeach ?>
                        <li class="tramites-globales span6">
                            <a href="<?php echo site_url('serviciosdisponibles'); ?>">Ver trámites</a> que puedes hacer en esta sucursal.
                        </li>
                    </ul>
                    <img src="<?php echo base_url('assets_v2/img/iconos/flecha_tramites_puntoatencion.png'); ?>" alt="Icono - Flecha" class="flecha_tramites_puntoatencion">
                </div>
            </div>
            <div class="span12 cont-mas-info cont-mapa">
                <div class="row-fluid">

                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<div class="pagination-centered">
    <?= $this->pagination->create_links() ?>
    <div class="clearfix"></div>
</div>