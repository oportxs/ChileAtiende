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
<div class="cont-busqueda">
    <form action="<?= site_url('buscar/fichas') ?>" method="get" id="main_search">
        <input title="Escribe aquí lo que buscas" accesskey="b" id="main_search_input" class="main_search_input span12 <?php echo (!$this->config->item("lite_mode"))?'active_search':''; ?>" autocomplete="off" name="buscar" placeholder="Escribe aquí lo que buscas" type="text" <?php echo (isset($buscar)) ? "value='" . htmlspecialchars($buscar,ENT_QUOTES) . "'" : "" ?> />
        <button type="submit" accesskey="s" class="searchbtn"><span class="fa fa-search" aria-hidden="true"></span> Buscar</button>
        <input type="hidden" name="e" value="<?=$e_value?>">
    </form>
</div>