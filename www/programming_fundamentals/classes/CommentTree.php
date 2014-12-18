<?php
require_once APP_ROOT . '/classes/CAbstractDbTree.php';
class CommentTree extends CAbstractDbTree{
	public function __construct($app) {
		$this->table('comments');
		//устанавливаю "неожиданные" ассоциации полей запроса и полей таблицы БД
		//ключ значения массива - имя поля в таблице,  значение - ключ в request
		$this->assoc(
			array(
				'parent_id' => 'parent',
				'part' => 'skey'
			)
		);
		//устанавливаю имена полей таблицы БД которые надо вставить
		//db fields
		$this->insert(
			array('part', 'uid', 'parent_id', 'title', 'body', 'date_modify', 'date_create')
		);
		//устанавливаю имена полей таблицы БД которые надо обновить
		//db fields
		$this->update(
			array('title', 'body', 'date_modify')
		);
		//устанавливаю имена полей в которые надо записать текущее время
		$this->timestamps(
			array('date_modify', 'date_create')
		);
		//Устанавливаю необходимые для заполнения поля
		$this->required('title', $app->lang['Error_title_required']);
		$this->required('body', $app->lang['Error_body_required']);
		//Проверяю, владелиц ли пользователь редактируемого комментария
		$auth_user_uid = sess('uid');
		$field_owner_id = 'uid';
		$this->setUpdateOwnerCondition($auth_user_uid, $field_owner_id);
		parent::__construct($app);
	}
	protected function validate() {
		$lang = utils_getCurrentLang();
		if (!$this->_app->user_email) {
			json_error('msg', $lang['Error_Member_only']);
		}
		parent::validate();
	}
	
	protected function req($name) {
		$v = parent::req($name);
		if ($name == 'skey') {
			if (!$v) {
				json_error('msg', $lang['default_error']);
			}
			$v = 'quick_start/' . $v;
		}
		return $v;
	}
}
