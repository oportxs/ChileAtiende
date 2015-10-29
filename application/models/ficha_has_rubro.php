<?php

class FichaHasRubro extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('ficha_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));

        $this->hasColumn('rubro_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));
    }

}
