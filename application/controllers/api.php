<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->router->method != 'mapa'){
            $this->_check_access();

            $this->load->helper('xml');
          }
    }

    function fichas($codigo=NULL) {
        $feed = new stdClass();
        $type = $this->input->get('type');
        $callback = $this->input->get('callback');

        if ($codigo === NULL) {
            $feed->fichas = new stdClass();
            $query=$this->input->get('query');
            $offset=$this->input->get('pageToken')?1*base64_decode(urldecode($this->input->get('pageToken'))):0;
            $limit=($this->input->get('maxResults') && $this->input->get('maxResults')<=100)?1*$this->input->get('maxResults'):10;
            
            $feed->fichas->titulo = 'Listado de Fichas';
            $feed->fichas->tipo = 'chileatiende#fichasFeed';
            
            $options=array();
            if($query){
                $options['offset']=$offset;
                $options['limit']=$limit;
                $result = Doctrine::getTable('Ficha')->apiSearch($query,$options);
                $fichas=$result->fichas;
                $nresults=$result->total;
            }
            else{
                $options['justCount']=TRUE;
                $nresults=Doctrine::getTable('Ficha')->findPublicados($options);

                unset($options['justCount']);
                $options['limit']=$limit;
                $options['offset']=$offset;
                $fichas = Doctrine::getTable('Ficha')->findPublicados($options);
            }

            if($nresults>$limit+$offset)
                $feed->fichas->nextPageToken=urlencode(base64_encode($offset+$limit));

            $feed->fichas->total = $nresults;
            $feed->fichas->items = new stdClass();
            foreach ($fichas as $f)
                $feed->fichas->items->ficha[] = $f->toPublicArray();
        } else {
            $codigo=explode('-', $codigo);
            if(count($codigo)!=2){
                $ficha = Doctrine::getTable('Ficha')->find($codigo);
            }else{
                $ficha = Doctrine::getTable('Ficha')->findOneByServicioCodigoAndCorrelativo($codigo[0],$codigo[1]);
              }
            if(!$ficha) show_404();
            $ficha=$ficha->getVersionPublicada();
            if(!$ficha) show_404();
            $feed->ficha = $ficha->toPublicArray();
        }

        if ($type == 'xml') {
            header('Content-type: text/xml');
            echo xml_encode($feed);
        } else {
            header('Content-type: application/json');
            if($callback) echo $callback.'(';
            echo json_encode($feed);
            if($callback) echo ')';
        }
    }

    function servicios($id=NULL, $parameter=NULL){
        $feed = new stdClass();
        $type = $this->input->get('type');
        $callback = $this->input->get('callback');

        if ($id === NULL) {
            $feed->servicios = new stdClass();
            $feed->servicios->titulo = 'Listado de Servicios';
            $feed->servicios->tipo = 'chileatiende#serviciosFeed';
            $feed->servicios->items = NULL;

            $servicios = Doctrine::getTable('Servicio')->findConPublicaciones();
            foreach ($servicios as $s)
                $feed->servicios->items->servicio[] = $s->toPublicArray();
        } else {
            $servicio = Doctrine::getTable('Servicio')->find($id);
            if(!$servicio) show_404();
            if($parameter===NULL){         
                $feed->servicio = $servicio->toPublicArray();
            } else if($parameter=='fichas'){
                $feed->fichas=new stdClass();
                $feed->fichas->titulo='Listado de Fichas - '.$servicio->nombre;
                $feed->fichas->tipo='chileatiende#fichasFeed';
                $feed->fichas->items = array();
                $fichas=Doctrine::getTable('Ficha')->findFichaOnServicio($id);
                foreach ($fichas as $f)
                    $feed->fichas->items[] = $f->toPublicArray();
            }
        }

        if ($type == 'xml') {
            header('Content-type: text/xml');
            echo xml_encode($feed);
        } else {
            header('Content-type: application/json');
            if($callback) echo $callback.'(';
            echo json_encode($feed);
            if($callback) echo ')';
        }
    }


    function _check_access(){
        $token=$this->input->get('access_token');
        $acceso=Doctrine::getTable('ApiAcceso')->findOneByToken($token);
        if($acceso){
            Doctrine::getTable('ApiHit')->insertarHit($acceso->id);
            return;
        }

        show_error('access_token incorrecto',401,'Acceso no autorizado');
        exit;
    }

    public function mapa(){
        $apc_name = '';
        $data['filtros'] = $this->input->get('filtros', true)==1;
        $data['titulo'] = $this->input->get('titulo', true)==1;
        $data['width'] = intval($this->input->get('width', true))-15;
        $data['height'] = intval($this->input->get('height', true))-40;
        $data['zoom'] = intval($this->input->get('zoom', true));
        $data['comuna_seleccionada'] = $this->input->get('comuna', true);
        $data['id_oficina'] = $this->input->get('id_oficina', true)?$this->input->get('id_oficina', true):null;
        $data['dominio'] = $this->input->get('dominio', true);

        $data['oficina_seleccionada'] = '';

        if($data['filtros']){
            $data['height'] -= 40;
        }
        if($data['titulo']){
            $data['height'] -= 43;
        }

        foreach($data as $d){
            $apc_name .= $d;
        }

        if($data['id_oficina']!=''){
            $data['oficina_seleccionada'] = Doctrine::getTable('Oficina')->find($data['id_oficina']);
        }

        //$apc_name = sha1($apc_name);
        //if(!($mapa = apc_fetch($apc_name))){
        $data['oficinas'] = Doctrine::getTable('Oficina')->findAll();

        $data['comunas'] = Doctrine_Query::create()
            ->from('Sector s, s.Oficinas o')
            ->select('s.*, COUNT(o.id) noficinas')
            ->where('s.tipo="comuna"')
            ->having('noficinas > 0')
            ->groupBy('s.codigo')
            ->orderBy('s.nombre asc')
            ->execute();

          $mapa = $this->load->view('mapa/gmap', $data, true);
          //apc_add($apc_name, $mapa, 86400);
        //}
        echo $mapa;
    }
}