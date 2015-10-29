<?php

class FichaHasRegion extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('ficha_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));

        $this->hasColumn('region_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));
    }

}