<?php
class Migration_TramiteEnConvenio extends Doctrine_Migration_Base {
    public function up()
    {
        //Tabla para los servicios disponibles en las oficinas
        $this->createTable('tramite_en_convenio', array(
                'id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1, 'autoincrement' => 1, 'primary' => 1),
                'titulo' => array('type' => 'varchar', 'length' => 255, 'notnull' => 1),
                'url_imagen' => array('type' => 'varchar', 'length' => 255, 'notnull' => 0),
                'url_tramite' => array('type' => 'varchar', 'length' => 255, 'notnull' => 0),
                'ficha_id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 0),
                'global' => array('type' => 'boolean')
            ));
        $this->createForeignKey('tramite_en_convenio', 'tramite_en_convenio_ficha_fk1', array('local' => 'ficha_id', 'foreign' => 'id', 'foreignTable' => 'ficha', 'onDelete' => 'SET NULL'));

        //Tabla para la relación entre los tramites y las oficinas
        $this->createTable('oficina_has_tramite_en_convenio', array(
                'oficina_id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1),
                'tramite_en_convenio_id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1)
            ));
        $this->createForeignKey('oficina_has_tramite_en_convenio', 'oficina_has_tramite_en_convenio_fk1', array('local' => 'oficina_id', 'foreign' => 'id', 'foreignTable' => 'oficina', 'onDelete' => 'CASCADE'));
        $this->createForeignKey('oficina_has_tramite_en_convenio', 'oficina_has_tramite_en_convenio_fk2', array('local' => 'tramite_en_convenio_id', 'foreign' => 'id', 'foreignTable' => 'tramite_en_convenio', 'onDelete' => 'CASCADE'));
    }
    
    public function down(){
        $this->dropTable('oficina_has_tramite_en_convenio');
        $this->dropTable('tramite_en_convenio');
    }
}
?>


