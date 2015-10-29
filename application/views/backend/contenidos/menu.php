<ul class="tabs">
    <li>
        <a <?php echo ($tab=='ver'?'class="active"':''); ?>href="<?php echo site_url('backend/contenidos/ver/'.$contenido->id); ?>">Ver</a>
    </li>
    <li>
        <a <?php echo ($tab=='editar'?'class="active"':''); ?>href="<?php echo site_url('backend/contenidos/editar/'.$contenido->id); ?>">Editar</a>
    </li>
    <li>
        <a <?php echo ($tab=='historial'?'class="active"':''); ?>href="<?php echo site_url('backend/contenidos/historial/'.$contenido->id); ?>">Historial</a>
    </li>
</ul>