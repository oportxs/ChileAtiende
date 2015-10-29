<?php

class HechoEmpresa extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
        $this->hasColumn('descripcion');
    }

    function setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('Ficha as Fichas', array(
            'local' => 'hecho_empresa_id',
            'foreign' => 'ficha_id',
            'refClass' => 'FichaHasHechoEmpresa'
        ));

        $this->hasMany('EtapaEmpresa as EtapasEmpresa', array(
            'local' => 'hecho_empresa_id',
            'foreign' => 'etapa_empresa_id',
            'refClass' => 'EtapaEmpresaHasHechoEmpresa'
        ));

    }

    function hasEtapaEmpresa($etapa_empresa_id) {
        foreach ($this->EtapasEmpresa as $etapa_empresa) {
            if ($etapa_empresa_id == $etapa_empresa->id)
                return TRUE;
        }
        return FALSE;
    }

    public function toString() {
        return $this->nombre;
    }

    function setEtapasEmpresaFromArray($etapas) {

        foreach ($this->EtapasEmpresa as $key => $c)
            unset($this->EtapasEmpresa[$key]);

        if ($etapas)
            foreach ($etapas as $etapa)
                $this->EtapasEmpresa[] = Doctrine::getTable('EtapaEmpresa')->find($etapa);
    }

}

?>
