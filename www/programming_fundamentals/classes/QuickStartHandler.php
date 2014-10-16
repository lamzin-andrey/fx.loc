<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class QuickStartHandler extends CBaseHandler{
	public $book_tpl = 'intro';
	public function __construct() {
		$this->left_inner = 'qs_tasklist.tpl.php';
		$this->right_inner = 'qs_inner.tpl.php';
		$this->css[] = 'qs';
		
		$aUrl = explode('?', $_SERVER['REQUEST_URI']);
		$url = $aUrl[0];
		$a = explode('programming_fundamentals/quick_start', $url);
		if (count($a) > 1) {
			$s = str_replace('/', '', $a[1]);
			if (file_exists(APP_ROOT . '/files/quick_book/' . $s . '.php')) {
				$this->book_tpl = $s;
			}
		}
		parent::__construct();
	}
	static public function part($key) {
		$lang = utils_getCurrentLang();
		return '<li><a class="" href="'. WEB_ROOT. '/quick_start/'. $key .'/">'. $lang[$key] . '</a></li>';
	}
	static public function tim($variant, $task, $subtask) {
		return '<img src="'.WEB_ROOT.'/files/tasks/'.$variant.'/'.$task.'.'.$subtask.'.png" />';
	}
}
