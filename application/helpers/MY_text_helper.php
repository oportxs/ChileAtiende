<?php

function extrae_contenidos($contenido)
{
    return prepare_content_ficha($contenido, false, true);
}

function separa_contenidos($texto, $pattern, $replacement)
{
    $contenido = null;
    preg_match_all($pattern, $texto, $matches);
    if($matches){
        $contenido = preg_replace($pattern, $replacement, $matches[0]);
        $texto = preg_replace($pattern, '', $texto);
    }
    return array($texto, $contenido);
}

function prepare_content_ficha($texto, $movil=false, $separados=false, $idFicha = '') {
    $contenidos = array('videos' => array());
    $texto = preg_replace('/\[\[(\d+)\]\]/', site_url((($movil) ? 'movil/' : '') . 'fichas/ver/$1'), $texto);
    $texto = prepare_content_ficha_remove_empty_tags($texto);
    // $texto = tidy_parse_string($texto, array(), 'UTF8');

    // YOUTUBE
    // {{youtube:idvideo}}
    $pattern = '/\{\{youtube:(.*?)\}\}/';
    $replacement = '<iframe class="iframe-video iframe-youtube" width="600" height="335" src="https://www.youtube-nocookie.com/embed/$1?rel=0" frameborder="0" allowfullscreen></iframe>';
    if($separados){
        list($tmp, $contenidos['youtube']) = separa_contenidos($texto, $pattern, $replacement);
        list($texto, $contenidos['youtube_sources']) = separa_contenidos($texto, $pattern, '$1');
        $contenidos['videos'] = array_merge($contenidos['videos'],$contenidos['youtube']);
    }else{
        $texto = preg_replace($pattern, $replacement, $texto);
    }

    // VIMEO
    // {{vimeo:idvideo}}
    $pattern = '/\{\{vimeo:(.*?)\}\}/';
    $replacement = '<iframe class="iframe-video iframe-vimeo" src="https://player.vimeo.com/video/$1?title=0&amp;byline=0&amp;portrait=0" width="601" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
    if($separados){
        list($texto, $contenidos['vimeo']) = separa_contenidos($texto, $pattern, $replacement);
        list($texto, $contenidos['vimeo_sources']) = separa_contenidos($texto, $pattern, '$1');
        $contenidos['videos'] = array_merge($contenidos['videos'],$contenidos['vimeo']);
    }else{
        $texto = preg_replace($pattern, $replacement, $texto);
    }

    // PODCASTER
    // {{podcaster:idpod}}
    $pattern = '/\{\{podcaster:(.*?)\}\}/';
    $replacement = '<embed height="62" width="327" flashvars="meta=http://www.podcaster.cl/get_podcast?id=$1" wmode="transparent" quality="high" bgcolor="#FFFFFF" name="podplayer" id="podplayer" src="http://www.podcaster.cl/i/player.swf" type="application/x-shockwave-flash"/>';
    if($separados){
        list($texto, $contenidos['podcaster']) = separa_contenidos($texto, $pattern, $replacement);
    }else{
        $texto = preg_replace($pattern, $replacement, $texto);
    }

    // PASO A PASO
    // {{paso:titulo del paso}}
    $pattern = '/\{\{paso:([^\}\}]+)\}\}/';
    $replacement = '<h4 class="paso-titulo">$1</h4>';
    if($separados){
        list($texto, $contenidos['pasos']) = separa_contenidos($texto, $pattern, $replacement);
    }else{
        $texto = preg_replace($pattern, $replacement, $texto);
    }

    // PREGUNTAS FRECUENTES (los contenidos se usan también en los paso a paso)
    // {{canal[tipo]:titulo del canal}}
    $pattern = '/\{\{canal\[(.*)\]:([^\}\}]+)\}\}/';
    $replacement = '<div class="pregunta-encabezado $1"><h4>$2</h4></div>';
    if($separados){
        list($texto, $contenidos['preguntas']) = separa_contenidos($texto, $pattern, $replacement);
    }else{
        $texto = preg_replace($pattern, $replacement, $texto);
    }

    // {{contenido:texto libre}}
    $pattern = '/\{\{contenido:([^\}\}]+)\}\}/';
    $replacement = '<div class="pregunta-contenido">$1</div>';
    if($separados){
        list($texto, $contenidos['contenidos']) = separa_contenidos($texto, $pattern, $replacement);
    }else{
        $texto = preg_replace($pattern, $replacement, $texto);
    }

    // {{doc[tipo]:texto libre}}
    $pattern = '/\{\{doc\[(.*)\]:([^\}\}]+)\}\}/';
    if($separados){
        $replacement = '<tr><td class="cont-icon-doc-requerido"><div class="documento-requerido documento-tipo-$1">$1</div></td><td class="no-border">$2</td></tr>';
        list($texto, $contenidos['doc_requeridos']) = separa_contenidos($texto, $pattern, $replacement);
    }else{
        $replacement = '<div class="documento-requerido documento-tipo-$1">$2</div>';
        $texto = preg_replace($pattern, $replacement, $texto);
    }

    // {{mensaje[tipo]:texto libre}}
    $pattern = '/\{\{mensaje\[(.*)\]:([^\}\}]+)\}\}/';
    $replacement = '<div class="clearfix"></div><div class="mensaje mensaje-$1">$2</div>';
    $texto = preg_replace($pattern, $replacement, $texto);

    // {{marcolegal:texto libre}}
    $pattern = '/\{\{marcolegal:([^\}\}]+)\}\}/';
    $replacement = '<div class="marcolegal">$1</div>';
    $texto = preg_replace($pattern, $replacement, $texto);

    // {{tooltip[titulo]:texto libre}}
    $pattern = '/\{\{tooltip\[(.*)\]:([^\}\}]+)\}\}/';
    $replacement = '<span data-toggle="tooltip" title="$2" class="tooltip-ficha">$1</span>';
    $texto = preg_replace($pattern, $replacement, $texto);

    // {{infografia:enlace imagen}}
    $pattern = '/\{\{infografia:([^\}\}]+)\}\}/';
    $replacement = '<div class="cont-infografia"><div class="cont-imagen-infografia"><img src="$1" class="infografia"></div><a href="$1" class="ver-mas-infografia visible-phone">Ver original</a><a href="$1" data-toggle="modal-chileatiende" data-modal-type="img" class="ver-mas-infografia hidden-phone">Ver grande</a></div>';
    $texto = preg_replace($pattern, $replacement, $texto);

    // {{infografia-thumb[enlace]:enlace imagen}}
    $marcaGAInfografia = 'data-ga-te-category="Acciones Ficha" data-ga-te-action="Fichas - Infografia Thumbnail" data-ga-te-value="'.$idFicha.'"';
    $pattern = '/\{\{infografia\-thumb\[(.*)\]:([^\}\}]+)\}\}/';
    $replacement = '<div class="cont-infografia-thumbnail cont-infografia"><div class="cont-link-infografia"><a '.$marcaGAInfografia.' href="$2" data-toggle="modal-chileatiende" data-modal-type="img" class="link-infografia">Ver infografía</a></div><div class="cont-imagen-infografia"><img src="$1" class="infografia"><a '.$marcaGAInfografia.' href="$2" class="ver-mas-infografia visible-phone">Ver original</a><a '.$marcaGAInfografia.' href="$2" data-toggle="modal-chileatiende" data-modal-type="img" class="ver-mas-infografia hidden-phone">Ver grande</a></div></div>';
    $texto = preg_replace($pattern, $replacement, $texto);

    // {{campo[nombre_campo]:texto libre}}
    $pattern = '/\{\{campo\[(.*)\]:([^\}\}]+)\}\}/';
    $replacement = '<a href="" data-modal-type="div" data-modal-id="campo-$1" data-toggle="modal-chileatiende">$2</a>';
    $texto = preg_replace($pattern, $replacement, $texto);

    if($separados){
        $contenidos['texto'] = $texto;
        return $contenidos;
    }else{
        return $texto;
    }
    
}

function prepare_content_ficha_remove_empty_tags($texto)
{
    //Se eliminan <br>
    $texto = str_replace('<br>', '', $texto);
    $texto = str_replace('<br/>', '', $texto);
    $texto = str_replace('<br />', '', $texto);

    //Se eliminan <p>
    $pattern = '/<p[^>]*><\\/p[^>]*>/';
    $texto = preg_replace($pattern, '', $texto);

    return preg_replace($pattern, '', $texto);
}

function prepare_content_ficha_resumen($texto, $word_limit, $strip_tags = false) {
    $texto = prepare_content_ficha($texto);

	 	if($strip_tags)
	 		$texto = strip_tags($texto);

		$texto = word_limiter($texto, $word_limit);
    $texto = preg_replace('/\{\{.*\}\}/', '', $texto);

    return $texto;
}

function prepare_search_terms($needle) {

    if (!$needle)
        return "";

    //$needle = leave_alpha_numerical($needle);
    $needle = preg_replace('/[aàáâãåäæAÁ]/iu', '[aàáâãåäæAÁ]', $needle);
    $needle = preg_replace('/[eèéêëEÉ]/iu', '[eèéêëEÉ]', $needle);
    $needle = preg_replace('/[iìíîïÍI]/iu', '[iìíîïÍI]', $needle);
    $needle = preg_replace('/[oòóôõöøÓO]/iu', '[oòóôõöøÓO]', $needle);
    $needle = preg_replace('/[uùúûüUÚ]/iu', '[uùúûüUÚ]', $needle);
    return $needle;
}

function highlight_phrases($content, $needles) {
    foreach($needles as $n)
        $content=  highlight_phrase ($content, $n);
    
    return $content;
}

function leave_alpha_numerical($string) {
    return trim(preg_replace('/[^A-Za-z0-9aàáâãåäæAÁeèéêëEÉiìíîïÍIoòóôõöøÓOuùúûüUÚñÑ ]/i', '', $string));
}

function debug($string="", $color="black", $whereis = FALSE, $level = 1) {

    $inf = debug_backtrace();

    $info = $inf[$level - 1];

    $file = $info['file'];
    $line = $info['line'];

    echo "<pre style='width: 900px; color:$color;'>";
    if ($whereis)
        print_r("<div style='padding: 5px;'><b>Debug:</b> En linea <b>$line</b>, dentro del archivo <b>$file</b></div>");
    echo "<div style='padding-left: 15px;'>";
    print_r($string);
    echo "</div>";
    echo "</pre>";
}

function search_smart_truncate($text, $len, $needles) {
    if (is_array($needles) && count($needles)) {
        return truncatePreserveWords($text, $needles);
    } else {
        if (str_len($txt) > $len) {
            return word_limiter($text, $len);
        }
    }
}

function truncatePreserveWords($text, $needles, $w_near_keywords=30, $class="highlight") {
    $b = explode(" ", trim(strip_tags($text))); //haystack words
    $c = array();      //array of words to keep/remove
    for ($j = 0; $j < count($b); $j++)
        $c[$j] = false;
    for ($i = 0; $i < count($b); $i++)
        for ($k = 0; $k < count($needles); $k++)
            if (stristr($b[$i], $needles[$k])) {
                //$b[$i]=preg_replace("/".$needles[$k]."/i","<$tag $class>\\0</$tag>",$b[$i]);
                for ($j = max($i - $w_near_keywords, 0); $j < min($i + $w_near_keywords, count($b)); $j++)
                    $c[$j] = true;
            }
    $o = ""; // reassembly words to keep
    for ($j = 0; $j < count($b); $j++)
        if ($c[$j])
            $o.=" " . $b[$j]; else
            $o.=".";
    return highlight_phrases(preg_replace("/\.{3,}/i", "...", $o), $needles, $class);
}

function botonTramiteOnlineMini($ficha, $texto = 'Ir al trámite'){
    $id_ficha_original = isset($ficha['metaficha']) ? $ficha->Maestro->id : $ficha->MetaFicha->id;

    $gaCategory = uri_string() == 'buscar/fichas' ? 'Acciones Buscador' : 'Acciones Ficha';
    $boton_mini = '';

    if($ficha->guia_online_url){
        $boton_mini = '
        <div class="proj-div" data-toggle="modal" style="width: 222px" data-target="#redirectModal">
                <input type="button" id="boton_ir_a_tramite" class="btn btn-ir-tramite-online t_online rs_skip" alt="Realizar en línea" data-ga-te-category="'.$gaCategory.'" data-ga-te-action="Botón Trámite Online" data-ga-te-value="'.$id_ficha_original.'" value="'.$texto.'" />
        </div>

        <div id="redirectModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #0148A2">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <!--<h4 class="modal-title" id="myModalLabel">Redireccionando...</h4>-->
                <img style="height: 70px" src="/assets_v2/img/nueva_home/logo_chileatiende.png">
              </div>
                <div class="modal-body" style="font-family: Helvetica, Arial, sans-serif; font-weight: 100;height: 120px !important; padding: 30px !important; text-align: center;">
                    Para realizar tu trámite te <b>redirigiremos</b> al sitio web institucional de '.$ficha->Servicio->nombre.($ficha->Servicio->sigla?' ('.$ficha->Servicio->sigla.')':'').'
                    <br>
                    <a target="_blank" id="btn_ir_y_cerrar" style="text-decoration: none;" href="'.$ficha->guia_online_url.'">
                        <button type="button" class="btn btn-primary" style="margin: 20px 10px 5px 10px; padding: 10px 20px; border: none;">Entendido</button>
                    </a>
                    <br>
                    <a id="btn_close_modal" href="" data-dismiss="modal" style="color: gray;font-size: 0.8em;">Prefiero seguir en ChileAtiende</a>
                    <br>
                </div>
              <div class="modal-footer" style="background-color: #1a1d21;">
                <img src="/assets_v2/img/logo_gobierno_footer.png" style="height: 35px">
              </div>
            </div>
          </div>
        </div>
        ';
    }
    return $boton_mini;
}

function botonTramiteOnlineSidebar($ficha, $texto = 'Ir al trámite en línea')
{
    $id_ficha_original = isset($ficha['metaficha']) ? $ficha->Maestro->id : $ficha->MetaFicha->id;

    $gaCategory = uri_string() == 'buscar/fichas' ? 'Acciones Buscador' : 'Acciones Ficha';
    $botonTramiteOnlineSidebar = '';

    if($ficha->guia_online_url){
        $botonTramiteOnlineSidebar = '
        <div class="proj-div" style="padding-top: 40px;">
                <input type="button" id="boton_ir_a_tramite_sidebar" class="btn btn-ir-tramite-online-sidebar t_online rs_skip" alt="Realizar en línea" data-ga-te-category="'.$gaCategory.'" data-ga-te-action="Botón Trámite Online" data-ga-te-value="'.$id_ficha_original.'" value="'.$texto.'" />
                <i class="fa fa-long-arrow-right arrow-ir-al-tramite-sidebar" id="arrow-ir-al-tramite-sidebar" style="cursor: pointer" aria-hidden="true"></i>
        </div>
        ';
    } 
    return $botonTramiteOnlineSidebar;
}

function botonTramiteOnline($ficha, $texto = 'Ir al trámite en línea')
{
    // INFO: se agrega para usar la misma funcion en Fichas y SubFichas
    $id_ficha_original = isset($ficha['metaficha']) ? $ficha->Maestro->id : $ficha->MetaFicha->id;

    $gaCategory = uri_string() == 'buscar/fichas' ? 'Acciones Buscador' : 'Acciones Ficha';
    $botonTramiteOnline = '';

    if($ficha->guia_online_url)
        // $botonTramiteOnline = '<a class="btn btn-ir-tramite-online t_online rs_skip" href="'.$ficha->guia_online_url.'" target="_blank" alt="Realizar en línea" data-ga-te-category="'.$gaCategory.'" data-ga-te-action="Botón Trámite Online" data-ga-te-value="'.$id_ficha_original.'">'.$texto.'</a>';
$botonTramiteOnline = '
<div class="proj-div" data-toggle="modal" style="width: 222px" data-target="#redirectModal">
        <input type="button" id="boton_ir_a_tramite" class="btn btn-ir-tramite-online t_online rs_skip" alt="Realizar en línea" data-ga-te-category="'.$gaCategory.'" data-ga-te-action="Botón Trámite Online" data-ga-te-value="'.$id_ficha_original.'" value="'.$texto.'" />
        <i class="fa fa-long-arrow-right arrow-ir-al-tramite" aria-hidden="true" style="cursor:pointer"></i>
</div>

<div id="redirectModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #0148A2">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
        <!--<h4 class="modal-title" id="myModalLabel">Redireccionando...</h4>-->
        <img style="height: 70px" src="/assets_v2/img/nueva_home/logo_chileatiende.png">
      </div>
      <div class="modal-body" style="font-family: Helvetica, Arial, sans-serif; font-weight: 100;height: 120px !important; padding: 30px !important; text-align: center;">
        Para realizar tu trámite te <b>redirigiremos</b> al sitio web institucional de '.$ficha->Servicio->nombre.($ficha->Servicio->sigla?' ('.$ficha->Servicio->sigla.')':'').'
        <br>
        <a target="_blank" id="btn_ir_y_cerrar" style="text-decoration: none;" href="'.$ficha->guia_online_url.'">
            <button type="button" class="btn btn-primary" style="margin: 20px 10px 5px 10px; padding: 10px 20px; border: none;">Entendido</button>
        </a>
        <br>
        <a id="btn_close_modal" href="" data-dismiss="modal" style="color: gray;font-size: 0.8em;">Prefiero seguir en ChileAtiende</a>
        <br>
      </div>
      <div class="modal-footer" style="background-color: #1a1d21;">
        <img src="/assets_v2/img/logo_gobierno_footer.png" style="height: 35px">
      </div>
    </div>
  </div>
</div>
';
    return $botonTramiteOnline;
}

function botonMejorarTramite($obj, $tipoTramite = 'online')
{
    // INFO: se agrega para usar la misma funcion en Fichas y SubFichas
    $ficha = isset($obj['metaficha']) ? $obj : $obj->MetaFicha;
    $agradecimiento = '<div class="btn btn-mejorar-tramite mejora-agradecimiento" style="display:none;">Gracias por su opinión</div>';
    if(!$obj->guia_online_url){
        return $agradecimiento . '<a id="btn-mejora" class="btn btn-quiero-tramite-online rs_skip" href="#" data-ga-te-category="Fichas" data-ga-te-action="Botón Quiero Trámite Online" data-ga-te-value="'.$ficha->Maestro->id.'">Quisiera este trámite disponible en línea</a>';
    }else{
        //return $agradecimiento . '<a id="btn-mejora" class="btn btn-mejorar-tramite rs_skip" href="#" data-ga-te-category="Fichas" data-ga-te-action="Botón Mejorar Trámite" data-ga-te-value="'.$ficha->Maestro->id.'">¿Podemos mejorar este trámite?</a>';
    }
}

/**
 * Create a web friendly URL slug from a string.
 * 
 * Although supported, transliteration is discouraged because
 *     1) most web browsers support UTF-8 characters in URLs
 *     2) transliteration causes a loss of information
 *
 * @author Sean Murphy <sean@iamseanmurphy.com>
 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
 * @license http://creativecommons.org/publicdomain/zero/1.0/
 *
 * @param string $str
 * @param array $options
 * @return string
 */
function url_slug($str, $options = array()) {
    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => false,
    );
    
    // Merge options
    $options = array_merge($defaults, $options);
    
    $char_map = array(
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
        'ß' => 'ss', 
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
        'ÿ' => 'y',
 
        // Latin symbols
        '©' => '(c)',
 
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
 
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 
 
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
 
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
 
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
        'Ž' => 'Z', 
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z', 
 
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
        'Ż' => 'Z', 
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
 
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );
    
    // Make custom replacements
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    
    // Transliterate characters to ASCII
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    
    // Replace non-alphanumeric characters with our delimiter
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    
    // Remove duplicate delimiters
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    
    // Truncate slug to max. characters
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    
    // Remove delimiter from ends
    $str = trim($str, $options['delimiter']);
    
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

/*
  Paul's Simple Diff Algorithm v 0.1
  (C) Paul Butler 2007 <http://www.paulbutler.org/>
  May be used and distributed under the zlib/libpng license.

  This code is intended for learning purposes; it was written with short
  code taking priority over performance. It could be used in a practical
  application, but there are a few ways it could be optimized.

  Given two arrays, the function diff will return an array of the changes.
  I won't describe the format of the array, but it will be obvious
  if you use print_r() on the result of a diff on some test data.

  htmlDiff is a wrapper for the diff command, it takes two strings and
  returns the differences in HTML. The tags used are <ins> and <del>,
  which can easily be styled with CSS.
 */

function diff($old, $new) {
    $maxlen = 0;
    foreach ($old as $oindex => $ovalue) {
        $nkeys = array_keys($new, $ovalue);
        foreach ($nkeys as $nindex) {
            $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                    $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
            if ($matrix[$oindex][$nindex] > $maxlen) {
                $maxlen = $matrix[$oindex][$nindex];
                $omax = $oindex + 1 - $maxlen;
                $nmax = $nindex + 1 - $maxlen;
            }
        }
    }
    if ($maxlen == 0)
        return array(array('d' => $old, 'i' => $new));
    return array_merge(
                    diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)), array_slice($new, $nmax, $maxlen), diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
}

function htmlDiff($old, $new) {
    $ret = '';
    $diff = diff(explode(' ', $old), explode(' ', $new));
    foreach ($diff as $k) {
        if (is_array($k))
            $ret .= (!empty($k['d']) ? "<del>" . implode(' ', $k['d']) . "</del> " : '') .
                    (!empty($k['i']) ? "<ins>" . implode(' ', $k['i']) . "</ins> " : '');
        else
            $ret .= $k . ' ';
    }
    return $ret;
}

function comparar($obja, $objb, $field) {
    if ($obja->$field == $objb->$field) {
        return $obja->$field;
    } else {
        return htmlDiff($obja->$field, $objb->$field);
    }
}

