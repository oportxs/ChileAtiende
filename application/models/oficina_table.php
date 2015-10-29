<?php
class OficinaTable extends Doctrine_Table{

    function ips() {
        $query= Doctrine_Query::create()
                ->from('Oficina o')
                ->where('servicio_codigo = ?','AL005');

        return $query->execute();
    }

    public function getUltimaActualizacion()
    {
        $query = Doctrine_Query::create()
                ->from('Oficina o')
                ->orderBy('updated_at DESC')
                ->limit(1);

        $resultado = $query->execute();
        return $resultado[0]->updated_at;
    }

    /*
     * Obtiene todas las oficinas
     */
    function allOficinas($options=array()) {
        $tipo = isset($options['tipo']) ? $options['tipo'] : 'personas';

        $query = Doctrine_Query::create()
                ->from('Oficina o')
                ->where('tipo = ?', $tipo);

        if (isset($options['limit']))
            $query->limit($options['limit']);

        if (isset($options['offset']))
            $query->offset($options['offset']);

        if(isset($options['order_by']))
            $query->orderBy($options['order_by']);

        if(isset($options['sector']))
            $query->andWhere('sector_codigo LIKE ?', $options['sector'].'%');

        // if(isset($options['tipo']))
        //     $query->where('tipo = ?', $options['tipo']);

        if(isset($options['justCount']))
            $resultado = $query->count();
        else
            $resultado = $query->execute();

        return $resultado;
    }

    function countTotal(){
        return Doctrine_Query::create()
                ->from('Oficina o')
                ->count();
    }

}

?>
