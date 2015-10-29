<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacto extends CI_Controller {
    public function index() {
        $data['title'] = 'Contacto';
        $data['content'] = 'contacto/ver';

        $this->load->view('template', $data);
    }

    function enviaramigo() {
        $data['is_ajax'] = $this->input->is_ajax_request();
        if($data['is_ajax']){
            $this->load->view('contacto/enviaramigo', $data);
        }else{
            $data['title'] = 'Contacto';
            $data['content'] = 'contacto/enviaramigo';

            $this->load->view('template', $data);
        }
    }

    function enviaemailamigo() {
        $this->form_validation->set_rules('nombres','Nombres','required');
        //$this->form_validation->set_rules('apellido_paterno','Apellido Paterno','required');
        $this->form_validation->set_rules('email','Correo Electrónico','required|valid_email');
        //datos amigo
        $this->form_validation->set_rules('nombres_a','Nombres','required');
        //$this->form_validation->set_rules('apellido_paterno_a','Apellido Paterno','required');
        $this->form_validation->set_rules('email_a','Correo Electrónico','required|valid_email');

        if($this->form_validation->run()==TRUE){
            $contacto->nombres=$this->input->post('nombres');
            //$contacto->apellido_paterno=$this->input->post('apellido_paterno');
            //$contacto->apellido_materno=$this->input->post('apellido_materno');
            $contacto->email=$this->input->post('email');
            $contacto->comentarios=$this->input->post('comentarios');
            //datos amigo
            $contacto->nombres_a=$this->input->post('nombres_a');
            //$contacto->apellido_paterno_a=$this->input->post('apellido_paterno_a');
            //$contacto->apellido_materno_a=$this->input->post('apellido_materno_a');
            $contacto->email_a=$this->input->post('email_a');

            $data['contacto']=$contacto;

            $this->email->from('chileatiende@chileatiende.gob.cl','ChileAtiende');
            $this->email->to($contacto->email_a);
            $this->email->subject($contacto->nombres_a.' tu amigo '.$contacto->nombres);
            $this->email->message($this->load->view('mails/amigo',$data,TRUE));
            $this->email->send();

            $respuesta->redirect=$this->input->server('HTTP_REFERER');
            $respuesta->msg='<div class="alert alert-success">Se ha enviado correctamente el mensaje a su amigo.</div>';
            $respuesta->validacion=TRUE;
        }else{
            $respuesta->validacion=FALSE;
            $respuesta->msg='<div class="alert alert-error">Los campos marcados con * son obligatorios</div>';
        }

        echo json_encode($respuesta);
    }
    
    
    public function sugerencias(){
        $this->load->view('contacto/sugerencias');
    }

    public function sugerencias_form(){
        if($this->input->post('correo'))
            exit;
        
        
        $this->form_validation->set_rules('nombres','Nombres','required');
        $this->form_validation->set_rules('paterno','Apellido Paterno','required');
        $this->form_validation->set_rules('materno','Apellido Materno','required');
        $this->form_validation->set_rules('tema','Tema','required');
        $this->form_validation->set_rules('email','Correo Electrónico','required|valid_email');
        $this->form_validation->set_rules('comentarios','Comentarios','required');


        if($this->form_validation->run()==TRUE){
            $data['nombres']=$this->input->post('nombres');
            $data['paterno']=$this->input->post('paterno');
            $data['materno']=$this->input->post('materno');
            $data['tema']=$this->input->post('tema');
            $data['email']=$this->input->post('email');
            $data['comentarios']=$this->input->post('comentarios');
            
            $this->email->from('chileatiende@chileatiende.cl','ChileAtiende');
            $this->email->to('gustavo.rojas@chileatiende.cl');
            $this->email->cc('fmancini@minsegpres.gob.cl');
            $this->email->subject('[ChileAtiende] Sugerencias ChileAtiende V2');
            $this->email->message($this->load->view('mails/sugerencias',$data,TRUE));
            $this->email->send();

            //$respuesta->redirect=$this->input->server('HTTP_REFERER');
            $respuesta->msg='<div class="alert alert-success">Se ha enviado correctamente el mensaje.</div>';
            $respuesta->validacion=TRUE;
        }else{
            $respuesta->validacion=FALSE;
            $respuesta->msg='<div class="alert alert-error">Todos los campos son obligatorios</div>';
        }

        echo json_encode($respuesta);
    }

}
