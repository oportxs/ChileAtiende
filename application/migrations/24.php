<?php
class Migration_VersionamientoEventos extends Doctrine_Migration_Base {

    public function up()
    {
        // Tabla para el modelo HistorialEvento
        $this->createTable('historial_evento', array(
            'id' => array('type' => 'integer', 'primary'=>1, 'unsigned'=>1, 'autoincrement'=>1),
            'evento_id' => array('type' => 'int', 'unsigned' => 1, 'notnull' => 0),
            'evento_version_id' => array('type' => 'int', 'unsigned' => 1, 'notnull' => 0),
            'usuario_backend_id' => array('type' => 'int(10) unsigned', 'notnull' => 0),
            'descripcion' => array('type' => 'text', 'notnull' => 1),
            'created_at' => array('type' => 'datetime', 'notnull' => 0),
            'updated_at' => array('type' => 'datetime', 'notnull' => 0)
        ));

        $this->createForeignKey('historial_evento', 'fk_historial_evento_id', 
            array('local' => 'evento_id', 'foreign' => 'id', 'foreignTable' => 'evento', 'onDelete' => 'SET NULL'));
        
        $this->createForeignKey('historial_evento', 'fk_historial_evento_version_id', 
            array('local' => 'evento_version_id', 'foreign' => 'id', 'foreignTable' => 'evento', 'onDelete' => 'SET NULL'));
        
        $this->createForeignKey('historial_evento', 'fk_historial_usuario_backend_id', 
            array('local' => 'usuario_backend_id', 'foreign' => 'id', 'foreignTable' => 'usuario_backend', 'onDelete' => 'SET NULL'));

        // Modificacion para el model Evento
        $this->dropForeignKey('evento', 'fk_evento_region1');
        $this->removeColumn('evento', 'region_id');
        $this->addColumn( 'evento', 'created_at', 'datetime');
        $this->addColumn( 'evento', 'updated_at', 'datetime');
        $this->addColumn( 'evento', 'publicado_at', 'datetime');
        $this->addColumn( 'evento', 'maestro', 'boolean', 1, array( 'notnull' => 0 ));
        $this->addColumn( 'evento', 'maestro_id', 'int', null, array( 'unsigned' => 1, 'notnull' => 0 ));
    }

    public function down()
    {
        $this->dropTable('historial_evento');
        $this->removeColumn('evento', 'created_at');
        $this->removeColumn('evento', 'updated_at');
        $this->removeColumn('evento', 'publicado_at');
        $this->removeColumn('evento', 'maestro');
        $this->removeColumn('evento', 'maestro_id');
        $this->addColumn( 'evento', 'region_id', 'integer', null, array( 'notnull' => 0));
        $this->createForeignKey('evento', 'fk_evento_region1', array('local' => 'region_id', 'foreign' => 'id', 'foreignTable' => 'region', 'onDelete' => 'SET NULL'));
    }
}
?>


