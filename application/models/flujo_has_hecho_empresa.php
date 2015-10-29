<?php

class FlujoHasHechoEmpresa extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('flujo_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));

        $this->hasColumn('hecho_empresa_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));
    }

}

?>
