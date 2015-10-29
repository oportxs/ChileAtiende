<div class="breadcrumb">
    <a href="<?php echo site_url('backend/portada'); ?>">Administración</a> »
    <a href="<?php echo site_url('backend/contenidos'); ?>">Contenidos</a> »
    <span><?php echo $contenido->titulo; ?></span>
</div>
<div class="pane">
    <?php $this->load->view('backend/contenidos/menu', array('tab' => 'historial')) ?>
    <h2>Historial de versiones</h2>

    <table class="logTable">
        <?php
        $cnt = 1;
        foreach ($contenido->Historiales as $l) {
            $class = ($cnt & 1) ? 'odd' : 'even';
            ?>
            <tr>
                <td class="<?=$class?>">
                    <h4>Fecha modificación:</h4><p><?= strftime('%d/%m/%Y - %H:%M', mysql_to_unix($l->created_at)) ?></p>
                    <h4>Usuario:</h4><p><?= $l->UsuarioBackend->nombres . ' ' . $l->UsuarioBackend->apellidos ?></p>
                </td>
                <td class="<?=$class?>">
                    <h3>Contenido # <?= $l->contenido_id ?> versión #<?= $l->contenido_version_id ?></h3>
                    <h4>Cambio(s) realizado(s):</h4>
                    <?= $l->descripcion; ?>
                </td>
            </tr>
            <?php
            $cnt++;
        }
        ?>
    </table>

</div>