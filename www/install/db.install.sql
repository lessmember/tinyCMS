-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 23 2013 г., 16:24
-- Версия сервера: 5.5.32
-- Версия PHP: 5.3.10-1ubuntu3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `tinycms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `value` tinytext NOT NULL,
  `type` enum('num','string','bool','array') NOT NULL DEFAULT 'string',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `options`
--

INSERT INTO `options` (`id`, `name`, `value`, `type`) VALUES
(1, 'theme', 'default', 'string'),
(2, 'default.page', '3', 'string'),
(3, 'default.page.type', 'section', 'string'),
(4, 'project.title', 'Обо всем на свете', 'string');

-- --------------------------------------------------------

--
-- Структура таблицы `option_values`
--

CREATE TABLE IF NOT EXISTS `option_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `option` int(10) unsigned NOT NULL,
  `value` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `option` (`option`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `option_values`
--

INSERT INTO `option_values` (`id`, `option`, `value`) VALUES
(1, 1, 'default'),
(2, 1, 'red-lake'),
(3, 1, 'blue-sky'),
(4, 3, 'page'),
(5, 3, 'section'),
(9, 1, 'q123456'),
(10, 1, 'test002'),
(11, 1, 'test003');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(10) unsigned NOT NULL,
  `title` tinytext NOT NULL,
  `url_name` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `role` enum('parent_face') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_name` (`url_name`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `parent`, `title`, `url_name`, `content`, `active`, `role`) VALUES
(1, 2, 'Test 001', 'test-001', 'test page 1', 1, NULL),
(2, 3, 'test 2', 'test-002', 'test page 2', 1, NULL),
(3, 3, 'test 3', 'test-003', 'test page 3', 1, NULL),
(4, 8, 'test page 8.1', 'test-8-001', 'test page 08-001', 1, NULL),
(5, 3, 'test page 3.3', 'page-3-3', 'test page 3-003', 1, NULL),
(6, 2, 'Test page 002', 'page-test-002', 'test page 002', 1, NULL),
(7, 11, 'Test page 08 sub 01', 'page-test-08-01', 'test page 08 -01', 1, NULL),
(8, 11, 'Test page 08 sub 02', 'page-08-02', 'test page 08 - 02', 1, NULL),
(9, 19, 'Домашние кошки', 'home-feline', 'Ко́шка, или дома́шняя ко́шка (лат. Félis silvéstris cátus) — домашнее животное, одно из наиболее популярных[1] (наряду с собакой) «животных-компаньонов»[2][3][4].\r\nС зоологической точки зрения, домашняя кошка — млекопитающее семейства кошачьих отряда хищных. Ранее домашнюю кошку нередко рассматривали как отдельный биологический вид. С точки зрения современной биологической систематики домашняя кошка (Felis silvestris catus) является подвидом лесной кошки (Felis silvestris)[5].\r\nЯвляясь одиночным охотником на грызунов и других мелких животных, кошка — социальное животное[6], использующее для общения широкий диапазон звуковых сигналов, а также феромоны и движения тела[7].\r\nВ настоящее время в мире насчитывается около 600 млн домашних кошек[8], выведено около 256 пород, от длинношёрстных (персидская кошка) до лишённых шерсти (сфинксы), признанных и зарегистрированных различными фелинологическими организациями.', 1, NULL),
(10, 13, 'Космос 1', 'space-1', 'Что-то про космос 1', 1, NULL),
(14, 1, 'root', '_face', '', 1, 'parent_face'),
(15, 2, 'Человек', 'human_face', 'Человек - это звучит по-всякому :)', 1, 'parent_face'),
(16, 3, 'Животные', 'animals_face', '', 1, 'parent_face'),
(17, 4, 'Растения', 'plants_face', '', 1, 'parent_face'),
(18, 5, 'Млекопитающие', 'mammals_face', '', 1, 'parent_face'),
(19, 6, 'Хищники', 'predator_face', '', 1, 'parent_face'),
(20, 8, 'Парнокопытные', 'artiodactyla_face', '', 1, 'parent_face'),
(21, 9, 'Непарнокопытные', 'perissodactyla_face', '', 1, 'parent_face'),
(22, 10, 'Грызуны', 'rodents_face', '', 1, 'parent_face'),
(23, 11, 'Жвачные', 'ruminants_face', '', 1, 'parent_face'),
(24, 12, 'Птицы', 'birds_face', '', 1, 'parent_face'),
(25, 13, 'Космос', 'space_face', '', 1, 'parent_face'),
(26, 15, 'Нежвачные', 'non-ruminant_face', '', 1, 'parent_face'),
(27, 18, 'Китообразные', 'cetacea_face', '', 1, 'parent_face'),
(28, 19, 'Кошкообразные', 'feliformia_face', '', 1, 'parent_face'),
(29, 27, 'Земноводные', 'amphibia_face', '', 1, 'parent_face'),
(30, 28, 'Пресмыкающиеся', 'reptiles_face', '', 1, 'parent_face'),
(31, 34, 'Микроорганизмы', 'micro-life_face', '', 1, 'parent_face'),
(32, 35, 'Строение вещества', 'matter_face', '', 1, 'parent_face'),
(33, 36, 'Мозоленогие', 'tylopoda_face', '', 1, 'parent_face'),
(34, 37, 'Псообразные', 'canines_face', '', 1, 'parent_face'),
(35, 38, 'Кристаллическая решетка', 'crystall_face', '', 1, 'parent_face'),
(36, 43, 'Молекулы', 'molekulas_face', '', 1, 'parent_face'),
(37, 44, 'Строение атома', 'atom-structure_face', '', 1, 'parent_face'),
(45, 45, 'Протон', 'proton', 'Заряженная частица с зарядом +1 и атомной массой = 1.', 1, NULL),
(46, 45, 'Нейтрон', 'neutron', 'Незаряженная частица с атомной массой = 1', 1, NULL),
(47, 45, 'Электрон', 'electron', 'Частица с зарядом -1 и атомной массой = 0,00055.', 1, NULL),
(48, 45, 'Ядро атома', 'atom-core_face', 'Ядро атома состоит из протонов и нейтронов.', 1, 'parent_face'),
(49, 50, 'История средних веков', 'middle-years-histoty_face', '', 1, 'parent_face'),
(50, 46, 'История', 'global-history_face', 'История человечества насчитывает неизвестное количество непроверяемых тысячелетий.', 1, 'parent_face');

-- --------------------------------------------------------

--
-- Структура таблицы `privileges`
--

CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `system` tinyint(1) NOT NULL,
  `content` tinyint(1) NOT NULL,
  `manage_content` tinyint(1) NOT NULL,
  `comments` tinyint(1) NOT NULL,
  `manage_comments` tinyint(1) NOT NULL,
  `manage_users` tinyint(1) NOT NULL,
  `taxonomy` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `taxonomy`
--

CREATE TABLE IF NOT EXISTS `taxonomy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(10) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `url_name` varchar(128) NOT NULL,
  `parent_id_chain` varchar(64) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_name` (`url_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Дамп данных таблицы `taxonomy`
--

INSERT INTO `taxonomy` (`id`, `parent`, `title`, `url_name`, `parent_id_chain`, `active`) VALUES
(1, 0, 'root', '', '0', 0),
(2, 1, 'Человек', 'human', '1', 1),
(3, 1, 'Животные', 'animals', '1', 1),
(4, 1, 'Растения', 'plants', '1', 1),
(5, 3, 'Млекопитающие', 'mammals', '1;3', 1),
(6, 5, 'Хищники', 'predator', '1;3;5', 1),
(8, 5, 'Парнокопытные', 'artiodactyla', '1;3;5', 0),
(9, 5, 'Непарнокопытные', 'perissodactyla', '1;3;5', 1),
(10, 5, 'Грызуны', 'rodents', '1;3;5', 1),
(11, 8, 'Жвачные', 'ruminants', '1;3;5;8', 0),
(12, 3, 'Птицы', 'birds', '1;3', 1),
(13, 1, 'Космос', 'space', '1', 1),
(15, 8, 'Нежвачные', 'non-ruminant', '1;3;5;8', 0),
(18, 5, 'Китообразные', 'cetacea', '1;3;5', 1),
(19, 6, 'Кошкообразные', 'feliformia', '1;3;5;6', 1),
(27, 3, 'Земноводные', 'amphibia', '1;3', 1),
(28, 3, 'Пресмыкающиеся', 'reptiles', '1;3', 1),
(34, 1, 'Микроорганизмы', 'micro-life', '1', 1),
(35, 1, 'Строение вещества', 'matter', '1', 1),
(36, 8, 'Мозоленогие', 'tylopoda', '1;3;5;8', 0),
(37, 6, 'Псообразные', 'canines', '1;3;5;6', 1),
(38, 35, 'Кристаллическая решетка', 'crystall', '1;35', 1),
(43, 35, 'Молекулы', 'molekulas', '1;35', 1),
(44, 35, 'Строение атома', 'atom-structure', '1;35', 1),
(45, 44, 'Ядро атома', 'atom-core', '1;35;44', 1),
(46, 2, 'История', 'global-history', '1;2', 1),
(48, 46, 'Древняя история', 'ancient-history', '1;2;46', 1),
(49, 46, 'Античная история', 'antic-history', '1;2;46', 1),
(50, 46, 'История средних веков', 'middle-years-histoty', '1;2;46', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `hash` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_manager` tinyint(1) NOT NULL DEFAULT '0',
  `is_moderator` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `hash`, `email`, `is_admin`, `is_manager`, `is_moderator`, `banned`) VALUES
(1, 'user1366375781bcc8', 'f0b583d32995142e', '1366375781_1399_a2406e549098e65d', '', 0, 0, 0, 0),
(2, 'user136637583960c9', 'f0b583d32995142e', '1366375839_1138_02729a932a003a11', '', 0, 0, 0, 0),
(3, 'user13663758638858', 'f0b583d32995142e', '1366375863_7718_2a281765c2a462dc', '', 0, 0, 0, 0),
(4, 'user13663759492c1a', 'f0b583d32995142e', '1366375949_666_f29c267799d640c3b', '', 0, 0, 0, 1),
(5, 'user1366376036b05e', 'f0b583d32995142e', '1366376036_6913_851aa923a5a49e35', '', 0, 0, 0, 0),
(6, 'user136637606535bb', 'f0b583d32995142e', '1366376065_3582_456d52d8fcd2c4d5', '', 0, 0, 0, 1),
(7, 'user136637608132cd', 'f0b583d32995142e', '1366376081_8444_7efc23317277d985', '', 0, 0, 0, 1),
(8, 'user136637612644b2', 'f0b583d32995142e', '1366376126_6634_ce308e6ec074695a', '', 0, 0, 0, 0),
(9, 'user13663762056902', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376205_7185_c17bf2ce8d5a7599f2361b741adb755d109c29133fe69a4485cf01f0e60b41bda5f2c7c5c8ac3dc61e73735288bf6f10337dd8c9b9a11d56', '', 0, 0, 0, 1),
(10, 'user13663762503b1b', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376250_9592_a2f02c29922816d3db2dc0ae9d41fec6b905a2efc31218e76b80ce9158a9463d128af3582efb94f9deaef7e846c3f59b61dba07dc882b656', '', 0, 0, 0, 0),
(11, 'user1366376296133f', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376296_4793_f77991e6ac74cdd968aaef33e850f8378681cb70de83bcbfdb1c87c6a0383b8e69b598eb7ebb377998c2c024cdf0bf1e9b106b2b9416544a', '', 0, 0, 0, 1),
(12, 'user136637635657b8', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376356_0512_0caa70e4ed90736a541799bd3a95cda2b13f05cc50088e77b5aef314d1cf777aada64f3a5ba942df841191fd3c9c88488a76e5d997f2420b', '', 0, 0, 0, 0),
(13, 'user1366376373c61c', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376373_6061_47ca1b8c3a86c5c603a9f32ab6c2b3fa6c2829910ea76ed09dc6d6f630e5922ec033adfc8fbf2fbf14b3542cb98f7d66631539736d2dedc1', '', 0, 0, 0, 1),
(14, 'user136637638953b8', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376389_6924_648cb2d0a3d74f766a76fde7eb0d7427088cd8233b3bfa7e09a20bf8d12c645f84eaf2089c9aaf4a7f47363049781bbd982ba79e2d4d8714', '', 0, 0, 0, 0),
(15, 'user1366376395b943', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376395_9579_212d84a64efc0b4b62ad4aa52fd74a7da86314fc08a20d0da7daa2bebc01d514e731668a89f7faf8ec5293dd635d224ed1ff36454a4e5f73', '', 0, 0, 0, 0),
(16, 'user136637639601a9', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376396_4635_34858eba6b02621615c0d5cf60947e2465949d0f108083ad522d63ec57a54bb408777376483d70064f9ed5187def2ca4d8d2f2b7a3215f60', '', 0, 0, 0, 0),
(17, 'user13663763979f06', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376397_0106_fc66fd3e21395e64dc192915dc9fdbcd4e8d4693619403fb4a620cf7169b4671ee132f6c98aa774b0aeb0d092a18a665752f311076139a7e', '', 0, 0, 0, 0),
(18, 'user136637670453cb', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376704_3076_0fa548a4c69be70851382c6703e104523ed952b44147b329289a3ad41f7303c73ae51cd816212842ec9d1251e9285a1e06d335aa272bcc16', 'user136637670453cb@mail.boo', 0, 0, 0, 0),
(19, 'user13663767095af3', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376709_794_a123d68ad7bef3e95c4e002fc83c8816d37aa6f3db00a24c4d102000e234587e1c7eb3d0c39dcfd5312aed54f0516939d9ff7de17dad3b334', 'user13663767095af3@mail.boo', 0, 0, 0, 0),
(20, 'user13663767336e50', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376733_6636_2f65c74d429b5d1cac399487cda5e0930e8e1294340b5016bf21e5368ac78905e775ae6b80df1fe5bdc5115d1945b3caf1feed84457366bd', 'user13663767336e50@mail.boo', 0, 0, 0, 0),
(21, 'user13663767648f99', 'f0b583d32995142e59b51918bec768a25738d37dd9dd6860c496743f6d341cd6', '1366376764_3461_1372e4eb54bff6fe22ed6b31fb108bc3992e3a9d4460d4001caa07a09c144de459f180df0a76b5a7122ef27b927c5069c732766831b98c72', 'user13663767648f99@mail.boo', 0, 0, 1, 0),
(22, 'test1', 'd95645ad19168b4d9526fcf3d4f5e4b0cee663bef3a969c6af52267928542a73', '1366630562_6362_da1cc839c6df7a67c27ef89ab9d3cb95402bb71f0f732116e8125c10cf46082b06eb3cb26314f51fb98f97374230fb6021bb2b2f7a7e88f6', '', 0, 0, 0, 0),
(23, 'admin', 'd95645ad19168b4d9526fcf3d4f5e4b0cee663bef3a969c6af52267928542a73', '1366654453_7275_b5aa809d16123ff526fc5ca588363aedd055f71849357dcd8aa5b56a006e7ee948da7201dab9beb5e72215a5278b4d97bfddd66d3f1757f9', 'admin@test.loc', 1, 1, 1, 0);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `option_values`
--
ALTER TABLE `option_values`
  ADD CONSTRAINT `option_values_ibfk_1` FOREIGN KEY (`option`) REFERENCES `options` (`id`);
