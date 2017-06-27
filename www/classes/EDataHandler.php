<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class EDataHandler extends CBaseHandler{
	public $first_message = 'Теперь можно нажать на сохранение...';
	public $datetime;
	public $info;
	public function __construct($app) {
		$this->left_inner = '';
		$this->right_inner = '';
		$this->css[] = 'edata';
		$this->first_message = 'Теперь можно нажать на сохранение...';
		$this->datetime = now();
		parent::__construct($app);
		$this->_postAction();
	}
	private function _postAction() {
		if (count($_POST)) {
			$log =  req('log');
			db_escape($log);
			$data =  req('data');
			file_put_contents(dirname(__FILE__) . '/out.js', $data);
			db_escape($data);
			file_put_contents(dirname(__FILE__) . '/outesc.js', $data);
			
			$catid =  ireq('catid');
			$furl =  req('furl');
			$sql = "INSERT INTO datas (url, catalog_id, datas, log) VALUES
			('{$furl}', {$catid}, '{$data}', '{$log}')
			";
			$rowId = query($sql);
			if ($rowId) {
				$this->first_message = 'СпасЫбо!';
			}
		}
	}
	public function getLastSave() {
		$sql = "SELECT * FROM datas ORDER BY id DESC LIMIT 1";
		$this->info = dbrow($sql, $nR);
		if (!$nR) {
			$this->info = false;
		}
	}
}
