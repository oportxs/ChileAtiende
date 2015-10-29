<?php
function _metaficha_prepare_txt($campo_str, $subficha, $metaficha_campos)
{
    return $metaficha_campos[$campo_str] ? 
        '<i>'.$subficha->MetaFicha[$campo_str].'</i>' : 
        $subficha[$campo_str];
}
function _metaficha_prepare_title($campo_str, $metaficha_campos, $title)
{
    return $metaficha_campos[$campo_str] ?
        $title.'<p style="font-size: x-small; font-style: italic;">(Campo de MetaFicha)</p>' : 
        $title;
}
?>

<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/subfichas') ?>">SubFichas</a> »
    <span>Ver SubFichas #<?= $subficha->id ?></span>
</div>

<div class="pane">
<?php $this->load->view('backend/subfichas/menu', array('tab' => 'ver')) ?>
<br />

    <?php
    $message = $this->session->flashdata('message');
    if ($message) {
        echo '<ul class="message">';
        echo '<li>';
        echo '<div class="mensaje">' . $message . '</div>';
        echo '</li>';
        echo '</ul>';
    }

    $editar = ($subficha->estado == 'en_revision') ? '' : "[" . anchor(site_url('backend/subfichas/editar/' . $subficha->id), 'Editar') . "]";
    $error = '';
    $errorRechazo = '';
    $metaficha_campos = unserialize($subficha->MetaFicha->metaficha_campos);

    $txt_fichaflujo = 'Esta subficha'; // TODO: quitar variable o cambiar nombre

    if (!UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
        if ($subficha->estado == 'en_revision') {
            $error .= '<li>';
            $error .= '<div class="mensaje"><strong>Atención.</strong> ' . $txt_fichaflujo . ' no se puede editar porque se encuentra en proceso de revisión</div>';
            $error .= '</li>';
        }
    }

    if ($subficha->estado == 'rechazado') {
        $errorRechazo .= '<li>';
        $errorRechazo .= '<div class="mensaje"><strong>' . $txt_fichaflujo . ' se encuentra con las siguientes observaciones:</strong> <br />' . $subficha->estado_justificacion . '</div>';
        $errorRechazo .= '</li>';
    }

    if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
        if ($subficha->actualizable) {
            $error .= '<li>';
            $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no está publicada en su última versión. La versión publicada actualmente es la # " . $subficha->getVersionPublicada()->id . "<br /> [<a class='popupcompara' href='" . site_url('backend/fichas/ajax_ficha_comparar/' . $subficha->getUltimaVersion()->id . '/' . $subficha->getVersionPublicada()->id) . "'>Comparar</a>] [<a href='" . site_url('backend/subfichas/publicar/' . $subficha->id) . "'>Actualizar</a>]</div>";
            $error .= '</li>';
        }
    }

    if (!$metaficha_campos['doc_requeridos'] && !$subficha->doc_requeridos) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> Esta subficha no tiene Documentos requeridos asociado $editar </div>";
        $error .= '</li>';
    }
    if (!$metaficha_campos['guia_online'] && !($subficha->guia_online && $subficha->guia_online_url)) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> Esta subficha no tiene un Trámite Online+URL asociado $editar </div>";
        $error .= '</li>';
    }
    if (!$metaficha_campos['guia_oficina'] && !$subficha->guia_oficina) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> Esta subficha no tiene un Trámite oficina asociado $editar </div>";
        $error .= '</li>';
    }
    if (!$metaficha_campos['guia_telefonico'] && !$subficha->guia_telefonico) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> Esta subficha no tiene un Trámite telefónico asociado $editar </div>";
        $error .= '</li>';
    }
    if (!$metaficha_campos['guia_correo'] && !$subficha->guia_correo) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> Esta subficha no tiene un Trámite carta asociado $editar </div>";
        $error .= '</li>';
    }
    if (!$metaficha_campos['guia_chileatiende'] && !$subficha->guia_chileatiende) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> Esta subficha no tiene un Trámite carta asociado $editar </div>";
        $error .= '</li>';
    }
    if (!$metaficha_campos['plazo'] && !$subficha->plazo) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> Esta subficha no tiene un Tiempo de realizacion asociado $editar </div>";
        $error .= '</li>';
    }
    if (!$metaficha_campos['vigencia'] && !$subficha->vigencia) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> Esta subficha no tiene una Vigencia asociado $editar </div>";
        $error .= '</li>';
    }
    if (!$metaficha_campos['costo'] && !$subficha->costo) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> Esta subficha no tiene un Costo asociado $editar </div>";
        $error .= '</li>';
    }
    if (!$metaficha_campos['marco_legal'] && !$subficha->marco_legal) {
        $error .= '<li>';
        $error .= "<div class='mensaje'><strong>Atención.</strong> Esta subficha no tiene un Marco legal asociado $editar </div>";
        $error .= '</li>';
    }

    if ($errorRechazo) {
        echo '<ul class="updateWarningsRechazado">' . $errorRechazo . '</ul>';
    }
    if ($error) {
        echo '<ul class="updateWarnings">' . $error . '</ul>';
    }

    // if (UsuarioBackendSesion::usuario()->tieneRol('aprobador')) {
    //     if (!$subficha->locked)
    //         echo '<div style="text-align: center;"><a class="boton" href="' . site_url('backend/subfichas/aprobar/' . $subficha->id) . '">Enviar a revisión</a></div>';
    // }
    ?>
    <style>
        tr:nth-child(odd) {
            background-color: #EDEDED;
        }
    </style>
    <br />
    <table class="formTable">
        <tr>
            <td style="font-weight: bold;">Código</td>
            <td>
                <?= $subficha->id; ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Servicio</td>
            <td>
                <?= $subficha->Servicio->nombre ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Nombre del trámite</td>
            <td><?= $subficha->MetaFicha->titulo ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Descripción</td>
            <td><?= prepare_content_ficha($subficha->MetaFicha->objetivo) ?></td>
        </tr>

        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('cc_observaciones', $metaficha_campos, 'Detalles'); ?></td>
            
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('cc_observaciones', $subficha, $metaficha_campos)) ?></td>
        </tr>

        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('beneficiarios', $metaficha_campos, 'Beneficiarios'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('beneficiarios', $subficha, $metaficha_campos)) ?></td>
        </tr>
        
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('doc_requeridos', $metaficha_campos, 'Documentos requeridos'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('doc_requeridos', $subficha, $metaficha_campos)) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('guia_online', $metaficha_campos, 'Guía Online'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_online', $subficha, $metaficha_campos)) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('guia_online_url', $metaficha_campos, 'Guía online URL'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_online_url', $subficha, $metaficha_campos)) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('guia_oficina', $metaficha_campos, 'Guía Oficina'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_oficina', $subficha, $metaficha_campos)) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('guia_telefonico', $metaficha_campos, 'Guía telefónico'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_telefonico', $subficha, $metaficha_campos)) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('guia_chileatiende', $metaficha_campos, 'Guía Chile Atiende'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_chileatiende', $subficha, $metaficha_campos)) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('guia_correo', $metaficha_campos, 'Guía Correo'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('guia_correo', $subficha, $metaficha_campos)) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('plazo', $metaficha_campos, 'Tiempo realización'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('plazo', $subficha, $metaficha_campos)) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('vigencia', $metaficha_campos, 'Vigencia'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('vigencia', $subficha, $metaficha_campos)) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('costo', $metaficha_campos, 'Costo'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('costo', $subficha, $metaficha_campos)) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('informacion_multimedia', $metaficha_campos, 'Infografía, audio y video'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('informacion_multimedia', $subficha, $metaficha_campos)) ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;"><?= _metaficha_prepare_title('marco_legal', $metaficha_campos, 'Marco legal'); ?></td>
            <td><?= prepare_content_ficha(_metaficha_prepare_txt('marco_legal', $subficha, $metaficha_campos)) ?></td>
        </tr>
    </table>

    <div style="text-align: center;">
        <?php
        if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) {

            if ($subficha->locked) {
                echo '<a class="overlay boton" rel="#msgrechazar" href="' . site_url('#') . '">Observaciones</a>';
                echo '<a class="boton" href="' . site_url('backend/subfichas/publicar/' . $subficha->id) . '">Publicar</a>';
            } else {
                if ($subficha->publicado)
                    echo '<a class="boton" href="' . site_url('backend/subfichas/despublicar/' . $subficha->id) . '">Despublicar</a>';
            }
        }

        if (UsuarioBackendSesion::usuario()->tieneRol('aprobador')) {
            if (!$subficha->locked)
                echo '<a class="boton" href="' . site_url('backend/subfichas/aprobar/' . $subficha->id) . '">Enviar a revisión</a>';
        }
        ?>
    </div>

    <div id="msgrechazar" class="simpleOverlay">
        <form method="post" action="<?= site_url('backend/subfichas/rechazar/' . $subficha->id) ?>">
            <table>
                <tr>
                    <td>Motivo por el que se realiza una observación a la subficha</td>
                </tr>
                <tr>
                    <td><textarea name="estado_justificacion" cols="90" rows="5"></textarea></td>
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
