<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calendario extends CI_Controller {
    /*

    public function index($anio=null, $mes=null) {
        $filtro_region      = $this->input->get('r') ? explode(',',$this->input->get('r')) : array();
        $filtro_institucion = $this->input->get('i') ? explode(',',$this->input->get('i')) : array();
        $es_empresa         = $this->input->get('e') && $this->input->get('e') == 1 ? true:false;

        $prefs = array (
            'show_next_prev'  => TRUE,
            'next_prev_url'   => '/calendario/index',
            'start_day' 	  => 'monday',
            'day_type'		  => 'long',
            'template'		  => 
            '
                {heading_row_start}<div class="calendario_title">{/heading_row_start}
                {heading_previous_cell}<a href="{previous_url}?r='.implode(',', $filtro_region).'&i='.implode(',', $filtro_institucion).($es_empresa?'&e=1':'').'" title="Mes Anterior">&lt;</a>&nbsp;{/heading_previous_cell}
                {heading_title_cell}{heading}{/heading_title_cell}
                {heading_next_cell}&nbsp;<a href="{next_url}?r='.implode(',', $filtro_region).'&i='.implode(',', $filtro_institucion).($es_empresa?'&e=1':'').'" title="Proximo Mes">&gt;</a>{/heading_next_cell}
                {heading_row_end}</div>{/heading_row_end}

                {table_open}<div class="calendario_container">{/table_open}
                {week_row_start}<div class="calendario_week">{/week_row_start}
                {week_day_cell}<div class="calendario_week_day">{week_day}</div>{/week_day_cell}
                {week_row_end}</div>{/week_row_end}

                {cal_row_start}<div class="calendario_cal">{/cal_row_start}
                {cal_cell_start}<div class="calendario_cal_day">{/cal_cell_start}


                {cal_cell_content}<span>{day}</span>{content}'."\n".'{/cal_cell_content}
                {cal_cell_content_today}<span>{day}</span>{content}'."\n".'{/cal_cell_content_today}

                {cal_cell_no_content}<span>{day}</span>'."\n".'{/cal_cell_no_content}
                {cal_cell_no_content_today}<span>{day}</span>'."\n".'{/cal_cell_no_content_today}

                {cal_cell_blank}&nbsp;{/cal_cell_blank}


                {cal_cell_end}</div>{/cal_cell_end}
                {cal_row_end}</div>{/cal_row_end}
                {table_close}</div>{/table_close}
                '
        );

        $this->load->library('calendar',$prefs);
        $this->load->library('calendario_pymes',$prefs);

        $data['title'] = 'Calendario';
        $data['content'] = 'calendario/index';
        $data['es_empresa'] = $es_empresa;
        $data['anio'] = isset($anio) ? $anio : date('Y');
        $data['mes'] = isset($mes) ? $mes : date('n');

        $lastDayMonth = date("t", strtotime(date($data['anio'].'-'.$data['mes'].'-'.date('d'))));
        $evento_options = array(
            'publicados' => true,
            'actuales' => false,
            'permanentes' => false,
            'inicio' => $data['anio'].'-'.$data['mes'].'-1',
            'fin' => $data['anio'].'-'.$data['mes'].'-'.$lastDayMonth,
            'regiones' => $filtro_region,
            'instituciones' => $filtro_institucion,
            'tipo' => $es_empresa ? 'empresas' : 'personas',
        );
        $eventos = Doctrine::getTable('Evento')->getEventos($evento_options);

        $background_colors = array("#ccd3e6","#e8f5fd","#aacae3","#c4e4f3", "#b2c2d1", "#d6e0f5", "#c2c2f3");

        $data['data']['events'] = array();
        $n_events = 0;
        $eventos_id = array();

        foreach($eventos as $e) 
        {
            $eventos_id[] = $e->id;
            $sameStartMonthYear = date('n Y', strtotime($e['postulacion_start'])) == date('n Y', strtotime('01-'.$data['mes'].'-'.$data['anio']));
            $sameEndMonthYear = date('n Y', strtotime($e['postulacion_end'])) == date('n Y', strtotime('01-'.$data['mes'].'-'.$data['anio']));
            $event_start = ($sameStartMonthYear) ? date('j', strtotime($e['postulacion_start'])) : 1; 
            $event_end = ($sameEndMonthYear) ? date('j', strtotime($e['postulacion_end'])) : $lastDayMonth;


            $expiro = strtotime($e->postulacion_end) < strtotime(date("Y-m-d")) ? true : false;
            $bgcolor = $expiro ? '#AAAAAA' : array_pop($background_colors);
            $event_data = Array(
                'titulo' => $e->titulo, 
                'url' => preg_replace('/\[\[(\d+)\]\]/', site_url('fichas/ver/$1'), $e->url),
                'bgcolor' =>  $bgcolor,
                'event_start' => $e->postulacion_start,
                'event_end' => $e->postulacion_end,
                'start' => $event_start,
                'end' => $event_end,
                'info' => $e->informacion,
                'regiones' => $e->Regiones,
                'institucion' => $e->Servicio->nombre,
                'expiro' => $expiro,
            );

            $data['data']['events'][$n_events] =  $event_data;
            $data['data'][$event_start][] = $n_events++;
        }

        $data['filtro_region'] = $filtro_region;
        $data['filtro_institucion'] = $filtro_institucion;
        $data['regiones'] = Doctrine::getTable('Region')->findAll();
        $data['data']['regiones'] = $data['regiones'];
        $data['instituciones'] = Doctrine::getTable('Servicio')->findServiciosBusquedaEventos(implode(',', $eventos_id));

        $theme = $es_empresa ? 'template_emprendete_v2' : 'template_v2';
        $this->output->cache($this->config->item('cache'));
        $this->load->view($theme, $data);
    }

    public function permanentes() {
        $filtro_region      = $this->input->get('r') ? explode(',',$this->input->get('r')) : array();
        $filtro_institucion = $this->input->get('i') ? explode(',',$this->input->get('i')) : array();
        $es_empresa         = $this->input->get('e') && $this->input->get('e') == 1 ? true:false;

        $evento_options = array(
            'publicados' => true,
            'permanentes' => true,
            'regiones' => $filtro_region,
            'instituciones' => $filtro_institucion,
            'tipo' => $es_empresa ? 'empresas' : 'personas',
            'limit' => 15,
            'offset' => $this->input->get('offset') ? $this->input->get('offset') : 0,
        );

        $eventos = Doctrine::getTable('Evento')->getEventos($evento_options);
        $evento_options['justCount'] = true;
        $noeventos = Doctrine::getTable('Evento')->getEventos($evento_options);
        
        $this->pagination->initialize(array(
            'base_url' => site_url('calendario/permanentes?' . ($es_empresa ? 'e=1' : '')),
            'total_rows' => $noeventos,
            'per_page' => $evento_options['limit']
        ));

        $eventos_id = array();
        $data['eventos'] = array();
        foreach($eventos as $e) 
        {
            $eventos_id[] = $e->id;
            $event_data = array(
                'titulo' => $e->titulo, 
                'url' => preg_replace('/\[\[(\d+)\]\]/', site_url('fichas/ver/$1'), $e->url),
                'info' => $e->informacion,
                'regiones' => $e->Regiones,
                'institucion' => $e->Servicio
            );
            $data['eventos'][] = $event_data;
        }

        $data['title'] = 'Eventos Permanentes';
        $data['content'] = 'calendario/permanentes';
        $data['es_empresa'] = $es_empresa;
        $data['filtro_region'] = $filtro_region;
        $data['filtro_institucion'] = $filtro_institucion;
        $data['regiones'] = Doctrine::getTable('Region')->findAll();
        $data['instituciones'] = Doctrine::getTable('Servicio')->findServiciosBusquedaEventos(implode(',', $eventos_id));

        $theme = $es_empresa ? 'template_emprendete_v2' : 'template_v2';
        $this->output->cache($this->config->item('cache'));
        $this->load->view($theme, $data);
    }
    */
}
