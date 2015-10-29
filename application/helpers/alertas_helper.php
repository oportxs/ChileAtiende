<?php

function getAlertasUrl(){
    $CI = get_instance();
    $alertas = Doctrine::getTable('Alerta')->findAlertsForUrl(current_url());
    $result = '';
    if(count($alertas)){
        $result = $CI->load->view('widget/alertas', array('alertas' => $alertas), true);
    }
    return $result;
}