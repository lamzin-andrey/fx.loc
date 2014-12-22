-- MySQL
ALTER TABLE  `comments` ADD COLUMN is_accept INTEGER DEFAULT 0 COMMENT 'Комментарий прошел модерацию';

CREATE TABLE IF NOT EXISTS `comments`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT 'Первичный ключ.',
   part VARCHAR(128) COMMENT 'Часть url определяющая тип, например quick_start/branching',
   uid INTEGER COMMENT 'Номер автора',
   parent_id INTEGER COMMENT 'Номер родительского комментария' DEFAULT 0,
   title VARCHAR(128) COMMENT 'Заголовок',
   body TEXT COMMENT 'Текст комментария',
   date_modify DATETIME COMMENT 'Время изменения',
   is_deleted INTEGER DEFAULT 0 COMMENT 'Удален или нет.',
   date_create DATETIME COMMENT 'время создания'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
