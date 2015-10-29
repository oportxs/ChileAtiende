<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175">
        <a href="<?= site_url('/') ?>">Portada</a> / <?php echo $noticia->titulo; ?>
    </div>
</div>

<div id="content" class="contenido">
    <div class="row-fluid">
        <div class="encabezado-contenido">
            <div class="span12">
                <h2><?php echo $noticia->titulo; ?></h2>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php echo getAlertasUrl(); ?>
    <div class="row-fluid">
        <div class="span12 span-maincontent">
            <div id="maincontent">
                <div class="row-fluid">
                    <div class="span12 text-content">
                        <?php if($noticia->foto){ ?>
                            <div class="contenedor_imagen">
                                <img src="/assets/uploads/noticias/<?php echo $noticia->foto; ?>" alt="<?php echo $noticia->titulo; ?>" class="img-poladoid pull-right" />
                            </div>
                        <?php } ?>
                        <?php echo prepare_content_ficha($noticia->contenido); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('widget/menu-inferior'); ?>
