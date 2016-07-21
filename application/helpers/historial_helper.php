<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function make_description($comparacion, $ficha_nueva, $master) {
    $descripcion = "";
    $json_comentarios = $ficha_nueva->comentarios;
    $comentarios = null;
    if($json_comentarios != null)
        $comentarios = json_decode($json_comentarios,true);

    foreach ($comparacion as $key => $val) {
        $descripcion.='<p>Modificación en <strong>' . ucwords($key) . '</strong> de '.( ($ficha_nueva->flujo)?'flujo':'ficha').' <strong>#' . $ficha_nueva->id . '</strong>:</p>';
        
        $descripcion.='<ul>';
        foreach ($val->left as $comp)
            $descripcion.='<li>' . $comp . '</li>';
        $descripcion.='</ul>';
        if (is_array($comentarios) && isset($comentarios[$key]) && $comentarios[$key]!="") {
            $descripcion .= "<p class='comment_toggle'><strong>Leer Comentarios (+)</strong></p>";
            $descripcion .= "<p class='comment'><strong>Ocultar Comentarios (-)</strong><br/>" . $comentarios[$key] . "</p>";
        }
        $descripcion.='<br />';

        if(strtolower($key)=='es_tramite_exterior'){
            if (intval($val->right) == 1){
                $exterior_lista_motivos = $master->listarMotivosExterior();
                $descripcion .= "<p>[ ".$ficha_nueva->id."] Se habilita para: " . implode(', ', $exterior_lista_motivos);
                // $descripcion .= "<pre>" . print_r($exterior_lista_motivos) . "</pre>";
            } else {
                $descripcion .= "<p>Se deshabilita esta opción</p>";
            }
        }
    }

    return $descripcion;
}

/**
 * Genera un texto html con la descripción de los cambios realizados
 *
 * @param array $comparacion Arreglo con los campos que tienen cambios
 * @param Doctrine_Record $version_nueva Version nueva del contenido
 *
 * @return string
 */
function _make_description_obj($comparacion, $version_nueva, $objtxt) {
    $descripcion = "";

    foreach ($comparacion as $key => $val) {
        $descripcion.='<p>Modificación en <strong>' . ucwords($key) . '</strong> de '.$objtxt.' <strong>#' . $version_nueva->id . '</strong>:</p>';
        
        $descripcion.='<ul>';
        foreach ($val->left as $comp)
            $descripcion.='<li>' . $comp . '</li>';
        $descripcion.='</ul>';

        $descripcion.='<br />';
    }

    return $descripcion;
}

function make_description_contenido($comparacion, $version_nueva) {
    return _make_description_obj($comparacion, $version_nueva, "contenido");
}

function make_description_evento($comparacion, $version_nueva) {
    return _make_description_obj($comparacion, $version_nueva, "evento");
}

function make_description_subficha($comparacion, $version_nueva) {
    return _make_description_obj($comparacion, $version_nueva, "subficha");
}

?>
