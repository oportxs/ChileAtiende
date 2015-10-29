<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Portada extends CI_Controller {

    public function index($modulo=FALSE) {

        $data = $this->_load_common_data();
        $dataMeta = $this->_load_meta();
        $data['tab_tema'] = TRUE;

        $data['esPortada'] = true;        
        $data['slide'] = 'front';
        $data['title'] = null;
        $data['content'] = 'portada/portada';

        if (isset($modulo) && ($modulo)) {
          $data["display_mod_atencion"] = true;
          $data["modulos"] = Doctrine::getTable('ModuloAtencion')->ModulosOrdenados();
        }

        //Obtiene las ultimas noticias del portal
        $data['noticias'] = Doctrine::getTable('Noticia')->ultimasNoticias(array('limit' => 3));
        $data['etapas'] = Doctrine_Query::create()->from('EtapaVida')->orderBy('orden asc')->execute();
        $data['temas'] = Doctrine_Query::create()->from('Tema t, t.Fichas f')->where('f.id>0')->groupBy('nombre')->execute();
        $data['accesos'] = Doctrine_Query::create()->from('Tema t')->where('t.destacado=1')->execute();
		$data['hidden_buscador'] = 0;//para busqueda entre chileatiende y emprendete, el valor 1 es de emprendete, esto para mantener la logica de navegacion

        $data = array_merge($data, $dataMeta);
        
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_v2', $data);
    }

    function etapas() {

        $data = $this->_load_common_data();

        $data['etapas'] = Doctrine_Query::create()->from('EtapaVida')->orderBy('orden asc')->execute();
        $data['temas'] = Doctrine_Query::create()->from('Tema t, t.Fichas f')->where('f.id>0')->groupBy('nombre')->execute();
        $data['active_slide'] = 'etapas';
        $data['titulo'] = 'Seleccione una etapa de vida';

        $data['slide'] = 'etapas';
        $data['title'] = 'Etapas';
        $data['content'] = 'portada/slider_v2';

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_v2', $data);
    }

    function temas() {
        $data = $this->_load_common_data();

        $data['etapas'] = Doctrine_Query::create()->from('EtapaVida')->orderBy('orden asc')->execute();
        $data['temas'] = Doctrine_Query::create()->from('Tema t, t.Fichas f')->where('f.id>0')->groupBy('nombre')->execute();
        $data['active_slide'] = 'temas';
        $data['titulo'] = 'Seleccione un tema de su interés';

        $data['slide'] = 'etapas';
        $data['title'] = 'Temas';
        $data['content'] = 'portada/slider_v2';

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('template_v2', $data);
    }

    public function modulo() {
        echo $this->index(TRUE);
    }
    
    public function barramodulo($codigo_modulo_activo = null, $v2 = false)
    {
        if($v2){
            $this->load->view('moduloatencion/barra_v2', array('codigo_modulo_activo' => $codigo_modulo_activo));
        }else{
            $this->load->view('moduloatencion/barra', array('codigo_modulo_activo' => $codigo_modulo_activo));
        }
    }

    public function sitemap($mobile=false) {
        ini_set("memory_limit","256M");
        
        $options['limit'] = 0;
        $options['offset'] = 0;
        
        $publicadas = Doctrine::getTable('Ficha')->findPublicados($options);
        /*
        $publicadas = Doctrine_Query::create()
                        ->from('Ficha')
                        ->where('maestro=1 AND publicado=1')
                        ->execute(array(), Doctrine_Core::HYDRATE_ON_DEMAND);
        */
        $aData["publicadas"] = $publicadas;
        
        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('sitemap', $aData);
    }
    
    function sitemapmobile() {
        $this->sitemap(true);
    }

    function _load_common_data() {

        $fichas_por_pagina = 12;
        $options['limit'] = $fichas_por_pagina;

        $fichasMasVistas = Doctrine::getTable('Ficha')->MasVistas(array('limit' => $fichas_por_pagina, 'last_week' => true));
        $fichasDestacadas = Doctrine::getTable('Ficha')->MasDestacadas($fichas_por_pagina);
        $fichasNuevas = Doctrine::getTable('Ficha')->MasNuevas($fichas_por_pagina);

        $data['oficinas'] = Doctrine::getTable('Oficina')->findByServicioCodigo('AL005');
        $data['comunas'] = Doctrine_Query::create()
                ->from('Sector s, s.Oficinas o')
                ->select('s.*, COUNT(o.id) noficinas')
                ->where('s.tipo="comuna"')
                ->having('noficinas > 0')
                ->groupBy('s.codigo')
                ->orderBy('s.nombre asc')
                ->execute();

        $data['fichasMasVistas'] = $fichasMasVistas;
        $data['fichasDestacadas'] = $fichasDestacadas;
        $data['fichasNuevas'] = $fichasNuevas;
        
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