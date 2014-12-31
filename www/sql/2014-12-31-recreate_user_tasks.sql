-- MySQL
DROP TABLE IF EXISTS `user_complete_tasks`;

CREATE TABLE IF NOT EXISTS `user_complete_tasks`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT 'Первичный ключ.',
   uid INTEGER COMMENT 'Пользователь',
   var INTEGER COMMENT 'Вариант',
   task INTEGER COMMENT 'Номер задания',
   files VARCHAR(128) COMMENT 'Файлы пользователя содержащие решения формат: номера через запятую'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
ALTER TABLE user_complete_tasks ADD CONSTRAINT uniq_task UNIQUE (uid, var, task);
ALTER TABLE user_complete_tasks ADD COLUMN rating INTEGER DEFAULT 0;
