-- MySQL
DROP TABLE IF EXISTS `resources`;

CREATE TABLE IF NOT EXISTS `resources`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT 'Первичный ключ.',
   src_file_name VARCHAR(128) COMMENT 'Исходное имя файла',
   display_file_name    VARCHAR(128) COMMENT 'Отображаемое имя файла',
   file_path VARCHAR(1024) COMMENT 'Путь к файлу относительно корня приложения',
   user_id INTEGER COMMENT 'Пользователь, загрузивший файл',
   is_image INTEGER DEFAULT 0 COMMENT 'Изображение ли',
   date_create DATETIME COMMENT 'время создания',
   date_update DATETIME COMMENT 'время создания',
   is_deleted INTEGER DEFAULT 0 COMMENT 'Удален или нет',
   delta INTEGER COMMENT 'Позиция'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
