<?php
class Migration_Participaciones extends Doctrine_Migration_Base {
    public function up()
    {
        // Tabla para las opiniones sobre la información de la ficha
        $this->createTable('participacion_opinion', array(
                'id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1, 'autoincrement' => 1, 'primary' => 1),
                'ficha_id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 0),
                'informacion_util' => array('type' => 'boolean', ''),
                'informacion_facil_de_encontrar'  => array('type' => 'boolean', ''),
                'que_podemos_mejorar' => array('type' => 'string', 'notnull' => 0),
                'created_at' => array('type' => 'datetime', 'notnull' => 1),
                'updated_at' => array('type' => 'datetime', 'notnull' => 1)
            ));
        $this->createForeignKey('participacion_opinion', 'participacion_opinion_ficha_fk1', array('local' => 'ficha_id', 'foreign' => 'id', 'foreignTable' => 'ficha', 'onDelete' => 'CASCADE'));

        // Tabla para los errores en los trámites
        $this->createTable('participacion_errores', array(
                'id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1, 'autoincrement' => 1, 'primary' => 1),
                'ficha_id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 0),
                'descripcion' => array('type' => 'string', 'notnull' => 0),
                'created_at' => array('type' => 'datetime', 'notnull' => 1),
                'updated_at' => array('type' => 'datetime', 'notnull' => 1)
            ));
        $this->createForeignKey('participacion_errores', 'participacion_errores_ficha_fk1', array('local' => 'ficha_id', 'foreign' => 'id', 'foreignTable' => 'ficha', 'onDelete' => 'CASCADE'));
    }
    
    public function down(){
        $this->dropTable('participacion_opinion');
        $this->dropTable('participacion_errores');
    }
}
?>


