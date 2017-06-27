-- MySQL
ALTER TABLE js_scripts ADD COLUMN is_no_complete_task TINYINT DEFAULT 0 COMMENT '1 когда файл помечен как содержащий решение задачи';
