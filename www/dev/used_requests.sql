

INSERT INTO `pages` (`parent`, `title`, `url_name`, `content`, `active`, `role`)
SELECT `id`, `title`, CONCAT(url_name, '_face'), '', TRUE, 'parent_face'  FROM taxonomy;

