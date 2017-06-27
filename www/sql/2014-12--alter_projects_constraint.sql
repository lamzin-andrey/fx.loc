ALTER TABLE projects ADD CONSTRAINT uniq_control UNIQUE (head, file_id);
