<?php
class Migration_MetaFicha2 extends Doctrine_Migration_Base {
    public function up()
    {
        $this->removeColumn( 'ficha', 'metaficha_categoria' );
        
        $conn = Doctrine_Manager::getInstance()->connection();
        $query = 'ALTER TABLE ficha ADD metaficha_opciones text';
        $results = $conn->execute($query);
    }
    
    public function down(){
        $this->removeColumn( 'ficha', 'metaficha_opciones' );
        
        $conn = Doctrine_Manager::getInstance()->connection();
        $query = 'ALTER TABLE ficha ADD metaficha_categoria varchar(16)';
        $results = $conn->execute($query);
    }
}
?>
