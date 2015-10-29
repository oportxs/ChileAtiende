--
-- Estructura de tabla para la tabla `usuario_backend_has_servicio`
--
CREATE TABLE IF NOT EXISTS `campana_modulo_has_sector` (
  `campana_modulo_id` int(11) NOT NULL,
  `sector_codigo` varchar(11) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`campana_modulo_id`,`sector_codigo`),
  KEY `sector_codigo` (`sector_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `campana_modulo_has_sector`
--
ALTER TABLE `campana_modulo_has_sector`
  ADD CONSTRAINT `campana_modulo_has_sector_ibfk_1` FOREIGN KEY (`campana_modulo_id`) REFERENCES `campana_modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `campana_modulo_has_sector_ibfk_2` FOREIGN KEY (`sector_codigo`) REFERENCES `sector` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;
