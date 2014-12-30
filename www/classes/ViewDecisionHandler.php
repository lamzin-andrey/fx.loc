<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class ViewDecisionHandler extends CBaseHandler{
	public $book_tpl = '1';
	public function __construct($app) {
		$this->left_inner = 'main_tasklist.tpl.php';
		$this->right_inner = 'vd_inner.tpl.php';
		$this->css[] = 'vd';
		parent::__construct($app);
		
		$this->_loadDecisions();
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
			$raw_data = query("SELECT uct.uid, uct.var, uct.task, uct.files,
							u.name, u.surname
							FROM user_complete_tasks AS uct
								LEFT JOIN users AS u ON u.id = uct.uid
							WHERE uct.var = {$var} AND uct.task = {$task}
							-- ORDER BY rating
							"
					);
			$a_file_ids = array();
			$data = array();
			foreach ($raw_data as $row) {
				$this->_insertUnique($a_file_ids, $row['files']);
				$data[ $row['uid'] ] = $row;
			}
			$file_ids = join(',', $a_file_ids);
			$code_data = query("SELECT file_content, user_id FROM js_scripts WHERE id IN ({$file_ids})");
			foreach ($code_data as $row) {
				if ( !isset($data[ $row['user_id'] ]['code']) ) {
					$data[ $row['user_id'] ]['code'] = array();
				}
				$data[ $row['user_id'] ]['code'][] = $row['file_content'];
			}
			echo '<pre>';
			print_r($data);
			die('</pre>' . __FILE__ . ', ' . __LINE__);
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
