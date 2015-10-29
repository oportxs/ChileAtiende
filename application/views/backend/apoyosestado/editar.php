<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/apoyosestado') ?>">Apoyos del Estado</a> »
    <span>Editar</span>
</div>

<div class="pane">
    <h2>Editar Apoyo del Estado</h2>

    <fieldset>
        <legend>Datos apoyo del estado<?= $apoyo ? ' - ' . $apoyo->nombre : '' ?></legend>
        <form class="ajaxForm" action="<?= site_url('backend/apoyosestado/form_guardar' . ( $apoyo ? '/' . $apoyo->id : '')) ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td class="titulo">Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="80" value="<?= $apoyo ? $apoyo->nombre : '' ?>" /></td>
                </tr>
                <tr>
                    <td class="titulo">Etapas de empresa <span class="red">*</span></td>
                    <td>
                        <select data-placeholder="Seleccione una(s) etapa(s) de empresa" name="etapas[]" class="chzn-select" style="width: 600px;" multiple>
                            <?php foreach ($etapasempresa as $etapa): ?>
                                <option value="<?= $etapa->id ?>" 
                                <?php
                                if ($apoyo->hasEtapaEmpresa($etapa->id))
                                    echo 'selected="selected"'
                                    ?>>
                                <?= $etapa->nombre ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2"><p class="red">* Campos Obligatorios</p></td></tr>
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