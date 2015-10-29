<?php

class TipoEmpresa extends Doctrine_Record {

    function setTableDefinition() {

        $this->hasColumn('id');
        $this->hasColumn('nombre');
    }

    function setUp() {
        parent::setUp();
        
        $this->hasMany('Ficha as Fichas', array(
            'local' => 'tipo_empresa_id',
            'foreign' => 'ficha_id',
            'refClass' => 'FichaHasTipoEmpresa'
        ));
    }

}

?>
