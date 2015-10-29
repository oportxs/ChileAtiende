<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Resultados Con Todo</span>
</div>

<div class="pane">
    <h2>Resultados Con Todo</h2>
    
    <?= $this->session->flashdata('message') ? '<div class="message">' . $this->session->flashdata('message') . '</div>' : '' ?>
    
    <p><a class="boton" href="<?= site_url('backend/searchpromocionados/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Resultado Con Todo</a></p>
    <table class="tabla">
        <tr>
            <th>Orden</th>
            <th>Título</th>
            <th>Query</th>
            <th>Regex</th>
            <th>Activo</th>
            <th>Acción</th>
        </tr>
        <?php
        if (count($promocionados)) {
            $cnt = 1;
            foreach ($promocionados as $p) :
                $class = ($cnt & 1) ? 'odd' : 'even';
                ?>
                <tr>
                    <td class="<?=$class?>"><?= $p->orden ?></td>
                    <td class="<?=$class?>"><?= $p->titulo ?></td>
                    <td class="<?=$class?>"><?= $p->query ?></td>
                    <td class="<?=$class?>"><?= $p->regex?'Si':'No' ?></td>
                    <td class="<?=$class?>"><?= $p->activo?'Si':'No' ?></td>
                    <td class="<?=$class?>"><a href="<?= site_url('backend/searchpromocionados/editar/' . $p->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a> <a href="<?= site_url('backend/searchpromocionados/borrar/' . $p->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar este Resultado Promocionado?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a></td>
                </tr>
                <?php
                $cnt++;
            endforeach;
        } else {
            ?>
            <tr>
                <td colspan="2" class="noregistros">No se encontraron registros</td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
