<?php

class ApoyoEstadoTable extends Doctrine_Table {

    /**
     * Funcion que implementa la busqueda de temas de fichas asociadas a la busqueda
     */
    function findApoyosBusqueda($set_de_fichas) {

        $query = Doctrine_Query::create();
        $query->select("a.id, ee.nombre AS ee_nombre, a.nombre, COUNT(a.id) AS numero_fichas");
        $query->from('ApoyoEstado a, a.EtapasEmpresa ee, a.Fichas f');
        
        if ($set_de_fichas) {
            $query->where("f.id IN (" . $set_de_fichas . ")");
        } else {
            $query->where("f.id IN (0)");
        }

        $query->groupBy("a.id");
        $query->orderBy("a.nombre ASC");
        //debug($query->getSqlQuery());
        return $query->execute();
    }

    function todosApoyos($options = array()) {

        $query = Doctrine_Query::create()
                ->from('ApoyoEstado ae')
                ->orderBy('ae.nombre');

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

    function getEtapaName($etapa_vida, $nombre) {
        $query = Doctrine_Query::create();
        $query->select("ae.id, ae.nombre");
        $query->from('ApoyoEstado ae');
        $query->leftJoin('ae.EtapasEmpresa e');
        $query->andWhere('e.id = ?', $etapa_vida);
        $query->andWhere('ae.nombre LIKE ?', $nombre);
        return $query->execute();
    }

    function getApoyoByEtapa($etapa_id) {
        $query = Doctrine_Query::create();
        $query->from('ApoyoEstado ae, ae.EtapasEmpresa ee');
        $query->where('ee.id = ?', $etapa_id);
        return $query->execute();
    }

}