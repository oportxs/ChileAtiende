<?php
class CampanaModuloTable extends Doctrine_Table {
    public function CampanasActivas() {
        $query = Doctrine_Query::create();
        $query->from('CampanaModulo c');
        $query->where('c.estado = 1');
        
        $resultado = $query->execute();

        return $resultado;
    }
}
