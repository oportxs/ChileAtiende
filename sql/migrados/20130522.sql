ALTER TABLE `ficha_has_ficha_similar` ADD FOREIGN KEY ( `ficha_id` ) REFERENCES `chileatiende`.`ficha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE `ficha_has_ficha_similar` ADD FOREIGN KEY ( `ficha_similar_id` ) REFERENCES `chileatiende`.`ficha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;
