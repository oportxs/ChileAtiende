<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/eventos/') ?>">Eventos</a> »
    <span>Agregar</span>
</div>

<div class="pane">
    
	<h2>Agregar evento</h2>

    <form class="ajaxForm" method="post" action="<?= site_url('backend/eventos/agregar_form/') ?>">

        <div class="validacion"></div>
        
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
                                    echo '<option value="' . $servicio->codigo . '" >' . $servicio->nombre . '</option>';
                                }
                                ?>
                            </select>


                        </td>
                    </tr>
                    
                    <tr id="titulo">
                        <td class="titulo"><label for="titulo">Título <span class="red">*</span></label></td>
                        <td>
                            <input type="text" name="titulo" maxlength="150" size="64" placeholder="Título del evento..." value="" />
                        </td>
                    </tr>

                    <tr id="url">
                        <td class="titulo"><label for="url">Enlace <span class="red">*</span></label></td>
                        <td>
                            <input type="text" name="url" maxlength="250" size="64" placeholder="Enlace del evento..." value="" />
                        </td>
                    </tr>

                    <tr id="region">
                        <td class="titulo"><label for="region">Región <span class="red">*</span></label></td>
                        <td>
                            <input type="radio" class="region_sel" name="region_sel" id="region-todos" value="1" checked="checked" ><label for="region-todos">Todas</label>
                            <input type="radio" class="region_sel" name="region_sel" id="region-especifico" value="0" ><label for="region-especifico">Específico</label>
                            <div class="region-select" style="display:none;" >
                                <select multiple data-placeholder="Seleccione la Región" name="region[]" class="chzn-select" style="width: 450px;">
                                    <option value=""></option>
                                <?php foreach ($regiones as $r): ?>
                                    <option value="<?= $r->id ?>" ><?= $r->nombre ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>                                
                        </td>
                    </tr>

                    <tr id="permanente">
                        <td class="titulo"><label for="permanente">Duración <span class="red">*</span></label></td>
                        <td>
                            <input type="radio" name="permanente" class="permanente_sel" value="0" checked="checked" /><label>Temporal</label>
                            <input type="radio" name="permanente" class="permanente_sel" value="1" /><label>Permanente</label>
                        </td>
                    </tr>

                    <tr id="fecha" style="display: table-row;">
                        <td class="titulo"><label for="postulacion_start">Período duración <span class="red">*</span></label></td>
                        <td>
                            <input type="text" name="postulacion_start" class="postulacion_start" value="" placeholder="24-02-2013" />
                            <input type="text" name="postulacion_end" class="postulacion_end" value="" placeholder="24-03-2013" />
                            <div class="error_date" style="color: red; display: none;">Debe elegir un periodo válido para la fecha</div>
                        </td>
                    </tr>

                    <tr>
                        <td class="titulo">Público objetivo  <span class="red">*</span></td>
                        <td>
                            <label><input type="radio" name="tipo" id="personas" value="1" /> Personas</label>
                            <label><input type="radio" name="tipo" id="empresas" value="2" checked="checked" /> Empresas</label>
                            <label><input type="radio" name="tipo" id="ambos" value="3"/> Ambos</label>
                            <div id="evento_tipo_msg">El Calendario no está activo en el portal Personas.</div>
                        </td>
                    </tr>

                    <?php if($this->user->tieneRol('cal-publicador')): ?>
                    <tr>
                        <td class="titulo">Destacado</td>
                        <td>
                            <label><input type="radio" name="destacado" value="1" /> Si</label>
                            <label><input type="radio" name="destacado" value="0" checked="checked" /> No</label>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr id="informacion">
                        <td class="titulo"><label for="informacion">Información</label></td>
                        <td><textarea name="informacion" class="" style="border: 1px #aaa solid;" maxlength="150" rows="3" cols="64" placeholder="Tiene 150 caracteres para describir el evento..." /></textarea></td>
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