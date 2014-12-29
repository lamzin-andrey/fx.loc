-- MySQL
DROP TABLE IF EXISTS `js_scripts`;

CREATE TABLE IF NOT EXISTS `js_scripts`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '��������� ����.',
   src_file_name VARCHAR(32) COMMENT '�������� ��� �����',
   display_file_name VARCHAR(128) COMMENT '������������ ��� �����',
   file_content TEXT COMMENT '������������ ��� �����',
   user_id INTEGER COMMENT 'id ������������ - ��������� �����',
   date_create DATETIME COMMENT '����� ��������',
   date_update DATETIME COMMENT '����� ����������',
   is_deleted INTEGER DEFAULT 0 COMMENT '������ ��� ���. ����� ���������� �� �������, �� ����� � cdbfrselectmodel ���� �������, ��� ������',
   delta INTEGER COMMENT '�������.  ����� ���������� �� �������, �� ����� � cdbfrselectmodel ���� �������, ��� ������'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;


