<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Etapas extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        redirect(site_url('portada/etapas'), 'location', 301);
        $data['etapas'] = Doctrine::getTable('EtapaVida')->findAll();

        $data['theme_page'] = "d";
        $data['theme_header'] = "a";
        $data['title'] = 'Hechos de Vida';
        $data['content'] = 'movil/veretapa';

        $this->load->view('movil/template', $data);
    }

    function ver($id) {
        redirect(site_url('buscar/fichas/?etapa='.$id), 'location', 301);
        $data['etapa'] = Doctrine::getTable('EtapaVida')->find($id);


        $data['theme_page'] = "d";
        $data['theme_header'] = "a";
        $data['title'] = $data['etapa']->nombre;
        $data['content'] = 'movil/verhechos';


        $this->load->view('movil/template', $data);
    }

}
