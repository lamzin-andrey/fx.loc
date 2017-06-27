-- MySQL
ALTER TABLE js_scripts ADD COLUMN file_ctrl_sum VARCHAR(32) COMMENT 'Контрольная сумма файла';
ALTER TABLE js_scripts ADD COLUMN project_ctrl_sum VARCHAR(32) COMMENT 'Контрольная сумма контрольных сумм файлов, для которых этот head';
