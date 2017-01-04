<?php
class Migration_AddMotivosEnExterior extends Doctrine_Migration_Base {
    public function up()
    {
        //Tabla para los servicios disponibles en exterior
        $columnas = array(
                'id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1, 'autoincrement' => 1, 'primary' => 1),
                'nombre' => array('type' => 'varchar', 'length' => 255, 'notnull' => 1)
            );
        $this->createTable('motivos_en_exterior', $columnas);
        
    }

    public function down(){ 
        $this->dropTable('motivos_en_exterior');
    }
}
?>