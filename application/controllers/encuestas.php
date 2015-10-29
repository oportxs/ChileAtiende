<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Encuestas extends CI_Controller {
    public function grabaResultadoEncuesta($encuesta_id){
//        $encuesta = Doctrine::getTable('Encuesta')->find($encuesta_id);

        $ficha_id = $this->input->post('ficha_id');
        $ficha_publicada_id = $this->input->post('ficha_publicada_id');
        $resultado = $this->input->post('resultado');

        $ficha = Doctrine::getTable('Ficha')->find($ficha_id);

        $encuestaResultado = new EncuestaResultado();
        $encuestaResultado->encuesta_id = $encuesta_id;
        $encuestaResultado->ficha_maestro_id = $ficha_id;
        $encuestaResultado->ficha_publicada_id = $ficha_publicada_id;
        $encuestaResultado->resultado = $resultado;

        $encuestaResultado->save();

        echo json_encode(array('errors' => false, 'message' => 'Gracias por participar!'));
    }
}