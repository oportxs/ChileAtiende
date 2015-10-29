<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contenidos extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->config->item('ssl'))
            force_ssl();

        $this->user = UsuarioBackendSesion::usuario();
        UsuarioBackendSesion::checkLogin();
    }

    public function index()
    {
        $data['contenidos'] = Doctrine::getTable('Contenido')->findMaestros();

        $data['title'] = 'Backend - Listado de Contenidos';
        $data['content'] = 'backend/contenidos/lista';
        $this->load->view('backend/template', $data);
    }

    public function ver($contenido_id)
    {
        $data['contenido'] = Doctrine::getTable('Contenido')->find($contenido_id);
        $data['title'] = 'Backend - Ver contenido';
        $data['content'] = 'backend/contenidos/ver';

        $data['title'] = 'Backend - Ver contenido '.$contenido_id;
        $this->load->view('backend/template', $data);
    }

    public function editar($contenido_id)
    {
        $this->_load_form(Doctrine::getTable('Contenido')->find($contenido_id));
    }

    public function agregar()
    {
        $this->_load_form(new Contenido());
    }

    public function _load_form($contenido)
    {
        $this->load->helper('file');
        $data['plantillas'] = get_filenames('application/views/contenido/');

        $data['contenido'] = $contenido;
        $data['title'] = 'Backend - Agregar nuevo contenido';
        $data['content'] = 'backend/contenidos/form';

        $this->load->view('backend/template', $data);
    }

    public function guardar($contenido_id = null)
    {
        $this->load->helper('file');
        $respuesta = new stdClass();

        if($contenido_id)
            $contenido = Doctrine::getTable('Contenido')->find($contenido_id);
        else
            $contenido = new Contenido();

        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
        $this->form_validation->set_rules('contenido', 'Contenido', 'required');
        if ($this->form_validation->run() == TRUE) {
            try{
                $url = (!$this->input->post('url')?$this->input->post('titulo'):$this->input->post('url'));
                $contenido->titulo = $this->input->post('titulo');
                $contenido->url = url_slug($url, array('transliterate' => true));
                $contenido->contenido = $this->input->post('contenido');
                $contenido->plantilla = $this->input->post('plantilla');
                $contenido->maestro = 1;
                
                $contenido->save();
                $contenido->generarVersion();

                $this->session->set_flashdata('message', 'Contenido '.($contenido_id?'actualizado':'creado').' exitosamente');
                $respuesta->validacion = TRUE;
                redirect('backend/contenidos/ver/'.$contenido->id);
            } catch (Exception $e) {
                $respuesta->validacion = FALSE;
                $respuesta->errores = "<p class='error'>" . $e . "</p>";
            }
        }else{
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        $data['plantillas'] = get_filenames('application/views/contenido/');
        $data['contenido'] = $contenido;
        $data['content'] = 'backend/contenidos/form';
        $data['title'] = 'Backend - Guardar contenido';
        $this->load->view('backend/template', $data);
    }

    public function eliminar($contenido_id)
    {
        if(!$this->user->tieneRol('mantenedor')){
            echo 'No tiene permisos';
            return;
        }
        $contenido = Doctrine::getTable('Contenido')->find($contenido_id);

        $contenido->delete();
        redirect('backend/contenidos');
    }

    public function historial($contenido_id)
    {
        $contenido = Doctrine::getTable('Contenido')->find($contenido_id);

        if(!$this->user->tieneRol('mantenedor')){
            echo 'No tiene permisos';
            return;
        }

        $data['contenido'] = $contenido;

        $data['title'] = 'Backend - Historial contenido '.$contenido->titulo;
        $data['content'] = 'backend/contenidos/historial';

        $this->load->view('backend/template', $data);
    }

    public function publicar($contenido_id) {
        $contenido = Doctrine::getTable('Contenido')->find($contenido_id);

        if(!$this->user->tieneRol('mantenedor')){
            echo 'No tiene permisos';
            return;
        }

        $contenido->publicar();

        $this->session->set_flashdata('message', 'El contenido ha sido publicado exitósamente');

        redirect('backend/contenidos/ver/'.$contenido_id);
    }

    public function despublicar($contenido_id) {
        $contenido = Doctrine::getTable('Contenido')->find($contenido_id);

        if(!$this->user->tieneRol('mantenedor')){
            echo 'No tiene permisos';
            return;
        }

        $contenido->despublicar();

        $this->session->set_flashdata('message', 'El contenido ha sido despublicado exitósamente');

        redirect('backend/contenidos/ver/'.$contenido_id);;
    }

}

?>