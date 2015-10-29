<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/modulosatencion') ?>">Módulos de atención</a> »
    Campañas
</div>

<div class="pane">
    <h2>Listado de Campañas para los Módulos de atención</h2>
    
    <?= $this->session->flashdata('message') ? '<div class="message">' . $this->session->flashdata('message') . '</div>' : '' ?>
    
    <p>
    	<a class="boton" href="<?= site_url('backend/campanasmodulos/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Campaña</a>
    </p>
    <table class="tabla">
        <tr>
            <th>Título</th>
            <th>Url</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php
        if (count($campanas)) {
            $cnt = 1;
            foreach ($campanas as $campana) :
                $class = ($cnt & 1) ? 'odd' : 'even';
                ?>
                <tr>
                    <td class="<?=$class?>"><?= $campana->titulo ?></td>
                    <td class="<?=$class?>"><a href="<?php echo $campana->url; ?>"><?= $campana->url ?></a></td>
                    <td class="<?=$class?>"><?= $campana->estado?'Activa':'Inactiva'; ?></td>
                    <td class="<?=$class?>"><a href="<?= site_url('backend/campanasmodulos/editar/' . $campana->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a> <a href="<?= site_url('backend/campanasmodulos/borrar/' . $campana->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar esta Campaña?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a></td>
                </tr>
                <?php
                $cnt++;
            endforeach;
        } else {
            ?>
            <tr>
                <td colspan="2" class="noregistros">No se encontraron registros</td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>