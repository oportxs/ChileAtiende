<?php
function codigo_sort($a, $b) { 
    return ($a->codigo == $b->codigo) ? 0 : 
        (($a->codigo < $b->codigo) ? -1 : 1); 
}
function nombre_sort($a, $b) { 
    return ($a->nombre == $b->nombre) ? 0 : 
        (($a->nombre < $b->nombre) ? -1 : 1); 
}
uasort($comunas, 'nombre_sort');
uasort($servicios, 'nombre_sort');
uasort($entidades, 'nombre_sort');
uasort($regiones, 'codigo_sort');
?>                
                    
                    <div class="filtros-puntosatencion">
                            <div class="row-fluid">
                                <div class="span12">
                                    <h4>
                                        <?= $menu_text; ?>
                                    </h4>
                                </div>
                            </div>
                            <div class="row-fluid">
                    
                    <?php
                    $metaficha_opciones = unserialize($ficha->metaficha_opciones);
                    ?>
                    <?php if($metaficha_opciones['categoria'] == "region-comuna"): ?>
                                <div class="metaficha-menu-select3">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label for="region">Región</label>
                                        </div>
                                        <div class="controls">
                                            <select class="input-block-level" name="region" id="region">
                                                <option value="">- Todas -</option>
                                                <?php foreach ($regiones as $key => $region): ?>
                                                    <option value="<?php echo $region->codigo; ?>"><?php echo $region->nombre; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="metaficha-menu-select3">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label for="comuna">Comuna</label>
                                        </div>
                                        <div class="controls">
                                            <select class="input-block-level" name="comuna" id="comuna">
                                                <option value=""></option>
                                                <?php foreach ($comunas as $key => $comuna): ?>
                                                    <option value="<?php echo $comuna->codigo.'-'.$key; ?>"><?php echo $comuna->nombre; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                    <?php elseif($metaficha_opciones['categoria'] == "servicio-alfabetico"): ?>
                                <div class="metaficha-menu-select1">
                                    <div class="control-group">
                                        <div class="controls">
                                            <select class="input-block-level" name="comuna" id="comuna">
                                                <option value=""></option>
                                                <?php foreach ($servicios as $key => $servicio): ?>
                                                    <option value="<?php echo 'nomark-'.$key; ?>"><?php echo $servicio->nombre; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                    <?php elseif($metaficha_opciones['categoria'] == "entidad-servicio"): ?>
                                <div class="metaficha-menu-select3">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label for="region">Entidad</label>
                                        </div>
                                        <div class="controls">
                                            <select class="input-block-level" name="region" id="region">
                                                <option value="">- Todas -</option>
                                                <?php foreach ($entidades as $key => $entidad): ?>
                                                    <option value="<?php echo $entidad->codigo; ?>"><?php echo $entidad->nombre; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="metaficha-menu-select3">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label for="comuna">Institución</label>
                                        </div>
                                        <div class="controls">
                                            <select class="input-block-level" name="comuna" id="comuna">
                                                <option value=""></option>
                                                <?php foreach ($servicios as $key => $servicio): ?>
                                                    <option value="<?php echo $servicio->codigo.'-'.$key; ?>"><?php echo $servicio->nombre; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                    <?php endif; ?>

                                <div class="metaficha-menu-boton" <?php if($metaficha_opciones['categoria'] == "servicio-alfabetico") echo 'style="margin: 0px 0px 0px 2px;"'; ?>>
                                    <div class="control-group-last">
                                        <button id="seleccion_subficha" class="btn btn-primary" onclick="click_botonFiltro()">Buscar</button>
                                    </div>
                                </div>

                            </div><!-- <div class="row-fluid"> -->
                    </div><!-- <div class="filtros-puntosatencion"> -->

                    <span id="error_msg" class="metaficha-menu-error"></span>

                    <?php if($metaficha_opciones['servicios_no_publican']): ?>
                    <span class="metaficha-menu-extrainfo">Para obtener información de otras instituciones comunicarse directamente con estas.</span>
                    <?php endif; ?>

                    <script type="text/javascript">
                    function click_botonFiltro() {
                        var comuna = $('#comuna option:selected');
                        var value = comuna.attr('value');
                        var limit_index = value.indexOf("-");
                        var sf_id = value.substr(limit_index+1);
                        if(sf_id === "") {
                            $("#error_msg").html("Seleccione una opción.");
                            $("#error_msg").css('display','block');
                            return;
                        }
                        $.getJSON(site_url+"subfichas/ver/"+sf_id, function(data) {
                            $("#ajax-content").html(data.info);
                            $("#error_msg").css('display','none');
                            window.app.init();
                        });
                    }
                    
                    <?php 
                    // INFO: Opcion pre-seleccionada en url
                    if(isset($seleccion)): 
                    ?>
                    $(function(){
                        $('#comuna option[value$="-<?= $seleccion ?>"]').attr('selected', 'selected');
                        $('#seleccion_subficha').click();
                    });
                    <?php endif; ?>
                    </script>
