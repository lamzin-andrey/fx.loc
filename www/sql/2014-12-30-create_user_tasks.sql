-- MySQL
DROP TABLE IF EXISTS `user_complete_tasks`;

CREATE TABLE IF NOT EXISTS `user_complete_tasks`
(
   uid INTEGER COMMENT 'Пользователь',
   var INTEGER COMMENT 'Вариант',
   task INTEGER COMMENT 'Номер задания',
   files VARCHAR(128) COMMENT 'Файлы пользователя содержащие решения формат: номера через запятую'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
