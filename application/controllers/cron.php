<?php

class Cron extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        if(!$this->input->is_cli_request())
            exit;
    }
    
    public function hourly(){
        //Indexamos las busquedas en Sphinx
        system('cd sphinx; searchd; indexer --rotate --all');
    }
    
    public function daily(){
        //Hacemos un respaldo de la base de datos
        $this->load->database();
        $backupName = $this->db->database . '_' . date("Ymd-His") . '.gz';
        $command = 'mysqldump -h '.$this->db->hostname.' -u '.$this->db->username.' -p'.$this->db->password.' '.$this->db->database.' | gzip > '.$backupName;
        system($command);
        $this->load->library('s3wrapper');
        $this->s3wrapper->putObject($this->s3wrapper->inputFile($backupName, false), 'chileatiende.cl', $backupName);
        system('rm ' . $backupName);
    }
    
    public function weekly(){
        //Calculamos las fichas similares
        TrackSesion::calcularFichasSimilares();
    }
    
}