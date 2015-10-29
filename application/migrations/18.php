<?php
class Migration_Region_Evento extends Doctrine_Migration_Base {
    public function up(){
        $this->changeColumn( 'evento', 'region_id', 'int(11) DEFAULT NULL');
        $this->addColumn( 'evento', 'permanente', 'integer' , 1, array( 'notnull' => 1, 'default' => 0));
    }
    public function down(){
        $this->changeColumn( 'evento', 'region_id', 'int(11) NOT NULL');
        $this->removeColumn( 'evento', 'permanente' );
    }
}