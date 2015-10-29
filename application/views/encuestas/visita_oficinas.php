<div class="modal hide fade" id="modal-encuestas">
    <form action="<?php echo site_url('encuestas/grabaResultadoEncuesta/1'); ?>" id="form-encuestas">
        <div class="row-fluid">
            <div class="span2">
                <div class="cont-img-asisitente">
                    <img src="<?php echo base_url('assets_v2/img/encuestas/visita_oficinas/asistente_chileatiende.png'); ?>" alt="Asistente Chileatiende"/>
                </div>
            </div>
            <div class="span10">
                <div class="cont-texto-encuesta">
                    <p>
                        <strong>¡Hola!, no quiero interrumpir,</strong> sólo quiero preguntar si la información entregada para realizar este trámite, <strong>¿le ahorró al menos una visita a una oficina pública?</strong>
                    </p>
                    <p>
                        <button data-value="1" type="button" class="btn-form-encuesta btn btn-primary">Si, me ahorró una visita</button>
                        <button data-value="2" type="button" class="btn-form-encuesta btn btn-primary">Si, pero igual tengo que ir</button>
                        <button data-value="3" type="button" class="btn-form-encuesta btn btn-primary">No</button>
                    </p>
                </div>
                <div class="cont-mensaje-encuesta">
                    <p>
                        Gracias por su respuesta, su opinión nos ayuda a mejorar nuestro servicio.
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-primary pull-right">Cerrar</button>
                        <span class="clearfix"></span>
                    </p>
                </div>
            </div>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <input type="hidden" id="encuesta_ficha_id" name="ficha_id" value="<?php echo $ficha->Maestro->id; ?>"/>
        <input type="hidden" id="encuesta_ficha_publicada_id" name="ficha_publicada_id" value="<?php echo $ficha->id; ?>"/>
        <input type="hidden" id="encuesta_resultado" name="resultado" value="">
        <input type="hidden" id="encuesta_id" name="encuesta_id" value="1">
    </form>
</div>