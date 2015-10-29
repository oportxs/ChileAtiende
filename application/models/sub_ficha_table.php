<?php

class SubFichaTable extends Doctrine_Table {

	function findMaestros($entidad=NULL, $servicio=NULL, $options=array()) {
        $query = Doctrine_Query::create();
		$query->from('SubFicha sf, sf.MetaFicha metaficha, sf.Servicio servicio, servicio.Entidad entidad');
        $query->andWhere('sf.maestro = 1');
        // INFO: se ocultan las sub_fichas que se quitaron de las listas a llenar por las instituciones (no se eliminan realmente)
        $query->andWhere("sf.estado NOT LIKE 'eliminado' OR sf.estado IS NULL");

        if ($entidad)
            $query->andWhere('entidad.codigo = ? ', $entidad);

        if ($servicio)
            $query->andWhere('servicio.codigo = ? ', $servicio);

        if (!empty($options['titulo'])) {
            //verifico si es numerico, en caso de que este buscando por el id del tramite
            if (is_numeric($options['titulo'])) {
                $query->andWhere('sf.id = ?', $options['titulo']);
            } else {
                //divido el string, en el caso de que se esté buscando por el codigo del tramite
                //si este arreglo que se genera es menor de 1 significa que está buscando por el titulo del tramite
                $aCodigo = explode('-', $options['titulo']);
                if (count($aCodigo) > 1) {
                    $query->andWhere('sf.servicio_codigo LIKE ?', $aCodigo[0]);
                    // $query->andWhere('sf.correlativo = ?', $aCodigo[1]); // subficha no tiene correlativo
                } else {
                    $query->andWhere('metaficha.titulo LIKE ?', '%' . $options['titulo'] . '%');
                }
            }
        }

        if (isset($options['estado'])) {

            if ($options['estado'] == 'publicados')
                $query->andWhere('sf.publicado = 1');

            if ($options['estado'] == 'nopublicados')
                $query->andWhere('sf.publicado = 0');

            if ($options['estado'] == 'actualizables')
                $query->andWhere('sf.actualizable = 1');

            if ($options['estado'] == 'enrevision')
                $query->andWhere("sf.estado LIKE 'en_revision'");

            if ($options['estado'] == 'rechazado')
                $query->andWhere("sf.estado LIKE 'rechazado'");

            if ($options['estado'] == 'creadas') {
                $query->andWhere("sf.publicado = 0");
                $query->andWhere("sf.publicado_at IS NULL");
                $query->andWhere("sf.locked = 0");
                $query->andWhere("sf.estado IS NULL");
            }
        }

        // $resultado = $query->execute();
        // return $resultado;
        return $this->_optionsHandler($query, $options);

    }

    function findPublicado($id_maestro, $options=array()) {
        $query = Doctrine_Query::create();
        $query->from('SubFicha sf, sf.Servicio servicio, servicio.Entidad entidad');
        $query->andWhere('sf.maestro = 0 and sf.publicado = 1');
        $query->andWhere('sf.maestro_id = ?', $id_maestro);

        return $this->_optionsHandler($query, $options);
    }    

    function _optionsHandler($query, $options) {
        //print_r($options);
        if (isset($options['filtros'])) {

            //Normalmente se hacen dos consultas, la primera es para obtener todos los resultados y construir la paginacion, obtener el total de temas asociados, etc.
            //La seguna es el resultado de una pagina especifica.
            //Este parametro es True cuando hago la consulta que pide todos los resultados y false cuando pido los resultados de una pagina en particular.
            $all = FALSE;
            if (!(isset($options['limit']) && isset($options['offset']) ))
            //Si estos parametros no estan definidos entonces es posible inferir que se piden todos los resultados
                $all = TRUE;

            //Si status es True, entonces Sphinx busco correctamente

            list($query, $status, $total, $set_total_de_fichas) = $this->_search($query, $options['filtros'], $options, $all);
            //echo '+'.$status.'+<br />';
            if ($status) {

                //En este caso se eliminan los limit y offset externos ya que se aplican sobre la busqueda de sphinx y no a nivel de doctrine, por ende es necesario ignorarlo en esta parte de optionsHandler.

                if (isset($options['limit']))
                    unset($options['limit']);
                if (isset($options['offset']))
                    unset($options['offset']);

                if (!$all) {
                    //Al igual que en el caso de limit y offset, doctrine se encarga de aplicar orderBy por lo tanto se ignora este campo.
                    unset($options['orderBy']);
                }
            }
        }

        if (isset($options['limit'])) {
            $query->limit($options['limit']);
        }
        if (isset($options['offset'])) {
            $query->offset($options['offset']);
        }

        /*
         * En esta parte, se desarma el parametro orderBy para implementar orderBy mas_votados y mas_vistos, los cuales no son campos de la ficha propiamente tal y es necesario
         * hacer una serie de cruces para poder entregar fichas ordenadas de esta manera.
         * Actualmente se observo que estos dos metodos no funcionan correctamente ya que doctrine
         * genera entidades extras que hacen que SUM y COUN no funcionen como es esperado, por lo tanto no se deben utilizar estos métodos y en el futuro
         * deberian ser eliminados.
         */

        if (isset($options['orderBy'])) {

            $orders = explode(",", $options['orderBy']);
            $orderByFinal = array();
            foreach ($orders as $orderby) {

                $orderby = explode(" ", trim($orderby));

                $campo = $orderby[0];
                $order = (isset($orderby[1])) ? $orderby[1] : "DESC";
                $orderByFinal[] = $campo . " " . $order;
            }
            $query->orderBy(implode(",", $orderByFinal));
        }

        if (isset($options['order_by'])) {
            $query->orderBy($options['order_by']);
        }

        $resultado = NULL;
        if (isset($options['justCount'])) {
            //debug($query->getSqlQuery(),"blue");
            $resultado = $query->count();
        } elseif (isset($options['justQuery'])) {
            $resultado = $query;
        } else {
            //debug($query->getSqlQuery(), "red");
            if (isset($options['justIds'])) {
                $query->select('sf.id');
            }
            $resultado = $query->execute();
        }
        if(isset($options['buscador']) && $options['buscador']){
            if (isset($options['to_array']))
                return array('total' => $total, 'resultado' => $resultado->toArray(), 'set_total_de_fichas' => $set_total_de_fichas);
            else
                return array('total' => $total, 'resultado' => $resultado, 'set_total_de_fichas' => $set_total_de_fichas);
          }else{
            if (isset($options['to_array']))
                return $resultado->toArray();
            else
                return $resultado;
          }
    }

}

?>