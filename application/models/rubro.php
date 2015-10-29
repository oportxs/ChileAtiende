<?php

class Rubro extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
    }

    function setUp() {
        parent::setUp();

        $this->hasMany('Ficha as Fichas', array(
            'local' => 'rubro_id',
            'foreign' => 'ficha_id',
            'refClass' => 'FichaHasRubro'
        ));
    }

    public function hasRubro($rubro_id) {
        foreach ($this->Rubros as $r) {
            if ($rubro_id == $r->id)
                return TRUE;
        }
        return FALSE;
    }

}