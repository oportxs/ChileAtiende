<?php
class Migration_SearchPatrocinado3 extends Doctrine_Migration_Base{
    public function up(){
        $this->changeColumn('search_promocionado', 'query','text',null);
    }

    
    public function down(){
        $this->changeColumn('search_promocionado', 'query','string',255);
    }
}