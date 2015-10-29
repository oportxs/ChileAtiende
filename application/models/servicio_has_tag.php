<?php

class ServicioHasTag extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('servicio_codigo', 'string', 8, array (
            'primary' => true,
            'autoincrement' => false
        ));
        $this->hasColumn('tag_id', 'integer', 4, array (
            'primary' => true,
            'autoincrement' => false
        ));
    }
}
?>
