<?php

class DiccionarioTable extends Doctrine_Table{
    
    public function corregirTexto($texto){
        $string_arr = explode(' ', $texto);
        foreach ($string_arr as &$s) {
            $dict=$this->findOneByTermino($s);
            if($dict)
                $s=$dict->definicion;

        }
        $suggest = implode(' ', $string_arr);
        
        return $suggest;
    }
    
}