<?php
    $nroFichas = Doctrine::getTable('Ficha')->totalPublicados();
    $nroFichas = ( substr($nroFichas, -1) > 0 ) ? $nroFichas - substr($nroFichas, -1) : $nroFichas;
?>
<div id="content" class="portada">

    <?php

        function getCanalesDisponibles($novedad){

            $disponibles = [
                'guia_online'=>         'en línea',
                'guia_oficina'=>        'sucursal de la institución',
                'guia_telefonico'=>     'teléfono',
                'guia_correo'=>         'correo postal',
                'guia_chileatiende'=>   'sucursales de ChileAtiende'
                ];

            $canales_disponibles = [];
            foreach ($disponibles as $key => $value) {
                if(!empty($novedad->$key)){
                    $canales_disponibles[] = '<span class="label">'.$value . '</span>'; 
                }
            }

            return $canales_disponibles;
        }

        //Combina Noticias con Trámites destacados y los mmezcla al
        $novedades = array();

        foreach ($noticias as $key => $value) {
            $novedades[] = $value;
        }

        foreach ($fichasDestacadas as $key => $value) {
            $novedades[] = $value;
        }

        shuffle($novedades);
    ?>

    <div class="cont-beneficios-home">
        <div class="row-fluid">
            <ul class="nav nav-pills nav-fichas-home">
                <li data-seccion="destacadas" class="active">
                    <a href="" title="Presiona enter para acceder a los trámites, beneficios y contenidos destacados." data-ga-te-category="Tabs Fichas" data-ga-te-action="Tab" data-ga-te-value="Destacados">Destacados</a>
                </li>
                <li data-seccion="nuevas">
                    <a href="" title="Presiona enter para acceder a los trámites, beneficios y contenidos nuevos." data-ga-te-category="Tabs Fichas" data-ga-te-action="Tab" data-ga-te-value="Nuevos">Nuevos</a>
                </li>
                <li data-seccion="masvisitadas">
                    <a href="" title="Presiona enter para acceder a los trámites, beneficios y contenidos más visitados." data-ga-te-category="Tabs Fichas" data-ga-te-action="Tab" data-ga-te-value="Más visitados">Más visitados</a>
                </li>
            </ul>
        </div>
        <div class="row-fluid">
            <div class="cont-fichas-home fichas-destacadas active">
                <?php foreach ($novedades as $key => $novedad){ ?>
                <div class="masonry-item span4">

                    <?php if (isset($novedad->guia_online)):?>
                        <a href="<?php echo site_url('fichas/ver/'.$novedad->maestro_id); ?>" data-ga-te-category="Tabs Fichas" data-ga-te-action="Ficha Destacadas" data-ga-te-value="<?php echo $novedad->maestro_id; ?>">
                            <div class="ficha-home<?php echo ($novedad->flujo?' flujo':''); ?><?php echo ($novedad->Maestro->sello_chilesinpapeleo?' sello_chilesinpapeleo':''); ?>">
                                <?php if ($novedad->flujo): ?>
                                    <img src="<?php echo base_url('assets_v2/img/label_aprende_sobre.png'); ?>" class="label_flujo" alt="Contenido aprende sobre">
                                <?php endif ?>
                                <?php if ($novedad->Maestro->sello_chilesinpapeleo): ?>
                                    <img src="<?php echo base_url('assets_v2/img/label_sello_chileatiende.png'); ?>" class="label_chilesinpapeleo" alt="Trámite 100% digital de Chile sin papeleo">
                                <?php endif ?>
                                <span><?php echo $novedad->Servicio->nombre; ?></span>
                                <h5>
                                    <?php echo $novedad->titulo; ?>
                                </h5>

                                <?php 
                                $c_disponibles = getCanalesDisponibles($novedad);
                                if(count($c_disponibles)):?> 
                                    <p>
                                        Disponible en: <?php echo implode(' ', $c_disponibles); ?>
                                    </p>
                                <?php endif ?>

                            </div>
                        </a>
                    <?php else:?>
                        <a href="<?=base_url('noticias/ver/'.$novedad->alias)?>" data-ga-te-category="Tabs Fichas" data-ga-te-action="Noticia" data-ga-te-value="<?php echo $novedad->id ?>">
                            <div class="ficha-home noticia">
                                <span></span>
                                    <?php if($novedad->foto){ ?>
                                        <img src="/assets/uploads/noticias/<?php echo $novedad->foto; ?>" alt="<?php echo $novedad->titulo; ?>" class="span12" />
                                    <?php }else{ ?>
                                        <h5>
                                            <?php echo $novedad->titulo; ?>
                                        </h5>
                                    <?php } ?>

                            </div>
                        </a>
                    <?php endif;?>

                </div>
                <?php } ?>
            </div>
            <div class="cont-fichas-home fichas-nuevas">
                <?php foreach ($fichasNuevas as $key => $ficha){ ?>
                <div class="masonry-item span4">
                    <a href="<?php echo site_url('fichas/ver/'.$ficha->maestro_id); ?>" data-ga-te-category="Tabs Fichas" data-ga-te-action="Ficha Nuevas" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">
                        <div class="ficha-home<?php echo ($ficha->flujo?' flujo':''); ?><?php echo ($ficha->Maestro->sello_chilesinpapeleo?' sello_chilesinpapeleo':''); ?>">
                            <?php if ($ficha->flujo): ?>
                                <img src="<?php echo base_url('assets_v2/img/label_aprende_sobre.png'); ?>" class="label_flujo" alt="Contenido aprende sobre">
                            <?php endif ?>
                            <?php if ($ficha->Maestro->sello_chilesinpapeleo): ?>
                                <img src="<?php echo base_url('assets_v2/img/label_sello_chileatiende.png'); ?>" class="label_chilesinpapeleo" alt="Trámite 100% digital de Chile sin papeleo">
                            <?php endif ?>
                            <span><?php echo $ficha->Servicio->nombre; ?></span>
                            <h5>
                                <?php echo $ficha->titulo; ?>
                            </h5>
                            <?php 
                            $c_disponibles = getCanalesDisponibles($ficha);
                            if(count($c_disponibles)):?> 
                                <p>
                                    Disponible en: <?php echo implode(' ', $c_disponibles); ?>
                                </p>
                            <?php endif ?>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
            <div class="cont-fichas-home fichas-masvisitadas">
                <?php foreach ($fichasMasVistas as $key => $ficha){ ?>
                <div class="masonry-item span4">
                    <a href="<?php echo site_url('fichas/ver/'.$ficha->maestro_id); ?>" data-ga-te-category="Tabs Fichas" data-ga-te-action="Ficha Mas Visitadas" data-ga-te-value="<?php echo $ficha->maestro_id; ?>">
                        <div class="ficha-home<?php echo ($ficha->flujo?' flujo':''); ?><?php echo ($ficha->Maestro->sello_chilesinpapeleo?' sello_chilesinpapeleo':''); ?>">
                            <?php if ($ficha->flujo): ?>
                                <img src="<?php echo base_url('assets_v2/img/label_aprende_sobre.png'); ?>" class="label_flujo" alt="Contenido aprende sobre">
                            <?php endif ?>
                            <?php if ($ficha->Maestro->sello_chilesinpapeleo): ?>
                                <img src="<?php echo base_url('assets_v2/img/label_sello_chileatiende.png'); ?>" class="label_chilesinpapeleo" alt="Trámite 100% digital de Chile sin papeleo">
                            <?php endif ?>
                            <span><?php echo $ficha->Servicio->nombre; ?></span>
                            <h5>
                                <?php echo $ficha->titulo; ?>
                            </h5>
                            <?php 
                            $c_disponibles = getCanalesDisponibles($ficha);
                            if(count($c_disponibles)):?> 
                                <p>
                                    Disponible en: <?php echo implode(' ', $c_disponibles); ?>
                                </p>
                            <?php endif ?>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php //$this->load->view('widget/menu-inferior'); ?>
</div>
