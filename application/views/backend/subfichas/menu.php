<ul class="tabs">
    <li><a <?= (isset($tab) && $tab=="ver")?"class='active'":""; ?> href="<?= site_url('backend/subfichas/ver/' . $subficha->id) ?>">Ver</a></li>
    <?php
    if( ( ($this->user->tieneRol('editor')?'1':'0') ) && !(($subficha->locked)?'1':'0') ) {
    ?>
    <li><a <?= (isset($tab) && $tab=="editar")?"class='active'":""; ?> href="<?= site_url('backend/subfichas/editar/' . $subficha->id) ?>">Editar</a></li>    
    <?php } ?>
    <li><a <?= (isset($tab) && $tab=="versiones")?"class='active'":""; ?> href="<?= site_url('backend/subfichas/versiones/' . $subficha->id) ?>">Versiones</a></li>
    <li><a <?= (isset($tab) && $tab=="historial")?"class='active'":""; ?> href="<?= site_url('backend/subfichas/historial/' . $subficha->id) ?>">Historial</a></li>
    <?php
    if ( ($this->user->tieneRol(array('editor', 'aprobador', 'publicador'))) && ($subficha->publicado)  ) {
    ?>
    <li><a <?= (isset($tab) && $tab=="previsualizar")?"class='active'":""; ?> href="<?= site_url('backend/subfichas/previsualizar/' . $subficha->id) ?>" class="popup">Previsualizar</a></li>
    <?php
    }
    ?>
    <!-- <li><a <?= (isset($tab) && $tab=="stats")?"class='active'":""; ?> href="<?= site_url('backend/subfichas/stats/' . $subficha->id) ?>">Estadísticas</a></li> -->
</ul>