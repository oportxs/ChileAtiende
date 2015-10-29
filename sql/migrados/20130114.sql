-- Nuevo campo en la Ficha para el sello de chilesinpapeleo
ALTER TABLE  `ficha` ADD  `sello_chilesinpapeleo` BOOLEAN NOT NULL DEFAULT  '0';

-- Nuevo rol para la asignación del sello chilesinpapeleo
INSERT INTO  `rol` (
`id` ,
`nombre` ,
`descripcion` ,
`created_at` ,
`updated_at`
)
VALUES (
'chilesinpapeleo',  'Chilesinpapeleo',  'Usuario encargado de marcar las fichas con el sello de ChileSinPapeleo', NOW() , NOW()
);

-- Nueva tabla para las campañas asociadas a los modulos de atención

CREATE TABLE IF NOT EXISTS `campana_modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- Busquedas
ALTER TABLE  `search_log` ADD  `cantidad_resultados` INT( 11 ) NULL DEFAULT NULL