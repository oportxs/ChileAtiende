<?php

/*
 * SPHINX HELPER:
 * Wrapper para la api de Sphinx para Redchile
 * 
 */

/*Toma el resultado de search y retorna solo el set de ids de fichas*/
function search_wrapper($search_result,$weights = FALSE){
    
    if(!function_exists("lambda_search")){
        function lambda_search($x){return $x['weight'];}
    }

    list($result_set,$status,$message,$full_result) = $search_result;
    
    if($status && $result_set && is_array($result_set) && count($result_set)){
        if(!$weights){
            return array_keys($result_set);
        }else{
            return array_combine(
                    array_keys($result_set), 
                    array_values(
                            array_map(
                                    "lambda_search",
                                    $result_set)));
        }
    }
    
    return array();
}

function merge_flujos_fichas($flujos, $fichas){
	$result = $fichas;
	$result[0] = $flujos[0]+$fichas[0];
	$result[3] = $fichas[3]+count($flujos[0]);
	return $result;
}

function search($string, $filters = array(), $nonfulltext = false, $limit = null, $offset = null, $max_flujos = 2){
	$offset = intval($offset);//Se fuerza el offset como entero

	//Si viene definido el filtro de flujos o se está obteniendo el total, hace la busqueda directamente
	if(isset($filters['flujo']) || $limit > 1000){
		return run_search($string, $filters, $nonfulltext, $limit, $offset);
	}

	//Solo se buscan flujos en la primera pagina o se está obteniendo el total
	if($offset <= 0){

		//Se buscan primero solo los flujos
		$filters['flujo'] = array(1);
		$flujos = run_search($string, $filters, $nonfulltext, $max_flujos, $offset);
		
		//Luego se buscan solo las fichas
		$filters['flujo'] = array(0);
		$fichas = run_search($string, $filters, $nonfulltext, $limit, $offset);
		
		//Se mesclan los flujos con las fichas
		return merge_flujos_fichas($flujos, $fichas);

	}else{
		
		$filters['flujo'] = array(0);
		return run_search($string, $filters, $nonfulltext, $limit, $offset);

	}

}

/*Busca usando sphinx, para buscar solo filtrando setear $nonfulltext a true*/
function run_search($string, $filters = array(), $nonfulltext = false, $limit = null, $offset = null) {
    
    $status = FALSE;
    $message = "Default";
    $result_set = array();
    
    $CI=&get_instance();
    
    //Se hace el stemming y wordforms en PHP mientras Sphinx no lo soporte en forma nativa en español
    $CI->load->library('stemm_es');
    
    $string_arr=explode(' ', $string);
    $wordforms=file('sphinx/etc/wordforms.txt');
    foreach($string_arr as &$s){    
        foreach($wordforms as $w){
            preg_match('/(\w+)\s*>\s*(\w+)/', $w, $matches);
            if(isset($matches[1]) && isset($matches[2]))
            if($matches[1]==$s){
                $s=$matches[2];
                break;
            }
        }
 
        $s=$CI->stemm_es->stemm($s);
    }
    
    $string=implode(' ', $string_arr);

    
    /* Para que esto funcione debe estar instalado sphinx y corriendo el demonio searchd en el servidor */
    /* http://www.hackido.com/2009/01/install-sphinx-search-on-ubuntu.html */
    /* O buscar en synaptic en caso de ubuntu por sphinx */
    /* IMPORTANTE: La api debe coincidir con la version de sphinx instalada!*/

    /* Cargo API de sphinx */
    $CI->load->library("sphinxclient");

    /* Config de Sphinx para Redchile de acuerdo a sphinx.conf */
    $CI->config->load('sphinx');

    $port = $CI->config->item('port');
    $server = $CI->config->item('server');
    $index = $CI->config->item('index');

    /*Asigno limites a la consulta*/
    if($limit !== null && $offset !== null){
        $CI->sphinxclient->SetLimits($offset,$limit,10000);
    }
    
    $CI->sphinxclient->SetServer($server, $port);
    $CI->sphinxclient->SetSortMode(SPH_SORT_EXTENDED,"flujo DESC, @weight DESC");
    
    $CI->sphinxclient->SetMatchMode(SPH_MATCH_EXTENDED2);
    // $CI->sphinxclient->setRankingMode(SPH_RANK_PROXIMITY_BM25);

    // SPH_RANK_PROXIMITY_BM25 = 'sum(lcs*user_weight)*1000+bm25'
    // Al ranking usado anteriormente, se le aplica un nuevo factor que considera los hits de cada ficha.
    $CI->sphinxclient->setRankingMode(SPH_RANK_EXPR, '(sum(lcs*user_weight)*1000+bm25)*(hits/max_hits)');
    
    //Se asignan pesos a los campos especificos.
    //Cada match suma 200 o 50 puntos respectivamente.
    //En otro campo un match va a sumar 1 punto.
    //El total aparece en el campo @weight de sphinx.
    $CI->sphinxclient->SetFieldWeights(array('keywords'=> 400,'titulo' => 200,'sic'=>200,'objetivo' => 50));
    
    /*Reseteo filtros, para poder invocar el objeto y hacer filtros varias veces*/
    $CI->sphinxclient->ResetFilters();
    
    /* Asigno filtros */
    //Except: Campos que requieren AND logico.
    $excep = array("tema_id","servicio_codigo","tema_empresa_id","apoyo_estado_id");
    
    if(is_array($filters) && count($filters)>0){
        foreach($filters as $field=>$values){
            //En este caso es necesario que cada valor represente un AND logico.
            //Para ello es necesiaro definir un filtro distinto por cada valor en el mismo campo.
            if(in_array($field,$excep)){
                foreach($values as $vls){
                    $CI->sphinxclient->SetFilter($field,array($vls));
                }
            }else{
                //En este caso, por cada campo se genera un filtro.
                //Sphinx toma como OR los valores posibles para mismo un campo si se definene en el mismo filtro.
                $CI->sphinxclient->SetFilter($field,$values);
            }
        }
    }
    
    /* Hago la consulta */
    $result = $CI->sphinxclient->Query($string, $index); //String, Index
    
    /* Proceso resultado */
    if ($result === false) {
        //Tipicamente este caso va a ser por que Sphinx no esta corriendo.
        $message = "Query failed: " . $CI->sphinxclient->GetLastError();
    } else {
        if ($CI->sphinxclient->GetLastWarning()) {
            $message = "WARNING: " . $CI->sphinxclient->GetLastWarning() . "";
        }else{
            $status = TRUE;
            if(isset($result['matches'])){
                $result_set = $result['matches'];
            }else{
                $message = "Empty Set";
                $result_set = array();
            }
        }
    }
    
    return array($result_set,$status,$message,$result['total']);
    
}

function new_run_search($string, $filters = array(), $nonfulltext = false, $limit = null, $offset = null) {
    
    $status = FALSE;
    $message = "";
    $result_set = array();
    
    $CI =& get_instance();
    
    /* Cargo API de sphinx */
    $CI->load->library("sphinxclient");

    /* Config de Sphinx para Redchile de acuerdo a sphinx.conf */
    $CI->config->load('sphinx');

    $port = $CI->config->item('port');
    $server = $CI->config->item('server');
    $index = $CI->config->item('index');

    /*Asigno limites a la consulta*/
    if($limit !== null && $offset !== null){
        $CI->sphinxclient->SetLimits($offset,$limit,10000);
    }
    
    $CI->sphinxclient->SetServer($server, $port);
    $CI->sphinxclient->SetSortMode(SPH_SORT_EXTENDED,!$nonfulltext?"flujo DESC, @weight DESC":"flujo DESC, hits DESC");
    

    $CI->sphinxclient->SetMatchMode(($nonfulltext)?SPH_MATCH_EXTENDED2:SPH_MATCH_FULLSCAN);
    // $CI->sphinxclient->setRankingMode(SPH_RANK_PROXIMITY_BM25);

    // SPH_RANK_PROXIMITY_BM25 = 'sum(lcs*user_weight)*1000+bm25'
    // Al ranking usado anteriormente, se le aplica un nuevo factor que considera los hits de cada ficha.
    $CI->sphinxclient->setRankingMode(SPH_RANK_EXPR, '(sum(lcs*user_weight)*1000+bm25)*(hits/max_hits)');
    
    //Se asignan pesos a los campos especificos.
    //Cada match suma 200 o 50 puntos respectivamente.
    //En otro campo un match va a sumar 1 punto.
    //El total aparece en el campo @weight de sphinx.
    $CI->sphinxclient->SetFieldWeights(array('keywords'=> 400,'titulo' => 200,'sic'=>200,'objetivo' => 50));
    
    /*Reseteo filtros, para poder invocar el objeto y hacer filtros varias veces*/
    $CI->sphinxclient->ResetFilters();
    
    /* Asigno filtros */
    //Except: Campos que requieren AND logico.
    $excep = array("hecho_empresa_id","etapa_empresa_id","apoyo_estado_id","tipo_empresa_id","rubro_id","evento_id","requisito_especial","formalizacion");
    //print_r($filters);

    //22310         3-1
    //22330         1-2
    //22330-22310   2-1
    //22330         2-3
    //22311         3-3
    //$CI->sphinxclient->SetFilter("tipo_empresa_id",array(3));
    //$CI->sphinxclient->SetFilter("apoyo_estado_id",array(3,1));

    echo '<pre>';
    print_r($filters["filtros"]);
    echo '</pre>';
    
    if(is_array($filters["filtros"]) && count($filters["filtros"])>0){
        foreach($filters["filtros"] as $field => $values){
            if( in_array( $field, $excep ) ) {
                if( count($filters["filtros"][$field])>0 ) {
                    //setFilter('string',array());
                    $CI->sphinxclient->SetFilter($field,$values);
                }
            }
            if($field == "fps") {
                //echo "value: ".$values;
                $CI->sphinxclient->SetFilterRange('puntaje_fps_min',0,$values);
                $CI->sphinxclient->SetFilterRange('puntaje_fps_max',$values,1000);
            }
        }
    }

    
    //$CI->sphinxclient->SetFilter("puntaje_fps_min",array(800));
    //$CI->sphinxclient->SetFilter("puntaje_fps_max",array(800));
    
    //exit();
    
    /* Hago la consulta */
    //echo $string.", ".$index.'<br>';
    $result = $CI->sphinxclient->Query($string, $index); //String, Index
    
    /* Proceso resultado */
    if ($result === false) {
        //Tipicamente este caso va a ser por que Sphinx no esta corriendo.
        $message = "Query failed: " . $CI->sphinxclient->GetLastError();
    } else {
        if ($CI->sphinxclient->GetLastWarning()) {
            $message = "WARNING: " . $CI->sphinxclient->GetLastWarning() . "";
        }else{
            $status = TRUE;
            if(isset($result['matches'])){
                $result_set = $result;
            }else{
                $message = "Empty Set";
                $result_set = array();
            }
        }
    }
    
    return array($result_set,'status'=>$status,'mensaje'=>$message);
}

function run_search_log_search($busqueda, $limit = 10){
	$status = FALSE;
	$message = "Default";
	$result_set = array();

	$CI =& get_instance();

	/* Para que esto funcione debe estar instalado sphinx y corriendo el demonio searchd en el servidor */
	/* http://www.hackido.com/2009/01/install-sphinx-search-on-ubuntu.html */
	/* O buscar en synaptic en caso de ubuntu por sphinx */
	/* IMPORTANTE: La api debe coincidir con la version de sphinx instalada!*/

	/* Cargo API de sphinx */
	$CI->load->library("sphinxclient");

	/* Config de Sphinx para Redchile de acuerdo a sphinx.conf */
	$CI->config->load('sphinx');

	$port = $CI->config->item('port');
	$server = $CI->config->item('server');
	$index = $CI->config->item('index_log_busquedas');

	$CI->sphinxclient->SetLimits(0,$limit,10000);
 	$CI->sphinxclient->SetServer($server, $port);

  $CI->sphinxclient->SetSortMode(SPH_SORT_EXTENDED,"hits DESC");
  
  $CI->sphinxclient->setRankingMode(SPH_RANK_PROXIMITY_BM25);

  //Se asignan pesos a los campos especificos.
  //Cada match suma 200 o 50 puntos respectivamente.
  //En otro campo un match va a sumar 1 punto.
  //El total aparece en el campo @weight de sphinx.
  $CI->sphinxclient->SetFieldWeights(array('search_query_parsed'=> 400));
  
  /*Reseteo filtros, para poder invocar el objeto y hacer filtros varias veces*/
  $CI->sphinxclient->ResetFilters();
	
	return $CI->sphinxclient->Query($busqueda, $index);
}

?>
