<?php
class Migration_AddMotivosEnExterior2 extends Doctrine_Migration_Base {
    public function up()
    {
        // añade valores a la tabla motivos_en_exterior
        $conn = Doctrine_Manager::getInstance()->connection();
        $query = "INSERT INTO motivos_en_exterior (nombre) VALUES ('Residencia Permanente en el Exterior');";
        $query.= "INSERT INTO motivos_en_exterior (nombre) VALUES ('Residencia Temporal en el Exterior ');";
        $query.= "INSERT INTO motivos_en_exterior (nombre) VALUES ('De Viaje en el Exterior');";
        $results = $conn->execute($query);

        // crea la clave foranea en tabla tramite_en_exterior
        $this->addColumn('tramite_en_exterior', 'motivo_id', 'integer', 1, array( 'length' => 4, 'unsigned' => 1, 'notnull' => 1, 'default' => 1));
        $this->createForeignKey('tramite_en_exterior', 'tramite_en_exterior_fk1', array('local' => 'motivo_id', 'foreign' => 'id', 'foreignTable' => 'motivos_en_exterior', 'onDelete' => 'NO ACTION'));
       
    }

    public function down(){
        $this->dropForeignKey('tramite_en_exterior', 'tramite_en_exterior_fk1');
        $this->removeColumn('tramite_en_exterior', 'motivo_id');   
    }
}