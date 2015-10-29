<?php

class HistorialSubFicha extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('sub_ficha_id');
        $this->hasColumn('sub_ficha_version_id');
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

        $this->hasOne('SubFicha', array(
            'local' => 'sub_ficha_id',
            'foreign' => 'id'
        ));

        $this->hasOne('SubFicha as SubFichaVersion', array(
            'local' => 'sub_ficha_version_id',
            'foreign' => 'id'
        ));

    }
}
?>
