<?php

class AlertaTable extends Doctrine_Table {

    public function findWithOptions($options = array()){
        $query = Doctrine_Query::create();
        $query->from('Alerta a');

        $query->limit($options['limit']);
        $query->offset($options['offset']);

        if(isset($options['count']) && $options['count'])
            $result = $query->count();
        else
            $result = $query->execute();

        return $result;
    }

    public function findAlertsForUrl($url){
        $url = parse_url($url);

        if(substr($url['path'],0,1) == '/')
            $url['path'] = substr($url['path'],1);

        if($url['path'] == '')
            $url['path'] = 'portada';

        $query = Doctrine_Query::create();
        $query->from('Alerta a, a.Urls au');

        $query->andWhere('au.url = :url', array('url' => $url['path']));
        $query->andWhere('a.publicado = 1');
        $query->andWhere('NOW() BETWEEN a.desde AND a.hasta');

        $result = $query->execute();

        return $result;
    }
}