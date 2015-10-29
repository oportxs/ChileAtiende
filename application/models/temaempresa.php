<?php

class TemaEmpresa extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
    }

    function setUp() {
        parent::setUp();

        $this->hasMany('Ficha as Fichas', array(
            'local' => 'tema_empresa_id',
            'foreign' => 'ficha_id',
            'refClass' => 'FichaHasTemaEmpresa'
        ));
    }

    public function toString() {
        return $this->nombre;
    }

}

?>