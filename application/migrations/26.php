<?php
class Migration_AlertasChileatiende extends Doctrine_Migration_Base {

    public function up()
    {
        // Tabla para las alertas del chileatiende
        $this->createTable('alerta', array(
            'id' => array('type' => 'integer', 'primary'=>1, 'unsigned'=>1, 'autoincrement'=>1),
            'titulo' => array('type' => 'string', 'notnull' => 0, 'length'=>255),
            'descripcion' => array('type' => 'text', 'notnull' => 1),
            'tipo' => array('type' => 'string', 'notnull' => 0, 'length'=>16),
            'desde' => array('type' => 'datetime', 'notnull' => 0),
            'hasta' => array('type' => 'datetime', 'notnull' => 0),
            'publicado' => array('type'=>'boolean','notnull'=>1),
            'publicado_at' => array('type' => 'datetime', 'notnull' => 0),
            'created_at' => array('type' => 'datetime', 'notnull' => 0),
            'updated_at' => array('type' => 'datetime', 'notnull' => 0)
        ));

        $this->createTable('alerta_url', array(
            'id' => array('type' => 'integer', 'primary'=>1, 'unsigned'=>1, 'autoincrement'=>1),
            'url' => array('type' => 'string', 'notnull' => 0, 'length'=>512),
            'created_at' => array('type' => 'datetime', 'notnull' => 0),
            'updated_at' => array('type' => 'datetime', 'notnull' => 0)
        ));

        $this->createTable('alerta_has_url', array(
            'alerta_id' => array('type' => 'integer', 'unsigned'=>1),
            'alerta_url_id' => array('type' => 'integer', 'unsigned'=>1)
        ));

        $this->createForeignKey('alerta_has_url', 'fk_alerta_id',
            array('local' => 'alerta_id', 'foreign' => 'id', 'foreignTable' => 'alerta', 'onDelete' => 'CASCADE'));

        $this->createForeignKey('alerta_has_url', 'fk_alerta_url_id',
            array('local' => 'alerta_url_id', 'foreign' => 'id', 'foreignTable' => 'alerta_url', 'onDelete' => 'CASCADE'));
    }

    public function down(){
        $this->dropTable('alerta_has_url');
        $this->dropTable('alerta_url');
        $this->dropTable('alerta');
    }
}