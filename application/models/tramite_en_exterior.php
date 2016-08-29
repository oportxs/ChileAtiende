<?php
    /**
    * Modelo para los tramites en exterior
    */
    class TramiteEnExterior extends Doctrine_Record
    {
        public function setTableDefinition()
        {
            $this->setTableName('tramite_en_exterior');
            $this->hasColumn('id');
            $this->hasColumn('id_ficha');
            $this->hasColumn('destacado', 'boolean', 1, array('default' => 0));
            $this->hasColumn('content_updated_data_at');
            $this->hasColumn('motivo');
            $this->hasColumn('motivo_id');

            $this->hasMany('MotivosEnExterior as MotivosEnExterior', array(
                'local' => 'id',
                'foreign' => 'motivo_id'
            ));

        }
    }

?>