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
	public $base_url;
	public function __construct() {
		@session_start();
		$this->lang = utils_getCurrentLang();
		$this->_loadAuthUserData();
		$this->_ajaxHandler();
		//TODO роутер
		$aUrl = explode('?', $_SERVER['REQUEST_URI']);
		$this->base_url = $url = trim($aUrl[0], '/');
		$work_fiolder = 'programming_fundamentals';
		switch ($url) {
			case $work_fiolder . '/console':
				$this->_consolePageActions();
				break;
			case $work_fiolder . '/quick_start':
				$this->_quickStartActions();
				break;
			case $work_fiolder . '/tasklist':
				$this->_tasklistActions();
				break;
			case $work_fiolder . '/editor':
			case $work_fiolder . '/text_editor':
				$this->_editorActions();
				break;
			case $work_fiolder:
				$this->_promoPageActions();
				break;
			case $work_fiolder . '/login':
				$this->_loginActions();
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
	 * @desc Обработка возможных действий на главной странице
	**/
	private function _quickStartActions() {
		$this->handler = $h = $this->_load('QuickStartHandler');
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
	 * @desc Обработка возможных действий на странице
	**/
	private function _load($class_name) {
		$file = APP_ROOT . '/classes/' . $class_name . '.php';
		if (file_exists($file)) {
			include_once($file);
			return new $class_name();
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
			$data = dbrow("SELECT id, email, name, surname FROM users WHERE id = '{$uid}'", $nR);
			//$guid = 0;
			if ($nR) {
				$this->user_email = $data['email'];
				$this->user_name = $data['name'];
				$this->user_surname = $data['surname'];
			}
		}
	}
}
