<?php
class Migration_Ficha_44 extends Doctrine_Migration_Base {
    public function up(){
        $this->addColumn( 'ficha', 'es_tramite_exterior', 'boolean');
    }
    public function down(){
        $this->removeColumn( 'ficha', 'es_tramite_exterior');
    }
}
