<?php
class Migration_EncuestaChileatiende extends Doctrine_Migration_Base {
    public function up(){
        $this->createTable('encuesta', array(
            'id' => array('type' => 'integer', 'primary'=>1, 'unsigned'=>1, 'autoincrement'=>1),
            'nombre' => array('type' => 'string', 'notnull' => 0, 'length'=>255),
            'created_at' => array('type' => 'datetime', 'notnull' => 0),
            'updated_at' => array('type' => 'datetime', 'notnull' => 0)
        ));

        $this->createTable('encuesta_resultado', array(
            'id' => array('type' => 'integer', 'primary'=>1, 'unsigned'=>1, 'autoincrement'=>1),
            'encuesta_id' => array('type' => 'integer', 'unsigned'=>1),
            'ficha_maestro_id' => array('type' => 'integer', 'unsigned'=>1),
            'ficha_publicada_id' => array('type' => 'integer', 'unsigned'=>1),
            'resultado' => array('type' => 'string', 'notnull' => 0, 'length'=>255),
            'created_at' => array('type' => 'datetime', 'notnull' => 0),
            'updated_at' => array('type' => 'datetime', 'notnull' => 0)
        ));

        $this->createForeignKey('encuesta_resultado', 'fk_encuesta_resultado_encuesta',
            array('local' => 'encuesta_id', 'foreign' => 'id', 'foreignTable' => 'encuesta', 'onDelete' => 'CASCADE'));

        $this->createForeignKey('encuesta_resultado', 'fk_encuesta_resultado_ficha_maestro',
            array('local' => 'ficha_maestro_id', 'foreign' => 'id', 'foreignTable' => 'ficha', 'onDelete' => 'CASCADE'));

        $this->createForeignKey('encuesta_resultado', 'fk_encuesta_resultado_ficha_publicada',
            array('local' => 'ficha_publicada_id', 'foreign' => 'id', 'foreignTable' => 'ficha', 'onDelete' => 'CASCADE'));

    }

    public function postUp()
    {
        //Se crea la primera encuesta para el sitio
        $conn = Doctrine_Manager::getInstance()->connection();
        $query = 'INSERT INTO encuesta(id,nombre, created_at, updated_at) values(1,"Visita Oficina",now(), now())';
        $conn->execute($query);
    }


    public function down(){
        $this->dropTable('encuesta');
        $this->dropTable('encuesta_resultado');
    }
} 