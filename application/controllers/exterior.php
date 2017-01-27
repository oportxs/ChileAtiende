<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exterior extends CI_Controller {

    public function index() {
        $data = $this->_load_common_data();
        $data['title'] = 'Portada ChileAtiende en el Exterior';
        $data['content'] = 'portada/exterior_tabs';
        $data['hidden_buscador'] = 1;
        
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_exterior', $data);
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


        $data['fichas_exterior'] = array(
            'permanentes' => Doctrine::getTable('Ficha')->FichasExterior(1,$fichas_por_pagina),
            'temporal' => Doctrine::getTable('Ficha')->FichasExterior(2,$fichas_por_pagina),
            'viaje' => Doctrine::getTable('Ficha')->FichasExterior(3,$fichas_por_pagina)
        );

        // $fichasMasVistas = Doctrine::getTable('Ficha')->MasVistasEmpresa(array('limit' => $fichas_por_pagina, 'last_week' => true));
        // //$fichasDestacadas = Doctrine::getTable('Ficha')->MasDestacadasEmpresa(4);

        // $data['fichasMasVistas'] = $fichasMasVistas;
        // //$data['fichasDestacadas'] = $fichasDestacadas;

        $nroFichas = Doctrine::getTable('Ficha')->totalPublicados('empresas');
        $data['nroFichas'] = ( substr($nroFichas, -1) > 0 ) ? $nroFichas - substr($nroFichas, -1) : $nroFichas;
        $data['esPortada'] = true;
        
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