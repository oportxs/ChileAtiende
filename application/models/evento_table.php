<?php

class EventoTable extends Doctrine_Table {

    /**
     * Funcion que implementa la busqueda de temas de fichas asociadas a la busqueda
     */
    function findEventoBusqueda($set_de_fichas) {

        // TODO: Eliminar funcion. Se deja como referencia para codigo en controllers/buscar.php
        //        Los eventos ya no se relacionan directamente con las fichas
        //        * En busqueda/filtros_v2.php no se esta usando tampoco el filtro que podria aportar Evento
        //
        // $query = Doctrine_Query::create();
        // $query->select("e.id, COUNT(e.id) AS numero_fichas");
        // $query->from('Evento e, e.Fichas f');
        //
        // if ($set_de_fichas) {
        //     $query->where("f.id IN (" . $set_de_fichas . ")");
        // } else {
        //     $query->where("f.id IN (0)");
        // }
        //
        // $query->groupBy("e.id");
        // //debug($query->getSqlQuery());
        // return $query->execute();

        return null;
    }

    /**
     * Funcion que devuelve Eventos segun los criterios determinados segun las opciones entregadas.
     * Opciones
     *      - publicados:       true/false para delimitar a eventos publicados de fichas publicadas
     *      - actuales:         true/false para delimitar a eventos con fecha de fin posterior a la actual
     *      - permanente:       true/false para delimitar a eventos permanentes
     *      - inicio:           "YYYY-MM-DD" para delimitar eventos a un periodo. En conjunto a 'fin'
     *      - fin:              "YYYY-MM-DD" para delimitar eventos a un periodo. En Conjunto a 'inicio'
     *      - regiones:         Array para delimitar eventos que pertenecen a las Regiones del array.
     *      - instituciones:    Array para delimitar eventos que pertenecen a las Instituciones del array.
     *      - tipo:             String para delimitar eventos que son de un tipo (empresas/personas)
     */
    function getEventos($options)
    {
        $query = Doctrine_Query::create();
        $query->select('e.*, RANDOM() as rand');
        $query->from('Evento e, e.Regiones r');
        $query->andWhere('e.maestro = 1');

        if(isset($options['publicados']) && ($options['publicados'] == true) )
            $query->andWhere('e.publicado = 1');

        if(isset($options['actuales']) && ($options['actuales'] == true) )
            $query->andWhere('e.postulacion_end >= DATE(NOW())');

        if(isset($options['permanentes']) && ($options['permanentes'] == true))
            $query->andWhere('e.permanente = 1');
        else if(isset($options['permanentes']) && ($options['permanentes'] == false))
            $query->andWhere('e.permanente = 0');
        
        if(isset($options['inicio']) && isset($options['fin']))
            $query->andWhere('e.postulacion_start <= "'.$options['fin'].'" AND e.postulacion_end >= "'.$options['inicio'].'"');

        if(isset($options['regiones']) &&  count($options['regiones']) > 0)
            $query->andWhere('r.id IN ('.implode(',', $options['regiones']).')');

        if(isset($options['instituciones']) &&  count($options['instituciones']) > 0)
            $query->andWhere('e.servicio_codigo IN ("'.implode('","', $options['instituciones']).'")');

        // INFO: filtra fuera el tipo contrario
        // 1 => 'Personas', 2 => 'Empresas', 3 => 'Ambos', 0 => 'No asignado'
        if(isset($options['tipo']))
            switch($options['tipo']) {
                case 'personas':
                    $query->andWhere('e.tipo != 2');
                    break;
                case 'empresas':
                    $query->andWhere('e.tipo != 1');
                    break;
                default:
                    break;
            }

        if(isset($options['destacados']) && ($options['destacados'] == true) )
            $query->andWhere('e.destacado = 1');

        if(isset($options['limit']))
            $query->limit($options['limit']);
        
        if (isset($options['offset']))
            $query->offset($options['offset']);

        if(isset($options['random']) && $options['random'] == true)
            $query->orderBy('rand');

        $query->groupBy('e.id');

        if(isset($options['justCount']))
            return $query->count();
        else
            return $query->execute();

    }

    function findMaestros($entidad=NULL, $servicio=NULL, $options=array()) {
        $query = Doctrine_Query::create();

        $query->from('Evento evento, evento.Servicio servicio, servicio.Entidad entidad');
        $query->andWhere('evento.maestro = 1');
        
        // INFO: Se excluyen los eventos que estan eliminados
        $query->andWhere('evento.estado IS NULL OR evento.estado != "eliminado"');

        if ($entidad)
            $query->andWhere('entidad.codigo = ?', $entidad);
        if ($servicio)
            $query->andWhere('servicio.codigo = ?', $servicio);

        if (isset($options['actuales']) && $options['actuales'] == true )
            $query->andWhere('evento.postulacion_end >= DATE(NOW()) OR evento.permanente = 1');

        if (isset($options['estado'])) {

            if ($options['estado'] == 'publicados')
                $query->andWhere('evento.publicado = 1');

            if ($options['estado'] == 'nopublicados')
                $query->andWhere('evento.publicado = 0');

            if ($options['estado'] == 'rechazados')
                $query->andWhere('evento.estado = "rechazado"');

            if ($options['estado'] == 'expirados') {
                $query->andWhere('evento.postulacion_end < DATE(NOW())');
                $options['order_by'] = 'evento.postulacion_end DESC';
            }
        }

        if (isset($options['limit'])) {
            $query->limit($options['limit']);
        }
        if (isset($options['offset'])) {
            $query->offset($options['offset']);
        }
        if (isset($options['order_by'])) {
            $query->orderBy($options['order_by']);
        }

        $resultado = NULL;
        if (isset($options['justCount'])) {
            $resultado = $query->count();
        } else {
            $resultado = $query->execute();
        }
        return $resultado;
    }

}