<div class="breadcrumb">
    <a href="<?php echo site_url('backend/portada'); ?>">Administración</a> »
    <a href="<?php echo site_url('backend/tramitesenconvenio'); ?>">Trámites en convenio</a> »
    <span><?php echo ($tramite->titulo?$tramite->titulo:'Nuevo Trámite'); ?></span>
</div>
<div id="tramites_en_convenio_edit" class="pane">
    <h2>Trámite en convenio</h2>
    <?php echo validation_errors('<p class="error">', '</p>'); ?>
    <form action="backend/tramitesenconvenio/guardar/<?php echo ($tramite->id?$tramite->id:''); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <table class="formTable">
            <tr>
                <td>Id Ficha</td>
                <td>
                    <input type="text" id="ficha_id" name="ficha_id" size="15" value="<?php echo set_value('ficha_id', $tramite->ficha_id); ?>">
                    <a href="<?php echo site_url('backend/tramitesenconvenio/get_datos_ficha/'); ?>" id="trae_datos_ficha">Traer datos Ficha</a>
                </td>
            </tr>
            <tr>
                <td>Título <span class="red">*</span></td>
                <td><input type="text" id="titulo" name="titulo" size="75" value="<?php echo set_value('titulo', $tramite->titulo); ?>" /></td>
            </tr>
            <tr>
                <td>Url Trámite <span class="red">*</span></td>
                <td><input type="text" id="url_tramite" name="url_tramite" size="75" value="<?php echo set_value('url_tramite', $tramite->url_tramite); ?>"></td>
            </tr>
            <tr>
                <td>Url imagen</td>
                <td><input type="text" name="url_imagen" size="75" value="<?php echo set_value('url_imagen', $tramite->url_imagen); ?>"></td>
            </tr>
        </table>
        <h2>Oficinas</h2>
        <table width="100%">
            <tr>
                <td style="text-align: right;">
                    Id Trámite en convenio
                    <input type="text" id="ficha_oficina_id" name="ficha_oficina_id" size="15"><br/>
                    <a href="<?php echo site_url('backend/tramitesenconvenio/get_sucursales_tramite_en_convenio/'); ?>" id="trae_oficinas_ficha">Traer oficinas de otro trámite en convenio</a>
                    <div id="feedback_service"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" value="1" id="global" name="global" <?php echo set_checkbox('global', '1', $tramite->global); ?>>
                    <label for="global">
                        Disponible en todos los puntos de atención
                    </label>
                </td>
            </tr>
            <tr class="oficinas-include-block">
                <td class="oficinas-include-block">
                    <label for="oficinas">Oficinas en las que está disponible el trámite.</label>
                </td>
            </tr>
            <tr class="oficinas-include-block">
                <td colspan="2" class="oficinas-include-block">
                    <select id="oficinas-include" data-placeholder="Oficinas Incluídas" name="oficinas[]" class="chzn-select" style="width: 100%" multiple>
                        <option value=""></option>
                        <?php
                        foreach ($oficinas as $oficina) :
                            ?>
                            <option value="<?= $oficina->id ?>" <?php if ($tramite->hasOficina($oficina->id)) echo 'selected="selected"' ?>><?= $oficina->nombre ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </td>
            </tr>

            <tr class="oficinas-exclude-block">
                <td class="oficinas-exclude-block">
                    <label for="oficinas-exclude">Oficinas en las que <strong>NO está disponible</strong>  el trámite.</label>
                </td>
            </tr>
            <tr class="oficinas-exclude-block">
                <td colspan="2" class="oficinas-exclude-block">
                    <select id="oficinas-exclude" data-placeholder="Oficinas Excluídas" name="oficinas-exclude[]" class="chzn-select" style="width: 100%" multiple>
                        <option value=""></option>
                        <?php
                        foreach ($oficinas as $oficina) :
                            ?>
                            <option value="<?= $oficina->id ?>" <?php if (!$tramite->hasOficina($oficina->id)) echo 'selected="selected"' ?>><?= $oficina->nombre ?></option>
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
                <td colspan="2">
                    <button type="submit" class="guardar">Guardar</button>
                    <button type="button" class="cancelar" onclick="javascript:history.back()">Cancelar</button>
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
    (function($){
        $(function(){
            var inputFichaId = $('#ficha_id'),
                linkTraeDatosFicha = $('#trae_datos_ficha');

            linkTraeDatosFicha.on('click', function(e){
                var url = this.href;
                if(inputFichaId.val()){
                    $.getJSON(url+'?ficha_id='+inputFichaId.val())
                        .success(function(data){
                            if(data){
                                $('#titulo').val(data.titulo);
                                $('#url_tramite').val(data.url);
                            }else{
                                $('#titulo').val('');
                                $('#url_tramite').val('');
                            }
                        });
                }
                e.preventDefault();
            });
        });
    })(jQuery);
</script>