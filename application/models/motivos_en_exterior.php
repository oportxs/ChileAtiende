<?php
    /**
    * Modelo para los motivos de tramites en exterior
    */
    class MotivosEnExterior extends Doctrine_Record
    {
        public function setTableDefinition()
        {
            $this->setTableName('motivos_en_exterior');
            $this->hasColumn('id');
            $this->hasColumn('nombre');

        }
    }

?>