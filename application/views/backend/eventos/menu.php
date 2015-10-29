<ul class="tabs">
    <li>
        <?php 
        $verTxt = $evento->publicado ? 'Ver' : (UsuarioBackendSesion::usuario()->tieneRol('cal-publicador') ? 'Publicar' : 'Revisión');
        ?>
        <a <?php echo ($tab=='ver'?'class="active"':''); ?>href="<?php echo site_url('backend/eventos/ver/'.$evento->id); ?>"><?php echo $verTxt; ?></a>
    </li>
    
    <?php
    if  ( $evento->publicado == 0 &&
          $evento->estado != "en_revision"
        ):
    ?>
    <li>
        <a <?php echo ($tab=='editar'?'class="active"':''); ?>href="<?php echo site_url('backend/eventos/editar/'.$evento->id); ?>">Editar</a>
    </li>
    <?php
    endif;
    ?>
    
    <li>
        <a <?php echo ($tab=='historial'?'class="active"':''); ?>href="<?php echo site_url('backend/eventos/historial/'.$evento->id); ?>">Historial</a>
    </li>
</ul>