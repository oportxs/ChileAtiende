-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 26-12-2012 a las 10:17:01
-- Versión del servidor: 5.5.28
-- Versión de PHP: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `chileatiende_desarrollo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `api_acceso`
--

CREATE TABLE IF NOT EXISTS `api_acceso` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `apellido` varchar(128) NOT NULL,
  `empresa` varchar(128) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=146 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `api_hit`
--

CREATE TABLE IF NOT EXISTS `api_hit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `count` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `api_acceso_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fecha` (`fecha`,`api_acceso_id`),
  KEY `fk_api_hits_api_acceso1` (`api_acceso_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=375 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo`
--

CREATE TABLE IF NOT EXISTS `archivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ficha_id` int(10) unsigned NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `url` text,
  `tipo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_archivos_ficha1` (`ficha_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campana_modulo`
--

CREATE TABLE IF NOT EXISTS `campana_modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chileclic_subtema`
--

CREATE TABLE IF NOT EXISTS `chileclic_subtema` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `chileclic_tema_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chileclic_tema_id` (`chileclic_tema_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chileclic_tema`
--

CREATE TABLE IF NOT EXISTS `chileclic_tema` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `chileclic_tipo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chileclic_tipo_id` (`chileclic_tipo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chileclic_tipo`
--

CREATE TABLE IF NOT EXISTS `chileclic_tipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ci_sessions_track`
--

CREATE TABLE IF NOT EXISTS `ci_sessions_track` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE IF NOT EXISTS `comentario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comentario` text NOT NULL,
  `ficha_id` int(10) unsigned NOT NULL,
  `usuario_frontend_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_evaluacion_ficha1` (`ficha_id`),
  KEY `fk_evaluacion_usuario_frontend1` (`usuario_frontend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
  `parametro` varchar(255) NOT NULL,
  `valor` text NOT NULL,
  PRIMARY KEY (`parametro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

CREATE TABLE IF NOT EXISTS `entidad` (
  `codigo` varchar(8) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `mision` text,
  `sigla` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapa_vida`
--

CREATE TABLE IF NOT EXISTS `etapa_vida` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orden` int(10) unsigned NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `descripcion` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orden` (`orden`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapa_vida_has_hecho_vida`
--

CREATE TABLE IF NOT EXISTS `etapa_vida_has_hecho_vida` (
  `etapa_vida_id` int(10) unsigned NOT NULL,
  `hecho_vida_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`etapa_vida_id`,`hecho_vida_id`),
  KEY `fk_etapa_vida_has_hecho_vida_hecho_vida1` (`hecho_vida_id`),
  KEY `fk_etapa_vida_has_hecho_vida_etapa_vida1` (`etapa_vida_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion`
--

CREATE TABLE IF NOT EXISTS `evaluacion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rating` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ficha_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_evaluacion_ficha2` (`ficha_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35410 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `a_paterno` varchar(45) NOT NULL,
  `a_materno` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `asunto` varchar(45) NOT NULL,
  `comentario` text NOT NULL,
  `enviado` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `origen` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=410 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha`
--

CREATE TABLE IF NOT EXISTS `ficha` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `correlativo` int(11) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `objetivo` text NOT NULL,
  `weight` int(10) unsigned DEFAULT NULL,
  `beneficiarios` text,
  `costo` text,
  `vigencia` text,
  `plazo` text NOT NULL,
  `guia_online` text,
  `guia_online_url` varchar(255) DEFAULT NULL,
  `guia_oficina` text,
  `guia_telefonico` text,
  `guia_correo` text,
  `marco_legal` text,
  `doc_requeridos` text,
  `maestro` tinyint(1) NOT NULL,
  `publicado` tinyint(1) NOT NULL,
  `publicado_at` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `estado` varchar(16) DEFAULT NULL,
  `estado_justificacion` text,
  `actualizable` tinyint(1) DEFAULT NULL,
  `destacado` tinyint(1) NOT NULL DEFAULT '0',
  `servicio_codigo` varchar(8) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `maestro_id` int(10) unsigned DEFAULT NULL,
  `genero_id` int(11) DEFAULT NULL,
  `convenio` tinyint(1) DEFAULT '0',
  `diagramacion` smallint(6) DEFAULT NULL,
  `cc_observaciones` text,
  `cc_id` varchar(20) DEFAULT NULL,
  `cc_formulario` text,
  `cc_llavevalor` int(11) DEFAULT NULL,
  `comentarios` text NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `flujo` tinyint(4) NOT NULL DEFAULT '0',
  `tema_principal` int(10) unsigned NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `sic` varchar(255) DEFAULT NULL,
  `sello_chilesinpapeleo` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`correlativo`,`servicio_codigo`),
  KEY `fk_ficha_servicio1` (`servicio_codigo`),
  KEY `fk_ficha_ficha1` (`maestro_id`),
  KEY `maestro` (`maestro`),
  KEY `publicado` (`publicado`),
  KEY `maestro_publicado` (`maestro`,`publicado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='no se agrega relacion con tabla genero.' AUTO_INCREMENT=16169 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_has_chileclic_subtema`
--

CREATE TABLE IF NOT EXISTS `ficha_has_chileclic_subtema` (
  `ficha_id` int(10) unsigned NOT NULL,
  `chileclic_subtema_id` int(11) NOT NULL,
  PRIMARY KEY (`ficha_id`,`chileclic_subtema_id`),
  KEY `chileclic_subtema_id` (`chileclic_subtema_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_has_hecho_vida`
--

CREATE TABLE IF NOT EXISTS `ficha_has_hecho_vida` (
  `ficha_id` int(10) unsigned NOT NULL,
  `hecho_vida_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ficha_id`,`hecho_vida_id`),
  KEY `fk_ficha_has_hecho_vida_hecho_vida1` (`hecho_vida_id`),
  KEY `fk_ficha_has_hecho_vida_ficha1` (`ficha_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_has_rango_edad`
--

CREATE TABLE IF NOT EXISTS `ficha_has_rango_edad` (
  `ficha_id` int(10) unsigned NOT NULL,
  `rango_edad_id` int(11) NOT NULL,
  PRIMARY KEY (`ficha_id`,`rango_edad_id`),
  KEY `fk_ficha_has_rango_edad_rango_edad1` (`rango_edad_id`),
  KEY `fk_ficha_has_rango_edad_ficha1` (`ficha_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_has_tag`
--

CREATE TABLE IF NOT EXISTS `ficha_has_tag` (
  `ficha_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ficha_id`,`tag_id`),
  KEY `fk_ficha_has_tag_tag1` (`tag_id`),
  KEY `fk_ficha_has_tag_ficha1` (`ficha_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_has_tema`
--

CREATE TABLE IF NOT EXISTS `ficha_has_tema` (
  `ficha_id` int(10) unsigned NOT NULL,
  `tema_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ficha_id`,`tema_id`),
  KEY `fk_ficha_has_tema_tema1` (`tema_id`),
  KEY `fk_ficha_has_tema_ficha1` (`ficha_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flujo`
--

CREATE TABLE IF NOT EXISTS `flujo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flujo_has_hecho_vida`
--

CREATE TABLE IF NOT EXISTS `flujo_has_hecho_vida` (
  `flujo_id` int(11) NOT NULL,
  `hecho_vida_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`flujo_id`,`hecho_vida_id`),
  KEY `fk_flujo_has_hecho_vida_hecho_vida1` (`hecho_vida_id`),
  KEY `fk_flujo_has_hecho_vida_flujo1` (`flujo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE IF NOT EXISTS `genero` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hecho_vida`
--

CREATE TABLE IF NOT EXISTS `hecho_vida` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `descripcion` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE IF NOT EXISTS `historial` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ficha_id` int(10) unsigned DEFAULT NULL,
  `ficha_version_id` int(10) unsigned DEFAULT NULL,
  `usuario_backend_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_historial_ficha1` (`ficha_id`),
  KEY `fk_historial_usuario_backend1` (`usuario_backend_id`),
  KEY `ficha_version_id` (`ficha_version_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20226 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hit`
--

CREATE TABLE IF NOT EXISTS `hit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `count` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `ficha_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fecha` (`fecha`,`ficha_id`),
  KEY `fk_hit_ficha1` (`ficha_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=408351 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_atencion`
--

CREATE TABLE IF NOT EXISTS `modulo_atencion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nro_maquina` int(2) NOT NULL,
  `descripcion` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `servicio_codigo` varchar(8) NOT NULL,
  `sector_codigo` varchar(11) NOT NULL,
  `oficina_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_modulo_atencion_servicio1` (`servicio_codigo`),
  KEY `fk_modulo_atencion_sector1` (`sector_codigo`),
  KEY `fk_modulo_atencion_oficina1` (`oficina_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=105 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE IF NOT EXISTS `noticia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `resumen` varchar(512) NOT NULL,
  `contenido` text NOT NULL,
  `foto` varchar(512) DEFAULT NULL,
  `publicado` tinyint(1) NOT NULL,
  `publicado_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `foto_descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`,`alias`),
  UNIQUE KEY `alias_UNIQUE` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficina`
--

CREATE TABLE IF NOT EXISTS `oficina` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) DEFAULT NULL,
  `direccion` varchar(512) NOT NULL,
  `horario` varchar(128) NOT NULL,
  `telefonos` varchar(128) NOT NULL,
  `fax` varchar(128) DEFAULT NULL,
  `sector_codigo` varchar(11) NOT NULL,
  `servicio_codigo` varchar(8) NOT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `director` varchar(128) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oficina_sector1` (`sector_codigo`),
  KEY `fk_oficina_servicio1` (`servicio_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=155 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rango_edad`
--

CREATE TABLE IF NOT EXISTS `rango_edad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `edad_minima` smallint(6) DEFAULT NULL,
  `edad_maxima` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=130 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id` varchar(16) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `descripcion` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `search_log`
--

CREATE TABLE IF NOT EXISTS `search_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `search_query` text,
  `search_query_parsed` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1260478 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sector`
--

CREATE TABLE IF NOT EXISTS `sector` (
  `codigo` varchar(11) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL,
  `sector_padre_codigo` varchar(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_sector_sector1` (`sector_padre_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE IF NOT EXISTS `servicio` (
  `codigo` varchar(8) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `sigla` varchar(32) DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL,
  `responsable` varchar(128) DEFAULT NULL,
  `entidad_codigo` varchar(8) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `mision` text NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_servicio_entidad` (`entidad_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistema_previsional`
--

CREATE TABLE IF NOT EXISTS `sistema_previsional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistema_salud`
--

CREATE TABLE IF NOT EXISTS `sistema_salud` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2032 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE IF NOT EXISTS `tema` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_backend`
--

CREATE TABLE IF NOT EXISTS `usuario_backend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `ministerial` tinyint(1) NOT NULL,
  `interministerial` tinyint(1) NOT NULL,
  `servicio_codigo` varchar(8) NOT NULL DEFAULT 'ZZ999' COMMENT 'Deprecated',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_usuario_backend_servicio1` (`servicio_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=191 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_backend_has_rol`
--

CREATE TABLE IF NOT EXISTS `usuario_backend_has_rol` (
  `usuario_backend_id` int(10) unsigned NOT NULL,
  `rol_id` varchar(16) NOT NULL,
  PRIMARY KEY (`usuario_backend_id`,`rol_id`),
  KEY `fk_usuario_backend_has_rol_rol1` (`rol_id`),
  KEY `fk_usuario_backend_has_rol_usuario_backend1` (`usuario_backend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_backend_has_servicio`
--

CREATE TABLE IF NOT EXISTS `usuario_backend_has_servicio` (
  `usuario_backend_id` int(10) unsigned NOT NULL,
  `servicio_codigo` varchar(8) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`usuario_backend_id`,`servicio_codigo`),
  KEY `servicio_codigo` (`servicio_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_frontend`
--

CREATE TABLE IF NOT EXISTS `usuario_frontend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `sexo` char(1) DEFAULT NULL,
  `edad` int(10) unsigned DEFAULT NULL,
  `sector_codigo` varchar(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `sistema_salud_id` int(10) unsigned NOT NULL,
  `sistema_previsional_id` int(10) unsigned NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_usuario_frontend_sector1` (`sector_codigo`),
  KEY `fk_usuario_frontend_sistema_salud1` (`sistema_salud_id`),
  KEY `fk_usuario_frontend_sistema_previsional1` (`sistema_previsional_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `api_hit`
--
ALTER TABLE `api_hit`
  ADD CONSTRAINT `fk_api_hits_api_acceso1` FOREIGN KEY (`api_acceso_id`) REFERENCES `api_acceso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD CONSTRAINT `fk_archivos_ficha1` FOREIGN KEY (`ficha_id`) REFERENCES `ficha` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `chileclic_subtema`
--
ALTER TABLE `chileclic_subtema`
  ADD CONSTRAINT `chileclic_subtema_ibfk_1` FOREIGN KEY (`chileclic_tema_id`) REFERENCES `chileclic_tema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `chileclic_tema`
--
ALTER TABLE `chileclic_tema`
  ADD CONSTRAINT `chileclic_tema_ibfk_1` FOREIGN KEY (`chileclic_tipo_id`) REFERENCES `chileclic_tipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `fk_evaluacion_ficha1` FOREIGN KEY (`ficha_id`) REFERENCES `ficha` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evaluacion_usuario_frontend1` FOREIGN KEY (`usuario_frontend_id`) REFERENCES `usuario_frontend` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `etapa_vida_has_hecho_vida`
--
ALTER TABLE `etapa_vida_has_hecho_vida`
  ADD CONSTRAINT `etapa_vida_has_hecho_vida_ibfk_1` FOREIGN KEY (`etapa_vida_id`) REFERENCES `etapa_vida` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etapa_vida_has_hecho_vida_ibfk_2` FOREIGN KEY (`hecho_vida_id`) REFERENCES `hecho_vida` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD CONSTRAINT `evaluacion_ibfk_1` FOREIGN KEY (`ficha_id`) REFERENCES `ficha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD CONSTRAINT `ficha_ibfk_1` FOREIGN KEY (`maestro_id`) REFERENCES `ficha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ficha_servicio1` FOREIGN KEY (`servicio_codigo`) REFERENCES `servicio` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ficha_has_chileclic_subtema`
--
ALTER TABLE `ficha_has_chileclic_subtema`
  ADD CONSTRAINT `ficha_has_chileclic_subtema_ibfk_1` FOREIGN KEY (`chileclic_subtema_id`) REFERENCES `chileclic_subtema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ficha_has_chileclic_subtema_ibfk_2` FOREIGN KEY (`ficha_id`) REFERENCES `ficha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ficha_has_hecho_vida`
--
ALTER TABLE `ficha_has_hecho_vida`
  ADD CONSTRAINT `ficha_has_hecho_vida_ibfk_1` FOREIGN KEY (`ficha_id`) REFERENCES `ficha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ficha_has_hecho_vida_ibfk_2` FOREIGN KEY (`hecho_vida_id`) REFERENCES `hecho_vida` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ficha_has_rango_edad`
--
ALTER TABLE `ficha_has_rango_edad`
  ADD CONSTRAINT `ficha_has_rango_edad_ibfk_1` FOREIGN KEY (`ficha_id`) REFERENCES `ficha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ficha_has_rango_edad_ibfk_2` FOREIGN KEY (`rango_edad_id`) REFERENCES `rango_edad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ficha_has_tag`
--
ALTER TABLE `ficha_has_tag`
  ADD CONSTRAINT `ficha_has_tag_ibfk_1` FOREIGN KEY (`ficha_id`) REFERENCES `ficha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ficha_has_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ficha_has_tema`
--
ALTER TABLE `ficha_has_tema`
  ADD CONSTRAINT `ficha_has_tema_ibfk_1` FOREIGN KEY (`ficha_id`) REFERENCES `ficha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ficha_has_tema_ibfk_2` FOREIGN KEY (`tema_id`) REFERENCES `tema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `flujo_has_hecho_vida`
--
ALTER TABLE `flujo_has_hecho_vida`
  ADD CONSTRAINT `flujo_has_hecho_vida_ibfk_1` FOREIGN KEY (`flujo_id`) REFERENCES `flujo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flujo_has_hecho_vida_ibfk_2` FOREIGN KEY (`hecho_vida_id`) REFERENCES `hecho_vida` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_2` FOREIGN KEY (`ficha_id`) REFERENCES `ficha` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `historial_ibfk_3` FOREIGN KEY (`ficha_version_id`) REFERENCES `ficha` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `historial_ibfk_4` FOREIGN KEY (`usuario_backend_id`) REFERENCES `usuario_backend` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `hit`
--
ALTER TABLE `hit`
  ADD CONSTRAINT `hit_ibfk_1` FOREIGN KEY (`ficha_id`) REFERENCES `ficha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `modulo_atencion`
--
ALTER TABLE `modulo_atencion`
  ADD CONSTRAINT `fk_modulo_atencion_oficina1` FOREIGN KEY (`oficina_id`) REFERENCES `oficina` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_modulo_atencion_sector1` FOREIGN KEY (`sector_codigo`) REFERENCES `sector` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_modulo_atencion_servicio1` FOREIGN KEY (`servicio_codigo`) REFERENCES `servicio` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `oficina`
--
ALTER TABLE `oficina`
  ADD CONSTRAINT `fk_oficina_servicio1` FOREIGN KEY (`servicio_codigo`) REFERENCES `servicio` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `oficina_ibfk_1` FOREIGN KEY (`sector_codigo`) REFERENCES `sector` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `fk_servicio_entidad` FOREIGN KEY (`entidad_codigo`) REFERENCES `entidad` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_backend`
--
ALTER TABLE `usuario_backend`
  ADD CONSTRAINT `fk_usuario_backend_servicio1` FOREIGN KEY (`servicio_codigo`) REFERENCES `servicio` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_backend_has_rol`
--
ALTER TABLE `usuario_backend_has_rol`
  ADD CONSTRAINT `usuario_backend_has_rol_ibfk_1` FOREIGN KEY (`usuario_backend_id`) REFERENCES `usuario_backend` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_backend_has_rol_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_backend_has_servicio`
--
ALTER TABLE `usuario_backend_has_servicio`
  ADD CONSTRAINT `usuario_backend_has_servicio_ibfk_1` FOREIGN KEY (`usuario_backend_id`) REFERENCES `usuario_backend` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_backend_has_servicio_ibfk_2` FOREIGN KEY (`servicio_codigo`) REFERENCES `servicio` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_frontend`
--
ALTER TABLE `usuario_frontend`
  ADD CONSTRAINT `fk_usuario_frontend_sistema_previsional1` FOREIGN KEY (`sistema_previsional_id`) REFERENCES `sistema_previsional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_frontend_sistema_salud1` FOREIGN KEY (`sistema_salud_id`) REFERENCES `sistema_salud` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_frontend_ibfk_1` FOREIGN KEY (`sector_codigo`) REFERENCES `sector` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
