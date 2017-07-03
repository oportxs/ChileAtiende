<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fichas extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->side_panel_limit = 3;
    }


    function ver($id, $codigo_ab = '2') {
        $this->load->library('user_agent');
        $codigo_ab = !in_array($codigo_ab, array('2', '3', '4')) || $this->agent->is_mobile() ? '2' : $codigo_ab;

        list($ficha) = Doctrine::getTable('Ficha')->findPublicado($id);
        if(isset($ficha->es_tramite_mujer) && ($ficha->es_tramite_mujer == true)) {
            $codigo_ab = "mujer";
        }

        $data['es_exterior'] = $es_exterior;

        if($ficha->titulo) {

            /*Para el caso del breadcumb*/
            $data['subtema'] = "";
            if($this->session->flashdata('subtema')){
                $data['subtema'] = $this->session->flashdata('subtema');
                $this->session->flashdata('subtema');
            }

            $options['limit'] = $this->side_panel_limit;

            //Se obtienen las fichas relacionadas
            $fichasRelacionadas = $ficha->getFichasSimilares(2);
            $fichasDestacadas = ($ficha->Servicio->codigo == 'ZY000' || ($ficha->tipo==2) ) ?
                Doctrine::getTable('Ficha')->MasDestacadasEmpresa($this->side_panel_limit) :
                Doctrine::getTable('Ficha')->MasDestacadas($this->side_panel_limit);

            $ficha_maestro = Doctrine::getTable('Ficha')->find($id);
            $regiones = Doctrine::getTable('Region')->findAll();
            $eventos = Doctrine::getTable('Evento')->getEventos(array(
                'publicados' => true, 
                'permanentes' => false,
                'destacados' => true,
                'actuales' => true,
                'random' => true,
                'limit' => $this->side_panel_limit,
            ));

            $data['fichasRelacionadas'] = $fichasRelacionadas;
            $data['fichasDestacadas'] = $fichasDestacadas;

            //Se guardan variables
            $data['categorytabs_closed'] = TRUE;
            $data['title'] = ''.$ficha->titulo;

            if($ficha->es_tramite_mujer==1 || $codigo_ab == "mujer"){
                if($_GET['mujer'] == 1){
                    $this_tpl = 'fichas/ver_mujer';
                }else{
                    $this_tpl = 'fichas/ver_v2';
                }
            }else{
                $this_tpl = 'fichas/ver_v'.$codigo_ab;
            }
            
            $data['content'] = $this_tpl;
            $data['ficha'] = $ficha;
            $data['regiones'] = $regiones;
            $data['eventos'] = $eventos;

            if($ficha->tipo == 2) {
                $data['perfil'] = "empresas";
                $data['empresa'] = 1;
            }

            // INFO: metaficha stuff
            $_comunas = array();
            $_regiones = array();
            $_servicios = array();
            $_entidades = array();
            $_subfichas = $ficha_maestro->SubFichas;
            $metaficha_opciones = unserialize($ficha->metaficha_opciones);
            foreach($_subfichas as $_subficha)
                if($_subficha->maestro == 1 && $_subficha->publicado == 1) {
                    if($metaficha_opciones['categoria'] == "region-comuna") {
                        // INFO: asume que el sector es comuna y que hay solo un servicio por comuna.
                        $_comunas[$_subficha->id] = $_subficha->Servicio->Sector;
                        if(!in_array($_subficha->Servicio->Sector->SectorPadre->SectorPadre, $_regiones))
                            $_regiones[] = $_subficha->Servicio->Sector->SectorPadre->SectorPadre;
                    }
                    elseif( in_array($metaficha_opciones['categoria'], array("servicio-alfabetico", "entidad-servicio")) ) {
                        $_servicios[$_subficha->id] = $_subficha->Servicio;
                        if(!in_array($_subficha->Servicio->Entidad, $_entidades))
                            $_entidades[] = $_subficha->Servicio->Entidad;
                    }
                    // INFO: Opcion pre-seleccionada en url
                    if($this->input->get('codigo') == $_subficha->Servicio->codigo)
                        $data['seleccion'] = $_subficha->id;
                }
            $data['menu_text'] = "Realiza este trámite en:";
            $data['regiones'] = $_regiones;
            $data['comunas'] = $_comunas;
            $data['servicios'] = $_servicios;
            $data['entidades'] = $_entidades;

        } else {
            redirect('fichas/error/');
        }
        $data["hidden_buscador"] = ($ficha->Servicio->codigo == 'ZY000' || ($ficha->tipo==2) ) ? 1 : 0;
        $template = ($ficha->Servicio->codigo == 'ZY000' || ($ficha->tipo==2) ) ? 'template_emprendete_v2' : 'template_v2';
        $template = ($es_exterior==="1"||$ficha->es_tramite_exterior==1) ? 'template_exterior' : $template;

        if($ficha->es_tramite_mujer==1){
            $template = 'template_mujer';
        }

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));

        //Variable utilizada para incluir el codigo del test AB de las fichas
        if(!$this->agent->is_mobile()){
            $codigosMarcasTestAb = array(
                    '1000' => '0',
                    '2272' => '1',
                    '24753' => '2'
                );
            if (isset($codigosMarcasTestAb[$id]) && $codigo_ab == '2') {
                $data['codigoMarcaTestAB'] = $codigosMarcasTestAb[$id];
            }
        }

        $this->load->view($template, $data);
    }

    function ajax_inserta_visita($id){
        //Lo guardo en la sesion de tracking.
        TrackSesion::insertarVisitaFicha($id);
        
        //Guardo la visita
        Doctrine::getTable('Hit')->insertaVista($id);
    }

    function imprimir($id) {

        $ficha = Doctrine::getTable('Ficha')->find($id);

        $data['title'] = 'Imprimir - '.$ficha->titulo;
        $data['content'] = 'fichas/imprimir';
        $data['ficha'] = $ficha;

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));
        $this->load->view('print', $data);
    }

    public function ajax_get_evaluaciones_stats($ficha_id) {
        $ficha = Doctrine::getTable('Ficha')->find($ficha_id);

        $evaluaciones = $ficha->getEstadisticaEvaluaciones()->toArray();
        $evaluaciones['canEvaluar'] = $this->_can_evaluar($ficha_id);

        echo json_encode($evaluaciones);
    }

    function _can_evaluar($ficha_id) {
        $ficha = Doctrine::getTable('Ficha')->find($ficha_id);

        $evaluados = json_decode($this->input->cookie('evaluados'));

        if (!$evaluados || !in_array($ficha->id, $evaluados))
            return TRUE;

        return FALSE;
    }

}