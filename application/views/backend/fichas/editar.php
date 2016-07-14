<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/' . ( ($flujo) ? 'fichas/listarflujos' : 'fichas' )) ?>"><?= ($flujo) ? 'Flujos' : 'Fichas' ?></a> »
    <span>Editar <?= ($flujo) ? 'Flujo' : 'Ficha' ?> #<?= $ficha->id ?></span>
</div>

<div class="pane">

    <?php $this->load->view('backend/fichas/menu', array('tab' => 'editar')) ?>

    <h2>Edición <?= ($flujo) ? 'flujo' : 'ficha' ?></h2>

    <form class="ajaxForm" method="post" action="<?= site_url('backend/fichas/' . $nombreform . '/' . $ficha->id) ?>">
        <fieldset>
            <legend><?= $ficha->titulo ?></legend>

            <div class="validacion"></div>
            <table class="formTable">

                <?php if(UsuarioBackendSesion::usuario()->tieneRol(array('metaficha')) && !$flujo): ?>
                <tr>
                    <td class="titulo">MetaFicha <span class="red">*</span></td>
                    <td>
                        <label><input type="radio" name="metaficha" id="metaficha_si" value="1" <?= $ficha->metaficha == 1 ? 'checked="checked"' : ''; ?>/> Si</label>
                        <label><input type="radio" name="metaficha" id="metaficha_no" value="0" <?= $ficha->metaficha == 0 ? 'checked="checked"' : ''; ?>/> No</label>
                    </td>
                </tr>
                <?php else: ?>
                <input type="hidden" name="metaficha" value="0"/>
                <?php endif; ?>

                <?php if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) { ?>
                    <tr id="fecha" style="display: table-row;">
                        <td class="titulo"><label for="postulacion_start">Fecha de actualización <span class="red">*</span></label></td>
                        <td>
                            <?php $updatedDate = ($ficha->updated_data_at)? $ficha->updated_data_at : $ficha->updated_at; ?>
                            <input type="text" name="updated_data_at" class="fecha_de_actualizacion" readonly="readonly" value="<?php echo strftime('%d-%m-%Y', mysql_to_unix($updatedDate)); ?>" placeholder="24-02-2013" />
                            <div class="error_date" style="color: red; display: none;">Debe elegir un periodo válido para la fecha</div>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="titulo">Servicio <span class="red">*</span></td>
                    <td>
                        <select data-placeholder="Seleccione un Servicio" name="servicio_codigo" class="chzn-select">
                            <option value=""></option>
                            <?php
                            foreach ($servicios as $servicio) {
                                echo '<option value="' . $servicio->codigo . '" ' . ( ($ficha->servicio_codigo == $servicio->codigo) ? 'selected="selected"' : '' ) . '>' . $servicio->nombre . '</option>';
                            }
                            ?>
                        </select>

                    </td>
                </tr>
                <td class="titulo">Código <span class="red">*</span></td>
                <td>
                    <input size="6" type="text" disabled="disabled" value="<?= $ficha->Servicio->codigo ?>" /> - <input size="6" name="correlativo" type="text" value="<?= $ficha->correlativo ?>" />
                </td>

                <?php
                
                $metaficha_campos = unserialize($ficha->metaficha_campos);
                
                //debug($metaficha_campos);
                // INFO: en caso de que las fichas sean anteriores a las metafichas, unserialize va a devolver FALSE
                $metaficha_campos = $metaficha_campos ? $metaficha_campos : array(
                        'cc_observaciones' => 1,
                        'beneficiarios' => 1,
                        'doc_requeridos' => 1,
                        'guia_online' => 1,
                        'guia_online_url' => 1,
                        'guia_oficina' => 1,
                        'guia_telefonico' => 1,
                        'guia_correo' => 1,
                        'guia_chileatiende' => 1,
                        'plazo' => 1,
                        'vigencia' => 1,
                        'costo' => 1,
                        'informacion_multimedia' => 1,
                        'marco_legal' => 1,
                        'guia_consulado' => 1
                    );

                //Agrego a los default para inicializarlo
                $metaficha_campos['guia_chileatiende'] = 1;

                $metaficha_opciones = unserialize($ficha->metaficha_opciones);
                $metaficha_servicios = unserialize($ficha->metaficha_servicios);
                $metaficha_servicios = $metaficha_servicios === false ? array() : $metaficha_servicios;
                $_metaficha_servicios_options = array();
                $_metaficha_servicios_options[] = array('value' => "", 'label' => "");
                foreach($subficha_servicios as $servicio_codigo => $servicio_nombre)
                    $_metaficha_servicios_options[] = array('value' => $servicio_codigo, 'label' => $servicio_nombre, 'selected' => in_array($servicio_codigo, $metaficha_servicios) ? true : false );

                if (isset($flujo) && ($flujo)) {
                    $campos = array(
                        array(  'label' => "Nombre del Flujo", 
                                'relevant' => 'true', 
                                'field' => 'titulo', 
                                'type' => 'input'
                        ),
                        array(  'label' => "Resumen", 
                                'id' => 'editorA', 
                                'relevant' => 'true', 
                                'field' => 'objetivo', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Servicios que deben completar el Flujo",
                                'tr_class' => 'metaficha_display',
                                'field' => 'metaficha_servicios[]',
                                'type' => 'select',
                                'type_class' => 'chzn-select',
                                'type_extra' => 'multiple style="width:550px;"',
                                'options' => $_metaficha_servicios_options
                        ),
                        array(  'label' => "Contenido", 
                                'id' => 'editorB', 
                                'field' => 'beneficiarios', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Recuerda", 
                                'id' => 'editorD', 
                                'field' => 'vigencia', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Marco Legal", 
                                'id' => 'editorE', 
                                'field' => 'marco_legal', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Trámite en Consulado", 
                                'id' => 'editorT', 
                                'field' => 'guia_consulado', 
                                'type' => 'textarea'
                        )
                    );
                } else {

                    $camposPre = array(
                        array(  'label' => "Nombre del Trámite", 
                                'relevant' => 'true', 
                                'field' => 'titulo', 
                                'type' => 'input'
                        )
                    );

                    if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
                        $camposPre[] =
                            array(  'label' => "Resumen", 
                                    'id' => 'editorN', 
                                    'field' => 'resumen', 
                                    'type' => 'textarea'
                            );
                    }

                    $campos = array_merge($camposPre, array(
                        array(  'label' => "Descripción", 
                                'id' => 'editorA', 
                                'relevant' => 'true', 
                                'field' => 'objetivo', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Criterio para categorizar las SubFichas",
                                'relevant' => 'true',
                                'tr_class' => 'metaficha_display',
                                'field' => 'metaficha_categoria',
                                'type' => 'select',
                                'type_class' => 'chzn-select',
                                'type_extra' => 'style="width:550px;" data-placeholder="Seleccione un criterio"',
                                'options' => array( 
                                    array('value' => "", 'label' => ""), 
                                    array('value' => "region-comuna", 'label' => "Región-Comuna", 'selected' => $metaficha_opciones['categoria'] == "region-comuna" ? true : false),
                                    array('value' => "servicio-alfabetico", 'label' => "Alfabético", 'selected' => $metaficha_opciones['categoria'] == "servicio-alfabetico" ? true : false),
                                    array('value' => "entidad-servicio", 'label' => "Entidad-Servicio", 'selected' => $metaficha_opciones['categoria'] == "entidad-servicio" ? true : false)
                                )
                        ),
                        array(  'label' => "Servicios que deben completar el Tramite",
                                'tr_class' => 'metaficha_display',
                                'field' => 'metaficha_servicios[]',
                                'type' => 'select',
                                'type_class' => 'chzn-select',
                                'type_extra' => 'multiple style="width:550px;" data-placeholder="Seleccione un Servicio"',
                                'options' => $_metaficha_servicios_options
                        ),
                        array(  'label' => '¿Hay instituciones que no publican en el portal?',
                                'tr_class' => 'metaficha_display',
                                'field' => 'metaficha_servicios_no_publican',
                                'type' => 'radio',
                                'options' => array(
                                    array('id' => '', 'value' => '1', 'label' => 'Si', 'checked' => $metaficha_opciones['servicios_no_publican'] == 1 ? 'checked="checked"' : ''),
                                    array('id' => '', 'value' => '0', 'label' => 'No', 'checked' => $metaficha_opciones['servicios_no_publican'] == 0 ? 'checked="checked"' : '')
                                )
                        ),
                        array(  'label' => "Detalles", 
                                'id' => 'editorL', 
                                'field' => 'cc_observaciones', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Beneficiarios", 
                                'id' => 'editorB', 
                                'field' => 'beneficiarios', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Documentos Requeridos", 
                                'id' => 'editorG', 
                                'field' => 'doc_requeridos', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Trámite Online", 
                                'id' => 'editorH', 
                                'field' => 'guia_online', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Url Trámite Online", 
                                'field' => 'guia_online_url', 
                                'type' => 'input'
                        ),
                        array(  'label' => "Trámite Oficina", 
                                'id' => 'editorI', 
                                'field' => 'guia_oficina', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Nombre de la oficina", 
                                'field' => 'guia_oficina_nombre', 
                                'type' => 'input'
                        ),
                        array(  'label' => "Trámite Telefónico", 
                                'id' => 'editorJ', 
                                'field' => 'guia_telefonico', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Trámite Carta", 
                                'id' => 'editorK', 
                                'field' => 'guia_correo', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Trámite Oficina ChileAtiende", 
                                'id' => 'editorO', 
                                'field' => 'guia_chileatiende', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Tiempo de Realización", 
                                'id' => 'editorF', 
                                'field' => 'plazo', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Vigencia", 
                                'id' => 'editorD', 
                                'field' => 'vigencia', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Costo", 
                                'id' => 'editorC', 
                                'field' => 'costo', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Infografía, audio y video", 
                                'id' => 'editorM', 
                                'field' => 'informacion_multimedia', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Marco Legal", 
                                'id' => 'editorE', 
                                'field' => 'marco_legal', 
                                'type' => 'textarea'
                        ),
                        array(  'label' => "Trámite en Consulado", 
                                'id' => 'editorT', 
                                'field' => 'guia_consulado', 
                                'type' => 'textarea'
                        )
                    )
                    );
                }

                $comentarios = json_decode($ficha->comentarios, true);

                foreach ($campos as $campo) {

                    if(isset($campo['tr_class']) && $campo['tr_class'] == "metaficha_display")
                        echo '<tr class="'.$campo['tr_class'].'" style="display: '.($ficha->metaficha ? 'table-row':'none').';">';
                    else
                        echo '<tr>';
                    if (isset($comentarios[$campo['field']]) && $comentarios[$campo['field']]) {
                        echo "<td class='titulo ttip' title='<div class=\"tooltip_content\">Comentario de la revisión anterior para " . $campo['label'] . ": <br/><br/>" . $comentarios[$campo['field']] . " </div>'>";
                        echo "<img src='" . base_url('assets/images/comment.png') . "' />";
                    } else {
                        echo "<td class='titulo'>";
                    }
                    echo $campo['label'];
                    if (isset($campo['relevant']) && $campo['relevant'] == true) {
                        echo "<span class='red'>*</span>";
                    }
                    if ($metaficha_campos && array_key_exists($campo['field'], $metaficha_campos)) {
                        echo '<br />
                            <div class="metaficha_display" style="display: '.($ficha->metaficha ? 'block':'none').';">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_'.$campo['field'].'" value="1" '.($metaficha_campos[$campo['field']] ? 'checked':'').'/> Si</label>
                                <label><input type="radio" name="metaficha_'.$campo['field'].'" value="0" '.($metaficha_campos[$campo['field']] ? '':'checked').'/> No</label>
                            </div>';
                    }
                    echo "</td>";
                    
                    echo "<td>";

                    if ($campo['type'] == 'input') {
                        echo "<input type='text' name='" . $campo['field'] . "' size='65' value='" . $ficha->$campo['field'] . "' />";
                    } 
                    elseif ($campo['type'] == 'radio') 
                    {
                        foreach($campo['options'] as $option){
                            $checked = isset($option['checked']) ? $option['checked'] :
                                ($ficha->$campo['field'] == $option['value'] ? 'checked="checked"' : '');
                        
                            echo '<label><input type="radio" name="'.$campo['field'].'" id="'.$option['id'].'" value="'.$option['value'].'" '.$checked.'/> '.$option['label'].'</label>';
                        }
                    } 
                    elseif ($campo['type'] == 'select') 
                    {
                        echo '<select name="'.$campo['field'].'" '.(isset($campo['type_class']) ? 'class="'.$campo['type_class'].'"' : '').' '.(isset($campo['type_extra']) ? $campo['type_extra'] : '').' >';
                        echo '<option value=""></option>';
                        foreach($campo['options'] as $option)
                            echo '<option value="'.$option['value'].'" '.(isset($option['selected']) && $option['selected']?'selected="selected"':'').'>'.$option['label'].'</option>';
                        echo '</select>';
                        
                        // INFO se agrega alerta para prevenir que se seleccione la categoria si las instituciones no estan previamente configuradas con un sector
                        if($campo['field'] == 'metaficha_categoria')
                            echo '
                        <br />
                        <div id="metaficha_categoria_msg" class="input_warn_msg">La opción Región-Comuna debe ser utilizada sólo cuando todas las instituciones que completarán subfichas son municipios.</div>
                        ';

                    } 
                    else 
                    {
                        echo "<textarea id='" . $campo['id'] . "' name='" . $campo['field'] . "' cols='65' rows='15'>" . $ficha->$campo['field'] . "</textarea>";
                    }
                    echo "<div class='comentario_wrap'>";
                    echo "<span class='comentario'>Clic aquí para comentar respecto a los cambios de " . $campo['label'] . "</span>";
                    
                    $_txtpos = strpos($campo['field'],'[');
                    $_txt = substr($campo['field'], 0, $_txtpos != FALSE ? $_txtpos : strlen($campo['field']));
                    echo "<textarea class='comentario_texto' name='comentario[" . $_txt . "]' cols='65' rows='5'>";

                    echo "</textarea>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </fieldset>

        <fieldset>
            <legend>Clasificación</legend>
            <table class="formTable">
                <tr>
                    <td class="titulo">Público objetivo</td>
                    <td>
                        <label><input type="radio" name="tipo" id="personas" value="1" <?= ($ficha->tipo == 1 || !$ficha->tipo) ? 'checked="checked"' : '' ?> /> Personas</label>
                        <label><input type="radio" name="tipo" id="empresas" value="2" <?= ($ficha->tipo == 2) ? 'checked="checked"' : '' ?> /> Empresas</label>
                        <label><input type="radio" name="tipo" id="ambos" value="3" <?= ($ficha->tipo == 3) ? 'checked="checked"' : '' ?> /> Ambos</label>
                    </td>
                </tr>
            </table>
            <div id="clasificacion-personas" style="<?= ($ficha->tipo == 1 || $ficha->tipo == 3 || $ficha->tipo == 0) ? 'display:block' : 'display:none' ?>">
                <table class="formTable">
                    <tr>
                        <td class="titulo">Rangos de Edad</td>
                        <td>
                            <input type="text" name="rangos" value="<?= $ficha->showRangosAsString()?$ficha->showRangosAsString():'' ?>" /> Ej: 15-30,40-65
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo">Género</td>
                        <td>
                            <select data-placeholder="Seleccione el Género" name="genero" class="chzn-select" style="width: 300px;">
                                <option value=""></option>
                                <?php
                                foreach ($generos as $genero) {
                                    echo '<option value="' . $genero->id . '" ' . ( ($ficha->genero_id == $genero->id) ? 'selected="selected"' : '' ) . '>' . $genero->nombre . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo">Temas</td>
                        <td>
                            <select data-placeholder="Seleccione su(s) Tema(s)" name="temas[]" multiple class="chzn-select" style="width:550px;">
                                <?php foreach ($temas as $tema): ?>
                                    <option value="<?= $tema->id ?>" <?php
                                if ($ficha->hasTema($tema->id))
                                    echo 'selected="selected"'
                                        ?> ><?= $tema->nombre ?></option>
                                        <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="titulo">Hechos de Vida</td>
                        <td class="widgetSelectTable">
                            <select class="chzn-select" data-placeholder="Seleccionar hecho de vida" style="width: 300px;">
                                <option></option>
                                <?php foreach ($etapasvida as $e): ?>
                                    <optgroup label="<?= $e->nombre ?>">
                                        <?php
                                        foreach ($e->HechosVida as $h):
                                            ?>
                                            <?php
                                            $eta = ' ( ';
                                            foreach ($etapasvida as $etapa):
                                                if ($h->hasEtapa($etapa->id))
                                                    $eta .= $etapa->nombre . ' ';
                                            endforeach;
                                            $eta .= ')';
                                            ?>
                                            <option value="<?= $h->id ?>" otro="<?= $h->nombre . $eta ?>"><?= $h->nombre ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </optgroup>

                                <?php endforeach; ?>
                            </select>
                            <input type="button" value="Agregar" class="agregar" />

                            <table id="tablaHV" style="border: 1px solid #ccc; margin-top: 5px;">
                                <thead>
                                    <tr>
                                        <td style="background-color:#e1e1e1; font-weight: bold; text-align: center;">Hecho de la Vida</td>
                                        <td style="background-color:#e1e1e1; font-weight: bold;">Acción</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 1;
                                    foreach ($ficha->HechosVida as $h):
                                        $color = ($cnt & 1) ? '#FFF' : '#EDEDED';
                                        ?>
                                        <tr style="background-color: <?= $color ?>">
                                            <td>
                                                <span style="font-weight: bold;"><?= $h->nombre ?></span>
                                                <?php
                                                $eta = '( ';
                                                foreach ($etapasvida as $etapa):
                                                    if ($h->hasEtapa($etapa->id))
                                                        $eta .= $etapa->nombre . ' ';
                                                endforeach;
                                                $eta .= ')';
                                                echo $eta;
                                                ?>
                                                <input type="hidden" name="hechosvida[]" value="<?= $h->id ?>" />
                                            </td>
                                            <td><a class="eliminar" href="#">Eliminar</a></td>
                                        </tr>
                                        <?php
                                        $cnt++;
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <!-- chilenos en el extranjero -->
                <div class="tramite-exterior">
                    <table class="formTable">
                        <tr>
                            <td>
                                <input type="checkbox" name="exterior" id="chkbox_exterior" <?php if($ficha->isTramiteExterior()) print "checked";?>/>
                                <label for="chkbox_exterior">Para chilenos en el exterior</label>
                            </td>
                        </tr>
                    </table>
                    <div class="tipos-exterior">
                        <table class="formTable">
                            <tr>
                                <td>
                                    <label for="chkbox_exterior">Para chilenos </label>
                                </td>
                                <td>
                                    <select class="chzn-select" 
                                            data-placeholder="Seleccionar un motivo de estadía en el exterior" 
                                            multiple 
                                            name="tipo_residente[]" 
                                            id="tipo_residente" 
                                            <?php if(!$ficha->isTramiteExterior()) print 'disabled="disabled"';?>
                                            style="width: 350px;">
                                        <option value></option>
                                        <?php foreach($motivos_en_exterior as $key=>$value):?>
                                        <option value="<?=$value?>" <?php if($ficha->checkMotivosSelected($value)) print "selected";?>><?=$value?></option>
                                        <?php endforeach;?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="checkbox" name="exterior_destacado" id="chkbox_exterior_destacado" 
                                        <?php if($ficha->isTramiteExteriorDestacado()) print "checked";?>
                                        <?php if(!$ficha->isTramiteExterior()) print 'disabled="disabled"';?>
                                        />
                                    <label for="chkbox_exterior">Destacado en la portada de <strong>ChileAtiende en el Exterior</strong></label>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- fin chilenos en el extranjero -->
            </div>
            <table class="formTable">
                <tr>
                    <td class="titulo">Tags</td>
                    <td>
                        <ul style="width: 535px;" class="tagitTags">
                            <?php foreach ($ficha->Tags as $tag): ?>
                                <li class="tagit-choice">
                                    <?= $tag->nombre ?>
                                    <a class="close">x</a>
                                    <input type="hidden" name="tags[]" value="<?= $tag->nombre ?>" />
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </td>
                </tr>
            </table>
        </fieldset>

        <fieldset id="clasificacion-emprendete" style="<?=($ficha->tipo==2 || $ficha->tipo==3)? 'display:block;' : 'display:none;'?>">
            <legend>Clasificación ChileAtiende Pymes</legend>
            <table class="formTable">
                <tr>
                    <td class="titulo">Aprende sobre</td>
                    <td class="widgetSelectTableAS">
                        <select class="chzn-select" data-placeholder="Seleccione una etapa de la empresa" style="width: 300px;">
                            <option></option>
                            <?php foreach ($etapasempresa as $ee): ?>
                                <optgroup label="<?= $ee->nombre ?>">
                                    <?php
                                    foreach ($ee->HechosEmpresa as $he):
                                        ?>
                                        <?php
                                        $eta = ' ( ';
                                        foreach ($etapasempresa as $etapa):
                                            if ($he->hasEtapaEmpresa($etapa->id))
                                                $eta .= $etapa->nombre . ' ';
                                        endforeach;
                                        $eta .= ')';
                                        ?>
                                        <option value="<?= $he->id ?>" otro="<?= $he->nombre . $eta ?>"><?= $he->nombre ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </optgroup>

                            <?php endforeach; ?>
                        </select>
                        <input type="button" value="Agregar" class="agregar" />

                        <table id="tablaHV" style="border: 1px solid #ccc; margin-top: 5px;">
                            <thead>
                                <tr>
                                    <td style="background-color:#e1e1e1; font-weight: bold; text-align: center;">Hecho de la Empresa</td>
                                    <td style="background-color:#e1e1e1; font-weight: bold;">Acción</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = 1;
                                foreach ($ficha->HechosEmpresa as $he):
                                    $color = ($cnt & 1) ? '#FFF' : '#EDEDED';
                                    ?>
                                    <tr style="background-color: <?= $color ?>">
                                        <td>
                                            <span style="font-weight: bold;"><?= $he->nombre ?></span>
                                            <?php
                                            $eta = '( ';
                                            foreach ($etapasempresa as $etapa):
                                                if ($he->hasEtapaEmpresa($etapa->id))
                                                    $eta .= $etapa->nombre . ' ';
                                            endforeach;
                                            $eta .= ')';
                                            echo $eta;
                                            ?>
                                            <input type="hidden" name="hechosempresa[]" value="<?= $he->id ?>" />
                                        </td>
                                        <td><a class="eliminar" href="#">Eliminar</a></td>
                                    </tr>
                                    <?php
                                    $cnt++;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="titulo">Categoría</td>
                    <td>
                        <select data-placeholder="Seleccione su(s) categoría(s)" name="temas_empresa[]" multiple class="chzn-select" style="width:550px;">
                            <?php foreach ($temasempresa as $te): ?>
                                <option value="<?= $te->id ?>" 
                                <?php
                                if ($ficha->hasTemaEmpresa($te->id))
                                    echo 'selected="selected"'
                                    ?> 
                                        ><?= $te->nombre ?></option>
                                    <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="titulo">Apoyo estatal</td>
                    <td class="widgetSelectTableAE">
                        <select class="chzn-select" data-placeholder="Seleccione un apoyo estatal" style="width: 300px;">
                            <option></option>
                            <?php foreach ($etapasempresa as $e): ?>
                            <optgroup label="<?= $e->nombre ?>">
                                <?php
                                foreach ($e->ApoyosEstado as $ae):
                                    ?>
                                    <?php
                                    $eta = ' ( ';
                                    foreach ($etapasempresa as $etapa):
                                        if ($ae->hasEtapaEmpresa($etapa->id))
                                            $eta .= $etapa->nombre . ' ';
                                    endforeach;
                                    $eta .= ')';
                                    ?>
                                    <option value="<?= $ae->id ?>" otro="<?= $ae->nombre . $eta ?>"><?= $ae->nombre ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </optgroup>
                            <?php endforeach; ?>
                        </select>
                        <input type="button" value="Agregar" class="agregar" />

                        <table id="tablaAE" style="border: 1px solid #ccc; margin-top: 5px;">
                            <thead>
                                <tr>
                                    <td style="background-color:#e1e1e1; font-weight: bold; text-align: center;">Apoyo estatal</td>
                                    <td style="background-color:#e1e1e1; font-weight: bold;">Acción</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = 1;
                                foreach ($ficha->ApoyosEstado as $ae):
                                    $color = ($cnt & 1) ? '#FFF' : '#EDEDED';
                                    ?>
                                    <tr style="background-color: <?= $color ?>">
                                        <td>
                                            <span style="font-weight: bold;"><?= $ae->nombre ?></span>
                                            <?php
                                            $eta = '( ';
                                            foreach ($etapasempresa as $etapa):
                                                if ($ae->hasEtapaEmpresa($etapa->id))
                                                    $eta .= $etapa->nombre . ' ';
                                            endforeach;
                                            $eta .= ')';
                                            echo $eta;
                                            ?>
                                            <input type="hidden" name="apoyosestado[]" value="<?= $ae->id ?>" />
                                        </td>
                                        <td><a class="eliminar" href="#">Eliminar</a></td>
                                    </tr>
                                    <?php
                                    $cnt++;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="titulo"><label for="venta_anual">Ventas anuales</label></td>
                    <td>
                        <?php
                        $cnt_tipos = 0;
                        $cnt_ficha_tipos = 0;
                        foreach ( $tipos_empresa as $te ) {
                            if($ficha->hasTipoEmpresa($te->id)) $cnt_ficha_tipos++;
                            $cnt_tipos++;
                        }
                        $venta_anual_sel = ($cnt_tipos==$cnt_ficha_tipos) ? true : false;
                        ?>
                        <input type="radio" name="venta_anual_sel" id="venta-anual-todos" value="1" <?php echo ($venta_anual_sel) ? 'checked="checked"' : '' ?>><label for="venta-anual-todos">Todos</label>
                        <input type="radio" name="venta_anual_sel" id="venta-anual-especifico" value="0" <?php echo (!$venta_anual_sel) ? 'checked="checked"' : '' ?>><label for="venta-anual-especifico">Específico</label>
                        
                        <div class="venta_anual-select" style="<?php echo ($venta_anual_sel) ? 'display:none' : 'display:block' ?>">
                            <select data-placeholder="Seleccione tamaño empresa" name="venta_anual[]" id="venta_anual" class="chzn-select" style="width:480px;" multiple>
                                <option value=""></option>
                                <?php
                                foreach ( $tipos_empresa as $te ) {
                                    ?>
                                    <option value="<?php echo $te->id ?>" <?php echo ($ficha->hasTipoEmpresa($te->id)) ? 'selected=selected' : '' ?>><?php echo $te->nombre ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="titulo"><label for="formalizacion">Formalidad</label></td>
                    <td>
                        <!--
                        <input type="radio" name="formalidad_sel" id="formalidad-todos" value="1"><label for="formalidad-todos">Todos</label>
                        <input type="radio" name="formalidad_sel" id="formalidad-especifico" value="0"><label for="formalidad-especifico">Específico</label>
                        -->
                        <div class="formalidad-select">
                            <select data-placeholder="Seleccione tipo de formalidad" name="formalizacion" id="formalizacion" class="chzn-select" style="width:300px;">
                                <option value=""></option>
                                <option value="">Cualquiera</option>
                                <option value="1" <?= ($ficha->formalizacion == 1) ? 'selected=selected' : '' ?>>Informal</option>
                                <option value="2" <?= ($ficha->formalizacion == 2) ? 'selected=selected' : '' ?>>Formal</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="titulo"><label for="fps">Ficha de Protección Social</label></td>
                    <td>
                        <input class="fps" type="radio" name="fps" value="0" <?= (!$ficha->fps) ? 'checked=checked' : '' ?>> No
                        <input class="fps" type="radio" name="fps" value="1" <?= ($ficha->fps) ? 'checked=checked' : '' ?>> Si
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <label for="puntaje_fps_min">Puntaje mínimo
                            <input type="text" size="6" maxlength="6" name="puntaje_fps_min" id="puntaje_fps_min" value="<?php echo ($ficha->fps) ? $ficha->puntaje_fps_min : '2000' ?>" placeholder="ej: 100" <?= (!$ficha->fps) ? 'disabled="disabled"' : '' ?> /> - 
                        </label>
                        <label for="puntaje_fps_max">Puntaje máximo
                            <input type="text" size="6" maxlength="6" name="puntaje_fps_max" id="puntaje_fps_max" value="<?php echo ($ficha->fps) ? $ficha->puntaje_fps_max : '20000' ?>" placeholder="ej: 500" <?= (!$ficha->fps) ? 'disabled="disabled"' : '' ?> />
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="titulo"><label for="rubro">Actividad económica</label></td>
                    <td>
                        <?php 
                        $nro_rubros = $nro_rubros_ficha = 0;
                        foreach ($rubros as $r):
                            if ($ficha->hasRubro($r->id)) {
                                $nro_rubros_ficha++;
                            }
                            $nro_rubros++;
                        endforeach;
                        ?>
                        <input type="radio" name="rubro_sel" id="rubro-todos" value="1" <?php echo ($nro_rubros == $nro_rubros_ficha) ? 'checked="checked"' : '' ?>><label for="rubro-todos">Todos</label>
                        <input type="radio" name="rubro_sel" id="rubro-especifico" value="0" <?php echo ($nro_rubros != $nro_rubros_ficha) ? 'checked="checked"' : '' ?>><label for="rubro-especifico">Específico</label>
                        <div class="rubro-select" style="<?php echo ($nro_rubros != $nro_rubros_ficha) ? 'display:block' : 'display:none' ?>">
                            <select data-placeholder="Seleccione el(los) rubro(s)" id="rubro" name="rubro[]" multiple class="chzn-select" style="width:550px;">
                                <?php foreach ($rubros as $r): ?>
                                    <option value="<?= $r->id ?>" <?php
                                if ($ficha->hasRubro($r->id))
                                    echo 'selected="selected"'
                                        ?> ><?= $r->nombre ?></option>
                                        <?php endforeach; ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="titulo"><label for="req_especial">Postulantes</label></td>
                    <td>
                        <select data-placeholder="Seleccione un requisito" name="req_especial" id="req_especial" class="chzn-select" style="width:300px;">
                            <option value=""></option>
                            <option value="">Ninguno</option>
                            <option value="1" <?php echo ($ficha->req_especial == 1) ?  'selected="selected"' : ''; ?>>Mujer</option>
                            <option value="2" <?php echo ($ficha->req_especial == 2) ?  'selected="selected"' : ''; ?>>Indígena</option>
                            <option value="3" <?php echo ($ficha->req_especial == 3) ?  'selected="selected"' : ''; ?>>Asociaciones empresariales</option>
                        </select>
                    </td>
                </tr>
            </table>
        </fieldset>

        <?php if (isset($editar_ext) && $editar_ext): ?>
        <fieldset>
            <legend>Clasificación Adicional</legend>
            <table class="formTable">
                <tr>
                    <td class="titulo">Destacada?</td>
                    <td><input type="checkbox" name="destacado" <?= ($ficha->destacado) ? 'checked="checked"' : '' ?> /></td>
                </tr>
                <tr>
                    <td class="titulo">Keywords</td>
                    <td>
                        <input style="width: 535px;" type="text" name="keywords" value="<?= $ficha->keywords ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="titulo">Sic</td>
                    <td>
                        <input style="width: 535px;" type="text" name="sic" value="<?= $ficha->sic ?>" />
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php else: ?>
            <input type="hidden" name="destacado" value="<?= ($ficha->destacado) ? 'on' : '' ?>" />
            <input type="hidden" name="keywords" value="<?= $ficha->keywords ?>" />
            <input type="hidden" name="sic" value="<?= $ficha->sic ?>" />
        <?php endif; ?>

        <?php
        if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
            if ($ficha->cc_id || $ficha->cc_formulario || $ficha->cc_llavevalor) {
                ?>
                <fieldset>
                    <legend>Información Adicional</legend>
                    <table class="formTable">
                        <?php
                        if ($ficha->cc_id) {
                            ?>
                            <tr>
                                <td class="titulo">CC ID</td>
                                <td><?= $ficha->cc_id ?></td>
                            </tr>
                            <?php
                        }
                        if ($ficha->cc_formulario) {
                            ?>
                            <tr>
                                <td class="titulo">CC Formulario</td>
                                <td><?= $ficha->cc_formulario ?></td>
                            </tr>
                            <?php
                        }
                        if ($ficha->cc_llavevalor) {
                            ?>
                            <tr>
                                <td class="titulo">CC LLave Valor</td>
                                <td><?= $ficha->cc_llavevalor ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </fieldset>
                <?php
            }
        }
        ?>

        <table>
            <tr><td colspan="2"><p class="red">* Campos Obligatorios</p></td></tr>
            <tr>
                <td colspan="2" class="botones">
                    <?php $this->load->view('backend/widgets/botones.php') ?>
                </td>
            </tr>
        </table>

    </form>
</div>
<script>
    $("td.ttip").tooltip({'effect':'fade'});
</script>
