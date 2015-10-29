<?php
class Migration_Add_Resumen extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'ficha', 'resumen', 'text' , null, array( 'notnull' => 0));
    }

    public function down()
    {
        $this->removeColumn( 'ficha', 'resumen' );
    }
}