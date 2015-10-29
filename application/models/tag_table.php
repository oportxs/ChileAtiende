<?php

class TagTable extends Doctrine_Table {

    public function findConServicios($options = array()) {
        $query = Doctrine_Query::create();
        $query->select('t.*, COUNT(s.codigo) AS numero_servicios');
        // $query->where('count(s.codigo) > 0');
        $query->from('Tag t, t.Servicios s');
        $query->having('numero_servicios > 0');
        $query->orderBy('t.nombre');
        $query->groupBy('t.id');
        // debug($query->getSqlQuery(),"red");
        $resultado = $query->execute();

        return $resultado;
    }

}

?>
