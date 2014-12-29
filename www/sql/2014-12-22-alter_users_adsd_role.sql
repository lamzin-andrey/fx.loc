-- MySQL
ALTER TABLE users ADD COLUMN role INTEGER DEFAULT 0 COMMENT 'Роль пользователя 0 - пользователь 1 - модератор - 2 - админ';
