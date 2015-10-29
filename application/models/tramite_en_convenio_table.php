<?php
class TramiteEnConvenioTable extends Doctrine_Table{

    function countTotal(){
        return Doctrine_Query::create()
                ->from('TramiteEnConvenio t, Ficha f')
                ->where('f.id = t.ficha_id')
                ->andWhere('f.publicado = 1')
                ->andWhere('f.maestro = 1')
                ->count();
    }

}

?>
