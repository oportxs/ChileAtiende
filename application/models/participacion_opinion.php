<?php
    class ParticipacionOpinion extends Doctrine_Record {
        public function setTableDefinition()
        {
            $this->setTableName('participacion_opinion');
            $this->hasColumn('id');
            $this->hasColumn('ficha_id');
            $this->hasColumn('informacion_util');
            $this->hasColumn('informacion_facil_de_encontrar');
            $this->hasColumn('que_podemos_mejorar');
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