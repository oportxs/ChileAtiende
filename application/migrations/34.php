<?php
class Migration_Updated_Data extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'ficha', 'updated_data_at', 'datetime' , null, array( 'notnull' => 0));
    }

    public function down()
    {
        $this->removeColumn( 'ficha', 'updated_data_at' );
    }
}