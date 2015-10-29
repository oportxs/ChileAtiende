<?php
class Evento extends Doctrine_Record 
{

    function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('postulacion_start');
        $this->hasColumn('postulacion_end');
        $this->hasColumn('publicado', 'boolean', 1, array('default' => 0));
        $this->hasColumn('publicado_at');
        $this->hasColumn('informacion');
        $this->hasColumn('permanente');
        $this->hasColumn('estado');
        $this->hasColumn('maestro', 'boolean', 1, array('default' => 0));
        $this->hasColumn('maestro_id');
        $this->hasColumn('created_at');
        $this->hasColumn('updated_at');
        $this->hasColumn('titulo');
        $this->hasColumn('url');
        $this->hasColumn('servicio_codigo');
        $this->hasColumn('tipo');
        $this->hasColumn('estado_justificacion');
        $this->hasColumn('destacado', 'boolean', 1, array('default' => 0));
    }

    function setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('Evento as Versiones', array(
            'local' => 'id',
            'foreign' => 'maestro_id',
            'orderBy' => 'id desc'
        ));

        $this->hasOne('Evento as Maestro', array(
            'local' => 'maestro_id',
            'foreign' => 'id'
        ));

        $this->hasMany('HistorialEvento as Historiales', array(
            'local' => 'id',
            'foreign' => 'evento_id',
            'orderBy' => 'id desc'
        ));

        $this->hasMany('Region as Regiones', array(
            'local' => 'evento_id',
            'foreign' => 'region_id',
            'refClass' => 'EventoHasRegion'
        ));

        $this->hasOne('Servicio as Servicio', array(
            'local' => 'servicio_codigo',
            'foreign' => 'codigo'
        ));
    }

    function setRegionesFromArray($aRegiones) {

        foreach ($this->Regiones as $key => $c)
            unset($this->Regiones[$key]);

        if ($aRegiones)
            foreach ($aRegiones as $r)
                $this->Regiones[] = Doctrine::getTable('Region')->find($r);
    }

    public function generarVersion() {
        if ($this->maestro) {
            $nuevoEvento = $this->copy(true);
            $nuevoEvento->maestro = 0;
            $nuevoEvento->maestro_id = $this->id;
            $nuevoEvento->save();

            // INFO: se despublican todas las versiones anteriores y se copia el estado
            //       del maestro al nuevo evento
            $versiones = $this->Versiones;
            foreach ($versiones as $v) {
                $v->publicado = 0;
                $v->publicado_at = NULL;
                $v->save();
            }
            $nuevoEvento->publicado = $this->publicado;
            $nuevoEvento->publicado_at = $this->publicado_at;
            $nuevoEvento->save();

            $this->logLastChange();
        }
    }

    public function copy($deep = false) {
        $copia = parent::copy(false);
        if($deep) {
            foreach($this->Regiones as $r)
                $copia->Regiones[] = $r;
        }
        $copia->created_at = NULL;
        $copia->updated_at = NULL;
        return $copia;
    }

    private function logLastChange() {
        $usuario = NULL;
        if (UsuarioBackendSesion::usuario())
            $usuario = UsuarioBackendSesion::usuario();

        $version_nueva = $this->getUltimaVersion();

        if ($this->Versiones->count() > 1) {

            $version_anterior = $this->Versiones[1];
            $comparacion = $version_nueva->compareWith($version_anterior);
            if ($comparacion) {
                $descripcion = make_description_evento($comparacion, $version_nueva); //Helper historial
            } else {
                $descripcion = '<p>El Evento ha sido guardado pero no se realizaron cambios.</p>';
            }
        } else {
            $descripcion = '<p>Se ha creado el Evento</p>';
        }

        $log = new HistorialEvento();
        $log->Evento = $this;
        $log->EventoVersion = $version_nueva;
        $log->UsuarioBackend = $usuario;
        $log->descripcion = $descripcion;
        $log->save();
    }

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

    public function compareWith(Evento $version_anterior)
    {
        $comparacion = array();

        $left = $this->toArray(false);
        $right = $version_anterior->toArray(false);

        $exclude = array('id', 'created_at', 'updated_at', 'publicado_at', 'maestro', 'maestro_id');
        
        foreach ($left as $field => $value) {
            if(!in_array($field, $exclude)){
                if($right[$field] != $left[$field]){
                    $diff = trim(htmlDiff(strip_tags($right[$field]), strip_tags($left[$field])));
                    
                    $comparacion[$field]->left[] = $diff;
                    $comparacion[$field]->right[] = $right[$field];
                }
            }
        }

        // INFO: comparacion de Regiones (relacion many)
        $left = $this->get('Regiones');
        $right = $version_anterior->get('Regiones');
        $left_nom = $right_nom = array();

        foreach($left as $lnom)
            $left_nom[] = $lnom->nombre;
        foreach($right as $rnom)
            $right_nom[] = $rnom->nombre;
        $_a = array_diff($left_nom, $right_nom);
        $_b = array_diff($right_nom, $left_nom);
        if(!empty($_a) || !empty($_b))
        {
            $left_label = implode(" ", $left_nom);
            $right_label = implode(" ", $right_nom);
            $diff = trim(htmlDiff($right_label, $left_label));
            if ($diff) {
                $comparacion['Regiones']->left[0] = $diff;
                $comparacion['Regiones']->right[0] = $right_label;
            }
        }

        return $comparacion;
    }

    public function publicar()
    {
        Doctrine_Manager::connection()->beginTransaction();

        if (!$this->publicado) {
            $this->publicado = 1;
            $this->publicado_at = date('Y-m-d H:i:s');
            $this->estado = "publicado";
            $this->save();
        }

        $versiones = $this->Versiones;
        foreach ($versiones as $v) {
            $v->publicado = 0;
            $v->publicado_at = NULL;
            $v->save();
        }

        $version_a_publicar = $this->getUltimaVersion();
        $version_a_publicar->publicado = 1;
        $version_a_publicar->publicado_at = date('Y-m-d H:i:s');
        $version_a_publicar->estado = "publicado";

        $version_a_publicar->save();

        $log = new HistorialEvento();
        $log->descripcion = '<strong>Actualización de Estado de Publicación</strong><br />Versión publicada';
        $log->Evento = $this;
        $log->EventoVersion = $version_a_publicar;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

    public function despublicar()
    {
        Doctrine_Manager::connection()->beginTransaction();

        $this->publicado = 0;
        $this->publicado_at = NULL;
        $this->estado = NULL;
        $this->save();

        $versiones = $this->Versiones;
        foreach ($versiones as $v) {
            if ($v->publicado == 1) {
                $v->publicado = 0;
                //$v->publicado_at = NULL; //Se comenta esto, debido a que es útil saber cuando fué publicada una versión
                $v->estado = NULL;
                $v->save();
                $version_a_despublicar = $v;
            }
        }

        $log = new HistorialEvento();
        $log->descripcion = '<strong>Actualización de Estado de Publicación</strong><br />Versión despublicada';
        $log->Evento = $this;
        $log->EventoVersion = $version_a_despublicar;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

    public function aprobar()
    {
        Doctrine_Manager::connection()->beginTransaction();

        $this->estado = 'en_revision';
        $this->save();

        $ultimaversion = $this->getUltimaVersion();
        $ultimaversion->estado = 'en_revision';
        $ultimaversion->save();

        $log = new HistorialEvento();
        $log->descripcion = '<strong>Actualización de Estado</strong><br />Versión aprobada y enviada a revisión.';
        $log->Evento = $this;
        $log->EventoVersion = $ultimaversion;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

    public function rechazar()
    {
        Doctrine_Manager::connection()->beginTransaction();

        $this->estado = 'rechazado';
        $this->save();

        $ultimaversion = $this->getUltimaVersion();
        $ultimaversion->estado = 'rechazado';
        $ultimaversion->estado_justificacion = $this->estado_justificacion;
        $ultimaversion->save();

        $log = new HistorialEvento();
        $log->descripcion = '<strong>Actualización de Estado</strong><br />Versión rechazada.<br />Motivo: ' . $this->estado_justificacion;
        $log->Evento = $this;
        $log->EventoVersion = $ultimaversion;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }
}