<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FichaTable extends Doctrine_Table {

    function findPublicados($options=array()) {
        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Temas temas, f.TemasEmpresa temasempresa, f.Servicio servicio, servicio.Entidad entidad, f.ApoyosEstado apoyos');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        
        if(isset($options['tipo']))
            switch($options['tipo'])
            {
                case 'personas':
                    $query->andWhere('f.tipo != 2');
                    break;
                case 'empresas':
                    $query->andWhere('f.tipo != 1');
                    break;
            }

        return $this->_optionsHandler($query, $options);
    }

    function findRangoEdadFicha($id) {
        $query = Doctrine_Query::create();
        $query->from('FichaHasRangoEdad r');
        $query->andWhere('r.ficha_id = ' . $id);
        $resultado = $query->fetchOne()->toArray();
        return $resultado;
    }

    function findMaestros($entidad=NULL, $servicio=NULL, $options=array()) {
        $query = Doctrine_Query::create();

        if (isset($options['campos']))
            $query->select($options['campos']);

        $query->from('Ficha f, f.Temas temas, f.Servicio servicio, servicio.Entidad entidad, f.TramitesEnExterior as exterior');
        $query->andWhere('f.maestro = 1');

        if ($entidad)
            // $query->andWhere('entidad.codigo = ? OR subfichas_servicio.entidad_codigo = ?', array($entidad,$entidad));
            $query->andWhere('entidad.codigo = ? ', $entidad);

        if ($servicio)
            // $query->andWhere('servicio.codigo = ? OR subfichas.servicio_codigo = ?', array($servicio, $servicio));
            $query->andWhere('servicio.codigo = ? ', $servicio);


        if (isset($options['flujos'])) {
            // habilitamos esta opción para que muestre destacadas las fichas y los flujos
            if ($options['estado'] != 'destacado') { 
                if ($options['flujos']) {
                    $query->andWhere('f.flujo = 1');
                } else {
                    $query->andWhere('f.flujo = 0');
                }
            }
        }

        if (!empty($options['titulo'])) {
            //verifico si es numerico, en caso de que este buscando por el id del tramite
            if (is_numeric($options['titulo'])) {
                $query->andWhere('f.id = ?', $options['titulo']);
            } else {
                //divido el string, en el caso de que se esté buscando por el codigo del tramite
                //si este arreglo que se genera es menor de 1 significa que está buscando por el titulo del tramite
                $aCodigo = explode('-', $options['titulo']);
                if (count($aCodigo) > 1) {
                    $query->andWhere('f.servicio_codigo LIKE ?', $aCodigo[0]);
                    $query->andWhere('f.correlativo = ?', $aCodigo[1]);
                } else {
                    $query->andWhere('f.titulo LIKE ?', '%' . $options['titulo'] . '%');
                }
            }
        }
        //filtro para tipos de fichas, empresas o personas
        if (!empty($options['publico'])) {
            $query->andWhere('f.tipo = ?', $options['publico']);
        }

        if (isset($options['estado'])) {

            if ($options['estado'] == 'publicados')
                $query->andWhere('f.publicado = 1');

            if ($options['estado'] == 'nopublicados')
                $query->andWhere('f.publicado = 0');

            if ($options['estado'] == 'actualizables')
                $query->andWhere('f.actualizable = 1');

            if ($options['estado'] == 'destacado')
                $query->andWhere('f.destacado = 1');

            if ($options['estado'] == 'chileclic')
                $query->andWhere('f.cc_llavevalor IS NOT NULL');

            if ($options['estado'] == 'pendiente')
                $query->andWhere('f.diagramacion = 1');

            if ($options['estado'] == 'enproceso')
                $query->andWhere('f.diagramacion = 2');

            if ($options['estado'] == 'finalizada')
                $query->andWhere('f.diagramacion = 3');

            if ($options['estado'] == 'enrevision')
                $query->andWhere("f.estado LIKE 'en_revision'");

            if ($options['estado'] == 'rechazado')
                $query->andWhere("f.estado LIKE 'rechazado'");

            if ($options['estado'] == 'creadas') {
                $query->andWhere("f.publicado = 0");
                $query->andWhere("f.publicado_at IS NULL");
                $query->andWhere("f.locked = 0");
                $query->andWhere("f.estado IS NULL");
            }

            if ($options['estado'] == 'metafichas')
                $query->andWhere("f.metaficha = 1");

            if ($options['estado'] == 'exterior')
                $query->andWhere("exterior.id_ficha IS NOT NULL");                
        }

        // debug($query->getSqlQuery(),"red");
        return $this->_optionsHandler($query, $options);
    }

    function findFichaOnServicio($codigo, $options=array()) {
        $query = Doctrine_Query::create();
        
        // INFO: todas las fichas del servicio sin tomar en cuenta las metafichas
        // $query->from('Ficha f');
        // $query->where('f.servicio_codigo = ?', $codigo);
        // $query->andWhere('f.maestro = 0 and f.publicado = 1');

        $query->select('f.*');
        $query->from('Ficha f, f.SubFichas sf');

        // INFO: Todas las fichas del servcio
        $query->where('f.servicio_codigo = ? AND f.maestro = 0 and f.publicado = 1', $codigo);
        // INFO: Todas las metafichas con subfichas del servicio. 
        //       ¡Devuelve maestro_id = NULL!
        $query->orWhere('sf.servicio_codigo = ? AND f.maestro = 1 and f.publicado = 1', $codigo);
        
        $query->orderBy('f.titulo');

        return $this->_optionsHandler($query, $options);
    }

    function findFichaOnEntidad($codigo, $options=array()) {
        $query = Doctrine_Query::create();
        $query->from('Ficha f');

        $query->where('f.servicio_codigo LIKE ?', $codigo . '%');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        //debug( $query->getSqlQuery() );

        return $this->_optionsHandler($query, $options);
    }

    function findNroFichasOnServicios($options=array()) {
        $query = Doctrine_Query::create();
        $query->select('COUNT(f.titulo) AS cnt, f.servicio_codigo, s.nombre');
        $query->from('Ficha f, f.Servicio s');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        $query->groupBy('f.servicio_codigo');
        $query->orderBy('cnt DESC');

        //return $this->_optionsHandler($query, $options);
        if (isset($options['limit']))
            $query->limit($options['limit']);
        if (isset($options['offset']))
            $query->offset($options['offset']);

        $result = $query->execute();
        return $result;
    }

    function findNroFichasOnHechos($idHV) {
        $query = Doctrine_Query::create();
        $query->select('COUNT(*) AS cnt');
        $query->from('Ficha f, f.HechosVida hv');
        $query->where('hv.id = ?', $idHV);
        //debug($query->getSqlQuery(),"red");
        $resultado = $query->fetchOne();

        return $resultado;
    }

    function findNroFichasOnHechosEmpresa($idHE) {
        $query = Doctrine_Query::create();
        $query->select('COUNT(*) AS cnt');
        $query->from('Ficha f, f.HechosEmpresa he');
        $query->where('he.id = ?', $idHE);
        //debug($query->getSqlQuery(),"red");
        $resultado = $query->fetchOne();

        return $resultado;
    }

    /* Metodo que retorna la ficha publicada a partir del id del maestro */

    function findPublicado($id_maestro, $options=array()) {
        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Temas temas, f.Servicio servicio, servicio.Entidad entidad');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        $query->andWhere('f.maestro_id = ?', $id_maestro);

        return $this->_optionsHandler($query, $options);
    }

    function findFichaMujer($ficha_id, $options=array()){
        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Temas temas, f.Servicio servicio, servicio.Entidad entidad');
        $query->andWhere('f.id = ?', $ficha_id);
        // die("SQL => ".$query->getSqlQuery());
        return $this->_optionsHandler($query, $options);
    }

    /* Metodo privado que gestiona las opciones de busqueda para una ficha */

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

                if ($campo == "mas_votados") {
                    //Warning: Estas dos funciones no son seguras, no calculan bien las cantidades

                    $query->addFrom(" f.Maestro maestro");
                    $query->leftJoin("maestro.Evaluaciones evaluaciones");
                    $query->addSelect("*,maestro.id, maestro.rating");
                    $query->groupBy("maestro.id");
                    $orderByFinal[] = "maestro.rating " . $order;
                } elseif ($campo == "mas_vistos") {
                    //Warning: Estas dos funciones no son seguras, no calculan bien las cantidades

                    $query->addFrom(" f.Maestro maestro");
                    $query->leftJoin("maestro.Hits hits ");
                    $query->addSelect("f.id,temas.*,servicio.*,entidad.*, SUM(hits.count) as total");
                    $query->groupBy("f.id, maestro.id");
                    $orderByFinal[] = "total " . $order;
                } else {

                    $orderByFinal[] = $campo . " " . $order;
                }
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
                $query->select('f.id');
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

    /* Funcion que gestiona la busqueda de fichas en distintos casos */

    private function _search($query, $filtros, $op = NULL, $all = FALSE) {

        $ci = &get_instance();
        $ci->load->helper("sphinx");

        //Se asume que el filtro no sera una busqueda en texto a menos que este definida la opcion 'palabra'
        $string = "";
        $nonfulltext = true;
        $filters = array();

        //Intento correr Sphinx
        //Defino una nueva variable de filtros que le paso al search(sphinxhelper) usando los filtros que me llegan del optionsHandler
        if (isset($filtros['string']) && $filtros['string'] != '') {
            $string = $filtros['string'];
            $nonfulltext = false;
        }

        if (isset($filtros['hecho'])) {
            $filters['hecho_vida_id'] = array($filtros['hecho']);
        }
        
        if (isset($filtros['hechoempresa'])) {
            $filters['hecho_empresa_id'] = array($filtros['hechoempresa']);
        }

        if (isset($filtros['etapa'])) {
            $filters['etapa_vida_id'] = array($filtros['etapa']);
        }
        
        if (isset($filtros['etapa_empresa'])) {
            $filters['etapa_empresa_id'] = array($filtros['etapa_empresa']);
        }

        if (isset($filtros['temas'])) {
            $filters['tema_id'] = $filtros['temas'];
        }
        if (isset($filtros['temas_empresa'])) {
            $filters['tema_empresa_id'] = $filtros['temas_empresa'];
        }
        if (isset($filtros['apoyos'])) {
            $filters['apoyo_estado_id'] = $filtros['apoyos'];
        }

        if (isset($filtros['servicios'])) {
            //Se usa crc32 para transformar el codigo de un servicio a int para poder indexarlo en sphinx.
            //Esto hay que hacerlo con cualquier campo sobre el cual haya que aplicar filtros y no sea un numero.
            $filters['servicio_codigo'] = array_map("crc32", $filtros['servicios']);
        }

        if(isset($filtros['tramites'])){
        	foreach ($filtros['tramites'] as $tramite) {
        		$filters[$tramite] = array(1);
        	}
        }

        if (isset($filtros['edad'])) {

            //La edad para filtrar no sirve directamente, es necesario obtener los rangos donde la edad esta incluida
            //y luego filtrar por ese set de rangos asociados a las fichas

            $rangos = Doctrine::getTable("RangoEdad")->rangosFromAge($filtros['edad']);
            if ($rangos) {
                $filters['rango_edad_id'] = $rangos;
            } else {
                //Fuerzo el resultado a 0 fichas ya que preguntan por una edad que no posee rangos de edad asociados
                return array($query->having("f.id IN (0)"), TRUE);
            }
        }

        if (isset($filtros['genero'])) {

            $genero = $filtros['genero'];
            switch ($genero) {
                case 1:
                    //Caso ambos (1) busco las fichas marcadas con ambos y las que poseen genero 0 (no asignadas)
                    $genero = array(1, 0);
                    break;
                case 2:
                    //Si me piden un genero particular busco el genero (2), ambos (1), que tambien contienen al genero (2) y también las que no han sido asignadas
                    $genero = array(2, 1, 0);
                    break;
                case 3:
                    //Igual que caso 2
                    $genero = array(3, 1, 0);
                    break;
            }

            $filtros['genero'] = $genero;

            if (!is_array($filtros['genero'])) {
                //Cada variable en filters debe ser un arreglo. Si genero es solo un valor, entonces lo defino como un arreglo de un elemento.
                $filters['genero_id'] = array($filtros['genero']);
            } else {
                $filters['genero_id'] = $filtros['genero'];
            }
        }

        if(isset($filtros['flujo'])){
        	$filters['flujo'] = array($filtros['flujo']);
        }

        /* IMPORTANTE AGREGAR PARA TENER BUENOS RESULTADOS */
        //Esto es un poco feo, ya que la busqueda solo me va a servir para documentos publicados.
        //Deberia ser posible abstraerlo.
        $filters['publicado'] = array(1);
        $filters['maestro'] = array(0);

        /* LIMITO RESULTADOS */
        $limit = 100000; //Se define esto ya que Sphinx limita por defecto los resultados, para el caso donde no se define limite se pone un limite alto para escapar el limite de sphinx.
        $offset = 0;
        if (isset($op['limit']))
            $limit = $op['limit'];
        if (isset($op['offset']))
            $offset = $op['offset'];

        /*
        echo '<br />string: "'.$string.'"<br />'; 
        echo 'filters: '; print_r($filters); echo '<br />';
        echo 'nonfulltext: '.( ($nonfulltext) ? 'true' : 'false').'<br />';
        */
        //debug($filters);
        //Es necesario hacer una llamada para obtener el registro total de las fichas
        // para poder mostrar sólo los filtros de busqueda que existen en el set de fichas obtenidos
        $search_result_total = search($string, $filters, $nonfulltext, 100000, 0);

        //Se llama a la busqueda de sphinx con los parámetros de paginación
        $search_result = search($string, $filters, $nonfulltext, $limit, $offset);

        list($res, $status, $message, $total) = $search_result;

        $temas = (isset($filtros['temas'])) ? $filtros['temas'] : null;
        $temas_empresa = (isset($filtros['temas_empresa'])) ? $filtros['temas_empresa'] : null;
        $servicios = (isset($filtros['servicios'])) ? $filtros['servicios'] : null;
        $edad = (isset($filtros['edad'])) ? $filtros['edad'] : null;
        $genero = (isset($filtros['genero'])) ? $filtros['genero'] : null;
        $apoyoss = (isset($filtros['apoyos'])) ? $filtros['apoyos'] : null;

        //Caso en que esta corriendo sphinx
        //echo '++'.$status.'++<br />';
        if ($status) {

            $fichas = search_wrapper($search_result, TRUE);
            $set_de_fichas = implode(",", array_keys($fichas));

            $q = Doctrine_Manager::getInstance()->getCurrentConnection();

            if ($set_de_fichas) {
                $query->having("f.id IN (" . $set_de_fichas . ")");
                $query->orderBy("FIELD(id," . $set_de_fichas . ")");
            } else {
                $query->having("f.id IN (0)");
            }
        } else {
            //En caso que no este corriendo el demonio searchd, se usan los metodos viejos de filtro :)
            //Busqueda por string
            if (isset($filtros['string']) AND !empty($filtros['string'])) {
                $query = $this->_searchString($query, $filtros['string']);
            }
            //Filtros! MUST CHANGE
            $query = $this->_searchFilters($query, $filtros);
        }

        //Se incluye en la respuesta el set total de fichas encontradas
        return array($query, $status, $total, $search_result_total[0]);
    }

    /* Método privado invocado por _search que gestiona filtros */

    function _searchFilters($query, $filtros) {

        //debug($filtros);
        $w = array();
        $s = array();

        $temas = (isset($filtros['temas'])) ? $filtros['temas'] : null;
        $temas_empresa = (isset($filtros['temas_empresa'])) ? $filtros['temas_empresa'] : null;
        $servicios = (isset($filtros['servicios'])) ? $filtros['servicios'] : null;
        $edad = (isset($filtros['edad'])) ? $filtros['edad'] : null;
        $genero = (isset($filtros['genero'])) ? $filtros['genero'] : null;
        $hecho = (isset($filtros['hecho'])) ? $filtros['hecho'] : null;
        $hechoempresa = (isset($filtros['hechoempresa'])) ? $filtros['hechoempresa'] : null;
        $apoyos = (isset($filtros['apoyos'])) ? $filtros['apoyos'] : null;

        //Temas y Servicios
        if ((is_array($temas) && count($temas)) || (is_array($servicios) && count($servicios))) {
            //debug("Temas y Servicios");
            if (is_array($temas) && count($temas)) {
                foreach ($temas as $tema) {
                    $w[] = ' temas.id = ? ';
                    $s[] = $tema;
                }
            }
            if (is_array($temas_empresa) && count($temas_empresa)) {
                foreach ($temas_empresa as $tema) {
                    $w[] = ' temasempresa.id = ? ';
                    $s[] = $tema;
                }
            }
            if (is_array($apoyos) && count($apoyos)) {
                foreach ($apoyos as $a) {
                    $w[] = ' apoyos.id = ? ';
                    $s[] = $a;
                }
            }
            if (is_array($servicios) && count($servicios)) {
                foreach ($servicios as $servicio) {
                    $w[] = ' servicio.codigo = ? ';
                    $s[] = $servicio;
                }
            }
            $query->andWhere(implode(" OR ", $w), $s);
        }

        if ($hecho) {
            //debug("Hecho");
            $query->addFrom('f.HechosVida hechos');
            $query->andWhere('hechos.id = ?', $hecho);
        }
        if ($hechoempresa) {
            //debug("Hecho");
            $query->addFrom('f.HechosEmpresa hechosempresa');
            $query->andWhere('hechosempresa.id = ?', $hecho);
        }

        //FILTROS DE EDAD
        if ($edad) {
            //debug("Edad");
            //valido que efectivamente sea un numero antes de incluirlo en la query, evitando inyecciones o cruces innecesarios.
            if ($edad > 0 && is_numeric($edad)) {
                $query->addFrom("f.RangosEdad r");
                $query->andWhere("r.edad_maxima >= $edad AND r.edad_minima <= $edad");
            }
            //debug($query->getSqlQuery());
        }

        //FILTRO DE GENERO
        if (is_array($genero)) {
            //debug("Genero");
            $gen = array();
            foreach ($genero as $key) {
                $gen[] = "f.genero_id = " . $key;
            }
            $query->andWhere(implode(" OR ", $gen));
        } elseif (is_numeric($genero)) {
            $query->andWhere("f.genero_id = $genero OR f.genero_id = 1 OR f.genero_id = 0");
        }

        return $query;
    }

    /* Busqueda por strings sin sphinx */

    function _searchString($query, $string) {

        $ci = &get_instance();
        $ci->load->helper("file");
        //echo '+'.$string.'+';
        $string = explode(" ", $string);
        $stopwords = explode("\n", read_file("./application/config/stopwords.txt"));
        $string = array_diff($string, $stopwords);

        if (is_array($string) && count($string) && $string[0]) {
            foreach ($string as $str) {
                if ($str) {
                    $str = "%" . $str . "%";
                    //$w[] = " objetivo LIKE '$str' OR titulo LIKE '$str' ";
                    $w[] = " objetivo LIKE ? OR titulo LIKE ? ";
                    $s[] = $str;
                    $s[] = $str;
                }
            }
            $query->andWhere(implode(" OR ", $w), $s);
        } else {
            //Llega vacio
            $query->andWhere(" objetivo LIKE '' OR titulo LIKE '' ");
        }

        return $query;
    }

    function getRandom($limit = 4) {

        $query = Doctrine_Query::create();
        $query->from('Ficha f');
        $query->where('f.maestro = 0 and f.publicado = 1');
        $query->select('f.* , RANDOM() AS rand');
        $query->orderby('rand');
        $query->limit($limit);
        $rating = $query->execute();
        return $rating;
    }

    //obtiene el total de fichas publicadas
    function totalPublicados($tipo = null) {
        $options_ficha['justCount'] = True;
        if($tipo)
            $options_ficha['tipo'] = $tipo;
        return $this->findPublicados($options_ficha);
    }

    function MasNuevas($limit = 10, $offset = 0)
    {
        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Maestro maestro, maestro.PrimeraVersionPublicada primeraVersion');
        $query->andWhere('f.maestro = 0 and f.publicado = 1 and f.tipo = 1');
        $query->orderBy('primeraVersion.created_at DESC');

        if ($limit)
            $query->limit($limit);
        if ($offset)
            $query->offset($offset);

        $result = $query->execute();
        return $result;
    }

    function MasVistas($aData) {
        if (!isset($aData['limit']))
            ini_set('memory_limit', '64M');

        if (isset($aData['fields']))
            $campos = $aData['fields'];
        else
            $campos = '*';

        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Maestro maestro, maestro.Hits hits');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        if (isset($aData['last_week']))
            $query->andWhere('hits.fecha > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)');
        $query->addSelect($campos . ",SUM(hits.count) as total");
        $query->orderBy("total DESC");
        $query->groupBy("f.maestro_id");

        if (isset($aData['limit']))
            $query->limit($aData['limit']);
        if (isset($aData['offset']))
            $query->offset($aData['offset']);

        $query->useResultCache(new Doctrine_Cache_Apc());
        $query->setResultCacheLifeSpan(600);

        $result = $query->execute();

        return $result;
    }
    function MasVistasEmpresa($aData) {
        if (!isset($aData['limit']))
            ini_set('memory_limit', '64M');

        if (isset($aData['fields']))
            $campos = $aData['fields'];
        else
            $campos = '*';

        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Maestro maestro, maestro.Hits hits');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        if (isset($aData['last_week']))
            $query->andWhere('hits.fecha > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)');
        $query->addSelect($campos . ",SUM(hits.count) AS total");
        $query->andWhere('f.tipo=2 OR f.tipo=3');
        $query->orderBy("total DESC");
        $query->groupBy("f.maestro_id");

        if (isset($aData['limit']))
            $query->limit($aData['limit']);
        if (isset($aData['offset']))
            $query->offset($aData['offset']);

        $query->useResultCache(new Doctrine_Cache_Apc());
        $query->setResultCacheLifeSpan(600);
        //echo $query->getSqlQuery();
        $result = $query->execute();

        return $result;
    }

    function FichasMujer($limit){
        $conn = Doctrine_Manager::getInstance()->connection();
        
        $sql = "SELECT f.*, s.nombre as nombre_servicio FROM ficha f ";
        $sql.= "LEFT JOIN servicio s ON f.servicio_codigo = s.codigo ";
        $sql.= "WHERE f.es_tramite_mujer = 1 AND f.maestro = 0 AND f.publicado = 1 LIMIT " . $limit;
        $result = $conn->execute($sql);
        return $result->fetchAll();
    }
    function FichasMujerDestacadas(){
        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Temas temas, f.Servicio servicio, servicio.Entidad entidad');
        $query->andWhere('f.es_tramite_mujer = 1 and f.es_tramite_mujer_destacado = 1');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');

        return $this->_optionsHandler($query, $options);

    }


    function MasVotadas($aData) {
        if (!isset($aData['limit']))
            ini_set('memory_limit', '64M');

        $query = Doctrine_Query::create();
        if (isset($aData['fields']))
            $campos = $aData['fields'];
        else
            $campos = '*';

        $query->from('Ficha f, f.Maestro maestro, maestro.Evaluaciones evaluaciones');
        $query->andWhere('f.maestro = 0 and f.publicado = 1');
        $query->addSelect($campos . ", AVG(evaluaciones.rating) as rating, COUNT(evaluaciones.ficha_id) as nrating");
        $query->groupBy("maestro.id");
        $query->orderBy("rating DESC, nrating DESC");

        if (isset($aData['limit']))
            $query->limit($aData['limit']);

        if (isset($aData['offset']))
            $query->offset($aData['offset']);

        $query->useResultCache(new Doctrine_Cache_Apc());
        $query->setResultCacheLifeSpan(600);

        $result = $query->execute();

        return $result;
    }

    function MasDestacadas($limit = False, $offset = False) {

        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Maestro maestro');
        $query->andWhere('f.maestro = 0 and f.publicado = 1 and f.destacado=1 AND f.tipo = 1');
        $query->orderBy('RAND()');

        if ($limit)
            $query->limit($limit);
        if ($offset)
            $query->offset($offset);

        $result = $query->execute();
        return $result;
    }
    function MasDestacadasEmpresa($limit = False, $offset = False) {

        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Maestro maestro');
        $query->andWhere('f.maestro = 0 and f.publicado = 1 and f.destacado=1');
        $query->andWhere('f.tipo=2 OR f.tipo=3');
        $query->orderBy('RAND()');

        if ($limit)
            $query->limit($limit);
        if ($offset)
            $query->offset($offset);
        //echo $query->getSqlQuery();
        $result = $query->execute();
        return $result;
    }

    public function FichasExterior($motivo, $limit = 9){
        // motivos: permamente = 1 | temporal = 2 | viaje = 3
        $conn = Doctrine_Manager::getInstance()->connection(); 
        
        $sql = "SELECT f.*, s.nombre as nombre_servicio FROM ficha f ";
        $sql .= "LEFT JOIN tramite_en_exterior t ON f.id = t.id_ficha ";
        $sql .= "LEFT JOIN servicio s ON f.servicio_codigo = s.codigo ";
        //indica la seccion a la que pertenece
        $sql .= "WHERE t.motivo_id = " . $motivo ." "; 
        //indica si es de exterior
        $sql .= "AND f.es_tramite_exterior = 1 ";
        //indica si es maestro y esta publicado
        $sql .= "AND f.maestro = 1 AND f.publicado = 1 ";
        $sql .= "ORDER BY f.created_at DESC ";
        $sql .= "LIMIT " . $limit;
        $result = $conn->execute($sql);
        return $result->fetchAll();
    }

    public function getFichaExport($aTmp) {
        $query = Doctrine_Query::create();
        $query->from('Ficha f, f.Maestro maestro');
        $query->Where('f.maestro = 1 and f.publicado = 1');
        $query->andWhere('correlativo=' . $aTmp[1]);
        $query->andWhere('servicio_codigo LIKE "' . $aTmp[0] . '"');
        //debug($query->getSqlQuery(), "red");
        $result = $query->execute(array(), DOCTRINE::HYDRATE_ARRAY);

        return $result;
    }

    public function findFormalidadBusqueda($set_de_fichas) {
        $query = Doctrine_Query::create();
        $query->select("f.id, f.formalizacion, COUNT(f.id) AS numero_fichas");
        $query->from('Ficha f');
        
        if ($set_de_fichas) {
            $query->where("f.id IN (" . $set_de_fichas . ")");
        } else {
            $query->where("f.id IN (0)");
        }

        $query->groupBy("f.id");
        $query->orderBy("f.formalizacion ASC");
        debug($query->getSqlQuery());
        return $query->execute();

    }

    public function findReqEspecialBusqueda($set_de_fichas) {
        $query = Doctrine_Query::create();
        $query->select("f.req_especial, COUNT(f.id) AS numero_fichas");
        $query->from('Ficha f');
        
        if ($set_de_fichas) {
            $query->where("f.id IN (" . $set_de_fichas . ")");
        } else {
            $query->where("f.id IN (0)");
        }

        $query->groupBy("f.id");
        $query->orderBy("f.req_especial ASC");
        //debug($query->getSqlQuery());
        return $query->execute();

    }

    /*Metodo de busqueda que usa la API*/
    public function apiSearch($query,$options){
        $CI=& get_instance();

        $offset=isset($options['offset'])?$options['offset']:0;
        $limit=isset($options['limit'])?$options['limit']:null;

        //Se hace la busqueda en Sphinx
        $CI->load->library('sphinxclient');
        $CI->sphinxclient->setServer($CI->config->item('sphinx_host'),(int)$CI->config->item('sphinx_port'));
        $CI->sphinxclient->SetFieldWeights(array('keywords' => 50, 'titulo' => 100, 'sic' => 50, 'objetivo' => 5));
        if($query){ //Si hau una busqueda, usamos el algoritmo para clasificar los resultados
            $CI->sphinxclient->SetMatchMode(SPH_MATCH_EXTENDED);
            $CI->sphinxclient->setRankingMode(SPH_RANK_EXPR, 'bm25 + 100*(sum(lcs*user_weight)/max_lcs) + 10*(hits/max_hits)');
        }else{  //Si no hay busqueda, simplement ordenamos por hits.
            $CI->sphinxclient->SetSortMode(SPH_SORT_ATTR_DESC,'hits');
        }
        $CI->sphinxclient->setLimits(0, 1000);



        //Preparo los terminos para enviarlos al sphinx (Para que haga busqueda ANY)
        $sphinx_query=trim(preg_replace('/[\-\+\'\"]+/', ' ', $query));     //Le quitamos los caracteres especiales de sphinx (- + " ')
        if($query){
            $query_arr=preg_split('/\s+/', $sphinx_query);
            foreach($query_arr as &$s)
                $s='('.$s.')';
            $sphinx_query=  implode(' | ', $query_arr);
        }

        //Hago la busqueda
        $result=$CI->sphinxclient->query($sphinx_query, 'redchile_fichas');

        //Se hace el match de los resultados de Sphinx con el modelo en Doctrine.
        $doctrine_query = Doctrine_Query::create()
            ->from('Ficha f')
            ->where('f.maestro = 0 AND f.publicado = 1');

        if ($result['total']>0) {
            $page_results=  array_slice($result['matches'],$offset ,$limit,TRUE);
            $matches = array_keys($page_results);
            if(!empty($matches)){
                $doctrine_query->whereIn('f.id', $matches);
                $doctrine_query->orderBy('FIELD (id, '.implode(',', $matches).')');
            }else{
                $doctrine_query->where('0');
            }
        } else {
            $doctrine_query->where('0');
        }

        $fichas = $doctrine_query->execute();
        $total_fichas = $result['total'];

        $result=new stdClass();
        $result->fichas=$fichas;
        $result->total=$total_fichas;

        return $result;
    }

}

?>