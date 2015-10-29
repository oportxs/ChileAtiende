<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ServiciosDisponibles extends CI_Controller {
    
    public function index($oficinaId = false)
    {
        $this->oficina(false);
    }

    public function oficina($oficinaId = false)
    {

        $data['content'] = 'serviciosdisponibles/index';
        $data['tramites'] = Doctrine::getTable('TramiteEnConvenio')->findAll();

        if($oficinaId){
            //Una oficina en particular
            $data['oficina'] = Doctrine::getTable('Oficina')->findOneById($oficinaId);
            $data['title'] = 'Servicios disponibles en Sucursal '.$data['oficina']->nombre;
            $data['servicios'] = Doctrine::getTable('Servicio')->findConTramitesEnConvenio($data['oficina']);
        } else {
            //Todos los servicios
            $data['title'] = 'Servicios disponibles en Sucursales';
            $data['servicios'] = Doctrine::getTable('Servicio')->findConTramitesEnConvenio();
        }

        //habilitamos el cache
        //$this->output->cache($this->config->item('cache'));
        $this->load->view('template_v2', $data);
    }
}
