<script type="text/javascript" src="assets/js/temas.js"></script>
<div id="temashome">
    <form method="get" action="buscar/fichas/">
        <div class="encabezado_temas">
            <span></span>
            <h2 class="temas_title">Apoyo Estatal</h2>
            <p><strong>Selecciona un apoyo</strong> de tu interés </p>
        </div>
        <div class="paso1">
            <div class="lista">
                <ul id="my-list">
                    <?php
                    $selected = TRUE;
                    foreach ($apoyosestado as $ae) {
                        if ($selected)
                            echo '<li class="on" >';
                        else
                            echo '<li>';

                        echo '<label class="label_radio">';
                        if ($selected)
                            echo '<input name="apoyos" id="' . str_replace(' ', '', $ae->nombre) . $ae->id . '" value="' . $ae->id . '" type="radio" checked="checked" />';
                        else
                            echo '<input name="apoyos" id="' . str_replace(' ', '', $ae->nombre) . $ae->id . '" value="' . $ae->id . '" type="radio" />';

                        echo $ae->nombre . '</label>';
                        echo '</li>';
                        if ($selected)
                            $selected = FALSE;
                    }
                    ?>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="accion2"></div>
        <div class="paso2">
            <p><input type="submit" name="button" id="button" value="Buscar" class="bt_buscar" onclick="_gaq.push(['_trackEvent', 'Acciones', 'Buscar', 'Apoyos']);" /></p>
        </div>
    </form>
</div>
