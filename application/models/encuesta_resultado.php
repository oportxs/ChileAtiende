<?php

class EncuestaResultado extends Doctrine_Record {
    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('encuesta_id');
        $this->hasColumn('ficha_maestro_id');
        $this->hasColumn('ficha_publicada_id');
        $this->hasColumn('resultado');
    }

    function setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasOne('Encuesta as Encuesta', array(
            'local' => 'encuesta_id',
            'foreign' => 'id'
        ));

        $this->hasOne('Ficha as Ficha', array(
            'local' => 'ficha_maestro_id',
            'foreign' => 'id'
        ));

        $this->hasOne('Ficha as Version', array(
            'local' => 'ficha_publicada_id',
            'foreign' => 'id'
        ));
    }
} 