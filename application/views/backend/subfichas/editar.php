
<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/subfichas') ?>">SubFichas</a> »
    <span>Editar SubFicha #<?= $subficha->id ?></span>
</div>

<div class="pane">

    <?php $this->load->view('backend/subfichas/menu', array('tab' => 'editar')) ?>

    <h2>Edición subficha</h2>

    <form class="ajaxForm" method="post" action="<?= site_url('backend/subfichas/' . $nombreform . '/' . $subficha->id) ?>">
        <fieldset>
            <legend><?= $subficha->Servicio->nombre ?></legend>

            <div class="validacion"></div>
            <table class="formTable">
                <?php
                
                $metaficha_campos = unserialize($ficha->metaficha_campos);
                $metaficha_servicios = unserialize($ficha->metaficha_servicios);
                $metaficha_servicios = $metaficha_servicios === false ? array() : $metaficha_servicios;
                $_metaficha_servicios_options = array();
                $_metaficha_servicios_options[] = array('value' => "", 'label' => "");
                foreach($servicios as $servicio)
                    $_metaficha_servicios_options[] = array('value' => $servicio->codigo, 'label' => $servicio->nombre);

                if (isset($flujo) && ($flujo)) {
                    $campos = array(
                        array(  'label' => "Nombre del Flujo", 
                                'field' => 'titulo', 
                                'type' => 'input',
                                'readonly' => 'readonly'
                        ),
                        /*array(  'label' => "Resumen Corto", 
                                'id' => 'editorN', 
                                'field' => 'resumen', 
                                'type' => 'textarea'
                        ),*/
                        array(  'label' => "Resumen", 
                                'id' => 'editorA', 
                                'field' => 'objetivo', 
                                'type' => 'textarea',
                                'readonly' => 'readonly'
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
                        array(  'label' => "Guia en Consulado", 
                                'id' => 'editorT', 
                                'field' => 'guia_consulado', 
                                'type' => 'textarea'
                        )
                    );
                } else {
                    $campos = array(
                        array(  'label' => "Nombre del Trámite", 
                                'field' => 'titulo', 
                                'type' => 'input',
                                'readonly' => 'readonly'
                        ),
                        array(  'label' => "Descripción", 
                                'id' => 'editorA', 
                                'field' => 'objetivo', 
                                'type' => 'textarea',
                                'readonly' => 'readonly'
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
                        /*array(  'label' => "Trámite Oficina ChileAtiende", 
                                'id' => 'editorO', 
                                'field' => 'guia_chileatiende', 
                                'type' => 'textarea'
                        ),*/
                        array(  'label' => "Trámite Oficina", 
                                'id' => 'editorI', 
                                'field' => 'guia_oficina', 
                                'type' => 'textarea'
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
                        array(  'label' => "Guia en Consulado", 
                                'id' => 'editorT', 
                                'field' => 'guia_consulado', 
                                'type' => 'textarea'
                        )
                    );
                }

                $comentarios = json_decode($subficha->comentarios, true);

                foreach ($campos as $campo) {
                    
                    if(array_key_exists($campo['field'], $metaficha_campos)) {
                        $editable = $metaficha_campos[$campo['field']] ? false : true;
                        $obj = $metaficha_campos[$campo['field']] ? $ficha : $subficha;
                    }
                    else {
                        // $editable = isset($campo['readonly']) && $campo['readonly'] == "readonly" ? false : true;
                        $editable = false;
                        $obj = $ficha;
                    }

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
                    // INFO: se dejan estos controles para aprovechar el javascript que controla los editores tinymce.
                    if ($metaficha_campos && array_key_exists($campo['field'], $metaficha_campos)) {
                        echo '<br />
                            <div class="metaficha_display" style="display: none;">
                                <label><input type="radio" name="metaficha_'.$campo['field'].'" value="0" '.($metaficha_campos[$campo['field']] ? 'checked':'').'/> Si</label>
                                <label><input type="radio" name="metaficha_'.$campo['field'].'" value="1" '.($metaficha_campos[$campo['field']] ? '':'checked').'/> No</label>
                            </div>';
                    }
                    echo "</td>";
                    
                    echo "<td>";

                    if ($campo['type'] == 'input') {
                        echo "<input type='text' name='" . $campo['field'] . "' size='65' value='" . $obj->$campo['field'] . "' ".($editable ? '' : 'readonly="readonly"')." />";
                    } elseif($editable) {
                        echo "<textarea id='" .$campo['id']. "' name='" . $campo['field'] . "' cols='65' rows='15' >" . $obj->$campo['field'] . "</textarea>";
                    } else {
                        echo '<div style="opacity:0.4; background-color:#ccc; color: black; max-width: 560px; max-height: 170px; overflow-y: scroll; padding:3px; border: 1px solid #666;">'.prepare_content_ficha($obj->$campo['field']) .'</div>';
                    }
                    echo "<div class='comentario_wrap'>";
                    echo "<span class='comentario'>Clic aquí para comentar respecto a los cambios de " . $campo['label'] . "</span>";
                    // TODO: revisar que esto este bien
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
