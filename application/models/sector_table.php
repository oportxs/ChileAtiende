<?php
class SectorTable extends Doctrine_Table{

    function porComuna() {
        $query= Doctrine_Query::create()
                ->from('Sector s')
                ->where('tipo LIKE ?','comuna')
                ->orderBy('lat DESC');

        return $query->execute();
    }

    public function findWithOptions($options = array())
    {
        $options['tipo'] = isset($options['tipo'])?$options['tipo']:'region';

        
        $query = Doctrine_Query::create()
            ->select('s.*')
            
            ->where('s.tipo = ?', $options['tipo'])
            ->groupBy('s.codigo');

        if($options['tipo']=='comuna'){
            $query->from('Sector s, s.Oficinas o');
            $query->having('COUNT(o.id) > 0');
        }

        if($options['tipo']=='region'){
            $query->from('Sector s, s.SectorHijos.SectorHijos.Oficinas o');
            $query->having('COUNT(o.id) > 0');
        }

        if($options['tipo']=='provincia'){
            $query->from('Sector s, s.SectorHijos.Oficinas o');
            $query->having('COUNT(o.id) > 0');
        }

        if(isset($options['orderby']))
            $query->orderBy($options['orderby']);
        else
            $query->orderBy('s.lat DESC');

        return $query->execute();
    }

}

?>
