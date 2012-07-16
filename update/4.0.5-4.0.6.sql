-- 1. sql
INSERT INTO `settings` (`key`, `value`, `name`, `description`, `group_id`, `type`, `param`) VALUES
	('lineage_sab_or_base_class', 'class_id', 'Какой класс', 'Выводить в статистике название класса персонажа: class_id - саб класс, base_class - базовый класс', 10, 'dropdown', 'class_id,base_class'),
	('count_failed_login_attempts', 3, 'Кол-во неудачных попыток', 'Введите ко-во неудачных попыток входа в личный кабинет после которых пользователь будет заблокирован по IP', 1, 'input', NULL),
	('time_blocked_login_attempts', 15, 'Время блокировки', 'На сколько в минутах пользователь будет заблокирован', 1, 'input', NULL)


-- 2. sql
CREATE TABLE `login_attempts` (
	`ip` varchar(25) NOT NULL,
	`date` datetime NOT NULL,
	`count` tinyint(4) NOT NULL,
	UNIQUE KEY `xIp` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 3. sql
ALTER TABLE shop_products ADD `enchant_level` smallint(6) unsigned NOT NULL DEFAULT '0'
ALTER TABLE shop_products ADD `item_type` enum('no_stock','stock') NOT NULL DEFAULT 'stock',
ALTER TABLE users_warehouse ADD `enchant_level` smallint(6) NOT NULL,
ALTER TABLE shop_products ADD `deleted` tinyint(1) unsigned NOT NULL,
