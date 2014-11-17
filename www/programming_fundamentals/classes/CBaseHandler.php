<?
class CBaseHandler {
	/** сообщения об ошибках*/
	public $errors = array();
	/** информационные сообщения*/
	public $messages = array();
	/** array массив локализации*/
	public $lang = array();
	/** string шаблон для вывода левой части*/
	public $left_inner;
	/** array специфичные файлы стилей, указывать только имена*/
	public $css;
	/** array специфичные файлы javascript, указывать путь от папки приложения js, например $this->js[] = 'folder/script.js'*/
	public $js;
	
	public function __construct() {
		$this->lang = utils_getCurrentLang();
	}
}
