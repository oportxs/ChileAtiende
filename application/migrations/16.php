<?php
class Migration_Info_Evento extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'evento', 'informacion', 'string' , 150, array( 'notnull' => 0 ));
    }
    
    public function down()
    {
        $this->removeColumn( 'evento', 'informacion' );
    }
}
