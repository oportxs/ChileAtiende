<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class HistorialContenido extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('contenido_id');
        $this->hasColumn('contenido_version_id');
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

        $this->hasOne('Contenido', array(
            'local' => 'contenido_id',
            'foreign' => 'id'
        ));

        $this->hasOne('Contenido as ContenidoVersion', array(
            'local' => 'contenido_version_id',
            'foreign' => 'id'
        ));

    }
}
?>
