<?php
class SubFicha extends Doctrine_Record 
{

    function setTableDefinition() {
        // INFO: campos del formulario
        $this->hasColumn('cc_observaciones');
        $this->hasColumn('beneficiarios');
        $this->hasColumn('doc_requeridos');
        $this->hasColumn('guia_online');
        $this->hasColumn('guia_online_url');
        $this->hasColumn('guia_oficina');
        $this->hasColumn('guia_telefonico');
        $this->hasColumn('guia_correo');
        $this->hasColumn('guia_chileatiende');
        $this->hasColumn('plazo');
        $this->hasColumn('vigencia');
        $this->hasColumn('costo');
        $this->hasColumn('informacion_multimedia');
        $this->hasColumn('marco_legal');
        // TODO: faltan los siguientes campos (tambien en Ficha??)
        //  Lugar de recepción de documentos
        //  Teléfono
        //  Horario de Atención
        //  E- mail de contacto

        // INFO: campos internos
        $this->hasColumn('id');
        $this->hasColumn('metaficha_id');
        $this->hasColumn('locked');
        $this->hasColumn('estado');
        $this->hasColumn('estado_justificacion');
        $this->hasColumn('actualizable');
        $this->hasColumn('servicio_codigo');
        $this->hasColumn('maestro');
        $this->hasColumn('maestro_id');
        $this->hasColumn('publicado', 'boolean', 1, array('default' => 0));
        $this->hasColumn('publicado_at');
        $this->hasColumn('primera_version_publicada_id');
        $this->hasColumn('comentarios');
        
    }

    function setUp() {
        parent::setUp();
        $this->actAs('Timestampable');

        $this->hasMany('SubFicha as Versiones', array(
            'local' => 'id',
            'foreign' => 'maestro_id',
            'orderBy' => 'id desc'
        ));

        $this->hasOne('SubFicha as Maestro', array(
            'local' => 'maestro_id',
            'foreign' => 'id'
        ));

        $this->hasMany('HistorialSubFicha as Historiales', array(
            'local' => 'id',
            'foreign' => 'sub_ficha_id',
            'orderBy' => 'id desc'
        ));

        $this->hasOne('Ficha as MetaFicha', array(
            'local' => 'metaficha_id',
            'foreign' => 'id'
        ));

        $this->hasOne('Servicio', array(
            'local' => 'servicio_codigo',
            'foreign' => 'codigo'
        ));
    }

    public function generarVersion() {
        if ($this->maestro) {
            $proyecto_copia = $this->copy(FALSE);
            $proyecto_copia->maestro = 0;
            // $proyecto_copia->publicado = 0;
            $proyecto_copia->maestro_id = $this->id;
            $proyecto_copia->save();

            $this->logLastChange();
        }
    }

    private function logLastChange() {
        $usuario = NULL;
        if (UsuarioBackendSesion::usuario())
            $usuario = UsuarioBackendSesion::usuario();

        $ultima_version = $this->getUltimaVersion();

        if ($this->Versiones->count() > 1) {

            $penultima_version = $this->Versiones[1];
            $comparacion = $ultima_version->compareWith($penultima_version);
            if ($comparacion) {
                $descripcion = make_description_subficha($comparacion, $ultima_version);
            } else {
                $descripcion = '<p>La SubFicha ha sido guardada pero no se realizaron cambios.</p>';
            }
        } else {    //El proyectos es nuevo
            $descripcion = '<p>Se ha creado la SubFicha</p>';
        }

        $log = new HistorialSubFicha();
        $log->SubFicha = $this;
        $log->SubFichaVersion = $ultima_version;
        $log->UsuarioBackend = $usuario;
        $log->descripcion = $descripcion;
        $log->save();
    }

    public function compareWith(SubFicha $subficha) {

        $comparacion = NULL;

        $left = $this->toArray(false);
        $right = $subficha->toArray(false);

        $exclude = array('id','metaficha_id','locked','estado','estado_justificacion','actualizable','servicio_codigo','maestro','maestro_id','publicado','publicado_at','updated_at','primera_version_publicada_id','comentarios');
        $labels = array('tipo' => array(1 => 'Personas', 2 => 'Empresas', 3 => 'Ambos', 0 => 'No asignado'));

        foreach ($left as $key => $val) {
            if (!in_array($key, $exclude)) {
                if ($right[$key] != $left[$key]) {
                    if (array_key_exists($key, $labels)) {
                        $diff = htmlDiff(
                                strip_tags($labels[$key][$right[$key]]), strip_tags($labels[$key][$left[$key]])
                        );
                    } else {
                        $diff = htmlDiff(strip_tags($right[$key]), strip_tags($left[$key]));
                    }
                    $diff = trim($diff);
                    if ($diff) {
                        $comparacion[$key]->left[] = $diff;
                        $comparacion[$key]->right[] = $right[$key];
                    }
                }
            }
        }

        return $comparacion;
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

    function getVersionPublicada() {
        if ($this->maestro)
            $versiones = $this->Versiones;
        else
            $versiones = $this->Maestro->Versiones;

        foreach ($versiones as $v)
            if ($v->publicado)
                return $v;

        return false;
    }

    function aprobar() {
        Doctrine_Manager::connection()->beginTransaction();

        //Marco el maestro como en revision
        $this->locked = 1;
        $this->estado = 'en_revision';
        $this->save();

        $ultimaversion = $this->getUltimaVersion();
        $ultimaversion->estado = 'en_revision';

        //Lo escribo en el log
        $log = new HistorialSubFicha();
        $log->descripcion = '<strong>Actualización de Estado</strong><br />Versión aprobada y enviada a revisión.';
        $log->SubFicha = $this;
        $log->SubFichaVersion = $ultimaversion;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

    function rechazar() {
        Doctrine_Manager::connection()->beginTransaction();

        $this->locked = 0;
        $this->estado = 'rechazado';
        $this->save();


        $ultimaversion = $this->getUltimaVersion();
        $ultimaversion->estado = 'rechazado';
        $ultimaversion->estado_justificacion = $this->estado_justificacion;

        $ultimaversion->save();

        //Lo escribo en el log
        $log = new HistorialSubFicha();
        $log->descripcion = '<strong>Actualización de Estado</strong><br />Versión rechazada.<br />Motivo: ' . $this->estado_justificacion;
        $log->SubFicha = $this;
        $log->SubFichaVersion = $ultimaversion;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

    function publicar() {
        Doctrine_Manager::connection()->beginTransaction();

        //Marco el maestro como publicado
        if ($this->publicado) {
            $this->actualizable = 0;
        } else {
            $this->publicado = 1;
            $this->publicado_at = date('Y-m-d H:i:s');
        }

        $this->estado_justificacion = '';
        $this->locked = 0;
        $this->estado = NULL;

        $this->save();

        //Primero despublico las versiones antiguas;
        $versiones = $this->Versiones;
        foreach ($versiones as $v) {
            $v->publicado = 0;
            $v->publicado_at = NULL;
            $v->save();
        }

        $ultimaversion = $this->getUltimaVersion();
        $ultimaversion->estado = NULL;
        $ultimaversion->publicado = 1;
        $ultimaversion->publicado_at = date('Y-m-d H:i:s');
        $ultimaversion->estado_justificacion = '';
        $ultimaversion->save();

        //Primera version publicada
        if(!$this->primera_version_publicada_id)
            $this->primera_version_publicada_id = $ultimaversion->id;

        //Lo escribo en el log
        $log = new HistorialSubFicha();
        $log->descripcion = '<strong>Actualización de Estado de Publicación</strong><br />Versión publicada';
        $log->SubFicha = $this;
        $log->SubFichaVersion = $ultimaversion;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

    function despublicar() {
        Doctrine_Manager::connection()->beginTransaction();

        //Marco el maestro como publicado
        $this->publicado = 0;
        $this->publicado_at = NULL;
        $this->actualizable = 0;

        $this->save();

        //Despublico las versiones;
        $versiones = $this->Versiones;
        foreach ($versiones as $v) {
            if ($v->publicado == 1) {
                $v->publicado = 0;
                $v->publicado_at = NULL;
                $v->save();
                $versionactualizada = $v;
            }
        }

        //Lo escribo en el log
        $log = new HistorialSubFicha();
        $log->descripcion = '<strong>Actualización de Estado de Publicación</strong><br />Versión despublicada';
        $log->SubFicha = $this;
        $log->SubFichaVersion = $versionactualizada;
        $log->UsuarioBackend = UsuarioBackendSesion::usuario();
        $log->save();

        Doctrine_Manager::connection()->commit();
    }

}