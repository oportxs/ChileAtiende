<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Entidades extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->side_panel_limit = 4;
    }

    function ver($codigo, $offset=null) {

        $options['limit'] = $this->side_panel_limit;
        //Obtengo fichas destacadas
        $fichasDestacadas = Doctrine::getTable('Ficha')->MasDestacadas( $this->side_panel_limit );

        $data['fichasDestacadas'] = $fichasDestacadas;

        $offset = $offset ? $offset : 0;
        $per_page = 10;

        $entidad = Doctrine::getTable('Entidad')->find($codigo);
        $fichas = Doctrine::getTable('Ficha')->findFichaOnEntidad($codigo, array('limit' => $per_page, 'offset' => $offset));
        $nfichas = Doctrine::getTable('Ficha')->findFichaOnEntidad($codigo, array('justCount' => TRUE));
        $servicios = Doctrine::getTable('Servicio')->findServiciosConFichas($codigo);

        $data['title'] = ''.$entidad->nombre;
        $data['content'] = 'entidades/ver_v2';
        $data['entidad'] = $entidad;
        $data['servicios'] = $servicios;
        $data['fichas'] = $fichas;

        $config['base_url'] = url_buscador();
        $config['total_rows'] = $nfichas;
        $config['per_page'] = $per_page;

        $this->pagination->initialize($config);

        $data['base_url'] = site_url('entidades/ver/'.$codigo.'/');
        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nfichas;
        $data['paginacion'] = $this->pagination->create_links();
        
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_v2', $data);
    }
}