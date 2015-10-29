<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apoyos extends CI_Controller {

    function ajax_get_apoyos(  ) {
        $respuesta=array();

        $etapa_id=$this->input->get('etapa_id');
        if($etapa_id){
            //$etapa=Doctrine::getTable('EtapaVida')->find($etapa_id);
            //$etapa->refreshRelated('HechosVida');
            $etapa = Doctrine_Query::create();
            $etapa->from('EtapaEmpresa e, e.ApoyosEstado ae');
            $etapa->where('e.id= ? AND ae.Fichas.id>0 and ae.Fichas.publicado=1 and ae.Fichas.maestro = 0',$etapa_id);
            $etapa->orderBy('ae.order_by ASC');
            //echo $etapa->getSqlQuery();
            $query = $etapa->fetchOne();

            $respuesta = $query->toArray();
        }
        
        echo json_encode($respuesta);
        
    }
}