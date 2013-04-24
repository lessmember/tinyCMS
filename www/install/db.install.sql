

CREATE TABLE IF NOT EXISTS `users` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`login` varchar(32) NOT NULL,
	`pass` varchar(32) NOT NULL,
	`email` varchar(64) NOT NULL,
	`hash` char(128)
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

