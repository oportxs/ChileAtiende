<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exterior extends CI_Controller {

    public function index() {
        $this->etapas();
    }

    public function etapas() {
        $data = $this->_load_common_data();
        
        $data['etapas'] = Doctrine_Query::create()->from('EtapaEmpresa')->orderBy('orden asc')->execute();
        
        $data['slide'] = 'etapas';
        $data['title'] = 'Portada';
        //$data['content'] = 'portada/emprendete/slider';
        $data['content'] = 'portada/emprendete_v2/etapas';
        $data['hidden_buscador'] = 1;
        
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        //$this->load->view('emprendete', $data);
        $this->load->view('template_exterior', $data);
    }

    public function subtemas($id) {
        redirect('empresas', 301);
        $subtema = Doctrine::getTable('ChileclicSubtema')->find($id);

        $this->session->set_flashdata('subtema', $subtema->id . "#" . $subtema->nombre);

        $fichas = Doctrine_Query::create()
                ->from('Ficha f, f.Maestro m ,m.ChileclicSubtemas s')
                ->andWhere('f.maestro=0 and f.publicado=1 and s.id=?', $id)
                ->execute();


        $data['subtema'] = $subtema;
        $data['fichas'] = $fichas;

        $data['perfil'] = 'empresas';
        $data['title'] = 'Portada Empresas';
        $data['content'] = 'empresas/subtemas';

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template', $data);
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

        $fichas_por_pagina = 4;
        $options['limit'] = $fichas_por_pagina;

        $fichasMasVistas = Doctrine::getTable('Ficha')->MasVistasEmpresa(array('limit' => $fichas_por_pagina, 'last_week' => true));
        //$fichasDestacadas = Doctrine::getTable('Ficha')->MasDestacadasEmpresa(4);

        $data['fichasMasVistas'] = $fichasMasVistas;
        //$data['fichasDestacadas'] = $fichasDestacadas;

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