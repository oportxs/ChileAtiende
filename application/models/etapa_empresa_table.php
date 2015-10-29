<?php

class EtapaEmpresaTable extends Doctrine_Table {

	/*
    Obtiene los apoyos que tienen fichas asociadas
    */
    function getApoyosByEtapa($etapa_id=1) {
        $query = Doctrine_Query::create();
        $query->select('ee.id, ee.nombre, ae.id, ae.nombre');
        $query->from('EtapaEmpresa ee, ee.ApoyosEstado ae');
        $query->where('ee.id = ?', $etapa_id);
        $query->andwhere('ae.Fichas.maestro = 0 AND ae.Fichas.publicado = 1');
        $query->groupBy("ae.id");
        $query->orderBy("ae.nombre ASC");
        //echo $query->getSqlQuery();
        return $query->execute();
    }

    public function getHechosEmpresaByEtapa($etapa_id) {
        $query = Doctrine_Query::create();
        //$query->select('ee.id, ee.nombre, he.id, he.nombre');
        $query->from('EtapaEmpresa ee, ee.HechosEmpresa he');
        $query->where('ee.id = ?', $etapa_id);
        $query->andwhere('he.Fichas.maestro = 0 AND he.Fichas.publicado = 1');
        $query->groupBy("he.id");
        $query->orderBy("he.nombre ASC");
        //echo $query->getSqlQuery();
        return $query->execute();
    }

    public function DestacadosByEtapaHechosEmpresa($etapa_id) {
        $query = Doctrine_Query::create();
        $query->select('ee.id, ee.nombre, he.id, he.nombre, f.titulo, f.maestro_id, s.nombre');
        $query->from('EtapaEmpresa ee, ee.HechosEmpresa he, he.Fichas f, f.Servicio s');
        $query->where('ee.id = ? ', $etapa_id);
        $query->andwhere('f.maestro = 0 AND f.publicado = 1 AND f.destacado = 1 AND f.tipo IN (2,3)');
        // $query->groupBy("he.id");
        $query->orderBy("he.nombre ASC");
        //echo $query->getSqlQuery();
        return $query->execute(array(), Doctrine::HYDRATE_ARRAY);
    }

    public function DestacadosByEtapaApoyosEstado($etapa_id) {
        $query = Doctrine_Query::create();
        $query->select('ee.id, ee.nombre, ae.id, ae.nombre, f.titulo, f.maestro_id, s.nombre');
        $query->from('EtapaEmpresa ee, ee.ApoyosEstado ae, ae.Fichas f, f.Servicio s');
        $query->where('ee.id = ? ', $etapa_id);
        $query->andwhere('f.maestro = 0 AND f.publicado = 1 AND f.destacado = 1 AND f.tipo IN (2,3)');
        // $query->groupBy("f.id");
        $query->orderBy("ae.nombre ASC");
        // echo $query->getSqlQuery();
        return $query->execute(array(), Doctrine::HYDRATE_ARRAY);
    }

    /**
     * Funcion que implementa la busqueda de temas de fichas asociadas a la busqueda
     */
    function findEtapaEmpresaBusqueda($set_de_fichas) {

        $query = Doctrine_Query::create();
        $query->select("ee.id, ee.nombre, COUNT(ee.id) AS numero_fichas");
        $query->from('EtapaEmpresa ee, ee.HechosEmpresa he, he.Fichas f');
        
        if ($set_de_fichas) {
            $query->where("f.id IN (" . $set_de_fichas . ")");
        } else {
            $query->where("f.id IN (0)");
        }

        $query->groupBy("ee.id");
        $query->orderBy("ee.nombre ASC");
        //debug($query->getSqlQuery());
        return $query->execute();
    }

}