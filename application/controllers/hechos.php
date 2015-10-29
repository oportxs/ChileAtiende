<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hechos extends CI_Controller {

    function ajax_get_hechos(  ) {
        $respuesta=array();

        $etapa_id=$this->input->get('etapa_id');
        if($etapa_id){
            //$etapa=Doctrine::getTable('EtapaVida')->find($etapa_id);
            //$etapa->refreshRelated('HechosVida');
            $query = Doctrine_Query::create()
                    ->from('EtapaVida e, e.HechosVida h')
                    ->where('e.id= ? AND h.Fichas.id>0 and h.Fichas.publicado=1 and h.Fichas.maestro = 0',$etapa_id);
            
            $query->useResultCache(new Doctrine_Cache_Apc());
            $query->setResultCacheLifeSpan(600);

            $etapa = $query->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

            $respuesta = $etapa[0];
        }

        echo json_encode($respuesta);

    }
}