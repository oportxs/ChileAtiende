<?php
    $contenidos = extrae_contenidos($contenido->contenido);
?>
<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175">
        <a href="<?= site_url('/') ?>">Portada</a> / <?php echo $contenido->titulo; ?>
    </div>
</div>
<div id="content" class="contenido contenido-<?php echo $contenido->url; ?>">
    <div class="row-fluid">
        <div class="encabezado-contenido">
            <div class="span12">
                <h2><?php echo $contenido->titulo; ?></h2>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php echo getAlertasUrl(); ?>
    <div class="row-fluid">
        <div class="span12 span-maincontent">
            <div id="maincontent">
                <div class="row-fluid">
                    <div class="span9 text-content">
                        <?php echo $contenidos['texto']; ?>
                        <?php if ($contenidos['youtube']): ?>
                            <div class="cont-videos visible-desktop">
                                <h3>Videos relacionados:</h3>
                                <div class="video-principal">
                                    <?php echo $contenidos['youtube'][0]; ?>
                                </div>
                                <?php if (count($contenidos['youtube']) > 1): ?>
                                    <div class="row-fluid cont-videos-thumbs">
                                        <div class="span8 offset2">
                                            <?php foreach ($contenidos['youtube'] as $key => $video): ?>
                                                <div class="video-thumb<?php echo $key==0?' active':''; ?>" data-video-id="<?php echo $contenidos['youtube_sources'][$key]; ?>">
                                                    <img src="http://img.youtube.com/vi/<?php echo $contenidos['youtube_sources'][$key]; ?>/1.jpg">
                                                    <p></p>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                            <div class="cont-videos hidden-desktop">
                                <h3>Videos relacionados:</h3>
                                <?php foreach ($contenidos['youtube'] as $key => $video): ?>
                                    <div class="video-thumb">
                                        <a target="_blank" href="http://m.youtube.com/watch?v=<?php echo $contenidos['youtube_sources'][$key]; ?>">
                                            <img src="http://img.youtube.com/vi/<?php echo $contenidos['youtube_sources'][$key]; ?>/1.jpg">
                                        </a>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>