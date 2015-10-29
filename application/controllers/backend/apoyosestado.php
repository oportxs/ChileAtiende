<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ApoyosEstado extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->config->item('ssl'))
            force_ssl();

        UsuarioBackendSesion::checkLogin();

        if (!UsuarioBackendSesion::usuario()->tieneRol('reportero')) {
            echo 'No tiene permisos';
            exit;
        }
    }

    public function index() {
        $per_page = 15;
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'id';
        
        $apoyosestado = Doctrine::getTable('ApoyoEstado')->todosApoyos( array('limit' => $per_page, 'offset' => $offset, 'order_by' => $order_by) );
        $napoyosestado = Doctrine::getTable('ApoyoEstado')->todosApoyos( array('justCount' => TRUE) );
        
        $etapasempresa = Doctrine::getTable('EtapaEmpresa')->findAll();
        
        $data['title'] = 'Backend - Apoyo estatal';
        $data['content'] = 'backend/apoyosestado/index';
        $data['apoyosestado'] = $apoyosestado;
        $data['etapasempresa'] = $etapasempresa;
        
        $this->pagination->initialize(array(
            'base_url' => site_url('backend/apoyosestado/?order_by=' . $order_by),
            'total_rows' => $napoyosestado,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $napoyosestado;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
    }

    function agregar() {
        $etapasempresa = Doctrine::getTable('EtapaEmpresa')->findAll();

        $data['title'] = 'Backend - Agregar Apoyo estatal';
        $data['content'] = 'backend/apoyosestado/agregar';
        $data['etapasempresa'] = $etapasempresa;

        $this->load->view('backend/template', $data);
    }

    function editar($id) {

        $apoyoestado = Doctrine::getTable('ApoyoEstado')->find($id);
        $etapasempresa = Doctrine::getTable('EtapaEmpresa')->findAll();

        $data['title'] = 'Backend - Apoyo estatal ' . $apoyoestado->nombre;
        $data['content'] = 'backend/apoyosestado/editar';
        $data['apoyo'] = $apoyoestado;
        $data['etapasempresa'] = $etapasempresa;

        $this->load->view('backend/template', $data);
    }

    function form_guardar($id) {
        $respuesta = new stdClass();
        
        if (!UsuarioBackendSesion::usuario()->tieneRol('editor')) {
            echo 'No tiene permisos';
            exit;
        }
        $apoyo = Doctrine::getTable('ApoyoEstado')->find($id);

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $apoyo->nombre = $this->input->post('nombre');
            $apoyo->setEtapasEmpresaFromArray($this->input->post('etapas'));
            $apoyo->save();

            $this->session->set_flashdata('message', 'Apoyo actualizado exitosamente! :)');

            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/apoyosestado');
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
        
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|callback_is_new');

        if ($this->form_validation->run() == TRUE) {
            $apoyo = new ApoyoEstado();

            $apoyo->nombre = $this->input->post('nombre');
            $apoyo->setEtapasEmpresaFromArray($this->input->post('etapas'));
            $apoyo->save();

            $this->session->set_flashdata('message', 'Apoyo creado exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/apoyosestado');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }
    
    function is_new($name){
        
        $etapas = $this->input->post('etapas');
        foreach($etapas as $etapa){
            list($apoyo) = Doctrine::getTable('ApoyoEstado')->getEtapaName($etapa,$name);
            if ($apoyo && $apoyo->nombre == $name){
                $this->form_validation->set_message('is_new', 'Ya existe una etapa con el nombre <strong>'.$name.'</strong> en otra etapa de empresa');
                return FALSE;
            }
        }
        return TRUE;
        
    }

    function borrar($apoyo_id) {
        $apoyo = Doctrine::getTable('ApoyoEstado')->find($apoyo_id);

        if (!UsuarioBackendSesion::usuario()->tieneRol('editor')) {
            echo 'No tiene permisos';
            return;
        }

        $apoyo->delete();
        redirect('backend/apoyosestado');
    }

}