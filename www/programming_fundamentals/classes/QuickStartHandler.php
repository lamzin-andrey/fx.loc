<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
require_once APP_ROOT . '/classes/CommentTree.php';
class QuickStartHandler extends CBaseHandler{
	public $book_tpl = 'intro';
	public $show_test_new_words_button = false;
	
	public $test_buttons = array();	   //array button_id => button_text
	public $tests = array();		   //button_template
	public $comments_data = array();   //комментарии
	private $_comment_tree;
	public function __construct($app) {
		$this->_app = $app;
		$this->left_inner = 'qs_tasklist.tpl.php';
		$this->right_inner = 'qs_inner.tpl.php';
		$this->css[] = 'qs';
		$this->css[] = 'test_new_words';
		$aUrl = explode('?', $_SERVER['REQUEST_URI']);
		$url = $aUrl[0];
		$a = explode('programming_fundamentals/quick_start', $url);
		if (count($a) > 1) {
			$s = str_replace('/', '', $a[1]);
			if (file_exists(APP_ROOT . '/files/quick_book/' . $s . '.php')) {
				$this->book_tpl = $s;
				$this->js[] = 'test-engine/js/testengine.js'; //движок тестов
				$this->js[] = 'usertest/newwords/testNewWordConfigBase.js';      //Основной конфиг теста на новые слова
				$this->_addNewWordsQuests($s);			   	   //Подключить файлы с вопросами для теста на новые слова
				$this->_addExtendsTest($s);
				$this->js[] = 'usertest/newwords/testNewWord.js';      		   //Окошко для теста на новые слова
				$this->show_test_new_words_button = true;
			}
		}
		$this->_comment_tree = new CommentTree($app);
		if (!is_ajax()) {
			$fields = 'comments.title, comments.body, comments.date_create, comments.date_modify, comments.uid, users.name, users.surname';
			$join = 'JOIN users ON users.id = comments.uid';
			$this->comments_data = $this->_comment_tree->buildTree("part = 'quick_start/{$this->book_tpl}' AND is_accept = 1 AND comments.is_deleted = 0", $fields, $join);
		}
		parent::__construct();
	}
	/**
	 * @desc Подключить файлы с вопросами для теста на новые слова
	*/
	private function _addNewWordsQuests($s) {
		$pages = array('wtf', 'keywords');
		$n = array_search($s, $pages);
		if ($n === false) {
			$n = count($pages) - 1;
		}
		for ($i = 0; $i <= $n; $i++) {
			$this->js[] = 'usertest/newwords/' .$pages[$i]. '.js';
		}
	}
	/**
	 * @desc Помощник для вывода элементов содержания на quick_start
	*/
	static public function part($key, $href = false) {
		$lang = utils_getCurrentLang();
		$display_text_key = $key;
		$end_link = '/';
		if ($href) {
			$end_link = '#' . $href;
			$display_text_key = $href;
		}
		return '<li><a class="" href="'. WEB_ROOT. '/quick_start/'. $key . $end_link . '">'. $lang[$display_text_key] . '</a></li>';
	}
	/**
	 * @desc Подключает тесты в зависимости от url
	*/
	private function _addExtendsTest($url) {
		if ($url == "observer") {
			$this->js[] = 'usertest/patterns/testPatternsConfigBase.js';      	//Основной конфиг теста по паттернам
			$this->js[] = 'usertest/patterns/testPatterns.js';      			//Окно тестов
			$this->test_buttons['patternTestRun'] = 'Тест по паттернам проектирования';
			$this->tests['qs-test-patterns'] = 'qs_test_patterns_view.tpl';
			$this->css[] = 'test_patterns';
		}
	}
	static public function tim($variant, $task, $subtask) {
		return '<img src="'.WEB_ROOT.'/files/tasks/'.$variant.'/'.$task.'.'.$subtask.'.png" />';
	}
	static public function a($href, $text, $blank = true) {
		return '<a href="'.$href . '"'. ($blank ? ' target="_blank" ' : '') .'">'.$text.'</a>';
	}
	static public function aback($keyword) {
		$lang = utils_getCurrentLang();
		return '<a href="'. WEB_ROOT. '/quick_start/'.$keyword.'">Назад - ' . $lang[$keyword]. '</a>';
	}
	static public function anext($keyword) {
		$lang = utils_getCurrentLang();
		return '<a href="'. WEB_ROOT. '/quick_start/'.$keyword.'">Далее - ' . $lang[$keyword]. '</a>';
	}
	/**
	 * @desc Навигация для страниц быстрого старта
	*/
	static public function prevnext($keyprev, $keynext){
		$s = '<div class="btm_navbar">';
		if ($keyprev) {
			$s .= '<div class="left">' . QuickStartHandler::aback($keyprev) . '</div>';
		}
		if ($keynext) {
			$s .= '<div class="right">' . QuickStartHandler::anext($keynext) . '</div>';
		}
		$s .= '<div class="clearfix"></div>
			  </div>';
		return $s;
	}
	public function ajaxAction() {
		$action = req('action');
		switch ($action) {
			case 'addComment':
				$this->_addComment();
				break;
			case 'getComment':
				$this->_getComment();
				break;
		}
		
	}
	
	private function _addComment() {
		$this->_comment_tree->writeData( array('uid' => CApplication::getUid()) );
		json_ok();
	}
	
	private function _getComment() {
		$data = $this->_comment_tree->getRecord(req('id'), 'id');
		if ($data) {
			json_ok_arr($data);
		}
		json_error('msg', $this->_app->lang['Error_record_not_found'] );
	}
	
	
}
