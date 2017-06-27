-- MySQL
ALTER TABLE users ADD COLUMN recovery_hash VARCHAR(32) COMMENT 'Хэш md5 для восстановления пароля';
ALTER TABLE users ADD COLUMN recovery_hash_created DATETIME COMMENT 'Время которое хеш действителен';
