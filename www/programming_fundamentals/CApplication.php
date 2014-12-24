<?php
require_once dirname(__FILE__) . '/classes/utils.php';
require_once dirname(__FILE__) . '/classes/mysql.php';
require_once dirname(__FILE__) . '/classes/CViewHelper.php';
class CApplication {
	public $handler = null;
	public $lang = array();
	public $user_email;
	public $user_name;
	public $user_surname;
	public $role = 0;
	public $base_url;
	public $layout = 'master.tpl.php';
	//public $reg_captcha = true;
	//public $comm_captcha = true;
	
	public function __construct() {
		@session_start();
		$this->lang = utils_getCurrentLang();
		$this->_loadAuthUserData();
		$this->_ajaxHandler();
		//TODO роутер
		$aUrl = explode('?', $_SERVER['REQUEST_URI']);
		$this->base_url = $url = trim($aUrl[0], '/');
		$work_folder = WORK_FOLDER;
		switch ($url) {
			case $work_folder . '/console':
				$this->_consolePageActions();
				break;
			case $work_folder . '/quick_start':
				$this->_quickStartActions();
				break;
			case $work_folder . '/tasklist':
				$this->_tasklistActions();
				break;
			case $work_folder . '/editor':
			case $work_folder . '/text_editor':
				$this->_editorActions();
				break;
			case $work_folder:
				$this->_promoPageActions();
				break;
			case $work_folder . '/login':
				$this->_loginActions();
				break;
			case $work_folder . '/newcomments':
				$this->_editCommentsActions();
				break;
			case $work_folder . '/resources':
				$this->_resourcesActions();
				break;
			default:
				if (strpos($url, 'programming_fundamentals/quick_start/') !== false) {
					$this->_quickStartActions();
				}
				if (strpos($url, 'programming_fundamentals/tasklist/') !== false) {
					$this->_tasklistActions();
				}
		}
	}
	/**
	 * @desc Обработка возможных действий на главной странице
	**/
	private function _editorActions() {
		$this->handler = $h = $this->_load('EditorHandler');
		$this->layout = 'tpl/editor.master.tpl.php';
		if (is_ajax()) {
			$h->ajaxAction();
		}
	}
	/**
	 * @desc Обработка возможных действий при регистрации и авторизации
	**/
	private function _loginActions() {
		$this->handler = $h = $this->_load('LoginHandler');
	}
	/**
	 * @desc Обработка возможных действий на странице списка задач
	**/
	private function _tasklistActions() {
		$this->handler = $h = $this->_load('TasklistHandler');
	}
	/**
	 * @desc Обработка возможных действий на странице быстрый чтарт
	**/
	private function _quickStartActions() {
		$this->handler = $h = $this->_load('QuickStartHandler');
		if (is_ajax()) {
			$h->ajaxAction();
		}
	}
	/**
	 * @desc Обработка возможных действий на странице модерирования комментариев
	**/
	private function _editCommentsActions() {
		$this->handler = $h = $this->_load('AcceptCommentHandler', 1);
		if (is_ajax()) {
			$h->ajaxAction();
		}
	}
	/**
	 * @desc Обработка возможных действий на главной странице
	**/
	private function _promoPageActions() {
		$this->handler = $h = $this->_load('MainPageHandler');
	}
	/**
	 * @desc Обработка возможных действий на странице консоли
	**/
	private function _consolePageActions() {
		$this->handler = $h = $this->_load('ConsoleHandler');
		if (count($_FILES)) {
			$h->processUploadFile();
			$messages = sess('messages', null, array());
			$messages[] = array(__FUNCTION__ . '_messages' => $h->messages);
			$messages[] = array(__FUNCTION__ . '_errors' => $h->errors);
			sess('messages', $messages);
			utils_302($_SERVER['REQUEST_URI']);
		} else {
			$h->loadUsersScripts();
		}
	}
	/**
	 * @desc Обработка возможных действий на странице загрузки ресурсов
	**/
	private function _resourcesActions() {
		if (!sess('uid')) {
			utils_302(WEB_ROOT);
		}
		$this->layout = 'tpl/resources.master.tpl.php';
		$this->handler = $h = $this->_load('ResourceHandler');
		if (count($_FILES) && $_FILES['resFile']['size'] != 0) {
			$h->processUploadFile();
			$messages = sess('messages', null, array());
			$messages[] = array(__FUNCTION__ . '_messages' => $h->messages);
			$messages[] = array(__FUNCTION__ . '_errors' => $h->errors);
			sess('messages', $messages);
			utils_302($_SERVER['REQUEST_URI']);
		} else {
			if (count($_POST)) {
				$h->updateFileInfo();
				if (req('action') == 'delete') {
					json_ok('msg', $h->delete_action_msg);
				}
			}
			$h->loadUserResources();
		}
	}
	/**
	 * @desc Обработка возможных действий на странице
	 * @param $class_name - Имя класса, который надо подгрузить
	 * @param $access_level = 0 - минимально необходимые права
	**/
	private function _load($class_name, $level = 0) {
		if ($this->role < $level) {
			utils_302(WEB_ROOT);
			return;
		}
		$file = APP_ROOT . '/classes/' . $class_name . '.php';
		if (file_exists($file)) {
			include_once($file);
			return new $class_name($this);
		} else {
			throw new Exception('Класс '  . $class_name . ' не найден там, где он ожидался');
		}
	}
	/**
	 * @desc Загрузка скриптов пользователя, если такие есть
	**/
	private function _loadUsersScripts() {
	}
	/**
	 * @desc Обработка аякс запросов
	**/
	private function _ajaxHandler() {
		$action = $this->_req('action', 'POST');
		$lang = $this->lang;
		switch ($action) {
			case 'getGuid':
				$this->_generateGuid();
				break;
			case 'removeTask':
				$id = (int)req('id');
				if ($id) {
					query("UPDATE js_scripts SET is_deleted = 1 WHERE id = {$id}");
					json_ok();
				} else {
					json_error($lang['fail_delete_user_script_try_update']);
				}
				break;
		}
	}
	/**
	 * @desc Создать уникальный идентификатор анонимного пользователя
	**/
	private function _generateGuid() {
		$datetime = now();
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = "INSERT INTO users (guest_id) VALUES (MD5('{$ip}{$datetime}'))";
		$uid = query($query);
		$query = "SELECT guest_id FROM users WHERE id = {$uid}";
		$guid = dbvalue($query);
		json_ok('guid', $guid);
	}
	/**
	 * @desc альтернатива @
	 * @param v - имя переменной
	 * @param varname - имя переменной
	**/
	private function _req($v, $varname = 'REQUEST') {
		$data = $_REQUEST;
		switch ($varname) {
			case 'POST':
			$data = $_POST;
				break;
			case 'GET':
				$data = $_GET;
				break;
		}
		if (isset($data[$v])) {
			return $data[$v];
		}
		return null;
	}
	/**
	 * 
	*/
	static public function getUid() {
		if ((int)sess('uid')) {
			return (int)sess('uid');
		}
		if ((int)sess('guid')) {
			return (int)sess('guid');
		}
		if (trim(a($_COOKIE, 'guest_id'))) {
			$guid = trim(a($_COOKIE, 'guest_id'));
			$guid = dbvalue("SELECT id FROM users WHERE guest_id = '{$guid}'");
			if ($guid) {
				sess('guid', $guid);
			}
			return $guid;
		}
		return 0;
	}
	/**
	 * @desc Получить мыло имя и фамилию неанонимного пользователя
	*/
	private function _loadAuthUserData() {
		if ($uid = (int)sess('uid')) {
			$data = dbrow("SELECT id, email, name, surname, role FROM users WHERE id = '{$uid}'", $nR);
			//$guid = 0;
			if ($nR) {
				$this->user_email = $data['email'];
				$this->user_name = $data['name'];
				$this->user_surname = $data['surname'];
				$this->role = $data['role'];
			}
		}
	}
}
