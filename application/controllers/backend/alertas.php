<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Alertas extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->config->item('ssl'))
            force_ssl();

        $this->user = UsuarioBackendSesion::usuario();
        UsuarioBackendSesion::checkLogin();


        if(!$this->user->tieneRol(array('mantenedor', 'jefaturaweb'))){
            echo 'No tiene permisos';
            return;
        }
    }

    public function index(){
        $data['title'] = 'Alertas';
        $options['per_page'] = 20;
        $options['limit'] = $this->input->get('limit') ? $this->input->get('limit') : $options['per_page'];
        $options['offset'] = $this->input->get('offset') ? $this->input->get('offset') : 0;

        $alertas = Doctrine::getTable('Alerta')->findWithOptions($options);
        $total = Doctrine::getTable('Alerta')->findWithOptions(array_merge($options, array('count' => true)));

        $data['alertas'] = $alertas;
        $data['content'] = 'backend/alertas/index';
        $data['options'] = $options;

        $this->pagination->initialize(array(
            'base_url' => site_url('backend/alertas/index?orderby=id&orderdir=asc'),
            'total_rows' => $total,
            'per_page' => $options['per_page'],
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $this->load->view('backend/template', $data);
    }

    public function agregar(){
        $data['title'] = 'Nueva alerta';
        $alerta = new Alerta();

        $data['alerta'] = $alerta;
        $data['content'] = 'backend/alertas/form';

        $this->load->view('backend/template', $data);
    }

    public function editar($alerta_id){
        $data['title'] = 'Editar alerta';
        $alerta = Doctrine::getTable('Alerta')->find($alerta_id);

        $data['alerta'] = $alerta;
        $data['content'] = 'backend/alertas/form';

        $this->load->view('backend/template', $data);
    }

    public function eliminar($alerta_id){
        $alerta = Doctrine::getTable('Alerta')->find($alerta_id);
        $alerta->delete();

        redirect('backend/alertas');
    }

    public function publicar($alerta_id){
        $alerta = Doctrine::getTable('Alerta')->find($alerta_id);
        $alerta->publicado = !$alerta->publicado;
        $alerta->publicado_at = $alerta->publicado ? date('Y-m-d H:i:s') : null;
        $alerta->save();

        $this->session->set_flashdata('message', 'Se ha ' . ($alerta->publicado ? 'publicado' : 'despublicado') . ' la alerta.');
        redirect('backend/alertas');
    }

    public function post_agregar(){
        $alerta = new Alerta();
        $this->graba_alerta($alerta);
    }

    public function post_editar($alerta_id){
        $alerta = Doctrine::getTable('Alerta')->find($alerta_id);
        $this->graba_alerta($alerta);
    }

    public function graba_alerta($alerta){
        $respuesta = array();

        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'trim|required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'trim|required');
        $this->form_validation->set_rules('desde', 'Fecha desde', 'trim|required');
        $this->form_validation->set_rules('hasta', 'Fecha hasta', 'trim|required');
        $this->form_validation->set_rules('urls[]', 'Urls', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $alerta->titulo = $this->input->post('titulo');
            $alerta->descripcion = $this->input->post('descripcion');
            $alerta->tipo = $this->input->post('tipo');
            $alerta->desde = date('Y-m-d H:i', strtotime($this->input->post('desde')));
            $alerta->hasta = date('Y-m-d H:i', strtotime($this->input->post('hasta')));
            $alerta->publicado = $this->input->post('publicado');
            $alerta->setUrlsFromArray($this->input->post('urls'));

            $alerta->save();

            $this->session->set_flashdata('message', 'Se ha grabado la alerta.');
            $respuesta['validacion'] = TRUE;
            $respuesta['redirect'] = site_url('backend/alertas/');

        } else {
            $respuesta['validacion'] = FALSE;
            $respuesta['errores'] = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    public function ajax_get_urls(){
        $term = $this->input->get('term');

        $urls = Doctrine_Query::create()
            ->from('AlertaUrl a')
            ->where('a.url LIKE ?', $term . '%')
            ->execute();

        $resultado = array();
        foreach ($urls as $u)
            $resultado[] = $u->url;

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }
}