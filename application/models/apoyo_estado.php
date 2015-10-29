<?php
class ApoyoEstado extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
        $this->hasColumn('order_by');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('Ficha as Fichas', array(
            'local' => 'apoyo_estado_id',
            'foreign' => 'ficha_id',
            'refClass' => 'FichaHasApoyoEstado'
        ));

        $this->hasMany('EtapaEmpresa as EtapasEmpresa', array(
            'local' => 'apoyo_estado_id',
            'foreign' => 'etapa_empresa_id',
            'refClass' => 'EtapaEmpresaHasApoyoEstado'
        ));
    }

    function hasEtapaEmpresa($etapa_id) {
        foreach ($this->EtapasEmpresa as $etapa) {
            if ($etapa_id == $etapa->id)
                return TRUE;
        }
        return FALSE;
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
