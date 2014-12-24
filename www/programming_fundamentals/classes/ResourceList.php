<?php
require_once APP_ROOT . '/classes/CAbstractDbTree.php';
class ResourceList extends CAbstractDbTree{
	public function __construct($app) {
		$this->table('resources');
		//устанавливаю "неожиданные" ассоциации полей запроса и полей таблицы БД
		//ключ значения массива - имя поля в таблице,  значение - ключ в request
		/*$this->assoc(
			array(
				'parent_id' => 'parent',
				'part' => 'skey'
			)
		);*/
		//устанавливаю имена полей таблицы БД которые надо вставить
		//db fields
		$this->insert(
			array('src_file_name', 'display_file_name', 'file_path', 'user_id', 'date_create', 'date_update', 'is_image')
		);
		//устанавливаю имена полей таблицы БД которые надо обновить
		//db fields
		$this->update(
			array('src_file_name', 'display_file_name', 'file_path', 'user_id', 'date_create', 'date_update', 'is_image')
		);
		//устанавливаю имена полей в которые надо записать текущее время
		$this->timestamps(
			array('date_update', 'date_create')
		);
		//Устанавливаю необходимые для заполнения поля
		$this->required('display_file_name', $app->lang['Error_title_required']);
		//Проверяю, владелиц ли пользователь редактируемого комментария
		$auth_user_uid = sess('uid');
		$field_owner_id = 'user_id';
		$this->setUpdateOwnerCondition($auth_user_uid, $field_owner_id);
		$this->_per_page = 12;
		parent::__construct($app);
	}
	protected function validate() {
		$lang = utils_getCurrentLang();
		if (!$this->_app->user_email) {
			json_error('msg', $lang['Error_Member_only']);
		}
		/*if (isset($this->_app->comm_captcha)) {
			$enter = req('commfstr');
			if ($enter != sess('capcode')) {
				json_error('msg', $lang['code_is_not_valid']);
			}
		}*/
		parent::validate();
	}
	
	/*protected function req($name) {
		$v = parent::req($name);
		if ($name == 'skey') {
			if (!$v) {
				json_error('msg', $this->_app->lang['default_error']);
			}
			$v = 'quick_start/' . $v;
		}
		$s = str_replace('[/code]', '</pre>', $v);
		$s = str_replace("[code]\n", '<pre>', $s);
		$v = str_replace('[code]', '<pre>', $s);
		return $v;
	}*/
	/**
	 * @desc Получить поля для апдейта
	 * @param  $id Идентификатор записи
	 * @param  string $additional_fields перечисление сеоез запятую дополнительных плоей
	 * @return $row | false row Содержит выборку полей заданных для update и поле на которое назначен первичный ключ
	**/
	/*public function getRecord($id, $additional_fields = false) {
		$row = parent::getRecord($id, $additional_fields);
		$row['body'] = str_replace('<pre>', "[code]\n", $row['body']);
		$row['body'] = str_replace('</pre>', '[/code]', $row['body']);
		return $row;
	}*/
}
