<?php

class Migration_RolesEvento extends Doctrine_Migration_Base {
    public function up() {

        Doctrine::getTable('Rol')->findByNombre('Calendario')->delete();
        
        $rol = new Rol();
        $rol->id = 'cal-aprobador';
        $rol->nombre = 'Calendario-Aprobador';
        $rol->descripcion = 'Usuario que puede aprobar y enviar a revision eventos';
        $rol->save();
    
    }

    public function down() {
        
        $rol = new Rol();
        $rol->id = 'calendario';
        $rol->nombre = 'Calendario';
        $rol->descripcion = '';
        $rol->save();

        Doctrine::getTable('Rol')->findByNombre('Calendario-Aprobador')->delete();
    }
} 

?>
