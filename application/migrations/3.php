<?php
class Migration_Rubros extends Doctrine_Migration_Base {
	public function up(){
		$rubro = new Rubro();
		$rubro->nombre = 'Deporte';
		$rubro->save();

		$rubro = new Rubro();
		$rubro->nombre = 'Arte';
		$rubro->save();
	}
	public function down(){
		Doctrine::getTable('Rubro')->findByNombre('Deporte')->delete();
		Doctrine::getTable('Rubro')->findByNombre('Arte')->delete();
	}
}