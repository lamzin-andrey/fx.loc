<?php
require_once APP_ROOT . '/classes/CBaseHandler.php';
class LoginHandler extends CBaseHandler {
	
	public function __construct() {
		switch (@$_REQUEST["action"]) {
			case "login":
				$this->_login();
				break;
			case "logout":
				$this->_logout();
				break;
			case "signup":
				$this->_signup();
				break;
			default:
				if (!@$_SESSION["uid"]) {
					utils_302(WEB_ROOT . '/');
				}
		}
	}
	
	private function _logout(){
		$_SESSION = array();
		utils_302(WEB_ROOT . '/');
	}
	
	private function _login() {
		$email = @$_POST['email'];
		$password = $this->_getHash(@$_POST["password"]);
		$sql_query = "SELECT u.id FROM users AS u
						WHERE u.email = '$email' AND u.pwd = '$password'";
		$data = query($sql_query, $nR);
		$id = 0;
		if ($nR) {
			$row = $data[0];
			$id = $row['id'];
		}
		if ($id) {
			$_SESSION["authorize"] = true;
			$_SESSION["uid"] = $id;
			$_SESSION["email"] = $email;
			print json_encode(array("success"=>'1'));
		} else {
			print json_encode(array("success"=>'0'));
		}
		exit;
	}
	/**
	 * @desc Регистрация пользователя
	**/
	private function _signup() {
		$lang = utils_getCurrentLang();
		$email = req('email');
		$pwd   = req('password');
		$pwd_c = req('pc');
		$name  = req('name');
		$sname = req('sname');
		if (!trim($email)) {
			json_error('sError', $lang['email_required']);
		}
		if (!checkMail($email)) {
			json_error('sError', $lang['email_is_not_valid']);
		}
		//die("SELECT id FROM users WHERE email = '{$email}'");
		$exists = dbvalue("SELECT id FROM users WHERE email = '{$email}'");
		if ($exists) {
			json_error('sError', $lang['email_already_exists']);
		}
		if (!trim($pwd)) {
			json_error('sError', $lang['password_required']);
		}
		if ($pwd != $pwd_c) {
			json_error('sError', $lang['password_different']);
		}
		$pwd = $this->_getHash($pwd);
		$name = str_replace("'", '&quot;', trim($name));
		$surname = str_replace("'", '&quot;', trim($sname));
		$email = str_replace("'", '&quot;', trim($email));
		$uid = CApplication::getUid();
		$sql_query = "UPDATE users SET name = '{$name}', surname = '{$surname}', email = '{$email}', pwd = '{$pwd}' WHERE id = {$uid}";
		//die($sql_query);
		query($sql_query, $nR, $aR);
		if ($aR) {
			json_ok('sError', $lang['reg_complete']);
		} else{
			json_error('sError', $lang['default_error']);
		}
	}
	/*
	 * 
	*/
	private function _getHash($s) {
		return md5(str_replace("'", '&quot;', trim($s)));
	}
}
