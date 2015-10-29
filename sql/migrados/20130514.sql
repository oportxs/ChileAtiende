CREATE TABLE `ficha_has_ficha_similar` (
  `ficha_id` int(10) unsigned NOT NULL,
  `ficha_similar_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ficha_id`,`ficha_similar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

