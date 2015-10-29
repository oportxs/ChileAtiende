<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class SearchLogTable extends Doctrine_Table {
    function getMasBuscados($limit = False) {
        $query = Doctrine_Query::create();
        $query->select('COUNT(*) AS cnt, search_query');
        $query->from('SearchLog');
        $query->groupby('search_query');
        $query->orderby('cnt DESC');
        if($limit) $query->limit( $limit );

        $result = $query->execute();
        return $result;
    }

    function findSugerenciasBuqueda($busqueda, $limit = 5){

			$ci = &get_instance();
      $ci->load->helper("sphinx");

      $ids_busquedas = array();

      $result = run_search_log_search(urldecode($busqueda), $limit);
      
      if(!isset($result['matches']))
      	return array();

      foreach ($result['matches'] as $id => $match) {
      	$ids_busquedas[] = $id;
      }
      
      $query = Doctrine_Query::create();
      $query->select('s.search_query_parsed, s.cantidad_resultados, s.id');
      $query->from('SearchLog s');
      $query->whereIn('s.id', $ids_busquedas);
      //$query->orderBy('cantidad_resultados DESC');
      $query->orderBy("FIELD(id," . implode(',', $ids_busquedas) . ")");

      $sugerencias = $query->execute()->toArray();

      foreach ($sugerencias as $key => $sugerencia) {
    		$a_sugerencias[$key]['hits'] = $sugerencia['cantidad_resultados'];
    		$a_sugerencias[$key]['sugerencia'] = $sugerencia['search_query_parsed'];
    	}

      return $a_sugerencias;
    }
}