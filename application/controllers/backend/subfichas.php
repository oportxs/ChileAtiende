<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SubFichas extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->config->item('ssl'))
            force_ssl();

        $this->user = UsuarioBackendSesion::usuario();
        UsuarioBackendSesion::checkLogin();
    }

    public function index($estado = '', $flujos = FALSE, $options = array()) {
        if (!($this->user->tieneRol(array('editor', 'aprobador', 'publicador', 'chilesinpapeleo', 'emprendete')) )) {
            echo 'No tiene permisos';
            exit;
        }

        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'sf.id ASC';
        $titulo = $this->input->post('titulo');
        $publico = $this->input->post('publico');
		$per_page = 30;
        $entidad = UsuarioBackendSesion::getEntidad();
        $servicio = UsuarioBackendSesion::getServicio();

        $args = array('limit' => $per_page,
            'offset' => $offset,
            'order_by' => $order_by,
            'estado' => $estado,
            'titulo' => $titulo,
            'publico' => $publico,
            'flujos' => $flujos
        );
        //argumentos para el contador
        $nargs = array('estado' => $estado,
            'justCount' => TRUE,
            'titulo' => $titulo,
            'publico' => $publico,
            'flujos' => $flujos
        );

        $subfichas = Doctrine::getTable('SubFicha')->findMaestros($entidad, $servicio, $args);
        $nsubfichas = Doctrine::getTable('SubFicha')->findMaestros($entidad, $servicio, $nargs);

        $this->pagination->initialize(array(
            'base_url' => site_url('backend/subfichas/index/' . $estado . '?order_by=' . $order_by),
            'total_rows' => $nsubfichas,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['title'] = 'Backend - SubFichas';
        $data['content'] = 'backend/subfichas/index';
        $data['subfichas'] = $subfichas;
        $data['flujos'] = $flujos;
        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['total'] = $nsubfichas;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);
    }

    public function editar($id) {
        $subficha = Doctrine::getTable('SubFicha')->find($id);

        if (!$this->user->canAccessServicio($subficha->Servicio->codigo) ||
                !($this->user->tieneRol('editor')) ) {

            echo 'No tiene permisos';
            exit;
        }

        $servicios = UsuarioBackendSesion::usuario()->getServiciosAccesibles();
        $subficha_servicios = Doctrine::getTable('Servicio')->findAll();

        $data['title'] = 'Backend - SubFicha #'.$subficha->id;
        $data['content'] = 'backend/subfichas/editar';
        $data['subficha'] = $subficha;
        $data['ficha'] = $subficha->MetaFicha;
        $data['servicios'] = $servicios;
        $data['subficha_servicios'] = $subficha_servicios;
        $data['nombreform'] = 'editar_form';

        $this->load->view('backend/template', $data);
    }

    function editar_form($id) {

        $subficha = Doctrine::getTable('SubFicha')->find($id);
        if ( !$this->user->canAccessServicio($subficha->Servicio->codigo) ||
                !(($this->user->tieneRol('editor') ? '1' : '0') || $this->user->tieneRol('publicador')) ) {
            echo 'No tiene permisos';
            exit;
        }
        echo $this->_save_subficha($id);
    }

    function _save_subficha($id = null) {
        $respuesta = new stdClass();
        if ($id) {
            try {
                $subficha = Doctrine::getTable('SubFicha')->find($id);
            } catch (Exception $e) {

                $respuesta->validacion = FALSE;
                $respuesta->errores = "<p class='error'>" . $e . "</p>";
                return json_encode($respuesta);
            }
        } else { // TODO: sacar, no deberia crearse nunca desde aca la subficha -> se crea desde la ficha
            $subficha = new SubFicha();
        }

        try {
        	$metaficha = $subficha->MetaFicha;
        	$metaficha_campos = unserialize($metaficha->metaficha_campos);
            foreach($metaficha_campos as $key => $value) {
                // INFO:
                //		0 - Se guarda en SubFicha
                //		1 - Se guarda en MetaFicha
                $subficha[$key] = $value == 0 ? $this->input->post($key) : '';
            }
            $comentarios = $this->input->post('comentario');
            $subficha->comentarios = json_encode($comentarios);
            $subficha->save();
            $subficha->generarVersion();

            $this->session->set_flashdata('message', 'SubFicha actualizada exitosamente');
            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url('backend/subfichas/ver/'.$subficha->id);
        } catch (Exception $e) {

            $respuesta->validacion = FALSE;
            $respuesta->errores = "<p class='error'>" . $e . "</p>";
            return json_encode($respuesta);
        }

        return json_encode($respuesta);
    }

    public function ver($id)
    {
        $subficha = Doctrine::getTable('SubFicha')->find($id);

        if (!$this->user->canAccessServicio($subficha->Servicio->codigo) ||
                !($this->user->tieneRol(array('editor', 'aprobador', 'publicador')))) {
            echo 'No tiene permisos';
            exit;
        }

        $data['subficha'] = $subficha;
        $data['title'] = 'Backend - Ver SubFicha ';
        $data['content'] = 'backend/subfichas/ver';

        $this->load->view('backend/template', $data);
    }

    function aprobar($id) {
        $subficha = Doctrine::getTable('SubFicha')->find($id);

        if (!$this->user->canAccessServicio($subficha->Servicio->codigo) ||
                !$this->user->tieneRol('aprobador')) {
            echo 'No tiene permisos';
            exit;
        }

        $subficha->aprobar();

        $aPublicadores = Doctrine::getTable('UsuarioBackend')->tipoUsuarios('publicador');
        //se envia a los usuarios con rol publicador anuncio de ficha para ser revisada.
        $publicadores = '';
        foreach ($aPublicadores as $publicador) {
            $publicadores .= $publicador->email . ',';
        }

        $this->email->from('chileatiende@chileatiende.gob.cl', 'ChileAtiende');
        $this->email->to(substr($publicadores, 0, -1));
        $this->email->subject('SubFicha ' . $subficha->id . ' para revisión Chile Atiende');
        $txt = 'La subficha ';
        $this->email->message($txt . ' <a href="' . site_url('backend/subfichas/ver/' . $subficha->id) . '">' . $subficha->id . '</a> de ' . $subficha->Servicio->nombre . ' fue enviada para revisión al equipo Chile Atiende.');

        if (!$this->email->send()) {
            $this->session->set_flashdata('message', 'La subficha ha sido enviada a revisión pero no se ha notificado via email.');
        } else {
            $this->session->set_flashdata('message', 'La subficha ha sido enviada a revisión.');
        }

        redirect('backend/subfichas/ver/' . $id);
    }

    function rechazar($id) {
        $subficha = Doctrine::getTable('SubFicha')->find($id);

        if (!$this->user->canAccessServicio($subficha->Servicio->codigo) ||
                !$this->user->tieneRol('publicador')) {
            echo 'No tiene permisos';
            exit;
        }

        $subficha->estado_justificacion = $this->input->post('estado_justificacion');
        $subficha->rechazar();

        $this->session->set_flashdata('message', 'La subficha ha sido rechazada.');

        redirect('backend/subfichas/ver/' . $id);
    }

    function publicar($id) {
        $subficha = Doctrine::getTable('SubFicha')->find($id);

        if (!$this->user->canAccessServicio($subficha->Servicio->codigo) ||
                !$this->user->tieneRol('publicador')) {
            echo 'No tiene permisos';
            return;
        }

        $subficha->publicar();
        $this->session->set_flashdata('message', 'La subficha ha sido publicada exitósamente');
        redirect('backend/subfichas/ver/' . $id);
    }

    function despublicar($id) {
        $subficha = Doctrine::getTable('SubFicha')->find($id);

        if (!$this->user->canAccessServicio($subficha->Servicio->codigo) ||
                !$this->user->tieneRol('publicador')) {
            echo 'No tiene permisos';
            return;
        }

        $subficha->despublicar();
        $this->session->set_flashdata('message', 'La subficha ha sido despublicada');
        redirect('backend/subfichas/ver/' . $id);
    }

    public function versiones($id) {
        $subficha = Doctrine::getTable('SubFicha')->find($id);

        if (!$this->user->canAccessServicio($subficha->Servicio->codigo) ||
                !($this->user->tieneRol(array('editor', 'aprobador', 'publicador')))) {
            echo 'No tiene permisos';
            exit;
        }

        $data['subficha'] = $subficha;
        $data['title'] = 'Backend - Ver SubFicha ' ;
        $data['content'] = 'backend/subfichas/versiones';
        $this->load->view('backend/template', $data);
    }

    function compara($id) {
        $subficha = Doctrine::getTable('SubFicha')->find($id);

        if (!$this->user->canAccessServicio($subficha->Servicio->codigo) ||
                !($this->user->tieneRol(array('editor', 'aprobador')))) {
            echo 'No tiene permisos';
            exit;
        }

        $data['subficha'] = $subficha;
        $data['title'] = 'Backend - Previsualizar ';
        $data['content'] = 'backend/subfichas/previsualizar';
        $this->load->view('backend/previsualizar', $data);
    }

    function previsualizar($id) {
        $subficha = Doctrine::getTable('SubFicha')->findPublicado($id);

        if (!$this->user->canAccessServicio($subficha[0]->Servicio->codigo) ||
                !($this->user->tieneRol(array('editor', 'aprobador', 'publicador')))) {
            echo 'No tiene permisos';
            exit;
        }

        $data['subficha'] = $subficha[0];
        $data['title'] = 'Backend - Previsualizar ';
        $data['content'] = 'backend/subfichas/previsualizar';
        $this->load->view('backend/previsualizar', $data);
    }

    public function historial($id) {
        $subficha = Doctrine::getTable('SubFicha')->find($id);

        if (!$this->user->canAccessServicio($subficha->Servicio->codigo) ||
                !($this->user->tieneRol(array('editor', 'aprobador', 'publicador')))) {
            echo 'No tiene permisos';
            exit;
        }

        $data['subficha'] = $subficha;
        $data['title'] = 'Backend - Ver SubFicha ';
        $data['content'] = 'backend/subfichas/historial';
        $this->load->view('backend/template', $data);
    }

}

?>