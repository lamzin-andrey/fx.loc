<?
class CBaseHandler {
	/** сообщения об ошибках*/
	public $errors = array();
	/** информационные сообщения*/
	public $messages = array();
	/** массив локализации*/
	public $lang = array();
	/** шаблон для вывода левой части*/
	public $left_inner;
	/** специфичные файлы стилей, указывать только имена*/
	public $css;
	
	public function __construct() {
		$this->lang = utils_getCurrentLang();
	}
}
