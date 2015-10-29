<?php
class Migration_FPS_Fichas_ApoyoEstado extends Doctrine_Migration_Base
{
    public function up()
    {

        $query = Doctrine_Query::create();
        $query->from('Ficha f');
        $query->innerJoin('f.ApoyosEstado fae');
        $query->andWhere('f.maestro = 0');
        $query->andWhere('f.publicado = 1');
        $query->andWhere('f.puntaje_fps_min is null');
        $query->andWhere('f.puntaje_fps_max is null');
        $query->groupBy('f.id');

        $fichas_modificables = $query->execute();
        foreach($fichas_modificables as $ficha)
        {
            $ficha->puntaje_fps_min = 2000;
            $ficha->puntaje_fps_max = 20000;
            $ficha->save();
        }
    }
    
    public function postUp()
    {
    }

    public function down()
    {
    }
}