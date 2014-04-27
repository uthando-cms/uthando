
DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
    `id` char(32),
    `name` char(32),
    `modified` int,
    `lifetime` int,
    `data` text,
     PRIMARY KEY (`id`, `name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
