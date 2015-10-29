<?php
class Migration_SearchParametros extends Doctrine_Migration_Base{
    public function up(){
        $this->addColumn('search_log', 'parametros','string', 255,array('notnull'=>1,'default'=>''));
    }

    
    public function down(){
        $this->removeColumn('search_log', 'parametros');
    }
}