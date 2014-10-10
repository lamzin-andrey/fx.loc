<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class MainPageHandler extends CBaseHandler{
	public $file_list;
	public function __construct() {
		$this->left_inner = 'main_tasklist.tpl.php';
		$this->right_inner = 'main_promo.tpl.php';
		$this->css[] = 'promo';
		parent::__construct();
	}
}
