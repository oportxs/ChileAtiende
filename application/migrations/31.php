<?php
class Migration_ServicioHasTag extends Doctrine_Migration_Base {
    public function up()
    {
        $this->createTable('servicio_has_tag', array(
            'servicio_codigo' => array('type' => 'varchar', 'length' => 8, 'notnull' => 1),
            'tag_id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1)
        ));

    }
    
    public function down(){
        $this->dropTable('servicio_has_tag');
    }
}
?>
