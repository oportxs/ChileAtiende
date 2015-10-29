<?php
	//Debido a que esta vista se carga desde cualquier controlador, es necesario consultar los modelos directamente.
	$modulo_activo = Doctrine::getTable('ModuloAtencion')->getModuloActivo($codigo_modulo_activo);
	$campanas_modulos = Doctrine::getTable('CampanaModulo')->CampanasActivas($modulo_activo);
?>
<div class="container-fluid">
    <div class="barra-campanas-modulo">
        <div class="container">
            <div class="cont-barra-campanas-modulo">
                <div class="row-fluid">
                    <div class="span9">
                        <?php if (isset($campanas_modulos)): ?>
                            <?php foreach ($campanas_modulos as $key => $campana){ ?>
                                <?php if ($campana->validaModuloActivo($modulo_activo)): ?>
                                    <a class="btn btn-campana" data-ga-te-category="modulos-campañas" data-ga-te-action="clic-campaña" data-ga-te-value="<?php echo $campana->id; ?>-<?php echo $campana->titulo; ?>" href="<?php echo $campana->url; ?>" target="_blank">
                                        <?php echo $campana->titulo; ?>
                                    </a>
                                <?php endif ?>            
                            <?php } ?>
                        <?php endif ?>
                    </div>
                    <div class="span3">
                        <div class="accionModulo">
                            <a href="<?php echo site_url('portada/modulo'); ?>" data-ga-te-category="modulos" data-ga-te-action="clic-salir" data-ga-te-value="salir">
                                <img src="<?php echo base_url('assets/images/btn_salir_modulo.png'); ?>" alt="Salir - Modulo">
                                Salir
                            </a>
                        </div>
                        <div class="infoModulo">
                            <p><strong>Módulo de Atención:</strong></p>
                            <p><?php echo $modulo_activo->Oficina->nombre; ?></p>
                            <p>Módulo <?php echo $modulo_activo->nro_maquina.' (' . $modulo_activo->sector_codigo.'-'.$modulo_activo->oficina_id.'-'.$modulo_activo->nro_maquina. ')'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    _gaq.push(['_setCustomVar', 2, 'codigo_modulo', '<?php echo $modulo_activo->sector_codigo ?>-<?php echo $modulo_activo->oficina_id; ?>-<?php echo $modulo_activo->nro_maquina; ?>', 3]);
</script>
