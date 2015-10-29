<?php

class EventoHasRegion extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('evento_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));

        $this->hasColumn('region_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));
    }

}

?>
