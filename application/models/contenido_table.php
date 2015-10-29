<?php

class ContenidoTable extends Doctrine_Table {

    function findMaestros() {
        $query = Doctrine_Query::create();

        $query->from('Contenido c');
        $query->andWhere('c.maestro = 1');

        return $query->execute();
    }

}
