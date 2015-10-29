SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `cha_desarrollo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `cha_desarrollo` ;

-- -----------------------------------------------------
-- Table `cha_desarrollo`.`api_acceso`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`api_acceso` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `token` VARCHAR(128) NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `nombre` VARCHAR(64) NOT NULL ,
  `apellido` VARCHAR(128) NOT NULL ,
  `empresa` VARCHAR(128) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `token` (`token` ASC) ,
  UNIQUE INDEX `email` (`email` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 162
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`api_hit`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`api_hit` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `count` INT(10) UNSIGNED NOT NULL ,
  `fecha` DATE NOT NULL ,
  `api_acceso_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `fecha` (`fecha` ASC, `api_acceso_id` ASC) ,
  INDEX `fk_api_hits_api_acceso1` (`api_acceso_id` ASC) ,
  CONSTRAINT `fk_api_hits_api_acceso1`
    FOREIGN KEY (`api_acceso_id` )
    REFERENCES `cha_desarrollo`.`api_acceso` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 503
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`apoyo_estado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`apoyo_estado` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`entidad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`entidad` (
  `codigo` VARCHAR(8) NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  `mision` TEXT NULL DEFAULT NULL ,
  `sigla` VARCHAR(45) NULL DEFAULT NULL ,
  `created_at` VARCHAR(45) NULL DEFAULT NULL ,
  `updated_at` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`codigo`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`servicio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`servicio` (
  `codigo` VARCHAR(8) NOT NULL ,
  `nombre` VARCHAR(255) NOT NULL ,
  `sigla` VARCHAR(32) NULL DEFAULT NULL ,
  `url` VARCHAR(512) NULL DEFAULT NULL ,
  `responsable` VARCHAR(128) NULL DEFAULT NULL ,
  `entidad_codigo` VARCHAR(8) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `mision` TEXT NOT NULL ,
  PRIMARY KEY (`codigo`) ,
  INDEX `fk_servicio_entidad` (`entidad_codigo` ASC) ,
  CONSTRAINT `fk_servicio_entidad`
    FOREIGN KEY (`entidad_codigo` )
    REFERENCES `cha_desarrollo`.`entidad` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `correlativo` INT(11) NULL DEFAULT NULL ,
  `titulo` VARCHAR(255) NOT NULL ,
  `alias` VARCHAR(255) NULL DEFAULT NULL ,
  `objetivo` TEXT NOT NULL ,
  `weight` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `beneficiarios` TEXT NULL DEFAULT NULL ,
  `costo` TEXT NULL DEFAULT NULL ,
  `vigencia` TEXT NULL DEFAULT NULL ,
  `plazo` TEXT NOT NULL ,
  `guia_online` TEXT NULL DEFAULT NULL ,
  `guia_online_url` VARCHAR(255) NULL DEFAULT NULL ,
  `guia_oficina` TEXT NULL DEFAULT NULL ,
  `guia_telefonico` TEXT NULL DEFAULT NULL ,
  `guia_correo` TEXT NULL DEFAULT NULL ,
  `marco_legal` TEXT NULL DEFAULT NULL ,
  `doc_requeridos` TEXT NULL DEFAULT NULL ,
  `maestro` TINYINT(1) NOT NULL ,
  `publicado` TINYINT(1) NOT NULL ,
  `publicado_at` DATETIME NULL DEFAULT NULL ,
  `locked` TINYINT(1) NOT NULL DEFAULT '0' ,
  `estado` VARCHAR(16) NULL DEFAULT NULL ,
  `estado_justificacion` TEXT NULL DEFAULT NULL ,
  `actualizable` TINYINT(1) NULL DEFAULT NULL ,
  `destacado` TINYINT(1) NOT NULL DEFAULT '0' ,
  `servicio_codigo` VARCHAR(8) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `maestro_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `genero_id` INT(11) NULL DEFAULT NULL ,
  `convenio` TINYINT(1) NULL DEFAULT '0' ,
  `diagramacion` SMALLINT(6) NULL DEFAULT NULL ,
  `cc_observaciones` TEXT NULL DEFAULT NULL ,
  `cc_id` VARCHAR(20) NULL DEFAULT NULL ,
  `cc_formulario` TEXT NULL DEFAULT NULL ,
  `cc_llavevalor` INT(11) NULL DEFAULT NULL ,
  `comentarios` TEXT NOT NULL ,
  `tipo` TINYINT(4) NOT NULL ,
  `flujo` TINYINT(4) NOT NULL DEFAULT '0' ,
  `tema_principal` INT(10) UNSIGNED NOT NULL ,
  `keywords` VARCHAR(255) NULL DEFAULT NULL ,
  `sic` VARCHAR(255) NULL DEFAULT NULL ,
  `sello_chilesinpapeleo` TINYINT(4) NOT NULL DEFAULT '0' ,
  `tipo_empresa_id` INT(11) NULL DEFAULT NULL ,
  `fps` TINYINT(1) NULL ,
  `puntaje_fps` VARCHAR(45) NULL ,
  `formalizacion` TINYINT(1) NULL ,
  `venta_anual` INT(3) NULL ,
  `nro_trabajadores` INT(3) NULL ,
  `req_especial` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `codigo` (`correlativo` ASC, `servicio_codigo` ASC) ,
  INDEX `fk_ficha_servicio1` (`servicio_codigo` ASC) ,
  INDEX `fk_ficha_ficha1` (`maestro_id` ASC) ,
  INDEX `maestro` (`maestro` ASC) ,
  INDEX `publicado` (`publicado` ASC) ,
  INDEX `maestro_publicado` (`maestro` ASC, `publicado` ASC) ,
  CONSTRAINT `ficha_ibfk_1`
    FOREIGN KEY (`maestro_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ficha_servicio1`
    FOREIGN KEY (`servicio_codigo` )
    REFERENCES `cha_desarrollo`.`servicio` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 16668
DEFAULT CHARACTER SET = utf8
COMMENT = 'no se agrega relacion con tabla genero.';


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`archivo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`archivo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `nombre` VARCHAR(255) NULL DEFAULT NULL ,
  `url` TEXT NULL DEFAULT NULL ,
  `tipo` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_archivos_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `fk_archivos_ficha1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`campana_modulo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`campana_modulo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `titulo` VARCHAR(255) NOT NULL ,
  `url` VARCHAR(255) NOT NULL ,
  `estado` TINYINT(1) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  `updated_at` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`chileclic_tipo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`chileclic_tipo` (
  `id` INT(11) NOT NULL ,
  `nombre` VARCHAR(128) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`chileclic_tema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`chileclic_tema` (
  `id` INT(11) NOT NULL ,
  `nombre` VARCHAR(128) NOT NULL ,
  `chileclic_tipo_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `chileclic_tipo_id` (`chileclic_tipo_id` ASC) ,
  CONSTRAINT `chileclic_tema_ibfk_1`
    FOREIGN KEY (`chileclic_tipo_id` )
    REFERENCES `cha_desarrollo`.`chileclic_tipo` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`chileclic_subtema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`chileclic_subtema` (
  `id` INT(11) NOT NULL ,
  `nombre` VARCHAR(128) NOT NULL ,
  `chileclic_tema_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `chileclic_tema_id` (`chileclic_tema_id` ASC) ,
  CONSTRAINT `chileclic_subtema_ibfk_1`
    FOREIGN KEY (`chileclic_tema_id` )
    REFERENCES `cha_desarrollo`.`chileclic_tema` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ci_sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ci_sessions` (
  `session_id` VARCHAR(40) NOT NULL DEFAULT '0' ,
  `ip_address` VARCHAR(16) NOT NULL DEFAULT '0' ,
  `user_agent` VARCHAR(120) NOT NULL ,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `user_data` TEXT NOT NULL ,
  PRIMARY KEY (`session_id`) ,
  INDEX `last_activity_idx` (`last_activity` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ci_sessions_track`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ci_sessions_track` (
  `session_id` VARCHAR(40) NOT NULL DEFAULT '0' ,
  `ip_address` VARCHAR(16) NOT NULL DEFAULT '0' ,
  `user_agent` VARCHAR(120) NOT NULL ,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `user_data` TEXT NOT NULL ,
  PRIMARY KEY (`session_id`) ,
  INDEX `last_activity_idx` (`last_activity` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`sistema_previsional`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`sistema_previsional` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`sistema_salud`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`sistema_salud` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`sector`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`sector` (
  `codigo` VARCHAR(11) NOT NULL ,
  `tipo` VARCHAR(45) NOT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `lat` FLOAT NULL DEFAULT NULL ,
  `lng` FLOAT NULL DEFAULT NULL ,
  `url` VARCHAR(512) NULL DEFAULT NULL ,
  `sector_padre_codigo` VARCHAR(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`codigo`) ,
  INDEX `fk_sector_sector1` (`sector_padre_codigo` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`usuario_frontend`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`usuario_frontend` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NOT NULL ,
  `nombres` VARCHAR(255) NOT NULL ,
  `apellidos` VARCHAR(255) NOT NULL ,
  `sexo` CHAR(1) NULL DEFAULT NULL ,
  `edad` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `sector_codigo` VARCHAR(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `sistema_salud_id` INT(10) UNSIGNED NOT NULL ,
  `sistema_previsional_id` INT(10) UNSIGNED NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email` (`email` ASC) ,
  INDEX `fk_usuario_frontend_sector1` (`sector_codigo` ASC) ,
  INDEX `fk_usuario_frontend_sistema_salud1` (`sistema_salud_id` ASC) ,
  INDEX `fk_usuario_frontend_sistema_previsional1` (`sistema_previsional_id` ASC) ,
  CONSTRAINT `fk_usuario_frontend_sistema_previsional1`
    FOREIGN KEY (`sistema_previsional_id` )
    REFERENCES `cha_desarrollo`.`sistema_previsional` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_frontend_sistema_salud1`
    FOREIGN KEY (`sistema_salud_id` )
    REFERENCES `cha_desarrollo`.`sistema_salud` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `usuario_frontend_ibfk_1`
    FOREIGN KEY (`sector_codigo` )
    REFERENCES `cha_desarrollo`.`sector` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`comentario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`comentario` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `comentario` TEXT NOT NULL ,
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `usuario_frontend_id` INT(10) UNSIGNED NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_evaluacion_ficha1` (`ficha_id` ASC) ,
  INDEX `fk_evaluacion_usuario_frontend1` (`usuario_frontend_id` ASC) ,
  CONSTRAINT `fk_evaluacion_ficha1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluacion_usuario_frontend1`
    FOREIGN KEY (`usuario_frontend_id` )
    REFERENCES `cha_desarrollo`.`usuario_frontend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`configuracion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`configuracion` (
  `parametro` VARCHAR(255) NOT NULL ,
  `valor` TEXT NOT NULL ,
  PRIMARY KEY (`parametro`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`etapa_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`etapa_empresa` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `orden` INT(10) UNSIGNED NOT NULL ,
  `nombre` VARCHAR(128) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `orden` (`orden` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`hecho_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`hecho_empresa` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 25
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`etapa_empresa_has_hecho_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`etapa_empresa_has_hecho_empresa` (
  `etapa_empresa_id` INT(10) UNSIGNED NOT NULL ,
  `hecho_empresa_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`etapa_empresa_id`, `hecho_empresa_id`) ,
  INDEX `fk_etapa_empresa_has_hecho_empresa_hecho_empresa1` (`hecho_empresa_id` ASC) ,
  INDEX `fk_etapa_empresa_has_hecho_empresa_etapa_empresa1` (`etapa_empresa_id` ASC) ,
  CONSTRAINT `etapa_empresa_has_hecho_empresa_ibfk_1`
    FOREIGN KEY (`etapa_empresa_id` )
    REFERENCES `cha_desarrollo`.`etapa_empresa` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `etapa_empresa_has_hecho_empresa_ibfk_2`
    FOREIGN KEY (`hecho_empresa_id` )
    REFERENCES `cha_desarrollo`.`hecho_empresa` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`etapa_vida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`etapa_vida` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `orden` INT(10) UNSIGNED NOT NULL ,
  `nombre` VARCHAR(128) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `orden` (`orden` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`hecho_vida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`hecho_vida` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 69
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`etapa_vida_has_hecho_vida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`etapa_vida_has_hecho_vida` (
  `etapa_vida_id` INT(10) UNSIGNED NOT NULL ,
  `hecho_vida_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`etapa_vida_id`, `hecho_vida_id`) ,
  INDEX `fk_etapa_vida_has_hecho_vida_hecho_vida1` (`hecho_vida_id` ASC) ,
  INDEX `fk_etapa_vida_has_hecho_vida_etapa_vida1` (`etapa_vida_id` ASC) ,
  CONSTRAINT `etapa_vida_has_hecho_vida_ibfk_1`
    FOREIGN KEY (`etapa_vida_id` )
    REFERENCES `cha_desarrollo`.`etapa_vida` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `etapa_vida_has_hecho_vida_ibfk_2`
    FOREIGN KEY (`hecho_vida_id` )
    REFERENCES `cha_desarrollo`.`hecho_vida` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`evaluacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`evaluacion` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `rating` INT(11) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_evaluacion_ficha2` (`ficha_id` ASC) ,
  CONSTRAINT `evaluacion_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 38389
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`feedback`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`feedback` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `a_paterno` VARCHAR(45) NOT NULL ,
  `a_materno` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `asunto` VARCHAR(45) NOT NULL ,
  `comentario` TEXT NOT NULL ,
  `enviado` TINYINT(1) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  `origen` TEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
AUTO_INCREMENT = 410
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha_has_chileclic_subtema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha_has_chileclic_subtema` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `chileclic_subtema_id` INT(11) NOT NULL ,
  PRIMARY KEY (`ficha_id`, `chileclic_subtema_id`) ,
  INDEX `chileclic_subtema_id` (`chileclic_subtema_id` ASC) ,
  CONSTRAINT `ficha_has_chileclic_subtema_ibfk_1`
    FOREIGN KEY (`chileclic_subtema_id` )
    REFERENCES `cha_desarrollo`.`chileclic_subtema` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_chileclic_subtema_ibfk_2`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha_has_hecho_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha_has_hecho_empresa` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `hecho_empresa_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `hecho_empresa_id`) ,
  INDEX `fk_ficha_has_hecho_empresa_hecho_empresa1` (`hecho_empresa_id` ASC) ,
  INDEX `fk_ficha_has_hecho_empresa_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_hecho_empresa_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_hecho_empresa_ibfk_2`
    FOREIGN KEY (`hecho_empresa_id` )
    REFERENCES `cha_desarrollo`.`hecho_empresa` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha_has_hecho_vida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha_has_hecho_vida` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `hecho_vida_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `hecho_vida_id`) ,
  INDEX `fk_ficha_has_hecho_vida_hecho_vida1` (`hecho_vida_id` ASC) ,
  INDEX `fk_ficha_has_hecho_vida_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_hecho_vida_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_hecho_vida_ibfk_2`
    FOREIGN KEY (`hecho_vida_id` )
    REFERENCES `cha_desarrollo`.`hecho_vida` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`rango_edad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`rango_edad` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `edad_minima` SMALLINT(6) NULL DEFAULT NULL ,
  `edad_maxima` SMALLINT(6) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 131
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha_has_rango_edad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha_has_rango_edad` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `rango_edad_id` INT(11) NOT NULL ,
  PRIMARY KEY (`ficha_id`, `rango_edad_id`) ,
  INDEX `fk_ficha_has_rango_edad_rango_edad1` (`rango_edad_id` ASC) ,
  INDEX `fk_ficha_has_rango_edad_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_rango_edad_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_rango_edad_ibfk_2`
    FOREIGN KEY (`rango_edad_id` )
    REFERENCES `cha_desarrollo`.`rango_edad` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`tag` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2126
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha_has_tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha_has_tag` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `tag_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `tag_id`) ,
  INDEX `fk_ficha_has_tag_tag1` (`tag_id` ASC) ,
  INDEX `fk_ficha_has_tag_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_tag_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_tag_ibfk_2`
    FOREIGN KEY (`tag_id` )
    REFERENCES `cha_desarrollo`.`tag` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`tema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`tema` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha_has_tema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha_has_tema` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `tema_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `tema_id`) ,
  INDEX `fk_ficha_has_tema_tema1` (`tema_id` ASC) ,
  INDEX `fk_ficha_has_tema_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_tema_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_tema_ibfk_2`
    FOREIGN KEY (`tema_id` )
    REFERENCES `cha_desarrollo`.`tema` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`tema_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`tema_empresa` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha_has_tema_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha_has_tema_empresa` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `tema_empresa_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `tema_empresa_id`) ,
  INDEX `fk_ficha_has_tema_empresa_tema1` (`tema_empresa_id` ASC) ,
  INDEX `fk_ficha_has_tema_empresa_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_tema_empresa_ibfk_2`
    FOREIGN KEY (`tema_empresa_id` )
    REFERENCES `cha_desarrollo`.`tema_empresa` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_tema_empresa_ibfk_3`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`genero`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`genero` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`usuario_backend`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`usuario_backend` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NOT NULL ,
  `nombres` VARCHAR(255) NOT NULL ,
  `apellidos` VARCHAR(255) NOT NULL ,
  `ministerial` TINYINT(1) NOT NULL ,
  `interministerial` TINYINT(1) NOT NULL ,
  `servicio_codigo` VARCHAR(8) NOT NULL DEFAULT 'ZZ999' COMMENT 'Deprecated' ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `activo` TINYINT(1) NULL DEFAULT '0' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email` (`email` ASC) ,
  INDEX `fk_usuario_backend_servicio1` (`servicio_codigo` ASC) ,
  CONSTRAINT `fk_usuario_backend_servicio1`
    FOREIGN KEY (`servicio_codigo` )
    REFERENCES `cha_desarrollo`.`servicio` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 194
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`historial`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`historial` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ficha_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `ficha_version_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `usuario_backend_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `descripcion` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_historial_ficha1` (`ficha_id` ASC) ,
  INDEX `fk_historial_usuario_backend1` (`usuario_backend_id` ASC) ,
  INDEX `ficha_version_id` (`ficha_version_id` ASC) ,
  CONSTRAINT `historial_ibfk_2`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL,
  CONSTRAINT `historial_ibfk_3`
    FOREIGN KEY (`ficha_version_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL,
  CONSTRAINT `historial_ibfk_4`
    FOREIGN KEY (`usuario_backend_id` )
    REFERENCES `cha_desarrollo`.`usuario_backend` (`id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL)
ENGINE = InnoDB
AUTO_INCREMENT = 21049
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`hit`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`hit` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `count` INT(10) UNSIGNED NOT NULL ,
  `fecha` DATE NOT NULL ,
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `fecha` (`fecha` ASC, `ficha_id` ASC) ,
  INDEX `fk_hit_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `hit_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 442539
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`oficina`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`oficina` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NULL DEFAULT NULL ,
  `direccion` VARCHAR(512) NOT NULL ,
  `horario` VARCHAR(128) NOT NULL ,
  `telefonos` VARCHAR(128) NOT NULL ,
  `fax` VARCHAR(128) NULL DEFAULT NULL ,
  `sector_codigo` VARCHAR(11) NOT NULL ,
  `servicio_codigo` VARCHAR(8) NOT NULL ,
  `lat` DOUBLE NULL DEFAULT NULL ,
  `lng` DOUBLE NULL DEFAULT NULL ,
  `director` VARCHAR(128) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_oficina_sector1` (`sector_codigo` ASC) ,
  INDEX `fk_oficina_servicio1` (`servicio_codigo` ASC) ,
  CONSTRAINT `fk_oficina_servicio1`
    FOREIGN KEY (`servicio_codigo` )
    REFERENCES `cha_desarrollo`.`servicio` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `oficina_ibfk_1`
    FOREIGN KEY (`sector_codigo` )
    REFERENCES `cha_desarrollo`.`sector` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 156
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`modulo_atencion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`modulo_atencion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nro_maquina` INT(2) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  `updated_at` DATETIME NOT NULL ,
  `servicio_codigo` VARCHAR(8) NOT NULL ,
  `sector_codigo` VARCHAR(11) NOT NULL ,
  `oficina_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_modulo_atencion_servicio1` (`servicio_codigo` ASC) ,
  INDEX `fk_modulo_atencion_sector1` (`sector_codigo` ASC) ,
  INDEX `fk_modulo_atencion_oficina1` (`oficina_id` ASC) ,
  CONSTRAINT `fk_modulo_atencion_oficina1`
    FOREIGN KEY (`oficina_id` )
    REFERENCES `cha_desarrollo`.`oficina` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_modulo_atencion_sector1`
    FOREIGN KEY (`sector_codigo` )
    REFERENCES `cha_desarrollo`.`sector` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_modulo_atencion_servicio1`
    FOREIGN KEY (`servicio_codigo` )
    REFERENCES `cha_desarrollo`.`servicio` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 106
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`noticia`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`noticia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `titulo` VARCHAR(255) NOT NULL ,
  `alias` VARCHAR(255) NOT NULL ,
  `resumen` VARCHAR(512) NOT NULL ,
  `contenido` TEXT NOT NULL ,
  `foto` VARCHAR(512) NULL DEFAULT NULL ,
  `publicado` TINYINT(1) NOT NULL ,
  `publicado_at` DATETIME NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `foto_descripcion` VARCHAR(128) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`, `alias`) ,
  UNIQUE INDEX `alias_UNIQUE` (`alias` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 66
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`rol`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`rol` (
  `id` VARCHAR(16) NOT NULL ,
  `nombre` VARCHAR(64) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`search_log`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`search_log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `search_query` TEXT NULL DEFAULT NULL ,
  `search_query_parsed` TEXT NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `cantidad_resultados` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1387416
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`tipo_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`tipo_empresa` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`usuario_backend_has_rol`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`usuario_backend_has_rol` (
  `usuario_backend_id` INT(10) UNSIGNED NOT NULL ,
  `rol_id` VARCHAR(16) NOT NULL ,
  PRIMARY KEY (`usuario_backend_id`, `rol_id`) ,
  INDEX `fk_usuario_backend_has_rol_rol1` (`rol_id` ASC) ,
  INDEX `fk_usuario_backend_has_rol_usuario_backend1` (`usuario_backend_id` ASC) ,
  CONSTRAINT `usuario_backend_has_rol_ibfk_1`
    FOREIGN KEY (`usuario_backend_id` )
    REFERENCES `cha_desarrollo`.`usuario_backend` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `usuario_backend_has_rol_ibfk_2`
    FOREIGN KEY (`rol_id` )
    REFERENCES `cha_desarrollo`.`rol` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`usuario_backend_has_servicio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`usuario_backend_has_servicio` (
  `usuario_backend_id` INT(10) UNSIGNED NOT NULL ,
  `servicio_codigo` VARCHAR(8) CHARACTER SET 'utf8' NOT NULL ,
  PRIMARY KEY (`usuario_backend_id`, `servicio_codigo`) ,
  INDEX `servicio_codigo` (`servicio_codigo` ASC) ,
  CONSTRAINT `usuario_backend_has_servicio_ibfk_1`
    FOREIGN KEY (`usuario_backend_id` )
    REFERENCES `cha_desarrollo`.`usuario_backend` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `usuario_backend_has_servicio_ibfk_2`
    FOREIGN KEY (`servicio_codigo` )
    REFERENCES `cha_desarrollo`.`servicio` (`codigo` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`rubro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`rubro` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha_has_rubro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha_has_rubro` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `rubro_id` INT NOT NULL ,
  PRIMARY KEY (`ficha_id`, `rubro_id`) ,
  INDEX `fk_ficha_has_rubro_rubro1` (`rubro_id` ASC) ,
  CONSTRAINT `fk_ficha_has_rubro_ficha1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_has_rubro_rubro1`
    FOREIGN KEY (`rubro_id` )
    REFERENCES `cha_desarrollo`.`rubro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`region`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`region` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha_has_region`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha_has_region` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `region_id` INT NOT NULL ,
  PRIMARY KEY (`ficha_id`, `region_id`) ,
  INDEX `fk_ficha_has_region_region1` (`region_id` ASC) ,
  CONSTRAINT `fk_ficha_has_region_ficha1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_has_region_region1`
    FOREIGN KEY (`region_id` )
    REFERENCES `cha_desarrollo`.`region` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha_has_apoyo_estado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha_has_apoyo_estado` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `apoyo_estado_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `apoyo_estado_id`) ,
  INDEX `fk_ficha_has_apoyo_estado_apoyo_estado1` (`apoyo_estado_id` ASC) ,
  CONSTRAINT `fk_ficha_has_apoyo_estado_ficha1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_has_apoyo_estado_apoyo_estado1`
    FOREIGN KEY (`apoyo_estado_id` )
    REFERENCES `cha_desarrollo`.`apoyo_estado` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`campana_modulo_has_sector`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`campana_modulo_has_sector` (
  `campana_modulo_id` INT(11) NOT NULL ,
  `sector_codigo` VARCHAR(11) CHARACTER SET 'utf8' NOT NULL ,
  PRIMARY KEY (`campana_modulo_id`, `sector_codigo`) ,
  INDEX `sector_codigo` (`sector_codigo` ASC) ,
  CONSTRAINT `campana_modulo_has_sector_ibfk_1`
    FOREIGN KEY (`campana_modulo_id` )
    REFERENCES `cha_desarrollo`.`campana_modulo` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `campana_modulo_has_sector_ibfk_2`
    FOREIGN KEY (`sector_codigo` )
    REFERENCES `cha_desarrollo`.`sector` (`codigo` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`evento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`evento` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `region_id` INT NOT NULL ,
  `postulacion_start` DATE NULL ,
  `postulacion_end` DATE NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_evento_region1` (`region_id` ASC) ,
  CONSTRAINT `fk_evento_region1`
    FOREIGN KEY (`region_id` )
    REFERENCES `cha_desarrollo`.`region` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cha_desarrollo`.`ficha_has_evento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cha_desarrollo`.`ficha_has_evento` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `evento_id` INT NOT NULL ,
  INDEX `fk_ficha_has_evento_ficha1` (`ficha_id` ASC) ,
  INDEX `fk_ficha_has_evento_evento1` (`evento_id` ASC) ,
  CONSTRAINT `fk_ficha_has_evento_ficha1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `cha_desarrollo`.`ficha` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_has_evento_evento1`
    FOREIGN KEY (`evento_id` )
    REFERENCES `cha_desarrollo`.`evento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
