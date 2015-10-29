<?php
class Migration_SearchVersion extends Doctrine_Migration_Base{
    public function up(){
        $this->addColumn('search_log', 'version','integer', null,array('unsigned'=>1,'notnull'=>1,'default'=>1));
    }

    
    public function down(){
        $this->removeColumn('search_log', 'version');
    }
}