<?php
$titulo = ( $flujo ) ? 'Flujo' : 'Ficha';
?>
<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url(( $flujo ) ? 'backend/fichas/listarflujos' : 'backend/fichas' ) ?>"><?= $titulo ?></a> »
    <span>Agregar <?= $titulo ?></span>
</div>

<div class="pane">
    <h2>Agregar <?= strtolower($titulo) ?></h2>
    <form class="ajaxForm" method="post" action="<?= site_url('backend/fichas/' . ( ( $flujo ) ? 'agregar_flujo' : 'agregar_form' )) ?>">
        <fieldset>
            <legend>Datos <?= strtolower($titulo) ?></legend>
            <div class="validacion"></div>
            <table class="formTable">

                <?php if(UsuarioBackendSesion::usuario()->tieneRol(array('metaficha')) && !$flujo): ?>
                <tr>
                    <td class="titulo">MetaFicha <span class="red">*</span></td>
                    <td>
                        <label><input type="radio" name="metaficha" id="metaficha_si" value="1" /> Si</label>
                        <label><input type="radio" name="metaficha" id="metaficha_no" value="0" /> No</label>
                    </td>
                </tr>
                <?php else: ?>
                <input type="hidden" name="metaficha" value="0"/>
                <?php endif; ?>
                
                <tr>
                    <td class="titulo">Servicio <span class="red">*</span></td>
                    <td>
                        <select data-placeholder="Seleccione un Servicio" name="servicio_codigo" class="chzn-select">
                            <option value=""></option>
                            <?php
                            foreach ($servicios as $servicio) {
                                echo '<option value="' . $servicio->codigo . '" >' . $servicio->nombre . '</option>';
                            }
                            ?>
                        </select>


                    </td>
                </tr>
                <tr>
                    <td class="titulo">Código <span class="red">*</span></td>
                    <td>
                        <input size="6" type="text" class="codigo_preview" disabled="disabled"> 

                        - <input size="6" title="Corresponde al Código Único e Identificatorio del Proyecto utizando la nomenclatura propuesta por Segpres. Ej: AJ001-1" type="text" name="correlativo" />
                        <a href="#" onclick="return generarCodigo()">Generar</a>
                    </td>
                </tr>
                <tr>
                    <td class="titulo">Nombre del <?= ($flujo) ? 'Flujo' : 'Trámite'; ?> <span class="red">*</span></td>
                    <td><input type="text" name="titulo" size="64" value="" /></td>
                </tr>
                <?php if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) { ?>
                    <tr>
                        <td class="titulo"><?= ($flujo) ? 'Resumen Corto' : 'Resumen'; ?></td>
                        <td><textarea id="editorN" name="resumen" cols="65" rows="15"></textarea></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="titulo"><?= ($flujo) ? 'Resumen' : 'Descripción'; ?> <span class="red">*</span></td>
                    <td><textarea id="editorA" name="objetivo" cols="65" rows="15"></textarea></td>
                </tr>
                <tr class="metaficha_display">
                    <td class="titulo">Criterio para categorizar las SubFichas <span class="red">*</span></td>
                    <td>
                        <select data-placeholder="Seleccione un criterio" name="metaficha_categoria" class="chzn-select" style="width:550px;">
                            <option value=""></option>
                            <option value="region-comuna">Región-Comuna</option>
                            <option value="servicio-alfabetico">Alfabético</option>
                            <option value="entidad-servicio">Entidad-Servicio</option>
                        </select>
                        <br />
                        <div id="metaficha_categoria_msg" class="input_warn_msg">La opción Región-Comuna debe ser utilizada sólo cuando todas las instituciones que completarán subfichas son municipios.</div>
                    </td>
                </tr>
                <tr class="metaficha_display">
                    <td class="titulo">Servicios que deben completar el <?= ($flujo) ? 'Flujo' : 'Trámite'; ?></td>
                    <td>
                        <select data-placeholder="Seleccione un Servicio" name="metaficha_servicios[]" multiple class="chzn-select" style="width:550px;">
                            <option value=""></option>
                            <?php
                            foreach ($subficha_servicios as $servicio_codigo => $servicio_nombre) {
                                echo '<option value="' . $servicio_codigo . '" >' . $servicio_nombre . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr class="metaficha_display">
                    <td class='titulo'>¿Hay instituciones que no publican en el portal?</td>
                    <td>
                        <label><input type="radio" name="metaficha_servicios_no_publican" id="" value="1" /> Si</label>
                        <label><input type="radio" name="metaficha_servicios_no_publican" id="" value="0" /> No</label>
                    </td>
                </tr>
                <tr>
                    <td class="titulo">
                        Detalles
                        <br />
                        <div class="metaficha_display">
                            <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                            <label><input type="radio" name="metaficha_cc_observaciones" value="1" checked/> Si</label>
                            <label><input type="radio" name="metaficha_cc_observaciones" value="0" /> No</label>
                        </div>
                    </td>
                    <td><textarea id="editorL" name="cc_observaciones" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">
                        <?= ($flujo) ? 'Contenido' : 'Beneficiarios'; ?>
                        <br />
                        <div class="metaficha_display">
                            <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                            <label><input type="radio" name="metaficha_beneficiarios" value="1" checked/> Si</label>
                            <label><input type="radio" name="metaficha_beneficiarios" value="0" /> No</label>
                        </div>
                    </td>
                    <td><textarea id="editorB" name="beneficiarios" cols="65" rows="15"></textarea></td>
                </tr>
                <?php
                if ($flujo) {
                ?>
                <tr>
                    <td class="titulo">
                        Recuerda
                        <br />
                        <div class="metaficha_display">
                            <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                            <label><input type="radio" name="metaficha_vigencia" value="1" checked/> Si</label>
                            <label><input type="radio" name="metaficha_vigencia" value="0" /> No</label>
                        </div>
                    </td>
                    <td><textarea id="editorD" name="vigencia" cols="65" rows="15"></textarea></td>
                </tr>
                <tr>
                    <td class="titulo">
                        Marco Legal
                        <br />
                        <div class="metaficha_display">
                            <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                            <label><input type="radio" name="metaficha_marco_legal" value="1" checked/> Si</label>
                            <label><input type="radio" name="metaficha_marco_legal" value="0" /> No</label>
                        </div>
                    </td>
                    <td><textarea id="editorE" name="marco_legal" cols="65" rows="15"></textarea></td>
                </tr>
                <?php
                }
                ?>
                <!-- si es un flujo, ocultamos estos campos -->
                <?php
                if (!$flujo) {
                    ?>
                    <tr>
                        <td class="titulo">
                            Documentos Requeridos
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_doc_requeridos" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_doc_requeridos" value="0" /> No</label>
                            </div>
                        </td>
                        <td><textarea id="editorG" name="doc_requeridos" cols="65" rows="15"></textarea></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Trámite Online
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_guia_online" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_guia_online" value="0" /> No</label>
                            </div>
                        </td>
                        <td><textarea id="editorH" name="guia_online" cols="65" rows="15"></textarea></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Url Trámite Online
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_guia_online_url" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_guia_online_url" value="0" /> No</label>
                            </div>
                        </td>
                        <td><input type="text" name="guia_online_url" size="65" value="" /></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Trámite Oficina
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_guia_oficina" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_guia_oficina" value="0" /> No</label>
                            </div>
                        </td>
                        <td><textarea id="editorI" name="guia_oficina" cols="65" rows="15"></textarea></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Nombre de la Oficina
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_guia_oficina_nombre" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_guia_oficina_nombre" value="0" /> No</label>
                            </div>
                        </td>
                        <td><input type="text" name="guia_oficina_nombre" size="65" value="" /></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Trámite Telefónico
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_guia_telefonico" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_guia_telefonico" value="0" /> No</label>
                            </div>
                        </td>
                        <td><textarea id="editorJ" name="guia_telefonico" cols="65" rows="15"></textarea></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Trámite Carta
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_guia_correo" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_guia_correo" value="0" /> No</label>
                            </div>
                        </td>
                        <td><textarea id="editorK" name="guia_correo" cols="65" rows="15"></textarea></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Trámite Oficina ChileAtiende
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_guia_chileatiende" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_guia_chileatiende" value="0" /> No</label>
                            </div>
                        </td>
                        <td><textarea id="editorO" name="guia_chileatiende" cols="65" rows="15"></textarea></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Tiempo Realización
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_plazo" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_plazo" value="0" /> No</label>
                            </div>
                        </td>
                        <td><textarea id="editorF" name="plazo" cols="65" rows="15"></textarea></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Vigencia
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_vigencia" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_vigencia" value="0" /> No</label>
                            </div>
                        </td>
                        <td><textarea id="editorY" name="vigencia" cols="65" rows="15"></textarea></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Costo
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_costo" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_costo" value="0" /> No</label>
                            </div>
                        </td>
                        <td><textarea id="editorC" name="costo" cols="65" rows="15"></textarea></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Infografía, audio y video
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_informacion_multimedia" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_informacion_multimedia" value="0" /> No</label>
                            </div>
                        </td>
                        <td><textarea id="editorM" name="informacion_multimedia" cols="65" rows="15"></textarea></td>
                    </tr>
                    <tr>
                        <td class="titulo">
                            Marco Legal
                            <br />
                            <div class="metaficha_display">
                                <span style="font-size: 80%; font-style: italic;">¿Info general?</span><br/>
                                <label><input type="radio" name="metaficha_marco_legal" value="1" checked/> Si</label>
                                <label><input type="radio" name="metaficha_marco_legal" value="0" /> No</label>
                            </div>
                        </td>
                        <td><textarea id="editorE" name="marco_legal" cols="65" rows="15"></textarea></td>
                    </tr>
                    <?php
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
                        <label><input type="radio" name="tipo" id="personas" value="1" /> Personas</label>
                        <label><input type="radio" name="tipo" id="empresas" value="2"/> Empresas</label>
                        <label><input type="radio" name="tipo" id="ambos" value="3"/> Ambos</label>
                    </td>
                </tr>
            </table>
            <div id="clasificacion-personas" style="display:none">
                <table class="formTable">
                    <tr>
                        <td class="titulo">Rangos de Edad</td>
                        <td>
                            <input type="text" name="rangos"  /> Ej: 15-30,40-65
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo">Género</td>
                        <td>
                            <select data-placeholder="Seleccione el Género" name="genero" class="chzn-select" style="width: 300px;">
                                <option value=""></option>
                                <?php
                                foreach ($generos as $genero) {
                                    echo '<option value="' . $genero->id . '" >' . $genero->nombre . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo">Temas</td>
                        <td>
                            <select data-placeholder="Seleccione su(s) Tema(s)" name="temas[]" multiple class="chzn-select" style="width:550px;">
                                <option value=""></option>
                                <?php foreach ($temas as $tema): ?>
                                    <option value="<?= $tema->id ?>"><?= $tema->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo">Hechos de Vida</td>
                        <td class="widgetSelectTable">
                            <select class="chzn-select"  data-placeholder="Seleccionar hecho de vida" style="width: 300px;">
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
                                <tbody></tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <!-- chilenos en el extranjero -->
                <div class="tramite-exterior">
                    <table class="formTable">
                        <tr>
                            <td>
                                <input type="checkbox" name="exterior" id="chkbox_exterior"/>
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
                                            disabled="disabled" 
                                            style="width: 350px;">
                                        <option value></option>
                                        <option value="Residencia permanente en el Exterior">con residencia permanente en el extranjero</option>
                                        <option value="Residencia temporal en el Exterior">con residencia temporal en el extranjero</option>
                                        <option value="De viaje en el Exterior">de viaje en el extranjero</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="checkbox" name="exterior_destacado" id="chkbox_exterior_destacado" disabled="true"/>
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
                        <ul style="width: 535px;" class="tagitTags"></ul>
                    </td>
                </tr>
            </table>
        </fieldset>

        <fieldset id="clasificacion-emprendete" style="display:none;">
            <legend>Clasificación ChileAtiende Pymes</legend>
            <table class="formTable">
                <tr>
                    <td class="titulo">Aprende sobre</td>
                    <td class="widgetSelectTableAS">
                        <select class="chzn-select"  data-placeholder="Seleccione una etapa de la empresa" style="width: 300px;">
                            <option></option>
                            <?php foreach ($etapasempresa as $ee): ?>
                                <optgroup label="<?= $ee->nombre ?>">
                                    <?php
                                    foreach ($ee->HechosEmpresa as $h):
                                        ?>
                                        <?php
                                        $eta = ' ( ';
                                        foreach ($etapasempresa as $etapa):
                                            if ($h->hasEtapaEmpresa($etapa->id))
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
                                    <td style="background-color:#e1e1e1; font-weight: bold; text-align: center;">Hecho de la Empresa</td>
                                    <td style="background-color:#e1e1e1; font-weight: bold;">Acción</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="titulo">Categoría</td>
                    <td>
                        <select data-placeholder="Seleccione su(s) categoría(s)" name="temas_empresa[]" multiple class="chzn-select" style="width:550px;">
                            <option value=""></option>
                            <?php foreach ($temasempresa as $te): ?>
                                <option value="<?= $te->id ?>"><?= $te->nombre ?></option>
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
                            <tbody></tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="titulo"><label for="venta_anual">Ventas anuales</label></td>
                    <td>
                        <input type="radio" name="venta_anual_sel" id="venta-anual-todos" value="1" checked="checked"><label for="venta-anual-todos">Todos</label>
                        <input type="radio" name="venta_anual_sel" id="venta-anual-especifico" value="0"><label for="venta-anual-especifico">Específico</label>

                        <div class="venta_anual-select" style="display:none;">
                            <select data-placeholder="Seleccione tamaño empresa" name="venta_anual[]" id="venta_anual" class="chzn-select" style="width:300px;" multiple>
                                <option value=""></option>
                                <?php
                                foreach ( $tipos_empresa as $te ) {
                                    ?>
                                    <option value="<?php echo $te->id ?>"><?php echo $te->nombre ?></option>
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
                        <input type="radio" name="formalidad_sel" id="formalidad-todos" value="1" checked="checked"><label for="formalidad-todos">Todos</label>
                        <input type="radio" name="formalidad_sel" id="formalidad-especifico" value="0"><label for="formalidad-especifico">Específico</label>

                        <div class="formalidad-select" style="display:none;">
                            <select data-placeholder="Seleccione tipo de formalidad" name="formalizacion" id="formalizacion" class="chzn-select" style="width:300px;">
                                <option value="1">Informal</option>
                                <option value="2">Formal</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="titulo"><label for="fps">Ficha de Protección Social</label></td>
                    <td>
                        <input type="radio"  class="fps" name="fps" value="0" checked="checked"> No
                        <input type="radio"  class="fps" name="fps" value="1"> Si
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <label for="puntaje_fps_min">Puntaje mínimo
                            <input type="text" size="6" maxlength="6" id="puntaje_fps_min" name="puntaje_fps_min" value="2000" disabled="disabled" />
                        </label>
                        <label for="puntaje_fps_max">Puntaje máximo
                            <input type="text" size="6" maxlength="6" id="puntaje_fps_max" name="puntaje_fps_max" value="20000" disabled="disabled" />
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="titulo"><label for="rubro">Actividad económica</label></td>
                    <td>
                        <input type="radio" name="rubro_sel" value="1" checked="checked">Todos
                        <input type="radio" name="rubro_sel" value="0">Específico
                        <div class="rubro-select" style="display:none;">
                            <select data-placeholder="Seleccione el(los) rubro(s)" name="rubro[]" multiple class="chzn-select" style="width:550px;">
                                <?php foreach ($rubros as $r): ?>
                                    <option value="<?= $r->id ?>" selected="selected"><?= $r->nombre ?></option>
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
                            <option value="1">Mujer</option>
                            <option value="2">Indígena</option>
                            <option value="3">Asociaciones empresariales</option>
                        </select>
                    </td>
                </tr>
            </table>

        </fieldset>

        <table>
            <tr>
                <td><p class="red">* Campos Obligatorios</p></td>
            </tr>
            <tr>
                <td class="botones">
                    <?php $this->load->view('backend/widgets/botones.php') ?>
                </td>
            </tr>
        </table>
    </form>
</div>
