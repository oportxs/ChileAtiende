<?php

class HechoEmpresaTable extends Doctrine_Table {

    function todosHechos($options = array()) {

        $query = Doctrine_Query::create()
                ->from('HechoEmpresa h')
                ->orderBy('h.nombre');

        if (isset($options['limit']))
            $query->limit($options['limit']);

        if (isset($options['offset']))
            $query->offset($options['offset']);

        if (isset($options['order_by'])) {
            $query->orderBy($options['order_by']);
        }

        if (isset($options['justCount']))
            $resultado = $query->count();
        else
            $resultado = $query->execute();

        return $resultado;
    }

    //Retorna un hecho de la vida asociado a un nombre y una etapa
    
    function getEtapaName($etapa_empresa,$nombre){
        $query = Doctrine_Query::create();
        $query->select("h.id, h.nombre");
        $query->from('HechoEmpresa h');
        $query->leftJoin('h.EtapasEmpresa e');
        $query->andWhere('e.id = ?',$etapa_empresa);
        $query->andWhere('h.nombre LIKE ?',$nombre);
        return $query->execute();
    }

//permite obtener nro de hechos de vida asociados a una etapa
    function obtieneHechosEmpresa($id) {
        $query = Doctrine_Query::create();
        $query->select('COUNT(*) AS cnt');
        $query->from('HechoEmpresa hv, hv.EtapasEmpresa ev');
        $query->where('ev.id = ?', $id);
        //debug($query->getSqlQuery(),"red");
        $resultado = $query->fetchOne();

        return $resultado;
    }

    /**
     * Funcion que implementa la busqueda de temas de fichas asociadas a la busqueda
     */
    function findHechosEmpresaBusqueda($set_de_fichas) {

        $query = Doctrine_Query::create();
        $query->select("he.id, he.nombre, COUNT(he.id) AS numero_fichas");
        $query->from('HechoEmpresa he, he.Fichas f');
        
        if ($set_de_fichas) {
            $query->where("f.id IN (" . $set_de_fichas . ")");
        } else {
            $query->where("f.id IN (0)");
        }

        $query->groupBy("he.id");
        $query->orderBy("he.nombre ASC");
        //debug($query->getSqlQuery());
        return $query->execute();
    }

}