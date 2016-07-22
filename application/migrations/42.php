<?php
class Migration_addColumsTramiteExterior extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'tramite_en_exterior', 'content_updated_data_at', 'datetime' , null, array( 'notnull' => 0));
        $this->addColumn( 'tramite_en_exterior', 'motivo', 'varchar(255) NOT NULL');
    }

    public function down()
    {
        $this->removeColumn( 'tramite_en_exterior', 'content_updated_data_at' );
        $this->removeColumn( 'tramite_en_exterior', 'motivo' );
    }
}