<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/eventos/') ?>">Eventos</a> »
    <span>Editar: <?= $evento->titulo ?></span>
</div>

<div class="pane">
    <?php $this->load->view('backend/eventos/menu', array('tab' => 'editar')); ?>
	<h2>Edición evento</h2>
    
    <?php
    if ($evento->estado == 'rechazado') {
        echo '
            <ul class="updateWarningsRechazado">
                <li>
                    <div class="mensaje"><strong> Este evento se encuentra con las siguientes observaciones:</strong> <br />' . $evento->estado_justificacion . '</div>
                </li>
            </ul>';
    }
    ?>

    <form class="ajaxForm" method="post" action="<?= site_url('backend/eventos/editar_form/' . $evento->id) ?>">

        <div class="validacion"></div>
        
        <?php
        
        $readonly = ($evento->publicado == 1) ? true : false;

        ?>
            <fieldset class="tabla-eventos" id="evento" >
                <legend>Datos evento</legend>
                
                <table class="formTable">
                    
                    <tr>
                        <td class="titulo">Servicio <span class="red">*</span></td>
                        <td>
                            <select data-placeholder="Seleccione un Servicio" name="servicio_codigo" class="chzn-select">
                                <option value=""></option>
                                <?php
                                foreach ($servicios as $servicio) {
                                    echo '<option value="' . $servicio->codigo . '" ' . ( ($evento->servicio_codigo == $servicio->codigo) ? 'selected="selected"' : '' ) . '>' . $servicio->nombre . '</option>';
                                }
                                ?>
                            </select>


                        </td>
                    </tr>
                    
                    <tr id="titulo">
                        <td class="titulo"><label for="titulo">Título <span class="red">*</span></label></td>
                        <td>
                            <input type="text" name="titulo" maxlength="150" size="64" placeholder="Título del evento..." <?= ($readonly) ? 'readonly' : '' ?> value="<?= $evento->titulo; ?>" />
                        </td>
                    </tr>

                    <tr id="url">
                        <td class="titulo"><label for="url">Enlace <span class="red">*</span></label></td>
                        <td>
                            <input type="text" name="url" maxlength="250" size="64" placeholder="Enlace del evento..." <?= ($readonly) ? 'readonly' : '' ?> value="<?= $evento->url; ?>" />
                        </td>
                    </tr>

                    <tr id="region">
                        <td class="titulo"><label for="region">Región <span class="red">*</span></label></td>
                        <td>
                            <?php 

                            $r_nombre = '';
                            $r_array = array();
                            foreach($evento->Regiones as $k => $r) { 
                                $r_nombre .= ($k == 0 ? '':', ').$r->nombre; 
                                $r_array[] = $r->id;
                            }
                            if(count($evento->Regiones) == count($regiones))
                                $r_nombre = "Todas las Regiones";

                            if($readonly):

                            ?>
                            <input readonly type="text" name="fakename" size="64" value="<?= $r_nombre; ?>" />
                            <?php foreach($r_array as $r_id): ?>
                            <input type="hidden" name="region[]" value="<?= $r_id ?>" />
                            <?php endforeach; ?>
                            <input type="hidden" name="region_sel" value="0" />
                            <?php 
                            
                            else: 

                            ?>
                            <input type="radio" class="region_sel" name="region_sel" id="region-todos" value="1" <?= (count($evento->Regiones) < count($regiones)) ? '':'checked="checked"' ?>><label for="region-todos">Todas</label>
                            <input type="radio" class="region_sel" name="region_sel" id="region-especifico" value="0" <?= (count($evento->Regiones) < count($regiones)) ? 'checked="checked"':'' ?>><label for="region-especifico">Específico</label>
                            <div class="region-select" <?= (count($evento->Regiones) < count($regiones)) ? '':'style="display:none;"' ?>>
                                <select multiple data-placeholder="Seleccione la Región" name="region[]" class="chzn-select" style="width: 450px;">
                                    <option value=""></option>
                                <?php foreach ($regiones as $r): ?>
                                    <option value="<?= $r->id ?>" <?= in_array($r->id, $r_array) ? 'selected="selected"' : ''; ?> ><?= $r->nombre ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>                                
                            <?php 

                            endif; 

                            ?>
                        </td>
                    </tr>

                    <tr id="permanente">
                        <td class="titulo"><label for="permanente">Duración <span class="red">*</span></label></td>
                        <td>
                            <input type="radio" name="permanente" class="permanente_sel" value="0" <?php echo !($evento->permanente) ? 'checked="checked"' : ''; ?> <?php echo $readonly ? 'disabled="disabled"' : ''; ?> /><label>Temporal</label>
                            <input type="radio" name="permanente" class="permanente_sel" value="1" <?php echo $evento->permanente ? 'checked="checked"' : ''; ?> <?php echo $readonly ? 'disabled="disabled"' : ''; ?> /><label>Permanente</label>
                            <?php if($readonly): ?>
                            <input type="hidden" name="permanente" value="<?php echo $evento->permanente; ?>" />
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr id="fecha" style="display: <?php echo $evento->permanente ? 'none' : 'table-row' ?>;">
                        <td class="titulo"><label for="postulacion_start">Período duración <span class="red">*</span></label></td>
                        <td>
                            <input type="text" name="postulacion_start" class="<?= ($readonly) ? '' : 'postulacion_start' ?>" value="<?= $evento->postulacion_start ? date('d\-m\-Y', strtotime($evento->postulacion_start)) : '' ?>" placeholder="24-02-2013" <?= ($readonly) ? 'readonly' : '' ?>/>
                            <input type="text" name="postulacion_end" class="<?= ($readonly) ? '' : 'postulacion_end' ?>" value="<?= $evento->postulacion_end ? date('d\-m\-Y', strtotime($evento->postulacion_end)) : '' ?>" placeholder="24-03-2013" <?= ($readonly) ? 'readonly' : '' ?>/>
                            <div class="error_date" style="color: red; display: none;">Debe elegir un periodo válido para la fecha</div>
                        </td>
                    </tr>

                    <tr>
                        <td class="titulo">Público objetivo  <span class="red">*</span></td>
                        <td>
                            <label><input type="radio" name="tipo" id="personas" value="1" <?= ($evento->tipo == 1 || !$evento->tipo) ? 'checked="checked"' : '' ?> /> Personas</label>
                            <label><input type="radio" name="tipo" id="empresas" value="2" <?= ($evento->tipo == 2) ? 'checked="checked"' : '' ?> /> Empresas</label>
                            <label><input type="radio" name="tipo" id="ambos" value="3" <?= ($evento->tipo == 3) ? 'checked="checked"' : '' ?> /> Ambos</label>
                            <div id="evento_tipo_msg" <?php echo ($evento->tipo != 2) ? 'style="display: block;"' : ''; ?> >El Calendario no está activo en el portal Personas.</div>
                        </td>
                    </tr>

                    <?php if($this->user->tieneRol('cal-publicador')): ?>
                    <tr>
                        <td class="titulo">Destacado</td>
                        <td>
                            <label><input type="radio" name="destacado" value="1" <?= ($evento->destacado == 1) ? 'checked="checked"' : '' ?> /> Si</label>
                            <label><input type="radio" name="destacado" value="0" <?= ($evento->destacado == 0) ? 'checked="checked"' : '' ?> /> No</label>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr id="informacion">
                        <td class="titulo"><label for="informacion">Información</label></td>
                        <td><textarea name="informacion" class="" style="border: 1px #aaa solid;" maxlength="150" rows="3" cols="64" placeholder="Tiene 150 caracteres para describir el evento..." <?= ($readonly) ? 'readonly' : '' ?>/><?= $evento->informacion; ?></textarea></td>
                    </tr>

                </table>
                
            </fieldset>
        
        <table>
            <tr>
                <td><p class="red">* Campos Obligatorios</p></td>
            </tr>
            <tr>
                <td colspan="2" class="botones">
                    <?php $this->load->view('backend/widgets/botones.php') ?>
                </td>
            </tr>
        </table>
    </form>

    <script src="assets/js/eventos.js"></script>
</div>