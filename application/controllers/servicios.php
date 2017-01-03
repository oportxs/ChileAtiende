<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Servicios extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->side_panel_limit = 4;
    }

    function ver($codigo, $offset=null) {

        $options['limit'] = $this->side_panel_limit;
        //Obtengo fichas destacadas
        $fichasDestacadas = Doctrine::getTable('Ficha')->MasDestacadas( $this->side_panel_limit );

        $data['fichasDestacadas'] = $fichasDestacadas;

        $offset = $this->input->get('offset', true) ? $this->input->get('offset', true) - 1 : 0;
        $per_page = 10;

        $servicio = Doctrine::getTable('Servicio')->find($codigo);

        //Ordenar por titulo A->Z
        $fichas = Doctrine::getTable('Ficha')->findFichaOnServicio($codigo, array('limit' => $per_page, 'offset' => $offset));
        $nfichas = Doctrine::getTable('Ficha')->findFichaOnServicio($codigo, array('justCount' => TRUE));

        $entidad = $servicio->Entidad;

        $data['categorytabs_closed'] = TRUE;
        $data['title'] = ''.$servicio->nombre;
        $data['content'] = 'servicios/ver_v2';
        $data['servicio'] = $servicio;
        $data['fichas'] = $fichas;
        $data['entidad'] = $entidad;

        $config['base_url'] = url_buscador();
        $config['total_rows'] = $nfichas;
        $config['per_page'] = $per_page;

        $this->pagination->initialize($config);

        $data['base_url'] = site_url('servicios/ver/'.$codigo.'/');
        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nfichas;
        $data['paginacion'] = $this->pagination->create_links();

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_v2', $data);
    }

    function directorio() {
        $servicios = Doctrine_Query::create()
                        ->from('Servicio s')
                        ->orderBy('s.nombre')
                        ->execute();
        $servicios = Doctrine::getTable('Servicio')->findConPublicaciones();
        $data['categorytabs_closed'] = TRUE;
        $data['title'] = 'Directorio';
        $data['content'] = 'servicios/directorio';
        $data['servicios'] = $servicios;
        $data['hidden_buscador'] = 0;

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_v2', $data);
    }

    function directorioExterior() {
        $servicios = Doctrine_Query::create()
                        ->from('Servicio s')
                        ->orderBy('s.nombre')
                        ->execute();
        $servicios = Doctrine::getTable('Servicio')->findConPublicacionesExterior();
        $data['categorytabs_closed'] = TRUE;
        $data['title'] = 'Directorio';
        $data['content'] = 'servicios/directorioext';
        $data['servicios'] = $servicios;
        $data['hidden_buscador'] = 0;

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_exterior', $data);
    }

}