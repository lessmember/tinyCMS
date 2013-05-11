-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `options`
--

INSERT INTO `options` (`id`, `name`, `value`, `type`) VALUES
(1, 'theme', 'default', 'string'),
(2, 'default.page', '1', 'string');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_name` (`url_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Дамп данных таблицы `taxonomy`
--

INSERT INTO `taxonomy` (`id`, `parent`, `title`, `url_name`, `parent_id_chain`, `active`) VALUES
(1, 0, 'root', '', '0', 1);

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
(1, 'admin', 'd95645ad19168b4d9526fcf3d4f5e4b0cee663bef3a969c6af52267928542a73', '', 'admin@email', 1, 1, 1, 1);
