<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/' . ( ($flujo) ? 'fichas/listarflujos' : 'fichas' )) ?>"><?= ($flujo) ? 'Flujos' : 'Fichas' ?></a> »
    <span>Ver <?= ($flujo) ? 'Flujo' : 'Ficha' ?> #<?= $ficha->id ?></span>
</div>

<div class="pane">

    <?php $this->load->view('backend/fichas/menu', array('tab' => 'ver', 'flujo' => $flujo)) ?>

    <h2><span style="font-size: 0.7em;"><a href="<?=site_url('/fichas/ver/'.$ficha->id)?>" target="_blank"><img src="assets/images/backend/eye.png" alt="previsualizar" title="previsualizar" /></a></span> <?= $ficha->titulo ?></h2>
    <style>
    .error_message { background-color: #FFCC99; color: #800000; border-color: #800000; }
    </style>
    <?php
    $message = $this->session->flashdata('message');
    $error_message = $this->session->flashdata('error_message');
    if ($message) {
        echo '<ul class="message '. ($error_message ? 'error_message':'') .'">';
        echo '<li>';
        echo '<div class="mensaje">' . $message . '</div>';
        echo '</li>';
        echo '</ul>';
    }

    $editar = ($ficha->estado == 'en_revision') ? '' : "[" . anchor(site_url('backend/fichas/' . ( ($flujo) ? 'editarflujo' : 'editar' ) . '/' . $ficha->id), 'Editar') . "]";

    $error = '';
    $errorRechazo = '';

    $txt_fichaflujo = ($flujo) ? 'Este flujo' : 'Esta ficha';

    if (!UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
        if ($ficha->estado == 'en_revision') {
            $error .= '<li>';
            $error .= '<div class="mensaje"><strong>Atención.</strong> ' . $txt_fichaflujo . ' no se puede editar porque se encuentra en proceso de revisión</div>';
            $error .= '</li>';
        }
    }

    if ($ficha->estado == 'rechazado') {
        $errorRechazo .= '<li>';
        $errorRechazo .= '<div class="mensaje"><strong>' . $txt_fichaflujo . ' se encuentra con las siguientes observaciones:</strong> <br />' . $ficha->estado_justificacion . '</div>';
        $errorRechazo .= '</li>';
    }

    if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
        if ($ficha->actualizable) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no está publicada en su última versión. La versión publicada actualmente es la # " . $ficha->getVersionPublicada()->id . "<br /> [<a class='popupcompara' href='" . site_url('backend/fichas/ajax_ficha_comparar/' . $ficha->getUltimaVersion()->id . '/' . $ficha->getVersionPublicada()->id) . "'>Comparar</a>] [<a href='" . site_url('backend/fichas/' . ( ($flujo) ? 'publicarflujo' : 'publicar' ) . '/' . $ficha->id) . "'>Actualizar</a>]</div>";
            $error .= '</li>';
        }
    }

    if (!$ficha->beneficiarios) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no tiene Beneficiarios asociado $editar </div>";
        $error .= '</li>';
    }

    if (!$flujo) {
        if (!$ficha->doc_requeridos) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene Documentos requeridos asociado $editar </div>";
            $error .= '</li>';
        }
        if (!($ficha->guia_online && $ficha->guia_online_url)) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Trámite Online+URL asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->guia_oficina) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Trámite oficina asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->guia_telefonico) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Trámite telefónico asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->guia_correo) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Trámite carta asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->plazo) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Tiempo de realizacion asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->vigencia) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene una Vigencia asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->costo) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Costo asociado $editar </div>";
            $error .= '</li>';
        }
        if (!$ficha->marco_legal) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> Esta ficha no tiene un Marco legal asociado $editar </div>";
            $error .= '</li>';
        }
    }

    if (!$ficha->showRangosAsString()) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no tiene un Rango de edad asociado $editar </div>";
        $error .= '</li>';
    }
    if (!$ficha->genero_id) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no tiene un Género asignado $editar </div>";
        $error .= '</li>';
    }

    if ($ficha->tipo != 2) { //no muestra si la ficha es de empresa
        if (count($ficha->Temas) == 0) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no tiene Temas asociados $editar </div>";
            $error .= '</li>';
        }
        if (count($ficha->HechosVida) == 0) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no tiene Hechos de Vida asociados $editar </div>";
            $error .= '</li>';
        }
    }

    $metaficha_campos = array();
    $metaficha_servicios = array();
    if($ficha->metaficha) {
        $metaficha_campos = unserialize($ficha->metaficha_campos);
        $metaficha_servicios = unserialize($ficha->metaficha_servicios);
        // INFO: 'b:0;' == serialize(array()) ===> unserialize('b:0;') == false
        $metaficha_servicios = $metaficha_servicios === false ? array() : $metaficha_servicios;
        $metaficha_opciones = unserialize($ficha->metaficha_opciones);
    }


    if ($errorRechazo) {
        echo '<ul class="updateWarningsRechazado">' . $errorRechazo . '</ul>';
    }
    if ($error) {
        echo '<ul class="updateWarnings">' . $error . '</ul>';
    }

    if (UsuarioBackendSesion::usuario()->tieneRol('aprobador')) {
        if (!$ficha->locked)
            echo '<div style="text-align: center;"><a class="boton" href="' . site_url('backend/fichas/' . ( ($flujo) ? 'aprobarflujo' : 'aprobar' ) . '/' . $ficha->id) . '">Enviar a revisión</a></div>';
    }
    ?>
    <style>
        tr:nth-child(odd) {
            background-color: #EDEDED;
        }
    </style>
    <table class="formTable">
        <tr>
            <td style="font-weight: bold;">Código</td>
            <td>
                <?= $ficha->getCodigo() ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Servicio</td>
            <td>
                <?= $ficha->Servicio->nombre ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Nombre del <?= ( ($flujo) ? 'flujo' : 'trámite' ) ?></td>
            <td><?= $ficha->titulo ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Fecha de actualización real</td>
            <td>
            <?php 
                echo ($ficha->content_updated_data_at) ? strftime("%d-%m-%Y %H:%M", strtotime($ficha->content_updated_data_at)) : strftime("%d-%m-%Y %H:%M", strtotime($ficha->Versiones[0]->updated_at))
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Fecha de actualización última version</td>
            <td>
            <?php 
                echo strftime('%d-%m-%Y %H:%M', mysql_to_unix($ficha->Versiones[0]->updated_at));
                ?>
            </td>
        </tr> 
        <tr>
            <td style="font-weight: bold;">Fecha de actualización pública</td>
            <td>
            <?php 
                $updatedDate = ($ficha->updated_data_at)? $ficha->updated_data_at : $ficha->updated_at;
                echo strftime('%d-%m-%Y', mysql_to_unix($updatedDate));
                ?>
            </td>
        </tr>    
        <tr>
            <td style="font-weight: bold;"><?= ( ($flujo) ? 'Resumen Corto' : 'Resumen' ) ?></td>
            <td><?= prepare_content_ficha($ficha->resumen) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= ( ($flujo) ? 'Resumen' : 'Descripción' ) ?></td>
            <td><?= prepare_content_ficha($ficha->objetivo) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">MetaFicha</td>
            <td><?= prepare_content_ficha($ficha->metaficha ? 'Si':'No') ?></td>
        </tr>
        <?php if($ficha->metaficha): ?>
        <tr>
            <td style="font-weight: bold;">Criterio para categorizar las SubFichas</td>
            <td><?= prepare_content_ficha($metaficha_opciones['categoria']) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Servicios que deben completar el <?= ($flujo) ? 'Flujo' : 'Trámite'; ?></td>
            <td>
                <?php 
                $_servicios = array();
                foreach($metaficha_servicios as $servicio_code) {
                    $servicio = Doctrine::getTable('Servicio')->find($servicio_code);
                    $_servicios[] = $servicio->nombre;
                }
                echo implode(', ', $_servicios);
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">¿Hay instituciones que no publican en el portal?</td>
            <td><?= prepare_content_ficha($metaficha_opciones['servicios_no_publican'] ? 'Si':'No') ?></td>
        </tr>
        <?php endif; ?>
        
        <?php
        function _metaficha_prepare_txt($campo_str, $ficha, $metaficha_campos)
        {
            if($ficha->metaficha)
                $_txt = $metaficha_campos[$campo_str] ? $ficha[$campo_str] : '<i>El campo se llena en la SubFicha</i>';
            else
                $_txt = $ficha[$campo_str];

            return $_txt;
        }
        ?>

        <?php 
        // si es un flujo, ocultamos estos campos
        if(!$flujo) { ?>
        <tr>
            <td style="font-weight: bold;">Detalles</td>
            
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('cc_observaciones', $ficha, $metaficha_campos)) ?></td>
        </tr>
        <?php } ?>

        <tr>
            <td style="font-weight: bold;"><?= ( ($flujo) ? 'Contenido' : 'Beneficiarios' ) ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('beneficiarios', $ficha, $metaficha_campos)) ?></td>
        </tr>
        
        <?php
        // si es un flujo, ocultamos estos campos
        if (!$flujo) {
            ?>
            <tr>
                <td style="font-weight: bold;">Documentos requeridos</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('doc_requeridos', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Guía Online</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_online', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Guía online URL</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_online_url', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Guía Oficina</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_oficina', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Nombre de la Oficina</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_oficina_nombre', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Guía telefónico</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_telefonico', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Guía Correo</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_correo', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Guía Chile Atiende</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_chileatiende', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Tiempo relización</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('plazo', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Vigencia</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('vigencia', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Costo</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('costo', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Infografía, audio y video</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('informacion_multimedia', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Marco legal</td>
                <td><?= prepare_content_ficha(_metaficha_prepare_txt('marco_legal', $ficha, $metaficha_campos)) ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="2" style="text-align: center; color: #000; background-color: #CCC; font-weight: bold;">Clasificación</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Destacada</td>
            <td><?= ($ficha->destacado) ? 'Si' : 'No' ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Temas</td>
            <td>
                <?php
                foreach ($ficha->Temas as $tema) {
                    echo $tema->nombre . ' ';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Tipo</td>
            <td><?php
                if ($ficha->tipo == 1) {
                    echo 'Personas';
                } elseif ($ficha->tipo == 2) {
                    echo 'Empresas';
                } else {
                    echo 'Ambos';
                }
                ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Hechos de la vida</td>
            <td>
                <?php
                foreach ($ficha->HechosVida as $h) {

                    $eta = ' ( ';
                    foreach ($etapasvida as $etapa):
                        if ($h->hasEtapa($etapa->id))
                            $eta .= $etapa->nombre . ' ';
                    endforeach;
                    $eta .= ')';

                    echo $h->nombre . ' ' . $eta . '<br />';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Género</td>
            <td><?= $ficha->Genero->nombre ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Rango edad</td>
            <td><?= $ficha->showRangosAsString() ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Tags</td>
            <td>
                <?php foreach ($ficha->Tags as $tag): ?>

                    <?= $tag->nombre ?>


                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Keywords</td>
            <td><?= $ficha->keywords ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Sic</td>
            <td><?= $ficha->sic ?></td>
        </tr>

        <?php if($ficha->isTramiteMujer()):?>
        <tr>
            <td colspan="2" style="text-align: center; color: #000; background-color: #CCC; font-weight: bold;">Chileatiende Mujer</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Se muestra en portal ChileAtiende Mujer?</td>
            <td>
                <?=($ficha->isTramiteMujer()?"Si":"No")?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Destacado en portada de ChileAtiende Mujer</td>
            <td>
                <?=($ficha->isTramiteMujerDestacado()?"Si":"No")?>
            </td>
        </tr>
        <?php endif; // mujer?>

        <?php if($ficha->isTramiteExterior()):?>
        <tr>
            <td colspan="2" style="text-align: center; color: #000; background-color: #CCC; font-weight: bold;">Trámite para chilenos en el Exterior</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Motivos de estadía en el Exterior</td>
            <td>
                <ul>
                <?php foreach($ficha->listarMotivosExterior() as $m):?>
                    <li><?=$m['MotivosEnExterior'][0]['nombre'];?></li>
                <?php endforeach; ?>
                </ul>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Destacado en portada de ChileAtiende en el Exterior</td>
            <td>
                <?=($ficha->isTramiteExteriorDestacado()?"Si":"No")?>
            </td>
        </tr>
        <?php endif; // exterior?>

        <?php if($ficha->guia_consulado): ?>
        <tr>
            <td>
                <strong>Guia en consulado</strong>
            </td>
            <td>
                <?=$ficha->guia_consulado?>
            </td>
        </tr>
        <?php endif; // guia_consulado?>
        
        <?php
        if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
            if ($ficha->cc_id || $ficha->cc_formulario || $ficha->cc_llavevalor) {
                ?>
                <tr>
                    <td colspan="2" style="text-align: center; color: #000; background-color: #CCC; font-weight: bold;">Información Adicional</td>
                </tr>
                <?php
                if ($ficha->cc_id) {
                    ?>
                    <tr>
                        <td style="font-weight: bold;">CC ID</td>
                        <td><?= $ficha->cc_id ?></td>
                    </tr>
                    <?php
                }
                if ($ficha->cc_formulario) {
                    ?>
                    <tr>
                        <td style="font-weight: bold;">CC Formulario</td>
                        <td><?= $ficha->cc_formulario ?></td>
                    </tr>
                    <?php
                }
                if ($ficha->cc_llavevalor) {
                    ?>
                    <tr>
                        <td style="font-weight: bold;">CC LLave Valor</td>
                        <td><?= $ficha->cc_llavevalor ?></td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
        <tr>
            <td colspan="2" style="text-align: center; color: #000; background-color: #CCC; font-weight: bold;">Clasificación Emprendete</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Trámites</td>
            <td>
                <?php
                foreach ($temasempresa as $te):
                    if ($ficha->hasTemaEmpresa($te->id))
                        echo $te->nombre . ' ';
                endforeach;
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Etapas empresa</td>
            <td>
                <?php
                foreach ($ficha->HechosEmpresa as $he):
                    foreach ($etapasempresa as $etapa):
                        if ($he->hasEtapaEmpresa($etapa->id))
                            echo $etapa->nombre . ' - ';
                    endforeach;
                endforeach;
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Apoyo Estado</td>
            <td>
                <?php
                foreach ($apoyosestado as $ae):
                    if ($ficha->hasApoyo($ae->id))
                        echo $ae->nombre.' ';
                endforeach;
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Rubro</td>
            <td>
                <?php 
                foreach ($rubros as $r):
                    if ($ficha->hasRubro($r->id)) {
                        echo $r->nombre.' ';
                    }
                endforeach; 
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Ficha de Protección Social</td>
            <td><?= ($ficha->fps) ? 'Si aplica, Puntaje: '.$ficha->puntaje_fps_min.' '.$ficha->puntaje_fps_max : 'No aplica'; ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Nivel de formalización</td>
            <td><?= ( ($ficha->formalizacion == "1") ? 'Informal' : 'Formal' ) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Tamaño empresa</td>
            <td>
                <ul>
                    <?php
                    foreach ( $tipos_empresa as $te ) {
                        echo ( $ficha->hasTipoEmpresa($te->id) ) ? '<li>'.$te->nombre.'</li>' : '' ;
                    }
                    ?>
                </ul>
                
            </td>
        </tr>

    </table>

    <div style="text-align: center;">
        <?php
        if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) {

            if ($ficha->locked) {
                //echo '<a class="boton" href="' . site_url('backend/fichas/rechazar/' . $ficha->id) . '">Rechazar</a>';
                echo '<a class="overlay boton" rel="#msgrechazar" href="' . site_url('#') . '">Observaciones</a>';
                echo '<a class="boton" href="' . site_url('backend/fichas/' . ( ($flujo) ? 'publicarflujo' : 'publicar' ) . '/' . $ficha->id) . '">Publicar</a>';
            } else {
                if ($ficha->publicado)
                    echo '<a class="boton" href="' . site_url('backend/fichas/' . ( ($flujo) ? 'despublicarflujo' : 'despublicar' ) . '/' . $ficha->id) . '">Despublicar</a>';
                //else
                //echo '<a class="boton" href="' . site_url('backend/fichas/publicar/' . $ficha->id) . '">Publicar</a>';
            }
        }

        if (UsuarioBackendSesion::usuario()->tieneRol('aprobador')) {
            if (!$ficha->locked)
                echo '<a class="boton" href="' . site_url('backend/fichas/' . ( ($flujo) ? 'aprobarflujo' : 'aprobar' ) . '/' . $ficha->id) . '">Enviar a revisión</a>';
        }
        ?>
    </div>

    <div id="msgrechazar" class="simpleOverlay">
        <form method="post" action="<?= site_url('backend/fichas/' . ( ($flujo) ? 'rechazarflujo' : 'rechazar' ) . '/' . $ficha->id) ?>">
            <table>
                <tr>
                    <td>Motivo por el que se realiza una observación al <?= ( ($flujo) ? 'flujo' : 'trámite' ) ?></td>
                </tr>
                <tr>
                    <td><textarea name="estado_justificacion" cols="110" rows="5"></textarea></td>
                </tr>
                <tr>
                    <td class="botones">
                        <button type="submit" class="agregar">Enviar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
