<?php
class Migration_Add_Oficina_Chile_Atiende extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'ficha', 'guia_chileatiende', 'text' , null, array( 'notnull' => 0));
    }

    public function down()
    {
        $this->removeColumn( 'ficha', 'guia_chileatiende' );
    }
}