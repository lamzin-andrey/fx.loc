-- MySQL
DROP TABLE IF EXISTS `datas`;

CREATE TABLE IF NOT EXISTS `datas`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT 'Первичный ключ.',
   url VARCHAR(1028) COMMENT 'Локальный url юзера',
   catalog_id INTEGER COMMENT 'Номер catalog',
   
   datas TEXT COMMENT 'Data',
   log TEXT COMMENT 'Error log',
   date_modify DATETIME COMMENT 'Время изменения',
   is_deleted INTEGER DEFAULT 0 COMMENT 'Удален или нет.',
   date_create DATETIME COMMENT 'время создания'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
