<?php
class Migration_Ficha_47 extends Doctrine_Migration_Base {
    public function up(){
        $this->addColumn( 'ficha', 'es_tramite_mujer', 'boolean');
        $this->addColumn( 'ficha', 'es_tramite_mujer_destacado', 'boolean');
    }
    public function down(){
        $this->removeColumn( 'ficha', 'es_tramite_mujer');
        $this->removeColumn( 'ficha', 'es_tramite_mujer_destacado');
    }
}