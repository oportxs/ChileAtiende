<?php

class ApiAcceso extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('token');
        $this->hasColumn('email');
        $this->hasColumn('nombre');
        $this->hasColumn('apellido');
        $this->hasColumn('empresa');
    }

    function  setUp() {
        parent::setUp();
        
        $this->actAs('Timestampable');
        
        $this->hasMany('ApiHit as ApiHits',array(
            'local'=>'id',
            'foreign'=>'api_acceso_id'
        ));

        

    }
}
