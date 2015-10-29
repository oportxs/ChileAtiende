<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EtapasEmpresa extends CI_Controller {
    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();

        if (!UsuarioBackendSesion::usuario()->tieneRol('reportero')) {
            echo 'No tiene permisos';
            exit;
        }
    }

    function index() {
        $etapasempresa = Doctrine::getTable('EtapaEmpresa')->findAll();

        $data['title'] = 'Backend - Etapas Empresa';
        $data['content'] = 'backend/etapasempresa/index';
        $data['etapasempresa'] = $etapasempresa;

        $this->load->view('backend/template', $data);
    }
    
    function agregar() {
        
        $data['title'] = 'Backend - Agregar Etapas empresa';
        $data['content'] = 'backend/etapasempresa/agregar';
        
        $this->load->view('backend/template', $data);
    }

    function editar($id) {

        $etapaempresa = Doctrine::getTable('EtapaEmpresa')->find($id);

        $data['title'] = 'Backend - Etapas empresa ' . $etapaempresa->nombre;
        $data['content'] = 'backend/etapasempresa/editar';
        $data['etapa'] = $etapaempresa;

        $this->load->view('backend/template', $data);
    }
    
    function form_guardar($id) {
        $respuesta = new stdClass();
        $etapa = Doctrine::getTable('EtapaEmpresa')->find($id);
        
        if (!UsuarioBackendSesion::usuario()->tieneRol('editor')) {
            echo 'No tiene permisos';
            exit;
        }

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $etapa->nombre = $this->input->post('nombre');
            $etapa->descripcion = $this->input->post('descripcion');
            $etapa->save();

            $this->session->set_flashdata('message', 'Etapa actualizada exitosamente! :)');

            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/etapasempresa');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
    
    function form_agregar() {
        $respuesta = new stdClass();
        
        if (!(UsuarioBackendSesion::usuario()->tieneRol('editor'))) {
            echo 'No tiene permisos';
            exit;
        }

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $etapa = new EtapaEmpresa();

            $etapa->nombre = $this->input->post('nombre');
            $etapa->descripcion = $this->input->post('descripcion');
            $etapa->save();

            $this->session->set_flashdata('message', 'Etapa creada exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/etapasempresa');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
    
    function borrar($etapa_id) {
        if (!UsuarioBackendSesion::usuario()->tieneRol('editor')) {
            echo 'No tiene permisos';
            return;
        }
        
        $etapa = Doctrine::getTable('EtapaEmpresa')->find($etapa_id);

        $etapa->delete();
        redirect('backend/etapasempresa');
    }
}