<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/alertas') ?>">Alertas</a> »
    <span>Agregar nueva alerta</span>
</div>

<div class="pane">
    <h2>Nueva Alerta</h2>

    <fieldset>
        <form class="ajaxForm" action="<?= site_url('backend/alertas/' . ($alerta->id ? 'post_editar/'.$alerta->id : 'post_agregar')) ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td><label for="publicado">Publicado</label></td>
                    <td>
                        <input type="radio" name="publicado" id="publicado_si" value="1" <?php echo $alerta->publicado ? 'checked="checked"' : ''; ?>/>
                        <label for="publicado_si">Si</label>
                        <input type="radio" name="publicado" id="publicado_no" value="0" <?php echo !$alerta->publicado ? 'checked="checked"' : ''; ?>/>
                        <label for="publicado_no">No</label>
                    </td>
                </tr>
                <tr>
                    <td><label for="titulo">Título <span class="red">*</span></label></td>
                    <td><input type="text" name="titulo" id="titulo" size="60" value="<?php echo $alerta->titulo; ?>" /></td>
                </tr>
                <tr>
                    <td><label for="descripcion">Descripción <span class="red">*</span></label></td>
                    <td><textarea name="descripcion" id="descripcion" cols="60" rows="10"><?php echo $alerta->descripcion; ?></textarea></td>
                </tr>
                <tr>
                    <td><label for="tipo">Tipo</label></td>
                    <td>
                        <?php $tipos = array('info' => 'Información', 'warning' => 'Warning', 'danger' => 'Danger'); ?>
                        <select id="tipo" data-placeholder="Tipo" name="tipo" class="chzn-select" style="width: 250px;">
                            <?php foreach($tipos as $tipo => $nombre): ?>
                                <option value="<?php echo $tipo; ?>" <?php echo $tipo == $alerta->tipo ? 'selected="selected"' : ''; ?>><?php echo $nombre; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="desde">Desde <span class="red">*</span></label></td>
                    <td>
                        <input type="text" class="datetimepicker" name="desde" id="desde" value="<?php echo date('d-m-Y H:i', strtotime($alerta->desde)); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td><label for="hasta">Hasta <span class="red">*</span></label></td>
                    <td>
                        <input type="text" class="datetimepicker" name="hasta" id="hasta" value="<?php echo date('d-m-Y H:i', strtotime($alerta->hasta)); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td><label for="url">Urls <span class="red">*</span></label></td>
                    <td>
                        <ul style="width: 535px;" class="tagitUrlAlertas">
                            <?php foreach ($alerta->Urls as $url): ?>
                                <li class="tagit-choice">
                                    <?= $url->url ?>
                                    <a class="close">x</a>
                                    <input type="hidden" name="urls[]" value="<?= $url->url ?>" />
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
                <tr><td><p class="red">* Campos Obligatorios</p></td></tr>
                <tr>
                    <td colspan="2" class="botones">
                        <button type="submit" class="guardar">Guardar</button>
                        <button type="button" class="cancelar"><a href="<?= site_url('backend/alertas') ?>" style="color:#FFF">Cancelar</a></button>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
<script>
    $('.datetimepicker').datetimepicker({
        format : "d-m-Y H:i"
    });
</script>