-- MySQL
DROP TABLE IF EXISTS `projects`;

CREATE TABLE IF NOT EXISTS `projects`
(
   head INTEGER COMMENT '����� ����� ������������� ���������, � �������� ��������� ���������',
   file_id INTEGER COMMENT '����� ����� ������������ � head'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
