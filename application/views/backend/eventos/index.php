<?php
$message = $this->session->flashdata('message');
?>

<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <?php
    echo ($this->uri->segment(4)) ? '<a href="' . site_url('backend/eventos') . '">Eventos</a>' : '<span>Eventos</span>';
    switch ($this->uri->segment(4)) {
        case 'nopublicados':
            echo ' » No Publicados';
            break;
        case 'publicados':
            echo ' » Publicados';
            break;
    }
    ?>
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
    <h2>Eventos</h2>

    <?php $this->load->view('backend/widgets/filtro_institucion') ?>

    <p><a class="boton" href="<?= site_url('backend/eventos/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar evento</a></p>

    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - <?= min($offset + $per_page, $total) ?> de <?= $total ?> resultados</span></div>

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
                <?php if ($this->user->tieneRol('cal-publicador')) { ?><th class="sortable"><a href="<?= site_url('backend/eventos/index/' . $this->uri->segment(4) . '?field=publicado&order_by=evento.servicio_codigo ' . ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Institución</a></th><?php } ?>
                <th class="sortable"><a href="<?= site_url('backend/eventos/index/' . $this->uri->segment(4) . '?field=titulo&order_by=evento.titulo ' . ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Nombre del evento</a></th>
                <th class="sortable"><a href="<?= site_url('backend/eventos/index/' . $this->uri->segment(4) . '?field=publicado&order_by=evento.publicado ' . ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Publicado</a></th>
                <th class="sortable centrado" style="text-align:center;"><a href="<?= site_url('backend/eventos/index/' . $this->uri->segment(4) . '?field=updated_at&order_by=evento.updated_at ' . ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Última<br/>Modificación</a></th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($eventos)) {
                $cnt = 1;
                foreach ($eventos as $evento) {
                    $color = ($cnt & 1) ? '#FFF' : '#EDEDED';
                    ?>
                    <tr style="background-color: <?= $color ?>">
                        <?php 
                        if ($this->user->tieneRol('cal-publicador')): 
                        ?>
                            <td class="centrado"><?php echo $evento->Servicio->nombre; ?></td>

                        <?php 
                        endif;

                        $titulo_url = '<a title="'. strip_tags($evento->titulo) .'" href="'. site_url('backend/eventos/ver/' . $evento->id) .'">'. character_limiter($evento->titulo, 100) .'</a>';
                        ?>
                        <td><?= $titulo_url ?></td>

                        <td class="centrado">
                            <?= $evento->publicado ? '<img src="assets/images/backend/tick.png" alt="Publicado" title="Publicado" />' : anchor("backend/eventos/publicar/" . $evento->id, '<img src="assets/images/backend/cross.png" alt="No Publicado" title="No Publicado" />') ?>
                        </td>

                        <td style="text-align:center;"><?php echo ($evento->updated_at) ? strftime("%d/%m/%Y<br/>%H:%M", strtotime($evento->updated_at)) : '' ?></td>
                        
                        <td class="centrado">
                            <a title="<?= $evento->titulo ?>" href="<?= site_url('backend/eventos/ver/' . $evento->id) ?>"><img src="assets/images/backend/eye.png" alt="Ver" title="Ver" /></a>
                            
                            <?php
                            if  ( $this->user->tieneRol('cal-editor') && 
                                  $evento->publicado == 0 &&
                                  $evento->estado != "en_revision"
                                ):
                            ?>
                                <a title="<?= $evento->titulo ?>" href="<?= site_url('backend/eventos/editar/' . $evento->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a>
                            <?php
                            endif;

                            if (UsuarioBackendSesion::usuario()->tieneRol( array('cal-publicador','mantenedor') ))
                                /* no se eliminan eventos publicados */
                                if (!$evento->publicado):
                            ?>
                                    <a href="<?= site_url('backend/eventos/eliminar/' . $evento->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar esta Evento?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>
                            <?php                             
                                endif;
                            ?>
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
