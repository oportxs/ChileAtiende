<?php

class Migration_BorradoOficinas extends Doctrine_Migration_Base {
    public function up(){
        $conn = Doctrine_Manager::getInstance()->connection();
        $query = 'ALTER TABLE `modulo_atencion` DROP FOREIGN KEY `fk_modulo_atencion_oficina1`;';
        $query .= 'ALTER TABLE `modulo_atencion` CHANGE `oficina_id` `oficina_id` INT(10) UNSIGNED NULL;';
        $query .= 'ALTER TABLE `modulo_atencion` ADD CONSTRAINT `fk_modulo_atencion_oficina1` FOREIGN KEY (`oficina_id`) REFERENCES `oficina` (`id`) ON DELETE SET NULL;';

        $conn->execute($query);
    }

    public function down(){
        $conn = Doctrine_Manager::getInstance()->connection();
        $query = 'ALTER TABLE `modulo_atencion` DROP FOREIGN KEY `fk_modulo_atencion_oficina1`;';
        $query .= 'ALTER TABLE `modulo_atencion` CHANGE `oficina_id` `oficina_id` INT(10) UNSIGNED NOT NULL;';
        $query .= 'SET foreign_key_checks = 0;';
        $query .= 'ALTER TABLE `modulo_atencion` ADD CONSTRAINT `fk_modulo_atencion_oficina1` FOREIGN KEY (`oficina_id`) REFERENCES `oficina` (`id`) ON DELETE NO ACTION;';

        $conn->execute($query);
    }
} 

?>
