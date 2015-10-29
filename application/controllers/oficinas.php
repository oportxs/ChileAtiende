<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Oficinas extends CI_Controller {

    public function ajax_load_infowindow($oficina_id) {

        $oficina=Doctrine::getTable('Oficina')->find($oficina_id);
        $data['oficina']=$oficina;

        $this->load->view('oficinas/ajax_load_infowindow', $data);
    }

    public function index($field='',$order='') {
        
        $tipo = $this->input->get('e') ? 'empresas' : 'personas';

        $options = array();
        $options['offset'] = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $options['order_by'] = $field ? $field.' '.$order : 'o.sector_codigo ASC';
        $options['tipo'] = $tipo;
        $options['limit'] = 10;
        $options['sector'] = null;

        if($this->input->get('region')){
            $options['sector'] = $this->input->get('region');
        }
        if($this->input->get('provincia')){
            $options['sector'] = $this->input->get('provincia');
        }
        if($this->input->get('comuna')){
            $options['sector'] = $this->input->get('comuna');
        }
        if($this->input->get('sector')){
            $options['sector'] = $this->input->get('sector');
        }

        $oficinas = Doctrine::getTable('Oficina')->allOficinas($options);
        $options['justCount'] = true;
        $noficinas = Doctrine::getTable('Oficina')->allOficinas($options);

        $data['regiones'] = Doctrine::getTable('Sector')->findWithOptions(array('tipo'=>'region'));
        $data['provincias'] = Doctrine::getTable('Sector')->findWithOptions(array('tipo'=>'provincia', 'orderby' => 's.nombre ASC'));
        $data['comunas'] = Doctrine::getTable('Sector')->findWithOptions(array('tipo'=>'comuna', 'orderby' => 's.nombre ASC'));

        $data['ultima_actualizacion'] = Doctrine::getTable('Oficina')->getUltimaActualizacion();
        $data['sector_codigo'] = $options['sector'];
        $data['oficinas'] = $oficinas;
        $data['title'] = 'Oficinas';
        $data['content'] = 'oficinas/index_v2';

        $data['count_sucursales'] = Doctrine::getTable('Oficina')->countTotal();
        $data['count_tramites'] = Doctrine::getTable('TramiteEnConvenio')->countTotal();

        $orderby = ($field ? $field.'/'.$order : 'o.sector_codigo/ASC').'?';
        $orderby = $orderby.($options['sector']?'sector='.$options['sector']:'');

        //Se configura la paginacion
        $this->pagination->initialize(array(
            'base_url' => site_url('oficinas/index/' . $orderby),
            'total_rows' => $noficinas,
            'per_page' => $options['limit']
        ));

        //habilitamos el cache
        $this->output->cache($this->config->item('cache'));

        if($this->input->is_ajax_request()){
            $theme = ($this->input->get('e')) ? 'oficinas/tmpl_emprendete_oficinas' : 'oficinas/tmpl_oficinas';
            $output['error'] = false;
            $output['oficinas'] = $this->load->view($theme, $data, true);
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }else{
            $theme = ($this->input->get('e')) ? 'template_emprendete_v2' : 'template_v2';
            $this->load->view($theme, $data);
        }
    }

    function exporta($formato) {
        header('Content-Disposition: attachment; filename="oficinas-chileatiende.'.$formato.'"');
        header('Content-type: text/'.$formato);
        $query = Doctrine::getTable('Oficina')->findAll();
        echo $query->exportTo($formato);
    }

    function exportacsv() {
        $query = Doctrine::getTable('Oficina')->findAll();
        $aOficinas = $query->toArray();

        array_to_csv($aOficinas, 'oficinas-chileatiende.csv');
    }

}