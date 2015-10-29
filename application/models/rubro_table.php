<?php

class RubroTable extends Doctrine_Table {

    /**
     * Funcion que implementa la busqueda de temas de fichas asociadas a la busqueda
     */
    function findRubroBusqueda($set_de_fichas) {

        $query = Doctrine_Query::create();
        $query->select("r.id, r.nombre, COUNT(r.id) AS numero_fichas");
        $query->from('Rubro r, r.Fichas f');
        
        if ($set_de_fichas) {
            $query->where("f.id IN (" . $set_de_fichas . ")");
        } else {
            $query->where("f.id IN (0)");
        }

        $query->groupBy("r.id");
        $query->orderBy("r.nombre ASC");
        //debug($query->getSqlQuery());
        return $query->execute();
    }

}