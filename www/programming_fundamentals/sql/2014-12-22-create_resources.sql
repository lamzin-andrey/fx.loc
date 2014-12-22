-- MySQL
DROP TABLE IF EXISTS `resources`;

CREATE TABLE IF NOT EXISTS `resources`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '��������� ����.',
   src_file_name VARCHAR(128) COMMENT '�������� ��� �����',
   display_file_name    VARCHAR(128) COMMENT '������������ ��� �����',
   file_path VARCHAR(1024) COMMENT '���� � ����� ������������ ����� ����������',
   user_id INTEGER COMMENT '������������, ����������� ����',
   is_image INTEGER DEFAULT 0 COMMENT '����������� ��',
   date_create DATETIME COMMENT '����� ��������',
   date_update DATETIME COMMENT '����� ��������',
   is_deleted INTEGER DEFAULT 0 COMMENT '������ ��� ���',
   delta INTEGER COMMENT '�������'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
