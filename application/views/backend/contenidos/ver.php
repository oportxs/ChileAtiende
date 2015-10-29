<div class="breadcrumb">
    <a href="<?php echo site_url('backend/portada'); ?>">Administración</a> »
    <a href="<?php echo site_url('backend/contenidos'); ?>">Contenidos</a> »
    <span><?php echo $contenido->titulo; ?></span>
</div>
<div class="pane">
    <?php $this->load->view('backend/contenidos/menu', array('tab' => 'ver')) ?>
    <table class="formTable">
        <tr>
            <td style="font-weight: bold;" width="120">Título</td>
            <td><?= prepare_content_ficha($contenido->titulo) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;" width="120">Url</td>
            <td><?= prepare_content_ficha($contenido->url) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;" width="120">Contenido</td>
            <td><?= prepare_content_ficha($contenido->contenido) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;" width="120">Plantilla</td>
            <td><?php echo ucfirst($contenido->plantilla); ?></td>
        </tr>
    </table>
</div>
<div style="text-align: center;">
    <?php if ($contenido->publicado): ?>
        <a class="boton" href="<?php echo site_url('backend/contenidos/despublicar/'.$contenido->id); ?>">Despublicar</a>
        <?php if (!$contenido->getUltimaVersion()->publicado): ?>
            <a class="boton" href="<?php echo site_url('backend/contenidos/publicar/'.$contenido->id); ?>">Publicar úlitma versión</a>
        <?php endif ?>
    <?php else: ?>
        <a class="boton" href="<?php echo site_url('backend/contenidos/publicar/'.$contenido->id); ?>">Publicar</a>
    <?php endif ?>
</div>