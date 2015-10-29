<?php

class CampanaModulo extends Doctrine_Record {
    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('titulo');
        $this->hasColumn('url');
        $this->hasColumn('estado');
    }
    
    function setUp() {
        parent::setUp();

        $this->actAs('Timestampable');

        $this->hasMany('Sector as Sectores', array(
            'local' => 'campana_modulo_id',
            'foreign' => 'sector_codigo',
            'refClass' => 'CampanaModuloHasSector'
        ));
    }

    function tieneSector($sectores) {

        if (!is_array($sectores)) {
            $sectores = array($sectores);
        }

        foreach ($this->Sectores as $s) {
            foreach ($sectores as $sector) {
                if ($s->codigo == $sector) {
                    return true;
                }
            }
        }

        return false;
    }


    function setSectoresFromArray($sectores) {

        foreach ($this->Sectores as $key => $s)
            unset($this->Sectores[$key]);

        if ($sectores)
            foreach ($sectores as $sector)
                $this->Sectores[] = Doctrine::getTable('Sector')->find($sector);
    }

    function validaModuloActivo($modulo_activo)
    {
        if(!count($this->Sectores))
            return true;
        foreach ($this->Sectores as $key => $sector) {
            if(substr($modulo_activo->sector_codigo, 0,strlen($sector->codigo)) == $sector->codigo)
                return true;
        }
        return false;
    }
    
}
