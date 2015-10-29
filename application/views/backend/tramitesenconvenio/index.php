<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Trámites en convenio</span>
</div>

<div class="pane">
    <h2>Trámites en convenio</h2>

    <p><a class="boton" href="<?= site_url('backend/tramitesenconvenio/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Trámite</a></p>

    <table class="tabla">
        <thead>
            <tr>
                <th>Título</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tramites as $key => $tramite): ?>
                <tr>
                    <td>
                        <?php echo $tramite->titulo; ?>
                    </td>
                    <td>
                        <a title="<?php echo $tramite->titulo ?>" href="<?php echo site_url('backend/tramitesenconvenio/editar/'.$tramite->id); ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a>
                        <a href="<?php echo site_url('backend/tramitesenconvenio/eliminar/'.$tramite->id); ?>" onclick="return confirm('¿Está seguro que desea eliminar este Trámite?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.tabla tr').nth-child(even).style('color','#ccc');
        });
    </script>
</div>