<form class="ajaxForm form form-horizontal" method="post" action="<?= site_url('contacto/enviaemailamigo') ?>">
<?php if ($is_ajax): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<?php endif ?>
    <h2>Enviar a un amigo</h2>
    <p>Utilice este formulario para recomendar este contenido a un amigo.</p>
<?php if ($is_ajax): ?>
    </div>
<?php endif ?>
<?php if ($is_ajax): ?>
    <div class="modal-body">
<?php endif ?>
    <fieldset>
        <legend>Información Personal</legend>
        <div class="control-group">
            <div class="control-label">
                <label for="amigo_nombres">Nombre*</label>
            </div>
            <div class="controls">
                <input type="text" class="input-xlarge required" id="amigo_nombres" name="nombres" />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="amigo_email">Correo Electrónico*</label>
            </div>
            <div class="controls">
                <input type="text" class="input-xlarge required email" id="amigo_email" name="email" />
            </div>
        </div>        
        <legend>Información Amigo</legend>
        <div class="control-group">
            <div class="control-label">
                <label for="amigo_nombres_a">Nombre*</label>
            </div>
            <div class="controls">
                <input type="text" class="input-xlarge required" id="amigo_nombres_a" name="nombres_a" />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="amigo_email_a">Correo Electrónico*</label>
            </div>
            <div class="controls">
                <input type="text" class="input-xlarge required email" id="amigo_email_a" name="email_a" />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="amigo_comentarios">Ingrese sus mensaje</label>
            </div>
            <div class="controls">
                <textarea name="comentarios" class="input-xlarge" id="amigo_comentarios" rows="4"></textarea>
            </div>
        </div>        
    </fieldset>
    <?php if (!$is_ajax): ?>
        <br />
        <p><input type="submit" class="submit" value="Enviar" data-ga-te-category="Acciones" data-ga-te-action="Enviar" data-ga-te-value="Contacto" /></p>
    <?php endif ?>
<?php if ($is_ajax): ?>
    </div>
    <div class="modal-footer">
        <div class="validacion"></div>
        <button type="submit" class="btn btn-primary" data-ga-te-category="Acciones" data-ga-te-action="Enviar" data-ga-te-value="Contacto">Enviar</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    </div>
<?php endif ?>
</form>
