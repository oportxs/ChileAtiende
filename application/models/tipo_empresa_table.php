<?php

class TipoEmpresaTable extends Doctrine_Table {
	/**
     * Funcion que implementa la busqueda de temas de fichas asociadas a la busqueda
     */
    function findTipoEmpresaBusqueda($set_de_fichas) {

        $query = Doctrine_Query::create();
        $query->select("te.id, te.nombre, COUNT(te.id) AS numero_fichas");
        $query->from('TipoEmpresa te, te.Fichas f');
        
        if ($set_de_fichas) {
            $query->where("f.id IN (" . $set_de_fichas . ")");
        } else {
            $query->where("f.id IN (0)");
        }

        $query->groupBy("te.id");
        $query->orderBy("te.nombre ASC");
        //debug($query->getSqlQuery());
        return $query->execute();
    }
}