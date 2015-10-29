<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class HechosEmpresa extends CI_Controller {

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

    function index() {

        $per_page = 15;
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'h.nombre ASC';

        $hechosempresa = Doctrine::getTable('HechoEmpresa')->todosHechos(array('limit' => $per_page, 'offset' => $offset, 'order_by' => $order_by));
        $nhechosempresa = Doctrine::getTable('HechoEmpresa')->todosHechos(array('justCount' => TRUE));

        $etapasempresa = Doctrine::getTable('EtapaEmpresa')->findAll();

        $data['title'] = 'Backend - Hechos Empresa';
        $data['content'] = 'backend/hechosempresa/index';
        $data['hechosempresa'] = $hechosempresa;
        $data['etapasempresa'] = $etapasempresa;

        $this->pagination->initialize(array(
            'base_url' => site_url('backend/hechosempresa/?order_by=' . $order_by),
            'total_rows' => $nhechosempresa,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nhechosempresa;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
    }

    function agregar() {
        $etapasempresa = Doctrine::getTable('EtapaEmpresa')->findAll();

        $data['title'] = 'Backend - Agregar Hechos empresa';
        $data['content'] = 'backend/hechosempresa/agregar';
        $data['etapasempresa'] = $etapasempresa;

        $this->load->view('backend/template', $data);
    }

    function editar($id) {

        $hechoempresa = Doctrine::getTable('HechoEmpresa')->find($id);
        $etapasempresa = Doctrine::getTable('EtapaEmpresa')->findAll();

        $data['title'] = 'Backend - Hechos de Vida ' . $hechoempresa->nombre;
        $data['content'] = 'backend/hechosempresa/editar';
        $data['hecho'] = $hechoempresa;
        $data['etapasempresa'] = $etapasempresa;

        $this->load->view('backend/template', $data);
    }

    function form_guardar($id) {
        $respuesta = new stdClass();

        if (!UsuarioBackendSesion::usuario()->tieneRol('editor')) {
            echo 'No tiene permisos';
            exit;
        }

        $hecho = Doctrine::getTable('HechoEmpresa')->find($id);

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $hecho->nombre = $this->input->post('nombre');
            $hecho->descripcion = $this->input->post('descripcion');
            $hecho->setEtapasEmpresaFromArray($this->input->post('etapas'));
            $hecho->save();

            $this->session->set_flashdata('message', 'Hecho actualizado exitosamente! :)');

            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/hechosempresa');
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
            $hecho = new HechoEmpresa();

            $hecho->nombre = $this->input->post('nombre');
            $hecho->descripcion = $this->input->post('descripcion');
            $hecho->setEtapasFromArray($this->input->post('etapas'));
            $hecho->save();

            $this->session->set_flashdata('message', 'Hecho creado exitosamente! :)');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/hechosempresa');
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    function is_new($name) {

        $etapas = $this->input->post('etapas');
        foreach ($etapas as $etapa) {
            list($hecho) = Doctrine::getTable('HechoEmpresa')->getEtapaName($etapa, $name);
            if ($hecho && $hecho->nombre == $name) {
                $this->form_validation->set_message('is_new', 'Ya existe una ficha con el nombre <strong>' . $name . '</strong> en otra etapa de empresa');
                return FALSE;
            }
        }
        return TRUE;
    }

    function borrar($hecho_id) {
        $hecho = Doctrine::getTable('HechoEmpresa')->find($hecho_id);

        if (!UsuarioBackendSesion::usuario()->tieneRol('editor')) {
            echo 'No tiene permisos';
            return;
        }

        $hecho->delete();
        redirect('backend/hechosempresa');
    }

}