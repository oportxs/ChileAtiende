<pre>
<?php
//var_dump($fichas->fichas->items->ficha)
?>
</pre>
<div class="pane">
    <ul>
        <?php
        $nroFicha = 1;
        foreach ($fichas->fichas->items->ficha as $f):
            if (!empty($f->cha_codigo)) {
                $aTmp = explode('-', $f->cha_codigo);
                $data = Doctrine::getTable('Ficha')->getFichaExport($aTmp);
                
                if (count($f->temas)) {
                    $cnt = 0;
                
                        if ($data[0]['id'] && (count($f->temas->tema))) {
                            
                            $ficha = Doctrine::getTable('Ficha')->find($data[0]['id']);
                            $ficha->setTemasEmpresaFromArray($f->temas->tema);
                            /*
                            $ficha->save();
                            $ficha->generarVersion();
                            $ficha->publicar();
                            /**/
                            
                        }

                }
                
                if (count($f->hechos)) {
                    $cnt = 0;
                    
                        
                        if ($data[0]['id'] && (count($f->hechos->hecho))) {
                            
                            $ficha = Doctrine::getTable('Ficha')->find($data[0]['id']);
                            $ficha->setHechosEmpresaFromArray($f->hechos->hecho);
                            /*
                            $ficha->save();
                            $ficha->generarVersion();
                            $ficha->publicar();
                            /**/
                        }

                }
                
                if (count($f->apoyos_estado)) {
                    $cnt = 0;
                    
                        
                        if ($data[0]['id'] && (count($f->apoyos_estado->apoyo))) {
                            
                            $ficha = Doctrine::getTable('Ficha')->find($data[0]['id']);
                            $ficha->setApoyosFromArray($f->apoyos_estado->apoyo);
                            /*
                            $ficha->save();
                            $ficha->generarVersion();
                            $ficha->publicar();
                            /**/
                        }
                        
                        
                    
                }

                echo '</li>';
                
            }
            $nroFicha++;
        endforeach;
        ?>
    </ul>
    <?php
    if(isset($fichas->fichas->nextPageToken)) {
    ?>
    <a href="<?=site_url('backend/mantenimiento/getFichasEmprendete?pageToken='.$fichas->fichas->nextPageToken)?>">Siguiente</a>
    <?php
    }
    ?>
</div>