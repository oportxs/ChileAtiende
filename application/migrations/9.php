<?php
class Migration_Tipo_Oficinas extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'oficina', 'tipo', 'string' , 32, array( 'notnull' => 1, 'default' => 'personas' ));
    }
    
    public function down()
    {
        $this->removeColumn( 'oficina', 'tipo' );
    }
}
