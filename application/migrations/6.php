<?php
class Migration_Remplazo_Campos_Ficha_V2 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn( 'ficha', 'detalles' );
        $this->addColumn( 'ficha', 'informacion_multimedia', 'string' , null, array( 'notnull' => 0 ));
    }

    public function down()
    {
        $this->addColumn( 'ficha', 'detalles', 'string' , null, array( 'notnull' => 0 ));
        $this->removeColumn( 'ficha', 'informacion_multimedia' );
    }
}
