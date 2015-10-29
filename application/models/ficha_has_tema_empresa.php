<?php

class FichaHasTemaEmpresa extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('ficha_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));

        $this->hasColumn('tema_empresa_id', 'integer', 4, array(
            'primary' => true,
            'autoincrement' => false
        ));
    }

}

?>
