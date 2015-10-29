<?php
class Migration_22 extends Doctrine_Migration_Base {
    public function up(){
        $this->addIndex( 'search_log', 'updated_at', array('fields'=>array('updated_at')) );
        $this->addIndex( 'search_log', 'session_id', array('fields'=>array('session_id')) );

    }
    public function down(){
        $this->removeIndex('search_log', 'updated_at');
        $this->removeIndex('search_log', 'session_id');
    }
}