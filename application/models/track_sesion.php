<?php

class TrackSesion {

    private static $config = array('sess_cookie_name' => 'track',
        'sess_expiration' => 604800,
        'sess_encrypt_cookie' => FALSE,
        'sess_use_database' => TRUE,
        'sess_table_name' => 'ci_sessions_track',
        'sess_match_ip' => FALSE,
        'sess_match_useragent' => TRUE,
        'sess_time_to_update' => 300
    );
    
    public static function loadSession(){
        $CI = &get_instance();
        $CI->load->library('session', self::$config, 'session_track');
    }

    public static function insertarVisitaFicha($id) {
        $CI = &get_instance();
        self::loadSession();
        $hits = $CI->session_track->userdata('hits');
        $hits[$id] = isset($hits[$id]) ? $hits[$id] + 1 : 1;
        $CI->session_track->set_userdata('hits', $hits);
    }

    public static function insertarEvaluacionFicha($id, $evaluacion) {
        $CI = &get_instance();
        self::loadSession();
        $evaluaciones = $CI->session_track->userdata('evaluaciones');
        $evaluaciones[$id] = $evaluacion;
        $CI->session_track->set_userdata('evaluaciones', $evaluaciones);
    }

    public static function calcularFichasSimilares() {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time',3600);

        $sesiones = Doctrine_Query::create()
                ->select('session_id,user_data')
                ->from('CiSessionsTrack')
                ->execute(array(), DOCTRINE_CORE::HYDRATE_ARRAY);
        $prefs = self::calcularPuntajes($sesiones);

        $prefs_inv = array();
        foreach ($prefs as $user => $value) {
            foreach ($value as $other_ficha_id => $puntaje) {
                $prefs_inv[$other_ficha_id][$user] = $puntaje;
            }
        }

        $fichas = Doctrine_Query::create()
                ->from('Ficha f')
                ->where('f.maestro = 1')
                ->execute();

        foreach ($fichas as $f)
            self::saveTopSimilares($prefs_inv, $f);
    }

    private static function calcularPuntajes($sesiones) {
        foreach ($sesiones as $s) {
            $data = unserialize($s['user_data']);
            if (isset($data['hits'])) {
                foreach ($data['hits'] as $ficha_id => $hits) {
                    $usuarios[$s['session_id']][$ficha_id] = 1;
                }
            }
        }
        return $usuarios;
    }

    private static function simDistance($prefs, $user1, $user2) {
        if (!isset($prefs[$user1]) || !isset($prefs[$user2]))
            return 0;

        //Obtenemos el listado de fichas en comun
        $si = array();
        foreach ($prefs[$user1] as $ficha_id => $puntaje) {
            if (array_key_exists($ficha_id, $prefs[$user2])) {
                $si[$ficha_id] = 1;
            }
        }

        $total = array();
        foreach ($prefs[$user1] as $ficha_id => $puntaje) {
            $total[$ficha_id] = 1;
        }
        foreach ($prefs[$user2] as $ficha_id => $puntaje) {
            $total[$ficha_id] = 1;
        }

        //return count($si);
        return count($si) / count($total);
    }

    private static function topMatches($prefs, $user, $n = 3) {
        $scores = array();
        foreach ($prefs as $other => $value) {
            if ($other != $user) {
                $sim = self::simDistance($prefs, $user, $other);
                //Ignoro las similitudes cero
                if ($sim <= 0)
                    continue;

                $scores[$other] = $sim;
            }
        }

        arsort($scores);
        return array_slice($scores, 0, $n, true);
    }

    private static function saveTopSimilares($prefs, Ficha $ficha) {
        $top = self::topMatches($prefs, $ficha->id, 3);
        
        Doctrine_Query::create()
                ->delete('FichaHasFichaSimilar f')
                ->where('f.ficha_id = ?',$ficha->id)
                ->execute();
          
        foreach ($top as $ficha_id => $score){
            $rel=new FichaHasFichaSimilar();
            $rel->ficha_id=$ficha->id;
            $rel->ficha_similar_id=$ficha_id;
            $rel->save();
        }

        /*
        foreach ($ficha->FichasSimilares as $key => $value)
            unset($ficha->FichasSimilares[$key]);

        foreach ($top as $ficha_id => $score) {
            $ficha->FichasSimilares[] = Doctrine::getTable('Ficha')->find($ficha_id);
        }
         * 
         */

        $ficha->save();
    }

}