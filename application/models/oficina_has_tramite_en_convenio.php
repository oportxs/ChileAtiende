<?php
    /**
    * Asociación de oficinas con tramites en convenio
    */
    class OficinaHasTramiteEnConvenio extends Doctrine_Record
    {
        public function setTableDefinition()
        {
            $this->setTableName('oficina_has_tramite_en_convenio');
            $this->hasColumn('oficina_id', 'integer', 4, array(
                'primary' => true,
                'autoincrement' => false
            ));

            $this->hasColumn('tramite_en_convenio_id', 'integer', 4, array(
                'primary' => true,
                'autoincrement' => false
            ));
        }
    }
?>