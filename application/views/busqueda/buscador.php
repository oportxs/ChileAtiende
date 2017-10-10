<?php
	switch(true){
		case(isset($empresa)):
			$e_value = $empresa;
			break;
		case(isset($es_exterior)):
			$e_value = 2;
			break;
		default:
			$e_value = 0;
	}
?>
<div class="cont-busqueda span12">
    <form action="<?= site_url('buscar/fichas') ?>" method="get" id="main_search">
        <input title="Escribe aquí lo que buscas" accesskey="b" id="main_search_input" class="main_search_input <?php echo (!$this->config->item("lite_mode"))?'active_search':''; ?>" autocomplete="off" name="buscar" placeholder="Escribe aquí lo que buscas" type="text" <?php echo (isset($buscar)) ? "value='" . htmlspecialchars($buscar,ENT_QUOTES) . "'" : "" ?> />
        <button type="submit" accesskey="s" class="searchbtn">
        	<span class="fa fa-search" aria-hidden="true"></span> 
        	<?php if( !isset($empresa) || $empresa != 1 ){ ?>
        	<span class="etiqueta"> Buscar</span>
        	<?php } ?>
        </button>
        <input type="hidden" name="e" value="<?=$e_value?>">
    </form>
</div>