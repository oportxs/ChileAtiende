<?php
class Migration_Add_Nombre_Oficina extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'ficha', 'guia_oficina_nombre', 'text' , null, array( 'notnull' => 0));
        $this->addColumn( 'sub_ficha', 'guia_oficina_nombre', 'text' , null, array( 'notnull' => 0));
    }

    public function down()
    {
        $this->removeColumn( 'ficha', 'guia_oficina_nombre' );
        $this->removeColumn( 'sub_ficha', 'guia_oficina_nombre' );
    }
}