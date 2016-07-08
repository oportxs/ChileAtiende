<?php
class Migration_TramiteEnExterior extends Doctrine_Migration_Base {
    public function up()
    {
        //Tabla para los servicios disponibles en exterior
        $columnas = array(
                'id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1, 'autoincrement' => 1, 'primary' => 1),
                'id_ficha' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 0),
                'destacado' => array('type' => 'boolean')
            );
        
        $this->createTable('tramite_en_exterior', $columnas);

        $this->createForeignKey('tramite_en_exterior', 'tramite_en_exterior_ficha_fk1', array('local' => 'id_ficha', 'foreign' => 'id', 'foreignTable' => 'ficha', 'onDelete' => 'SET NULL'));

    }

    public function down(){
        $this->dropTable('tramite_en_exterior');
    }
}
?>
