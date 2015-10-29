<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Widget extends CI_Controller {

    function index() {

        $data['title'] = 'ChileAtiende en tu sitio';
        $data['content'] = 'widget/index_v2';
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_v2', $data);
    }
    
    function urls(){
        $data['servicios']=Doctrine::getTable('Servicio')->findServiciosConFichas();
        
        $data['title'] = 'ChileAtiende en tu sitio';
        $data['content'] = 'widget/urls_v2';
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_v2', $data);
    }

    public function mapa(){
      $data['title'] = 'ChileAtiende en tu sitio - Mapa oficinas';
      $data['content'] = 'widget/mapa_v2';

      $data['comunas'] = Doctrine_Query::create()
              ->from('Sector s, s.Oficinas o')
              ->select('s.*, COUNT(o.id) noficinas')
              ->where('s.tipo="comuna"')
              ->having('noficinas > 0')
              ->groupBy('s.codigo')
              ->orderBy('s.nombre asc')
              ->execute();
              
      //$this->output->cache($this->config->item('cache'));
      $this->load->view('template_v2', $data);
    }

}