<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
require_once APP_ROOT . '/classes/ResourceList.php';

class ResourceHandler extends CBaseHandler {
	public $file_list;
	public $paging;
	public $delete_action_msg;
	
	public function __construct($app) {
		$this->left_inner = 'resource_tasklist.tpl.php';
		$this->right_inner = 'resource_inner.tpl.php';
		$this->css[] = 'res';
		parent::__construct($app);
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
		$fileInfo = $_FILES['resFile'];
		if ($s = $this->_validFile($fileInfo['name'], $fileInfo['error'], $fileInfo['tmp_name'], $error, $target_file, $is_image)) {
			$this->_saveFile($fileInfo['name'], $target_file, $is_image);
		} else {
			$this->errors[] = $lang[$error];
		}
	}
	/**
	 * @desc ОБновление информации о файле
	 * @param  $filename   - имя файла
	**/
	public function updateFileInfo() {
		$display_file_name = req('resDisplayName');
		db_escape($display_file_name);
		if ((int)req('res_edit_id')) {
			$id = (int)req('res_edit_id');
			$query = "UPDATE resources SET display_file_name  = '{$display_file_name}'
					WHERE id = {$id}
			";
			query($query, $numRows, $affectedRows);
			if ($affectedRows) {
				$this->messages[] = $this->lang['success_update_file'];
			}
		} elseif ((int)req('id') && req('action') == 'delete') {
			$id = (int)req('id');
			$query = "UPDATE resources SET is_deleted  = 1	WHERE id = {$id}";
			query($query, $numRows, $affectedRows);
			if ($affectedRows) {
				$this->messages[] = $this->delete_action_msg = $this->lang['success_delete_file'];
			} else {
				$this->messages[] = $this->delete_action_msg = $this->lang['default_error'];
			}
			$path = dbvalue("SELECT file_path FROM resources WHERE id = {$id}");
			if ($path) {
				$path = APP_ROOT . $path;
				if (file_exists($path)) {
					@unlink($path);
				}
			}
		}
	}
	/**
	 * @desc Загрузка скриптов пользователя, если такие есть
	 * @param  $filename   - имя файла
	**/
	private function _saveFile($src_file_name, $dest_file, $is_image) {
		$uid = CApplication::getUid();
		$datetime = now();
		$display_file_name = req('resDisplayName');
		db_escape($src_file_name);
		db_escape($display_file_name);
		$dest_file = str_replace(APP_ROOT, '', $dest_file);
		$is_image = ($is_image ? 1 : 0);
		$query = "INSERT INTO resources (src_file_name, display_file_name, file_path, user_id, 
											date_create, date_update, is_image) 
							VALUES ('{$src_file_name}', '{$display_file_name}', '{$dest_file}', '{$uid}', '{$datetime}', '{$datetime}', '{$is_image}')";
		if ((int)req('res_edit_id')) {
			$id = (int)req('res_edit_id');
			$query = "UPDATE resources SET src_file_name = '{$src_file_name}', 
						display_file_name  = '{$display_file_name}',
						file_path  = '{$dest_file}',
						is_image  = '{$is_image}',
						date_update = '{$datetime}'
					WHERE id = {$id}
			";
		}
		$id = query($query, $numRows, $affectedRows);
		if ((int)$id) {
			$this->messages[] = $this->lang['success_append_file'];
		} elseif ($affectedRows) {
			$this->messages[] = $this->lang['success_update_file'];
		}
		/*if (!sess('uid')) {
			$this->errors[] = $this->lang['warning_anonim_user'];
		}*/
	}
	public function validFile($filename, $codeError, $tmp_file, &$error_str, &$dest_file, &$is_image) {
		return $this->_validFile($filename, $codeError, $tmp_file, $error_str, $dest_file, $is_image);
	}
	/**
	 * @desc Загрузка скриптов пользователя, если такие есть
	 * @param  $filename   - имя файла
	 * @param  $codeError  - код ошибки из _FILES
	 * @param  $tmp_file   - путь к временному апач - файлу
	 * @param  &$err_str   - ключ элемента массива локализации, сообщение об ошибке
	 * @param  &$dest_file - путь ко временному файлу
	 * @param  &$is_image - 
	**/
	private function _validFile($filename, $codeError, $tmp_file, &$error_str, &$dest_file, &$is_image) {
		$error_str = 'test';
		if ($codeError != 0) {
			$error_str = 'error_upload_file';
			if ($codeError == 2) {
				$error_str = 'file_too_big';
			}
			return false;
		}
		if (filesize($tmp_file) > 5 * 1024 * 1024) {
			$error_str = 'file_too_big';
			return false;
		}
		$target = utils_getFilePath(APP_ROOT . '/files', $tmp_file, $filename, $is_image);
		if (!$target) {
			$error_str = 'invalid_file_resource';
			return false;
		}
		if (!move_uploaded_file($tmp_file, $target)) {
			copy($tmp_file, $target);
		}
		$dest_file = $target;
		return true;
	}
	/**
	 * @desc Загрузка скриптов пользователя, если такие есть
	**/
	public function loadUserResources() {
		$resList = new ResourceList($this->_app);
		$uid = CApplication::getUid();
		$page = (int)req('page', 'GET');
		$page = ($page ? $page : 1);
		
		$filter = '';
		if ($name = req('searchFileName', 'GET')) {
			$filter = "AND ( display_file_name LIKE ('%{$name}%') OR src_file_name LIKE ('%{$name}%') )";
		}
		
		$this->file_list = $resList->getRawList("user_id = {$uid} {$filter}", '*', '', $page);
		$this->paging = $resList->paging;
		return;
		
		//old code 
		$uid = CApplication::getUid();
		$lang = $this->lang;
		$query = "SELECT id, src_file_name, display_file_name, file_path, is_image FROM resources WHERE user_id = {$uid} AND is_deleted != 1 ORDER BY delta";
		//die($query);
		
		$this->file_list = query($query);
		/*echo '<pre>';
		print_r($this->file_list);
		echo '</pre>';die;/**/
	}
}
