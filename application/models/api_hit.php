<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ApiHit extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('count');
        $this->hasColumn('fecha');
        $this->hasColumn('api_acceso_id');
    }

    function  setUp() {
        parent::setup();
        
        $this->hasOne('ApiAcceso', array(
            'local' => 'api_acceso_id',
            'foreign' => 'id'
        ));
    }
}
?>
