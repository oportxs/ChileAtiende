<?php
class Migration_Add_Flag_Temas extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'tema', 'destacado', 'boolean');
    }

    public function down()
    {
        $this->removeColumn( 'tema', 'destacado' );
    }
}