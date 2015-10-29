<div class="breadcrumb">
    <a href="<?php echo site_url('backend/portada'); ?>">Administración</a> »
    <span>Contenidos</span>
</div>
<div class="pane">
    <h2>Contenidos</h2>
    <?php if ($this->session->flashdata('message') != ''): ?>
        <ul class="message">
            <li>
                <div class="mensaje"><?php echo $this->session->flashdata('message'); ?></div>
            </li>
        </ul>
    <?php endif ?>
    <p>
        <a class="boton" href="<?php echo site_url('backend/contenidos/agregar'); ?>"><img src="assets/images/backend/add.png"> Agregar Contenido</a>
    </p>
    <table class="display tabla" id="tablacontenidos">
        <thead>
            <tr>
                <th class="sortable">
                    <a href="<?php echo site_url('backend/contenidos/'); ?>">Id</a>
                </th>
                <th class="sortable">
                    <a href="<?php echo site_url('backend/contenidos/'); ?>">Título</a>
                </th>
                <th class="sortable">
                    <a href="<?php echo site_url('backend/contenidos/'); ?>">Publicado</a>
                </th>
                <th class="sortable">
                    <a href="<?php echo site_url('backend/contenidos/'); ?>">Plantilla</a>
                </th>
                <th class="sortable">
                    <a href="<?php echo site_url('backend/contenidos/'); ?>">Url</a>
                </th>
                <th class="sortable" style="text-align:center;">
                    <a href="<?php echo site_url('backend/contenidos/'); ?>">Última<br/>Modificación</a>
                </th>
                <th>
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contenidos as $key => $contenido): ?>
                <tr>
                    <td>
                        <?php echo $contenido->id; ?>
                    </td>
                    <td>
                        <?php echo $contenido->titulo; ?>
                    </td>
                    <td>
                        <?php echo $contenido->publicado?'<img src="assets/images/backend/tick.png" alt="Publicado" title="Publicado" />':'<img src="assets/images/backend/cross.png" alt="No Publicado" title="No Publicado" />'; ?>
                    </td>
                    <td>
                        <?php echo $contenido->plantilla; ?>
                    </td>
                    <td>
                        <?php echo $contenido->url; ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo ($contenido->updated_at) ? strftime("%d/%m/%Y<br/>%H:%M", strtotime($contenido->updated_at)) : '' ?>
                    </td>
                    <td>
                        <a title="<?php echo $contenido->titulo ?>" href="<?php echo site_url('backend/contenidos/editar/'.$contenido->id); ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a>
                        <a href="<?php echo site_url('backend/contenidos/eliminar/'.$contenido->id); ?>" onclick="return confirm('¿Está seguro que desea eliminar este Cotenido?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>