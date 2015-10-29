<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Embed extends CI_Controller{
    public function header(){
        $this->load->view('embed/header');
    }

    public function footer(){
        $this->load->view('embed/footer');
    }
}