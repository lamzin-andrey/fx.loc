<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class HelpfulHandler extends CBaseHandler{
	public $file_list;
	public function __construct() {
		$this->left_inner = 'hful_tasklist.tpl.php';
		$this->right_inner = 'hful_promo.tpl.php';
		$this->css[] = 'promo';
		parent::__construct();
	}
}
