<?php
class Tag extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->hasColumn('id');
        $this->hasColumn('nombre');

    }

    public function setUp()
    {
        parent::setUp();
        
        $this->hasMany('Ficha as Fichas', array(
             'local' => 'tag_id',
             'foreign' => 'ficha_id',
             'refClass' => 'FichaHasTag'
        ));

        $this->hasMany('Servicio as Servicios', array(
             'local' => 'tag_id',
             'foreign' => 'servicio_codigo',
             'refClass' => 'ServicioHasTag'
        ));

    }

    public function  toString() {
        return $this->nombre;
    }

}