<form id='formContactenos' class='ajaxForm' action='<?= site_url('contacto/sugerencias_form') ?>'>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <legend>¿Qué opina del nuevo sitio?</legend>
</div>
<div class="modal-body">
        <div class="validacion"></div>
        <div class='row-fluid'>
            <div class='span12'>
        <label>Nombres</label>
        <input class='span12' type='text' name='nombres' />
            </div>
        </div>
        <div class='row-fluid'>
            <div class='span6'>
                <label>Apellido Paterno</label>
                <input class='span11' type='text' name='paterno' />
            </div>
            <div class='span6'>
                <label>Apellido Materno</label>
                <input class='span11' type='text' name='materno' />
            </div>
        </div>

        <div class='row-fluid'>
            <div class='span6'>
                <label>Correo Electrónico</label>
                <input class='span11' type='text' name='email' />
            </div>
            <div class='span6'>
                <label>Tema</label>
                <select class='span11' name='tema'>
                    <option value=''></option>
                    <option value='Sugerencia'>Sugerencia</option>
                    <option value='Reportar un error'>Reportar un error</option>
                    <option value='Comentario General'>Comentario General</option>
                </select>
            </div>
        </div>


        <div class='row-fluid'>
            <div class='span12'>

        <label>Ingrese sus comentarios</label>
        <textarea class='span12' name='comentarios' rows='5'></textarea>
        <input type="text" name="correo" id="name-opina" value="">
            </div>
        </div>
</div>
<div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
    <a href="#" class="btn btn-primary" onclick='javascript:$("#formContactenos").submit()'>Enviar</a>
</div>
</form>
