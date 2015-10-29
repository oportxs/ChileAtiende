<?php

/*Este set de parametros debe ser configurado de acuerdo a los parametros asignados en sphinx.conf*/

$config = array(
    "port"=>9312, //el port se obtiene al correr searchd
    'server'=>"localhost",
    'index' => 'redchile_fichas',
    'index_log_busquedas' => 'log_busquedas'
    );


?>