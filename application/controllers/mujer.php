<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mujer extends CI_Controller {

    public function index() {
        $data = $this->_load_common_data();
        $data['title'] = 'Portada ChileAtiende Mujer';
        $data['content'] = 'portada/mujer_tabs';
        $data['hidden_buscador'] = 1;
        
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_mujer', $data);
    }

    public function subtemas($id) {
        redirect('empresas', 301);
    }

    function apoyos() {
        $data = $this->_load_common_data();

        $apoyosestado = Doctrine_Query::create()->from('ApoyoEstado ae, ae.Fichas f')->where('f.id>0')->groupBy('nombre')->execute();
        $data['apoyosestado'] = $apoyosestado;

        $data['slide'] = 'apoyos';
        $data['title'] = 'Apoyo Estatal';
        $data['content'] = 'portada/emprendete/slider';

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('emprendete', $data);
    }
    
    function temas() {
        $data = $this->_load_common_data();

        $data['generos'] = Doctrine::getTable("Genero")->findAll();
        $temas = Doctrine_Query::create()->from('TemaEmpresa t, t.Fichas f')->where('f.id>0')->groupBy('nombre')->execute();
        $data['temas'] = $temas;

        $data['slide'] = 'temas';
        $data['title'] = 'Temas';
        $data['content'] = 'portada/emprendete/slider';

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('emprendete', $data);
    }

    function _load_common_data() {

        $fichas_por_pagina = 9;
        $options['limit'] = $fichas_por_pagina;

        $data['tramites_mujer'] = Doctrine::getTable('Ficha')->findBy('es_tramite_mujer', true);
        $data['tramites_mujer_destacado'] = Doctrine::getTable('Ficha')->findBy('es_tramite_mujer_destacado', true);
        
        return $data;
    }

    function _load_meta() {
        $descripcion = Doctrine::getTable('Configuracion')->find('descripcion')->valor;
        $keywords = Doctrine::getTable('Configuracion')->find('keywords')->valor;
        $autor = Doctrine::getTable('Configuracion')->find('autor')->valor;

        $data["descripcion"] = $descripcion;
        $data["keywords"] = $keywords;
        $data["autor"] = $autor;

        return $data;
    }

}