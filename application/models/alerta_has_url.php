<?php

class AlertaHasUrl extends Doctrine_Record {
    function setTableDefinition() {
        $this->hasColumn('alerta_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));

        $this->hasColumn('alerta_url_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));
    }
} 