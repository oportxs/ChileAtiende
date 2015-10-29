<?php
class Migration_23 extends Doctrine_Migration_Base {
    public function up(){
        $this->addColumn( 'search_log', 'referrer', 'string' , 255, array( 'notnull' => 1));
    }
    public function down(){
        $this->removeColumn( 'search_log', 'referrer' );
    }
}