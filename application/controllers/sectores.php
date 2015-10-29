<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sectores extends CI_Controller {

    public function ajax_get_info($sector_id) {

        $sector = Doctrine::getTable('Sector')->find($sector_id);
        if ($sector) {
            if (count($sector->Oficinas) == 1) {
                $sector['lat'] = $sector->Oficinas[0]['lat'];
                $sector['lng'] = $sector->Oficinas[0]['lng'];
            }

            echo json_encode($sector->toArray());
        }
    }

}