<?php

class Encuesta extends Doctrine_Record {
    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
    }

    function setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('EncuestaResultado as Resultados', array(
            'local' => 'id',
            'foreign' => 'encuesta_id',
            'orderBy' => 'id desc'
        ));
    }
} 