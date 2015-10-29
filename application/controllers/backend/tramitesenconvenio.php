<?php
class TramitesEnConvenio extends CI_Controller
{
    function __construct() {
        parent::__construct();

        if($this->config->item('ssl'))force_ssl();

        UsuarioBackendSesion::checkLogin();

        if (!UsuarioBackendSesion::usuario()->tieneRol('mantenedor')) {
            echo 'No tiene permisos';
            exit;
        }
    }
    public function index()
    {
        $data['tramites'] = Doctrine::getTable('TramiteEnConvenio')->findAll();
        
        $data['title'] = 'Tramites en Convenio';
        $data['content'] = 'backend/tramitesenconvenio/index';
        $this->load->view('backend/template', $data);
    }


    public function editar($tramite_id)
    {
        $this->_load_form(Doctrine::getTable('TramiteEnConvenio')->find($tramite_id));
    }

    public function agregar()
    {
        $this->_load_form(new TramiteEnConvenio());
    }

    public function _load_form($tramite)
    {
        $data['tramite'] = $tramite;
        $data['oficinas'] = Doctrine::getTable('Oficina')->findAll();
        $data['title'] = 'Backend - Agregar nuevo Trámite en convenio';
        $data['content'] = 'backend/tramitesenconvenio/form';

        $this->load->view('backend/template', $data);
    }

    public function guardar($tramite_id = null)
    {
        $respuesta = new stdClass();

        if($tramite_id)
            $tramite = Doctrine::getTable('TramiteEnConvenio')->find($tramite_id);
        else
            $tramite = new TramiteEnConvenio();

        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
        $this->form_validation->set_rules('url_tramite', 'Url Trámite', 'required');

        $oficinas = $this->resolve_oficinas($this->input->post('global'),$this->input->post('oficinas'),$this->input->post('oficinas-exclude'));

        if ($this->form_validation->run() == TRUE) {
            try{
                $tramite->titulo = $this->input->post('titulo');
                $tramite->url_tramite = $this->input->post('url_tramite');
                $tramite->url_imagen = $this->input->post('url_imagen');
                $tramite->ficha_id = $this->input->post('ficha_id')?$this->input->post('ficha_id'):null;
                $tramite->global = $this->input->post('global');
                $tramite->setOficinasFromArray($oficinas);
                
                $tramite->save();

                $this->session->set_flashdata('message', 'Trámite '.($tramite_id?'actualizado':'creado').' exitosamente');
                $respuesta->validacion = TRUE;
                redirect('backend/tramitesenconvenio');
            } catch (Exception $e) {
                $respuesta->validacion = FALSE;
                $respuesta->errores = "<p class='error'>" . $e . "</p>";
            }
        }else{
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors('<p class="error">', '</p>');
        }

        $data['tramite'] = $tramite;
        $data['content'] = 'backend/tramitesenconvenio/form';
        $data['title'] = 'Backend - Guardar Trámite en convenio';
        $this->load->view('backend/template', $data);
    }

    private function resolve_oficinas($global, $include, $exclude){
        $oficinas = array();
        if($global && !$exclude){
            $oficinas = false;
        } else if(!$global && $include) {
            $oficinas = $include;
        } else if($global && $exclude){
            $all = Doctrine::getTable('Oficina')->findAll();
            foreach ($all as $ofi) {
                if(!in_array($ofi->id, $exclude)){
                    $oficinas[] = $ofi->id;
                }
            }
        }
        return $oficinas;
    }

    public function get_datos_ficha($ficha_id = null)
    {
        $ficha_id = $ficha_id?$ficha_id:$this->input->get('ficha_id');
        if(!$ficha_id){
            return false;
        }

        $ficha = Doctrine::getTable('Ficha')->findOneByIdAndMaestroAndPublicado($ficha_id,1,1);

        if(!$ficha)
            $output = null;
        else
            $output = array('titulo' => $ficha->titulo,'url' => site_url('fichas/ver/'.$ficha->id));

        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function get_sucursales_tramite_en_convenio($ficha_id = null)
    {
        $ficha_id = $ficha_id?$ficha_id:$this->input->get('ficha_id');
        $tramite = false;

        if(!$ficha_id){
            return array('error' => true);
        } else {
            $tramite = Doctrine::getTable('TramiteEnConvenio')->find($ficha_id);
        }

        if(!$tramite) {
            $output = array('error' => true);
        } else {
            $oficinas = array();
            foreach ($tramite->Oficinas as $value) {
                $oficinas[] = $value->id;
            }
            $output = array('titulo' => $tramite->titulo, 'ficha_id' => $tramite->ficha_id, 'oficinas' => $oficinas,'global' => $tramite->global, 'error' => false);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function eliminar($tramite_id) {
        $tramite = Doctrine::getTable('TramiteEnConvenio')->find($tramite_id);
        $tramite->delete();
        redirect('backend/tramitesenconvenio');
    }
}
?>