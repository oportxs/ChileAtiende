<?php

class Alerta extends Doctrine_Record {

    public function setTableDefinition()
    {
        $date = new DateTime();

        $this->hasColumn('id');
        $this->hasColumn('titulo');
        $this->hasColumn('descripcion');
        $this->hasColumn('tipo');
        $this->hasColumn('desde', 'datetime', null, array('default' => $date->format('d-m-Y H:i')));
        $date->add(new DateInterval('PT30M'));
        $this->hasColumn('hasta', 'datetime', null, array('default' => $date->format('d-m-Y H:i')));
        $this->hasColumn('publicado', 'boolean', 1, array('default' => 0));
        $this->hasColumn('publicado_at');
    }

    public function setUp()
    {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('AlertaUrl as Urls', array(
            'local' => 'alerta_id',
            'foreign' => 'alerta_url_id',
            'refClass' => 'AlertaHasUrl'
        ));
    }

    public function setUrlsFromArray($urls){
        foreach ($this->Urls as $key => $u)
            unset($this->Urls[$key]);

        if ($urls) {
            foreach ($urls as $u) {
                $u = parse_url($u);

                if(substr($u['path'],0,1) == '/')
                    $u['path'] = substr($u['path'],1);

                $url = Doctrine::getTable('AlertaUrl')->findOneByUrl($u['path']);
                if (!$url) {
                    $url = new AlertaUrl();
                    $url->url = $u['path'];
                }
                $this->Urls[] = clone $url;
            }
        }
    }
}