<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class JIHandler extends CBaseHandler{
	public function __construct($app) {
		$this->left_inner = '';
		$this->right_inner = 'jin/simple.tpl.php';
		$this->css[] = 'jin/simple';
		$this->css[] = 'jin/demo_observer';
		
		$this->js[] = 'jin/extendsupport.js';
		$this->js[] = 'jin/observer/Observer.js';
		$this->js[] = 'jin/variables.js';//subject
		$this->js[] = 'jin/codeview.js';//observer
		$this->js[] = 'jin/jsview.js';//observer
		$this->js[] = 'jin/cppview.js';//observer
		$this->js[] = 'jin/stackview.js';//observer
		$this->js[] = 'jin/jin.js';
		
		parent::__construct($app);
		$this->_postAction();
	}
	private function _postAction() {
		if (count($_POST)) {
			//
		}
	}
}
