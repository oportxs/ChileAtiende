<?php
    /**
    * Modelo para los tramites en convenio
    */
    class TramiteEnConvenio extends Doctrine_Record
    {
        public function setTableDefinition()
        {
            $this->setTableName('tramite_en_convenio');
            $this->hasColumn('id');
            $this->hasColumn('titulo');
            $this->hasColumn('url_imagen');
            $this->hasColumn('url_tramite');
            $this->hasColumn('ficha_id');
            $this->hasColumn('global', 'boolean', 1, array('default' => 0));
        }

        public function setUp()
        {
            parent::setUp();
            $this->hasOne('Ficha', array(
                 'local' => 'ficha_id',
                 'foreign' => 'id'));

            $this->hasMany('Oficina as Oficinas', array(
                'local' => 'tramite_en_convenio_id',
                'foreign' => 'oficina_id',
                'refClass' => 'OficinaHasTramiteEnConvenio'
            ));
        }

        public function hasOficina($oficina_id)
        {

            foreach ($this->Oficinas as $o) {
                if($o->id == $oficina_id)
                    return true;
            }

            return false;
        }


        public function setOficinasFromArray($oficinas_id) {

            foreach ($this->Oficinas as $key => $s)
                unset($this->Oficinas[$key]);

            if ($oficinas_id)
                foreach ($oficinas_id as $oficina_id)
                    $this->Oficinas[] = Doctrine::getTable('Oficina')->find($oficina_id);
        }

    }
?>