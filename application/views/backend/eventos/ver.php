<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/eventos/') ?>">Eventos</a> »
    <span>Ver: <?= $evento->titulo ?></span>
</div>

<div class="pane">
    <?php $this->load->view('backend/eventos/menu', array('tab' => 'ver')); ?>
	<h2><?= $evento->titulo ?></h2>
   
   <?php
    $message = $this->session->flashdata('message');
    if ($message) {
        echo '<ul class="message">';
        echo '<li>';
        echo '<div class="mensaje">' . $message . '</div>';
        echo '</li>';
        echo '</ul>';
    }

    $error = '';
    $errorRechazo = '';

    // if (!UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
        if ($evento->estado == 'en_revision') {
            $error .= '<li>';
            $error .= '<div class="mensaje"><strong>Atención.</strong> Este evento no se puede editar porque se encuentra en proceso de revisión</div>';
            $error .= '</li>';
        }
    // }

    if ($evento->estado == 'rechazado') {
        $errorRechazo .= '<li>';
        $errorRechazo .= '<div class="mensaje"><strong> Este evento se encuentra con las siguientes observaciones:</strong> <br />' . $evento->estado_justificacion . '</div>';
        $errorRechazo .= '</li>';
    }

    // if (UsuarioBackendSesion::usuario()->tieneRol('publicador')) {
    //     if ($ficha->actualizable) {
    //         $error .= '<li>';
    //         $error .= "<div class='mensaje'><strong>Atención.</strong> $txt_fichaflujo no está publicada en su última versión. La versión publicada actualmente es la # " . $ficha->getVersionPublicada()->id . "<br /> [<a class='popupcompara' href='" . site_url('backend/fichas/ajax_ficha_comparar/' . $ficha->getUltimaVersion()->id . '/' . $ficha->getVersionPublicada()->id) . "'>Comparar</a>] [<a href='" . site_url('backend/fichas/' . ( ($flujo) ? 'publicarflujo' : 'publicar' ) . '/' . $ficha->id) . "'>Actualizar</a>]</div>";
    //         $error .= '</li>';
    //     }
    // }

    if ($errorRechazo) {
        echo '<ul class="updateWarningsRechazado">' . $errorRechazo . '</ul>';
    }
    if ($error) {
        echo '<ul class="updateWarnings">' . $error . '</ul>';
    }

    ?>

    <style>
        tr:nth-child(odd) {
            background-color: #EDEDED;
        }
    </style>
    <table class="formTable">
        <tr>
            <td style="font-weight: bold;">Servicio</td>
            <td>
                <?= $evento->Servicio->nombre ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Título</td>
            <td>
                <?= $evento->titulo ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Enlace</td>
            <td>
                <?= preg_replace('/\[\[(\d+)\]\]/', site_url('fichas/ver/$1'), $evento->url); ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Región</td>
            <td>
                <?php
                $r_nombre = "";
                foreach($evento->Regiones as $k => $r) 
                    $r_nombre .= ($k == 0 ? '':', ').$r->nombre;
                echo $r_nombre; 
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Duración</td>
            <td>
                <?php
                if($evento->permanente == 1)
                    echo "Permanente";
                else {
                    $dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");

                    if($evento->postulacion_start == $evento->postulacion_end)
                        $periodo_str = $dias[date('w', strtotime($evento->postulacion_start))]." ".date('d/m/Y', strtotime($evento->postulacion_start));
                    else
                        $periodo_str = $dias[date('w', strtotime($evento->postulacion_start))]." ".date('d/m/Y', strtotime($evento->postulacion_start)).' al '.$dias[date('w', strtotime($evento->postulacion_end))]." ".date('d/m/Y', strtotime($evento->postulacion_end));
                    echo $periodo_str;
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Público objetivo</td>
            <td>
                <?php
                switch($evento->tipo)
                {
                    case 1:
                        echo "Personas";
                    break;
                    case 2:
                        echo "Empresas";
                    break;
                    case 3:
                        echo "Ambos";
                    break;
                    default:
                        echo "No asignado";
                    break;
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Información</td>
            <td>
                <?= $evento->informacion ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Destacado</td>
            <td>
                <?= $evento->destacado ? 'Si' : 'No' ?>
            </td>
        </tr>
    </table>

    <div style="text-align: center;">
        <?php

        // if !locked:
        if ( !in_array($evento->estado, array('en_revision', 'publicado')) ) {
            if (UsuarioBackendSesion::usuario()->tieneRol('cal-publicador')) {
                echo '<a class="boton" href="' . site_url('backend/eventos/publicar/' . $evento->id) . '">Publicar</a>';
            }
            else if (UsuarioBackendSesion::usuario()->tieneRol('cal-aprobador')) {
                echo '<a class="boton" href="' . site_url('backend/eventos/aprobar/' . $evento->id) . '">Enviar a revisión</a>';
            }
        } else {
            if (UsuarioBackendSesion::usuario()->tieneRol('cal-publicador')) {
                if ($evento->publicado)
                    echo '<a class="boton" href="' . site_url('backend/eventos/despublicar/' . $evento->id) . '">Despublicar</a>';
                else {
                    echo '<a class="overlay boton" rel="#msgrechazar" href="' . site_url('#') . '">Observaciones</a>';
                    echo '<a class="boton" href="' . site_url('backend/eventos/publicar/' . $evento->id) . '">Publicar</a>';
                }
            }
        }

        ?>
    </div>

    <div id="msgrechazar" class="simpleOverlay">
        <form method="post" action="<?= site_url('backend/eventos/rechazar/' . $evento->id) ?>">
            <table>
                <tr>
                    <td>Motivo por el que se realiza una observación al evento</td>
                </tr>
                <tr>
                    <td><textarea name="estado_justificacion" cols="86" rows="5"></textarea></td>
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
