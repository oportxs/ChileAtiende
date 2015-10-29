<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class CampanaModuloHasSector extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('campana_modulo_id','integer',null,array (
            'primary' => true,
            'autoincrement' => false
        ));

        $this->hasColumn('sector_codigo','varchar',null,array (
            'primary' => true,
            'autoincrement' => false
        ));
    }
}
?>
