<div class="row-fluid">
    <div class="breadcrumbs span12 no-print" data-spy="affix" data-offset-top="175">
        <a href="<?php echo site_url('/') ?>">Portada</a> / <a href="<?=site_url('widget')?>">ChileAtiende en tu sitio</a> / URLs GobiernoTransparente
    </div>
</div>
<div id="content" class="widget">
    <div class="row-fluid">
        <div class="encabezado-contenido">
            <div class="span12">
                <h2>URLs GobiernoTransparente</h2>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 span-maincontent">
            <div id="maincontent">
                <div class="row-fluid">
                    <div class="span12 text-content">
                        <table class="oficinas table table-striped table-bordered">
                            <tr>
                                <th>Servicio</th>
                                <th>URL</th>
                            </tr>
                            <?php
                            foreach ($servicios as $s) {
                                ?>
                                <tr>
                                    <td><?= $s->nombre ?></td>
                                    <td><a href="<?=$s->sigla? site_url('transparencia/'.$s->sigla) : site_url('servicios/ver/'.$s->codigo) ?>"><?=$s->sigla? site_url('transparencia/'.$s->sigla) : site_url('servicios/ver/'.$s->codigo) ?></a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
