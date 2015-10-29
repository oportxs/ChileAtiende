<?php
class Migration_Evento_Estado extends Doctrine_Migration_Base {
    public function up(){
    	$this->addColumn( 'evento', 'estado', 'string' , 32, array( 'notnull' => 1, 'default' => 'ok' ));
    }
    public function down(){
        $this->removeColumn( 'evento', 'estado' );
    }
}