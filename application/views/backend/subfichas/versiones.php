<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/subfichas') ?>">SubFichas</a> »
    <span>Versiones SubFicha #<?= $subficha->id ?></span>
</div>

<div class="pane">
    <?php $this->load->view('backend/subfichas/menu',array('tab'=>'versiones')) ?>
    
    <h2>Comparador de versiones</h2>

<!-- TODO: implementar la comparacion para subfichas    
    <div class="dropProyecto">
        <h4>Comparar Versiones</h4>
        <p>Arrastre hacia esta zona las versiones que desee comparar (Máximo dos).</p>
        <ul class="proyectosList"></ul>
        <a style="display: none;" class="clear" title="Limpiar" href="#"><img src="assets/images/backend/clear.png" /> Limpiar</a>
        <a style="display: none;" class="button compareButton popupcompara" href="#"><img src="assets/images/backend/compare.png" /> Comparar</a>
    </div> -->

    
    <table class="tabla" style="width: 60%">
        <tr>
            <th>Versión</th>
            <th>Publicada</th>
            <th>Fecha de Creación</th>
            <th>Ver</th>
        </tr>
        <?php
        $cnt = 1;
        foreach ($subficha->Versiones as $version):
            $class = ($cnt & 1) ? 'odd' : 'even';
            ?>
            <tr class="dragProyecto">
                <td class="idItem <?=$class?>"><?= $version->id ?></td>
                <td class="<?=$class?>"><?= $version->publicado ? 'Si' : 'No' ?></td>
                <td class="<?=$class?>"><?= ($version->created_at) ? strftime("%d/%m/%Y %H:%M", strtotime($version->created_at)) : ''; ?></td>
                <td class="<?=$class?>"><a href="<?= site_url('backend/subfichas/compara/' . $version->id) ?>" class="popup"><img src="assets/images/backend/eye.png" /></a></td>
            </tr>
            <?php
            $cnt++;
        endforeach;
        ?>
    </table>
</div>