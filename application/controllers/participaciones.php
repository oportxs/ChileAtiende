<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Participaciones extends CI_Controller {

    public function ajax_guarda_participacion_opinion($ficha_id = null)
    {
        $informacionutil = $this->input->get('informacionutil')=='s';
        $busquedafacil = $this->input->get('busquedafacil')=='s';
        $quemejorar = $this->input->get('quemejorar');
        $honeypot = $this->input->get('nombre');

        /*Se debe validar que no exista un nombre ingresado, se usa este campo como metodo antispam*/
        if(!$honeypot){
            $participacion = new ParticipacionOpinion();
            $participacion->ficha_id = $ficha_id;
            $participacion->informacion_util = $informacionutil;
            $participacion->informacion_facil_de_encontrar = $busquedafacil;
            $participacion->que_podemos_mejorar = $quemejorar;
            $participacion->save();

            $respuesta = array('error' => false, 'msg' => 'Gracias por sus sugerencias.');
            $this->output->set_content_type('application/json')->set_output(json_encode($respuesta));
        }
    }

    public function ajax_guarda_participacion_error($ficha_id = null)
    {
        $descripcion = $this->input->get('errorestramite');
        $honeypot = $this->input->get('nombre');

        /*Se debe validar que no exista un nombre ingresado, se usa este campo como metodo antispam*/
        if(!$honeypot){
            $participacion = new ParticipacionErrores();
            $participacion->ficha_id = $ficha_id;
            $participacion->descripcion = $descripcion;
            $participacion->save();

            $respuesta = array('error' => false, 'msg' => 'Gracias por sus sugerencias.');
            $this->output->set_content_type('application/json')->set_output(json_encode($respuesta));
        } 
    }

}