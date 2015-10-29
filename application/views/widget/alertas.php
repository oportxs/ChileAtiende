<div class="container container-alertas">
    <div class="row-fluid">
        <div class="container-alertas-sitio">
            <?php foreach($alertas as $alerta): ?>
                <div class="alert alert-<?php echo $alerta->tipo; ?>">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <h4><?php echo $alerta->titulo; ?></h4>
                    <p><?php echo $alerta->descripcion; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>