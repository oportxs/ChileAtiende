CREATE TABLE `diccionario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `termino` varchar(128) NOT NULL,
  `definicion` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `termino` (`termino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;