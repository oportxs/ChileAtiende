-- 20130225.sql

-- -----------------------------------------------------
-- Table `etapa_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `etapa_empresa` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `orden` INT(10) UNSIGNED NOT NULL ,
  `nombre` VARCHAR(128) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- Volcado de datos para la tabla `etapa_empresa`
--

INSERT INTO `etapa_empresa` (`id`, `orden`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 0, 'Sólo una idea', '', NULL, NULL),
(2, 0, 'Crear una empresa', '', NULL, NULL),
(3, 0, 'El primer año', '', NULL, NULL),
(4, 0, 'Crecer / financiar', '', NULL, NULL),
(5, 0, 'En problemas', '', NULL, NULL);


-- -----------------------------------------------------
-- Table `hecho_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hecho_empresa` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `order_by` INT UNSIGNED NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) 
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- Volcado de datos para la tabla `hecho_empresa`
--

INSERT INTO `hecho_empresa` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`, `order_by`) VALUES
(1, 'Antes de empezar', '', NULL, NULL, NULL),
(2, 'Crear tu empresa paso a paso', '', NULL, NULL, NULL),
(3, 'Contratar trabajadores', '', NULL, NULL, NULL),
(4, 'Autorizaciones y permisos', '', NULL, NULL, NULL),
(5, 'Pagar impuestos', '', NULL, NULL, NULL),
(6, 'Contratar trabajadores', '', NULL, NULL, NULL),
(7, 'Autorizaciones y permisos', '', NULL, NULL, NULL),
(8, 'Exportar - importar', '', NULL, NULL, NULL),
(9, 'Marcas y propiedad intelectual', '', NULL, NULL, NULL),
(10, 'Venderle al Estado', '', NULL, NULL, NULL),
(11, 'Autorizaciones y permisos', '', NULL, NULL, NULL),
(12, 'Empresa en problemas', '', NULL, NULL, NULL),
(13, 'Terminar con el giro', '', NULL, NULL, NULL);


--
-- Estructura de tabla para la tabla `tema_empresa`
--

CREATE TABLE IF NOT EXISTS `tema_empresa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- Volcado de datos para la tabla `tema_empresa`
--

INSERT INTO `tema_empresa` (`id`, `nombre`) VALUES
(1, 'Laborales'),
(2, 'Tributarios'),
(3, 'Sanitarios'),
(4, 'De exportación / importación');


-- -----------------------------------------------------
-- Table `etapa_empresa_has_hecho_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `etapa_empresa_has_hecho_empresa` (
  `etapa_empresa_id` INT(10) UNSIGNED NOT NULL ,
  `hecho_empresa_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`etapa_empresa_id`, `hecho_empresa_id`) ,
  INDEX `fk_etapa_empresa_has_hecho_empresa_hecho_empresa1` (`hecho_empresa_id` ASC) ,
  INDEX `fk_etapa_empresa_has_hecho_empresa_etapa_empresa1` (`etapa_empresa_id` ASC) ,
  CONSTRAINT `etapa_empresa_has_hecho_empresa_ibfk_1`
    FOREIGN KEY (`etapa_empresa_id` )
    REFERENCES `etapa_empresa` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `etapa_empresa_has_hecho_empresa_ibfk_2`
    FOREIGN KEY (`hecho_empresa_id` )
    REFERENCES `hecho_empresa` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- Volcado de datos para la tabla `etapa_empresa_has_hecho_empresa`
--

INSERT INTO `etapa_empresa_has_hecho_empresa` (`etapa_empresa_id`, `hecho_empresa_id`) VALUES
(1, 1),
(2, 2),
(2, 3),
(2, 4),
(3, 5),
(3, 6),
(3, 7),
(4, 8),
(4, 9),
(4, 10),
(4, 11),
(5, 12),
(5, 13);


-- -----------------------------------------------------
-- Table `ficha_has_hecho_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ficha_has_hecho_empresa` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `hecho_empresa_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `hecho_empresa_id`) ,
  INDEX `fk_ficha_has_hecho_empresa_hecho_empresa1` (`hecho_empresa_id` ASC) ,
  INDEX `fk_ficha_has_hecho_empresa_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_hecho_empresa_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_hecho_empresa_ibfk_2`
    FOREIGN KEY (`hecho_empresa_id` )
    REFERENCES `hecho_empresa` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- -----------------------------------------------------
-- Table `ficha_has_tema_empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ficha_has_tema_empresa` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `tema_empresa_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `tema_empresa_id`) ,
  INDEX `fk_ficha_has_tema_empresa_tema1` (`tema_empresa_id` ASC) ,
  INDEX `fk_ficha_has_tema_empresa_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_tema_empresa_ibfk_2`
    FOREIGN KEY (`tema_empresa_id` )
    REFERENCES `tema_empresa` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_tema_empresa_ibfk_3`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- -----------------------------------------------------
-- Table `apoyo_estado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `apoyo_estado` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `order_by` INT UNSIGNED NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) 
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- Volcado de datos para la tabla `apoyo_estado`
--

INSERT INTO `apoyo_estado` (`id`, `nombre`, `created_at`, `updated_at`, `order_by`) VALUES
(1, 'Financiamiento (capital)', NULL, NULL, 0),
(2, 'Financiamiento (crédito)', NULL, NULL, 0),
(3, 'Asesorías', NULL, NULL, 0),
(4, 'Capacitación', NULL, NULL, 0),
(5, 'Incentivos tributarios', NULL, NULL, 0),
(6, 'Seguros', NULL, NULL, 0),
(7, 'Marketing y estudios', NULL, NULL, 0),
(8, 'Financiamiento (capital)', '2013-05-06 12:21:40', '2013-05-06 12:21:40', 0),
(9, 'Financiamiento (crédito)', '2013-05-06 12:21:49', '2013-05-06 12:21:49', 0),
(10, 'Asesorías', '2013-05-06 12:21:58', '2013-05-06 12:21:58', 0),
(11, 'Capacitación', '2013-05-06 12:22:05', '2013-05-06 12:22:05', 0),
(12, 'Incentivos tributarios', '2013-05-06 12:22:11', '2013-05-06 12:22:11', 0),
(13, 'Seguros', '2013-05-06 12:22:20', '2013-05-06 12:22:20', 0),
(14, 'Marketing y estudios', '2013-05-06 12:22:28', '2013-05-06 12:22:28', 0),
(15, 'Financiamiento (capital)', '2013-05-06 12:24:49', '2013-05-06 12:24:49', 0),
(16, 'Financiamiento (crédito)', '2013-05-06 12:24:58', '2013-05-06 12:24:58', 0),
(17, 'Asesorías', '2013-05-06 12:25:08', '2013-05-06 12:25:08', 0),
(18, 'Capacitación', '2013-05-06 12:25:19', '2013-05-06 12:25:19', 0),
(19, 'Incentivos tributarios', '2013-05-06 12:25:29', '2013-05-06 12:25:29', 0),
(20, 'Seguros', '2013-05-06 12:25:39', '2013-05-06 12:25:39', 0),
(21, 'Marketing y estudios', '2013-05-06 12:25:47', '2013-05-06 12:25:47', 0),
(22, 'Financiamiento (capital)', '2013-05-06 12:25:58', '2013-05-06 12:25:58', 0),
(23, 'Financiamiento (crédito)', '2013-05-06 12:26:07', '2013-05-06 12:26:07', 0),
(24, 'Asesorías', '2013-05-06 12:26:13', '2013-05-06 12:26:13', 0),
(25, 'Capacitación', '2013-05-06 12:26:19', '2013-05-06 12:26:19', 0),
(26, 'Incentivos tributarios', '2013-05-06 12:26:25', '2013-05-06 12:26:25', 0),
(27, 'Seguros', '2013-05-06 12:26:34', '2013-05-06 12:26:34', 0),
(28, 'Marketing y estudios', '2013-05-06 12:26:42', '2013-05-06 12:26:42', 0),
(29, 'Financiamiento (capital)', '2013-05-06 12:26:49', '2013-05-06 12:26:49', 0),
(30, 'Financiamiento (crédito)', '2013-05-06 12:26:56', '2013-05-06 12:26:56', 0),
(31, 'Asesorías', '2013-05-06 12:27:03', '2013-05-06 12:27:03', 0),
(32, 'Capacitación', '2013-05-06 12:27:09', '2013-05-06 12:27:09', 0),
(33, 'Incentivos tributarios', '2013-05-06 12:27:15', '2013-05-06 12:27:15', 0),
(34, 'Seguros', '2013-05-06 12:27:22', '2013-05-06 12:27:22', 0),
(35, 'Marketing y estudios', '2013-05-06 12:27:29', '2013-05-06 12:27:29', 0);

--
-- -----------------------------------------------------
-- Table `ficha_has_apoyo_estado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ficha_has_apoyo_estado` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `apoyo_estado_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `apoyo_estado_id`) ,
  INDEX `fk_ficha_has_apoyo_estado_apoyo_estado1` (`apoyo_estado_id` ASC) ,
  CONSTRAINT `fk_ficha_has_apoyo_estado_ficha1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `ficha` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_has_apoyo_estado_apoyo_estado1`
    FOREIGN KEY (`apoyo_estado_id` )
    REFERENCES `apoyo_estado` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- -----------------------------------------------------
-- modificacion tabla ficha
-- -----------------------------------------------------
  ALTER TABLE  `ficha` ADD  `fps` tinyint(1) DEFAULT NULL;
  ALTER TABLE  `ficha` ADD  `puntaje_fps_min` int(11) DEFAULT NULL;
  ALTER TABLE  `ficha` ADD  `puntaje_fps_max` int(11) DEFAULT NULL;
  ALTER TABLE  `ficha` ADD  `formalizacion` tinyint(1) DEFAULT NULL;
  ALTER TABLE  `ficha` ADD  `nro_trabajadores` int(3) DEFAULT NULL;
  ALTER TABLE  `ficha` ADD  `req_especial` text DEFAULT NULL;


-- -----------------------------------------------------
-- creacion tabla region para eventos
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `region` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) 
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- -----------------------------------------------------
-- Table `evento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `evento` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `region_id` INT NOT NULL ,
  `postulacion_start` DATE NULL ,
  `postulacion_end` DATE NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_evento_region1` (`region_id` ASC) ,
  CONSTRAINT `fk_evento_region1`
    FOREIGN KEY (`region_id` )
    REFERENCES `region` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- -----------------------------------------------------
-- Table `ficha_has_evento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ficha_has_evento` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `evento_id` INT NOT NULL ,
  INDEX `fk_ficha_has_evento_ficha1` (`ficha_id` ASC) ,
  INDEX `fk_ficha_has_evento_evento1` (`evento_id` ASC) ,
  CONSTRAINT `fk_ficha_has_evento_ficha1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `ficha` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_has_evento_evento1`
    FOREIGN KEY (`evento_id` )
    REFERENCES `evento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- -----------------------------------------------------
-- Table `rubro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `rubro` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) 
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- Volcado de datos para la tabla `rubro`
--

INSERT INTO `rubro` (`id`, `nombre`) VALUES
(1, 'Pesca'),
(2, 'Acuicultura'),
(3, 'Agricultura'),
(4, 'Ganadería'),
(5, 'Silvicultura'),
(6, 'Minería'),
(7, 'Construcción'),
(8, 'Otro');


-- -----------------------------------------------------
-- Table `ficha_has_rubro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ficha_has_rubro` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `rubro_id` INT NOT NULL ,
  PRIMARY KEY (`ficha_id`, `rubro_id`) ,
  INDEX `fk_ficha_has_rubro_rubro1` (`rubro_id` ASC) ,
  CONSTRAINT `fk_ficha_has_rubro_ficha1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `ficha` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_has_rubro_rubro1`
    FOREIGN KEY (`rubro_id` )
    REFERENCES `rubro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- se agrega nuevo Rol para administracion calendario
--
INSERT INTO  `rol` (`id`, `nombre` ) VALUES ('chapyme', 'ChileAtiende Pymes');

-- -----------------------------------------------------
-- tipo empresa
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tipo_empresa` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) 
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


--
-- Volcado de datos para la tabla `region`
--

INSERT INTO `region` (`id`, `nombre`) VALUES
(1, 'Tarapacá'),
(2, 'Antofagasta'),
(3, 'Atacama'),
(4, 'Coquimbo'),
(5, 'Valparaíso'),
(6, 'Del Libertador Gral. Bernardo O’Higgins'),
(7, 'Del Maule'),
(8, 'Del Biobío'),
(9, 'De la Araucanía'),
(10, 'De los Lagos'),
(11, 'Aysén del Gral. Carlos Ibáñez del Campo'),
(12, 'Magallanes y de la Antártica Chilena'),
(13, 'Metropolitana de Santiago'),
(14, 'De los Ríos'),
(15, 'Arica y Parinacota');

--
-- 
--
CREATE  TABLE IF NOT EXISTS `etapa_empresa_has_apoyo_estado` (
  `etapa_empresa_id` INT(10) UNSIGNED NOT NULL ,
  `apoyo_estado_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`etapa_empresa_id`, `apoyo_estado_id`) ,
  INDEX `fk_etapa_empresa_has_apoyo_estado_apoyo_estado1` (`apoyo_estado_id` ASC) ,
  CONSTRAINT `fk_etapa_empresa_has_apoyo_estado_etapa_empresa1`
    FOREIGN KEY (`etapa_empresa_id` )
    REFERENCES `etapa_empresa` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etapa_empresa_has_apoyo_estado_apoyo_estado1`
    FOREIGN KEY (`apoyo_estado_id` )
    REFERENCES `apoyo_estado` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- Volcado de datos para la tabla `etapa_empresa_has_apoyo_estado`
--

INSERT INTO `etapa_empresa_has_apoyo_estado` (`etapa_empresa_id`, `apoyo_estado_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 25),
(4, 26),
(4, 27),
(4, 28),
(5, 29),
(5, 30),
(5, 31),
(5, 32),
(5, 33),
(5, 34),
(5, 35);


-- creacion rol calendario
INSERT INTO `rol` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES ('calendario', 'Calendario', 'calendario', NULL, NULL);  

--
-- Estructura de tabla para la tabla `tipo_empresa`
--

CREATE TABLE IF NOT EXISTS `tipo_empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tipo_empresa`
--

INSERT INTO `tipo_empresa` (`id`, `nombre`) VALUES
(1, '2.400 U.F.'),
(2, '25.000 U.F.'),
(3, '100.000 U.F.'),
(4, 'Grande');

--
-- Estructura de tabla para la tabla `ficha_has_tipo_empresa`
--

CREATE TABLE IF NOT EXISTS `ficha_has_tipo_empresa` (
  `ficha_id` int(10) unsigned NOT NULL,
  `tipo_empresa_id` int(11) NOT NULL,
  PRIMARY KEY (`ficha_id`,`tipo_empresa_id`),
  KEY `fk_ficha_has_tipo_empresa_tipo_empresa1` (`tipo_empresa_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ficha_has_tipo_empresa`
--
ALTER TABLE `ficha_has_tipo_empresa`
  ADD CONSTRAINT `fk_ficha_has_tipo_empresa_ficha1` FOREIGN KEY (`ficha_id`) REFERENCES `ficha` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ficha_has_tipo_empresa_tipo_empresa1` FOREIGN KEY (`tipo_empresa_id`) REFERENCES `tipo_empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
