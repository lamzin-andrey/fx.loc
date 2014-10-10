-- MySQL
DROP TABLE IF EXISTS `js_scripts`;

CREATE TABLE IF NOT EXISTS `js_scripts`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT 'Первичный ключ.',
   src_file_name VARCHAR(32) COMMENT 'исходное имя файла',
   display_file_name VARCHAR(128) COMMENT 'отображаемое имя файла',
   file_content TEXT COMMENT 'отображаемое имя файла',
   user_id INTEGER COMMENT 'id пользователя - владельца файла',
   date_create DATETIME COMMENT 'время создания',
   date_update DATETIME COMMENT 'время обновления',
   is_deleted INTEGER DEFAULT 0 COMMENT 'Удален или нет. Может называться по другому, но тогда в cdbfrselectmodel надо указать, как именно',
   delta INTEGER COMMENT 'Позиция.  Может называться по другому, но тогда в cdbfrselectmodel надо указать, как именно'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;


