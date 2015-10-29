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
                        <?php echo prepare_content_ficha($contenido->contenido); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('widget/menu-inferior'); ?>
