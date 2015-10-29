<?php
//permite consumir fichas desde plataforma ChileAtiende mediante la API
/*
 * Obtiene un servicio
 * https://www.chileatiende.cl/desarrolladores/servicios_obtener
 */
function APIServicio($idServicio) {
    $CI = & get_instance();

    $token = $CI->config->item('chileatiende_api_access_token');
    $url = $CI->config->item('chileatiende_api_url');

    $servicio = json_decode(file_get_contents($url . 'servicios/' . $idServicio . '?access_token=' . $token));

    return $servicio;
}

/*
 * Obtiene todos los servicios
 * https://www.chileatiende.cl/desarrolladores/servicios_listar
 */

function APIServicios() {
    $CI = & get_instance();

    $token = $CI->config->item('chileatiende_api_access_token');
    $url = $CI->config->item('chileatiende_api_url');

    $servicios = json_decode(file_get_contents($url . 'servicios/?access_token=' . $token));

    return $servicios;
}

/*
 * Obtiene una ficha
 * https://www.chileatiende.cl/desarrolladores/fichas_obtener
 */

function APIFicha($idFicha) {
    $CI = & get_instance();

    $token = $CI->config->item('chileatiende_api_access_token');
    $url = $CI->config->item('chileatiende_api_url');

    $ficha = json_decode(file_get_contents($url . 'fichas/' . $idFicha . '?access_token=' . $token));

    return $ficha;
}

/*
 * Obtiene las fichas asociadas a un servicio
 * https://www.chileatiende.cl/desarrolladores/fichas_listarporservicio
 */

function APIFichas($servicioId) {
    $CI = & get_instance();

    $token = $CI->config->item('chileatiende_api_access_token');
    $url = $CI->config->item('chileatiende_api_url');

    $fichas = json_decode(file_get_contents($url . 'servicios/' . $servicioId . '/fichas?access_token=' . $token));

    return $fichas;
}

/*
 * Obtiene todas las fichas
 * https://www.chileatiende.cl/desarrolladores/fichas_listar
 */
function APIAllFichas($aParams = array()) {
    $CI = & get_instance();

    $token = $CI->config->item('chileatiende_api_access_token');
    $url = $CI->config->item('chileatiende_api_url');
    $url_sufix = '';
    
    if ($aParams['query'])
        $url_sufix .= '&query=' . str_replace(' ', '%20', $aParams['query']);
    if (intval($aParams['maxResults']))
        $url_sufix .= '&maxResults=' . $aParams['maxResults'];
    if ($aParams['pageToken'])
        $url_sufix .= '&pageToken=' . $aParams['pageToken'];
    
    $fichas = json_decode(file_get_contents($url . 'fichas/?access_token=' . $token . $url_sufix));

    return $fichas;
}

?>
