<?php
class Migration_21 extends Doctrine_Migration_Base {
    public function up(){
    	$this->addColumn( 'search_log', 'session_id', 'string' , 40, array( 'notnull' => 1));
    }
    public function down(){
        $this->removeColumn( 'search_log', 'session_id' );
    }
}