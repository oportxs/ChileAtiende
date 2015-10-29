<?php

$message = $this->session->flashdata('message');
?>
<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> » SubFichas
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
    <h2>SubFichas</h2>

    <?php $this->load->view('backend/widgets/filtro_institucion') ?>

    <?php $this->load->view('backend/widgets/filtro_titulo') ?>
    <?php // $this->load->view('backend/widgets/filtro_publico') ?>

    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - 
        <?= min($offset + $per_page, $total) ?> de 
        <?= $total ?> resultados</span></div>

    <table class="display tabla" id="tablafichas">
        <thead>
            <?php
            $orden = $imagen_id = $imagen_titulo = $imagen_publicado = $imagen_updated = $img = '';

            /* Veo si hay order by para los campos */
            $field = $this->input->get('field');
            if ($field) {

                $order_by = $this->input->get('order_by');

                if ($order_by) {

                    $orden = (strpos($order_by, "ASC") === FALSE) ? "ASC" : "DESC";
                    $img = ($orden == "ASC") ? 'arrow_up.png' : 'arrow_down.png';
                    $img = "<img src='assets/images/backend/" . $img . "' border='0' />";

                    $imagen_id = ($field == 'id') ? $img : '';
                    $imagen_titulo = ($field == 'titulo') ? $img : '';
                    $imagen_publicado = ($field == 'publicado') ? $img : '';
                    $imagen_updated = ($field == 'updated_at') ? $img : '';
                }
            }
            ?>
            <tr>
<!--                 <th class="sortable">
                    Código
                    <?= $imagen_id ?>
                </th> -->
                <?php if ($this->user->tieneRol('publicador')): ?>
                <th class="sortable">Institución</th>
                <?php endif; ?>
                <th class="sortable">Nombre del Tramite</th>
                <th>Dest.</th>
                <?php if ($this->uri->segment(4) != "publicados"): ?>
                <th class="sortable">Estado</th>
                <?php endif; ?>
                <th class="sortable">Publicado</th>
                <th class="sortable centrado" style="text-align:center;">Última<br/>Modificación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($subfichas)) {
                $cnt = 1;
                foreach ($subfichas as $subficha) {
                    $color = ($cnt & 1) ? '#FFF' : '#EDEDED';
                    ?>
                    <tr style="background-color: <?= $color ?>">
                        <!-- <td><span style="font-size:9px;">NO HAY CODIGO</span></td> -->
                        <?php 
                        if ($this->user->tieneRol('publicador')) { 
                        ?>
                            <td class="centrado"><?php echo $subficha->Servicio->nombre; ?></td>
                        <?php 
                        } 
                        $url = ($this->user->tieneRol('publicador')) ? '<a title="'. strip_tags($subficha->MetaFicha->titulo) .'" href="'. site_url('backend/subfichas/ver/' . $subficha->id) .'">'. character_limiter($subficha->MetaFicha->titulo, 100) .'</a>' : character_limiter($subficha->MetaFicha->titulo, 100);
                        ?>
                        <td><?=$url?></td>

                        <td class="centrado"><?= ($subficha->MetaFicha->destacado) ? '<img src="assets/images/backend/tick.png" alt="Destacada" title="Destacada" />' : '<img src="assets/images/backend/cross.png" alt="No Destacada" title="No Destacada" />' ?></td>

                        <?php
                        if ($this->uri->segment(4) != "publicados") {
                            ?>
                            <td>
                                <?php 
                                switch($subficha->estado) { 
                                    case "en_revision":
                                        echo "Para revisión";
                                        break;
                                    case "rechazado":
                                        echo "Con observación";
                                        break;
                                    default:
                                        echo "";
                                        break;
                                }
                                ?>
                            </td>
                            <?php
                        }
                        ?>
                        <td class="centrado">
                            <?= $subficha->publicado ? '<img src="assets/images/backend/tick.png" alt="Publicado" title="Publicado" />' : anchor("backend/subfichas/publicar/" . $subficha->id, '<img src="assets/images/backend/cross.png" alt="No Publicado" title="No Publicado" />') ?>
                        </td>

                        <td style="text-align:center;"><?php echo ($subficha->updated_at) ? strftime("%d/%m/%Y<br/>%H:%M", strtotime($subficha->updated_at)) : '' ?></td>
                        <td class="centrado">
                            <a title="<?= $subficha->MetaFicha->titulo ?>" href="<?= site_url('backend/subfichas/editar/' . $subficha->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a>
                        </td>
                    </tr> 
                    <?php
                    $cnt++;
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" class="noregistros">No se encontraron registros</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - <?= min($offset + $per_page, $total) ?> de <?= $total ?> resultados</span></div>
    <?php echo $this->pagination->create_links() ?>
</div>
