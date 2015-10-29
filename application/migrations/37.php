<?php
class Migration_Content_Updated_Data extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'ficha', 'content_updated_data_at', 'datetime' , null, array( 'notnull' => 0));
    }

    public function down()
    {
        $this->removeColumn( 'ficha', 'content_updated_data_at' );
    }
}