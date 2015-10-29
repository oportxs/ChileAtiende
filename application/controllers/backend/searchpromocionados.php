<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SearchPromocionados extends CI_Controller {
    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();

        if (!UsuarioBackendSesion::usuario()->tieneRol('mantenedor')) {
            echo 'No tiene permisos';
            exit;
        }
    }

    function index() {
        $promocionados = Doctrine_Query::create()
                ->from('SearchPromocionado s')
                ->orderBy('s.orden ASC')
                ->execute();

        $data['promocionados'] = $promocionados;
        $data['title'] = 'Backend - Resultados Promocionados';
        $data['content'] = 'backend/searchpromocionados/index';     

        $this->load->view('backend/template', $data);
    }
    
    function editar($id){
        $promocionado=Doctrine::getTable('SearchPromocionado')->find($id);
        
        $data['promocionado'] = $promocionado;
        $data['title'] = 'Backend - Editar Resultados Promocionado';
        $data['content'] = 'backend/searchpromocionados/editar';     

        $this->load->view('backend/template', $data);
    }
    
    function form_editar($id){
        $promocionado=Doctrine::getTable('SearchPromocionado')->find($id);
        
        $this->form_validation->set_rules('orden','Orden','required');
        $this->form_validation->set_rules('titulo','Título','required');
        $this->form_validation->set_rules('introtext','Introtext','required');
        $this->form_validation->set_rules('url','enlace','required');
        $this->form_validation->set_rules('query','Query de Búsqueda','required');
        
        $resultado=new stdClass();
        if($this->form_validation->run()==true){
            $promocionado->activo=$this->input->post('activo');
            $promocionado->orden=$this->input->post('orden');
            $promocionado->titulo=$this->input->post('titulo');
            $promocionado->introtext=$this->input->post('introtext');
            $promocionado->url=$this->input->post('url');
            $promocionado->query=$this->input->post('query');
            $promocionado->regex=$this->input->post('regex');
            $promocionado->save();
            
            $this->session->set_flashdata('message','El resultado promocionado se ha editado con éxito.');
            $resultado->validacion=true;
            $resultado->redirect=site_url('backend/searchpromocionados');
        }else{
            $resultado->validacion=false;
            $resultado->errores=validation_errors('<p class="error">', '</p>');
        }
        
        echo json_encode($resultado);
        
        
    }
    
    function agregar(){
        
        $data['title'] = 'Backend - Editar Resultados Promocionado';
        $data['content'] = 'backend/searchpromocionados/agregar';     

        $this->load->view('backend/template', $data);
    }
    
    function form_agregar(){     
        $this->form_validation->set_rules('orden','Orden','required');
        $this->form_validation->set_rules('titulo','Título','required');
        $this->form_validation->set_rules('introtext','Introtext','required');
        $this->form_validation->set_rules('url','enlace','required');
        $this->form_validation->set_rules('query','Query de Búsqueda','required');
        
        $resultado=new stdClass();
        if($this->form_validation->run()==true){
            $promocionado=new SearchPromocionado();
            $promocionado->activo=$this->input->post('activo');
            $promocionado->orden=$this->input->post('orden');
            $promocionado->titulo=$this->input->post('titulo');
            $promocionado->introtext=$this->input->post('introtext');
            $promocionado->url=$this->input->post('url');
            $promocionado->query=$this->input->post('query');
            $promocionado->regex=$this->input->post('regex');
            $promocionado->save();
            
            $this->session->set_flashdata('message','El resultado promocionado se ha agregado con éxito.');
            $resultado->validacion=true;
            $resultado->redirect=site_url('backend/searchpromocionados');
        }else{
            $resultado->validacion=false;
            $resultado->errores=validation_errors('<p class="error">', '</p>');
        }
        
        echo json_encode($resultado);
        
        
    }
    
    function borrar($id) {

        Doctrine::getTable('SearchPromocionado')->find($id)->delete();
        $this->session->set_flashdata('message','El resultado promocionado se ha borrado con éxito.');
        redirect('backend/searchpromocionados');
    }
    

}