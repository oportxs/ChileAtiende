<?php
class Migration_Medios_Pago_Ficha extends Doctrine_Migration_Base {
    public function up()
    {
        //Tabla los medios de pagos
        $this->createTable('medio_pago', array(
                'id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1, 'autoincrement' => 1, 'primary' => 1),
                'nombre' => array('type' => 'varchar', 'length' => 255, 'notnull' => 1),
                'url_icono' => array('type' => 'varchar', 'length' => 255, 'notnull' => 0)
            ));

        $this->addColumn( 'ficha', 'medio_pago_id', 'integer', 4, array( 'unsigned' => 1, 'notnull' => 0 ));    
        $this->createForeignKey('ficha', 'medio_pago_ficha_fk1', array('local' => 'medio_pago_id', 'foreign' => 'id', 'foreignTable' => 'medio_pago', 'onDelete' => 'SET NULL'));
    }

    public function down()
    {
        $this->dropTable('medio_pago');
        $this->removeColumn( 'ficha', 'medio_pago_id' );
    }
}