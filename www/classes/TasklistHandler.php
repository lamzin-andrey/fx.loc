<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class TasklistHandler extends CBaseHandler{
	public $book_tpl = '1';
	public function __construct() {
		$this->left_inner = 'ts_tasklist.tpl.php';
		$this->right_inner = 'ts_inner.tpl.php';
		$this->css[] = 'ts';
		
		$aUrl = explode('?', $_SERVER['REQUEST_URI']);
		$url = $aUrl[0];
		$a = explode('/tasklist', $url);
		
		if (count($a) > 1) {
			$s = str_replace('/', '', $a[1]);
			if (file_exists(APP_ROOT . '/files/tasklist/' . $s . '.php')) {
				$this->book_tpl = $s;
			} else if ($a[1] == '/' || !$a[1]) {
				$this->book_tpl = '1';
			} else {
				$this->action404();
			}
		}
		parent::__construct();
	}
	/**
	 * @desc
	***/
	static public function v($n) {
		$lang = utils_getCurrentLang();
		return '<li><a href="'. WEB_ROOT. '/tasklist/'. $n .'">'. $lang['variant'] . ' ' . $n . '</a></li>';
	}
	static public function tim($variant, $task, $subtask) {
		return '<img src="'.WEB_ROOT.'/files/tasks/'.$variant.'/'.$task.'.'.$subtask.'.png" />';
	}
}
