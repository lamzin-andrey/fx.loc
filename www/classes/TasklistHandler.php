<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class TasklistHandler extends CBaseHandler{
	public $book_tpl = '1';
	public function __construct($app) {
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
		parent::__construct($app);
	}
	/**
	 * @desc
	*/
	public function ajaxAction() {
		$act = req('action');
		$lang = $this->_app->lang;
		$uid = CApplication::getUid();
		switch ($act) {
			case 'getUserTasks':
				$current_task = dbvalue("SELECT current_task FROM users WHERE id = {$uid}");
				$a_current_task = explode(':', $current_task);
				$current_task = (int)a($a_current_task, 1) ? (int)a($a_current_task, 1) : -1;
				$var = (int)req('variant');
				if ((int)$a_current_task[0] != $var) {
					$current_task = -1;
				}
				$list = array();
				if ($var) {
					$list = query("SELECT task FROM user_complete_tasks WHERE uid = {$uid} AND var = {$var}");
				}
				json_ok('current', $current_task, 'done_list', $list);
				break;
			case 'saveSelectedFiles':
				$files = ilistFromString('data');
				$var = ireq('variant');
				$task = ireq('task');
				if ($uid && $var && $files) {
					//TODO insert
					$files = join(',', $files);
					query("INSERT INTO user_complete_tasks (uid, var, files, task) VALUES ('{$uid}', '{$var}', '{$files}', '{$task}') 
							ON DUPLICATE KEY UPDATE uid = {$uid}");
					query("UPDATE js_scripts SET is_no_complete_task = 1 WHERE id IN({$files})");
					json_ok();
				}
				json_error($lang['default_error']);
				break;
			case 'setAsCurrent':
				$var = ireq('variant');
				$task = ireq('task');
				if ($var && $task) {
					query("UPDATE users SET current_task = '{$var}:{$task}' WHERE id = {$uid}");
					json_ok('id', $task);
				}
				json_error('msg', $lang['default_error']);
				break;
		}
	}
	/**
	 * @desc
	*/
	static public function v($n) {
		$lang = utils_getCurrentLang();
		return '<li><a href="'. WEB_ROOT. '/tasklist/'. $n .'">'. $lang['variant'] . ' ' . $n . '</a></li>';
	}
	static public function tim($variant, $task, $subtask) {
		return '<img src="'.WEB_ROOT.'/files/tasks/'.$variant.'/'.$task.'.'.$subtask.'.png" />';
	}
}
