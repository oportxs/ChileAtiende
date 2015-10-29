<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fichas extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function ver($id){
        redirect(site_url('fichas/ver/'.$id), 'location', 301);
        if(!$data=apc_fetch('movil_fichas_ver_data'.$id)){

            $data['theme_page'] = "d";
            $data['theme_header'] = "a";

            $ficha = Doctrine::getTable('Ficha')->findPublicado($id);

            if($ficha[0]->titulo) {
                $data['title'] = $ficha[0]->titulo;
                if($ficha[0]->flujo)
                    $data['content'] = 'movil/verflujo';
                else
                    $data['content'] = 'movil/verficha';
                $data['vista_ficha'] = true;
                $data['ficha'] = $ficha[0];
                
                if($this->config->item('cache'))
                    apc_store('movil_fichas_ver_data'.$id, $data, 60*$this->config->item('cache'));

            } else {
                redirect('movil/ficha/error/');
            }
        
        }

        $this->load->view('movil/template', $data);
    }
    
}
