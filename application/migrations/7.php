<?php
Class Migration_Actualizacion_TipoEmpresa extends Doctrine_Migration_Base
{
	public function up() 
	{
		//UPDATE  `tipo_empresa` SET  `nombre` =  '0 - 2.400 U.F.' WHERE  `tipo_empresa`.`id` =1;
		$tipo_empresa = Doctrine::getTable('TipoEmpresa')->find(1);
		$tipo_empresa->nombre = '0 - 2.400 U.F.';
		$tipo_empresa->save();
		//UPDATE  `tipo_empresa` SET  `nombre` =  '2.401 - 25.000 U.F.' WHERE  `tipo_empresa`.`id` =2;
		$tipo_empresa = Doctrine::getTable('TipoEmpresa')->find(2);
		$tipo_empresa->nombre = '2.401 - 25.000 U.F.';
		$tipo_empresa->save();
		//UPDATE  `tipo_empresa` SET  `nombre` =  '25.001 - 100.000 U.F.' WHERE  `tipo_empresa`.`id` =3;
		$tipo_empresa = Doctrine::getTable('TipoEmpresa')->find(3);
		$tipo_empresa->nombre = '25.001 - 100.000 U.F.';
		$tipo_empresa->save();
		//UPDATE  `tipo_empresa` SET  `nombre` =  '100.001 U.F. en adelante' WHERE  `tipo_empresa`.`id` =4;
		$tipo_empresa = Doctrine::getTable('TipoEmpresa')->find(4);
		$tipo_empresa->nombre = '100.001 U.F. en adelante';
		$tipo_empresa->save();
	}

	public function down()
	{
		//UPDATE  `tipo_empresa` SET  `nombre` =  '0 - 2.400 U.F.' WHERE  `tipo_empresa`.`id` =1;
		$tipo_empresa = Doctrine::getTable('TipoEmpresa')->find(1);
		$tipo_empresa->nombre = '2.400 U.F.';
		$tipo_empresa->save();
		//UPDATE  `tipo_empresa` SET  `nombre` =  '2.401 - 25.000 U.F.' WHERE  `tipo_empresa`.`id` =2;
		$tipo_empresa = Doctrine::getTable('TipoEmpresa')->find(2);
		$tipo_empresa->nombre = '25.000 U.F.';
		$tipo_empresa->save();
		//UPDATE  `tipo_empresa` SET  `nombre` =  '25.001 - 100.000 U.F.' WHERE  `tipo_empresa`.`id` =3;
		$tipo_empresa = Doctrine::getTable('TipoEmpresa')->find(3);
		$tipo_empresa->nombre = '100.000 U.F.';
		$tipo_empresa->save();
		//UPDATE  `tipo_empresa` SET  `nombre` =  '100.001 U.F. en adelante' WHERE  `tipo_empresa`.`id` =4;
		$tipo_empresa = Doctrine::getTable('TipoEmpresa')->find(4);
		$tipo_empresa->nombre = '100.001 U.F. en adelante';
		$tipo_empresa->save();
	}
}