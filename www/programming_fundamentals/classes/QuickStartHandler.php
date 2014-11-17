<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class QuickStartHandler extends CBaseHandler{
	public $book_tpl = 'intro';
	public $show_test_new_words_button = false;
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
				$this->js[] = 'test-engine/js/testengine.js'; //движок тестов
				$this->js[] = 'usertest/newwords/testNewWordConfigBase.js';      //Основной конфиг теста на новые слова
				$this->_addNewWordsQuests($s);			   	   //Подключить файлы с вопросами для теста на новые слова
				$this->js[] = 'usertest/newwords/testNewWord.js';      		   //Окошко для теста на новые слова
				$this->show_test_new_words_button = true;
			}
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
}
