<?php
class ModuloAtencionTable extends Doctrine_Table {
    public function ModulosOrdenados() {
        $query = Doctrine_Query::create();
        $query->from('ModuloAtencion m');
        $query->OrderBy('sector_codigo ASC');
        
        $resultado = $query->execute();

        return $resultado;
    }
    public function getModuloActivo($codigo_modulo){
    	$aux = explode('-', $codigo_modulo); // 0 = sector_codigo, 1 = oficina_id, 2 = nro_maquina

    	$query = Doctrine_Query::create();
      $query->from('ModuloAtencion m');
      $query->Where('m.sector_codigo = ?',$aux[0]);
      $query->andWhere('m.oficina_id = ?',$aux[1]);
      $query->andWhere('m.nro_maquina = ?',$aux[2]);
      
      $resultado = $query->fetchOne();

      return $resultado;
    }
}
