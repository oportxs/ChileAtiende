<?php
class Migration_25 extends Doctrine_Migration_Base {
    public function up(){
        $this->addColumn( 'oficina', 'movil', 'boolean' , null, array('default'=>0,'notnull'=>1));
    }
    public function down(){
        $this->removeColumn( 'oficina', 'movil' );
    }
}