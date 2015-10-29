<?php

class Migration_NuevoEvento extends Doctrine_Migration_Base {
    public function up() {

        // 1-. Eliminar Rol "Calendario", "Calendario-Publicador",  "Calendario-Editor" ??
        // Doctrine::getTable('Rol')->findByNombre('Calendario')->delete();
        // Doctrine::getTable('Rol')->findByNombre('Calendario-Editor')->delete();
        // Doctrine::getTable('Rol')->findByNombre('Calendario-Publicador')->delete();

        // 2-. Eliminar relacion con Ficha:
        $this->dropTable('ficha_has_evento');
        
        // 3-.
        $this->changeColumn( 'evento', 'informacion', 'string', 500 );
        $this->changeColumn( 'evento', 'estado', 'string', 32, array( 'notnull' => 0 , 'default' => null) );
        $this->addColumn( 'evento', 'titulo', 'string' , 255, array( 'notnull' => 1) );
        $this->addColumn( 'evento', 'url', 'string' , 255, array( 'notnull' => 1));
        $this->addColumn( 'evento', 'servicio_codigo', 'string' , 8, array( 'notnull' => 1));
        $this->addColumn( 'evento', 'estado_justificacion', 'text', null, array( 'notnull' => 0 ));
        $this->addColumn( 'evento', 'tipo', 'int', 1, array( 'notnull' => 1 ));
        $this->addColumn( 'evento', 'destacado', 'integer' , 1, array( 'notnull' => 1, 'default' => 0));
    }

    public function postUp() {
        $query = Doctrine_Query::create();
        $query->from('Evento evento');
            // ->andWhere('evento.maestro = 1');
        $eventos = $query->execute();

        foreach($eventos as $evento){
            $evento->publicado = 0;
            $evento->estado = NULL;
            $evento->titulo = "Evento sin titulo, url ni institucion asociada";
            $evento->url = "http://www.chileatiende.cl";
            $evento->servicio_codigo = "ZZ001";
            $evento->save();
            // $evento->generarVersion();
        }
    }

    public function down() {
        $this->removeColumn( 'evento', 'destacado' );
        $this->removeColumn( 'evento', 'tipo' );
        $this->removeColumn( 'evento', 'estado_justificacion' );
        $this->removeColumn( 'evento', 'servicio_codigo' );
        $this->removeColumn( 'evento', 'url' );
        $this->removeColumn( 'evento', 'titulo' );
        $this->changeColumn( 'evento', 'informacion', 'string', 150 );
        $this->createTable('ficha_has_evento', array(
                'ficha_id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1),
                'evento_id' => array('type' => 'integer', 'length' => 4, 'unsigned' => 1, 'notnull' => 1)
        ));
    }
} 

?>