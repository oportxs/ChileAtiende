<?php

class SearchPromocionadoTable extends Doctrine_Table {

    public function search($input_query) {
        $patrocinados = new Doctrine_Collection('SearchPromocionado');

        $activos = Doctrine_Query::create()
                ->from('SearchPromocionado s')
                ->where('s.activo = 1')
                ->orderBy('s.orden ASC')
                ->execute();

        foreach ($activos as $s) {
            if ($s->regex) {
                if (preg_match('/' . $s->query . '/', $input_query))
                    $patrocinados[] = $s;
            }else {
                $terminos = preg_split('/\s*,\s*/', $s->query);
                foreach ($terminos as $t){
                    if (strpos($input_query, $t) !== false){
                        $patrocinados[] = $s;
                        break;
                    }
                }
            }
        }

        return $patrocinados;
    }

}