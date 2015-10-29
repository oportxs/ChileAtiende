<?php

class ApiHitTable extends Doctrine_Table {

    function insertarHit($idAccesoApi) {
        
        $aData = array($idAccesoApi, date('Y-m-d'));
        $query = Doctrine_Query::create()->from('ApiHit');
        $query->where("api_acceso_id=? AND fecha=?", $aData);
        
        $fichaHit = $query->fetchOne();
        if ($fichaHit) {
            $fichaHit->count = $fichaHit->count + 1;
        } else {
            $fichaHit = new ApiHit();
            $fichaHit->count = 1;
            $fichaHit->fecha = date('Y-m-d');
            $fichaHit->api_acceso_id = $idAccesoApi;
        }
        
        $fichaHit->save();
    }

}