<?php
class Migration_Nombre_Sectores extends Doctrine_Migration_Base {
    public function up(){
        $this->changeColumn( 'sector', 'nombre', 'varchar(255) NOT NULL');
    }
    public function down(){
        $this->changeColumn( 'sector', 'nombre', 'varchar(45) NOT NULL');
    }
}