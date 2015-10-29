<?php 
if( count($ficha->ApoyosEstado) ) :
?>
<div class="text-content">
    <a id="emprendete" class="anchor-top">&nbsp;</a>
    <!-- RSPEAK_START -->
    <table class="table table-striped">
        <tbody>
            <?php 
            if( count($ficha->HechosEmpresa) ) :
            ?>
            <tr>
                <td class="titulo-tabla">Etapa:</td>
                <td>
                    <?php 
                    foreach( $ficha->HechosEmpresa as $he) {

                        foreach($he->EtapasEmpresa as $ee) {
                            echo $ee->nombre.', ';
                        }
                    }
                    ?>
                </td>
            </tr>
            <?php endif ?>
            <?php 
            if( count($ficha->ApoyosEstado) ) :
            ?>
            <tr>
                <td class="titulo-tabla">Uso del apoyo:</td>
                <td>
                    <?php 
                    foreach( $ficha->ApoyosEstado as $ae) {
                        echo $ae->nombre.', ';
                    }
                    ?>
                </td>
            </tr>
            <?php endif ?>
            <?php 
            if( !empty($reg) ) :
            ?>
            <tr>
                <td class="titulo-tabla">Región:</td>
                <td>
                    <?php
                    echo $reg;
                    ?>
                </td>
            </tr>
            <?php endif ?>
            <?php if (!empty($ficha->fps)): ?>
            <tr>
                <td class="titulo-tabla">Puntaje FPS:</td>
                <td>
                    <?php echo ($ficha->puntaje_fps_min) ? 'Puntaje Mínimo: '.prepare_content_ficha($ficha->puntaje_fps_min) : ''; ?>
                    <?php echo ($ficha->puntaje_fps_max) ? 'Puntaje Máximo: '.prepare_content_ficha($ficha->puntaje_fps_max) : ''; ?>
                </td>
            </tr>
            <?php endif ?>
            <?php if (!empty($ficha->formalizacion)): ?>
            <tr>
                <td class="titulo-tabla">Nivel de Formalización</td>
                <td><?php echo ( ($ficha->formalizacion == 1) ? 'Informal' : 'Formal' ); ?></td>
            </tr>
            <?php endif ?>
            <?php if (!empty($ficha->req_especial)): ?>
            <tr>
                <td class="titulo-tabla">Requisito especial</td>
                <td><?php echo ( ($ficha->req_especial == 1) ? 'Mujer' : 'Indígena' ); ?></td>
            </tr>
            <?php endif ?>
        </tbody>
    </table>
    <!-- RSPEAK_STOP -->
</div>
<?php endif ?>