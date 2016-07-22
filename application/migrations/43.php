<?php
class Migration_Ficha_43 extends Doctrine_Migration_Base {
    public function up(){
        $this->addColumn( 'ficha', 'guia_consulado', 'text');
    }
    public function down(){
        $this->removeColumn( 'ficha', 'guia_consulado');
    }
}