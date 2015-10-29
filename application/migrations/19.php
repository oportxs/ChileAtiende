<?php
class Migration_EventoHasRegion extends Doctrine_Migration_Base {
    public function up(){
        $this->createTable('evento_has_region', array(
                'evento_id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1),
                'region_id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1)
            ));
    }
    public function down(){
        $this->dropTable('evento_has_region');
    }
}