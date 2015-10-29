<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/etapasempresa') ?>">Etapas empresa</a> »
    <span>Editar Etapa empresa #<?= $etapa->id ?></span>
</div>

<div class="pane">
    <h2>Editar Etapa empresa</h2>
    

    <fieldset>
        <legend>Datos etapa empresa<?= $etapa ? ' - ' . $etapa->nombre : '' ?></legend>
        <form class="ajaxForm" action="<?= site_url('backend/etapasempresa/form_guardar' . ( $etapa ? '/' . $etapa->id : '')) ?>" method="post" accept-charset="utf-8">
            <div class="validacion"></div>
            <table class="formTable">
                <tr>
                    <td class="titulo">Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="80" value="<?= $etapa ? $etapa->nombre : '' ?>" /></td>
                </tr>
                <tr>
                    <td class="titulo">Descripción</td>
                    <td><textarea id="editorA" name="descripcion" cols="80" rows="15"><?= $etapa ? $etapa->descripcion : '' ?></textarea></td>
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
