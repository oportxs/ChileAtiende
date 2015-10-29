<?php
    $date = new DateTime();
    $message = $this->session->flashdata('message');
?>
<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    Alertas
</div>

<?php
if ($message) {
    echo '<ul class="message">';
    echo '<li>';
    echo '<div class="mensaje">' . $message . '</div>';
    echo '</li>';
    echo '</ul>';
}
?>

<div class="pane">
    <h2>Alertas</h2>

    <p><a class="boton" href="<?php echo site_url('backend/alertas/agregar' ); ?>"><img src="<?php echo base_url('assets/images/backend/add.png'); ?>" /> Agregar</a></p>

    <table class="display tabla" id="tablafichas">
        <thead>
            <tr>
                <th>Título</th>
                <th>Publicado</th>
                <th>Estado</th>
                <th width="10%">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($alertas as $alerta): ?>
                <tr>
                    <td><?php echo $alerta->titulo; ?></td>
                    <td>
                        <a href="<?php echo site_url('backend/alertas/publicar/'.$alerta->id); ?>">
                        <?php if($alerta->publicado): ?>
                            <img src="assets/images/backend/tick.png" alt="Publicado" title="Publicado">
                        <?php else: ?>
                            <img src="assets/images/backend/cross.png" alt="No Publicado" title="No Publicado">
                        <?php endif; ?>
                        </a>
                    </td>
                    <td>
                        <?php $desde = DateTime::createFromFormat('Y-m-d H:i:s', $alerta->desde) ?>
                        <?php $hasta = DateTime::createFromFormat('Y-m-d H:i:s', $alerta->hasta) ?>
                        <?php if ($date >= $desde && $date <= $hasta): ?>
                            Activa
                        <?php else: ?>
                            Caducada
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo site_url('backend/alertas/editar/'.$alerta->id); ?>"><img src="<?php echo base_url('assets/images/backend/pencil.png'); ?>" alt="Editar" title="Editar"></a>
                        <a onclick="return confirm('Está seguro que desea eliminar la alerta [<?php echo $alerta->titulo; ?>]')" href="<?php echo site_url('backend/alertas/eliminar/'.$alerta->id); ?>"><img src="<?php echo base_url('assets/images/backend/delete.png'); ?>" alt="Eliminar" title="Eliminar"></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(!count($alertas)): ?>
                <tr>
                    <td colspan="2">No hay alertas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php echo $this->pagination->create_links() ?>
</div>