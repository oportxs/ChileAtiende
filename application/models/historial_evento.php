<?php

class HistorialEvento extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('evento_id');
        $this->hasColumn('evento_version_id');
        $this->hasColumn('usuario_backend_id');
        $this->hasColumn('descripcion');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasOne('UsuarioBackend', array(
            'local' => 'usuario_backend_id',
            'foreign' => 'id'
        ));

        $this->hasOne('Evento', array(
            'local' => 'evento_id',
            'foreign' => 'id'
        ));

        $this->hasOne('Evento as EventoVersion', array(
            'local' => 'evento_version_id',
            'foreign' => 'id'
        ));

    }
}
?>
