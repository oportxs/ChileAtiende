--
-- Estructura de tabla para la tabla `contenido`
--

CREATE TABLE IF NOT EXISTS `contenido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `contenido` text,
  `plantilla` varchar(255) DEFAULT NULL,
  `maestro` tinyint(1) DEFAULT NULL,
  `maestro_id` int(10) unsigned NULL,
  `publicado` tinyint(1) DEFAULT NULL,
  `publicado_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maestro_id` (`maestro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD CONSTRAINT `fk_contenido_maestro` FOREIGN KEY (`maestro_id`) REFERENCES `contenido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Estructura de tabla para la tabla `historial_contenido`
--

CREATE TABLE IF NOT EXISTS `historial_contenido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contenido_id` int(10) unsigned DEFAULT NULL,
  `contenido_version_id` int(10) unsigned DEFAULT NULL,
  `usuario_backend_id` int(10) unsigned DEFAULT NULL,
  `descripcion` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contenido_version_id` (`contenido_version_id`),
  KEY `fk_contenido_id` (`contenido_id`),
  KEY `fk_usuario_backend_id` (`usuario_backend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_contenido`
--
ALTER TABLE `historial_contenido`
  ADD CONSTRAINT `historial_contenido_ibfk_1` FOREIGN KEY (`usuario_backend_id`) REFERENCES `usuario_backend` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `historial_contenido_ibfk_2` FOREIGN KEY (`contenido_version_id`) REFERENCES `contenido` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `historial_contenido_ibfk_3` FOREIGN KEY (`contenido_id`) REFERENCES `contenido` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;