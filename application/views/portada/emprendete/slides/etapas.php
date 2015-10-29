<script type="text/javascript" src="assets/js/emprendete/etapasempresa.js"></script>
<div id="etapas">
    <form action="buscar/fichas/" method="get">
        <div class="encabezado_temas">
            <span></span>
            <h2 class="temas_title">Elige tu etapa</h2>
            <p></p>
        </div>

        <div class="paso1">
            <div class="lista">
                <div class="ui-widget-content hoverscroll vertical" style="width: 170px; height: 300px;">
                    <div class="listcontainer" style="width: 170px; height: 300px;">
                        
                        <ul id="my-list" class="list" style="height: 467px;">
                            <?php foreach ($etapas as $e): ?>
                                <li class="item"><label class="label_radio"><input type="radio" value="<?= $e->id ?>" name="etapa" /><?= $e->nombre ?></label></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="paso2">
            <h3 style="padding-bottom: 10px; font-size: 20px; font-weight: bold;">Aprende sobre</h3>
            <ul class="hechos">
                <li></li>
            </ul>
            <div style="clear: both;"></div><br />
            <br />
            <br />
            <br />
            <br />
            <h3 style="padding-bottom: 10px; font-size: 20px; font-weight: bold; border-top: #FFF 1px dotted; padding-top: 10px;">Apoyo estatal</h3>
            <ul class="apoyos">
                <li></li>
            </ul>
            <div class="clear"></div>
            <div><input style="display: none;" type="submit" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Buscar', 'Temas']);" class="bt_buscar" value="Buscar" id="button" name="button" /></div>
        </div>

    </form>

</div>
<!-- Fin Contenido -->
