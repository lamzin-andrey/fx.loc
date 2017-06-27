-- MySQL
DROP TABLE IF EXISTS `user_votes`;

CREATE TABLE IF NOT EXISTS `user_votes`
(
   uid INTEGER COMMENT 'Голосовавший Пользователь',
   decision_id INTEGER COMMENT 'Номер решения см. таблицу user_complete_tasks',
   sign TINYINT COMMENT 'Тип голоса'
  
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
ALTER TABLE user_votes ADD CONSTRAINT uniq_vote UNIQUE (uid, decision_id);

-- UPDATE `user_complete_tasks` set rating = 0;
-- TRUNCATE TABLE user_votes;

