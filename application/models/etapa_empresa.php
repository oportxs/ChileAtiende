<?php

class EtapaEmpresa extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('orden');
        $this->hasColumn('nombre');
        $this->hasColumn('descripcion');
    }

    function setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('HechoEmpresa as HechosEmpresa', array(
            'local' => 'etapa_empresa_id',
            'foreign' => 'hecho_empresa_id',
            'refClass' => 'EtapaEmpresaHasHechoEmpresa'
        ));

        $this->hasMany('ApoyoEstado as ApoyosEstado', array(
            'local' => 'etapa_empresa_id',
            'foreign' => 'apoyo_estado_id',
            'refClass' => 'EtapaEmpresaHasApoyoEstado'
        ));
    }

}

?>
