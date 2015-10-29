<div class="span4">
    <div id="sidebar" class="filtros-busqueda hidden-phone">
        <div class="filtros-header">
            <h2>
                Filtros
            </h2>
            <p class="instruccion">Para resultados más específicos.</p>
            <div class="clearfix"></div>
        </div>
        <div class="cont-form-filtros-busqueda">
            <?php if (isset($fichas) && count($fichas) > 0): ?>
                <?php if (isset($tramites) && count($tramites) > 0) { ?>
                    <h2 id="f_tramite" class="toggle filter_title lightblue-text">Canales</h2>
                    <ul id="tramite_filtro" class="text-small toggable">
                        <?php
                            if(!isset($hidden_filter_tramites)) $hidden_filter_tramites = array();
                            foreach ($tramites as $codigo_tramite => $tramite) {
                                $activo = in_array($codigo_tramite, $hidden_filter_tramites);
                        ?>
                            <li class="<?php echo $activo?'on':''; ?>">
                                <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('tramites', $codigo_tramite, $activo, true); ?>"><?php echo $tramite['nombre']; ?></a>
                                <span>(<?php echo $tramite['numero_fichas']; ?>)</span>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <?php
                /*
                if (isset($etapas_empresa) && count($etapas_empresa) > 0) {
                ?>
                <h2 id="f_etapa_empresa" class="toggle filter_title lightblue-text">Etapa Empresa</h2>
                <ul id="etapa_empresa" class="text-small toggable">
                    <?php
                    
                    if(!isset($filtro_etapa_empresa)) $filtro_etapa_empresa = array();
                    foreach($etapas_empresa as $a) {
                        $activo = in_array($a->id, $filtro_etapa_empresa);
                    ?>
                    <li class="<?php echo $activo?'on':''; ?>">
                        <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('etapa_empresa', $a->id, $activo, false) ?>"><?php echo $a->nombre; ?></a>
                        <?php
                        if(isset($a->numero_fichas)) {
                        ?>
                        <span>(<?php echo $a->numero_fichas; ?>)</span>
                        <?php
                        }
                        ?>
                    </li>
                    <?php
                    }
                    
                    ?>
                </ul>
                <?php
                }
                */
                /*
                if (isset($apoyos_estado) && count($apoyos_estado) > 0) {
                ?>
                <h2 id="f_apoyos" class="toggle filter_title lightblue-text">Apoyo estatal</h2>
                <ul id="apoyos_filtro" class="text-small toggable">
                    <?php
                    
                    if(!isset($filtro_apoyo_estado)) $filtro_apoyo_estado = array();
                    foreach($apoyos_estado as $a) {
                        $activo = in_array($a->id, $filtro_apoyo_estado);
                    ?>
                    <li class="<?php echo $activo?'on':''; ?>">
                        <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('apoyo_estado', $a->id, $activo, false) ?>"><?php echo $a->ee_nombre.' : '.$a->nombre; ?></a>
                        <span>(<?php echo $a->numero_fichas; ?>)</span>
                    </li>
                    <?php
                    }
                    
                    ?>
                </ul>
                <?php
                }
                */
                /*
                if (isset($eventos) && count($eventos) > 0) {
                ?>
                <h2 id="f_eventos" class="toggle filter_title lightblue-text">Eventos / Región</h2>
                <ul id="eventos" class="text-small toggable">
                    <?php
                    
                    if(!isset($filtro_evento)) $filtro_evento = array();
                    foreach($eventos as $a) {
                        $activo = in_array($a->id, $filtro_evento);
                    ?>
                    <li class="<?php echo $activo?'on':''; ?>">
                        <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('evento', $a->id, $activo, false) ?>"><?php echo $a->region_id; ?> región</a>
                        <span>(<?php echo $a->numero_fichas; ?>)</span>
                    </li>
                    <?php
                    }
                    
                    ?>
                </ul>
                <?php
                }
                */
                ?>
                <h2 id="f_temas" class="toggle filter_title lightblue-text">Temas</h2>
                <ul id="temas_filtro" class="text-small toggable">
                    <?php 
                    foreach ($temas as $tema) { 
                        $activo = in_array($tema->id, $filtro_temas);
                    ?>
                        <li class="<?php echo $activo?'on':''; ?>">
                            <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('temas', $tema->id, $activo, true); ?>"><?php echo $tema->nombre; ?></a>
                            <span>(<?php echo $tema->numero_fichas; ?>)</span>
                        </li>
                    <?php
                    }
                    /*
                    filtros emprendete
                    */
                    /*
                    if(!isset($filtro_tema_empresa)) $filtro_tema_empresa = array();

                    foreach ($temas_empresa as $te) {
                        $activo = in_array($te->id, $filtro_tema_empresa);
                    ?>
                    <li class="<?php echo $activo?'on':''; ?>">*
                        <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('tema_empresa', $te->id, $activo, false) ?>"><?php echo $te->nombre; ?></a>
                        <span>(<?php echo $te->numero_fichas; ?>)</span>
                    </li>
                    <?php
                    }
                    */
                    ?>
                </ul>
                <?php
                /*
                if (isset($tipos_empresa) && count($tipos_empresa) > 0) {
                ?>
                <h2 id="f_tamanio" class="toggle filter_title lightblue-text">Tamaño</h2>
                <ul id="tamanio_empresa" class="text-small toggable">
                    <?php
                    
                    if(!isset($filtro_tipo_empresa)) $filtro_tipo_empresa = array();
                    foreach($tipos_empresa as $a) {
                        $activo = in_array($a->id, $filtro_tipo_empresa);
                    ?>
                    <li class="<?php echo $activo?'on':''; ?>">
                        <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('tipo_empresa', $a->id, $activo, false) ?>"><?php echo $a->nombre; ?></a>
                        <span>(<?php echo $a->numero_fichas; ?>)</span>
                    </li>
                    <?php
                    }
                    
                    ?>
                </ul>
                <?php
                }
                */
                /*
                if (isset($formalidad) && count($formalidad) > 0) {
                    //print_r($filtro_formalizacion);
                ?>
                <h2 id="f_formalidad" class="toggle filter_title lightblue-text">Formalidad</h2>
                <ul id="formalidad" class="text-small toggable">
                    <?php
                    
                    if(!isset($filtro_formalizacion)) $filtro_formalizacion = array();
                    foreach($formalidad as $f) {
                        switch($f['nombre']) {
                            case 'Informal':
                                $val = 1;
                                break;
                            case 'Formal':
                                $val = 2;
                                break;
                        }
                        $activo = in_array($val, $filtro_formalizacion);
                    ?>
                    <li class="<?php echo $activo?'on':''; ?>">
                        <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('formalizacion', $val, $activo, false) ?>"><?php echo $f['nombre']; ?></a>
                        <span>(<?php echo $f['numero_fichas']; ?>)</span>
                    </li>
                    <?php
                    }
                    
                    ?>
                </ul>
                <?php
                }
                ?>
                <h2 id="f_fps" class="toggle filter_title lightblue-text">Ficha Protección Social</h2>
                <form action="<?php echo site_url('buscar/fichas') ?>" method="get">
                    <input type="text" name="fps" id="fps" value="<?php echo $fps ?>" placeholder="Ingrese su puntaje FPS">
                    <input type="hidden" name="e" value="<?php echo isset($empresa)?$empresa:0; ?>">
                </form>
                <?php
                */
                /*
                //actividad economica
                if (isset($rubros) && count($rubros) > 0) {
                    ?>
                    <h2 id="f_rubros" class="toggle filter_title lightblue-text">Actividad Económica</h2>
                    <ul id="rubros" class="text-small toggable">
                        <?php
                        
                        if(!isset($filtro_rubro)) $filtro_rubro = array();
                        foreach($rubros as $a) {
                            $activo = in_array($a->id, $filtro_rubro);
                        ?>
                        <li class="<?php echo $activo?'on':''; ?>">
                            <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('rubro', $a->id, $activo, false) ?>"><?php echo $a->nombre; ?></a>
                            <span>(<?php echo $a->numero_fichas; ?>)</span>
                        </li>
                        <?php
                        }
                        
                        ?>
                    </ul>
                    <?php
                }
                */
                /*
                //requsito especial
                if (isset($req_especial) && count($req_especial) > 0) {
                    ?>
                    <h2 id="f_req_especial" class="toggle filter_title lightblue-text">Requisito Especial</h2>
                    <ul id="req_especial" class="text-small toggable">
                        <?php
                        
                        if(!isset($filtro_req_especial)) $filtro_req_especial = array();
                        foreach($req_especial as $a) {
                            switch($a['nombre']) {
                                case 'Mujer':
                                    $val = 1;
                                    break;
                                case 'Indigena':
                                    $val = 2;
                                    break;
                            }
                            $activo = in_array($val, $filtro_req_especial);
                        ?>
                        <li class="<?php echo $activo?'on':''; ?>">
                            <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('req_especial', $val, $activo, false) ?>"><?php echo $a['nombre'] ?></a>
                            <span>(<?php echo $a['numero_fichas']; ?>)</span>
                        </li>
                        <?php
                        }
                        
                        ?>
                    </ul>
                    <?php
                }
                */
                ?>
                <?php if (isset($instituciones) && count($instituciones) > 0) { ?>
                  <h2 id="f_instituciones" class="toggle filter_title lightblue-text">Instituciones</h2>
                  <ul id='instituciones_filtro' class='text-small toggable'>
                    <?php 
                        foreach ($instituciones as $institucion){ 
                            $activo = in_array($institucion->codigo, $filtro_instituciones);
                    ?>
                        <li class="<?php echo $activo?'on':''; ?>">
                            <?php if ($institucion->sigla): ?>
                                <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('instituciones', $institucion->codigo, $activo, true); ?>"><?php echo $institucion->sigla; ?></a> <span>(<?php echo $institucion->numero_fichas; ?>)</span>
                                <p><?php echo $institucion->nombre; ?></p>
                            <?php else: ?>
                                <a class="<?php echo $activo?'on':''; ?>" href="<?php echo url_buscador('instituciones', $institucion->codigo, $activo, true); ?>"><?php echo $institucion->nombre.( ($institucion->sigla) ? ' ('.$institucion->sigla.')' : '' ); ?></a>
                                <span>(<?php echo $institucion->numero_fichas; ?>)</span>
                            <?php endif ?>
                        </li>
                    <?php } ?>
                  </ul>
                <?php } ?>
            <?php endif ?>
        </div>
    </div>
</div>