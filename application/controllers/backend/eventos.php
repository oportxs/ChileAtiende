<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Eventos extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->config->item('ssl'))
            force_ssl();

        $this->user = UsuarioBackendSesion::usuario();
        UsuarioBackendSesion::checkLogin();
    }

    public function index($estado = '') 
    {
        if ( ! ( $this->user->tieneRol( array( 'cal-editor', 'cal-publicador' ) ) ) ) {
            echo 'No tiene permisos';
            exit;
        }

        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $order_by = $this->input->get('order_by') ? $this->input->get('order_by') : 'evento.id ASC';
        $per_page = 30;

        $entidad = UsuarioBackendSesion::getEntidad();
        $servicio = UsuarioBackendSesion::getServicio();
        
        $args = array(
            'estado' => $estado,
            'actuales' => ($estado == 'expirados' ? false : true),
        	'limit' => $per_page,
            'offset' => $offset,
            'order_by' => $order_by
        );
        $nargs = array(
            'estado' => $estado,
            'actuales' => ($estado == 'expirados' ? false : true),
            'justCount' => TRUE,
        );
        $eventos = Doctrine::getTable('Evento')->findMaestros($entidad, $servicio, $args);
        $neventos = Doctrine::getTable('Evento')->findMaestros($entidad, $servicio, $nargs);

        $this->pagination->initialize(array(
            'base_url' => site_url('backend/eventos/index/?order_by=' . $order_by),
            'total_rows' => $neventos,
            'per_page' => $per_page,
            'first_link' => 'Inicio',
            'last_link' => 'Último'
        ));

        $data['title'] = 'Backend - Eventos';
        $data['content'] = 'backend/eventos/index';
        $data['eventos'] = $eventos;
        $data['total'] = $neventos;
        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['order_by'] = $order_by;

        $this->load->view('backend/template', $data);

    }

    public function agregar()
    {
        if ( ! $this->user->tieneRol('cal-editor') && ! $this->user->tieneRol('cal-publicador') ) {
            echo 'No tiene permisos';
            exit;
        }

        $servicios = UsuarioBackendSesion::usuario()->getServiciosAccesibles();
        $regiones = Doctrine::getTable('Region')->findAll();

        $data['title'] = 'Backend - Agregar Evento ';
        $data['content'] = 'backend/eventos/agregar';
        $data['regiones'] = $regiones;
        $data['servicios'] = $servicios;

        $this->load->view('backend/template', $data);
    }

    public function ver($eventoId)
    {
        $evento = Doctrine::getTable('Evento')->find($eventoId);

        if ( ! $this->user->canAccessServicio($evento->Servicio->codigo) || ! $this->user->tieneRol(array( 'cal-editor', 'cal-publicador' )) ) {
            echo 'No tiene permisos';
            exit;
        }

        $data['title'] = 'Backend - Evento ' . $evento->titulo;
        $data['content'] = 'backend/eventos/ver';
        $data['evento'] = $evento;

        $this->load->view('backend/template', $data);
    }

    public function editar($eventoId)
    {
        $evento = Doctrine::getTable('Evento')->find($eventoId);

        if ( ! $this->user->canAccessServicio($evento->Servicio->codigo) || 
            ( ! $this->user->tieneRol('cal-editor') && ! $this->user->tieneRol('cal-publicador') ) ) 
        {
            echo 'No tiene permisos';
            exit;
        }
        if ( $evento->estado == "en_revision" )
        {
            redirect('backend/eventos/ver/'.$eventoId);
        }

        $servicios = UsuarioBackendSesion::usuario()->getServiciosAccesibles();
        $regiones = Doctrine::getTable('Region')->findAll();

        $data['title'] = 'Backend - Evento ' . $evento->titulo;
        $data['content'] = 'backend/eventos/editar';
        $data['evento'] = $evento;
        $data['regiones'] = $regiones;
        $data['servicios'] = $servicios;

        $this->load->view('backend/template', $data);
    }

    public function historial($eventoId)
    {
        $evento = Doctrine::getTable('Evento')->find($eventoId);

        if ( ! $this->user->canAccessServicio($evento->Servicio->codigo) || ! $this->user->tieneRol(array( 'cal-editor', 'cal-publicador' )) ) {
            echo 'No tiene permisos';
            exit;
        }

        $data['title'] = 'Backend - Evento ' . $evento->titulo;
        $data['content'] = 'backend/eventos/historial';
        $data['evento'] = $evento;

        $this->load->view('backend/template', $data);
    }

    public function editar_form($eventoId)
    {
        if (! $this->user->tieneRol(array( 'cal-editor' )) ) {
            echo 'No tiene permisos';
            exit;
        }

        $this->_agregar_editar_form($eventoId);
    }

    public function agregar_form()
    {
        if (! $this->user->tieneRol(array( 'cal-editor' )) ) {
            echo 'No tiene permisos';
            exit;
        }

        $this->_agregar_editar_form();
    }

    public function publicar($eventoId)
    {
        $evento = Doctrine::getTable('evento')->find($eventoId);

        if (!$this->user->canAccessServicio($evento->Servicio->codigo) ||
                !$this->user->tieneRol('cal-publicador')) {
            echo 'No tiene permisos';
            return;
        }

        $evento->publicar();

        // se envia email a los editores del servicio dl evento y al usuario que genera la accion
        $aEditores = Doctrine::getTable('UsuarioBackend')->tipoServicioUsuarios('cal-editor', $evento->Servicio->codigo);
        $editores = $this->user->email.',';
        foreach ($aEditores as $editor) {
            $editores .= $editor->email . ',';
        }
        $this->email->from('chileatiende@chileatiende.gob.cl', 'ChileAtiende');
        $this->email->to(substr($editores, 0, -1));
        $this->email->subject('Evento ' . $evento->id . ' publicado Chile Atiende');
        $this->email->message("El evento " . $evento->id . ' ['.site_url('backend/eventos/ver/' . $evento->id).'] de ' . $evento->Servicio->nombre . " fue publicado por el equipo Chile Atiende.");

        if (!$this->email->send()) {
            $this->session->set_flashdata('message', 'El evento ha sido publicado pero no se ha notificado via email.');
        } else {
            $this->session->set_flashdata('message', 'El evento ha sido publicado exitósamente.');
        }

        redirect('backend/eventos/ver/'.$eventoId);
    }

    function despublicar($eventoId) {
        $evento = Doctrine::getTable('Evento')->find($eventoId);

        if (!$this->user->canAccessServicio($evento->Servicio->codigo) ||
                !$this->user->tieneRol('cal-publicador')) {
            echo 'No tiene permisos';
            return;
        }

        $evento->despublicar();
        $this->session->set_flashdata('message', 'El evento ha sido despublicado' );

        redirect('backend/eventos/ver/' . $eventoId);
    }

    public function aprobar($eventoId)
    {
        $evento = Doctrine::getTable('Evento')->find($eventoId);

        if (!$this->user->canAccessServicio($evento->Servicio->codigo) ||
                !$this->user->tieneRol('cal-aprobador')) {
            echo 'No tiene permisos';
            exit;
        }

        $evento->aprobar();

        // se envia a los usuarios con rol publicador anuncio de evento para ser revisada.
        // tambien se envia al propio usuario que esta generando la accion
        $aPublicadores = Doctrine::getTable('UsuarioBackend')->tipoUsuarios('publicador');
        $publicadores = $this->user->email.',';
        foreach ($aPublicadores as $publicador) {
            $publicadores .= $publicador->email . ',';
        }
        $this->email->from('chileatiende@chileatiende.gob.cl', 'ChileAtiende');
        $this->email->to(substr($publicadores, 0, -1));
        $this->email->subject('Evento ' . $evento->id . ' para revisión Chile Atiende');
        $this->email->message("El evento " . $evento->id . ' ['.site_url('backend/eventos/ver/' . $evento->id).'] de ' . $evento->Servicio->nombre . ' fue enviada para revisión al equipo Chile Atiende.');

        if (!$this->email->send()) {
            $this->session->set_flashdata('message', 'El evento ha sido enviado a revisión pero no se ha notificado via email.');
        } else {
            $this->session->set_flashdata('message', 'El evento ha sido enviado a revisión.');
        }

        redirect('backend/eventos/ver/' . $eventoId);
    }

    public function rechazar($eventoId)
    {
        $evento = Doctrine::getTable('Evento')->find($eventoId);

        if (!$this->user->canAccessServicio($evento->Servicio->codigo) ||
                !$this->user->tieneRol('cal-publicador')) {
            echo 'No tiene permisos';
            exit;
        }

        $evento->estado_justificacion = $this->input->post('estado_justificacion');
        $evento->save();
        $evento->rechazar();

        // se envia email a los editores del servicio dl evento y al usuario que genera la accion
        $aEditores = Doctrine::getTable('UsuarioBackend')->tipoServicioUsuarios('cal-editor', $evento->Servicio->codigo);
        $editores = $this->user->email.',';
        foreach ($aEditores as $editor) {
            $editores .= $editor->email . ',';
        }
        $this->email->from('chileatiende@chileatiende.gob.cl', 'ChileAtiende');
        $this->email->to(substr($editores, 0, -1));
        $this->email->subject('Evento ' . $evento->id . ' rechazado Chile Atiende');
        $this->email->message("El evento " . $evento->id . ' ['.site_url('backend/eventos/ver/' . $evento->id).'] de ' . $evento->Servicio->nombre . " fue rechazado por el equipo Chile Atiende con la siguiente justificación:\n\n" . $evento->estado_justificacion);

        if (!$this->email->send()) {
            $this->session->set_flashdata('message', 'El evento ha sido rechazado pero no se ha notificado via email.');
        } else {
            $this->session->set_flashdata('message', 'El evento ha sido rechazado.');
        }

        redirect('backend/eventos/ver/' . $eventoId);
    }

    public function eliminar($eventoId)
    {
        $evento = Doctrine::getTable('Evento')->find($eventoId);

        if (!$this->user->canAccessServicio($evento->Servicio->codigo) ||
                !($this->user->tieneRol('cal-editor') && !$evento->publicado)) {
            echo 'No tiene permisos';
            return;
        }

        // $evento->delete();
        $evento->estado = 'eliminado';
        $evento->save();
        $evento->generarVersion();
        redirect('backend/eventos/');
    }

    function _agregar_editar_form($eventoId = null)
    {
        $respuesta = new stdClass();
        $respuesta->validacion = FALSE;
        $mensaje = '';

        $this->form_validation->set_rules('titulo', 'Título', 'required|trim');
        $this->form_validation->set_rules('url', 'Enlace', 'required|trim|callback__check_url');
        $this->form_validation->set_rules('informacion', 'Información', 'trim|max_length[150]');
        $this->form_validation->set_rules('permanente', 'Periodo', 'callback__check_fecha');
        $this->form_validation->set_rules('region_sel', 'Regiones', 'callback__check_region');
        $this->form_validation->set_rules('servicio_codigo', 'Servicio', 'required|callback__check_servicio');
        $this->form_validation->set_rules('tipo', 'Público objetivo', 'required');

        if ($this->form_validation->run() == TRUE) {

            if($eventoId)
                $evento = Doctrine::getTable('Evento')->find($eventoId);
            else {
                $evento = new Evento();
                $evento->maestro = 1;
                $evento->publicado = 0;
                $evento->estado = NULL;
            }

            if($this->input->post('region_sel') == 1) {
                $Regiones = Doctrine::getTable('Region')->findAll();
                $regionesArr = array();
                foreach($Regiones as $r)
                    $regionesArr[] = $r->id;
            } else
                $regionesArr = $this->input->post('region');

            // INFO: las fechas en el formulario vienen con otro formato, por lo que es necesario normalizarlas
            $_postulacion_start = $this->input->post('postulacion_start');
            if (preg_match("/^(\d{2})[-\/](\d{2})[-\/](\d{4})$/", $_postulacion_start)) {
                $_aDate = explode('-', $_postulacion_start);
                $_postulacion_start = $_aDate[2].'-'.$_aDate[1].'-'.$_aDate[0];
            }
            $_postulacion_end = $this->input->post('postulacion_end');
            if (preg_match("/^(\d{2})[-\/](\d{2})[-\/](\d{4})$/", $_postulacion_end)) {
                $_aDate = explode('-', $_postulacion_end);
                $_postulacion_end = $_aDate[2].'-'.$_aDate[1].'-'.$_aDate[0];
            }

            if($this->input->post('permanente') == 1) {
                $evento->postulacion_start = NULL;
                $evento->postulacion_end = NULL;
                $evento->permanente = 1;
            } else {
                $evento->postulacion_start = $_postulacion_start;
                $evento->postulacion_end = $_postulacion_end;
                $evento->permanente = 0;
            }

            $evento->informacion = $this->input->post('informacion');
            $evento->titulo = $this->input->post('titulo');
            $evento->url = $this->input->post('url');
            $evento->servicio_codigo = $this->input->post('servicio_codigo');
            $evento->tipo = $this->input->post('tipo');
            $evento->destacado = $this->input->post('destacado') ? $this->input->post('destacado') : 0;
            $evento->setRegionesFromArray($regionesArr);
            $evento->save();
            $evento->generarVersion();

            $respuesta->validacion = TRUE;
            $siteUrl = 'backend/eventos' . (!$this->user->tieneRol(array('cal-publicador', 'cal-aprobador')) ? '' : '/ver/'.$evento->id);
            $respuesta->redirect = site_url($siteUrl);
            $this->session->set_flashdata('message', 'Evento actualizado exitosamente.');

        }
        else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        echo json_encode($respuesta);
    }

    function _empty($val) { return empty($val); }
    function _check_fecha($permanente)
    {
        if( $permanente || (!$this->_empty($this->input->post('postulacion_start')) && !$this->_empty($this->input->post('postulacion_end'))) )
            return TRUE;

        $this->form_validation->set_message('_check_fecha', 'Debe llenar las Fechas del Evento');
        return FALSE;        
    }
    function _check_region($region_todas)
    {
        $region = $this->input->post('region');
        if( !$region_todas && (!is_array($region) || count($region) == 0) ) {
            $this->form_validation->set_message('_check_region', 'Debe llenar las Regiones del Evento');
            return FALSE;
        }

        return TRUE;
    }
    function _check_servicio($servicio_codigo) 
    {
        if ($this->user->canAccessServicio($servicio_codigo))
            return TRUE;

        $this->form_validation->set_message('_check_servicio', 'No tiene permisos para asignar esta institución');
        return FALSE;
    }
    function _check_url($url)
    {
        if(preg_match('/\[\[\d+\]\]/', $url))
            return $url;
        else
            return prep_url($url);
    }
}

?>