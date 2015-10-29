<?php
class Contenido extends Doctrine_Record {

    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('titulo');
        $this->hasColumn('url');
        $this->hasColumn('contenido');
        $this->hasColumn('plantilla');
        $this->hasColumn('maestro', 'boolean', 1, array('default' => 0));
        $this->hasColumn('maestro_id');
        $this->hasColumn('publicado', 'boolean', 1, array('default' => 0));
        $this->hasColumn('publicado_at');
    }


    function setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('Contenido as Versiones', array(
            'local' => 'id',
            'foreign' => 'maestro_id',
            'orderBy' => 'id desc'
        ));

        $this->hasOne('Contenido as Maestro', array(
            'local' => 'maestro_id',
            'foreign' => 'id'
        ));

        $this->hasMany('HistorialContenido as Historiales', array(
            'local' => 'id',
            'foreign' => 'contenido_id',
            'orderBy' => 'id desc'
        ));
    }

    public function generarVersion() {
        if ($this->maestro) {
            $nuevoContenido = parent::copy(false);

            $nuevoContenido->maestro = 0;
            $nuevoContenido->publicado = 0;
            $nuevoContenido->maestro_id = $this->id;
            $nuevoContenido->save();

            $this->logLastChange();
        }
    }

    //Grabo en el log lo que se hizo
    private function logLastChange() {
        $usuario = NULL;
        if (UsuarioBackendSesion::usuario())
            $usuario = UsuarioBackendSesion::usuario();

        $version_nueva = $this->getUltimaVersion();

        if ($this->Versiones->count() > 1) {

            $version_anterior = $this->Versiones[1];
            $comparacion = $version_nueva->compareWith($version_anterior);
            if ($comparacion) {
                $descripcion = make_description_contenido($comparacion, $version_nueva); //Helper historial
            } else {
                $descripcion = '<p>El Contenido ha sido guardado pero no se realizaron cambios.</p>';
            }
        } else {
            $descripcion = '<p>Se ha creado el Contenido</p>';
        }

        $log = new HistorialContenido();
        $log->Contenido = $this;
        $log->ContenidoVersion = $version_nueva;
        $log->UsuarioBackend = $usuario;
        $log->descripcion = $descripcion;
        $log->save();
    }

    /**
     * Obtiene la ultima version de este proyecto
     * La última versión se define como la versión con el ID más grande.
     *
     * @return Doctrine_Record
     */
    function getUltimaVersion() {
        if ($this->maestro)
            $versiones = $this->Versiones;
        else
            $versiones = $this->Maestro->Versiones;

        $version = NULL;

        if ($versiones)
            $version = $versiones[0];

        return $version;
    }

    /**
     * Compara el contenido con una version especificada
     *
     * @param Doctrine_Record $version_anterior contenido a comparar.
     *
     * @return string
     */
    public function compareWith(Contenido $version_anterior)
    {
        $comparacion = array();

        $left = $this->toArray(false);
        $right = $version_anterior->toArray(false);

        $exclude = array('id', 'maestro', 'maestro_id', 'publicado', 'publicado_at', 'updated_at', 'created_at');

        foreach ($left as $field => $value) {
            if(!in_array($field, $exclude)){
                if($right[$field] != $left[$field]){
                    $diff = trim(htmlDiff(strip_tags($right[$field]), strip_tags($left[$field])));
                    
                    $comparacion[$field]->left[] = $diff;
                    $comparacion[$field]->right[] = $right[$field];
                }
            }
        }

        return $comparacion;
    }

    /**
     * Publica la version del contenido
     *
     * @return void
     */
    public function publicar()
    {
        Doctrine_Manager::connection()->beginTransaction();

        //Marco el maestro como publicado
        if (!$this->publicado) {
            $this->publicado = 1;
            $this->publicado_at = date('Y-m-d H:i:s');
        }

        $this->save();

        //Primero despublico las versiones antiguas;
        $versiones = $this->Versiones;
        foreach ($versiones as $v) {
            $v->publicado = 0;
            $v->publicado_at = NULL;
            $v->save();
        }

        $version_a_publicar = $this->getUltimaVersion();
        $version_a_publicar->publicado = 1;
        $version_a_publicar->publicado_at = date('Y-m-d H:i:s');

        $version_a_publicar->save();

        //Se guarda el log de la publicación
        $log = new HistorialContenido();
        $log->descripcion = '<strong>Actualización de Estado de Publicación</strong><br />Versión publicada';
        $log->Contenido = $this;
        $log->ContenidoVersion = $version_a_publicar;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

    /**
     * Despublica la version del contenido
     *
     * @return void
     */
    public function despublicar()
    {
        Doctrine_Manager::connection()->beginTransaction();

        //Marco el maestro como publicado
        $this->publicado = 0;
        $this->publicado_at = NULL;

        $this->save();

        //Despublico las versiones;
        $versiones = $this->Versiones;
        foreach ($versiones as $v) {
            if ($v->publicado == 1) {
                $v->publicado = 0;
                //$v->publicado_at = NULL; //Se comenta esto, debido a que es útil saber cuando fué publicada una versión
                $v->save();
                $version_a_despublicar = $v;
            }
        }

        //Se guarda el log de la despublicación
        $log = new HistorialContenido();
        $log->descripcion = '<strong>Actualización de Estado de Publicación</strong><br />Versión despublicada';
        $log->Contenido = $this;
        $log->ContenidoVersion = $version_a_despublicar;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }
}
?>