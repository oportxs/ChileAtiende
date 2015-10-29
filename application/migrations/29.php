<?php
class Migration_MetaFicha extends Doctrine_Migration_Base {
    public function up()
    {
        $conn = Doctrine_Manager::getInstance()->connection();
        $query = 'CREATE TABLE `sub_ficha` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `objetivo` text,
  `beneficiarios` text,
  `costo` text,
  `vigencia` text,
  `plazo` text,
  `guia_online` text,
  `guia_online_url` varchar(255) DEFAULT NULL,
  `guia_oficina` text,
  `guia_telefonico` text,
  `guia_correo` text,
  `marco_legal` text,
  `doc_requeridos` text,
  `locked` tinyint(1) DEFAULT 0,
  `estado` varchar(16) DEFAULT NULL,
  `estado_justificacion` text,
  `actualizable` tinyint(1) DEFAULT NULL,
  `comentarios` text,
  `maestro` tinyint(1) NOT NULL,
  `publicado` tinyint(1) NOT NULL,
  `publicado_at` datetime DEFAULT NULL,
  `servicio_codigo` varchar(8) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `maestro_id` int(10) unsigned DEFAULT NULL,
  `metaficha_id` int(10) unsigned NOT NULL,
  `cc_observaciones` text,
  `primera_version_publicada_id` int(10) unsigned DEFAULT NULL,
  `informacion_multimedia` text,
  PRIMARY KEY (`id`),
  KEY `fk_sub_ficha_servicio1` (`servicio_codigo`),
  KEY `fk_sub_ficha_sub_ficha1` (`maestro_id`),
  KEY `sub_ficha_maestro` (`maestro`),
  KEY `sub_ficha_publicado` (`publicado`),
  KEY `sub_ficha_maestro_publicado` (`maestro`,`publicado`),
  KEY `sub_ficha_primera_version_publicada_id_idx` (`primera_version_publicada_id`),
  CONSTRAINT `sub_ficha_ibfk_1` FOREIGN KEY (`maestro_id`) REFERENCES `sub_ficha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_sub_ficha_servicio1` FOREIGN KEY (`servicio_codigo`) REFERENCES `servicio` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $results = $conn->execute($query);

        $query = 'CREATE TABLE `historial_sub_ficha` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sub_ficha_id` int(10) unsigned DEFAULT NULL,
  `sub_ficha_version_id` int(10) unsigned DEFAULT NULL,
  `usuario_backend_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_historial_sub_ficha1` (`sub_ficha_id`),
  KEY `fk_historial_usuario_backend1` (`usuario_backend_id`),
  KEY `sub_ficha_version_id` (`sub_ficha_version_id`),
  CONSTRAINT `historial_sub_ibfk_2` FOREIGN KEY (`sub_ficha_id`) REFERENCES `sub_ficha` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `historial_sub_ibfk_3` FOREIGN KEY (`sub_ficha_version_id`) REFERENCES `sub_ficha` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `historial_sub_ibfk_4` FOREIGN KEY (`usuario_backend_id`) REFERENCES `usuario_backend` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $results = $conn->execute($query);

        $query = 'ALTER TABLE ficha ADD metaficha tinyint(1) NOT NULL';
        $results = $conn->execute($query);

        $query = 'ALTER TABLE ficha ADD metaficha_campos text';
        $results = $conn->execute($query);

        $query = 'ALTER TABLE ficha ADD metaficha_servicios text';
        $results = $conn->execute($query);

        $query = 'ALTER TABLE ficha ADD metaficha_categoria varchar(16)';
        $results = $conn->execute($query);

        $query = 'ALTER TABLE servicio ADD sector_codigo varchar(11) NOT NULL DEFAULT "00"';
        $results = $conn->execute($query);

        $query = 'INSERT INTO rol(id,nombre,descripcion) values("metaficha","Metaficha","Usuario que puede crear metafichas")';
        $results = $conn->execute($query);
        
    }
    
    public function down(){
        $this->dropTable('sub_ficha');
        $this->dropTable('historial_sub_ficha');
        $this->removeColumn( 'ficha', 'metaficha' );
        $this->removeColumn( 'ficha', 'metaficha_campos' );
        $this->removeColumn( 'ficha', 'metaficha_servicios' );
        $this->removeColumn( 'ficha', 'metaficha_categoria' );
        $this->removeColumn( 'servicio', 'sector_codigo' );
        Doctrine::getTable('Rol')->findByNombre('Metaficha')->delete();
    }
}
?>
