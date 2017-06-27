ALTER TABLE user_complete_tasks ADD CONSTRAINT uniq_task UNIQUE (uid, var, task);
