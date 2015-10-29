<?php

function loadAssets($assets, $type = 'js'){
    $assetString = '';
    if(!isset($assets[$type]))
        return $assetString;

    foreach($assets[$type] as $path){
        if($type == 'js')
            $assetString .= loadJavascriptAssets($path);
        if($type == 'css')
            $assetString .= loadStylesheetAssets($path);
    }
    return $assetString;
}

function loadJavascriptAssets($path){
    return '<script src="'.base_url($path).'"></script>';
}

function loadStylesheetAssets($path){
    return '<link rel="stylesheet" href="'.base_url($path).'" />';
}