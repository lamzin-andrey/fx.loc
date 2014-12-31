<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
require_once APP_ROOT . '/classes/TasklistHandler.php';
class ViewDecisionHandler extends CBaseHandler{
	public $comments_data = false;
	public $data = array();
	public $allow = false;
	public function __construct($app) {
		$this->left_inner = 'main_tasklist.tpl.php';
		$this->right_inner = 'vd_inner.tpl.php';
		$this->css[] = 'vd';
		//$this->css[] = 'qs';
		parent::__construct($app);
		if ($this->_access()) {
			$this->_loadDecisions();
		}
	}
	public function ajaxAction() {
		$act = req('action');
		switch ($act) {
			case 'vdrating':
				$this->_changeRating();
				break;
			case 'getTask':
				$this->_loadTask();
				break;
		}
		
	}
	private function _loadTask() {
		$lang = $this->_app->lang;
		$var = ireq('variant');
		$task = ireq('task');
		$popup = 0;
		if (ireq('byUid')) {
			$uid = CApplication::getUid();
			$sql_query = "SELECT current_task FROM users WHERE id = {$uid}";
			$data = explode(':', dbvalue($sql_query) );
			if (count($data) == 2) {
				$var = $data[0];
				$task = $data[1];
				$popup = 1;
			} else {
				json_error('has_no', 1, 'popup', 1);
			}
		}
		$path = APP_ROOT . '/files/tasklist/' . $var . '.php';
		if ($var && $task && file_exists($path)) {
			ob_start();
				include $path;
			$s = ob_get_contents();
			ob_clean();
			if (!$popup) {
				json_ok('html', $s, 'task' , $task, 'var', $var);
			} else {
				json_ok('html', $s, 'task' , $task, 'var', $var, 'popup', 1);
			}
		}
		json_error('msg', $lang['default_error']);
	}
	private function _changeRating() {
		$lang = $this->_app->lang;
		$a_id = explode(':', strval(req('id')));
		$sign = ireq('sign');
		if ($sign && count($a_id) == 3) {
			$author_id = $a_id[0];
			$var = $a_id[1];
			$task = $a_id[2];
			$uid = CApplication::getUid();
			if ($uid == $author_id) {
				json_error('msg', $lang['error_self_vote']);
			}
			$row = dbrow("SELECT id, rating FROM user_complete_tasks WHERE uid = {$author_id} AND var = {$var} AND task = {$task}");
			$dec_id = a($row, 'id');
			$rating = a($row, 'rating');
			if ($dec_id) {
				$sql_query = "SELECT sign FROM user_votes WHERE decision_id = {$dec_id} AND uid = {$uid}";
				$old_vote_sign = dbvalue($sql_query);
				if ($old_vote_sign === false) {
					query("INSERT INTO user_votes VALUES ({$uid}, {$dec_id}, {$sign})");
					if ($sign > 0) {
						query("UPDATE user_complete_tasks SET rating = rating + 1 WHERE id = {$dec_id}");
						$rating++;
					} else {
						query("UPDATE user_complete_tasks SET rating = rating - 1 WHERE id = {$dec_id}");
						$rating--;
					}
				} else {
					if ($old_vote_sign != $sign) {
						if ($sign > 0) {
							query("UPDATE user_complete_tasks SET rating = rating + 2 WHERE id = {$dec_id}");
							$rating += 2;
						} else {
							query("UPDATE user_complete_tasks SET rating = rating - 2 WHERE id = {$dec_id}");
							$rating -= 2;
						}
						$v_sign = ($sign > 0 ? 1 : -1);
						query("UPDATE user_votes SET sign = {$v_sign} WHERE decision_id = {$dec_id} AND uid = {$uid}");
					} else {
						$s_sign = ($sign > 0 ? $lang['vt_positive'] : $lang['vt_negative']);
						json_error('msg', $lang['You_already_left_'] . ' '. $s_sign . ' ' . $lang['vote']);
					}
				}
				json_ok('id', req('id'), 'v', $rating);
			} else {
				json_error('msg', $lang['default_error']);
			}
		} else {
			json_error('msg', $lang['default_error']);
		}
	}
	private function _access() {
		$aUrl = explode('/', $_SERVER['REQUEST_URI']);
		$var = (int)a($aUrl, 2);
		$task = (int)a($aUrl, 3);
		$uid = CApplication::getUid();
		if ($uid && $var && $task) {
			$sql_query = "SELECT uid FROM user_complete_tasks WHERE uid = {$uid} AND var = {$var} AND task = {$task}";
			$exists = dbvalue($sql_query);
			if (!$exists) {
				return false;
			}
			$this->allow = true;
			return true;
		} else {
			return false;
		}
		return false;
	}
	private function _loadDecisions() {
		$aUrl = explode('/', $_SERVER['REQUEST_URI']);
		$var = (int)a($aUrl, 2);
		$task = (int)a($aUrl, 3);
		if ($var && $task) {
			$uid = CApplication::getUid();
			/*$data = query("SELECT uct.uid, uct.var, uct.task, uct.files, 
							GROUP_CONCAT(s.file_content) AS code,
							u.name, u.surname
							FROM user_complete_tasks AS uct
								LEFT JOIN js_scripts AS s 	ON s.id IN SPLIT(',', uct.files)
								LEFT JOIN users AS u ON u.id = uct.uid
							WHERE uct.var = {$var} AND uct.task = {$task}
							GROUP BY (uct.uid)"
					);*/
			$raw_data = query("SELECT uct.uid, uct.var, uct.task, uct.files, uct.rating,
							u.name, u.surname
							FROM user_complete_tasks AS uct
								LEFT JOIN users AS u ON u.id = uct.uid
							WHERE uct.var = {$var} AND uct.task = {$task}
							 ORDER BY rating DESC
							"
					);
			$a_file_ids = array();
			$data = array();
			foreach ($raw_data as $row) {
				$this->_insertUnique($a_file_ids, $row['files']);
				$data[ $row['uid'] ] = $row;
			}
			$file_ids = join(',', $a_file_ids);
			$code_data = query("SELECT display_file_name, file_content, user_id FROM js_scripts WHERE id IN ({$file_ids})");
			foreach ($code_data as $row) {
				if ( !isset($data[ $row['user_id'] ]['code']) ) {
					$data[ $row['user_id'] ]['code'] = array();
				}
				$data[ $row['user_id'] ]['code'][] = array('text' => $row['file_content'], 'title' => $row['display_file_name']);
			}
			$this->data = $data;
			/*echo '<pre>';
			print_r($data);
			die('</pre>' . __FILE__ . ', ' . __LINE__);/**/
		}
	}
	
	private function _insertUnique(&$arr, $sep_str){
		$buf = explode(',', $sep_str);
		foreach ($buf as $n) {
			if ( array_search($n, $arr) === false ) {
				$arr[] = $n;
			}
		}
	}
}
