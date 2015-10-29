<div class="participacion no-print hidden-phone rs_skip">
    <div class="row-fluid participacion-header">
        <div class="btn-participacion btn-opina" data-participacion="opina">
            <a href="#" data-ga-te-category="Acciones Ficha" data-ga-te-action="Participacion - que opinas" data-ga-te-value="<?php echo $ficha->maestro_id; ?>"><div class="opina-icon"></div> ¿Qué opinas de esta información?</a>
        </div>
        <div class="btn-participacion btn-reporta-error" data-participacion="reporta-error">
            <a href="#" data-ga-te-category="Acciones Ficha" data-ga-te-action="Participacion - hay errores" data-ga-te-value="<?php echo $ficha->maestro_id; ?>"><div class="reporta-icon"></div> ¿Hay algún error en esta información?</a>
        </div>
    </div>
    <div class="row-fluid participacion-formularios">
        <div class="span12 participacion-formulario formulario-opina">
            <form action="<?php echo site_url('participaciones/ajax_guarda_participacion_opinion/'.$ficha->id); ?>" method="get">
                <div class="row-fluid">
                    <div class="span12 informacionutil">
                        <span>¿Te parece útil esta información?</span>
                        <label for="informacionutil-s" class="checked"><input type="radio" name="informacionutil" id="informacionutil-s" value="s" checked="checked"> Sí</label>
                        <label for="informacionutil-n"><input type="radio" name="informacionutil" id="informacionutil-n" value="n"> No</label>
                    </div>
                    <div class="span12 busquedafacil">
                        <span>¿Encuentras fácilmente la información que buscas?</span>
                        <label for="busquedafacil-s" class="checked"><input type="radio" name="busquedafacil" id="busquedafacil-s" value="s" checked="checked"> Sí</label>
                        <label for="busquedafacil-n"><input type="radio" name="busquedafacil" id="busquedafacil-n" value="n"> No</label>
                    </div>
                    <div class="span12 quemejorar">
                        <label for="quemejorar">¿Qué podemos mejorar?</label>
                        <textarea name="quemejorar" class="input-block-level" id="quemejorar" rows="10"></textarea>
                    </div>
                    <div class="span12">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
                <input type="text" name="nombre" id="name-opina" value="">
            </form>
            <div class="ajax-msg"></div>
        </div>
        <div class="span12 participacion-formulario formulario-reporta-error">
            <form action="<?php echo site_url('participaciones/ajax_guarda_participacion_error/'.$ficha->id); ?>" method="get">
                <div class="row-fluid">
                    <div class="span12">
                        <label for="errorestramite">¿Qué errores tiene este trámite?</label>
                        <textarea name="errorestramite" class="input-block-level" id="errorestramite" rows="10"></textarea>
                    </div>
                    <div class="span12">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
                <input type="text" name="nombre" id="name-reporta-error" value="">
            </form>
            <div class="ajax-msg"></div>
        </div>
    </div>
</div>