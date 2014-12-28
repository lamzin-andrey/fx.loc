<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class EditorHandler extends CBaseHandler{
	public function __construct() {
		$this->left_inner = 'ed_tasklist.tpl.php';
		$this->right_inner = 'ed_inner.tpl.php';
		$this->css[] = 'ed';
		parent::__construct();
	}
	public function ajaxAction() {
		$lang = utils_getCurrentLang();
		$a = req('action', 'POST');
		switch ($a) {
			case 'saveFile':
				$id = (int)req('id', 'POST');
				if ($id) {
					//TODO проверить, не сменилось ли имя и на клиенте тоже
					$dval = $val = req('val', 'POST');
					db_escape($dval);
					$dval = str_replace('cookie', 'сооkie', $dval);
					$file_sum = md5($dval);
					query("UPDATE js_scripts SET file_content = '{$dval}', file_ctrl_sum = '{$file_sum}' WHERE id = {$id} AND is_deleted != 1", $nr, $ar);
					if ($ar) {
						//проверяю, есть ли проекты, включающие этот файл
						$heads = query("SELECT p.head FROM projects AS p WHERE file_id = {$id}", $num);
						//если есть - пересчитываю для них сумму
						if ($num) {
							foreach ($heads as $rec) {
								$files = query("SELECT s.file_ctrl_sum FROM projects AS p JOIN js_scripts AS s ON s.id = p.file_id WHERE head = {$rec['head']}");
								$a_sum = array();
								foreach ($files as $file) {
									$a_sum[] = $file['file_ctrl_sum'];
								}
								$project_sum = md5(join('', $a_sum));
								query("UPDATE js_scripts SET project_ctrl_sum = '{$project_sum}' WHERE id = {$rec['head']}");
							}
						}
						json_ok('text', $val);
					} else {
						json_error('msg', $lang['fail_save_file_enter_it_name'], 'requiredFilename', 1);
					}
				} else {
					json_error('msg', $lang['fail_save_file_try_again']);
				}
				break;
			case 'saveFileAs':
				$uid = CApplication::getUid();
				$d_src_file_name = $src_file_name = req('fileName', 'POST');
				$d_display_file_name = $display_file_name = req('display', 'POST');
				$d_file_content = $file_content = req('content', 'POST');
				db_escape($d_src_file_name);
				db_escape($d_display_file_name);
				$ex_id = dbvalue("SELECT id FROM js_scripts WHERE src_file_name = '{$d_src_file_name}' AND user_id = {$uid} AND is_deleted != 1");
				if ($ex_id) {
					json_error('msg', $lang['programm_with_name_exists']);
				}
				db_escape($d_file_content);
				$d_file_content = str_replace('cookie', 'сооkie', $d_file_content);
				$ip = a($_SERVER, 'REMOTE_ADDR');
				$tstamp = date('Y-m-d H:i:s');
				$hash = md5("{$src_file_name}{$ip}{$tstamp}");
				$target = APP_ROOT . "/files/{$hash}.tmp";
				file_put_contents($target, $file_content);
				$filemd5 = md5($d_file_content);
				//@unlink($target);
				include_once dirname(__FILE__) . '/ConsoleHandler.php';
				$ch = new ConsoleHandler();
				if ($ch->validFile($src_file_name, 0, $target, $err_str, $output, $dbg_info)) {
					$query = "INSERT INTO js_scripts (src_file_name, display_file_name, file_content, user_id, 
											date_create, date_update, file_ctrl_sum) 
							VALUES ('{$d_src_file_name}', '{$d_display_file_name}', '{$d_file_content}', '{$uid}',
									'{$tstamp}', '{$tstamp}', '{$filemd5}')";
					$id = query($query, $numRows, $affectedRows);
					$message = '';
					$warning = '';
					if ((int)$id) {
						$message = $this->lang['success_append_file'];
					} elseif ($affectedRows) {
						$message = $this->lang['success_update_file'];
					}
					if (!sess('uid')) {
						$warning = $this->lang['warning_anonim_user'];
					}
					json_ok('id', $id, 'message', $message, 'warning', $warning, 'display', $display_file_name);
				} else {
					json_error('msg', $lang['fail_save_user_script_try_update']);
				}
				break;
			case 'loadUserFiles':
				$uid = CApplication::getUid();
				if (!$uid) {
					json_error('msg', $lang['unable_load_file_list_try_later']);
				} else {
					$data = query("SELECT * FROM js_scripts WHERE user_id = {$uid} AND is_deleted != 1 ORDER BY date_create DESC", $nR);
					if ($nR) {
						json_ok('list', $data);
					} else {
						json_ok();
					}
				}
				break;
			case 'renameFile':
				$uid = CApplication::getUid();
				$id = (int)req('id', 'POST');
				$val = $display_file_name = req('displayText', 'POST');
				if ($id && $display_file_name) {
					db_escape($val);
					query("UPDATE js_scripts SET display_file_name = '{$val}' WHERE user_id = {$uid} AND id = {$id}", $nR, $aR);
					if ($aR) {
						json_ok('id', $id, 'text', $display_file_name);
					} else {
						json_error('msg', $lang['alien_file_or_other_ipdate_page']);
					}
				}
				json_error('msg', $lang['alien_file_or_other_ipdate_page']);
				break;
			case 'removeFile':
				$uid = CApplication::getUid();
				$id = (int)req('id', 'POST');
				if ($id) {
					db_escape($val);
					query("UPDATE js_scripts SET is_deleted = 1 WHERE user_id = {$uid} AND id = {$id}", $nR, $aR);
					if ($aR) {
						json_ok('id', $id);
					} else {
						json_error('msg', $lang['remove_alien_file_or_other_update_page']);
					}
				}
				json_error('msg', $lang['remove_alien_file_or_other_update_page']);
				break;
			case 'loadFileContent':
				$uid = CApplication::getUid();
				$id = (int)req('id', 'POST');
				$data = dbrow("SELECT id, display_file_name, file_content FROM js_scripts WHERE id = {$id} AND user_id = {$uid} AND is_deleted != 1", $nR);
				if ($nR) {
					json_ok('row', $data);
				} else {
					json_error('msg', $lang['load_file_fail']);
				}
				break;
			case 'loadAssignedFiles':
				$uid = CApplication::getUid();
				$id = (int)req('id', 'POST');
				$all = query("SELECT id, display_file_name FROM js_scripts WHERE user_id = {$uid} AND is_deleted = 0 ORDER BY (id = {$id}) DESC", $num);
				if ($num) {
					$data = query("SELECT p.file_id, js.display_file_name FROM projects AS p
									JOIN js_scripts AS js ON js.id = p.file_id
									WHERE head = {$id} AND js.is_deleted = 0");
					json_ok('all', $all, 'sets', $data, 'id', $id);
				}
				json_error('msg', $lang['load_file_fail']);
				break;
			case 'fromAll2sets':
				$uid = CApplication::getUid();
				$head = (int)req('head', 'POST');
				$id = (int)req('ex', 'POST');
				if ($head && $id) {
					$ctrl_query = "SELECT COUNT(id) FROM js_scripts WHERE user_id = {$uid} AND id IN ({$id}, {$head}) AND is_deleted = 0";
					$num = dbvalue($ctrl_query);
					if ($num) {
						$sql_query = "INSERT INTO projects (head, file_id) VALUES ({$head}, {$id}) ON DUPLICATE KEY UPDATE head = {$head}";
						query($sql_query, $num, $updated);
						if (!$num && !$updated) {
							json_error('msg', $lang['default_error']);
						}
						$this->_recalculateProjectCSum($head);
						json_ok('act', $a);
					}
				}
				json_error('msg', $lang['default_error']);
				break;
			case 'fromSets2all':
				$uid = CApplication::getUid();
				$head = (int)req('head', 'POST');
				$id = (int)req('ex', 'POST');
				if ($head && $id) {
					$ctrl_query = "SELECT COUNT(id) FROM js_scripts WHERE user_id = {$uid} AND id IN ({$id}, {$head}) AND is_deleted = 0";
					$num = dbvalue($ctrl_query);
					if ($num) {
						$sql_query = "DELETE FROM projects WHERE head = {$head} AND file_id = {$id}";
						query($sql_query, $num, $updated);
						$this->_recalculateProjectCSum($head);
						json_ok('act', $a);
					}
				}
				json_error('msg', $lang['default_error']);
				break;
			case 'getCsumAndFlieContents':
				$head = req('id');
				if ($head == -1) {
					json_ok('nothing', 1);
				}
				if ($head) {
					$this->_access($head);
					$sql_query = "SELECT project_ctrl_sum FROM js_scripts WHERE id = {$head}";
					$sum = dbvalue($sql_query);
					
					$sql_query = "
					SELECT s.id, s.file_content FROM projects AS p
					JOIN js_scripts AS s ON s.id = p.file_id 
					WHERE head = {$head}";
					$data = query($sql_query);
					json_ok('sum', $sum, 'rows', $data);
				}
				json_error('msg', $lang['default_error'], 'nothing', 1);
				break;
			case 'getCsum':
				$head = req('id');
				if ($head == -1) {
					json_ok('nothing', 1);
				}
				if ($head) {
					$this->_access($head);
					$sql_query = "SELECT project_ctrl_sum FROM js_scripts WHERE id = {$head}";
					$sum = dbvalue($sql_query);
					json_ok('sum', $sum);
				}
				json_error('msg', $lang['default_error'], 'nothing', 1);
				break;
		}
	}
	/**
	 * @desc Подсчитывает и обновляет в таблице контрольную сумму проекта
	 * @param  номер файла, определяющего проект
	*/
	private function _recalculateProjectCSum($head) {
		$sql_query = "
		SELECT s.file_ctrl_sum FROM projects AS p 
		JOIN js_scripts AS s ON s.id = p.file_id
		WHERE head = {$head} ORDER BY s.id";
		$data = query($sql_query, $num);
		if ($num) {
			$ar = array();
			foreach ($data as $row) {
				$ar[] = $row['file_ctrl_sum'];
			}
			$sum = md5( join('', $ar) );
			query("UPDATE js_scripts SET project_ctrl_sum = '{$sum}' WHERE id = '{$head}'");
		}
	}
	/**
	 * @desc Прерывает выполнение если файл чужой
	 * @param $file_id 
	*/
	private function _access($file_id) {
		$file_id = (int)$file_id;
		$uid = CApplication::getUid();
		$id = dbvalue("SELECT id FROM js_scripts WHERE id = {$file_id} AND user_id = {$uid}");
		if (!$id) {
			json_error('msg', $lang['default_error']);
		}
	}
}
