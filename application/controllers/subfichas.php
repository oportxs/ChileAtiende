<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SubFichas extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->side_panel_limit = 3;
    }


    function ver($id) {
        $subficha = Doctrine::getTable('SubFicha')->find($id);
        $data['subficha'] = $subficha;
        $_comunas = array();
        $_regiones = array();
        $_subfichas = $subficha->MetaFicha->SubFichas;
        foreach($_subfichas as $_subficha)
            if($_subficha->maestro == 1) {
                $_comunas[$_subficha->id] = $_subficha->Servicio->Sector;
                if(!in_array($_subficha->Servicio->Sector->SectorPadre->SectorPadre, $_regiones))
                    $_regiones[] = $_subficha->Servicio->Sector->SectorPadre->SectorPadre;
            }

        $data['regiones'] = $_regiones;
        $data['comunas'] = $_comunas;
        $data['sector_codigo'] = $subficha->Servicio->Sector->codigo;

        $this->output->cache($this->config->item('cache'));
        $output['error'] = false;
        $output['info'] = $this->load->view('subfichas/ver', $data, true);
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

}