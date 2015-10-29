<?php

class Region extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
    }
    
    function  setUp() {
        parent::setUp();
        
        $this->hasMany('Ficha as Fichas',array(
            'local' => 'region_id',
            'foreign' => 'ficha_id',
            'refClass' => 'FichaHasRegion'
        ));

        $this->hasMany('Evento as Eventos', array(
            'local' => 'region_id',
            'foreign' => 'evento_id',
            'refClass' => 'EventoHasRegion'
        ));
    }
    
    public function hasRegion($region_id) {
        foreach ($this->Regiones as $r) {
            if ($region_id == $r->id)
                return TRUE;
        }
        return FALSE;
    }
}