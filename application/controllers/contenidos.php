<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contenidos extends CI_Controller {
    public function _remap($method, $url_contenido)
    {
        //Se busca si existe un contenido asociado al nombre pasado como metodo entregado
        $contenido = Doctrine::getTable('Contenido')->findOneByUrlAndPublicadoAndMaestro($method,1,0);
        if($contenido){
            $this->ver($method, $contenido);
        }else{
            if(method_exists($this, $method))
                $this->$method($url_contenido);
            else
                show_404();
        }
    }

    public function ver($url_contenido, Contenido $contenido = null)
    {
        if(!$contenido)
            $contenido = Doctrine::getTable('Contenido')->findOneByUrlAndPublicadoAndMaestro($url_contenido,1,0);
        
        if(!$contenido){
            show_404();
        }else{
            $es_empresa        = $this->input->get('e') && $this->input->get('e') == 1 ? true:false;
            $es_exterior        = $this->input->get('exterior') && $this->input->get('exterior') == 1 ? true:false;
            $theme             = $es_empresa ? 'template_emprendete_v2' : 'template_v2';
            $theme             = ($es_exterior)?"template_exterior":$theme;
            $data['contenido'] = $contenido;
            $data['title'] = $contenido->titulo;
            $data['content'] = 'contenido/'.$contenido->plantilla;
            $this->output->cache($this->config->item('cache'));
            $this->load->view($theme, $data);
        }
    }
}