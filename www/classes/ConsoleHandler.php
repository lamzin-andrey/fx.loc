<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class ConsoleHandler extends CBaseHandler{
	public $file_list;
	public function __construct() {
		$this->left_inner = 'console_tasklist_inner.tpl.php';
		$this->right_inner = 'console_console.tpl.php';
		parent::__construct();
	}
	/**
	 * @desc Обработка возможных действий на странице
	**/
	public function processUploadFile() {
		$uid = CApplication::getUid();
		$lang = $this->lang;
		if (!$uid) {
			$this->errors[] = $lang['unauth_and_cookie_trouble'];
			return;
		}
		$fileInfo = $_FILES['scriptFile'];
		if ($s = $this->_validFile($fileInfo['name'], $fileInfo['error'], $fileInfo['tmp_name'], $error, $target_file, $dbg_error)) {
			$this->_saveFile($fileInfo['name'], $target_file);
		} else {
			//print_r($lang);
			//die($error);
			$this->errors[] = $lang[$error];
		}
	}
	/**
	 * @desc Загрузка скриптов пользователя, если такие есть
	 * @param  $filename   - имя файла
	**/
	private function _saveFile($src_file_name, $tmp_file) {
		$uid = CApplication::getUid();
		$s = file_get_contents($tmp_file);
		$datetime = now();
		$display_file_name = req('scriptDisplayName');
		db_escape($src_file_name);
		db_escape($display_file_name);
		db_escape($s);
		$s = str_replace('cookie', 'сооkie', $s);
		$filemd5 = md5($s);
		$query = "INSERT INTO js_scripts (src_file_name, display_file_name, file_content, user_id, 
											date_create, date_update, file_ctrl_sum) 
							VALUES ('{$src_file_name}', '{$display_file_name}', '{$s}', '{$uid}', '{$datetime}', '{$datetime}', '{$filemd5}')";
		if ((int)req('edit_id')) {
			$id = (int)req('edit_id');
			$query = "UPDATE js_scripts SET src_file_name = '{$src_file_name}', 
						display_file_name  = '{$display_file_name}',
						file_content  = '{$s}',
						date_update = '{$datetime}',
						file_ctrl_sum = '{$filemd5}'
					WHERE id = {$id}
			";
		}
		$id = query($query, $numRows, $affectedRows);
		if ((int)$id) {
			$this->messages[] = $this->lang['success_append_file'];
		} elseif ($affectedRows) {
			$this->messages[] = $this->lang['success_update_file'];
		}
		if (!sess('uid')) {
			$this->errors[] = $this->lang['warning_anonim_user'];
		}
	}
	public function validFile($filename, $codeError, $tmp_file, &$error_str, &$dest_file, &$dbg_err_str = '') {
		return $this->_validFile($filename, $codeError, $tmp_file, $error_str, $dest_file, $dbg_err_str);
	}
	/**
	 * @desc Загрузка скриптов пользователя, если такие есть
	 * @param  $filename   - имя файла
	 * @param  $codeError  - код ошибки из _FILES
	 * @param  $tmp_file   - путь к временному апач - файлу
	 * @param  &$err_str   - ключ элемента массива локализации, сообщение об ошибке
	 * @param  &$dest_file - путь ко временному файлу
	 * @param  &$dbg_err_str - отладочная строка для различных сообщений
	**/
	private function _validFile($filename, $codeError, $tmp_file, &$error_str, &$dest_file, &$dbg_err_str = '') {
		$error_str = 'test';
		if ($codeError != 0) {
			$error_str = 'error_upload_file';
			if ($codeError == 2) {
				$error_str = 'file_too_big';
			}
			return false;
		}
		$ip = a($_SERVER, 'REMOTE_ADDR');
		$tstamp = date('YmdHis');
		$hash = md5("{$filename}{$ip}{$tstamp}");
		$target = APP_ROOT . "/files/{$hash}.tmp";
		//print "tf = {$tmp_file}\n";
		//print "tf = {$target}\n";
		if (!move_uploaded_file($tmp_file, $target)) {
			copy($tmp_file, $target);
		}
		///print file_get_contents($target);
		//die("LINE = " . __LINE__ . ", FILE = " . __FILE__);
		/*if (req('scriptDisplayName')) {
			$uid = CApplication::getUid();
			db_escape($display_file_name);
			db_escape($filename);
			$v = dbvalue("SELECT count(id) FROM js_scripts WHERE uid = {$uid} AND display_file_name = '{$display_file_name}' AND src_file_name = '{$file_name}'");
			if ($v) {
				$error_str = 'file_too_big';
				return false;
			}
		}*/
		
		$dest_file = $target;
		$h = fopen($target, 'r');
		$q_is_open = false;
		$dq_is_open = false;
		$dc_is_open = false;
		$c_is_open = false;
		$in_ignore_block = false;
		$count_quotes = 0;
		$main_function_definition_found = false;
		$count_open_blocks = 0;
		$enter_in_block = false;
		$count_functions = 0;
		$dbg_err_str = '';
		while (!feof($h)) {
			$s = fgets($h);
			if ($in_ignore_block && $c_is_open) {
				$c_is_open = $in_ignore_block = false;//TODO проверить, содержит ли полученная fgets строка символ перевода каретки
			}
			$q = '';
			for ($i = 0; $i < strlen($s); $i++) {
				$ch = $s[$i];
				if (!$in_ignore_block) { //проверить, не начался ли с текущего символа блок игнора
					if ($ch == '"') {
							$dq_is_open = $in_ignore_block = true;
					} else if ($ch == "'") {
						$q_is_open = $in_ignore_block = true;
					} else if ($ch == '/') {
						if (a($s, $i + 1) == '/') {
							$c_is_open = $in_ignore_block = true;
						} else if (a($s, $i + 1) == '*') {
							$dc_is_open = $in_ignore_block = true;
						}
					}
					if ($in_ignore_block) {
						continue;
					}
				}
				if ($in_ignore_block) {  //проверить, не закончился ли с текущим символом блок игнора
					if ($q_is_open && $ch == "'") {
						$q_is_open = $in_ignore_block = false;
					} else if ($dq_is_open && $ch == '"') {
						$dq_is_open = $in_ignore_block = false;
					} else if ($c_is_open && $ch == "\n") {
						$c_is_open = $in_ignore_block = false;
					} else if ($dc_is_open && $ch == '/') {
						if (a($s, $i - 1) == '*') {
							$dc_is_open = $in_ignore_block = false;
						}
					}
					if (!$in_ignore_block) {
						continue;
					}
				}
				if (!$in_ignore_block) { //проверяем на валидность
					$q .= $ch;
					if ($ch == '{') {
						$count_open_blocks++;
					}
					if ($ch == '}') {
						$count_open_blocks--;
					}
				}
			}
			if ($count_open_blocks) {
				$enter_in_block = true;
			}
			if ($enter_in_block && $count_open_blocks == 0) {
				$count_functions++;
				$enter_in_block = false;
			}
			if ($count_functions > 1) {
				$dbg_err_str = 'too_many_functions';
				break;
			}
			$pattern = "#\s*function\s+([a-zA-Z0-9_]+)\s*\(\s*\)\s*\{#";
			if (!$main_function_definition_found && preg_match($pattern, $q, $m)) {
				$function_name = $m[1];
				if (str_replace('.js', '', $filename) == $function_name && $count_open_blocks == 1) {
					$main_function_definition_found = true;
				}
			}
		}
		fclose($h);
		//die("count_functions = $count_functions");
		if ($main_function_definition_found && $count_open_blocks == 0) {
			return true;
		} else {
			$error_str = 'invalid_file_format';
			return false;
		}
	}
	/**
	 * @desc Загрузка скриптов пользователя, если такие есть
	**/
	public function loadUsersScripts() {
		$uid = CApplication::getUid();
		$lang = $this->lang;
		$query = "SELECT id, src_file_name, display_file_name FROM js_scripts WHERE user_id = {$uid} AND is_deleted != 1 ORDER BY delta";
		$fl = $this->file_list = query($query);
		return $fl; 
	}
}
