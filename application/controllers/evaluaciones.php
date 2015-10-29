<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluaciones extends CI_Controller {

    public function evaluar($ficha_id) {
        $updates = array('positivo' => 0, 'negativo' => 0);
        $evaluaciones = json_decode($this->input->post('valoraciones'));
        foreach($evaluaciones as $evaluacion){
            $updates[$evaluacion->tipo] += intval($evaluacion->actualizacion);
        }
        
        $ficha = Doctrine::getTable('Ficha')->find($ficha_id);

        $ficha->votos_positivos = $ficha->votos_positivos + $updates['positivo'];
        $ficha->votos_negativos = $ficha->votos_negativos + $updates['negativo'];

        $ficha->save();

        echo json_encode(array('msg' => 'Valoraciones actualizadas.'));
        
        return true;
    }

    public function get_valoraciones($ficha_id)
    {
        $ficha = Doctrine::getTable('Ficha')->find($ficha_id);
        $votos = $ficha->getVotos();
        echo json_encode($votos);

        return true;
    }
}
