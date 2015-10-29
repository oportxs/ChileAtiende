<div class="breadcrumb">
    <a href="<?php echo site_url('backend/portada'); ?>">Administración</a> »
    <a href="<?php echo site_url('backend/contenidos'); ?>">Contenidos</a> »
    <span><?php echo ($contenido->titulo?$contenido->titulo:'Nuevo Contenido'); ?></span>
</div>
<div class="pane">
    <?php if ($contenido->id): ?>
        <?php $this->load->view('backend/contenidos/menu', array('tab' => 'editar')) ?>
    <?php endif ?>
    <h2>Contenido</h2>
    <?php echo validation_errors('<p class="error">', '</p>'); ?>
    <form action="backend/contenidos/guardar/<?php echo ($contenido->id?$contenido->id:''); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <table class="formTable">
            <tr>
                <td>Título <span class="red">*</span></td>
                <td><input type="text" name="titulo" size="85" value="<?= set_value('titulo', $contenido->titulo); ?>" /></td>
            </tr>
            <tr>
                <td>Url</td>
                <td><input type="text" name="url" id="url" size="85" value="<?php echo set_value('url', $contenido->url); ?>"></td>
            </tr>
            <tr>
                <td>Contenido <span class="red">*</span></td>
                <td><textarea id="editorB" name="contenido" cols="85" rows="15"><?php echo set_value('contenido', $contenido->contenido); ?></textarea></td>
            </tr>
            <tr>
                <td>Plantilla</td>
                <td>
                    <select name="plantilla" id="plantilla">
                        <?php foreach ($plantillas as $key => $plantilla): ?>
                            <?php $nombre_plantilla = str_replace('.php', '', $plantilla); ?>
                            <option <?php echo $nombre_plantilla==$contenido->plantilla?'selected="selected"':''; ?> value="<?php echo $nombre_plantilla; ?>"><?php echo str_replace('-', ' ', ucfirst($nombre_plantilla)); ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><p class="red">* Campos Obligatorios</p></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="guardar">Guardar</button>
                    <button type="button" class="cancelar" onclick="javascript:history.back()">Cancelar</button>
                </td>
            </tr>
        </table>
    </form>
</div>