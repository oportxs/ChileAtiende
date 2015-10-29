<?php
class Migration_SearchPatrocinado2 extends Doctrine_Migration_Base{
    public function up(){
        $this->addColumn('search_promocionado', 'orden','integer', null,array('unsigned'=>1,'notnull'=>1));
        $this->addColumn('search_promocionado', 'activo','boolean' ,null,array('default'=>1,'notnull'=>1));
    }

    
    public function down(){
        $this->removeColumn('search_promocionado', 'activo');
        $this->removeColumn('search_promocionado', 'orden');
    }
}