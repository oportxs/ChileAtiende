<div class="modal hide fade" id="modal-moduloatencion" data-backdrop="static" data-keyboard="false" >
    <form action="<?php echo site_url('portada/modulo'); ?>" method="post" class="form">
        <div class="modal-header">
            <h3>Identifique su módulo de atención</h3>
        </div>
        <div class="modal-body">
            <div class="control-group">
                <div class="controls">
                    <select class="input-block-level" name="id_modulo" id="id_modulo">
                        <option value="">Seleccione</option>
                        <?php foreach ($modulos as $modulo): ?>
                            <option value="<?php echo $modulo->sector_codigo.'-'.$modulo->oficina_id.'-'.$modulo->nro_maquina; ?>"><?php echo $modulo->descripcion; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Recordar</button>
        </div>
    </form>
</div>