<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sitemap extends CI_Controller {
    function index() {
        
        //$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'file'));
       
        
        $data['categorytabs_closed'] = TRUE;       
        $data['title'] = 'Mapa del Sitio';
        $data['content'] = 'sitemap/index_v2';
        $data['servicios'] = Doctrine::getTable('Servicio')->findConPublicaciones();
        $data['etapas'] = Doctrine::getTable('EtapaVida')->findAll();
        $data['temas'] = Doctrine::getTable('Tema')->findAll();
        $data['oficinas_regiones'] = Doctrine::getTable('Sector')->findWithOptions(array('tipo'=>'region'));
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_v2', $data);
        
    }
}