<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/modulosatencion') ?>">Modulos de atención</a> »
    <a href="<?= site_url('backend/campanasmodulos') ?>">Campañas Modulos de atención</a> »
    <span>Editar Campaña Módulo de atención</span>
</div>

<div class="pane">
    <h2>Editar Campaña Módulo de atención </h2>

    <fieldset>
        <legend>Datos campaña</legend>
        <form class="ajaxForm" action="<?= site_url('backend/campanasmodulos/form_guardar/'.$campana->id) ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
            		<tr>
                    <td>ID</td>
                    <td><?= $campana ? $campana->id : '' ?></td>
                </tr>
                <tr>
                    <td>Título <span class="red">*</span></td>
                    <td><input type="text" name="titulo" id="titulo" size="60" value="<?php echo $campana->titulo; ?>" /></td>
                </tr>
                <tr>
                    <td>Url <span class="red">*</span></td>
                    <td><input type="text" name="url" id="url" size="60" value="<?php echo $campana->url; ?>" /></td>
                </tr>
                <tr>
                	<td>Estado</td>
                	<td>
                		<select name="estado" id="estado">
                			<option value="0"<?php echo $campana->estado?' selected="selected"':''; ?>>Inactiva</option>
                			<option value="1"<?php echo $campana->estado?' selected="selected"':''; ?>>Activa</option>
                		</select>
                	</td>
                </tr>
                <tr>
                    <td>Sector</td>
                    <td>
                        <select data-placeholder="Seleccione su Sector"  name="sector[]" class="chzn-select" style="width: 470px" multiple>
                            <option value=""></option>
                            <?php
                            foreach ($sectores as $sector) :
                                ?>
                                <option value="<?= $sector->codigo ?>" <?php if ($campana->tieneSector($sector->codigo)) echo 'selected="selected"' ?>><?= $sector->nombre ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2"><p class="red">* Campos Obligatorios</p></td>
                </tr>
                <tr>
                    <td colspan="2" class="botones">
                        <button type="submit" class="guardar">Guardar</button>
                        <button type="button" class="cancelar" onclick="javascript:history.back()">Cancelar</button>
                    </td>
                </tr>
            </table>
        </form>

    </fieldset>

</div>
