<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/hechosempresa') ?>">Hechos de empresa</a> »
    <span>Editar Hecho de empresa #<?= $hecho->id ?></span>
</div>

<div class="pane">
    <h2>Editar Hecho de empresa</h2>

    <fieldset>
        <legend>Datos hecho de empresa<?= $hecho ? ' - ' . $hecho->nombre : '' ?></legend>
        <form class="ajaxForm" action="<?= site_url('backend/hechosempresa/form_guardar' . ( $hecho ? '/' . $hecho->id : '')) ?>" method="post" accept-charset="utf-8">
            <table class="formTable">
                <tr>
                    <td class="titulo">Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="80" value="<?= $hecho ? $hecho->nombre : '' ?>" /></td>
                </tr>
                <tr>
                    <td class="titulo">Descripción</td>
                    <td><textarea id="editorA" name="descripcion" cols="80" rows="15"><?= $hecho ? $hecho->descripcion : '' ?></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">Etapas de empresa <span class="red">*</span></td>
                    <td>
                        <select data-placeholder="Seleccione una(s) Etapa(s) de empresa" name="etapas[]" class="chzn-select" style="width: 600px;" multiple>
                            <?php foreach ($etapasempresa as $etapa): ?>
                                <option value="<?= $etapa->id ?>" 
                                <?php
                                if ($hecho->hasEtapaEmpresa($etapa->id))
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
