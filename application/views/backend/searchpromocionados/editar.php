<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/searchpromocionados') ?>">Resultados Con Todo</a> »
    <span>Editar Resultado #<?= $promocionado->id ?></span>
</div>

<div class="pane">
    <h2>Editar Resultado Con Todo</h2>

    <fieldset>
        <legend>Datos resultado - <?= $promocionado->titulo ?></legend>
        <div class="validacion"></div>
        <form class="ajaxForm" action="<?= site_url('backend/searchpromocionados/form_editar/' . $promocionado->id) ?>" method="post" >
            <table class="formTable">
                <tr>
                    <td>¿Activada? <span class="red">*</span></td>
                    <td><label><input type="checkbox" name="activo" value="1" <?=$promocionado->activo?'checked':''?> /> Si, activar este resultado.</label></td>
                </tr>
                <tr>
                    <td>Orden <span class="red">*</span></td>
                    <td><input type="text" name="orden" size="10" value="<?= $promocionado->orden ?>" /></td>
                </tr>
                <tr>
                    <td>Título <span class="red">*</span></td>
                    <td><input type="text" name="titulo" size="50" value="<?= $promocionado->titulo ?>" /></td>
                </tr>
                <tr>
                    <td>Introtext <span class="red">*</span></td>
                    <td><textarea name="introtext" cols="50"><?= $promocionado->introtext ?></textarea></td>
                </tr>
                <tr>
                    <td>Enlace <span class="red">*</span></td>
                    <td><input type="text" name="url" size="50" value="<?= $promocionado->url ?>" /></td>
                </tr>
                <tr>
                    <td>Query de busqueda <span class="red">*</span><br />(Separados por coma)</td>
                    <td><input type="text" name="query" size="50" value="<?= $promocionado->query ?>" /></td>
                </tr>
                <tr>
                    <td>¿Expresión Regular? <span class="red">*</span></td>
                    <td><label><input type="checkbox" name="regex" value="1" <?=$promocionado->regex?'checked':''?> /> Si, tomar la el query de busqueda como una expresión regular.</label></td>
                </tr>
                <tr>
                    <td colspan="2"><p class="red">* Campos Obligatorios</p></td>
                </tr>
                <tr>
                    <td colspan="2" class="botones">
                        <?php $this->load->view('backend/widgets/botones.php') ?>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
