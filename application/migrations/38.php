<?php
class Migration_Add_Oficina_Chile_Atiende_Subficha extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'sub_ficha', 'guia_chileatiende', 'text' , null, array( 'notnull' => 0));
    }

    public function down()
    {
        $this->removeColumn( 'sub_ficha', 'guia_chileatiende' );
    }
}