<?php
class Migration_SearchPatrocinado extends Doctrine_Migration_Base{
    public function up(){
        $this->createTable('search_promocionado', array(
            'id'=>array('type'=>'integer','primary'=>1,'unsigned'=>1,'autoincrement'=>1),
            'titulo'=>array('type'=>'string','length'=>255,'notnull'=>1),
            'introtext'=>array('type'=>'text','notnull'=>1),
            'url'=>array('type'=>'string','length'=>255,'notnull'=>1),
            'query'=>array('type'=>'string','length'=>255,'notnull'=>1),
            'regex'=>array('type'=>'boolean','notnull'=>1)
        ));
    }

    
    public function down(){
        $this->dropTable('search_promocionado');
    }
}