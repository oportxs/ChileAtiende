<?php
class Migration_Publicado_Evento extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'evento', 'publicado', 'integer' , 1, array( 'notnull' => 1, 'default' => 0));
    }

    public function postUp()
    {
        $rol = new Rol();
        $rol->id = 'cal-editor';
        $rol->nombre = 'Calendario-Editor';
        $rol->descripcion = 'Usuario que puede agregar eventos en las fichas';
        $rol->save();

        $rol = new Rol();
        $rol->id = 'cal-publicador';
        $rol->nombre = 'Calendario-Publicador';
        $rol->descripcion = 'Usuario que puede publicar eventos en el calendario';
        $rol->save();

    }
    
    public function down()
    {
        $this->removeColumn( 'evento', 'publicado' );

        Doctrine::getTable('Rol')->findByNombre('Calendario-Editor')->delete();
        Doctrine::getTable('Rol')->findByNombre('Calendario-Publicador')->delete();
    }
}