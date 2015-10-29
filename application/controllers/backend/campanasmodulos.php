<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CampanasModulos extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->config->item('ssl'))
            force_ssl();

        $this->user = UsuarioBackendSesion::usuario();
        UsuarioBackendSesion::checkLogin();
    }

    public function index() {
        if (!($this->user->tieneRol(array('editor', 'aprobador', 'publicador')) )) {
            echo 'No tiene permisos';
            exit;
        }

        $data['title'] = 'Backend - Campañas Módulos de atención';
        $data['content'] = 'backend/campanasmodulos/index';
        $data['campanas'] = Doctrine::getTable('CampanaModulo')->findAll();

        $this->load->view('backend/template', $data);
    }
    
    public function editar($id) {
        $campana = Doctrine::getTable('CampanaModulo')->find($id);
        $sectores = Doctrine::getTable('Sector')->findByTipo('region');
        
        $data['title'] = 'Backend - Campaña Módulo de atención ' . $campana->titulo;
        $data['content'] = 'backend/campanasmodulos/editar';
        $data['campana'] = $campana;
        $data['sectores'] = $sectores;

        $this->load->view('backend/template', $data);
    }
    
    function form_guardar($id) {
        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
        $this->form_validation->set_rules('url', 'Url', 'trim|required');
        $this->form_validation->set_rules('estado', 'Estado', 'trim|numeric|required');

        if ($this->form_validation->run() == TRUE) {
            $campana = Doctrine::getTable('CampanaModulo')->find($id);

            $campana->titulo = $this->input->post('titulo');
            $campana->url = $this->input->post('url');
            $campana->estado = $this->input->post('estado');
            $campana->setSectoresFromArray($this->input->post('sector'));

            $campana->save();

            $this->session->set_flashdata('message', 'Campaña para Módulo de atención guardada exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/campanasmodulos/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
    
    function agregar() {
        $sectores = Doctrine::getTable('Sector')->findByTipo('region');
        
        $data['title'] = 'Backend - Campaña Módulo de atención ';
        $data['content'] = 'backend/campanasmodulos/agregar';
        $data['sectores'] = $sectores;

        $this->load->view('backend/template', $data);
    }

    function form_agregar() {
        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
        $this->form_validation->set_rules('url', 'Url', 'trim|required');
        $this->form_validation->set_rules('estado', 'Estado', 'trim|numeric|required');

        if ($this->form_validation->run() == TRUE) {
            $campana = new CampanaModulo();
            $campana->titulo = $this->input->post('titulo');
            $campana->url = $this->input->post('url');
            $campana->estado = $this->input->post('estado');
            $campana->setSectoresFromArray($this->input->post('sector'));

            $campana->save();

            $this->session->set_flashdata('message', 'Campaña para Módulo de atención creada exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/campanasmodulos/');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    function borrar($id) {
        $campana = Doctrine::getTable('CampanaModulo')->find($id);
        $campana->delete();
        redirect('backend/campanasmodulos');
    }

}
