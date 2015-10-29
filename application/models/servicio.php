<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Servicio extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('codigo', 'string', 8, array (
            'primary' => true,
            'autoincrement' => false
        ));
        $this->hasColumn('nombre');
        $this->hasColumn('sigla');
        $this->hasColumn('url');
        $this->hasColumn('responsable');
        $this->hasColumn('entidad_codigo');
        $this->hasColumn('mision');
        $this->hasColumn('updated_at');
        $this->hasColumn('sector_codigo');
    }

    function  setUp() {
        parent::setUp();
        $this->hasMany('Ficha as Fichas', array(
            'local' => 'codigo',
            'foreign' => 'servicio_codigo'
        ));

        $this->hasMany('SubFicha as SubFichas', array(
            'local' => 'codigo',
            'foreign' => 'servicio_codigo'
        ));

        $this->hasMany('Evento as Eventos', array(
            'local' => 'codigo',
            'foreign' => 'servicio_codigo'
        ));

        $this->hasOne('Entidad', array(
            'local' => 'entidad_codigo',
            'foreign' => 'codigo'
        ));

        $this->hasMany('Oficina as Oficinas', array(
            'local' => 'codigo',
            'foreign' => 'servicio_codigo'
        ));
        
        $this->hasMany('ModuloAtencion as Modulos', array(
            'local' => 'codigo',
            'foreign' => 'servicio_codigo'
        ));
        
        $this->hasMany('UsuarioBackend as UsuariosBackend', array(
            'local' => 'servicio_codigo',
            'foreign' => 'usuario_backend_id',
            'refClass' => 'UsuarioBackendHasServicio'
        ));

        $this->hasOne('Sector', array(
            'local' => 'sector_codigo',
            'foreign' => 'codigo'
        ));

        $this->hasMany('Tag as Tags', array(
            'local' => 'servicio_codigo',
            'foreign' => 'tag_id',
            'refClass' => 'ServicioHasTag'
        ));
    }

    //Retorna la ficha convertida en array, solamente con los campos visibles al publico a traves de la API.
    public function toPublicArray(){

        $publicArray=array(
            'id'=>$this->codigo,
            'sigla'=>$this->sigla,
            'nombre'=>$this->nombre,
            'url'=>$this->url,
            'mision'=>$this->mision,
        );

        return $publicArray;
    }

    function setTagsFromArray($tags) {
        foreach ($this->Tags as $key => $c)
            unset($this->Tags[$key]);

        if ($tags) {
            foreach ($tags as $t) {
                $tag_db = Doctrine::getTable('Tag')->findOneByNombre($t);
                if (!$tag_db) {
                    $tag_db = new Tag();
                    $tag_db->nombre = $t;
                }
                $this->Tags[] = clone $tag_db;
            }
        }
    }
}
?>
