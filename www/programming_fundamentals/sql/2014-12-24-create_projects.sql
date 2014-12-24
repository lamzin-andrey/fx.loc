-- MySQL
DROP TABLE IF EXISTS `projects`;

CREATE TABLE IF NOT EXISTS `projects`
(
   head INTEGER COMMENT 'Номер файла определяющего множество, к которому относятся остальные',
   file_id INTEGER COMMENT 'Номер файла относящегося к head'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
