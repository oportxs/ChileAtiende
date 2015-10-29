<?php

class AlertaUrl extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->hasColumn('id');
        $this->hasColumn('url');
    }

    public function setUp()
    {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('Alerta as Alertas', array(
            'local' => 'alerta_url_id',
            'foreign' => 'alerta_id',
            'refClass' => 'AlertaHasUrl'
        ));

    }
} 