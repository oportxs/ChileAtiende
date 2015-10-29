<?php

class FichaHasApoyoEstado extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('ficha_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));

        $this->hasColumn('apoyo_estado_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));
    }

}

?>
