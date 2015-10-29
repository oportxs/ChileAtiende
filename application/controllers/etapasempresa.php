<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EtapasEmpresa extends CI_Controller {

	public function getApoyosByEtapaId() {
		$etapa_id = $this->input->get('etapa_id');
		$apoyos = Doctrine::getTable('EtapaEmpresa')->getApoyosByEtapa($etapa_id);
		$retorna = $apoyos->toArray();

		echo json_encode($retorna);
	}

	public function getHechosEmpresaByEtapaId() {
        $etapa_id = $this->input->get('etapa_id');
        $apoyos = Doctrine::getTable('EtapaEmpresa')->getHechosEmpresaByEtapa($etapa_id);
        $retorna = $apoyos->toArray();

        echo json_encode($retorna);
    }

    public function MasDestacadasByEtapaId() {
    	$etapa_id = $this->input->get('etapa_id');
        $destacados_1 = Doctrine::getTable('EtapaEmpresa')->DestacadosByEtapaHechosEmpresa($etapa_id);
        $destacados_2 = Doctrine::getTable('EtapaEmpresa')->DestacadosByEtapaApoyosEstado($etapa_id);
        $hechos_empresa = count($destacados_1) > 0 ? $destacados_1[0]["HechosEmpresa"] : array();
        $apoyos_estado = count($destacados_2) > 0 ? $destacados_2[0]["ApoyosEstado"] : array();
        $new_data = array();
        
        foreach($hechos_empresa as $he)
            foreach ($he['Fichas'] as $ficha)
                $new_data[] = $ficha;

        foreach($apoyos_estado as $ae)
            foreach ($ae['Fichas'] as $ficha)
                $new_data[] = $ficha;

        shuffle($new_data);
        echo json_encode(array_slice($new_data, 0, count($new_data) < 4 ? count($new_data) : 4));
    }
}