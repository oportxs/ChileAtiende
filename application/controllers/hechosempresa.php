<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class HechosEmpresa extends CI_Controller {

    function ajax_get_hechos() {
        $respuesta = array();

        $etapa_id = $this->input->get('etapa_id');
        if ($etapa_id) {
            $etapa = Doctrine_Query::create()->from('EtapaEmpresa e, e.HechosEmpresa h')->where('e.id= ? AND h.Fichas.id>0 and h.Fichas.publicado=1 and h.Fichas.maestro = 1',$etapa_id)->fetchOne();
            //debug($etapa->getSqlQuery());
            $respuesta = $etapa->toArray();
        }

        echo json_encode($respuesta);
    }

}