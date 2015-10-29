<?php

class Estadisticas extends CI_Controller
{

    private $mainSource = 'https://docs.google.com/spreadsheet/pub?key=0AlgKtkYSoaWidDdRdXdkM3F6dTE1b1BtcmRRRGp2blE&single=true&output=csv&gid='; //Producción
//    private $mainSource = 'https://docs.google.com/spreadsheet/pub?key=0AinNhkqmnRezdDdKNUdJLUx0VlVTTjVJcHhqTWtXcWc&single=true&output=csv&gid='; //Desarrollo

    private $sources = array();

    private $dataPath = '';

    function __construct()
    {
        parent::__construct();

        $this->sources['num-atenciones'] = $this->mainSource.'0';
        $this->sources['visitas-sitio'] = $this->mainSource.'1';
        $this->sources['presencial-region'] = $this->mainSource.'2';
        $this->sources['instituciones-region'] = $this->mainSource.'3';
        $this->sources['tiempo-espera'] = $this->mainSource.'5';
        $this->sources['evolucion-sucursales'] = $this->mainSource.'6';
        $this->sources['numero-comunas'] = $this->mainSource.'8';
        $this->sources['evolucion-crecimiento'] = $this->mainSource.'7';

        $this->dataPath = BASEPATH.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'assets_v2'.DIRECTORY_SEPARATOR.'estadisticas'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
    }


    public function index()
    {
        $data['title'] = 'Estadísticas ChileAtiende';
        $data['content'] = 'estadisticas/index';
        $data['assets']['js'] = array(
            'assets_v2/estadisticas/js/d3.v3.min.js',
            'assets_v2/estadisticas/js/nv.d3.min.js',
            'assets_v2/estadisticas/js/nvd3/tooltip.js',
            'assets_v2/estadisticas/js/nvd3/utils.js',
            'assets_v2/estadisticas/js/nvd3/interactiveLayer.js',
            'assets_v2/estadisticas/js/nvd3/models/axis.js',
            'assets_v2/estadisticas/js/nvd3/models/scatter.js',
            'assets_v2/estadisticas/js/nvd3/models/legend.js',
            'assets_v2/estadisticas/js/nvd3/models/pie.js',
            'assets_v2/estadisticas/js/nvd3/models/pieChart.js',
            'assets_v2/estadisticas/js/nvd3/models/line.js',
            'assets_v2/estadisticas/js/nvd3/models/lineChart.js',
            'assets_v2/estadisticas/js/nvd3/models/multiBar.js',
            'assets_v2/estadisticas/js/nvd3/models/multiBarChart.js',
            'assets_v2/estadisticas/js/estadisticas.js?v=2',
            'assets_v2/estadisticas/js/bootstrap-slider.js'
        );
        $data['assets']['css'] = array(
            'assets_v2/estadisticas/js/nvd3/nv.d3.css',
            'assets_v2/estadisticas/css/styles.css?v=2',
            'assets_v2/estadisticas/css/slider.css'
        );
        $this->load->view('template_v2', $data);
    }

    public function loadData($dataSource = 'num-atenciones'){
        header('Content-type: application/json');

        apc_clear_cache();

        if(extension_loaded('apc')){
            if(apc_fetch($dataSource)){
                $result = apc_fetch($dataSource);
                echo $result;
                return true;
            }
        }

        // Set your CSV feed
        $feed = $this->sources[$dataSource];
        $localFile = $this->dataPath.$dataSource.'.csv';

        // Arrays we'll use later
        $keys = array();
        $newArray = array();

        if(!file_exists($localFile) || (mktime() - filemtime($localFile) > 600))
            file_put_contents($localFile, fopen($feed,'r'));

        // Function to convert CSV into associative array
        function csvToArray($file, $delimiter) {
            if (($handle = fopen($file, 'r')) !== FALSE) {
                $i = 0;
                while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
                    for ($j = 0; $j < count($lineArray); $j++) {
                        $arr[$i][$j] = $lineArray[$j];
                    }
                    $i++;
                }
                fclose($handle);
            }
            return $arr;
        }

        $data = csvToArray($localFile, ',');

        // Set number of elements (minus 1 because we shift off the first row)
        $count = count($data) - 1;

        //Use first row for names
        $labels = array_shift($data);

        foreach ($labels as $label) {
            $keys[] = $label;
        }

        // Add Ids, just in case we want them later
        $keys[] = 'id';

        for ($i = 0; $i < $count; $i++) {
            $data[$i][] = $i;
        }

        // Bring it all together
        for ($j = 0; $j < $count; $j++) {
            $d = array_combine($keys, $data[$j]);
            $newArray[$j] = $d;
        }

        $result = json_encode($newArray);

        if(extension_loaded('apc'))
            if(!apc_fetch($dataSource))
                apc_add($dataSource, $result, 600);

        // Print it out as JSON
        echo $result;
    }

    public function descarga($dataSource = 'num-atenciones'){
        $fileUrl = site_url('assets_v2/estadisticas/data/'.$dataSource.'.csv');
        redirect($fileUrl);
    }
}

?>