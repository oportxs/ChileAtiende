<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BuscarExterior extends CI_Controller {

    public function fichas() {
        $per_page = 10;

        //Se obtienen los parametros de busqueda definidos en el input del usuario
        $buscar                 = $this->input->get('buscar');


        $offset                 = (int)$this->input->get('offset');
        $exacto                 = $this->input->get('exacto');
        $empresa = $vista_pymes = $this->input->get('e') && $this->input->get('e') == 1 ? true:false;

//var_dump($empresa);


        $filtro_temas           = $this->input->get('temas') ? explode(',', $this->input->get('temas')) : array();
        $filtro_hecho           = $this->input->get('hecho') ? explode(',',$this->input->get('hecho')):array();
        $filtro_genero          = $this->input->get('genero')?$this->input->get('genero'):null;
        $filtro_edad            = $this->input->get('edad')?$this->input->get('edad'):null;
        $filtro_tema_empresa    = $this->input->get('tema_empresa') ? explode(',', $this->input->get('tema_empresa')) : array();
        $filtro_instituciones   = $this->input->get('instituciones') ? explode(',', $this->input->get('instituciones')) : array();
        $filtro_formalizacion   = $this->input->get('formalizacion') ? explode(',', $this->input->get('formalizacion')) : array();
        $filtro_apoyo_estado    = $this->input->get('apoyo_estado') ? explode(',', $this->input->get('apoyo_estado')) : array();
        $filtro_fps             = $this->input->get('fps') ? $this->input->get('fps') : '';
        $filtro_rubro           = $this->input->get('rubro') ? explode(',',$this->input->get('rubro')) : array();
        $filtro_tipo_empresa    = $this->input->get('tipo_empresa') ? explode(',',$this->input->get('tipo_empresa')) : array();
        $filtro_etapa_empresa   = $this->input->get('etapa_empresa') ? explode(',',$this->input->get('etapa_empresa')) : array();
        $filtro_hecho_empresa   = $this->input->get('hecho_empresa') ? explode(',',$this->input->get('hecho_empresa')) : array();
        $filtro_aprende         = $this->input->get('aprende') ? explode(',',$this->input->get('aprende')) : array();
        $filtro_evento          = $this->input->get('evento') ? explode(',',$this->input->get('evento')) : array();
        $filtro_req_especial    = $this->input->get('req_especial') ? explode(',',$this->input->get('req_especial')) : array();
        $aData                  = array();

        //Sugerencias en base a diccionario
        $suggest=null;
        $query=trim($buscar);
        if(!$exacto){
            $correccion=Doctrine::getTable('Diccionario')->corregirTexto($query);
            if($correccion!=$query){    //Es decir, hubo una correccion
                $suggest=$query;
                $query=$correccion;     
            }
        }
        
        //Vemos si hay resultados patrocinados
        $promocionados=Doctrine::getTable('SearchPromocionado')->search($query);

        //Se hace la busqueda en Sphinx
        $this->load->library('sphinxclient');
        $this->sphinxclient->setServer($this->config->item('sphinx_host'),(int)$this->config->item('sphinx_port'));
        $this->sphinxclient->SetFieldWeights(array('keywords' => 50, 'titulo' => 100, 'sic' => 50, 'objetivo' => 5));
        if($query){ //Si hau una busqueda, usamos el algoritmo para clasificar los resultados
            $this->sphinxclient->SetMatchMode(SPH_MATCH_EXTENDED);
            $this->sphinxclient->setRankingMode(SPH_RANK_EXPR, 'bm25 + 100*(sum(lcs*user_weight)/max_lcs) + 10*(hits/max_hits)');
        }else{  //Si no hay busqueda, simplement ordenamos por hits.
            $this->sphinxclient->SetSortMode(SPH_SORT_ATTR_DESC,'hits');
        }
        $this->sphinxclient->setLimits(0, 1000);
        
        if (!empty($filtro_temas)){
            foreach($filtro_temas as $f)
                $this->sphinxclient->setFilter('tema_id', array($f));
        }
        if (!empty($filtro_instituciones)) {
            $filtro_instituciones_crc32 = array_map('crc32', $filtro_instituciones);
            $this->sphinxclient->setFilter('servicio_codigo', $filtro_instituciones_crc32);
        }
        if(!empty($filtro_hecho))
            $this->sphinxclient->setFilter('hecho_vida_id', $filtro_hecho);
        if($filtro_genero && $filtro_genero!=1) //Si es que hay un filtro de genero, y no se selecciono "Ambos"
            $this->sphinxclient->setFilter('genero_id', array(1,$filtro_genero));
        if($filtro_edad){
            $this->sphinxclient->SetSelect('*, IF(edad_minima < '.$filtro_edad.' AND '.$filtro_edad.' < edad_maxima ,1,0) as edad_ok');
            $this->sphinxclient->setFilter('edad_ok',array(1));
        }
        if (!empty($filtro_tema_empresa))
            $this->sphinxclient->setFilter('tema_empresa_id', $filtro_tema_empresa);
        if (!empty($filtro_formalizacion)) {
            $this->sphinxclient->setFilter('formalizacion', $filtro_formalizacion);
        }
        if (!empty($filtro_apoyo_estado)) {
            $this->sphinxclient->setFilter('apoyo_estado_id', $filtro_apoyo_estado);
        }
        if(!empty($filtro_fps)) {
            $this->sphinxclient->setFilterRange('puntaje_fps_min', 0, $filtro_fps);
            $this->sphinxclient->setFilterRange('puntaje_fps_max', $filtro_fps, 100000);
        }
        if (!empty($filtro_rubro)) {
            $this->sphinxclient->setFilter('rubro_id', $filtro_rubro);
        }
        if (!empty($filtro_tipo_empresa)) {
            $this->sphinxclient->setFilter('tipo_empresa_id', $filtro_tipo_empresa);
        }
        if (!empty($filtro_etapa_empresa)) {
            $this->sphinxclient->setFilter('etapa_empresa_id', $filtro_etapa_empresa);
        }
        if(!empty($filtro_hecho_empresa)) {
            $this->sphinxclient->setFilter('hecho_empresa_id', $filtro_hecho_empresa);
        }
        if(!empty($filtro_aprende)) {
            $this->sphinxclient->setFilter('flujo', $filtro_aprende);
        }
        if(!empty($filtro_evento)) {
            $this->sphinxclient->setFilter('evento_id', $filtro_evento);
        }
        if(!empty($filtro_req_especial)) {
            $this->sphinxclient->setFilter('requisito_especial', $filtro_req_especial);
        }

        //Preparo los terminos para enviarlos al sphinx (Para que haga busqueda ANY)
        $sphinx_query=trim(preg_replace('/[\-\+\'\"]+/', ' ', $query));     //Le quitamos los caracteres especiales de sphinx (- + " ')
        if($query){
            $query_arr=preg_split('/\s+/', $sphinx_query);
            foreach($query_arr as &$s)
                $s='('.$s.')';
            $sphinx_query=  implode(' | ', $query_arr);
        }
        
        //Hago la busqueda
        $result=$this->sphinxclient->query($sphinx_query, 'redchile_fichas');
                
        //Se hace el match de los resultados de Sphinx con el modelo en Doctrine.
        $doctrine_query = Doctrine_Query::create()
                        ->from('Ficha f')
                        ->where('f.maestro = 0 AND f.publicado = 1');
             
        if ($result['total']>0) {    
            $page_results=  array_slice($result['matches'],$offset ,$per_page,TRUE);
            $matches = array_keys($page_results);
            if(!empty($matches)){
                $doctrine_query->whereIn('f.id', $matches);
                $doctrine_query->orderBy('FIELD (id, '.implode(',', $matches).')');
            }else{
                $doctrine_query->where('0');
            }
        } else {
            $doctrine_query->where('0');
        }

        $fichas = $doctrine_query->execute();
        $total_fichas = $result['total'];

        
        //Se configura la paginacion
        $this->pagination->initialize(array(
            'base_url' => url_buscador(),
            'total_rows' => $total_fichas,
            'per_page' => $per_page
        ));
        
        
        //Se calculan los parametros para llenar la barra izquierda de navegacion.
        if($result['total']>0){
            $formalidad = array('informal' => 'Informal', 'formal' => 'Formal');
            $req_especial = array('mujer' => 'Mujer', 'indigena' => 'Indigena');

            foreach($result['matches'] as $ficha) {
                
                foreach( $formalidad as $tramite => $nombre){
                    if($ficha['attrs'][$tramite])
                        if(!isset($aData['formalidad'][$tramite])){
                            $aData['formalidad'][$tramite]['nombre'] = $nombre;
                            $aData['formalidad'][$tramite]['numero_fichas'] = 1;
                        }else{
                            $aData['formalidad'][$tramite]['numero_fichas']++;
                        }
                }

                foreach( $req_especial as $tramite => $nombre){
                    if($ficha['attrs'][$tramite])
                        if(!isset($aData['req_especial'][$tramite])){
                            $aData['req_especial'][$tramite]['nombre'] = $nombre;
                            $aData['req_especial'][$tramite]['numero_fichas'] = 1;
                        }else{
                            $aData['req_especial'][$tramite]['numero_fichas']++;
                        }
                }
            }

            $all_ids        = array_keys($result['matches']);
            $instituciones  = Doctrine::getTable('Servicio')->findServiciosBusqueda(implode(',', $all_ids));
            $temas          = Doctrine::getTable('Tema')->findTemasBusqueda(implode(',', $all_ids));
            $temas_empresa  = Doctrine::getTable('TemaEmpresa')->findTemasEmpresaBusqueda(implode(',', $all_ids));
            $apoyos_estado  = Doctrine::getTable('ApoyoEstado')->findApoyosBusqueda(implode(',', $all_ids));
            $tipos_empresa  = Doctrine::getTable('TipoEmpresa')->findTipoEmpresaBusqueda(implode(',', $all_ids));
            $etapas_empresa = Doctrine::getTable('EtapaEmpresa')->findEtapaEmpresaBusqueda(implode(',', $all_ids));
            $eventos        = Doctrine::getTable('Evento')->findEventoBusqueda(implode(',', $all_ids));
            $formalidad     = isset($aData['formalidad']) ? $aData['formalidad'] : array() ;
            $rubros         = Doctrine::getTable('Rubro')->findRubroBusqueda(implode(',', $all_ids));
            $req_especial   = isset($aData['req_especial']) ? $aData['req_especial'] : array();
        }else{
            $instituciones  = null;
            $temas          = null;
            $temas_empresa  = null;
            $apoyos_estado  = null;
            $tipos_empresa  = null;
            $etapas_empresa = null;
            $eventos        = null;
            $formalidad     = null;
            $rubros         = null;
            $req_especial   = null;
        }

        //Almacenamos la busqueda en el log
        $this->load->library('user_agent');
        TrackSesion::loadSession();
        $log = new SearchLog();
        $log->search_query          = $buscar;
        $log->search_query_parsed   = $query;
        $log->cantidad_resultados   = $total_fichas+count($promocionados);
        $log->parametros            = $this->input->server('QUERY_STRING'); //Filtros enviados a la busqueda
        $log->referrer              = $this->agent->referrer();
        $log->session_id            = $this->session_track->userdata('session_id');
        $log->save();

        //Se guarda en la sesión el origen de la navegación del usuario para marcas de analytics
        if(!$this->input->cookie('origen_navegacion')){
            $origen_navegacion = 'buscador';
            $origen_navegacion = !empty($filtro_hecho) ? 'etapas' : $origen_navegacion;
            $origen_navegacion = !empty($filtro_temas) ? 'temas' : $origen_navegacion;

            $this->input->set_cookie(array(
                'name'   => 'origen_navegacion',
                'value'  => $origen_navegacion,
                'expire' => '86400',
                'path'   => '/',
                'secure' => FALSE
            ));
        }
        
        //Pasamos los parametros a la vista y cargamos la vista.
        $data['buscar']         = $buscar;    //La busqueda original del usuario
        $data['empresa']        = $empresa;    //Es busqueda de ChilAtiende Empresas?
        $data['query']          = $query;    //La busqueda que se hizo realmente
        $data['suggest']        = $suggest;    //Sugerencia de alternativa
        $data['promocionados']  = $promocionados; //Resultados promocionados
        $data['fichas']         = $fichas;
        $data['total_fichas']   = $total_fichas;
        $data['offset']         = $offset;
        
        $data['temas']          = $temas;
        $data['instituciones']  = $instituciones;
        $data['temas_empresa']  = $temas_empresa;
        $data['apoyos_estado']  = $apoyos_estado;
        $data['tipos_empresa']  = $tipos_empresa;
        $data['etapas_empresa'] = $etapas_empresa;
        $data['eventos']        = $eventos;
        $data['formalidad']     = $formalidad;
        $data['rubros']         = $rubros;
        $data['req_especial']   = $req_especial;
        $data['fps']            = $filtro_fps;

        $data['filtro_temas']           = $filtro_temas;
        $data['filtro_tema_empresa']    = $filtro_tema_empresa;
        $data['filtro_instituciones']   = $filtro_instituciones;
        $data['filtro_apoyo_estado']    = $filtro_apoyo_estado;
        $data['filtro_tipo_empresa']    = $filtro_tipo_empresa;
        $data['filtro_etapa_empresa']   = $filtro_etapa_empresa;
        $data['filtro_evento']          = $filtro_evento;
        $data['filtro_formalizacion']   = $filtro_formalizacion;
        $data['filtro_rubro']           = $filtro_rubro;
        $data['filtro_req_especial']    = $filtro_req_especial;

        $data['title']      = 'Resultados de Búsqueda';
        $data['content']    = 'busqueda/resultado_v2';

        $template = ($empresa) ? 'template_emprendete_v2' : 'template_v2';
            
        $this->load->view($template, $data);
    }

    public function filtros() {
        $per_page = 10;
        //Se obtienen los parametros de busqueda definidos en el input del usuario
        $buscar                 = $this->input->get('buscar');
        $offset                 = (int)$this->input->get('offset');
        $exacto                 = $this->input->get('exacto');
        $empresa = $vista_pymes = $this->input->get('e') && $this->input->get('e') == 1 ? true:false;
        $filtro_etapa_empresa   = $this->input->get('ee') ? explode(',', $this->input->get('ee') ) : array();
        $filtro_tema_empresa    = $this->input->get('te') ? explode(',', $this->input->get('te')) : array();
        $filtro_apoyo_estado    = $this->input->get('ae') ? explode(',', $this->input->get('ae')) : array();
        $filtro_venta_anual     = $this->input->get('va') ? explode(',', $this->input->get('va')) : array();
        $filtro_rubro           = $this->input->get('r') ? explode(',', $this->input->get('r')) : array();
        $filtro_fps             = is_numeric($this->input->get('fps')) ? $this->input->get('fps') : '';

        //Se hace la busqueda en Sphinx
        $this->load->library('sphinxclient');
        $this->sphinxclient->setServer($this->config->item('sphinx_host'),(int)$this->config->item('sphinx_port'));
        $this->sphinxclient->SetFieldWeights(array('keywords' => 10, 'titulo' => 100, 'sic' => 10));
        $this->sphinxclient->SetMatchMode(SPH_MATCH_EXTENDED);
        $this->sphinxclient->setRankingMode(SPH_RANK_EXPR, 'bm25 + 10*(sum(lcs*user_weight)/max_lcs) + 10*(hits/max_hits)');
        $this->sphinxclient->setLimits(0, 1000);

        //Sugerencias en base a diccionario
        $suggest=null;
        $query=trim($buscar);
        if(!$exacto){
            $correccion=Doctrine::getTable('Diccionario')->corregirTexto($query);
            if($correccion!=$query){    //Es decir, hubo una correccion
                $suggest=$query;
                $query=$correccion;     
            }
        }
/*
        if (!empty($filtro_etapa_empresa) && empty($filtro_apoyo_estado)) {
            $this->sphinxclient->setFilter('etapa_empresa_id', $filtro_etapa_empresa);
        }
        */
        if (!empty($filtro_tema_empresa)) {
            $this->sphinxclient->setFilter('tema_empresa_id', $filtro_tema_empresa);
        }
        if (!empty($filtro_apoyo_estado)) {
            $this->sphinxclient->setFilter('apoyo_estado_id', $filtro_apoyo_estado);
        } else {
            $ids = array();
            if( $this->input->get('ee') ) {
                $query_ae = Doctrine_Query::create()->select('ee.id, ae.id as apoyo_id, ae.nombre')->from('EtapaEmpresa ee, ee.ApoyosEstado ae')->where('ee.id = ?', $this->input->get('ee'));
                //echo  $query_ae->getSqlQuery();
                $query_data = $query_ae->execute();

                $aIds = $query_data->toArray();
                
                foreach ($aIds[0]['ApoyosEstado'] as $value) {
                    $ids[] = $value['id'];
                }
            } else {
                $query_ae = Doctrine_Query::create()->select('id')->from('ApoyoEstado')->execute();
                $aIds = $query_ae->toArray();

                foreach ($aIds as $value) {
                    $ids[] = $value['id'];
                }
            }
            
            $this->sphinxclient->setFilter('apoyo_estado_id', $ids);
        }
        if (!empty($filtro_venta_anual)) {
            $this->sphinxclient->setFilter('tipo_empresa_id', $filtro_venta_anual);
        }
        if (!empty($filtro_rubro)) {
            $this->sphinxclient->setFilter('rubro_id', $filtro_rubro);
        }
        if(!empty($filtro_fps)) {
            $this->sphinxclient->SetSelect('*,'.
                'IF( (puntaje_fps_min <= '.$filtro_fps.' AND puntaje_fps_max >= '.$filtro_fps.') OR (puntaje_fps_min = 0 AND puntaje_fps_max >= '.$filtro_fps.'), 1, 0)'.
                ' as filtro_fps');
            $this->sphinxclient->setFilter('filtro_fps',array(1));
        }

        $result = $this->sphinxclient->query($query, 'redchile_fichas');
        
        //Se hace el match de los resultados de Sphinx con el modelo en Doctrine.
        $doctrine_query = Doctrine_Query::create()
                        ->from('Ficha f')
                        ->where('f.maestro = 0 AND f.publicado = 1');

        if ($result['total'] > 0) {
            $page_results=  array_slice($result['matches'],$offset ,$per_page,TRUE);
            $matches = array_keys($page_results);
            $doctrine_query->whereIn('f.id', $matches);
            $doctrine_query->orderBy('FIELD (id, '.implode(',', $matches).')');
        } else {
            $doctrine_query->where('0');
        }

        $fichas = $doctrine_query->execute();
        $total_fichas = $result['total'];

        
        //Se configura la paginacion
        $this->pagination->initialize(array(
            'base_url' => url_buscador(),
            'total_rows' => $total_fichas,
            'per_page' => $per_page
        ));

        $etapas_empresa = Doctrine::getTable('EtapaEmpresa')->findAll()->toArray();
        $temas_empresa  = Doctrine::getTable('TemaEmpresa')->findAll()->toArray();
        $apoyos_estado  = array();
        if($filtro_etapa_empresa) {
            $apoyos_estado = Doctrine::getTable('ApoyoEstado')->getApoyoByEtapa($filtro_etapa_empresa)->toArray();
        }
        $ventas_anuales = Doctrine::getTable('TipoEmpresa')->findAll()->toArray();
        $rubros         = Doctrine::getTable('Rubro')->findAll()->toArray();

        //Pasamos los parametros a la vista y cargamos la vista.
        $data['buscar']         = $buscar;    //La busqueda original del usuario
        $data['empresa']        = $empresa;    //Es busqueda de ChilAtiende Empresas?
        $data['query']          = $query;    //La busqueda que se hizo realmente
        $data['suggest']        = $suggest;    //Sugerencia de alternativa
        $data['fichas']         = $fichas;
        $data['offset']         = $offset;
        $data['total_fichas']   = $total_fichas;
        $data['vista_filtros']  = 'filtro_pyme';

        $data['etapas_empresa']         = $etapas_empresa;
        $data['filtro_etapa_empresa']   = $filtro_etapa_empresa;
        $data['temas_empresa']          = $temas_empresa;
        $data['filtro_tema_empresa']    = $filtro_tema_empresa;
        $data['apoyos_estado']          = $apoyos_estado;
        $data['filtro_apoyo_estado']    = $filtro_apoyo_estado;
        $data['ventas_anuales']         = $ventas_anuales;
        $data['filtro_venta_anual']     = $filtro_venta_anual;
        $data['rubros']                 = $rubros;
        $data['filtro_rubro']           = $filtro_rubro;
        $data['filtro_fps']             = $filtro_fps;
        $data['promocionados']          = array();

        $data['title']      = 'Resultados de Búsqueda';
        $data['content']    = 'busqueda/resultado_v2';

        $template = ($empresa) ? 'template_emprendete_v2' : 'template_v2';
            
        $this->load->view($template, $data);
    }
    
    function ajax_busqueda(){
        $buscar=$this->input->get('buscar');
        
        $this->load->library('sphinxclient');
        $this->sphinxclient->setServer($this->config->item('sphinx_host'),(int)$this->config->item('sphinx_port'));
        //$this->sphinxclient->SetMatchMode(SPH_MATCH_EXTENDED);
        //$this->sphinxclient->setRankingMode(SPH_RANK_EXPR, '(sum(lcs*user_weight)*1000+bm25)*(hits/max_hits)');
        $this->sphinxclient->setSortMode(SPH_SORT_ATTR_DESC,'hits');
        $this->sphinxclient->setLimits(0, 4);
        $result=$this->sphinxclient->query($buscar, 'log_busquedas');
        
        $resultados=array();
        if($result['total']>0)
            foreach($result['matches'] as $m)
                $resultados[]=Doctrine::getTable('Diccionario')->corregirTexto($m['attrs']['search_query']);
        
        $resultados = array_values( array_unique( $resultados ) );
        
        echo json_encode($resultados);
    }

}
