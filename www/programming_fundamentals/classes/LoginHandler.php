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
			default:
				if (!@$_SESSION["uid"]) {
					utils_302(WEB_ROOT . '/');
				}
		}
		/*$phone =  Shared::preparePhone(@$_SESSION['phone']);
		if (strlen($phone) < 5) {
			$this->stopSql = true;
		} else {
			$this->filter = " WHERE phone = '$phone' AND m.is_deleted != 1 ";
		}
		$this->exec();*/
	}
	
	private function _logout(){
		$_SESSION = array();
		utils_302(WEB_ROOT . '/');
	}
	
	private function _login() {
		$email = @$_POST['email'];
		$password = md5(str_replace("'", '&quot;', trim(@$_POST["password"])));
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
}
