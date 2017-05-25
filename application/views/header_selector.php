

<div id='navegacion' class='no-print'>
    <div class='container wrapper'>
        <ul class="pull-right">
            <li class='<?php echo ($isEmpresa || $isExterior || $es_exterior || $isMujer)?'':'active';?>' ><a href='/'>ChileAtiende</a></li>
            <!--<li class='<?php echo ($isMujer || $es_mujer)?'active':'';?>' ><a href='/mujer'>Mujer</a></li>-->
            <li class='<?php echo ($isExterior || $es_exterior)?'active':'';?>' ><a href='/exterior'>Chilenos en el Exterior</a></li>
            <li class='<?php echo ($isEmpresa)?'active':'';?>'><a href='/empresas'>Pymes</a></li>
        </ul>
	</div>
</div>

<!-- Emergencia
<div style="background-color:#EF8D19;">
	<div class="row">
		<div class="col-xs-12 text-center">
			<a href="http://www.onemi.gob.cl" target="_blank"><img src="<?php echo config_item('base_url');?>assets_v2/img/banners/banner-emergencia-980x80.png" class="img-responsive" /></a>
		</div>
	</div>
</div> -->


