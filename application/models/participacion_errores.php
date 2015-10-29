<?php
    class ParticipacionErrores extends Doctrine_Record {
        public function setTableDefinition()
        {
            $this->setTableName('participacion_errores');
            $this->hasColumn('id');
            $this->hasColumn('ficha_id');
            $this->hasColumn('descripcion');
        }

        public function setUp()
        {
            parent::setUp();
            $this->actAs('Timestampable');
            $this->hasOne('Ficha', array(
                 'local' => 'ficha_id',
                 'foreign' => 'id'));
        }
    }
?>